<?php
    $currentLocale = $locale ?? app()->getLocale();
    $isRtl = $currentLocale === 'ar';
    $direction = $isRtl ? 'rtl' : 'ltr';
    $textAlign = $isRtl ? 'right' : 'left';
    $textAlignOpposite = $isRtl ? 'left' : 'right';
    $fontFamily = $isRtl ? "'Segoe UI', Tahoma, Arial, sans-serif" : "'Segoe UI', Tahoma, Geneva, Verdana, sans-serif";
    
    $reasonsMap = [
        'Non-payment' => 'عدم الدفع',
        'Invoice Overdue' => 'تجاوز موعد دفع الفاتورة',
        'Terms of Service Violation' => 'مخالفة شروط الخدمة',
        'Abuse/Spam' => 'إساءة استخدام',
        'Security Issue' => 'مشكلة أمنية',
        'Resource Overuse' => 'استهلاك زائد للموارد',
        'Client Request' => 'طلب العميل',
        'Fraudulent Activity' => 'نشاط احتيالي',
        'Administrative Action' => 'إجراء إداري',
    ];
    
    $displayReason = $isRtl ? ($reasonsMap[$reason] ?? $reason) : $reason;
    $isPaymentIssue = in_array($reason, ['Non-payment', 'Invoice Overdue']);
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
<h1 style="color: #dc2626; font-size: 26px; font-weight: 700; margin: 0; text-align: center;"><?php echo new \Illuminate\Support\EncodedHtmlString($isRtl ? 'إشعار تعليق الخدمة' : 'Service Suspension Notice'); ?></h1>
<p style="color: #718096; font-size: 15px; margin-top: 10px; margin-bottom: 0; text-align: center;"><?php echo new \Illuminate\Support\EncodedHtmlString($isRtl ? 'تم تعليق خدمتك مؤقتاً' : 'Your service has been temporarily suspended'); ?></p>
</div>


<p style="font-size: 15px; color: #4a5568; line-height: 1.6; text-align: <?php echo new \Illuminate\Support\EncodedHtmlString($textAlign); ?>;">
<?php echo new \Illuminate\Support\EncodedHtmlString($isRtl ? 'عزيزي' : 'Dear'); ?> <strong><?php echo new \Illuminate\Support\EncodedHtmlString($client->first_name); ?></strong>,
</p>

<p style="font-size: 15px; color: #4a5568; line-height: 1.6; text-align: <?php echo new \Illuminate\Support\EncodedHtmlString($textAlign); ?>;">
<?php echo new \Illuminate\Support\EncodedHtmlString($isRtl ? 'نود إبلاغك بأنه تم تعليق الخدمة التالية على حسابك.' : 'We would like to inform you that the following service on your account has been suspended.'); ?>

</p>


<div style="background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%); border-radius: 12px; padding: 20px; margin: 25px 0; color: #ffffff; direction: <?php echo new \Illuminate\Support\EncodedHtmlString($direction); ?>;">
<table style="width: 100%; border-collapse: collapse;" cellpadding="0" cellspacing="0" dir="<?php echo new \Illuminate\Support\EncodedHtmlString($direction); ?>">
<tr>
<?php if($isRtl): ?>
<td style="vertical-align: middle; padding: 5px 10px; text-align: right; width: 50%;">
<p style="margin: 0; font-size: 13px; opacity: 0.9; text-align: right;">اسم الخدمة</p>
<p style="margin: 5px 0 0 0; font-size: 20px; font-weight: 700; text-align: right;"><?php echo new \Illuminate\Support\EncodedHtmlString($service->service_name); ?></p>
</td>
<td style="vertical-align: middle; padding: 5px 10px; text-align: left; width: 50%;">
<p style="margin: 0; font-size: 13px; opacity: 0.9; text-align: left;">تاريخ التعليق</p>
<p style="margin: 5px 0 0 0; font-size: 20px; font-weight: 700; text-align: left;" dir="ltr"><?php echo new \Illuminate\Support\EncodedHtmlString(now()->format('M d, Y')); ?></p>
</td>
<?php else: ?>
<td style="vertical-align: middle; padding: 5px 10px; text-align: left; width: 50%;">
<p style="margin: 0; font-size: 13px; opacity: 0.9;">Service Name</p>
<p style="margin: 5px 0 0 0; font-size: 20px; font-weight: 700;"><?php echo new \Illuminate\Support\EncodedHtmlString($service->service_name); ?></p>
</td>
<td style="vertical-align: middle; padding: 5px 10px; text-align: right; width: 50%;">
<p style="margin: 0; font-size: 13px; opacity: 0.9;">Suspension Date</p>
<p style="margin: 5px 0 0 0; font-size: 20px; font-weight: 700;"><?php echo new \Illuminate\Support\EncodedHtmlString(now()->format('M d, Y')); ?></p>
</td>
<?php endif; ?>
</tr>
</table>
</div>


<div style="margin: 30px 0;">
<h2 style="color: #1a202c; font-size: 16px; font-weight: 600; margin: 0 0 15px 0; padding-bottom: 10px; border-bottom: 1px solid #e2e8f0; text-align: <?php echo new \Illuminate\Support\EncodedHtmlString($textAlign); ?>;"><?php echo new \Illuminate\Support\EncodedHtmlString($isRtl ? 'تفاصيل الخدمة' : 'Service Details'); ?></h2>
<table style="width: 100%; font-size: 14px; direction: <?php echo new \Illuminate\Support\EncodedHtmlString($direction); ?>;">
<tr>
<td style="padding: 10px 0; color: #718096; border-bottom: 1px solid #f0f0f0; text-align: <?php echo new \Illuminate\Support\EncodedHtmlString($textAlign); ?>;"><?php echo new \Illuminate\Support\EncodedHtmlString($isRtl ? 'النطاق' : 'Domain'); ?></td>
<td style="padding: 10px 0; text-align: <?php echo new \Illuminate\Support\EncodedHtmlString($textAlignOpposite); ?>; color: #1a202c; font-weight: 500; border-bottom: 1px solid #f0f0f0;" dir="ltr"><?php echo new \Illuminate\Support\EncodedHtmlString($service->domain ?? '-'); ?></td>
</tr>
<tr>
<td style="padding: 10px 0; color: #718096; border-bottom: 1px solid #f0f0f0; text-align: <?php echo new \Illuminate\Support\EncodedHtmlString($textAlign); ?>;"><?php echo new \Illuminate\Support\EncodedHtmlString($isRtl ? 'اسم المستخدم' : 'Username'); ?></td>
<td style="padding: 10px 0; text-align: <?php echo new \Illuminate\Support\EncodedHtmlString($textAlignOpposite); ?>; color: #1a202c; border-bottom: 1px solid #f0f0f0;" dir="ltr"><?php echo new \Illuminate\Support\EncodedHtmlString($service->username ?? '-'); ?></td>
</tr>
<tr>
<td style="padding: 10px 0; color: #718096; border-bottom: 1px solid #f0f0f0; text-align: <?php echo new \Illuminate\Support\EncodedHtmlString($textAlign); ?>;"><?php echo new \Illuminate\Support\EncodedHtmlString($isRtl ? 'سبب التعليق' : 'Suspension Reason'); ?></td>
<td style="padding: 10px 0; text-align: <?php echo new \Illuminate\Support\EncodedHtmlString($textAlignOpposite); ?>;">
<span style="background-color: #fecaca; color: #991b1b; padding: 5px 14px; border-radius: 20px; font-size: 12px; font-weight: 600;"><?php echo new \Illuminate\Support\EncodedHtmlString($displayReason); ?></span>
</td>
</tr>
<tr>
<td style="padding: 10px 0; color: #718096; text-align: <?php echo new \Illuminate\Support\EncodedHtmlString($textAlign); ?>;"><?php echo new \Illuminate\Support\EncodedHtmlString($isRtl ? 'الحالة' : 'Status'); ?></td>
<td style="padding: 10px 0; text-align: <?php echo new \Illuminate\Support\EncodedHtmlString($textAlignOpposite); ?>;">
<span style="background-color: #fef3c7; color: #92400e; padding: 5px 14px; border-radius: 20px; font-size: 12px; font-weight: 600; text-transform: uppercase;"><?php echo new \Illuminate\Support\EncodedHtmlString($isRtl ? 'معلق' : 'SUSPENDED'); ?></span>
</td>
</tr>
</table>
</div>


<div style="margin: 30px 0;">
<h2 style="color: #1a202c; font-size: 16px; font-weight: 600; margin: 0 0 15px 0; padding-bottom: 10px; border-bottom: 1px solid #e2e8f0; text-align: <?php echo new \Illuminate\Support\EncodedHtmlString($textAlign); ?>;"><?php echo new \Illuminate\Support\EncodedHtmlString($isRtl ? 'الخطوات التالية' : 'Next Steps'); ?></h2>

<p style="font-size: 15px; color: #4a5568; line-height: 1.6; text-align: <?php echo new \Illuminate\Support\EncodedHtmlString($textAlign); ?>;">
<?php if($isPaymentIssue): ?>
<?php echo new \Illuminate\Support\EncodedHtmlString($isRtl ? 'لإعادة تفعيل خدمتك، يرجى تسوية الفواتير المستحقة من خلال لوحة التحكم الخاصة بك.' : 'To reactivate your service, please settle your outstanding invoices through your client area.'); ?>

<?php else: ?>
<?php echo new \Illuminate\Support\EncodedHtmlString($isRtl ? 'يرجى التواصل مع فريق الدعم الفني لمناقشة هذا الأمر وإعادة تفعيل خدمتك.' : 'Please contact our support team to discuss this matter and reactivate your service.'); ?>

<?php endif; ?>
</p>
</div>


<div style="text-align: center; margin: 35px 0;">
<?php if($isPaymentIssue): ?>
<?php if (isset($component)) { $__componentOriginal15a5e11357468b3880ae1300c3be6c4f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal15a5e11357468b3880ae1300c3be6c4f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => $__env->getContainer()->make(Illuminate\View\Factory::class)->make('mail::button'),'data' => ['url' => route('client.invoices'),'color' => 'primary']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('mail::button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['url' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('client.invoices')),'color' => 'primary']); ?>
<?php echo new \Illuminate\Support\EncodedHtmlString($isRtl ? 'عرض الفواتير المستحقة' : 'View Outstanding Invoices'); ?>

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
<?php else: ?>
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
<?php echo new \Illuminate\Support\EncodedHtmlString($isRtl ? 'التواصل مع الدعم' : 'Contact Support'); ?>

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
<?php endif; ?>
</div>


<div style="background-color: #fef2f2; border: 1px solid #fecaca; border-radius: 10px; padding: 20px; margin: 25px 0; text-align: <?php echo new \Illuminate\Support\EncodedHtmlString($textAlign); ?>;">
<p style="margin: 0 0 10px 0; font-size: 15px; color: #991b1b; font-weight: 600; text-align: <?php echo new \Illuminate\Support\EncodedHtmlString($textAlign); ?>;"><?php echo new \Illuminate\Support\EncodedHtmlString($isRtl ? 'تنبيه مهم' : 'Important Notice'); ?></p>
<p style="margin: 0; font-size: 13px; color: #7f1d1d; line-height: 1.6; text-align: <?php echo new \Illuminate\Support\EncodedHtmlString($textAlign); ?>;"><?php echo new \Illuminate\Support\EncodedHtmlString($isRtl ? 'إذا كنت تعتقد أن هذا التعليق تم بالخطأ، يرجى التواصل معنا فوراً. بياناتك محفوظة ولن يتم حذفها فوراً.' : 'If you believe this suspension was made in error, please contact us immediately. Your data is preserved and will not be deleted immediately.'); ?></p>
</div>


<div style="text-align: center; padding-top: 25px; border-top: 1px solid #e2e8f0; margin-top: 30px;">
<p style="color: #718096; font-size: 13px; margin: 0 0 15px 0; text-align: center;"><?php echo new \Illuminate\Support\EncodedHtmlString($isRtl ? 'إذا كان لديك أي استفسارات، لا تتردد في التواصل مع فريق الدعم.' : 'If you have any questions, please don\'t hesitate to contact our support team.'); ?></p>


<div style="margin: 20px 0; text-align: center;">
<p style="color: #4a5568; font-size: 14px; margin: 0; text-align: center;"><?php echo new \Illuminate\Support\EncodedHtmlString($isRtl ? 'مع التحية' : 'Best regards'); ?>,</p>
<p style="color: #1d71b8; font-size: 15px; font-weight: 600; margin: 8px 0 3px 0; text-align: center;"><?php echo new \Illuminate\Support\EncodedHtmlString($isRtl ? 'فريق دعم العملاء' : 'Customer Support Team'); ?></p>
<p style="color: #1a202c; font-size: 14px; font-weight: 700; margin: 0; text-align: center;"><?php echo new \Illuminate\Support\EncodedHtmlString(config('app.name')); ?></p>
</div>


<div style="background-color: #f8fafc; border-radius: 8px; padding: 20px; margin-top: 20px; direction: <?php echo new \Illuminate\Support\EncodedHtmlString($direction); ?>;">
<p style="margin: 0 0 15px 0; font-size: 13px; color: #1a202c; font-weight: 700; text-align: center;"><?php echo new \Illuminate\Support\EncodedHtmlString(config('app.name')); ?></p>


<div style="text-align: center; padding-top: 10px;">
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
<?php echo new \Illuminate\Support\EncodedHtmlString($isRtl ? 'الخدمة' : 'Service'); ?>: <?php echo new \Illuminate\Support\EncodedHtmlString($service->service_name); ?> | <?php echo new \Illuminate\Support\EncodedHtmlString($isRtl ? 'سبب التعليق' : 'Reason'); ?>: <?php echo new \Illuminate\Support\EncodedHtmlString($displayReason); ?>

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
<?php /**PATH C:\laragon\www\resources\views/emails/service-suspended.blade.php ENDPATH**/ ?>