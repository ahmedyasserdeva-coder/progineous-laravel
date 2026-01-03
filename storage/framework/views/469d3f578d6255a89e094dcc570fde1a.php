

<?php $__env->startSection('title', __('tickets.tickets')); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800"><?php echo e(__('tickets.tickets')); ?></h1>
            <p class="text-slate-500 mt-1"><?php echo e(app()->getLocale() == 'ar' ? 'إدارة تذاكر الدعم الفني' : 'Manage support tickets'); ?></p>
        </div>
        <div class="flex items-center gap-3">
            <a href="<?php echo e(route('admin.tickets.overview')); ?>" 
               class="inline-flex items-center gap-2 px-4 py-2.5 bg-white border border-slate-200 text-slate-700 rounded-xl hover:bg-slate-50 hover:border-slate-300 transition-all shadow-sm">
                <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                <?php echo e(app()->getLocale() == 'ar' ? 'نظرة عامة' : 'Overview'); ?>

            </a>
            <a href="<?php echo e(route('admin.tickets.departments')); ?>" 
               class="inline-flex items-center gap-2 px-4 py-2.5 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition-all shadow-sm shadow-blue-500/20">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5"/>
                </svg>
                <?php echo e(__('tickets.departments')); ?>

            </a>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-4 lg:grid-cols-8 gap-3">
        <a href="<?php echo e(route('admin.tickets.index')); ?>" class="group bg-white rounded-xl p-4 border border-slate-200 hover:border-slate-300 hover:shadow-md transition-all">
            <p class="text-2xl font-bold text-slate-800 group-hover:text-slate-900"><?php echo e($stats['total']); ?></p>
            <p class="text-xs text-slate-500 mt-1 font-medium"><?php echo e(__('tickets.total_tickets')); ?></p>
        </a>
        <a href="<?php echo e(route('admin.tickets.index', ['status' => 'open'])); ?>" class="group bg-blue-50 rounded-xl p-4 border-2 border-blue-100 hover:border-blue-300 hover:shadow-md transition-all">
            <p class="text-2xl font-bold text-blue-600"><?php echo e($stats['open']); ?></p>
            <p class="text-xs text-blue-600/70 mt-1 font-medium"><?php echo e(__('tickets.status_open')); ?></p>
        </a>
        <a href="<?php echo e(route('admin.tickets.index', ['status' => 'customer_reply'])); ?>" class="group bg-orange-50 rounded-xl p-4 border-2 border-orange-100 hover:border-orange-300 hover:shadow-md transition-all relative">
            <?php if($stats['customer_reply'] > 0): ?>
                <span class="absolute top-2 <?php echo e(app()->getLocale() == 'ar' ? 'left-2' : 'right-2'); ?> w-2 h-2 bg-orange-500 rounded-full animate-pulse"></span>
            <?php endif; ?>
            <p class="text-2xl font-bold text-orange-600"><?php echo e($stats['customer_reply']); ?></p>
            <p class="text-xs text-orange-600/70 mt-1 font-medium"><?php echo e(__('tickets.awaiting_reply')); ?></p>
        </a>
        <a href="<?php echo e(route('admin.tickets.index', ['status' => 'answered'])); ?>" class="group bg-emerald-50 rounded-xl p-4 border-2 border-emerald-100 hover:border-emerald-300 hover:shadow-md transition-all">
            <p class="text-2xl font-bold text-emerald-600"><?php echo e($stats['answered']); ?></p>
            <p class="text-xs text-emerald-600/70 mt-1 font-medium"><?php echo e(__('tickets.status_answered')); ?></p>
        </a>
        <a href="<?php echo e(route('admin.tickets.index', ['status' => 'on_hold'])); ?>" class="group bg-amber-50 rounded-xl p-4 border-2 border-amber-100 hover:border-amber-300 hover:shadow-md transition-all">
            <p class="text-2xl font-bold text-amber-600"><?php echo e($stats['on_hold']); ?></p>
            <p class="text-xs text-amber-600/70 mt-1 font-medium"><?php echo e(__('tickets.status_on_hold')); ?></p>
        </a>
        <a href="<?php echo e(route('admin.tickets.index', ['status' => 'closed'])); ?>" class="group bg-slate-50 rounded-xl p-4 border-2 border-slate-200 hover:border-slate-300 hover:shadow-md transition-all">
            <p class="text-2xl font-bold text-slate-600"><?php echo e($stats['closed']); ?></p>
            <p class="text-xs text-slate-500 mt-1 font-medium"><?php echo e(__('tickets.status_closed')); ?></p>
        </a>
        <a href="<?php echo e(route('admin.tickets.index', ['assigned_to' => 'unassigned'])); ?>" class="group bg-red-50 rounded-xl p-4 border-2 border-red-100 hover:border-red-300 hover:shadow-md transition-all">
            <p class="text-2xl font-bold text-red-600"><?php echo e($stats['unassigned']); ?></p>
            <p class="text-xs text-red-600/70 mt-1 font-medium"><?php echo e(__('tickets.unassigned')); ?></p>
        </a>
        <a href="<?php echo e(route('admin.tickets.index', ['assigned_to' => 'me'])); ?>" class="group bg-cyan-50 rounded-xl p-4 border-2 border-cyan-100 hover:border-cyan-300 hover:shadow-md transition-all">
            <p class="text-2xl font-bold text-cyan-600"><?php echo e($stats['my_tickets']); ?></p>
            <p class="text-xs text-cyan-600/70 mt-1 font-medium"><?php echo e(__('tickets.my_assigned')); ?></p>
        </a>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <form action="<?php echo e(route('admin.tickets.index')); ?>" method="GET">
            <div class="p-4 flex flex-wrap items-center gap-3">
                <!-- Search -->
                <div class="flex-1 min-w-[250px]">
                    <div class="relative">
                        <svg class="absolute <?php echo e(app()->getLocale() == 'ar' ? 'right-3' : 'left-3'); ?> top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <input type="text" name="search" value="<?php echo e(request('search')); ?>" 
                               placeholder="<?php echo e(__('tickets.search_placeholder')); ?>"
                               class="w-full <?php echo e(app()->getLocale() == 'ar' ? 'pr-10 pl-4' : 'pl-10 pr-4'); ?> py-2.5 bg-slate-50 border-0 rounded-xl focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all text-sm">
                    </div>
                </div>

                <!-- Status Filter -->
                <div class="relative min-w-[160px]">
                    <select name="status" class="w-full appearance-none px-4 <?php echo e(app()->getLocale() == 'ar' ? 'pl-10' : 'pr-10'); ?> py-2.5 bg-white border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm font-medium text-slate-700 cursor-pointer hover:border-slate-300 transition-all">
                        <option value=""><?php echo e(__('tickets.all_statuses')); ?></option>
                        <option value="flagged" <?php echo e(request('status') == 'flagged' ? 'selected' : ''); ?>><?php echo e(__('tickets.flagged')); ?></option>
                        <option value="active" <?php echo e(request('status') == 'active' ? 'selected' : ''); ?>><?php echo e(__('tickets.active_tickets')); ?></option>
                        <option value="open" <?php echo e(request('status') == 'open' ? 'selected' : ''); ?>><?php echo e(__('tickets.status_open')); ?></option>
                        <option value="customer_reply" <?php echo e(request('status') == 'customer_reply' ? 'selected' : ''); ?>><?php echo e(__('tickets.status_customer_reply')); ?></option>
                        <option value="answered" <?php echo e(request('status') == 'answered' ? 'selected' : ''); ?>><?php echo e(__('tickets.status_answered')); ?></option>
                        <option value="in_progress" <?php echo e(request('status') == 'in_progress' ? 'selected' : ''); ?>><?php echo e(__('tickets.status_in_progress')); ?></option>
                        <option value="on_hold" <?php echo e(request('status') == 'on_hold' ? 'selected' : ''); ?>><?php echo e(__('tickets.status_on_hold')); ?></option>
                        <option value="closed" <?php echo e(request('status') == 'closed' ? 'selected' : ''); ?>><?php echo e(__('tickets.status_closed')); ?></option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 <?php echo e(app()->getLocale() == 'ar' ? 'left-0 pl-3' : 'right-0 pr-3'); ?> flex items-center">
                        <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </div>
                </div>

                <!-- Priority Filter -->
                <div class="relative min-w-[160px]">
                    <select name="priority" class="w-full appearance-none px-4 <?php echo e(app()->getLocale() == 'ar' ? 'pl-10' : 'pr-10'); ?> py-2.5 bg-white border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm font-medium text-slate-700 cursor-pointer hover:border-slate-300 transition-all">
                        <option value=""><?php echo e(__('tickets.all_priorities')); ?></option>
                        <option value="urgent" <?php echo e(request('priority') == 'urgent' ? 'selected' : ''); ?>><?php echo e(__('tickets.priority_urgent')); ?></option>
                        <option value="high" <?php echo e(request('priority') == 'high' ? 'selected' : ''); ?>><?php echo e(__('tickets.priority_high')); ?></option>
                        <option value="medium" <?php echo e(request('priority') == 'medium' ? 'selected' : ''); ?>><?php echo e(__('tickets.priority_medium')); ?></option>
                        <option value="low" <?php echo e(request('priority') == 'low' ? 'selected' : ''); ?>><?php echo e(__('tickets.priority_low')); ?></option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 <?php echo e(app()->getLocale() == 'ar' ? 'left-0 pl-3' : 'right-0 pr-3'); ?> flex items-center">
                        <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </div>
                </div>

                <!-- Department Filter -->
                <div class="relative min-w-[160px]">
                    <select name="department" class="w-full appearance-none px-4 <?php echo e(app()->getLocale() == 'ar' ? 'pl-10' : 'pr-10'); ?> py-2.5 bg-white border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm font-medium text-slate-700 cursor-pointer hover:border-slate-300 transition-all">
                        <option value=""><?php echo e(__('tickets.all_departments')); ?></option>
                        <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $department): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($department->id); ?>" <?php echo e(request('department') == $department->id ? 'selected' : ''); ?>>
                                <?php echo e($department->name); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 <?php echo e(app()->getLocale() == 'ar' ? 'left-0 pl-3' : 'right-0 pr-3'); ?> flex items-center">
                        <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </div>
                </div>

                <!-- Assigned To Filter -->
                <div class="relative min-w-[160px]">
                    <select name="assigned_to" class="w-full appearance-none px-4 <?php echo e(app()->getLocale() == 'ar' ? 'pl-10' : 'pr-10'); ?> py-2.5 bg-white border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm font-medium text-slate-700 cursor-pointer hover:border-slate-300 transition-all">
                        <option value=""><?php echo e(__('tickets.assign_to')); ?></option>
                        <option value="unassigned" <?php echo e(request('assigned_to') == 'unassigned' ? 'selected' : ''); ?>><?php echo e(__('tickets.unassigned')); ?></option>
                        <option value="me" <?php echo e(request('assigned_to') == 'me' ? 'selected' : ''); ?>><?php echo e(__('tickets.my_assigned')); ?></option>
                        <?php $__currentLoopData = $admins; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $admin): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($admin->id); ?>" <?php echo e(request('assigned_to') == $admin->id ? 'selected' : ''); ?>>
                                <?php echo e($admin->name); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 <?php echo e(app()->getLocale() == 'ar' ? 'left-0 pl-3' : 'right-0 pr-3'); ?> flex items-center">
                        <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </div>
                </div>

                <!-- Filter Button -->
                <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition-colors font-medium text-sm shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                    </svg>
                    <?php echo e(__('tickets.filter')); ?>

                </button>

                <?php if(request()->hasAny(['search', 'status', 'priority', 'department', 'assigned_to'])): ?>
                    <a href="<?php echo e(route('admin.tickets.index')); ?>" class="inline-flex items-center gap-1 px-4 py-2.5 text-slate-600 hover:text-slate-800 hover:bg-slate-100 rounded-xl transition-colors text-sm font-medium">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        <?php echo e(app()->getLocale() == 'ar' ? 'مسح' : 'Clear'); ?>

                    </a>
                <?php endif; ?>
            </div>
        </form>
    </div>

    <!-- Success/Error Messages -->
    <?php if(session('success')): ?>
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-5 py-4 rounded-xl flex items-center gap-3">
            <svg class="w-5 h-5 text-emerald-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <!-- Tickets List -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <?php if($tickets->count() > 0): ?>
            <!-- Table Header (Desktop) -->
            <div class="hidden xl:grid xl:grid-cols-12 gap-4 px-6 py-3 bg-slate-50 border-b border-slate-200 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                <div class="col-span-2"><?php echo e(__('tickets.ticket_number')); ?></div>
                <div class="col-span-2"><?php echo e(app()->getLocale() == 'ar' ? 'العميل' : 'Client'); ?></div>
                <div class="col-span-2"><?php echo e(__('tickets.subject')); ?></div>
                <div class="col-span-1"><?php echo e(__('tickets.status')); ?></div>
                <div class="col-span-1"><?php echo e(__('tickets.priority')); ?></div>
                <div class="col-span-2"><?php echo e(__('tickets.assigned_to')); ?></div>
                <div class="col-span-2"><?php echo e(__('tickets.last_reply')); ?></div>
            </div>

            <!-- Tickets -->
            <div class="divide-y divide-slate-100">
                <?php $__currentLoopData = $tickets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ticket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e(route('admin.tickets.show', $ticket)); ?>" 
                       class="block hover:bg-slate-50 transition-colors <?php echo e($ticket->status == 'customer_reply' ? 'bg-orange-50/50 hover:bg-orange-50' : ''); ?>">
                        
                        <!-- Desktop View (xl screens) -->
                        <div class="hidden xl:grid xl:grid-cols-12 gap-4 px-6 py-4 items-center">
                            <!-- Ticket Number -->
                            <div class="col-span-2">
                                <div class="flex items-center gap-1">
                                    <?php if($ticket->is_flagged): ?>
                                        <svg class="w-4 h-4 text-yellow-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    <?php endif; ?>
                                    <span class="font-mono text-sm font-semibold text-blue-600">#<?php echo e($ticket->ticket_number); ?></span>
                                </div>
                            </div>

                            <!-- Client -->
                            <div class="col-span-2">
                                <p class="text-sm font-medium text-slate-800 truncate"><?php echo e($ticket->client->first_name); ?> <?php echo e($ticket->client->last_name); ?></p>
                                <p class="text-xs text-slate-400 truncate"><?php echo e($ticket->client->email); ?></p>
                            </div>

                            <!-- Subject -->
                            <div class="col-span-2">
                                <p class="text-sm font-medium text-slate-800 truncate"><?php echo e($ticket->subject); ?></p>
                                <p class="text-xs text-slate-400 truncate"><?php echo e($ticket->department->name); ?></p>
                            </div>

                            <!-- Status -->
                            <div class="col-span-1">
                                <?php
                                    $statusStyles = [
                                        'open' => 'bg-blue-100 text-blue-700',
                                        'customer_reply' => 'bg-orange-100 text-orange-700',
                                        'answered' => 'bg-emerald-100 text-emerald-700',
                                        'in_progress' => 'bg-cyan-100 text-cyan-700',
                                        'on_hold' => 'bg-amber-100 text-amber-700',
                                        'closed' => 'bg-slate-100 text-slate-600',
                                    ];
                                ?>
                                <span class="inline-flex px-2 py-1 text-[10px] font-semibold rounded-lg <?php echo e($statusStyles[$ticket->status] ?? 'bg-slate-100 text-slate-600'); ?>">
                                    <?php echo e($ticket->status_label); ?>

                                </span>
                            </div>

                            <!-- Priority -->
                            <div class="col-span-1">
                                <?php
                                    $priorityStyles = [
                                        'urgent' => 'bg-red-100 text-red-700',
                                        'high' => 'bg-orange-100 text-orange-700',
                                        'medium' => 'bg-blue-100 text-blue-700',
                                        'low' => 'bg-emerald-100 text-emerald-700',
                                    ];
                                ?>
                                <span class="inline-flex items-center gap-1 px-2 py-1 text-[10px] font-semibold rounded-lg <?php echo e($priorityStyles[$ticket->priority] ?? 'bg-slate-100 text-slate-600'); ?>">
                                    <?php if($ticket->priority == 'urgent'): ?>
                                        <span class="w-1.5 h-1.5 bg-red-500 rounded-full animate-pulse"></span>
                                    <?php endif; ?>
                                    <?php echo e($ticket->priority_label); ?>

                                </span>
                            </div>

                            <!-- Assigned To -->
                            <div class="col-span-2">
                                <?php if($ticket->assignedAdmin): ?>
                                    <div class="flex items-center gap-2">
                                        <div class="w-6 h-6 rounded-lg bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-[9px] font-bold text-white flex-shrink-0">
                                            <?php echo e(strtoupper(substr($ticket->assignedAdmin->name, 0, 2))); ?>

                                        </div>
                                        <span class="text-sm text-slate-700 truncate"><?php echo e($ticket->assignedAdmin->name); ?></span>
                                    </div>
                                <?php else: ?>
                                    <span class="inline-flex items-center gap-1 text-[10px] font-medium text-red-600 bg-red-50 px-2 py-1 rounded-lg">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                        </svg>
                                        <?php echo e(__('tickets.unassigned')); ?>

                                    </span>
                                <?php endif; ?>
                            </div>

                            <!-- Last Reply -->
                            <div class="col-span-2">
                                <span class="text-xs text-slate-500"><?php echo e($ticket->last_reply_at ? $ticket->last_reply_at->diffForHumans() : $ticket->created_at->diffForHumans()); ?></span>
                            </div>
                        </div>

                        <!-- Tablet View (lg screens) -->
                        <div class="hidden lg:grid xl:hidden lg:grid-cols-6 gap-4 px-6 py-4 items-center">
                            <!-- Ticket Info -->
                            <div class="col-span-2">
                                <div class="flex items-center gap-1 mb-1">
                                    <?php if($ticket->is_flagged): ?>
                                        <svg class="w-4 h-4 text-yellow-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    <?php endif; ?>
                                    <span class="font-mono text-sm font-semibold text-blue-600">#<?php echo e($ticket->ticket_number); ?></span>
                                </div>
                                <p class="text-sm font-medium text-slate-800 truncate"><?php echo e($ticket->subject); ?></p>
                                <p class="text-xs text-slate-400"><?php echo e($ticket->client->first_name); ?> <?php echo e($ticket->client->last_name); ?></p>
                            </div>

                            <!-- Status & Priority -->
                            <div class="col-span-2">
                                <div class="flex flex-wrap gap-1">
                                    <?php
                                        $statusStyles = [
                                            'open' => 'bg-blue-100 text-blue-700',
                                            'customer_reply' => 'bg-orange-100 text-orange-700',
                                            'answered' => 'bg-emerald-100 text-emerald-700',
                                            'in_progress' => 'bg-cyan-100 text-cyan-700',
                                            'on_hold' => 'bg-amber-100 text-amber-700',
                                            'closed' => 'bg-slate-100 text-slate-600',
                                        ];
                                        $priorityStyles = [
                                            'urgent' => 'bg-red-100 text-red-700',
                                            'high' => 'bg-orange-100 text-orange-700',
                                            'medium' => 'bg-blue-100 text-blue-700',
                                            'low' => 'bg-emerald-100 text-emerald-700',
                                        ];
                                    ?>
                                    <span class="inline-flex px-2 py-1 text-[10px] font-semibold rounded-lg <?php echo e($statusStyles[$ticket->status] ?? 'bg-slate-100 text-slate-600'); ?>">
                                        <?php echo e($ticket->status_label); ?>

                                    </span>
                                    <span class="inline-flex items-center gap-1 px-2 py-1 text-[10px] font-semibold rounded-lg <?php echo e($priorityStyles[$ticket->priority] ?? 'bg-slate-100 text-slate-600'); ?>">
                                        <?php if($ticket->priority == 'urgent'): ?>
                                            <span class="w-1.5 h-1.5 bg-red-500 rounded-full animate-pulse"></span>
                                        <?php endif; ?>
                                        <?php echo e($ticket->priority_label); ?>

                                    </span>
                                </div>
                                <p class="text-xs text-slate-400 mt-1"><?php echo e($ticket->department->name); ?></p>
                            </div>

                            <!-- Assigned & Time -->
                            <div class="col-span-2">
                                <?php if($ticket->assignedAdmin): ?>
                                    <div class="flex items-center gap-2 mb-1">
                                        <div class="w-6 h-6 rounded-lg bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-[9px] font-bold text-white flex-shrink-0">
                                            <?php echo e(strtoupper(substr($ticket->assignedAdmin->name, 0, 2))); ?>

                                        </div>
                                        <span class="text-sm text-slate-700 truncate"><?php echo e($ticket->assignedAdmin->name); ?></span>
                                    </div>
                                <?php else: ?>
                                    <span class="inline-flex items-center gap-1 text-[10px] font-medium text-red-600 bg-red-50 px-2 py-1 rounded-lg mb-1">
                                        <?php echo e(__('tickets.unassigned')); ?>

                                    </span>
                                <?php endif; ?>
                                <p class="text-xs text-slate-400"><?php echo e($ticket->last_reply_at ? $ticket->last_reply_at->diffForHumans() : $ticket->created_at->diffForHumans()); ?></p>
                            </div>
                        </div>

                        <!-- Mobile View -->
                        <div class="lg:hidden p-4">
                            <div class="flex items-start justify-between gap-3 mb-3">
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2 mb-1">
                                        <?php if($ticket->is_flagged): ?>
                                            <svg class="w-4 h-4 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                        <?php endif; ?>
                                        <span class="font-mono text-sm font-semibold text-blue-600">#<?php echo e($ticket->ticket_number); ?></span>
                                        <?php
                                            $statusStyles = [
                                                'open' => 'bg-blue-100 text-blue-700',
                                                'customer_reply' => 'bg-orange-100 text-orange-700',
                                                'answered' => 'bg-emerald-100 text-emerald-700',
                                                'in_progress' => 'bg-cyan-100 text-cyan-700',
                                                'on_hold' => 'bg-amber-100 text-amber-700',
                                                'closed' => 'bg-slate-100 text-slate-600',
                                            ];
                                        ?>
                                        <span class="inline-flex px-2 py-0.5 text-[10px] font-semibold rounded-full <?php echo e($statusStyles[$ticket->status] ?? 'bg-slate-100 text-slate-600'); ?>">
                                            <?php echo e($ticket->status_label); ?>

                                        </span>
                                    </div>
                                    <p class="text-sm font-medium text-slate-800 truncate"><?php echo e($ticket->subject); ?></p>
                                </div>
                                <?php
                                    $priorityStyles = [
                                        'urgent' => 'bg-red-500',
                                        'high' => 'bg-orange-500',
                                        'medium' => 'bg-blue-500',
                                        'low' => 'bg-emerald-500',
                                    ];
                                ?>
                                <span class="w-3 h-3 rounded-full <?php echo e($priorityStyles[$ticket->priority] ?? 'bg-slate-400'); ?> <?php echo e($ticket->priority == 'urgent' ? 'animate-pulse' : ''); ?> flex-shrink-0 mt-1"></span>
                            </div>
                            <div class="flex items-center justify-between text-xs text-slate-500">
                                <span><?php echo e($ticket->client->first_name); ?> <?php echo e($ticket->client->last_name); ?></span>
                                <span><?php echo e($ticket->last_reply_at ? $ticket->last_reply_at->diffForHumans() : $ticket->created_at->diffForHumans()); ?></span>
                            </div>
                        </div>
                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <!-- Pagination -->
            <?php if($tickets->hasPages()): ?>
                <div class="px-6 py-4 border-t border-slate-200 bg-white">
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                        <!-- Results Info -->
                        <p class="text-sm text-slate-500">
                            <?php echo e(app()->getLocale() == 'ar' ? 'عرض' : 'Showing'); ?>

                            <span class="font-semibold text-slate-700"><?php echo e($tickets->firstItem()); ?></span>
                            <?php echo e(app()->getLocale() == 'ar' ? 'إلى' : 'to'); ?>

                            <span class="font-semibold text-slate-700"><?php echo e($tickets->lastItem()); ?></span>
                            <?php echo e(app()->getLocale() == 'ar' ? 'من' : 'of'); ?>

                            <span class="font-semibold text-slate-700"><?php echo e($tickets->total()); ?></span>
                            <?php echo e(app()->getLocale() == 'ar' ? 'نتيجة' : 'results'); ?>

                        </p>

                        <!-- Pagination Links -->
                        <div class="flex items-center gap-1">
                            
                            <?php if($tickets->onFirstPage()): ?>
                                <span class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-slate-100 text-slate-400 cursor-not-allowed">
                                    <svg class="w-5 h-5 <?php echo e(app()->getLocale() == 'ar' ? 'rotate-180' : ''); ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                    </svg>
                                </span>
                            <?php else: ?>
                                <a href="<?php echo e($tickets->previousPageUrl()); ?>" class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-white border border-slate-200 text-slate-600 hover:bg-blue-50 hover:border-blue-200 hover:text-blue-600 transition-all">
                                    <svg class="w-5 h-5 <?php echo e(app()->getLocale() == 'ar' ? 'rotate-180' : ''); ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                    </svg>
                                </a>
                            <?php endif; ?>

                            
                            <?php
                                $start = max($tickets->currentPage() - 2, 1);
                                $end = min($start + 4, $tickets->lastPage());
                                if($end - $start < 4) {
                                    $start = max($end - 4, 1);
                                }
                            ?>

                            <?php if($start > 1): ?>
                                <a href="<?php echo e($tickets->url(1)); ?>" class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-white border border-slate-200 text-sm font-medium text-slate-600 hover:bg-blue-50 hover:border-blue-200 hover:text-blue-600 transition-all">1</a>
                                <?php if($start > 2): ?>
                                    <span class="px-2 text-slate-400">...</span>
                                <?php endif; ?>
                            <?php endif; ?>

                            <?php for($i = $start; $i <= $end; $i++): ?>
                                <?php if($i == $tickets->currentPage()): ?>
                                    <span class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-blue-600 text-sm font-semibold text-white shadow-sm"><?php echo e($i); ?></span>
                                <?php else: ?>
                                    <a href="<?php echo e($tickets->url($i)); ?>" class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-white border border-slate-200 text-sm font-medium text-slate-600 hover:bg-blue-50 hover:border-blue-200 hover:text-blue-600 transition-all"><?php echo e($i); ?></a>
                                <?php endif; ?>
                            <?php endfor; ?>

                            <?php if($end < $tickets->lastPage()): ?>
                                <?php if($end < $tickets->lastPage() - 1): ?>
                                    <span class="px-2 text-slate-400">...</span>
                                <?php endif; ?>
                                <a href="<?php echo e($tickets->url($tickets->lastPage())); ?>" class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-white border border-slate-200 text-sm font-medium text-slate-600 hover:bg-blue-50 hover:border-blue-200 hover:text-blue-600 transition-all"><?php echo e($tickets->lastPage()); ?></a>
                            <?php endif; ?>

                            
                            <?php if($tickets->hasMorePages()): ?>
                                <a href="<?php echo e($tickets->nextPageUrl()); ?>" class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-white border border-slate-200 text-slate-600 hover:bg-blue-50 hover:border-blue-200 hover:text-blue-600 transition-all">
                                    <svg class="w-5 h-5 <?php echo e(app()->getLocale() == 'ar' ? 'rotate-180' : ''); ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </a>
                            <?php else: ?>
                                <span class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-slate-100 text-slate-400 cursor-not-allowed">
                                    <svg class="w-5 h-5 <?php echo e(app()->getLocale() == 'ar' ? 'rotate-180' : ''); ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <!-- Empty State -->
            <div class="p-16 text-center">
                <div class="w-20 h-20 rounded-2xl bg-slate-100 flex items-center justify-center mx-auto mb-5">
                    <svg class="w-10 h-10 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-slate-800 mb-2"><?php echo e(__('tickets.messages.no_tickets_found')); ?></h3>
                <p class="text-slate-500 mb-6"><?php echo e(app()->getLocale() == 'ar' ? 'لا توجد تذاكر تطابق معايير البحث' : 'No tickets match your search criteria'); ?></p>
                <?php if(request()->hasAny(['search', 'status', 'priority', 'department', 'assigned_to'])): ?>
                    <a href="<?php echo e(route('admin.tickets.index')); ?>" class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition-colors font-medium text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        <?php echo e(app()->getLocale() == 'ar' ? 'إعادة تعيين الفلاتر' : 'Reset Filters'); ?>

                    </a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\resources\views/admin/tickets/index.blade.php ENDPATH**/ ?>