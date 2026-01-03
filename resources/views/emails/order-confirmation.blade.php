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
<h1 style="color: #1a202c; font-size: 26px; font-weight: 700; margin: 0; text-align: center;">{{ __('emails.order_confirmed') ?? 'Order Confirmed' }}</h1>
<p style="color: #718096; font-size: 15px; margin-top: 10px; margin-bottom: 0; text-align: center;">{{ __('emails.thank_you_message') ?? 'Thank you for your purchase' }}</p>
</div>

{{-- Greeting --}}
<p style="font-size: 15px; color: #4a5568; line-height: 1.6; text-align: {{ $textAlign }};">
{{ __('emails.dear') ?? 'Dear' }} <strong>{{ $client->first_name }}</strong>,
</p>

<p style="font-size: 15px; color: #4a5568; line-height: 1.6; text-align: {{ $textAlign }};">
{{ __('emails.thank_you_for_order') ?? 'Thank you for your order! Your payment has been received and your services are being activated.' }}
</p>

{{-- Order Info Badge --}}
<div style="background: linear-gradient(135deg, #1d71b8 0%, #1a5a94 100%); border-radius: 12px; padding: 20px; margin: 25px 0; color: #ffffff; direction: {{ $direction }};">
<table style="width: 100%; border-collapse: collapse;" cellpadding="0" cellspacing="0" dir="{{ $direction }}">
<tr>
@if($isRtl)
{{-- RTL: الإجمالي على اليمين، رقم الطلب على اليسار --}}
<td style="vertical-align: middle; padding: 5px 10px; text-align: right; width: 50%;">
<p style="margin: 0; font-size: 13px; opacity: 0.9; text-align: right;">{{ __('emails.order_number') ?? 'Order Number' }}</p>
<p style="margin: 5px 0 0 0; font-size: 20px; font-weight: 700; text-align: right;" dir="ltr">#{{ $order->order_number }}</p>
</td>
<td style="vertical-align: middle; padding: 5px 10px; text-align: left; width: 50%;">
<p style="margin: 0; font-size: 13px; opacity: 0.9; text-align: left;">{{ __('emails.total') ?? 'Total' }}</p>
<p style="margin: 5px 0 0 0; font-size: 20px; font-weight: 700; text-align: left;" dir="ltr">${{ number_format($order->total, 2) }}</p>
</td>
@else
{{-- LTR: رقم الطلب على اليسار، الإجمالي على اليمين --}}
<td style="vertical-align: middle; padding: 5px 10px; text-align: left; width: 50%;">
<p style="margin: 0; font-size: 13px; opacity: 0.9;">{{ __('emails.order_number') ?? 'Order Number' }}</p>
<p style="margin: 5px 0 0 0; font-size: 20px; font-weight: 700;">#{{ $order->order_number }}</p>
</td>
<td style="vertical-align: middle; padding: 5px 10px; text-align: right; width: 50%;">
<p style="margin: 0; font-size: 13px; opacity: 0.9;">{{ __('emails.total') ?? 'Total' }}</p>
<p style="margin: 5px 0 0 0; font-size: 20px; font-weight: 700;">${{ number_format($order->total, 2) }}</p>
</td>
@endif
</tr>
</table>
</div>

{{-- Order Details --}}
<div style="margin: 30px 0;">
<h2 style="color: #1a202c; font-size: 16px; font-weight: 600; margin: 0 0 15px 0; padding-bottom: 10px; border-bottom: 1px solid #e2e8f0; text-align: {{ $textAlign }};">{{ __('emails.order_details') ?? 'Order Details' }}</h2>
<table style="width: 100%; font-size: 14px; direction: {{ $direction }};">
<tr>
<td style="padding: 10px 0; color: #718096; border-bottom: 1px solid #f0f0f0; text-align: {{ $textAlign }};">{{ __('emails.invoice_number') ?? 'Invoice Number' }}</td>
<td style="padding: 10px 0; text-align: {{ $textAlignOpposite }}; color: #1a202c; font-weight: 500; border-bottom: 1px solid #f0f0f0;">#{{ $invoice->invoice_number }}</td>
</tr>
<tr>
<td style="padding: 10px 0; color: #718096; border-bottom: 1px solid #f0f0f0; text-align: {{ $textAlign }};">{{ __('emails.order_date') ?? 'Order Date' }}</td>
<td style="padding: 10px 0; text-align: {{ $textAlignOpposite }}; color: #1a202c; border-bottom: 1px solid #f0f0f0;">{{ $order->created_at->format('F d, Y') }}</td>
</tr>
<tr>
<td style="padding: 10px 0; color: #718096; border-bottom: 1px solid #f0f0f0; text-align: {{ $textAlign }};">{{ __('emails.payment_method') ?? 'Payment Method' }}</td>
<td style="padding: 10px 0; text-align: {{ $textAlignOpposite }}; color: #1a202c; border-bottom: 1px solid #f0f0f0;">{{ __('emails.payment_methods.' . strtolower($order->payment_method ?? 'na')) ?? ucfirst($order->payment_method ?? 'N/A') }}</td>
</tr>
<tr>
<td style="padding: 10px 0; color: #718096; text-align: {{ $textAlign }};">{{ __('emails.payment_status') ?? 'Payment Status' }}</td>
<td style="padding: 10px 0; text-align: {{ $textAlignOpposite }};">
<span style="background-color: #c6f6d5; color: #22543d; padding: 5px 14px; border-radius: 20px; font-size: 12px; font-weight: 600; text-transform: uppercase;">{{ __('emails.payment_statuses.' . strtolower($order->payment_status ?? 'pending')) ?? $order->payment_status }}</span>
</td>
</tr>
</table>
</div>

{{-- Purchased Items --}}
<div style="margin: 30px 0; direction: {{ $direction }};">
<h2 style="color: #1a202c; font-size: 16px; font-weight: 600; margin: 0 0 15px 0; padding-bottom: 10px; border-bottom: 1px solid #e2e8f0; text-align: {{ $textAlign }};">{{ __('emails.purchased_items') ?? 'Purchased Items' }}</h2>

@foreach($items as $item)
<div style="padding: 15px; background-color: #f8fafc; border-radius: 8px; margin-bottom: 10px; direction: {{ $direction }};">
<table style="width: 100%;" dir="{{ $direction }}">
<tr>
@if($isRtl)
{{-- RTL: اسم المنتج على اليمين، السعر على اليسار --}}
<td style="vertical-align: top; text-align: right; width: 70%;">
<p style="margin: 0; font-weight: 600; color: #1a202c; font-size: 14px; text-align: right;">{{ __('emails.product_names.' . strtolower($item->product_name)) !== 'emails.product_names.' . strtolower($item->product_name) ? __('emails.product_names.' . strtolower($item->product_name)) : $item->product_name }}</p>
@if(isset($item->configuration['domain']))
<p style="margin: 5px 0 0 0; color: #718096; font-size: 13px; text-align: right;" dir="ltr">{{ $item->configuration['domain'] }}</p>
@endif
</td>
<td style="text-align: left; vertical-align: top; width: 30%;">
<p style="margin: 0; font-weight: 700; color: #1a202c; font-size: 15px; text-align: left;" dir="ltr">${{ number_format($item->total, 2) }}</p>
</td>
@else
{{-- LTR: Product name on left, price on right --}}
<td style="vertical-align: top; text-align: left; width: 70%;">
<p style="margin: 0; font-weight: 600; color: #1a202c; font-size: 14px;">{{ __('emails.product_names.' . strtolower($item->product_name)) !== 'emails.product_names.' . strtolower($item->product_name) ? __('emails.product_names.' . strtolower($item->product_name)) : $item->product_name }}</p>
@if(isset($item->configuration['domain']))
<p style="margin: 5px 0 0 0; color: #718096; font-size: 13px;">{{ $item->configuration['domain'] }}</p>
@endif
</td>
<td style="text-align: right; vertical-align: top; width: 30%;">
<p style="margin: 0; font-weight: 700; color: #1a202c; font-size: 15px;">${{ number_format($item->total, 2) }}</p>
</td>
@endif
</tr>
</table>
</div>
@endforeach
</div>

@if($services->count() > 0)
{{-- Services Section --}}
<div style="margin: 30px 0;">
<h2 style="color: #1a202c; font-size: 16px; font-weight: 600; margin: 0 0 15px 0; padding-bottom: 10px; border-bottom: 1px solid #e2e8f0; text-align: {{ $textAlign }};">{{ __('emails.your_services') ?? 'Your Services' }}</h2>

@foreach($services as $service)
<div style="border: 1px solid #e2e8f0; border-radius: 10px; padding: 18px; margin-bottom: 12px;">
<table style="width: 100%; direction: {{ $direction }};">
<tr>
<td style="text-align: {{ $textAlign }};">
<span style="font-weight: 600; color: #1a202c; font-size: 15px;">{{ $service->service_name }}</span>
</td>
<td style="text-align: {{ $textAlignOpposite }};">
<span style="background-color: {{ $service->status === 'active' ? '#c6f6d5' : '#fef3c7' }}; color: {{ $service->status === 'active' ? '#22543d' : '#92400e' }}; padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 600; text-transform: uppercase;">{{ $service->status }}</span>
</td>
</tr>
</table>

<div style="margin-top: 12px; padding-top: 12px; border-top: 1px dashed #e2e8f0;">
<table style="width: 100%; font-size: 13px; direction: {{ $direction }};">
@if($service->getDomainName())
<tr>
<td style="padding: 4px 0; color: #718096; width: 40%; text-align: {{ $textAlign }};">{{ __('emails.domain') ?? 'Domain' }}</td>
<td style="padding: 4px 0; color: #4a5568; font-weight: 500; text-align: {{ $textAlignOpposite }};">{{ $service->getDomainName() }}</td>
</tr>
@endif
@if($service->next_due_date)
<tr>
<td style="padding: 4px 0; color: #718096; text-align: {{ $textAlign }};">{{ __('emails.next_renewal') ?? 'Next Renewal' }}</td>
<td style="padding: 4px 0; color: #4a5568; text-align: {{ $textAlignOpposite }};">{{ $service->next_due_date->format('F d, Y') }}</td>
</tr>
@endif
@if($service->billing_cycle)
<tr>
<td style="padding: 4px 0; color: #718096; text-align: {{ $textAlign }};">{{ __('emails.billing_cycle') ?? 'Billing Cycle' }}</td>
<td style="padding: 4px 0; color: #4a5568; text-align: {{ $textAlignOpposite }};">{{ ucfirst($service->billing_cycle) }}</td>
</tr>
@endif
</table>
</div>
</div>
@endforeach
</div>
@endif

{{-- Next Steps --}}
<p style="font-size: 15px; color: #4a5568; line-height: 1.6; margin-top: 25px; text-align: {{ $textAlign }};">
@if($services->where('type', 'hosting')->count() > 0 || $services->where('type', 'cloud_hosting')->count() > 0)
{{ __('emails.hosting_credentials') ?? 'Your hosting account credentials will be sent in a separate email once your service is activated.' }}
@endif
{{ __('emails.manage_services') ?? 'You can manage your services from your client dashboard.' }}
</p>

{{-- Action Button --}}
<div style="text-align: center; margin: 35px 0;">
<x-mail::button :url="route('client.dashboard')" color="primary">
{{ __('emails.go_to_dashboard') ?? 'Go to Dashboard' }}
</x-mail::button>
</div>

{{-- Rating Section --}}
<div style="background-color: #fffbeb; border: 1px solid #fbbf24; border-radius: 10px; padding: 20px; margin: 25px 0; text-align: center;">
<p style="margin: 0 0 10px 0; font-size: 15px; color: #92400e; font-weight: 600; text-align: center;">{{ __('emails.rate_experience') ?? 'How was your experience?' }}</p>
<p style="margin: 0 0 15px 0; font-size: 13px; color: #a16207; text-align: center;">{{ __('emails.rate_experience_desc') ?? 'Your feedback helps us improve our services.' }}</p>
<a href="{{ route('payment.success', $order->id) }}#rating" style="display: inline-block; background-color: #f59e0b; color: #ffffff; padding: 10px 25px; border-radius: 6px; text-decoration: none; font-size: 14px; font-weight: 600;">{{ __('emails.rate_now') ?? 'Rate Now' }}</a>
</div>

{{-- Footer --}}
<div style="text-align: center; padding-top: 25px; border-top: 1px solid #e2e8f0; margin-top: 30px;">
<p style="color: #718096; font-size: 13px; margin: 0 0 15px 0; text-align: center;">{{ __('emails.questions') ?? 'If you have any questions, please don\'t hesitate to contact our support team.' }}</p>

{{-- Signature --}}
<div style="margin: 20px 0; text-align: center;">
<p style="color: #4a5568; font-size: 14px; margin: 0; text-align: center;">{{ __('emails.best_regards') ?? 'Best regards' }},</p>
<p style="color: #1d71b8; font-size: 15px; font-weight: 600; margin: 8px 0 3px 0; text-align: center;">{{ __('emails.customer_success_team') ?? 'Customer Success Team' }}</p>
<p style="color: #1a202c; font-size: 14px; font-weight: 700; margin: 0; text-align: center;">{{ config('app.name') }}</p>
</div>

{{-- Company Info --}}
<div style="background-color: #f8fafc; border-radius: 8px; padding: 20px; margin-top: 20px; direction: {{ $direction }};">
<p style="margin: 0 0 15px 0; font-size: 13px; color: #1a202c; font-weight: 700; text-align: center;">{{ config('app.name') }}</p>

{{-- UK Office --}}
<div style="margin-bottom: 15px; padding-bottom: 15px; border-bottom: 1px solid #e2e8f0; text-align: {{ $textAlign }};">
<p style="margin: 0 0 5px 0; font-size: 11px; color: #1d71b8; font-weight: 600; text-align: {{ $textAlign }};">{{ __('emails.uk_office') ?? 'UK Office' }}</p>
<p style="margin: 0 0 3px 0; font-size: 11px; color: #64748b; line-height: 1.5; text-align: {{ $textAlign }};" dir="ltr">71-75, Shelton Street, Covent Garden, London, WC2H 9JQ, United Kingdom</p>
<p style="margin: 0; font-size: 10px; color: #94a3b8; text-align: {{ $textAlign }};">{{ __('emails.reg_number') ?? 'Reg. No' }}: <span dir="ltr">16307182</span></p>
</div>

{{-- Egypt Office --}}
<div style="margin-bottom: 15px; text-align: {{ $textAlign }};">
<p style="margin: 0 0 5px 0; font-size: 11px; color: #1d71b8; font-weight: 600; text-align: {{ $textAlign }};">{{ __('emails.egypt_office') ?? 'Egypt Office' }}</p>
<p style="margin: 0 0 3px 0; font-size: 11px; color: #64748b; line-height: 1.5; text-align: {{ $textAlign }};" dir="ltr">Bani Waldin Ihsanan Tower - 3rd Floor, Mostafa Kamel Street, Beni Suef Center, Beni Suef Governorate</p>
<p style="margin: 0 0 2px 0; font-size: 10px; color: #94a3b8; text-align: {{ $textAlign }};">{{ __('emails.reg_number') ?? 'Reg. No' }}: <span dir="ltr">90088</span></p>
<p style="margin: 0; font-size: 10px; color: #94a3b8; text-align: {{ $textAlign }};">{{ __('emails.tax_number') ?? 'Tax Reg. No' }}: <span dir="ltr">755-552-334</span></p>
</div>

{{-- Contact --}}
<div style="text-align: center; padding-top: 10px; border-top: 1px solid #e2e8f0;">
<p style="margin: 0 0 12px 0; font-size: 11px; color: #64748b; text-align: center;" dir="ltr">
<a href="mailto:support@progineous.com" style="color: #1d71b8; text-decoration: none;">support@progineous.com</a>
&nbsp;|&nbsp;
<a href="https://progineous.com" style="color: #1d71b8; text-decoration: none;">progineous.com</a>
</p>

{{-- Social Media Links --}}
<div style="margin-top: 10px;">
{{-- Facebook --}}
<a href="https://facebook.com/progineous" target="_blank" style="display: inline-block; margin: 0 6px; text-decoration: none;">
<img src="https://cdn-icons-png.flaticon.com/24/733/733547.png" alt="Facebook" width="22" height="22" style="border: 0; vertical-align: middle;">
</a>
{{-- X (Twitter) --}}
<a href="https://x.com/progineous" target="_blank" style="display: inline-block; margin: 0 6px; text-decoration: none;">
<img src="https://cdn-icons-png.flaticon.com/24/5968/5968830.png" alt="X" width="22" height="22" style="border: 0; vertical-align: middle;">
</a>
{{-- LinkedIn --}}
<a href="https://uk.linkedin.com/company/progineous" target="_blank" style="display: inline-block; margin: 0 6px; text-decoration: none;">
<img src="https://cdn-icons-png.flaticon.com/24/733/733561.png" alt="LinkedIn" width="22" height="22" style="border: 0; vertical-align: middle;">
</a>
{{-- Instagram --}}
<a href="https://instagram.com/progineous" target="_blank" style="display: inline-block; margin: 0 6px; text-decoration: none;">
<img src="https://cdn-icons-png.flaticon.com/24/2111/2111463.png" alt="Instagram" width="22" height="22" style="border: 0; vertical-align: middle;">
</a>
{{-- WhatsApp --}}
<a href="https://wa.me/201070798859" target="_blank" style="display: inline-block; margin: 0 6px; text-decoration: none;">
<img src="https://cdn-icons-png.flaticon.com/24/733/733585.png" alt="WhatsApp" width="22" height="22" style="border: 0; vertical-align: middle;">
</a>
</div>

{{-- Trust Badges --}}
<div style="margin-top: 20px; padding-top: 15px; border-top: 1px solid #e2e8f0;">
<table cellpadding="0" cellspacing="0" border="0" style="margin: 0 auto;">
<tr>
{{-- SSL Secured --}}
<td style="padding: 0 10px; text-align: center;">
<img src="{{ asset('assets/images/letsencrypt-svgrepo-com.svg') }}" alt="SSL" width="28" height="28" style="border: 0;">
</td>
{{-- Secure Payments --}}
<td style="padding: 0 10px; text-align: center;">
<img src="{{ asset('assets/images/dollar-secure-payment-svgrepo-com.svg') }}" alt="Secure" width="28" height="28" style="border: 0;">
</td>
{{-- 24/7 Support --}}
<td style="padding: 0 10px; text-align: center;">
<img src="{{ asset('assets/images/24-hours-support-svgrepo-com.svg') }}" alt="Support" width="28" height="28" style="border: 0;">
</td>
{{-- Money Back --}}
<td style="padding: 0 10px; text-align: center;">
<img src="{{ asset('assets/images/guarantee-svgrepo-com.svg') }}" alt="Guarantee" width="28" height="28" style="border: 0;">
</td>
{{-- ICANN --}}
<td style="padding: 0 10px; text-align: center;">
<img src="{{ asset('assets/images/icann-ar21.svg') }}" alt="ICANN" width="60" height="28" style="border: 0;">
</td>
</tr>
</table>
</div>
</div>
</div>
</div>
</div>{{-- End RTL wrapper --}}

<x-mail::subcopy>
<div style="direction: {{ $direction }}; text-align: center;">
{{ __('emails.order_reference') ?? 'Order Reference' }}: <span dir="ltr">#{{ $order->order_number }}</span> | {{ __('emails.invoice_reference') ?? 'Invoice' }}: <span dir="ltr">#{{ $invoice->invoice_number }}</span>
</div>
</x-mail::subcopy>
</x-mail::message>
