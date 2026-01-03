@php
    $currentLocale = $locale ?? app()->getLocale();
    $isRtl = $currentLocale === 'ar';
    $direction = $isRtl ? 'rtl' : 'ltr';
    $textAlign = $isRtl ? 'right' : 'left';
    $textAlignOpposite = $isRtl ? 'left' : 'right';
    $fontFamily = $isRtl ? "'Segoe UI', Tahoma, Arial, sans-serif" : "'Segoe UI', Tahoma, Geneva, Verdana, sans-serif";
@endphp
<x-mail::message>
<div style="direction: {{ $direction }}; text-align: {{ $textAlign }}; font-family: {{ $fontFamily }};">
{{-- Logo & Header --}}
<div style="text-align: center; padding-bottom: 25px; border-bottom: 2px solid #e2e8f0; margin-bottom: 25px;">
<img src="{{ config('app.url') }}/logo/pro%20Gineous_logo.svg" alt="{{ config('app.name') }}" width="160" height="auto" style="max-width: 160px; height: auto; margin-bottom: 20px;">
<h1 style="color: #059669; font-size: 26px; font-weight: 700; margin: 0; text-align: center;">{{ $isRtl ? 'تم إعادة تفعيل الخدمة' : 'Service Reactivated' }}</h1>
<p style="color: #718096; font-size: 15px; margin-top: 10px; margin-bottom: 0; text-align: center;">{{ $isRtl ? 'خدمتك أصبحت نشطة الآن' : 'Your service is now active' }}</p>
</div>

{{-- Greeting --}}
<p style="font-size: 15px; color: #4a5568; line-height: 1.6; text-align: {{ $textAlign }};">
{{ $isRtl ? 'عزيزي' : 'Dear' }} <strong>{{ $client->first_name }}</strong>,
</p>

<p style="font-size: 15px; color: #4a5568; line-height: 1.6; text-align: {{ $textAlign }};">
{{ $isRtl ? 'يسعدنا إبلاغك بأنه تم إعادة تفعيل خدمتك بنجاح.' : 'We are pleased to inform you that your service has been successfully reactivated.' }}
</p>

{{-- Success Info Badge --}}
<div style="background: linear-gradient(135deg, #059669 0%, #047857 100%); border-radius: 12px; padding: 20px; margin: 25px 0; color: #ffffff; direction: {{ $direction }};">
<table style="width: 100%; border-collapse: collapse;" cellpadding="0" cellspacing="0" dir="{{ $direction }}">
<tr>
@if($isRtl)
<td style="vertical-align: middle; padding: 5px 10px; text-align: right; width: 50%;">
<p style="margin: 0; font-size: 13px; opacity: 0.9; text-align: right;">اسم الخدمة</p>
<p style="margin: 5px 0 0 0; font-size: 20px; font-weight: 700; text-align: right;">{{ $service->service_name }}</p>
</td>
<td style="vertical-align: middle; padding: 5px 10px; text-align: left; width: 50%;">
<p style="margin: 0; font-size: 13px; opacity: 0.9; text-align: left;">الحالة</p>
<p style="margin: 5px 0 0 0; font-size: 20px; font-weight: 700; text-align: left;">نشطة</p>
</td>
@else
<td style="vertical-align: middle; padding: 5px 10px; text-align: left; width: 50%;">
<p style="margin: 0; font-size: 13px; opacity: 0.9;">Service Name</p>
<p style="margin: 5px 0 0 0; font-size: 20px; font-weight: 700;">{{ $service->service_name }}</p>
</td>
<td style="vertical-align: middle; padding: 5px 10px; text-align: right; width: 50%;">
<p style="margin: 0; font-size: 13px; opacity: 0.9;">Status</p>
<p style="margin: 5px 0 0 0; font-size: 20px; font-weight: 700;">Active</p>
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
<td style="padding: 10px 0; color: #718096; border-bottom: 1px solid #f0f0f0; text-align: {{ $textAlign }};">{{ $isRtl ? 'تاريخ التفعيل' : 'Activation Date' }}</td>
<td style="padding: 10px 0; text-align: {{ $textAlignOpposite }}; color: #1a202c; border-bottom: 1px solid #f0f0f0;" dir="ltr">{{ now()->format('M d, Y - H:i') }}</td>
</tr>
<tr>
<td style="padding: 10px 0; color: #718096; text-align: {{ $textAlign }};">{{ $isRtl ? 'الحالة' : 'Status' }}</td>
<td style="padding: 10px 0; text-align: {{ $textAlignOpposite }};">
<span style="background-color: #d1fae5; color: #065f46; padding: 5px 14px; border-radius: 20px; font-size: 12px; font-weight: 600; text-transform: uppercase;">{{ $isRtl ? 'نشطة' : 'ACTIVE' }}</span>
</td>
</tr>
</table>
</div>

{{-- What's Next --}}
<div style="margin: 30px 0;">
<h2 style="color: #1a202c; font-size: 16px; font-weight: 600; margin: 0 0 15px 0; padding-bottom: 10px; border-bottom: 1px solid #e2e8f0; text-align: {{ $textAlign }};">{{ $isRtl ? 'ماذا بعد؟' : 'What\'s Next?' }}</h2>

<p style="font-size: 15px; color: #4a5568; line-height: 1.6; text-align: {{ $textAlign }};">
{{ $isRtl ? 'خدمتك الآن نشطة بالكامل. يمكنك الوصول إلى جميع الميزات والخدمات كالمعتاد.' : 'Your service is now fully active. You can access all features and services as usual.' }}
</p>
</div>

{{-- Action Button --}}
<div style="text-align: center; margin: 35px 0;">
<x-mail::button :url="route('client.dashboard')" color="success">
{{ $isRtl ? 'الذهاب إلى لوحة التحكم' : 'Go to Dashboard' }}
</x-mail::button>
</div>

{{-- Info Box --}}
<div style="background-color: #ecfdf5; border: 1px solid #a7f3d0; border-radius: 10px; padding: 20px; margin: 25px 0; text-align: {{ $textAlign }};">
<p style="margin: 0 0 10px 0; font-size: 15px; color: #065f46; font-weight: 600; text-align: {{ $textAlign }};">{{ $isRtl ? 'شكراً لك' : 'Thank You' }}</p>
<p style="margin: 0; font-size: 13px; color: #047857; line-height: 1.6; text-align: {{ $textAlign }};">{{ $isRtl ? 'نشكرك على ثقتك بنا. إذا كان لديك أي استفسارات، فريق الدعم متاح لمساعدتك.' : 'Thank you for your continued trust in us. If you have any questions, our support team is available to assist you.' }}</p>
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
{{ $isRtl ? 'الخدمة' : 'Service' }}: {{ $service->service_name }} | {{ $isRtl ? 'الحالة' : 'Status' }}: {{ $isRtl ? 'نشطة' : 'Active' }}
</div>
</x-mail::subcopy>
</x-mail::message>
