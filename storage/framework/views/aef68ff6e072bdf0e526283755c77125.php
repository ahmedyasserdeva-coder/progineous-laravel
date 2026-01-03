

<?php $__env->startSection('title', __('tickets.departments')); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-sm text-gray-500 mb-1">
                <a href="<?php echo e(route('admin.tickets.index')); ?>" class="hover:text-blue-600"><?php echo e(__('tickets.tickets')); ?></a>
                <span>/</span>
                <span><?php echo e(__('tickets.departments')); ?></span>
            </div>
            <h1 class="text-2xl font-bold text-gray-900"><?php echo e(__('tickets.departments')); ?></h1>
        </div>
        <button type="button" onclick="openModal('createModal')"
                class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
            <svg class="w-5 h-5 <?php echo e(app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2'); ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
            <?php echo e(app()->getLocale() == 'ar' ? 'إضافة قسم' : 'Add Department'); ?>

        </button>
    </div>

    <!-- Success/Error Messages -->
    <?php if(session('success')): ?>
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
            <?php echo e(session('error')); ?>

        </div>
    <?php endif; ?>

    <!-- Departments List -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <?php if($departments->count() > 0): ?>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?> text-xs font-medium text-gray-500 uppercase">
                                <?php echo e(app()->getLocale() == 'ar' ? 'الترتيب' : 'Order'); ?>

                            </th>
                            <th class="px-6 py-3 text-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?> text-xs font-medium text-gray-500 uppercase">
                                <?php echo e(app()->getLocale() == 'ar' ? 'الاسم (إنجليزي)' : 'Name (English)'); ?>

                            </th>
                            <th class="px-6 py-3 text-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?> text-xs font-medium text-gray-500 uppercase">
                                <?php echo e(app()->getLocale() == 'ar' ? 'الاسم (عربي)' : 'Name (Arabic)'); ?>

                            </th>
                            <th class="px-6 py-3 text-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?> text-xs font-medium text-gray-500 uppercase">
                                <?php echo e(app()->getLocale() == 'ar' ? 'البريد الإلكتروني' : 'Email'); ?>

                            </th>
                            <th class="px-6 py-3 text-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?> text-xs font-medium text-gray-500 uppercase">
                                <?php echo e(app()->getLocale() == 'ar' ? 'عدد التذاكر' : 'Tickets Count'); ?>

                            </th>
                            <th class="px-6 py-3 text-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?> text-xs font-medium text-gray-500 uppercase">
                                <?php echo e(__('tickets.status')); ?>

                            </th>
                            <th class="px-6 py-3 text-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?> text-xs font-medium text-gray-500 uppercase">
                                <?php echo e(__('tickets.actions')); ?>

                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $department): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <?php echo e($department->sort_order); ?>

                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="font-medium text-gray-900"><?php echo e($department->name_en); ?></span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-gray-900"><?php echo e($department->name_ar); ?></span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <?php echo e($department->email ?? '-'); ?>

                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm text-gray-600"><?php echo e($department->tickets_count ?? 0); ?></span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <?php if($department->is_active): ?>
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                            <?php echo e(app()->getLocale() == 'ar' ? 'مفعل' : 'Active'); ?>

                                        </span>
                                    <?php else: ?>
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                            <?php echo e(app()->getLocale() == 'ar' ? 'معطل' : 'Inactive'); ?>

                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-2">
                                        <button type="button" onclick="editDepartment(<?php echo e(json_encode($department)); ?>)"
                                                class="text-blue-600 hover:text-blue-800">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </button>
                                        <button type="button" onclick="confirmDelete(<?php echo e($department->id); ?>, '<?php echo e($department->name_en); ?>')"
                                                class="text-red-600 hover:text-red-800">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="p-12 text-center">
                <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5"/>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-2"><?php echo e(app()->getLocale() == 'ar' ? 'لا توجد أقسام' : 'No departments yet'); ?></h3>
                <p class="text-gray-500 mb-4"><?php echo e(app()->getLocale() == 'ar' ? 'قم بإضافة أقسام للدعم الفني' : 'Add support departments to get started'); ?></p>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Create Modal -->
<div id="createModal" class="hidden fixed inset-0 z-50 overflow-y-auto">
    <div class="flex min-h-screen items-center justify-center p-4">
        <div class="fixed inset-0 bg-black/50" onclick="closeModal('createModal')"></div>
        <div class="relative bg-white rounded-xl shadow-xl max-w-lg w-full max-h-[90vh] overflow-y-auto">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-gray-900"><?php echo e(app()->getLocale() == 'ar' ? 'إضافة قسم جديد' : 'Add New Department'); ?></h3>
        </div>
        <form action="<?php echo e(route('admin.tickets.departments.store')); ?>" method="POST" class="p-6 space-y-4">
            <?php echo csrf_field(); ?>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1"><?php echo e(app()->getLocale() == 'ar' ? 'الاسم (إنجليزي)' : 'Name (English)'); ?> *</label>
                <input type="text" name="name_en" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1"><?php echo e(app()->getLocale() == 'ar' ? 'الاسم (عربي)' : 'Name (Arabic)'); ?> *</label>
                <input type="text" name="name_ar" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1"><?php echo e(app()->getLocale() == 'ar' ? 'الوصف (إنجليزي)' : 'Description (English)'); ?></label>
                <textarea name="description_en" rows="2"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1"><?php echo e(app()->getLocale() == 'ar' ? 'الوصف (عربي)' : 'Description (Arabic)'); ?></label>
                <textarea name="description_ar" rows="2"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1"><?php echo e(app()->getLocale() == 'ar' ? 'البريد الإلكتروني' : 'Email'); ?></label>
                <input type="email" name="email"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1"><?php echo e(app()->getLocale() == 'ar' ? 'الترتيب' : 'Sort Order'); ?></label>
                <input type="number" name="sort_order" value="0"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div class="flex items-center">
                <input type="checkbox" name="is_active" id="create_is_active" value="1" checked
                       class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                <label for="create_is_active" class="ms-2 text-sm text-gray-700">
                    <?php echo e(app()->getLocale() == 'ar' ? 'مفعل' : 'Active'); ?>

                </label>
            </div>
            <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                <button type="button" onclick="closeModal('createModal')"
                        class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">
                    <?php echo e(__('tickets.cancel')); ?>

                </button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    <?php echo e(app()->getLocale() == 'ar' ? 'إضافة' : 'Add'); ?>

                </button>
            </div>
        </form>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div id="editModal" class="hidden fixed inset-0 z-50 overflow-y-auto">
    <div class="flex min-h-screen items-center justify-center p-4">
        <div class="fixed inset-0 bg-black/50" onclick="closeModal('editModal')"></div>
        <div class="relative bg-white rounded-xl shadow-xl max-w-lg w-full max-h-[90vh] overflow-y-auto">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-gray-900"><?php echo e(app()->getLocale() == 'ar' ? 'تعديل القسم' : 'Edit Department'); ?></h3>
        </div>
        <form id="editForm" method="POST" class="p-6 space-y-4">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1"><?php echo e(app()->getLocale() == 'ar' ? 'الاسم (إنجليزي)' : 'Name (English)'); ?> *</label>
                <input type="text" name="name_en" id="edit_name_en" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1"><?php echo e(app()->getLocale() == 'ar' ? 'الاسم (عربي)' : 'Name (Arabic)'); ?> *</label>
                <input type="text" name="name_ar" id="edit_name_ar" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1"><?php echo e(app()->getLocale() == 'ar' ? 'الوصف (إنجليزي)' : 'Description (English)'); ?></label>
                <textarea name="description_en" id="edit_description_en" rows="2"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1"><?php echo e(app()->getLocale() == 'ar' ? 'الوصف (عربي)' : 'Description (Arabic)'); ?></label>
                <textarea name="description_ar" id="edit_description_ar" rows="2"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1"><?php echo e(app()->getLocale() == 'ar' ? 'البريد الإلكتروني' : 'Email'); ?></label>
                <input type="email" name="email" id="edit_email"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1"><?php echo e(app()->getLocale() == 'ar' ? 'الترتيب' : 'Sort Order'); ?></label>
                <input type="number" name="sort_order" id="edit_sort_order"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div class="flex items-center">
                <input type="checkbox" name="is_active" id="edit_is_active" value="1"
                       class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                <label for="edit_is_active" class="ms-2 text-sm text-gray-700">
                    <?php echo e(app()->getLocale() == 'ar' ? 'مفعل' : 'Active'); ?>

                </label>
            </div>
            <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                <button type="button" onclick="closeModal('editModal')"
                        class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">
                    <?php echo e(__('tickets.cancel')); ?>

                </button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    <?php echo e(app()->getLocale() == 'ar' ? 'حفظ التغييرات' : 'Save Changes'); ?>

                </button>
            </div>
        </form>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div id="deleteModal" class="hidden fixed inset-0 z-50 overflow-y-auto">
    <div class="flex min-h-screen items-center justify-center p-4">
        <div class="fixed inset-0 bg-black/50" onclick="closeModal('deleteModal')"></div>
        <div class="relative bg-white rounded-xl shadow-xl max-w-md w-full p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4"><?php echo e(app()->getLocale() == 'ar' ? 'حذف القسم' : 'Delete Department'); ?></h3>
            <p class="text-gray-600 mb-2"><?php echo e(app()->getLocale() == 'ar' ? 'هل أنت متأكد من حذف القسم:' : 'Are you sure you want to delete department:'); ?></p>
            <p class="text-gray-900 font-semibold mb-6" id="deleteDepartmentName"></p>
            <div class="flex justify-end gap-3">
                <button type="button" onclick="closeModal('deleteModal')"
                        class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">
                    <?php echo e(__('tickets.cancel')); ?>

                </button>
                <form id="deleteForm" method="POST" class="inline">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                        <?php echo e(__('tickets.delete')); ?>

                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
    function openModal(modalId) {
        document.getElementById(modalId).classList.remove('hidden');
    }

    function closeModal(modalId) {
        document.getElementById(modalId).classList.add('hidden');
    }

    function editDepartment(department) {
        document.getElementById('editForm').action = '<?php echo e(route("admin.tickets.departments")); ?>/' + department.id;
        document.getElementById('edit_name_en').value = department.name_en;
        document.getElementById('edit_name_ar').value = department.name_ar;
        document.getElementById('edit_description_en').value = department.description_en || '';
        document.getElementById('edit_description_ar').value = department.description_ar || '';
        document.getElementById('edit_email').value = department.email || '';
        document.getElementById('edit_sort_order').value = department.sort_order;
        document.getElementById('edit_is_active').checked = department.is_active;
        openModal('editModal');
    }

    function confirmDelete(id, name) {
        document.getElementById('deleteForm').action = '<?php echo e(route("admin.tickets.departments")); ?>/' + id;
        document.getElementById('deleteDepartmentName').textContent = name;
        openModal('deleteModal');
    }

    // Close modal on backdrop click
    document.querySelectorAll('[id$="Modal"]').forEach(modal => {
        modal.addEventListener('click', function(e) {
            if (e.target === this) {
                this.classList.add('hidden');
            }
        });
    });
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\resources\views/admin/tickets/departments/index.blade.php ENDPATH**/ ?>