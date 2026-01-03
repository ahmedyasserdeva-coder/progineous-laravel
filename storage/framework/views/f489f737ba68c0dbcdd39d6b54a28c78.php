<?php
    $currentLocale = $locale ?? app()->getLocale();
    $isRtl = $currentLocale === 'ar';
    $direction = $isRtl ? 'rtl' : 'ltr';
    $textAlign = $isRtl ? 'right' : 'left';
    $textAlignOpposite = $isRtl ? 'left' : 'right';
    $fontFamily = $isRtl ? "'Segoe UI', Tahoma, Arial, sans-serif" : "'Segoe UI', Tahoma, Geneva, Verdana, sans-serif";
?>
<?php if (isset($component)) { $__componentOriginalaa758e6a82983efcbf593f765e026bd9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalaa758e6a82983efcbf593f765e026bd9 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => $__env->getContainer()->make(Illuminate\View\Factory::class)->make('mail::message'),'data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('mail::message'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<div style="direction: <?php echo new \Illuminate\Support\EncodedHtmlString($direction); ?>; text-align: <?php echo new \Illuminate\Support\EncodedHtmlString($textAlign); ?>; font-family: <?php echo new \Illuminate\Support\EncodedHtmlString($fontFamily); ?>;">

<div style="text-align: center; padding-bottom: 25px; border-bottom: 2px solid #e2e8f0; margin-bottom: 25px;">
<img src="<?php echo new \Illuminate\Support\EncodedHtmlString(config('app.url')); ?>/logo/pro%20Gineous_logo.svg" alt="<?php echo new \Illuminate\Support\EncodedHtmlString(config('app.name')); ?>" width="160" height="auto" style="max-width: 160px; height: auto; margin-bottom: 20px;">
<h1 style="color: #1a202c; font-size: 26px; font-weight: 700; margin: 0; text-align: center;"><?php echo new \Illuminate\Support\EncodedHtmlString(__('emails.order_confirmed') ?? 'Order Confirmed'); ?></h1>
<p style="color: #718096; font-size: 15px; margin-top: 10px; margin-bottom: 0; text-align: center;"><?php echo new \Illuminate\Support\EncodedHtmlString(__('emails.thank_you_message') ?? 'Thank you for your purchase'); ?></p>
</div>


<p style="font-size: 15px; color: #4a5568; line-height: 1.6; text-align: <?php echo new \Illuminate\Support\EncodedHtmlString($textAlign); ?>;">
<?php echo new \Illuminate\Support\EncodedHtmlString(__('emails.dear') ?? 'Dear'); ?> <strong><?php echo new \Illuminate\Support\EncodedHtmlString($client->first_name); ?></strong>,
</p>

<p style="font-size: 15px; color: #4a5568; line-height: 1.6; text-align: <?php echo new \Illuminate\Support\EncodedHtmlString($textAlign); ?>;">
<?php echo new \Illuminate\Support\EncodedHtmlString(__('emails.thank_you_for_order') ?? 'Thank you for your order! Your payment has been received and your services are being activated.'); ?>

</p>


<div style="background: linear-gradient(135deg, #1d71b8 0%, #1a5a94 100%); border-radius: 12px; padding: 20px; margin: 25px 0; color: #ffffff; direction: <?php echo new \Illuminate\Support\EncodedHtmlString($direction); ?>;">
<table style="width: 100%; border-collapse: collapse;" cellpadding="0" cellspacing="0" dir="<?php echo new \Illuminate\Support\EncodedHtmlString($direction); ?>">
<tr>
<?php if($isRtl): ?>

<td style="vertical-align: middle; padding: 5px 10px; text-align: right; width: 50%;">
<p style="margin: 0; font-size: 13px; opacity: 0.9; text-align: right;"><?php echo new \Illuminate\Support\EncodedHtmlString(__('emails.order_number') ?? 'Order Number'); ?></p>
<p style="margin: 5px 0 0 0; font-size: 20px; font-weight: 700; text-align: right;" dir="ltr">#<?php echo new \Illuminate\Support\EncodedHtmlString($order->order_number); ?></p>
</td>
<td style="vertical-align: middle; padding: 5px 10px; text-align: left; width: 50%;">
<p style="margin: 0; font-size: 13px; opacity: 0.9; text-align: left;"><?php echo new \Illuminate\Support\EncodedHtmlString(__('emails.total') ?? 'Total'); ?></p>
<p style="margin: 5px 0 0 0; font-size: 20px; font-weight: 700; text-align: left;" dir="ltr">$<?php echo new \Illuminate\Support\EncodedHtmlString(number_format($order->total, 2)); ?></p>
</td>
<?php else: ?>

<td style="vertical-align: middle; padding: 5px 10px; text-align: left; width: 50%;">
<p style="margin: 0; font-size: 13px; opacity: 0.9;"><?php echo new \Illuminate\Support\EncodedHtmlString(__('emails.order_number') ?? 'Order Number'); ?></p>
<p style="margin: 5px 0 0 0; font-size: 20px; font-weight: 700;">#<?php echo new \Illuminate\Support\EncodedHtmlString($order->order_number); ?></p>
</td>
<td style="vertical-align: middle; padding: 5px 10px; text-align: right; width: 50%;">
<p style="margin: 0; font-size: 13px; opacity: 0.9;"><?php echo new \Illuminate\Support\EncodedHtmlString(__('emails.total') ?? 'Total'); ?></p>
<p style="margin: 5px 0 0 0; font-size: 20px; font-weight: 700;">$<?php echo new \Illuminate\Support\EncodedHtmlString(number_format($order->total, 2)); ?></p>
</td>
<?php endif; ?>
</tr>
</table>
</div>


<div style="margin: 30px 0;">
<h2 style="color: #1a202c; font-size: 16px; font-weight: 600; margin: 0 0 15px 0; padding-bottom: 10px; border-bottom: 1px solid #e2e8f0; text-align: <?php echo new \Illuminate\Support\EncodedHtmlString($textAlign); ?>;"><?php echo new \Illuminate\Support\EncodedHtmlString(__('emails.order_details') ?? 'Order Details'); ?></h2>
<table style="width: 100%; font-size: 14px; direction: <?php echo new \Illuminate\Support\EncodedHtmlString($direction); ?>;">
<tr>
<td style="padding: 10px 0; color: #718096; border-bottom: 1px solid #f0f0f0; text-align: <?php echo new \Illuminate\Support\EncodedHtmlString($textAlign); ?>;"><?php echo new \Illuminate\Support\EncodedHtmlString(__('emails.invoice_number') ?? 'Invoice Number'); ?></td>
<td style="padding: 10px 0; text-align: <?php echo new \Illuminate\Support\EncodedHtmlString($textAlignOpposite); ?>; color: #1a202c; font-weight: 500; border-bottom: 1px solid #f0f0f0;">#<?php echo new \Illuminate\Support\EncodedHtmlString($invoice->invoice_number); ?></td>
</tr>
<tr>
<td style="padding: 10px 0; color: #718096; border-bottom: 1px solid #f0f0f0; text-align: <?php echo new \Illuminate\Support\EncodedHtmlString($textAlign); ?>;"><?php echo new \Illuminate\Support\EncodedHtmlString(__('emails.order_date') ?? 'Order Date'); ?></td>
<td style="padding: 10px 0; text-align: <?php echo new \Illuminate\Support\EncodedHtmlString($textAlignOpposite); ?>; color: #1a202c; border-bottom: 1px solid #f0f0f0;"><?php echo new \Illuminate\Support\EncodedHtmlString($order->created_at->format('F d, Y')); ?></td>
</tr>
<tr>
<td style="padding: 10px 0; color: #718096; border-bottom: 1px solid #f0f0f0; text-align: <?php echo new \Illuminate\Support\EncodedHtmlString($textAlign); ?>;"><?php echo new \Illuminate\Support\EncodedHtmlString(__('emails.payment_method') ?? 'Payment Method'); ?></td>
<td style="padding: 10px 0; text-align: <?php echo new \Illuminate\Support\EncodedHtmlString($textAlignOpposite); ?>; color: #1a202c; border-bottom: 1px solid #f0f0f0;"><?php echo new \Illuminate\Support\EncodedHtmlString(__('emails.payment_methods.' . strtolower($order->payment_method ?? 'na')) ?? ucfirst($order->payment_method ?? 'N/A')); ?></td>
</tr>
<tr>
<td style="padding: 10px 0; color: #718096; text-align: <?php echo new \Illuminate\Support\EncodedHtmlString($textAlign); ?>;"><?php echo new \Illuminate\Support\EncodedHtmlString(__('emails.payment_status') ?? 'Payment Status'); ?></td>
<td style="padding: 10px 0; text-align: <?php echo new \Illuminate\Support\EncodedHtmlString($textAlignOpposite); ?>;">
<span style="background-color: #c6f6d5; color: #22543d; padding: 5px 14px; border-radius: 20px; font-size: 12px; font-weight: 600; text-transform: uppercase;"><?php echo new \Illuminate\Support\EncodedHtmlString(__('emails.payment_statuses.' . strtolower($order->payment_status ?? 'pending')) ?? $order->payment_status); ?></span>
</td>
</tr>
</table>
</div>


<div style="margin: 30px 0; direction: <?php echo new \Illuminate\Support\EncodedHtmlString($direction); ?>;">
<h2 style="color: #1a202c; font-size: 16px; font-weight: 600; margin: 0 0 15px 0; padding-bottom: 10px; border-bottom: 1px solid #e2e8f0; text-align: <?php echo new \Illuminate\Support\EncodedHtmlString($textAlign); ?>;"><?php echo new \Illuminate\Support\EncodedHtmlString(__('emails.purchased_items') ?? 'Purchased Items'); ?></h2>

<?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div style="padding: 15px; background-color: #f8fafc; border-radius: 8px; margin-bottom: 10px; direction: <?php echo new \Illuminate\Support\EncodedHtmlString($direction); ?>;">
<table style="width: 100%;" dir="<?php echo new \Illuminate\Support\EncodedHtmlString($direction); ?>">
<tr>
<?php if($isRtl): ?>

<td style="vertical-align: top; text-align: right; width: 70%;">
<p style="margin: 0; font-weight: 600; color: #1a202c; font-size: 14px; text-align: right;"><?php echo new \Illuminate\Support\EncodedHtmlString(__('emails.product_names.' . strtolower($item->product_name)) !== 'emails.product_names.' . strtolower($item->product_name) ? __('emails.product_names.' . strtolower($item->product_name)) : $item->product_name); ?></p>
<?php if(isset($item->configuration['domain'])): ?>
<p style="margin: 5px 0 0 0; color: #718096; font-size: 13px; text-align: right;" dir="ltr"><?php echo new \Illuminate\Support\EncodedHtmlString($item->configuration['domain']); ?></p>
<?php endif; ?>
</td>
<td style="text-align: left; vertical-align: top; width: 30%;">
<p style="margin: 0; font-weight: 700; color: #1a202c; font-size: 15px; text-align: left;" dir="ltr">$<?php echo new \Illuminate\Support\EncodedHtmlString(number_format($item->total, 2)); ?></p>
</td>
<?php else: ?>

<td style="vertical-align: top; text-align: left; width: 70%;">
<p style="margin: 0; font-weight: 600; color: #1a202c; font-size: 14px;"><?php echo new \Illuminate\Support\EncodedHtmlString(__('emails.product_names.' . strtolower($item->product_name)) !== 'emails.product_names.' . strtolower($item->product_name) ? __('emails.product_names.' . strtolower($item->product_name)) : $item->product_name); ?></p>
<?php if(isset($item->configuration['domain'])): ?>
<p style="margin: 5px 0 0 0; color: #718096; font-size: 13px;"><?php echo new \Illuminate\Support\EncodedHtmlString($item->configuration['domain']); ?></p>
<?php endif; ?>
</td>
<td style="text-align: right; vertical-align: top; width: 30%;">
<p style="margin: 0; font-weight: 700; color: #1a202c; font-size: 15px;">$<?php echo new \Illuminate\Support\EncodedHtmlString(number_format($item->total, 2)); ?></p>
</td>
<?php endif; ?>
</tr>
</table>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>

<?php if($services->count() > 0): ?>

<div style="margin: 30px 0;">
<h2 style="color: #1a202c; font-size: 16px; font-weight: 600; margin: 0 0 15px 0; padding-bottom: 10px; border-bottom: 1px solid #e2e8f0; text-align: <?php echo new \Illuminate\Support\EncodedHtmlString($textAlign); ?>;"><?php echo new \Illuminate\Support\EncodedHtmlString(__('emails.your_services') ?? 'Your Services'); ?></h2>

<?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div style="border: 1px solid #e2e8f0; border-radius: 10px; padding: 18px; margin-bottom: 12px;">
<table style="width: 100%; direction: <?php echo new \Illuminate\Support\EncodedHtmlString($direction); ?>;">
<tr>
<td style="text-align: <?php echo new \Illuminate\Support\EncodedHtmlString($textAlign); ?>;">
<span style="font-weight: 600; color: #1a202c; font-size: 15px;"><?php echo new \Illuminate\Support\EncodedHtmlString($service->service_name); ?></span>
</td>
<td style="text-align: <?php echo new \Illuminate\Support\EncodedHtmlString($textAlignOpposite); ?>;">
<span style="background-color: <?php echo new \Illuminate\Support\EncodedHtmlString($service->status === 'active' ? '#c6f6d5' : '#fef3c7'); ?>; color: <?php echo new \Illuminate\Support\EncodedHtmlString($service->status === 'active' ? '#22543d' : '#92400e'); ?>; padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 600; text-transform: uppercase;"><?php echo new \Illuminate\Support\EncodedHtmlString($service->status); ?></span>
</td>
</tr>
</table>

<div style="margin-top: 12px; padding-top: 12px; border-top: 1px dashed #e2e8f0;">
<table style="width: 100%; font-size: 13px; direction: <?php echo new \Illuminate\Support\EncodedHtmlString($direction); ?>;">
<?php if($service->getDomainName()): ?>
<tr>
<td style="padding: 4px 0; color: #718096; width: 40%; text-align: <?php echo new \Illuminate\Support\EncodedHtmlString($textAlign); ?>;"><?php echo new \Illuminate\Support\EncodedHtmlString(__('emails.domain') ?? 'Domain'); ?></td>
<td style="padding: 4px 0; color: #4a5568; font-weight: 500; text-align: <?php echo new \Illuminate\Support\EncodedHtmlString($textAlignOpposite); ?>;"><?php echo new \Illuminate\Support\EncodedHtmlString($service->getDomainName()); ?></td>
</tr>
<?php endif; ?>
<?php if($service->next_due_date): ?>
<tr>
<td style="padding: 4px 0; color: #718096; text-align: <?php echo new \Illuminate\Support\EncodedHtmlString($textAlign); ?>;"><?php echo new \Illuminate\Support\EncodedHtmlString(__('emails.next_renewal') ?? 'Next Renewal'); ?></td>
<td style="padding: 4px 0; color: #4a5568; text-align: <?php echo new \Illuminate\Support\EncodedHtmlString($textAlignOpposite); ?>;"><?php echo new \Illuminate\Support\EncodedHtmlString($service->next_due_date->format('F d, Y')); ?></td>
</tr>
<?php endif; ?>
<?php if($service->billing_cycle): ?>
<tr>
<td style="padding: 4px 0; color: #718096; text-align: <?php echo new \Illuminate\Support\EncodedHtmlString($textAlign); ?>;"><?php echo new \Illuminate\Support\EncodedHtmlString(__('emails.billing_cycle') ?? 'Billing Cycle'); ?></td>
<td style="padding: 4px 0; color: #4a5568; text-align: <?php echo new \Illuminate\Support\EncodedHtmlString($textAlignOpposite); ?>;"><?php echo new \Illuminate\Support\EncodedHtmlString(ucfirst($service->billing_cycle)); ?></td>
</tr>
<?php endif; ?>
</table>
</div>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<?php endif; ?>


<p style="font-size: 15px; color: #4a5568; line-height: 1.6; margin-top: 25px; text-align: <?php echo new \Illuminate\Support\EncodedHtmlString($textAlign); ?>;">
<?php if($services->where('type', 'hosting')->count() > 0 || $services->where('type', 'cloud_hosting')->count() > 0): ?>
<?php echo new \Illuminate\Support\EncodedHtmlString(__('emails.hosting_credentials') ?? 'Your hosting account credentials will be sent in a separate email once your service is activated.'); ?>

<?php endif; ?>
<?php echo new \Illuminate\Support\EncodedHtmlString(__('emails.manage_services') ?? 'You can manage your services from your client dashboard.'); ?>

</p>


<div style="text-align: center; margin: 35px 0;">
<?php if (isset($component)) { $__componentOriginal15a5e11357468b3880ae1300c3be6c4f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal15a5e11357468b3880ae1300c3be6c4f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => $__env->getContainer()->make(Illuminate\View\Factory::class)->make('mail::button'),'data' => ['url' => route('client.dashboard'),'color' => 'primary']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('mail::button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['url' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('client.dashboard')),'color' => 'primary']); ?>
<?php echo new \Illuminate\Support\EncodedHtmlString(__('emails.go_to_dashboard') ?? 'Go to Dashboard'); ?>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal15a5e11357468b3880ae1300c3be6c4f)): ?>
<?php $attributes = $__attributesOriginal15a5e11357468b3880ae1300c3be6c4f; ?>
<?php unset($__attributesOriginal15a5e11357468b3880ae1300c3be6c4f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal15a5e11357468b3880ae1300c3be6c4f)): ?>
<?php $component = $__componentOriginal15a5e11357468b3880ae1300c3be6c4f; ?>
<?php unset($__componentOriginal15a5e11357468b3880ae1300c3be6c4f); ?>
<?php endif; ?>
</div>


<div style="background-color: #fffbeb; border: 1px solid #fbbf24; border-radius: 10px; padding: 20px; margin: 25px 0; text-align: center;">
<p style="margin: 0 0 10px 0; font-size: 15px; color: #92400e; font-weight: 600; text-align: center;"><?php echo new \Illuminate\Support\EncodedHtmlString(__('emails.rate_experience') ?? 'How was your experience?'); ?></p>
<p style="margin: 0 0 15px 0; font-size: 13px; color: #a16207; text-align: center;"><?php echo new \Illuminate\Support\EncodedHtmlString(__('emails.rate_experience_desc') ?? 'Your feedback helps us improve our services.'); ?></p>
<a href="<?php echo new \Illuminate\Support\EncodedHtmlString(route('payment.success', $order->id)); ?>#rating" style="display: inline-block; background-color: #f59e0b; color: #ffffff; padding: 10px 25px; border-radius: 6px; text-decoration: none; font-size: 14px; font-weight: 600;"><?php echo new \Illuminate\Support\EncodedHtmlString(__('emails.rate_now') ?? 'Rate Now'); ?></a>
</div>


<div style="text-align: center; padding-top: 25px; border-top: 1px solid #e2e8f0; margin-top: 30px;">
<p style="color: #718096; font-size: 13px; margin: 0 0 15px 0; text-align: center;"><?php echo new \Illuminate\Support\EncodedHtmlString(__('emails.questions') ?? 'If you have any questions, please don\'t hesitate to contact our support team.'); ?></p>


<div style="margin: 20px 0; text-align: center;">
<p style="color: #4a5568; font-size: 14px; margin: 0; text-align: center;"><?php echo new \Illuminate\Support\EncodedHtmlString(__('emails.best_regards') ?? 'Best regards'); ?>,</p>
<p style="color: #1d71b8; font-size: 15px; font-weight: 600; margin: 8px 0 3px 0; text-align: center;"><?php echo new \Illuminate\Support\EncodedHtmlString(__('emails.customer_success_team') ?? 'Customer Success Team'); ?></p>
<p style="color: #1a202c; font-size: 14px; font-weight: 700; margin: 0; text-align: center;"><?php echo new \Illuminate\Support\EncodedHtmlString(config('app.name')); ?></p>
</div>


<div style="background-color: #f8fafc; border-radius: 8px; padding: 20px; margin-top: 20px; direction: <?php echo new \Illuminate\Support\EncodedHtmlString($direction); ?>;">
<p style="margin: 0 0 15px 0; font-size: 13px; color: #1a202c; font-weight: 700; text-align: center;"><?php echo new \Illuminate\Support\EncodedHtmlString(config('app.name')); ?></p>


<div style="margin-bottom: 15px; padding-bottom: 15px; border-bottom: 1px solid #e2e8f0; text-align: <?php echo new \Illuminate\Support\EncodedHtmlString($textAlign); ?>;">
<p style="margin: 0 0 5px 0; font-size: 11px; color: #1d71b8; font-weight: 600; text-align: <?php echo new \Illuminate\Support\EncodedHtmlString($textAlign); ?>;"><?php echo new \Illuminate\Support\EncodedHtmlString(__('emails.uk_office') ?? 'UK Office'); ?></p>
<p style="margin: 0 0 3px 0; font-size: 11px; color: #64748b; line-height: 1.5; text-align: <?php echo new \Illuminate\Support\EncodedHtmlString($textAlign); ?>;" dir="ltr">71-75, Shelton Street, Covent Garden, London, WC2H 9JQ, United Kingdom</p>
<p style="margin: 0; font-size: 10px; color: #94a3b8; text-align: <?php echo new \Illuminate\Support\EncodedHtmlString($textAlign); ?>;"><?php echo new \Illuminate\Support\EncodedHtmlString(__('emails.reg_number') ?? 'Reg. No'); ?>: <span dir="ltr">16307182</span></p>
</div>


<div style="margin-bottom: 15px; text-align: <?php echo new \Illuminate\Support\EncodedHtmlString($textAlign); ?>;">
<p style="margin: 0 0 5px 0; font-size: 11px; color: #1d71b8; font-weight: 600; text-align: <?php echo new \Illuminate\Support\EncodedHtmlString($textAlign); ?>;"><?php echo new \Illuminate\Support\EncodedHtmlString(__('emails.egypt_office') ?? 'Egypt Office'); ?></p>
<p style="margin: 0 0 3px 0; font-size: 11px; color: #64748b; line-height: 1.5; text-align: <?php echo new \Illuminate\Support\EncodedHtmlString($textAlign); ?>;" dir="ltr">Bani Waldin Ihsanan Tower - 3rd Floor, Mostafa Kamel Street, Beni Suef Center, Beni Suef Governorate</p>
<p style="margin: 0 0 2px 0; font-size: 10px; color: #94a3b8; text-align: <?php echo new \Illuminate\Support\EncodedHtmlString($textAlign); ?>;"><?php echo new \Illuminate\Support\EncodedHtmlString(__('emails.reg_number') ?? 'Reg. No'); ?>: <span dir="ltr">90088</span></p>
<p style="margin: 0; font-size: 10px; color: #94a3b8; text-align: <?php echo new \Illuminate\Support\EncodedHtmlString($textAlign); ?>;"><?php echo new \Illuminate\Support\EncodedHtmlString(__('emails.tax_number') ?? 'Tax Reg. No'); ?>: <span dir="ltr">755-552-334</span></p>
</div>


<div style="text-align: center; padding-top: 10px; border-top: 1px solid #e2e8f0;">
<p style="margin: 0 0 12px 0; font-size: 11px; color: #64748b; text-align: center;" dir="ltr">
<a href="mailto:support@progineous.com" style="color: #1d71b8; text-decoration: none;">support@progineous.com</a>
&nbsp;|&nbsp;
<a href="https://progineous.com" style="color: #1d71b8; text-decoration: none;">progineous.com</a>
</p>


<div style="margin-top: 10px;">

<a href="https://facebook.com/progineous" target="_blank" style="display: inline-block; margin: 0 6px; text-decoration: none;">
<img src="https://cdn-icons-png.flaticon.com/24/733/733547.png" alt="Facebook" width="22" height="22" style="border: 0; vertical-align: middle;">
</a>

<a href="https://x.com/progineous" target="_blank" style="display: inline-block; margin: 0 6px; text-decoration: none;">
<img src="https://cdn-icons-png.flaticon.com/24/5968/5968830.png" alt="X" width="22" height="22" style="border: 0; vertical-align: middle;">
</a>

<a href="https://uk.linkedin.com/company/progineous" target="_blank" style="display: inline-block; margin: 0 6px; text-decoration: none;">
<img src="https://cdn-icons-png.flaticon.com/24/733/733561.png" alt="LinkedIn" width="22" height="22" style="border: 0; vertical-align: middle;">
</a>

<a href="https://instagram.com/progineous" target="_blank" style="display: inline-block; margin: 0 6px; text-decoration: none;">
<img src="https://cdn-icons-png.flaticon.com/24/2111/2111463.png" alt="Instagram" width="22" height="22" style="border: 0; vertical-align: middle;">
</a>

<a href="https://wa.me/201070798859" target="_blank" style="display: inline-block; margin: 0 6px; text-decoration: none;">
<img src="https://cdn-icons-png.flaticon.com/24/733/733585.png" alt="WhatsApp" width="22" height="22" style="border: 0; vertical-align: middle;">
</a>
</div>


<div style="margin-top: 20px; padding-top: 15px; border-top: 1px solid #e2e8f0;">
<table cellpadding="0" cellspacing="0" border="0" style="margin: 0 auto;">
<tr>

<td style="padding: 0 10px; text-align: center;">
<img src="<?php echo new \Illuminate\Support\EncodedHtmlString(asset('assets/images/letsencrypt-svgrepo-com.svg')); ?>" alt="SSL" width="28" height="28" style="border: 0;">
</td>

<td style="padding: 0 10px; text-align: center;">
<img src="<?php echo new \Illuminate\Support\EncodedHtmlString(asset('assets/images/dollar-secure-payment-svgrepo-com.svg')); ?>" alt="Secure" width="28" height="28" style="border: 0;">
</td>

<td style="padding: 0 10px; text-align: center;">
<img src="<?php echo new \Illuminate\Support\EncodedHtmlString(asset('assets/images/24-hours-support-svgrepo-com.svg')); ?>" alt="Support" width="28" height="28" style="border: 0;">
</td>

<td style="padding: 0 10px; text-align: center;">
<img src="<?php echo new \Illuminate\Support\EncodedHtmlString(asset('assets/images/guarantee-svgrepo-com.svg')); ?>" alt="Guarantee" width="28" height="28" style="border: 0;">
</td>

<td style="padding: 0 10px; text-align: center;">
<img src="<?php echo new \Illuminate\Support\EncodedHtmlString(asset('assets/images/icann-ar21.svg')); ?>" alt="ICANN" width="60" height="28" style="border: 0;">
</td>
</tr>
</table>
</div>
</div>
</div>
</div>
</div>

<?php if (isset($component)) { $__componentOriginala95a089fc4dac0df2b807f0c4d49e8b5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala95a089fc4dac0df2b807f0c4d49e8b5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => $__env->getContainer()->make(Illuminate\View\Factory::class)->make('mail::subcopy'),'data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('mail::subcopy'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<div style="direction: <?php echo new \Illuminate\Support\EncodedHtmlString($direction); ?>; text-align: center;">
<?php echo new \Illuminate\Support\EncodedHtmlString(__('emails.order_reference') ?? 'Order Reference'); ?>: <span dir="ltr">#<?php echo new \Illuminate\Support\EncodedHtmlString($order->order_number); ?></span> | <?php echo new \Illuminate\Support\EncodedHtmlString(__('emails.invoice_reference') ?? 'Invoice'); ?>: <span dir="ltr">#<?php echo new \Illuminate\Support\EncodedHtmlString($invoice->invoice_number); ?></span>
</div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala95a089fc4dac0df2b807f0c4d49e8b5)): ?>
<?php $attributes = $__attributesOriginala95a089fc4dac0df2b807f0c4d49e8b5; ?>
<?php unset($__attributesOriginala95a089fc4dac0df2b807f0c4d49e8b5); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala95a089fc4dac0df2b807f0c4d49e8b5)): ?>
<?php $component = $__componentOriginala95a089fc4dac0df2b807f0c4d49e8b5; ?>
<?php unset($__componentOriginala95a089fc4dac0df2b807f0c4d49e8b5); ?>
<?php endif; ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalaa758e6a82983efcbf593f765e026bd9)): ?>
<?php $attributes = $__attributesOriginalaa758e6a82983efcbf593f765e026bd9; ?>
<?php unset($__attributesOriginalaa758e6a82983efcbf593f765e026bd9); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalaa758e6a82983efcbf593f765e026bd9)): ?>
<?php $component = $__componentOriginalaa758e6a82983efcbf593f765e026bd9; ?>
<?php unset($__componentOriginalaa758e6a82983efcbf593f765e026bd9); ?>
<?php endif; ?>
<?php /**PATH C:\laragon\www\resources\views/emails/order-confirmation.blade.php ENDPATH**/ ?>