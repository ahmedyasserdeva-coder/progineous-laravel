<!DOCTYPE html>
<html dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}" lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ app()->getLocale() == 'ar' ? 'تم استلام نطاق جديد' : 'New Domain Received' }}</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f4f4f4; direction: {{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }};">
    <table role="presentation" style="width: 100%; border-collapse: collapse;">
        <tr>
            <td style="padding: 40px 20px;">
                <table role="presentation" style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 12px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                    <!-- Header -->
                    <tr>
                        <td style="padding: 30px 40px; text-align: center; border-bottom: 1px solid #e5e7eb;">
                            <img src="{{ asset('logo/pro Gineous_logo.svg') }}" alt="Logo" style="max-width: 180px; height: auto; margin-bottom: 20px;">
                            <h1 style="margin: 0; color: #059669; font-size: 24px;">
                                🎉 {{ app()->getLocale() == 'ar' ? 'تم استلام نطاق جديد!' : 'New Domain Received!' }}
                            </h1>
                        </td>
                    </tr>
                    
                    <!-- Content -->
                    <tr>
                        <td style="padding: 40px;">
                            <p style="margin: 0 0 20px; color: #4b5563; font-size: 16px; line-height: 1.6;">
                                {{ app()->getLocale() == 'ar' ? 'مرحباً' : 'Hello' }} {{ $to_client_name }},
                            </p>
                            
                            <p style="margin: 0 0 20px; color: #4b5563; font-size: 16px; line-height: 1.6;">
                                {{ app()->getLocale() == 'ar' 
                                    ? 'يسعدنا إعلامك بأنه تم نقل نطاق جديد إلى حسابك!' 
                                    : 'We are pleased to inform you that a new domain has been transferred to your account!' }}
                            </p>
                            
                            <!-- Domain Info -->
                            <div style="margin: 25px 0; padding: 20px; background-color: #d1fae5; border: 1px solid #10b981; border-radius: 12px;">
                                <table style="width: 100%;">
                                    <tr>
                                        <td style="padding: 8px 0;">
                                            <span style="color: #065f46; font-size: 14px;">{{ app()->getLocale() == 'ar' ? 'النطاق:' : 'Domain:' }}</span>
                                        </td>
                                        <td style="padding: 8px 0; text-align: {{ app()->getLocale() == 'ar' ? 'left' : 'right' }};">
                                            <span style="font-size: 18px; font-weight: bold; color: #1f2937;">{{ $domain }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 8px 0;">
                                            <span style="color: #065f46; font-size: 14px;">{{ app()->getLocale() == 'ar' ? 'المالك السابق:' : 'Previous Owner:' }}</span>
                                        </td>
                                        <td style="padding: 8px 0; text-align: {{ app()->getLocale() == 'ar' ? 'left' : 'right' }};">
                                            <span style="font-size: 16px; color: #1f2937;">{{ $from_client_name }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 8px 0;">
                                            <span style="color: #065f46; font-size: 14px;">{{ app()->getLocale() == 'ar' ? 'تاريخ النقل:' : 'Transfer Date:' }}</span>
                                        </td>
                                        <td style="padding: 8px 0; text-align: {{ app()->getLocale() == 'ar' ? 'left' : 'right' }};">
                                            <span style="font-size: 14px; color: #6b7280;">{{ $transfer_date }}</span>
                                        </td>
                                    </tr>
                                    @if($expiry_date)
                                    <tr>
                                        <td style="padding: 8px 0;">
                                            <span style="color: #065f46; font-size: 14px;">{{ app()->getLocale() == 'ar' ? 'تاريخ الانتهاء:' : 'Expiry Date:' }}</span>
                                        </td>
                                        <td style="padding: 8px 0; text-align: {{ app()->getLocale() == 'ar' ? 'left' : 'right' }};">
                                            <span style="font-size: 14px; color: #6b7280;">{{ $expiry_date }}</span>
                                        </td>
                                    </tr>
                                    @endif
                                </table>
                            </div>
                            
                            <p style="margin: 20px 0; color: #4b5563; font-size: 16px; line-height: 1.6;">
                                {{ app()->getLocale() == 'ar' 
                                    ? 'يمكنك الآن إدارة هذا النطاق من لوحة التحكم الخاصة بك.' 
                                    : 'You can now manage this domain from your dashboard.' }}
                            </p>
                            
                            <!-- CTA Button -->
                            <div style="margin: 30px 0; text-align: center;">
                                <a href="{{ route('client.domains.index') }}" style="display: inline-block; padding: 14px 32px; background: linear-gradient(135deg, #10b981, #059669); color: #ffffff; text-decoration: none; font-weight: bold; font-size: 16px; border-radius: 10px;">
                                    {{ app()->getLocale() == 'ar' ? 'إدارة النطاقات' : 'Manage Domains' }}
                                </a>
                            </div>
                            
                            <!-- Info Notice -->
                            <div style="margin: 25px 0; padding: 15px; background-color: #dbeafe; border: 1px solid #3b82f6; border-radius: 8px;">
                                <p style="margin: 0; color: #1e40af; font-size: 14px; line-height: 1.5;">
                                    <strong>{{ app()->getLocale() == 'ar' ? 'ℹ️ ملاحظة:' : 'ℹ️ Note:' }}</strong>
                                    {{ app()->getLocale() == 'ar' 
                                        ? 'أنت الآن مسؤول عن تجديد هذا النطاق. تأكد من مراجعة تاريخ الانتهاء وتفعيل التجديد التلقائي إذا رغبت.' 
                                        : 'You are now responsible for renewing this domain. Make sure to check the expiry date and enable auto-renewal if desired.' }}
                                </p>
                            </div>
                        </td>
                    </tr>
                    
                    <!-- Footer -->
                    <tr>
                        <td style="padding: 20px 40px; text-align: center; background-color: #f9fafb; border-top: 1px solid #e5e7eb; border-radius: 0 0 12px 12px;">
                            <p style="margin: 0; color: #9ca3af; font-size: 12px;">
                                {{ app()->getLocale() == 'ar' 
                                    ? 'هذا البريد الإلكتروني تم إرساله تلقائياً، يرجى عدم الرد عليه.' 
                                    : 'This is an automated email, please do not reply.' }}
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
