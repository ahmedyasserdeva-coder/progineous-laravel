

<?php $__env->startSection('title', __('crm.invoice') . ' #' . $invoice->invoice_number); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-6">
    <!-- Breadcrumb -->
    <nav class="flex mb-6" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3 rtl:space-x-reverse">
            <li class="inline-flex items-center">
                <a href="<?php echo e(route('admin.clients.index')); ?>" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                    <?php echo e(__('crm.clients')); ?>

                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-3 h-3 text-gray-400 mx-1 rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                    <a href="<?php echo e(route('admin.clients.show', $invoice->client)); ?>" class="text-sm font-medium text-gray-700 hover:text-blue-600">
                        <?php echo e($invoice->client->first_name); ?> <?php echo e($invoice->client->last_name); ?>

                    </a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="w-3 h-3 text-gray-400 mx-1 rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                    <span class="text-sm font-medium text-gray-500"><?php echo e(__('crm.invoice')); ?> #<?php echo e($invoice->invoice_number); ?></span>
                </div>
            </li>
        </ol>
    </nav>

    <!-- Invoice Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-gray-50 to-white px-6 py-5 border-b border-gray-200">
            <div class="flex items-center justify-between flex-wrap gap-4">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-purple-100 rounded-lg">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900"><?php echo e(__('crm.invoice')); ?> #<?php echo e($invoice->invoice_number); ?></h1>
                        <p class="text-sm text-gray-500"><?php echo e(__('crm.created_at')); ?>: <?php echo e($invoice->created_at->format('Y-m-d H:i')); ?></p>
                    </div>
                </div>
                
                <!-- Status Badge -->
                <div class="flex items-center gap-3">
                    <?php if($invoice->status === 'paid'): ?>
                        <span class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full text-sm font-semibold bg-green-100 text-green-800">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <?php echo e(__('crm.paid')); ?>

                        </span>
                    <?php elseif($invoice->status === 'pending'): ?>
                        <span class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full text-sm font-semibold bg-yellow-100 text-yellow-800">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                            </svg>
                            <?php echo e(__('crm.pending')); ?>

                        </span>
                    <?php elseif($invoice->status === 'cancelled'): ?>
                        <span class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full text-sm font-semibold bg-red-100 text-red-800">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                            <?php echo e(__('crm.cancelled')); ?>

                        </span>
                    <?php else: ?>
                        <span class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full text-sm font-semibold bg-gray-100 text-gray-800">
                            <?php echo e(ucfirst($invoice->status)); ?>

                        </span>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="p-6">
            <!-- Client & Company Info -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <!-- Client Info -->
                <div class="bg-gray-50 rounded-lg p-5">
                    <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-4"><?php echo e(__('crm.client_info')); ?></h3>
                    <div class="space-y-2">
                        <p class="text-base font-semibold text-gray-900"><?php echo e($invoice->client->first_name); ?> <?php echo e($invoice->client->last_name); ?></p>
                        <p class="text-sm text-gray-600"><?php echo e($invoice->client->email); ?></p>
                        <?php if($invoice->client->phone): ?>
                        <p class="text-sm text-gray-600" dir="ltr"><?php echo e($invoice->client->phone); ?></p>
                        <?php endif; ?>
                        <?php if($invoice->client->company_name): ?>
                        <p class="text-sm text-gray-600"><?php echo e($invoice->client->company_name); ?></p>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Invoice Dates -->
                <div class="bg-gray-50 rounded-lg p-5">
                    <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-4"><?php echo e(__('crm.invoice_dates')); ?></h3>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600"><?php echo e(__('crm.invoice_date')); ?>:</span>
                            <span class="text-sm font-medium text-gray-900"><?php echo e($invoice->invoice_date?->format('Y-m-d') ?? '-'); ?></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600"><?php echo e(__('crm.due_date')); ?>:</span>
                            <span class="text-sm font-medium text-gray-900"><?php echo e($invoice->due_date?->format('Y-m-d') ?? '-'); ?></span>
                        </div>
                        <?php if($invoice->paid_at): ?>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600"><?php echo e(__('crm.paid_date')); ?>:</span>
                            <span class="text-sm font-medium text-green-600"><?php echo e($invoice->paid_at->format('Y-m-d H:i')); ?></span>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Order Items -->
            <?php if($invoice->order && $invoice->order->items && $invoice->order->items->count() > 0): ?>
            <div class="mb-8">
                <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-4"><?php echo e(__('crm.order_items')); ?></h3>
                <div class="border border-gray-200 rounded-lg overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?> text-xs font-medium text-gray-500 uppercase"><?php echo e(__('crm.item')); ?></th>
                                <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase"><?php echo e(__('crm.quantity')); ?></th>
                                <th class="px-4 py-3 text-<?php echo e(app()->getLocale() == 'ar' ? 'left' : 'right'); ?> text-xs font-medium text-gray-500 uppercase"><?php echo e(__('crm.unit_price')); ?></th>
                                <th class="px-4 py-3 text-<?php echo e(app()->getLocale() == 'ar' ? 'left' : 'right'); ?> text-xs font-medium text-gray-500 uppercase"><?php echo e(__('crm.total')); ?></th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php $__currentLoopData = $invoice->order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td class="px-4 py-4">
                                    <div class="text-sm font-medium text-gray-900"><?php echo e($item->product_name ?? $item->item_name ?? 'N/A'); ?></div>
                                    <?php if($item->description): ?>
                                    <div class="text-xs text-gray-500 mt-0.5"><?php echo e($item->description); ?></div>
                                    <?php endif; ?>
                                </td>
                                <td class="px-4 py-4 text-center text-sm text-gray-900"><?php echo e($item->quantity ?? 1); ?></td>
                                <td class="px-4 py-4 text-<?php echo e(app()->getLocale() == 'ar' ? 'left' : 'right'); ?> text-sm text-gray-900">
                                    $<?php echo e(number_format($item->unit_price ?? 0, 2)); ?>

                                </td>
                                <td class="px-4 py-4 text-<?php echo e(app()->getLocale() == 'ar' ? 'left' : 'right'); ?> text-sm font-medium text-gray-900">
                                    $<?php echo e(number_format($item->total ?? (($item->unit_price ?? 0) * ($item->quantity ?? 1)), 2)); ?>

                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php endif; ?>

            <!-- Invoice Summary -->
            <div class="flex justify-end">
                <div class="w-full md:w-96 bg-gray-50 rounded-lg p-5">
                    <div class="space-y-3">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600"><?php echo e(__('crm.subtotal')); ?>:</span>
                            <span class="font-medium text-gray-900">$<?php echo e(number_format($invoice->subtotal ?? 0, 2)); ?></span>
                        </div>
                        
                        <?php if($invoice->tax > 0): ?>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600"><?php echo e(__('crm.tax')); ?>:</span>
                            <span class="font-medium text-gray-900">$<?php echo e(number_format($invoice->tax, 2)); ?></span>
                        </div>
                        <?php endif; ?>
                        
                        <?php if($invoice->discount > 0): ?>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600"><?php echo e(__('crm.discount')); ?>:</span>
                            <span class="font-medium text-green-600">-$<?php echo e(number_format($invoice->discount, 2)); ?></span>
                        </div>
                        <?php endif; ?>
                        
                        <div class="border-t border-gray-200 pt-3 mt-3">
                            <div class="flex justify-between">
                                <span class="text-base font-semibold text-gray-900"><?php echo e(__('crm.total')); ?>:</span>
                                <span class="text-xl font-bold text-gray-900">$<?php echo e(number_format($invoice->total ?? 0, 2)); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payments -->
            <?php if($invoice->payments && $invoice->payments->count() > 0): ?>
            <div class="mt-8">
                <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-4"><?php echo e(__('crm.payment_history')); ?></h3>
                <div class="border border-gray-200 rounded-lg overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?> text-xs font-medium text-gray-500 uppercase"><?php echo e(__('crm.date')); ?></th>
                                <th class="px-4 py-3 text-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?> text-xs font-medium text-gray-500 uppercase"><?php echo e(__('crm.payment_method')); ?></th>
                                <th class="px-4 py-3 text-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?> text-xs font-medium text-gray-500 uppercase"><?php echo e(__('crm.reference')); ?></th>
                                <th class="px-4 py-3 text-<?php echo e(app()->getLocale() == 'ar' ? 'left' : 'right'); ?> text-xs font-medium text-gray-500 uppercase"><?php echo e(__('crm.amount')); ?></th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php $__currentLoopData = $invoice->payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td class="px-4 py-3 text-sm text-gray-900"><?php echo e($payment->created_at?->format('Y-m-d H:i') ?? '-'); ?></td>
                                <td class="px-4 py-3 text-sm text-gray-900"><?php echo e(ucwords(str_replace('_', ' ', $payment->payment_method ?? '-'))); ?></td>
                                <td class="px-4 py-3 text-sm font-mono text-gray-600"><?php echo e($payment->transaction_id ?? $payment->reference ?? '-'); ?></td>
                                <td class="px-4 py-3 text-<?php echo e(app()->getLocale() == 'ar' ? 'left' : 'right'); ?> text-sm font-medium text-green-600">
                                    +$<?php echo e(number_format($payment->amount ?? 0, 2)); ?>

                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php endif; ?>

            <!-- Wallet Transactions -->
            <?php
                $walletTransactions = \App\Models\WalletTransaction::where('client_id', $invoice->client_id)
                    ->where(function($q) use ($invoice) {
                        $q->whereJsonContains('metadata->invoice_id', $invoice->id)
                          ->orWhere('metadata', 'LIKE', '%"invoice_id":' . $invoice->id . '%')
                          ->orWhere('metadata', 'LIKE', '%"invoice_id": ' . $invoice->id . '%');
                    })
                    ->orderBy('created_at', 'desc')
                    ->get();
            ?>
            <?php if($walletTransactions->count() > 0): ?>
            <div class="mt-8">
                <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-4"><?php echo e(__('crm.transaction_history')); ?></h3>
                <div class="border border-gray-200 rounded-lg overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?> text-xs font-medium text-gray-500 uppercase"><?php echo e(__('crm.reference')); ?></th>
                                <th class="px-4 py-3 text-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?> text-xs font-medium text-gray-500 uppercase"><?php echo e(__('crm.type')); ?></th>
                                <th class="px-4 py-3 text-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?> text-xs font-medium text-gray-500 uppercase"><?php echo e(__('crm.description')); ?></th>
                                <th class="px-4 py-3 text-<?php echo e(app()->getLocale() == 'ar' ? 'left' : 'right'); ?> text-xs font-medium text-gray-500 uppercase"><?php echo e(__('crm.amount')); ?></th>
                                <th class="px-4 py-3 text-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?> text-xs font-medium text-gray-500 uppercase"><?php echo e(__('crm.status')); ?></th>
                                <th class="px-4 py-3 text-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?> text-xs font-medium text-gray-500 uppercase"><?php echo e(__('crm.date')); ?></th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php $__currentLoopData = $walletTransactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3">
                                    <a href="<?php echo e(route('admin.clients.wallet.transaction', [$invoice->client, $transaction->id])); ?>" 
                                       class="text-sm font-mono text-blue-600 hover:text-blue-800 hover:underline">
                                        <?php echo e($transaction->reference ?? $transaction->transaction_reference ?? '#' . $transaction->id); ?>

                                    </a>
                                </td>
                                <td class="px-4 py-3">
                                    <?php if($transaction->type == 'deposit'): ?>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <?php echo e(__('crm.deposit')); ?>

                                        </span>
                                    <?php elseif($transaction->type == 'deduction'): ?>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800">
                                            <?php echo e(__('crm.deduction')); ?>

                                        </span>
                                    <?php elseif($transaction->type == 'withdrawal'): ?>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            <?php echo e(__('crm.withdrawal')); ?>

                                        </span>
                                    <?php elseif($transaction->type == 'refund'): ?>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            <?php echo e(__('crm.refund')); ?>

                                        </span>
                                    <?php else: ?>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            <?php echo e(ucfirst($transaction->type ?? 'Unknown')); ?>

                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-900">
                                    <?php
                                        $desc = $transaction->description;
                                        if (empty($desc) && $transaction->metadata) {
                                            $meta = is_string($transaction->metadata) ? json_decode($transaction->metadata, true) : $transaction->metadata;
                                            $desc = $meta['description'] ?? null;
                                        }
                                    ?>
                                    <?php echo e($desc ?? '-'); ?>

                                </td>
                                <td class="px-4 py-3 text-<?php echo e(app()->getLocale() == 'ar' ? 'left' : 'right'); ?> text-sm font-medium <?php echo e($transaction->amount >= 0 ? 'text-green-600' : 'text-red-600'); ?>">
                                    <?php echo e($transaction->amount >= 0 ? '+' : ''); ?>$<?php echo e(number_format(abs($transaction->amount), 2)); ?>

                                </td>
                                <td class="px-4 py-3">
                                    <?php if($transaction->status == 'completed'): ?>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <?php echo e(__('crm.completed')); ?>

                                        </span>
                                    <?php elseif($transaction->status == 'pending'): ?>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            <?php echo e(__('crm.pending')); ?>

                                        </span>
                                    <?php else: ?>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            <?php echo e(ucfirst($transaction->status ?? 'Unknown')); ?>

                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-500">
                                    <?php echo e($transaction->created_at?->format('Y-m-d H:i') ?? '-'); ?>

                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <!-- Footer -->
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
            <div class="flex justify-between items-center flex-wrap gap-3">
                <a href="<?php echo e(route('admin.clients.wallet', $invoice->client)); ?>" class="inline-flex items-center gap-2 text-sm text-gray-600 hover:text-gray-900">
                    <svg class="w-4 h-4 rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    <?php echo e(__('crm.back_to_wallet')); ?>

                </a>
                
                <a href="<?php echo e(route('admin.clients.show', $invoice->client)); ?>" class="inline-flex items-center gap-2 text-sm text-blue-600 hover:text-blue-800">
                    <?php echo e(__('crm.view_client')); ?>

                    <svg class="w-4 h-4 rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\resources\views/admin/invoices/show.blade.php ENDPATH**/ ?>