

<?php $__env->startSection('title', __('frontend.order_success') ?? 'Order Success'); ?>

<?php $__env->startSection('content'); ?>
<section class="py-8 md:py-12">
    <div class="w-full max-w-2xl mx-auto">
        
        <!-- Success Card -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 overflow-hidden shadow-sm">
            
            <!-- Success Header -->
            <div class="relative px-6 pt-8 pb-6 text-center border-b border-slate-100 dark:border-slate-700/50">
                <!-- Decorative Background -->
                <div class="absolute inset-0 bg-gradient-to-b from-green-50 to-transparent dark:from-green-900/10 dark:to-transparent"></div>
                
                <div class="relative">
                    <!-- Success Icon -->
                    <div class="inline-flex items-center justify-center w-14 h-14 bg-green-500 rounded-full mb-4 shadow-lg shadow-green-500/25">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    
                    <h1 class="text-xl font-semibold text-slate-900 dark:text-white mb-1">
                        <?php echo e(__('frontend.order_success_title') ?? 'Payment Successful'); ?>

                    </h1>
                    <p class="text-sm text-slate-500 dark:text-slate-400">
                        <?php echo e(__('frontend.order_success_subtitle') ?? 'Your order has been confirmed'); ?>

                    </p>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="px-6 py-5">
                <!-- Order & Invoice Info -->
                <div class="flex items-center justify-between text-sm mb-5 pb-5 border-b border-dashed border-slate-200 dark:border-slate-700">
                    <div class="flex items-center gap-4">
                        <div>
                            <span class="text-slate-400 dark:text-slate-500 text-xs"><?php echo e(__('frontend.order_number') ?? 'Order'); ?></span>
                            <p class="font-mono font-medium text-slate-900 dark:text-white">#<?php echo e($order->order_number); ?></p>
                        </div>
                        <div class="w-px h-8 bg-slate-200 dark:bg-slate-700"></div>
                        <div>
                            <span class="text-slate-400 dark:text-slate-500 text-xs"><?php echo e(__('frontend.invoice_number') ?? 'Invoice'); ?></span>
                            <div class="flex items-center gap-2">
                                <a href="<?php echo e(route('client.invoices.show', isset($targetInvoice) ? $targetInvoice->id : $order->invoice->id)); ?>" class="font-mono font-medium text-blue-600 dark:text-blue-400 hover:underline">#<?php echo e(isset($targetInvoice) ? $targetInvoice->invoice_number : $order->invoice->invoice_number); ?></a>
                                <a href="<?php echo e(route('client.invoices.download', isset($targetInvoice) ? $targetInvoice->id : $order->invoice->id)); ?>" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 transition-colors" title="<?php echo e(__('frontend.download_invoice_pdf') ?? 'Download PDF'); ?>">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="text-slate-400 dark:text-slate-500 text-xs"><?php echo e(isset($targetInvoice) ? $targetInvoice->created_at->format('M d, Y') : $order->created_at->format('M d, Y')); ?></span>
                        <div class="mt-0.5">
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium <?php echo e((isset($targetInvoice) ? $targetInvoice->status === 'paid' : $order->payment_status === 'paid') ? 'bg-green-100 text-green-700 dark:bg-green-500/20 dark:text-green-400' : 'bg-amber-100 text-amber-700 dark:bg-amber-500/20 dark:text-amber-400'); ?>">
                                <span class="w-1.5 h-1.5 rounded-full <?php echo e((isset($targetInvoice) ? $targetInvoice->status === 'paid' : $order->payment_status === 'paid') ? 'bg-green-500' : 'bg-amber-500'); ?>"></span>
                                <?php echo e(isset($targetInvoice) ? ucfirst($targetInvoice->status) : ucfirst($order->payment_status)); ?>

                            </span>
                        </div>
                    </div>
                </div>

                <!-- Order Items -->
                <div class="space-y-3 mb-5">
                    <?php if(isset($targetInvoice)): ?>
                        <div class="flex items-center justify-between py-2">
                            <span class="text-sm text-slate-700 dark:text-slate-300"><?php echo e($targetInvoice->notes); ?></span>
                            <span class="text-sm font-medium text-slate-900 dark:text-white">$<?php echo e(number_format($targetInvoice->total, 2)); ?></span>
                        </div>
                    <?php else: ?>
                        <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="flex items-start justify-between py-2">
                            <div class="flex-1 min-w-0 pe-4">
                                <p class="text-sm font-medium text-slate-900 dark:text-white"><?php echo e($item->product_name); ?></p>
                                <?php if(isset($item->configuration['domain']) || isset($item->configuration['billing_cycle'])): ?>
                                <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                                    <?php if(isset($item->configuration['domain'])): ?><?php echo e($item->configuration['domain']); ?><?php endif; ?>
                                    <?php if(isset($item->configuration['domain']) && isset($item->configuration['billing_cycle'])): ?> · <?php endif; ?>
                                    <?php if(isset($item->configuration['billing_cycle'])): ?><?php echo e(ucfirst($item->configuration['billing_cycle'])); ?><?php endif; ?>
                                </p>
                                <?php endif; ?>
                            </div>
                            <span class="text-sm font-medium text-slate-900 dark:text-white whitespace-nowrap">$<?php echo e(number_format($item->total, 2)); ?></span>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </div>

                <!-- Total -->
                <div class="flex items-center justify-between py-4 px-4 -mx-4 bg-slate-50 dark:bg-slate-900/50 rounded-xl">
                    <span class="font-medium text-slate-900 dark:text-white"><?php echo e(__('frontend.total') ?? 'Total Paid'); ?></span>
                    <span class="text-xl font-bold text-slate-900 dark:text-white">$<?php echo e(number_format(isset($targetInvoice) ? $targetInvoice->total : $order->total, 2)); ?></span>
                </div>

                <!-- Payment Method Details -->
                <?php
                    $invoice = isset($targetInvoice) ? $targetInvoice : $order->invoice;
                    $payment = $invoice->payments->first();
                    $paymentMethod = $order->payment_method;
                ?>
                <?php if($payment || $paymentMethod): ?>
                <div class="mt-4 pt-4 border-t border-dashed border-slate-200 dark:border-slate-700">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <!-- Payment Method Icon -->
                            <div class="w-10 h-10 rounded-lg bg-slate-100 dark:bg-slate-700 flex items-center justify-center">
                                <?php if($payment && str_contains(strtolower($payment->gateway), 'stripe') || $paymentMethod === 'stripe'): ?>
                                    <svg class="w-6 h-6 text-[#635BFF]" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M13.976 9.15c-2.172-.806-3.356-1.426-3.356-2.409 0-.831.683-1.305 1.901-1.305 2.227 0 4.515.858 6.09 1.631l.89-5.494C18.252.975 15.697 0 12.165 0 9.667 0 7.589.654 6.104 1.872 4.56 3.147 3.757 4.992 3.757 7.218c0 4.039 2.467 5.76 6.476 7.219 2.585.92 3.445 1.574 3.445 2.583 0 .98-.84 1.545-2.354 1.545-1.875 0-4.965-.921-6.99-2.109l-.9 5.555C5.175 22.99 8.385 24 11.714 24c2.641 0 4.843-.624 6.328-1.813 1.664-1.305 2.525-3.236 2.525-5.732 0-4.128-2.524-5.851-6.591-7.305z"/>
                                    </svg>
                                <?php elseif($payment && str_contains(strtolower($payment->gateway), 'paypal') || $paymentMethod === 'paypal'): ?>
                                    <svg class="w-6 h-6 text-[#003087]" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M7.076 21.337H2.47a.641.641 0 0 1-.633-.74L4.944.901C5.026.382 5.474 0 5.998 0h7.46c2.57 0 4.578.543 5.69 1.81 1.01 1.15 1.304 2.42 1.012 4.287-.023.143-.047.288-.077.437-.983 5.05-4.349 6.797-8.647 6.797h-2.19c-.524 0-.968.382-1.05.9l-1.12 7.106zm14.146-14.42a3.35 3.35 0 0 0-.607-.541c-.013.076-.026.175-.041.254-.93 4.778-4.005 7.201-9.138 7.201h-2.19a.563.563 0 0 0-.556.479l-1.187 7.527h-.506l-.24 1.516a.56.56 0 0 0 .554.647h3.882c.46 0 .85-.334.922-.788.06-.26.76-4.852.816-5.09a.932.932 0 0 1 .923-.788h.58c3.76 0 6.705-1.528 7.565-5.946.36-1.847.174-3.388-.777-4.471z"/>
                                    </svg>
                                <?php elseif($payment && str_contains(strtolower($payment->gateway), 'wallet') || $paymentMethod === 'wallet'): ?>
                                    <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                    </svg>
                                <?php elseif($payment && str_contains(strtolower($payment->gateway), 'fawaterak') || $paymentMethod === 'fawaterak'): ?>
                                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                <?php else: ?>
                                    <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                    </svg>
                                <?php endif; ?>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-slate-900 dark:text-white">
                                    <?php if($payment): ?>
                                        <?php echo e($payment->fawaterak_payment_method_name ?? ucfirst($payment->gateway)); ?>

                                    <?php elseif($paymentMethod === 'wallet'): ?>
                                        <?php echo e(__('frontend.wallet_balance') ?? 'Wallet Balance'); ?>

                                    <?php else: ?>
                                        <?php echo e(ucfirst($paymentMethod)); ?>

                                    <?php endif; ?>
                                </p>
                                <p class="text-xs text-slate-500 dark:text-slate-400">
                                    <?php if($payment && $payment->paid_at): ?>
                                        <?php echo e(__('frontend.paid_on') ?? 'Paid on'); ?> <?php echo e($payment->paid_at->format('M d, Y \a\t h:i A')); ?>

                                    <?php elseif($payment && $payment->transaction_id): ?>
                                        <?php echo e(__('frontend.transaction_id') ?? 'Transaction'); ?>: <?php echo e(Str::limit($payment->transaction_id, 20)); ?>

                                    <?php elseif($order->paid_at): ?>
                                        <?php echo e(__('frontend.paid_on') ?? 'Paid on'); ?> <?php echo e($order->paid_at->format('M d, Y \a\t h:i A')); ?>

                                    <?php elseif($invoice && $invoice->paid_at): ?>
                                        <?php echo e(__('frontend.paid_on') ?? 'Paid on'); ?> <?php echo e($invoice->paid_at->format('M d, Y \a\t h:i A')); ?>

                                    <?php endif; ?>
                                </p>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="inline-flex items-center gap-1 px-2 py-1 rounded-lg bg-green-100 dark:bg-green-500/20 text-xs font-medium text-green-700 dark:text-green-400">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <?php echo e(__('frontend.payment_confirmed') ?? 'Confirmed'); ?>

                            </span>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>

            <!-- Services Status -->
            <?php if($order->services->count() > 0): ?>
            <div class="px-6 py-5 border-t border-slate-100 dark:border-slate-700/50">
                <h3 class="text-xs font-semibold text-slate-400 dark:text-slate-500 uppercase tracking-wider mb-3"><?php echo e(__('frontend.your_services') ?? 'Services'); ?></h3>
                
                <div class="space-y-2">
                    <?php $__currentLoopData = $order->services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="flex items-center justify-between p-3 rounded-lg <?php echo e($service->status === 'failed' ? 'bg-red-50 dark:bg-red-900/10 border border-red-100 dark:border-red-900/30' : 'bg-slate-50 dark:bg-slate-900/30'); ?>">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="flex-shrink-0 w-8 h-8 rounded-lg flex items-center justify-center
                                <?php echo e($service->status === 'active' ? 'bg-green-100 dark:bg-green-500/20' : ''); ?>

                                <?php echo e($service->status === 'pending' ? 'bg-amber-100 dark:bg-amber-500/20' : ''); ?>

                                <?php echo e($service->status === 'failed' || $service->status === 'suspended' ? 'bg-red-100 dark:bg-red-500/20' : ''); ?>">
                                <?php if($service->status === 'active'): ?>
                                <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <?php elseif($service->status === 'pending'): ?>
                                <svg class="w-4 h-4 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <?php else: ?>
                                <svg class="w-4 h-4 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                <?php endif; ?>
                            </div>
                            <div class="min-w-0">
                                <p class="text-sm font-medium text-slate-900 dark:text-white truncate"><?php echo e($service->service_name); ?></p>
                                <?php if($service->getDomainName()): ?>
                                <p class="text-xs text-slate-500 dark:text-slate-400 truncate"><?php echo e($service->getDomainName()); ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="text-end">
                            <span class="text-xs font-medium px-2 py-1 rounded
                                <?php echo e($service->status === 'active' ? 'text-green-700 dark:text-green-400' : ''); ?>

                                <?php echo e($service->status === 'pending' ? 'text-amber-700 dark:text-amber-400' : ''); ?>

                                <?php echo e($service->status === 'failed' || $service->status === 'suspended' ? 'text-red-700 dark:text-red-400' : ''); ?>">
                                <?php echo e(ucfirst($service->status)); ?>

                            </span>
                            <?php if($service->next_due_date): ?>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                                <?php echo e(__('frontend.renews') ?? 'Renews'); ?>: <?php echo e($service->next_due_date->format('M d, Y')); ?>

                            </p>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <?php if($service->status === 'failed' && isset($service->server_data['error'])): ?>
                    <div class="ms-11 p-2 text-xs text-red-600 dark:text-red-400 bg-red-50 dark:bg-red-900/10 rounded-lg">
                        <?php
                            $errorMessage = $service->server_data['error'];
                            // Hide technical SQL errors from users
                            if (str_contains($errorMessage, 'SQLSTATE') || str_contains($errorMessage, 'SQL:') || str_contains($errorMessage, 'Integrity constraint')) {
                                $errorMessage = __('frontend.service_activation_error') ?? 'There was an issue activating this service. Our team has been notified and will resolve it shortly.';
                            }
                        ?>
                        <?php echo e($errorMessage); ?>

                    </div>
                    <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
            <?php endif; ?>

            <!-- Next Steps -->
            <div class="px-6 py-5 border-t border-slate-100 dark:border-slate-700/50 bg-slate-50/50 dark:bg-slate-900/30">
                <div class="flex items-start gap-3">
                    <div class="flex-shrink-0 w-8 h-8 rounded-full bg-blue-100 dark:bg-blue-500/20 flex items-center justify-center">
                        <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="flex-1 text-sm text-slate-600 dark:text-slate-400">
                        <p class="font-medium text-slate-900 dark:text-white mb-1"><?php echo e(__('frontend.what_next') ?? 'What\'s next?'); ?></p>
                        <p><?php echo e(__('frontend.confirmation_email_sent') ?? 'A confirmation email has been sent to your inbox with all order details.'); ?></p>
                    </div>
                </div>
            </div>

            <!-- Rating Section -->
            <?php
                $existingRating = \App\Models\OrderRating::where('order_id', $order->id)->where('category', 'checkout')->first();
            ?>
            <div class="px-6 py-5 border-t border-slate-100 dark:border-slate-700/50" id="rating-section">
                <div class="text-center">
                    <p class="text-sm font-medium text-slate-900 dark:text-white mb-1"><?php echo e(__('frontend.rate_experience') ?? 'How was your checkout experience?'); ?></p>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mb-4"><?php echo e(__('frontend.rate_experience_desc') ?? 'Your feedback helps us improve'); ?></p>
                    
                    <!-- Star Rating -->
                    <div class="flex items-center justify-center gap-1 mb-3" id="star-rating">
                        <?php for($i = 1; $i <= 5; $i++): ?>
                        <button type="button" 
                                class="star-btn p-1 transition-all duration-200 hover:scale-110 focus:outline-none <?php echo e($existingRating && $existingRating->rating >= $i ? 'text-amber-400' : 'text-slate-300 dark:text-slate-600'); ?>"
                                data-rating="<?php echo e($i); ?>"
                                <?php echo e($existingRating ? 'disabled' : ''); ?>>
                            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        </button>
                        <?php endfor; ?>
                    </div>

                    <!-- Rating Labels -->
                    <p class="text-xs text-slate-500 dark:text-slate-400 mb-3" id="rating-label">
                        <?php if($existingRating): ?>
                            <?php echo e(__('frontend.you_rated') ?? 'You rated'); ?>: <span class="font-medium text-amber-500"><?php echo e($existingRating->rating); ?>/5</span>
                        <?php else: ?>
                            <?php echo e(__('frontend.click_to_rate') ?? 'Click to rate'); ?>

                        <?php endif; ?>
                    </p>

                    <!-- Feedback Form (hidden by default) -->
                    <?php if(!$existingRating): ?>
                    <div id="feedback-form" class="hidden mt-4">
                        <textarea id="feedback-text" 
                                  class="w-full px-3 py-2 text-sm border border-slate-200 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none"
                                  rows="2"
                                  placeholder="<?php echo e(__('frontend.feedback_placeholder') ?? 'Tell us more about your experience (optional)'); ?>"></textarea>
                        <button type="button" 
                                id="submit-rating-btn"
                                class="mt-3 inline-flex items-center justify-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <?php echo e(__('frontend.submit_rating') ?? 'Submit Rating'); ?>

                        </button>
                    </div>
                    <?php else: ?>
                    <!-- Show existing feedback -->
                    <?php if($existingRating->feedback): ?>
                    <div class="mt-2 p-3 bg-slate-100 dark:bg-slate-700/50 rounded-lg text-start">
                        <p class="text-xs text-slate-500 dark:text-slate-400 mb-1"><?php echo e(__('frontend.your_feedback') ?? 'Your feedback'); ?>:</p>
                        <p class="text-sm text-slate-700 dark:text-slate-300"><?php echo e($existingRating->feedback); ?></p>
                    </div>
                    <?php endif; ?>
                    <p class="text-xs text-green-600 dark:text-green-400 mt-2">
                        <svg class="w-4 h-4 inline-block me-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <?php echo e(__('frontend.thanks_for_rating') ?? 'Thank you for your feedback!'); ?>

                    </p>
                    <?php endif; ?>

                    <!-- Success Message (hidden) -->
                    <div id="rating-success" class="hidden mt-3">
                        <p class="text-sm text-green-600 dark:text-green-400">
                            <svg class="w-4 h-4 inline-block me-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <?php echo e(__('frontend.thanks_for_rating') ?? 'Thank you for your feedback!'); ?>

                        </p>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="px-6 py-5 border-t border-slate-200 dark:border-slate-700 flex flex-col sm:flex-row gap-3">
                <a href="<?php echo e(route('client.dashboard')); ?>" class="flex-1 inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-slate-900 dark:bg-white hover:bg-slate-800 dark:hover:bg-slate-100 text-white dark:text-slate-900 text-sm font-medium rounded-lg transition-colors">
                    <?php echo e(__('frontend.go_to_dashboard') ?? 'Go to Dashboard'); ?>

                    <svg class="w-4 h-4 rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                    </svg>
                </a>
                <a href="<?php echo e($order->services->count() === 1 ? $order->services->first()->getViewUrl() : route('client.hosting.index')); ?>" class="flex-1 inline-flex items-center justify-center gap-2 px-5 py-2.5 text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700/50 text-sm font-medium rounded-lg transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2"></path>
                    </svg>
                    <?php echo e(__('frontend.view_services') ?? 'View Services'); ?>

                </a>
            </div>
        </div>

    </div>
</section>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const starButtons = document.querySelectorAll('.star-btn:not([disabled])');
    const feedbackForm = document.getElementById('feedback-form');
    const submitBtn = document.getElementById('submit-rating-btn');
    const ratingLabel = document.getElementById('rating-label');
    const ratingSuccess = document.getElementById('rating-success');
    let selectedRating = 0;

    const ratingLabels = {
        1: '<?php echo e(__("frontend.rating_very_poor") ?? "Very Poor"); ?>',
        2: '<?php echo e(__("frontend.rating_poor") ?? "Poor"); ?>',
        3: '<?php echo e(__("frontend.rating_average") ?? "Average"); ?>',
        4: '<?php echo e(__("frontend.rating_good") ?? "Good"); ?>',
        5: '<?php echo e(__("frontend.rating_excellent") ?? "Excellent"); ?>'
    };

    // Star hover and click handling
    starButtons.forEach((btn, index) => {
        btn.addEventListener('mouseenter', function() {
            highlightStars(index + 1);
        });

        btn.addEventListener('mouseleave', function() {
            highlightStars(selectedRating);
        });

        btn.addEventListener('click', function() {
            selectedRating = parseInt(this.dataset.rating);
            highlightStars(selectedRating);
            ratingLabel.innerHTML = ratingLabels[selectedRating] + ' <span class="text-amber-500">(' + selectedRating + '/5)</span>';
            
            // Show feedback form
            if (feedbackForm) {
                feedbackForm.classList.remove('hidden');
            }
        });
    });

    function highlightStars(count) {
        starButtons.forEach((btn, index) => {
            if (index < count) {
                btn.classList.remove('text-slate-300', 'dark:text-slate-600');
                btn.classList.add('text-amber-400');
            } else {
                btn.classList.remove('text-amber-400');
                btn.classList.add('text-slate-300', 'dark:text-slate-600');
            }
        });
    }

    // Submit rating
    if (submitBtn) {
        submitBtn.addEventListener('click', async function() {
            if (selectedRating === 0) return;

            const feedbackText = document.getElementById('feedback-text')?.value || '';
            
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> <?php echo e(__("frontend.submitting") ?? "Submitting..."); ?>';

            try {
                const response = await fetch('<?php echo e(route("order.rating.store", $order->id)); ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        rating: selectedRating,
                        feedback: feedbackText,
                        category: 'checkout'
                    })
                });

                const data = await response.json();

                if (data.success) {
                    // Hide form and show success
                    feedbackForm.classList.add('hidden');
                    ratingSuccess.classList.remove('hidden');
                    
                    // Disable stars
                    starButtons.forEach(btn => {
                        btn.disabled = true;
                        btn.classList.add('cursor-default');
                    });
                } else {
                    alert(data.message || '<?php echo e(__("frontend.error_occurred") ?? "An error occurred"); ?>');
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> <?php echo e(__("frontend.submit_rating") ?? "Submit Rating"); ?>';
                }
            } catch (error) {
                console.error('Error:', error);
                alert('<?php echo e(__("frontend.error_occurred") ?? "An error occurred"); ?>');
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> <?php echo e(__("frontend.submit_rating") ?? "Submit Rating"); ?>';
            }
        });
    }
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.client.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\resources\views/frontend/client/order-success.blade.php ENDPATH**/ ?>