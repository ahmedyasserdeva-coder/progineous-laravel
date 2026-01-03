@php
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
@endphp
<x-mail::message>
<div style="direction: {{ $direction }}; text-align: {{ $textAlign }}; font-family: {{ $fontFamily }};">
{{-- Logo & Header --}}
<div style="text-align: center; padding-bottom: 25px; border-bottom: 2px solid #e2e8f0; margin-bottom: 25px;">
<img src="{{ config('app.url') }}/logo/pro%20Gineous_logo.svg" alt="{{ config('app.name') }}" width="160" height="auto" style="max-width: 160px; height: auto; margin-bottom: 20px;">
<h1 style="color: #dc2626; font-size: 26px; font-weight: 700; margin: 0; text-align: center;">{{ $isRtl ? 'إشعار تعليق الخدمة' : 'Service Suspension Notice' }}</h1>
<p style="color: #718096; font-size: 15px; margin-top: 10px; margin-bottom: 0; text-align: center;">{{ $isRtl ? 'تم تعليق خدمتك مؤقتاً' : 'Your service has been temporarily suspended' }}</p>
</div>

{{-- Greeting --}}
<p style="font-size: 15px; color: #4a5568; line-height: 1.6; text-align: {{ $textAlign }};">
{{ $isRtl ? 'عزيزي' : 'Dear' }} <strong>{{ $client->first_name }}</strong>,
</p>

<p style="font-size: 15px; color: #4a5568; line-height: 1.6; text-align: {{ $textAlign }};">
{{ $isRtl ? 'نود إبلاغك بأنه تم تعليق الخدمة التالية على حسابك.' : 'We would like to inform you that the following service on your account has been suspended.' }}
</p>

{{-- Suspension Info Badge --}}
<div style="background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%); border-radius: 12px; padding: 20px; margin: 25px 0; color: #ffffff; direction: {{ $direction }};">
<table style="width: 100%; border-collapse: collapse;" cellpadding="0" cellspacing="0" dir="{{ $direction }}">
<tr>
@if($isRtl)
<td style="vertical-align: middle; padding: 5px 10px; text-align: right; width: 50%;">
<p style="margin: 0; font-size: 13px; opacity: 0.9; text-align: right;">اسم الخدمة</p>
<p style="margin: 5px 0 0 0; font-size: 20px; font-weight: 700; text-align: right;">{{ $service->service_name }}</p>
</td>
<td style="vertical-align: middle; padding: 5px 10px; text-align: left; width: 50%;">
<p style="margin: 0; font-size: 13px; opacity: 0.9; text-align: left;">تاريخ التعليق</p>
<p style="margin: 5px 0 0 0; font-size: 20px; font-weight: 700; text-align: left;" dir="ltr">{{ now()->format('M d, Y') }}</p>
</td>
@else
<td style="vertical-align: middle; padding: 5px 10px; text-align: left; width: 50%;">
<p style="margin: 0; font-size: 13px; opacity: 0.9;">Service Name</p>
<p style="margin: 5px 0 0 0; font-size: 20px; font-weight: 700;">{{ $service->service_name }}</p>
</td>
<td style="vertical-align: middle; padding: 5px 10px; text-align: right; width: 50%;">
<p style="margin: 0; font-size: 13px; opacity: 0.9;">Suspension Date</p>
<p style="margin: 5px 0 0 0; font-size: 20px; font-weight: 700;">{{ now()->format('M d, Y') }}</p>
</td>
@endif
</tr>
</table>
</div>

{{-- Service Details --}}
<div style="margin: 30px 0;">
<h2 style="color: #1a202c; font-size: 16px; font-weight: 600; margin: 0 0 15px 0; padding-bottom: 10px; border-bottom: 1px solid #e2e8f0; text-align: {{ $textAlign }};">{{ $isRtl ? 'تفاصيل الخدمة' : 'Service Details' }}</h2>
<table style="width: 100%; font-size: 14px; direction: {{ $direction }};">
<tr>
<td style="padding: 10px 0; color: #718096; border-bottom: 1px solid #f0f0f0; text-align: {{ $textAlign }};">{{ $isRtl ? 'النطاق' : 'Domain' }}</td>
<td style="padding: 10px 0; text-align: {{ $textAlignOpposite }}; color: #1a202c; font-weight: 500; border-bottom: 1px solid #f0f0f0;" dir="ltr">{{ $service->domain ?? '-' }}</td>
</tr>
<tr>
<td style="padding: 10px 0; color: #718096; border-bottom: 1px solid #f0f0f0; text-align: {{ $textAlign }};">{{ $isRtl ? 'اسم المستخدم' : 'Username' }}</td>
<td style="padding: 10px 0; text-align: {{ $textAlignOpposite }}; color: #1a202c; border-bottom: 1px solid #f0f0f0;" dir="ltr">{{ $service->username ?? '-' }}</td>
</tr>
<tr>
<td style="padding: 10px 0; color: #718096; border-bottom: 1px solid #f0f0f0; text-align: {{ $textAlign }};">{{ $isRtl ? 'سبب التعليق' : 'Suspension Reason' }}</td>
<td style="padding: 10px 0; text-align: {{ $textAlignOpposite }};">
<span style="background-color: #fecaca; color: #991b1b; padding: 5px 14px; border-radius: 20px; font-size: 12px; font-weight: 600;">{{ $displayReason }}</span>
</td>
</tr>
<tr>
<td style="padding: 10px 0; color: #718096; text-align: {{ $textAlign }};">{{ $isRtl ? 'الحالة' : 'Status' }}</td>
<td style="padding: 10px 0; text-align: {{ $textAlignOpposite }};">
<span style="background-color: #fef3c7; color: #92400e; padding: 5px 14px; border-radius: 20px; font-size: 12px; font-weight: 600; text-transform: uppercase;">{{ $isRtl ? 'معلق' : 'SUSPENDED' }}</span>
</td>
</tr>
</table>
</div>

{{-- Next Steps --}}
<div style="margin: 30px 0;">
<h2 style="color: #1a202c; font-size: 16px; font-weight: 600; margin: 0 0 15px 0; padding-bottom: 10px; border-bottom: 1px solid #e2e8f0; text-align: {{ $textAlign }};">{{ $isRtl ? 'الخطوات التالية' : 'Next Steps' }}</h2>

<p style="font-size: 15px; color: #4a5568; line-height: 1.6; text-align: {{ $textAlign }};">
@if($isPaymentIssue)
{{ $isRtl ? 'لإعادة تفعيل خدمتك، يرجى تسوية الفواتير المستحقة من خلال لوحة التحكم الخاصة بك.' : 'To reactivate your service, please settle your outstanding invoices through your client area.' }}
@else
{{ $isRtl ? 'يرجى التواصل مع فريق الدعم الفني لمناقشة هذا الأمر وإعادة تفعيل خدمتك.' : 'Please contact our support team to discuss this matter and reactivate your service.' }}
@endif
</p>
</div>

{{-- Action Button --}}
<div style="text-align: center; margin: 35px 0;">
@if($isPaymentIssue)
<x-mail::button :url="route('client.invoices')" color="primary">
{{ $isRtl ? 'عرض الفواتير المستحقة' : 'View Outstanding Invoices' }}
</x-mail::button>
@else
<x-mail::button :url="route('client.dashboard')" color="primary">
{{ $isRtl ? 'التواصل مع الدعم' : 'Contact Support' }}
</x-mail::button>
@endif
</div>

{{-- Warning Box --}}
<div style="background-color: #fef2f2; border: 1px solid #fecaca; border-radius: 10px; padding: 20px; margin: 25px 0; text-align: {{ $textAlign }};">
<p style="margin: 0 0 10px 0; font-size: 15px; color: #991b1b; font-weight: 600; text-align: {{ $textAlign }};">{{ $isRtl ? 'تنبيه مهم' : 'Important Notice' }}</p>
<p style="margin: 0; font-size: 13px; color: #7f1d1d; line-height: 1.6; text-align: {{ $textAlign }};">{{ $isRtl ? 'إذا كنت تعتقد أن هذا التعليق تم بالخطأ، يرجى التواصل معنا فوراً. بياناتك محفوظة ولن يتم حذفها فوراً.' : 'If you believe this suspension was made in error, please contact us immediately. Your data is preserved and will not be deleted immediately.' }}</p>
</div>

{{-- Footer --}}
<div style="text-align: center; padding-top: 25px; border-top: 1px solid #e2e8f0; margin-top: 30px;">
<p style="color: #718096; font-size: 13px; margin: 0 0 15px 0; text-align: center;">{{ $isRtl ? 'إذا كان لديك أي استفسارات، لا تتردد في التواصل مع فريق الدعم.' : 'If you have any questions, please don\'t hesitate to contact our support team.' }}</p>

{{-- Signature --}}
<div style="margin: 20px 0; text-align: center;">
<p style="color: #4a5568; font-size: 14px; margin: 0; text-align: center;">{{ $isRtl ? 'مع التحية' : 'Best regards' }},</p>
<p style="color: #1d71b8; font-size: 15px; font-weight: 600; margin: 8px 0 3px 0; text-align: center;">{{ $isRtl ? 'فريق دعم العملاء' : 'Customer Support Team' }}</p>
<p style="color: #1a202c; font-size: 14px; font-weight: 700; margin: 0; text-align: center;">{{ config('app.name') }}</p>
</div>

{{-- Company Info --}}
<div style="background-color: #f8fafc; border-radius: 8px; padding: 20px; margin-top: 20px; direction: {{ $direction }};">
<p style="margin: 0 0 15px 0; font-size: 13px; color: #1a202c; font-weight: 700; text-align: center;">{{ config('app.name') }}</p>

{{-- Contact --}}
<div style="text-align: center; padding-top: 10px;">
<p style="margin: 0 0 12px 0; font-size: 11px; color: #64748b; text-align: center;" dir="ltr">
<a href="mailto:support@progineous.com" style="color: #1d71b8; text-decoration: none;">support@progineous.com</a>
&nbsp;|&nbsp;
<a href="https://progineous.com" style="color: #1d71b8; text-decoration: none;">progineous.com</a>
</p>

{{-- Social Media Links --}}
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
</div>{{-- End RTL wrapper --}}

<x-mail::subcopy>
<div style="direction: {{ $direction }}; text-align: center;">
{{ $isRtl ? 'الخدمة' : 'Service' }}: {{ $service->service_name }} | {{ $isRtl ? 'سبب التعليق' : 'Reason' }}: {{ $displayReason }}
</div>
</x-mail::subcopy>
</x-mail::message>
