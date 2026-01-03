<!DOCTYPE html>
<html dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}" lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ app()->getLocale() == 'ar' ? 'تم نقل النطاق' : 'Domain Transferred' }}</title>
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
                            <h1 style="margin: 0; color: #1f2937; font-size: 24px;">
                                {{ app()->getLocale() == 'ar' ? 'تم نقل النطاق' : 'Domain Transferred' }}
                            </h1>
                        </td>
                    </tr>
                    
                    <!-- Content -->
                    <tr>
                        <td style="padding: 40px;">
                            <p style="margin: 0 0 20px; color: #4b5563; font-size: 16px; line-height: 1.6;">
                                {{ app()->getLocale() == 'ar' ? 'مرحباً' : 'Hello' }} {{ $from_client_name }},
                            </p>
                            
                            <p style="margin: 0 0 20px; color: #4b5563; font-size: 16px; line-height: 1.6;">
                                {{ app()->getLocale() == 'ar' 
                                    ? 'نود إعلامك بأنه تم نقل ملكية النطاق التالي من حسابك بنجاح:' 
                                    : 'We would like to inform you that the following domain has been successfully transferred from your account:' }}
                            </p>
                            
                            <!-- Domain Info -->
                            <div style="margin: 25px 0; padding: 20px; background-color: #fef3c7; border: 1px solid #f59e0b; border-radius: 12px;">
                                <table style="width: 100%;">
                                    <tr>
                                        <td style="padding: 8px 0;">
                                            <span style="color: #92400e; font-size: 14px;">{{ app()->getLocale() == 'ar' ? 'النطاق:' : 'Domain:' }}</span>
                                        </td>
                                        <td style="padding: 8px 0; text-align: {{ app()->getLocale() == 'ar' ? 'left' : 'right' }};">
                                            <span style="font-size: 18px; font-weight: bold; color: #1f2937;">{{ $domain }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 8px 0;">
                                            <span style="color: #92400e; font-size: 14px;">{{ app()->getLocale() == 'ar' ? 'المالك الجديد:' : 'New Owner:' }}</span>
                                        </td>
                                        <td style="padding: 8px 0; text-align: {{ app()->getLocale() == 'ar' ? 'left' : 'right' }};">
                                            <span style="font-size: 16px; color: #1f2937;">{{ $to_client_name }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 8px 0;">
                                            <span style="color: #92400e; font-size: 14px;">{{ app()->getLocale() == 'ar' ? 'تاريخ النقل:' : 'Transfer Date:' }}</span>
                                        </td>
                                        <td style="padding: 8px 0; text-align: {{ app()->getLocale() == 'ar' ? 'left' : 'right' }};">
                                            <span style="font-size: 14px; color: #6b7280;">{{ $transfer_date }}</span>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            
                            <p style="margin: 20px 0; color: #4b5563; font-size: 16px; line-height: 1.6;">
                                {{ app()->getLocale() == 'ar' 
                                    ? 'لم يعد بإمكانك الوصول إلى إدارة هذا النطاق. إذا كنت تعتقد أن هذا خطأ أو لم تقم بهذا الإجراء، يرجى التواصل مع الدعم الفني فوراً.' 
                                    : 'You no longer have access to manage this domain. If you believe this is an error or you did not perform this action, please contact support immediately.' }}
                            </p>
                            
                            <!-- Warning -->
                            <div style="margin: 25px 0; padding: 15px; background-color: #fee2e2; border: 1px solid #ef4444; border-radius: 8px;">
                                <p style="margin: 0; color: #991b1b; font-size: 14px; line-height: 1.5;">
                                    <strong>{{ app()->getLocale() == 'ar' ? '⚠️ تنبيه:' : '⚠️ Notice:' }}</strong>
                                    {{ app()->getLocale() == 'ar' 
                                        ? 'إذا لم تقم بهذا الإجراء، يرجى تغيير كلمة المرور فوراً والتواصل مع الدعم الفني.' 
                                        : 'If you did not perform this action, please change your password immediately and contact support.' }}
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
