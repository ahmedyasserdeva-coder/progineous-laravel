

<?php $__env->startSection('title', __('tickets.view_ticket') . ' #' . $ticket->ticket_number); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-sm text-gray-500 mb-1">
                <a href="<?php echo e(route('admin.tickets.index')); ?>" class="hover:text-blue-600"><?php echo e(__('tickets.tickets')); ?></a>
                <span>/</span>
                <span>#<?php echo e($ticket->ticket_number); ?></span>
            </div>
            <h1 class="text-2xl font-bold text-gray-900"><?php echo e($ticket->subject); ?></h1>
        </div>
        <div class="flex items-center gap-3">
            <!-- Flag Button -->
            <form action="<?php echo e(route('admin.tickets.toggle-flag', $ticket)); ?>" method="POST" class="inline">
                <?php echo csrf_field(); ?>
                <button type="submit" class="px-4 py-2 rounded-lg transition-colors flex items-center gap-2 <?php echo e($ticket->is_flagged ? 'bg-yellow-100 text-yellow-700 hover:bg-yellow-200' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'); ?>">
                    <svg class="w-5 h-5 <?php echo e($ticket->is_flagged ? 'text-yellow-500' : 'text-gray-400'); ?>" fill="<?php echo e($ticket->is_flagged ? 'currentColor' : 'none'); ?>" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                    </svg>
                    <?php echo e($ticket->is_flagged ? __('tickets.flagged') : __('tickets.flag')); ?>

                </button>
            </form>

            <?php if($ticket->status != 'closed'): ?>
                <button type="button" onclick="document.getElementById('closeModal').classList.remove('hidden')"
                        class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                    <?php echo e(__('tickets.close_ticket')); ?>

                </button>
            <?php else: ?>
                <form action="<?php echo e(route('admin.tickets.update', $ticket)); ?>" method="POST" class="inline">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    <input type="hidden" name="status" value="open">
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                        <?php echo e(__('tickets.reopen_ticket')); ?>

                    </button>
                </form>
            <?php endif; ?>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Original Message -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">
                            <span class="text-blue-600 font-semibold"><?php echo e(substr($ticket->client->first_name, 0, 1)); ?></span>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900"><?php echo e($ticket->client->first_name); ?> <?php echo e($ticket->client->last_name); ?></p>
                            <p class="text-sm text-gray-500"><?php echo e($ticket->created_at->format('Y-m-d H:i')); ?></p>
                        </div>
                    </div>
                    <span class="px-2 py-1 bg-blue-100 text-blue-700 text-xs font-medium rounded"><?php echo e(__('tickets.client')); ?></span>
                </div>
                <div class="px-6 py-4">
                    <div class="prose max-w-none">
                        <?php echo $ticket->message; ?>

                    </div>
                    
                    <?php if($ticket->attachments->where('reply_id', null)->count() > 0): ?>
                        <div class="mt-4 pt-4 border-t border-gray-100">
                            <h4 class="text-sm font-medium text-gray-700 mb-2"><?php echo e(__('tickets.attachments')); ?></h4>
                            <div class="flex flex-wrap gap-2">
                                <?php $__currentLoopData = $ticket->attachments->where('reply_id', null); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attachment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <a href="<?php echo e(route('admin.tickets.attachment.download', $attachment)); ?>" 
                                       class="inline-flex items-center px-3 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg text-sm transition-colors">
                                        <svg class="w-4 h-4 <?php echo e(app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2'); ?> text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        <?php echo e($attachment->filename); ?>

                                        <span class="text-gray-400 <?php echo e(app()->getLocale() == 'ar' ? 'mr-2' : 'ml-2'); ?>">(<?php echo e(number_format($attachment->size / 1024, 1)); ?> KB)</span>
                                    </a>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Replies -->
            <?php $__currentLoopData = $ticket->replies()->orderBy('created_at', 'asc')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reply): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="bg-white rounded-xl shadow-sm border <?php echo e($reply->is_internal ? 'border-yellow-200 bg-yellow-50' : ($reply->isFromClient() ? 'border-gray-100' : 'border-blue-100')); ?> overflow-hidden">
                    <div class="px-6 py-4 border-b <?php echo e($reply->is_internal ? 'border-yellow-200 bg-yellow-100' : ($reply->isFromClient() ? 'border-gray-100 bg-gray-50' : 'border-blue-100 bg-blue-50')); ?> flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full <?php echo e($reply->isFromClient() ? 'bg-blue-100' : 'bg-green-100'); ?> flex items-center justify-center">
                                <span class="<?php echo e($reply->isFromClient() ? 'text-blue-600' : 'text-green-600'); ?> font-semibold">
                                    <?php echo e(substr($reply->author_name, 0, 1)); ?>

                                </span>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900"><?php echo e($reply->author_name); ?></p>
                                <p class="text-sm text-gray-500"><?php echo e($reply->created_at->format('Y-m-d H:i')); ?></p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <?php if($reply->is_internal): ?>
                                <span class="px-2 py-1 bg-yellow-200 text-yellow-800 text-xs font-medium rounded"><?php echo e(__('tickets.internal_note')); ?></span>
                            <?php endif; ?>
                            <span class="px-2 py-1 <?php echo e($reply->isFromClient() ? 'bg-blue-100 text-blue-700' : 'bg-green-100 text-green-700'); ?> text-xs font-medium rounded">
                                <?php echo e($reply->isFromClient() ? __('tickets.client') : __('tickets.staff')); ?>

                            </span>
                        </div>
                    </div>
                    <div class="px-6 py-4 <?php echo e($reply->is_internal ? 'bg-yellow-50' : ''); ?>">
                        <div class="prose max-w-none">
                            <?php echo $reply->message; ?>

                        </div>

                        <?php if($reply->attachments->count() > 0): ?>
                            <div class="mt-4 pt-4 border-t <?php echo e($reply->is_internal ? 'border-yellow-200' : 'border-gray-100'); ?>">
                                <h4 class="text-sm font-medium text-gray-700 mb-2"><?php echo e(__('tickets.attachments')); ?></h4>
                                <div class="flex flex-wrap gap-2">
                                    <?php $__currentLoopData = $reply->attachments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attachment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <a href="<?php echo e(route('admin.tickets.attachment.download', $attachment)); ?>" 
                                           class="inline-flex items-center px-3 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg text-sm transition-colors">
                                            <svg class="w-4 h-4 <?php echo e(app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2'); ?> text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                            <?php echo e($attachment->filename); ?>

                                            <span class="text-gray-400 <?php echo e(app()->getLocale() == 'ar' ? 'mr-2' : 'ml-2'); ?>">(<?php echo e(number_format($attachment->size / 1024, 1)); ?> KB)</span>
                                        </a>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        
                        <?php if(!$reply->isFromClient() && !$reply->is_internal && $reply->rating): ?>
                            <div class="mt-4 pt-4 border-t border-gray-100">
                                <div class="flex items-center gap-2">
                                    <span class="text-sm text-gray-500"><?php echo e(__('tickets.client_rating')); ?>:</span>
                                    <?php if($reply->rating == 'helpful'): ?>
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-green-50 border border-green-200 rounded-full text-xs font-medium text-green-700">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z"/>
                                            </svg>
                                            <?php echo e(__('tickets.helpful')); ?>

                                        </span>
                                    <?php else: ?>
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-red-50 border border-red-200 rounded-full text-xs font-medium text-red-700">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M18 9.5a1.5 1.5 0 11-3 0v-6a1.5 1.5 0 013 0v6zM14 9.667v-5.43a2 2 0 00-1.105-1.79l-.05-.025A4 4 0 0011.055 2H5.64a2 2 0 00-1.962 1.608l-1.2 6A2 2 0 004.44 12H8v4a2 2 0 002 2 1 1 0 001-1v-.667a4 4 0 01.8-2.4l1.4-1.866a4 4 0 00.8-2.4z"/>
                                            </svg>
                                            <?php echo e(__('tickets.not_helpful')); ?>

                                        </span>
                                    <?php endif; ?>
                                    <span class="text-xs text-gray-400"><?php echo e($reply->rated_at ? $reply->rated_at->format('Y-m-d H:i') : ''); ?></span>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <!-- Reply Form -->
            <?php if($ticket->status != 'closed'): ?>
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100">
                        <h3 class="font-semibold text-gray-900"><?php echo e(__('tickets.add_reply')); ?></h3>
                    </div>
                    <form action="<?php echo e(route('admin.tickets.reply', $ticket)); ?>" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
                        <?php echo csrf_field(); ?>
                        <div>
                            <textarea name="message" rows="5" required
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 <?php $__errorArgs = ['message'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                      placeholder="<?php echo e(__('tickets.write_your_reply')); ?>"><?php echo e(old('message')); ?></textarea>
                            <?php $__errorArgs = ['message'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="mt-1 text-sm text-red-500"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2"><?php echo e(__('tickets.attachments')); ?></label>
                            <input type="file" name="attachments[]" multiple accept=".jpg,.jpeg,.png,.gif,.pdf,.doc,.docx,.xls,.xlsx,.txt,.zip"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            <p class="mt-1 text-sm text-gray-500"><?php echo e(__('tickets.allowed_file_types')); ?></p>
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" name="is_internal" id="is_internal" value="1" class="w-4 h-4 text-yellow-600 border-gray-300 rounded focus:ring-yellow-500">
                            <label for="is_internal" class="ms-2 text-sm text-gray-700">
                                <?php echo e(__('tickets.internal_note')); ?> <span class="text-gray-500">(<?php echo e(__('tickets.client_will_not_see')); ?>)</span>
                            </label>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                <?php echo e(__('tickets.send_reply')); ?>

                            </button>
                        </div>
                    </form>
                </div>
            <?php endif; ?>
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Ticket Info -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h3 class="font-semibold text-gray-900"><?php echo e(__('tickets.ticket_info')); ?></h3>
                </div>
                <div class="px-6 py-4 space-y-4">
                    <div>
                        <p class="text-sm text-gray-500"><?php echo e(__('tickets.ticket_number')); ?></p>
                        <p class="font-mono text-blue-600"><?php echo e($ticket->ticket_number); ?></p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500"><?php echo e(__('tickets.department')); ?></p>
                        <p class="font-medium text-gray-900"><?php echo e($ticket->department->name); ?></p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 mb-1"><?php echo e(__('tickets.status')); ?></p>
                        <form action="<?php echo e(route('admin.tickets.update', $ticket)); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PUT'); ?>
                            <select name="status" onchange="this.form.submit()" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500">
                                <option value="open" <?php echo e($ticket->status == 'open' ? 'selected' : ''); ?>><?php echo e(__('tickets.status_open')); ?></option>
                                <option value="answered" <?php echo e($ticket->status == 'answered' ? 'selected' : ''); ?>><?php echo e(__('tickets.status_answered')); ?></option>
                                <option value="customer_reply" <?php echo e($ticket->status == 'customer_reply' ? 'selected' : ''); ?>><?php echo e(__('tickets.status_customer_reply')); ?></option>
                                <option value="on_hold" <?php echo e($ticket->status == 'on_hold' ? 'selected' : ''); ?>><?php echo e(__('tickets.status_on_hold')); ?></option>
                                <option value="closed" <?php echo e($ticket->status == 'closed' ? 'selected' : ''); ?>><?php echo e(__('tickets.status_closed')); ?></option>
                            </select>
                        </form>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 mb-1"><?php echo e(__('tickets.priority')); ?></p>
                        <form action="<?php echo e(route('admin.tickets.update', $ticket)); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PUT'); ?>
                            <select name="priority" onchange="this.form.submit()" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500">
                                <option value="low" <?php echo e($ticket->priority == 'low' ? 'selected' : ''); ?>><?php echo e(__('tickets.priority_low')); ?></option>
                                <option value="medium" <?php echo e($ticket->priority == 'medium' ? 'selected' : ''); ?>><?php echo e(__('tickets.priority_medium')); ?></option>
                                <option value="high" <?php echo e($ticket->priority == 'high' ? 'selected' : ''); ?>><?php echo e(__('tickets.priority_high')); ?></option>
                                <option value="urgent" <?php echo e($ticket->priority == 'urgent' ? 'selected' : ''); ?>><?php echo e(__('tickets.priority_urgent')); ?></option>
                            </select>
                        </form>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 mb-1"><?php echo e(__('tickets.assigned_to')); ?></p>
                        <form action="<?php echo e(route('admin.tickets.update', $ticket)); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PUT'); ?>
                            <select name="assigned_admin_id" onchange="this.form.submit()" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500">
                                <option value=""><?php echo e(__('tickets.unassigned')); ?></option>
                                <?php $__currentLoopData = $admins; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $admin): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($admin->id); ?>" <?php echo e($ticket->assigned_admin_id == $admin->id ? 'selected' : ''); ?>>
                                        <?php echo e($admin->name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </form>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500"><?php echo e(__('tickets.created_at')); ?></p>
                        <p class="text-gray-900"><?php echo e($ticket->created_at->format('Y-m-d H:i')); ?></p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500"><?php echo e(__('tickets.last_updated')); ?></p>
                        <p class="text-gray-900"><?php echo e($ticket->updated_at->format('Y-m-d H:i')); ?></p>
                    </div>
                </div>
            </div>

            <!-- Client Info -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h3 class="font-semibold text-gray-900"><?php echo e(__('tickets.client_info')); ?></h3>
                </div>
                <div class="px-6 py-4 space-y-4">
                    <div>
                        <p class="text-sm text-gray-500"><?php echo e(__('tickets.name_label')); ?></p>
                        <p class="font-medium text-gray-900"><?php echo e($ticket->client->first_name); ?> <?php echo e($ticket->client->last_name); ?></p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500"><?php echo e(__('tickets.email_label')); ?></p>
                        <a href="mailto:<?php echo e($ticket->client->email); ?>" class="text-blue-600 hover:underline"><?php echo e($ticket->client->email); ?></a>
                    </div>
                    <?php if($ticket->client->phone): ?>
                        <div>
                            <p class="text-sm text-gray-500"><?php echo e(__('tickets.phone_label')); ?></p>
                            <p class="text-gray-900"><?php echo e($ticket->client->phone); ?></p>
                        </div>
                    <?php endif; ?>
                    <div>
                        <a href="<?php echo e(route('admin.clients.show', $ticket->client)); ?>" 
                           class="text-sm text-blue-600 hover:underline">
                            <?php echo e(__('tickets.view_client_profile')); ?> →
                        </a>
                    </div>
                </div>
            </div>

            <!-- Related Service -->
            <?php if($ticket->service): ?>
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100">
                        <h3 class="font-semibold text-gray-900"><?php echo e(__('tickets.related_service')); ?></h3>
                    </div>
                    <div class="px-6 py-4 space-y-3">
                        <div>
                            <p class="text-sm text-gray-500"><?php echo e(__('tickets.type')); ?></p>
                            <p class="text-gray-900"><?php echo e(ucfirst(str_replace('_', ' ', $ticket->service_type))); ?></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500"><?php echo e(__('tickets.name_label')); ?></p>
                            <p class="font-medium text-gray-900"><?php echo e($ticket->service->domain ?? $ticket->service->service_name ?? 'N/A'); ?></p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Actions -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h3 class="font-semibold text-gray-900"><?php echo e(__('tickets.actions')); ?></h3>
                </div>
                <div class="px-6 py-4 space-y-3">
                    <button type="button" onclick="document.getElementById('deleteModal').classList.remove('hidden')"
                            class="w-full px-4 py-2 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition-colors text-sm">
                        <?php echo e(__('tickets.delete_ticket')); ?>

                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Close Modal -->
<div id="closeModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-xl shadow-xl max-w-md w-full p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4"><?php echo e(__('tickets.close_ticket')); ?></h3>
        <p class="text-gray-600 mb-6"><?php echo e(__('tickets.confirm_close')); ?></p>
        <div class="flex justify-end gap-3">
            <button type="button" onclick="document.getElementById('closeModal').classList.add('hidden')"
                    class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">
                <?php echo e(__('tickets.cancel')); ?>

            </button>
            <form action="<?php echo e(route('admin.tickets.update', $ticket)); ?>" method="POST" class="inline">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <input type="hidden" name="status" value="closed">
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                    <?php echo e(__('tickets.close_ticket')); ?>

                </button>
            </form>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div id="deleteModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-xl shadow-xl max-w-md w-full p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4"><?php echo e(__('tickets.delete_ticket')); ?></h3>
        <p class="text-gray-600 mb-6"><?php echo e(__('tickets.confirm_delete')); ?></p>
        <div class="flex justify-end gap-3">
            <button type="button" onclick="document.getElementById('deleteModal').classList.add('hidden')"
                    class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">
                <?php echo e(__('tickets.cancel')); ?>

            </button>
            <form action="<?php echo e(route('admin.tickets.destroy', $ticket)); ?>" method="POST" class="inline">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                    <?php echo e(__('tickets.delete')); ?>

                </button>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\resources\views/admin/tickets/show.blade.php ENDPATH**/ ?>