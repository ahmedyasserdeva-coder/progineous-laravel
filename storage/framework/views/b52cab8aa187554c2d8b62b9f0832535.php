

<?php $__env->startSection('title', __('tickets.open_new_ticket')); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-3xl mx-auto p-6">
    
    <!-- Header -->
    <div class="mb-8">
        <a href="<?php echo e(route('admin.tickets.index')); ?>" 
           class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-blue-600 transition-colors mb-4">
            <svg class="w-4 h-4 <?php echo e(app()->getLocale() == 'ar' ? 'rotate-180' : ''); ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            <?php echo e(__('tickets.back_to_tickets')); ?>

        </a>
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center shadow-lg shadow-blue-500/30">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                </svg>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-900"><?php echo e(__('tickets.open_new_ticket')); ?></h1>
                <p class="text-gray-500 text-sm"><?php echo e(app()->getLocale() == 'ar' ? 'إنشاء تذكرة نيابة عن العميل' : 'Create a ticket on behalf of a client'); ?></p>
            </div>
        </div>
    </div>

    <!-- Form Card -->
    <form action="<?php echo e(route('admin.tickets.store')); ?>" method="POST" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
            
            <!-- Client Selection -->
            <div class="p-6 border-b border-gray-100">
                <h2 class="text-sm font-semibold text-gray-900 mb-5"><?php echo e(app()->getLocale() == 'ar' ? 'اختيار العميل' : 'Select Client'); ?></h2>
                
                <div>
                    <label for="client_id" class="block text-sm font-medium text-gray-700 mb-2">
                        <?php echo e(__('crm.client')); ?> <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <select name="client_id" id="client_id" required
                                class="w-full appearance-none px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 focus:bg-white transition-all cursor-pointer <?php $__errorArgs = ['client_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-400 bg-red-50 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                            <option value=""><?php echo e(app()->getLocale() == 'ar' ? 'اختر العميل' : 'Select a client'); ?></option>
                            <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($client->id); ?>" <?php echo e(old('client_id') == $client->id ? 'selected' : ''); ?>>
                                    <?php echo e($client->first_name); ?> <?php echo e($client->last_name); ?> (<?php echo e($client->email); ?>)
                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <div class="absolute inset-y-0 <?php echo e(app()->getLocale() == 'ar' ? 'left-0 pl-4' : 'right-0 pr-4'); ?> flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                    </div>
                    <?php $__errorArgs = ['client_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                            <?php echo e($message); ?>

                        </p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            <!-- Basic Info -->
            <div class="p-6 border-b border-gray-100">
                <h2 class="text-sm font-semibold text-gray-900 mb-5"><?php echo e(app()->getLocale() == 'ar' ? 'المعلومات الأساسية' : 'Basic Information'); ?></h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <!-- Department -->
                    <div>
                        <label for="department_id" class="block text-sm font-medium text-gray-700 mb-2">
                            <?php echo e(__('tickets.department')); ?> <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <select name="department_id" id="department_id" required
                                    class="w-full appearance-none px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 focus:bg-white transition-all cursor-pointer <?php $__errorArgs = ['department_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-400 bg-red-50 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                <option value=""><?php echo e(__('tickets.select_department')); ?></option>
                                <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $department): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($department->id); ?>" <?php echo e(old('department_id') == $department->id ? 'selected' : ''); ?>>
                                        <?php echo e($department->name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <div class="absolute inset-y-0 <?php echo e(app()->getLocale() == 'ar' ? 'left-0 pl-4' : 'right-0 pr-4'); ?> flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </div>
                        </div>
                        <?php $__errorArgs = ['department_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                <?php echo e($message); ?>

                            </p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Priority -->
                    <div>
                        <label for="priority" class="block text-sm font-medium text-gray-700 mb-2">
                            <?php echo e(__('tickets.priority')); ?> <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <select name="priority" id="priority" required
                                    class="w-full appearance-none px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 focus:bg-white transition-all cursor-pointer <?php $__errorArgs = ['priority'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-400 bg-red-50 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                <option value="low" <?php echo e(old('priority') == 'low' ? 'selected' : ''); ?>><?php echo e(__('tickets.priority_low')); ?></option>
                                <option value="medium" <?php echo e(old('priority', 'medium') == 'medium' ? 'selected' : ''); ?>><?php echo e(__('tickets.priority_medium')); ?></option>
                                <option value="high" <?php echo e(old('priority') == 'high' ? 'selected' : ''); ?>><?php echo e(__('tickets.priority_high')); ?></option>
                                <option value="urgent" <?php echo e(old('priority') == 'urgent' ? 'selected' : ''); ?>><?php echo e(__('tickets.priority_urgent')); ?></option>
                            </select>
                            <div class="absolute inset-y-0 <?php echo e(app()->getLocale() == 'ar' ? 'left-0 pl-4' : 'right-0 pr-4'); ?> flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </div>
                        </div>
                        <?php $__errorArgs = ['priority'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                <?php echo e($message); ?>

                            </p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                <!-- Assigned Admin -->
                <div class="mt-5">
                    <label for="assigned_admin_id" class="block text-sm font-medium text-gray-700 mb-2">
                        <?php echo e(__('tickets.assigned_to')); ?>

                        <span class="text-gray-400 font-normal">(<?php echo e(app()->getLocale() == 'ar' ? 'اختياري' : 'Optional'); ?>)</span>
                    </label>
                    <div class="relative">
                        <select name="assigned_admin_id" id="assigned_admin_id"
                                class="w-full appearance-none px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 focus:bg-white transition-all cursor-pointer">
                            <option value=""><?php echo e(app()->getLocale() == 'ar' ? 'تعيين تلقائي لي' : 'Auto-assign to me'); ?></option>
                            <?php $__currentLoopData = $admins; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $admin): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($admin->id); ?>" <?php echo e(old('assigned_admin_id') == $admin->id ? 'selected' : ''); ?>>
                                    <?php echo e($admin->name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <div class="absolute inset-y-0 <?php echo e(app()->getLocale() == 'ar' ? 'left-0 pl-4' : 'right-0 pr-4'); ?> flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Subject -->
            <div class="p-6 border-b border-gray-100">
                <h2 class="text-sm font-semibold text-gray-900 mb-5"><?php echo e(__('tickets.subject')); ?></h2>
                
                <input type="text" name="subject" id="subject" value="<?php echo e(old('subject')); ?>" required
                       placeholder="<?php echo e(__('tickets.subject_placeholder')); ?>"
                       class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 focus:bg-white transition-all <?php $__errorArgs = ['subject'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-400 bg-red-50 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                <?php $__errorArgs = ['subject'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                        <?php echo e($message); ?>

                    </p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Message -->
            <div class="p-6 border-b border-gray-100">
                <h2 class="text-sm font-semibold text-gray-900 mb-5"><?php echo e(__('tickets.message')); ?></h2>
                
                <div class="rounded-xl overflow-hidden <?php $__errorArgs = ['message'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> ring-2 ring-red-400 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                    <textarea name="message" id="message"><?php echo e(old('message')); ?></textarea>
                </div>
                <?php $__errorArgs = ['message'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                        <?php echo e($message); ?>

                    </p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Attachments -->
            <div class="p-6 border-b border-gray-100">
                <h2 class="text-sm font-semibold text-gray-900 mb-5">
                    <?php echo e(__('tickets.attachments')); ?>

                    <span class="text-gray-400 font-normal">(<?php echo e(app()->getLocale() == 'ar' ? 'اختياري' : 'Optional'); ?>)</span>
                </h2>
                
                <div x-data="{ dragging: false, files: [] }" 
                     class="relative">
                    <div @dragover.prevent="dragging = true"
                         @dragleave.prevent="dragging = false"
                         @drop.prevent="dragging = false; $refs.fileInput.files = $event.dataTransfer.files; files = Array.from($refs.fileInput.files)"
                         :class="{ 'border-blue-500 bg-blue-50': dragging, 'border-gray-200 bg-gray-50': !dragging }"
                         class="border-2 border-dashed rounded-xl p-8 text-center transition-all cursor-pointer hover:border-blue-400 hover:bg-blue-50/50">
                        <input type="file" name="attachments[]" multiple x-ref="fileInput"
                               accept=".jpg,.jpeg,.png,.gif,.webp,.pdf,.doc,.docx,.txt,.rtf,.xls,.xlsx,.csv,.zip,.rar,.7z"
                               class="hidden" id="attachments"
                               @change="files = Array.from($refs.fileInput.files)">
                        <label for="attachments" class="cursor-pointer block">
                            <div class="w-14 h-14 mx-auto mb-4 rounded-2xl bg-white border border-gray-200 flex items-center justify-center shadow-sm">
                                <svg class="w-7 h-7 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                </svg>
                            </div>
                            <p class="text-sm font-medium text-gray-700 mb-1"><?php echo e(__('tickets.drop_files')); ?></p>
                            <p class="text-xs text-gray-500"><?php echo e(__('tickets.max_file_size')); ?></p>
                        </label>
                    </div>
                    
                    <!-- File List -->
                    <template x-if="files.length > 0">
                        <div class="mt-4 space-y-2">
                            <template x-for="(file, index) in files" :key="index">
                                <div class="flex items-center gap-3 p-3 bg-blue-50 rounded-lg border border-blue-100">
                                    <div class="w-8 h-8 rounded-lg bg-blue-500 flex items-center justify-center flex-shrink-0">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 truncate" x-text="file.name"></p>
                                        <p class="text-xs text-gray-500" x-text="(file.size / 1024 / 1024).toFixed(2) + ' MB'"></p>
                                    </div>
                                    <button type="button" @click="files.splice(index, 1)" class="p-1 hover:bg-blue-100 rounded transition-colors">
                                        <svg class="w-4 h-4 text-gray-400 hover:text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </button>
                                </div>
                            </template>
                        </div>
                    </template>
                </div>
                <?php $__errorArgs = ['attachments.*'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                        <?php echo e($message); ?>

                    </p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Submit -->
            <div class="p-6 bg-gray-50">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="flex items-center gap-2 text-sm text-gray-500">
                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span><?php echo e(app()->getLocale() == 'ar' ? 'سيتم إرسال إشعار للعميل' : 'Client will be notified'); ?></span>
                    </div>
                    <button type="submit" 
                            class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-3 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 focus:ring-4 focus:ring-blue-500/20 transition-all shadow-lg shadow-blue-500/30 hover:shadow-blue-500/40">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        <?php echo e(__('tickets.create_ticket')); ?>

                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .tox-tinymce {
        border: none !important;
        border-radius: 0.75rem !important;
    }
    .tox .tox-toolbar__primary {
        background: #f9fafb !important;
        border-bottom: 1px solid #e5e7eb !important;
    }
    .tox .tox-statusbar {
        background: #f9fafb !important;
        border-top: 1px solid #e5e7eb !important;
    }
    .tox .tox-edit-area__iframe {
        background: #fff !important;
    }
    .tox .tox-toolbar__group {
        border: none !important;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="<?php echo e(asset('tinymce_8.3.1/tinymce/js/tinymce/tinymce.min.js')); ?>"></script>
<script>
    tinymce.init({
        selector: '#message',
        license_key: 'gpl',
        height: 350,
        menubar: false,
        language: '<?php echo e(app()->getLocale() == "ar" ? "ar" : "en"); ?>',
        directionality: '<?php echo e(app()->getLocale() == "ar" ? "rtl" : "ltr"); ?>',
        plugins: [
            'advlist', 'autolink', 'lists', 'link', 'charmap',
            'searchreplace', 'visualblocks', 'code', 'fullscreen',
            'insertdatetime', 'table', 'help', 'wordcount', 'emoticons', 'directionality',
            'codesample', 'quickbars'
        ],
        toolbar: 'undo redo | styles | bold italic underline | ' +
            'alignleft aligncenter alignright | ltr rtl | ' +
            'bullist numlist | emoticons link codesample | removeformat | fullscreen',
        quickbars_selection_toolbar: 'bold italic underline | quicklink blockquote | codesample',
        quickbars_insert_toolbar: 'quicktable quicklink hr',
        codesample_languages: [
            { text: 'HTML/XML', value: 'markup' },
            { text: 'CSS', value: 'css' },
            { text: 'JavaScript', value: 'javascript' },
            { text: 'PHP', value: 'php' },
            { text: 'Python', value: 'python' },
            { text: 'Java', value: 'java' },
            { text: 'C#', value: 'csharp' },
            { text: 'Bash', value: 'bash' },
            { text: 'SQL', value: 'sql' },
            { text: 'JSON', value: 'json' }
        ],
        content_style: `
            body {
                font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
                font-size: 14px;
                line-height: 1.7;
                color: #374151;
                padding: 16px;
                direction: <?php echo e(app()->getLocale() == 'ar' ? 'rtl' : 'ltr'); ?>;
                text-align: <?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?>;
            }
            p { margin: 0 0 12px 0; }
            * { direction: <?php echo e(app()->getLocale() == 'ar' ? 'rtl' : 'ltr'); ?>; }
        `,
        skin: 'oxide',
        <?php if(app()->getLocale() == 'ar'): ?>
        toolbar_location: 'top',
        toolbar_sticky: true,
        <?php endif; ?>
        branding: false,
        promotion: false,
        statusbar: true,
        resize: 'both',
        min_height: 300,
        max_height: 600,
        placeholder: '<?php echo e(__("tickets.message_placeholder")); ?>',
        setup: function(editor) {
            editor.on('change keyup', function() {
                editor.save();
            });
        }
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\resources\views/admin/tickets/create.blade.php ENDPATH**/ ?>