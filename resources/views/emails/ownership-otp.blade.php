<!DOCTYPE html>
<html dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}" lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ app()->getLocale() == 'ar' ? 'كود التحقق' : 'Verification Code' }}</title>
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
                                {{ app()->getLocale() == 'ar' ? 'نقل ملكية النطاق' : 'Domain Ownership Transfer' }}
                            </h1>
                        </td>
                    </tr>
                    
                    <!-- Content -->
                    <tr>
                        <td style="padding: 40px;">
                            <p style="margin: 0 0 20px; color: #4b5563; font-size: 16px; line-height: 1.6;">
                                {{ app()->getLocale() == 'ar' ? 'مرحباً' : 'Hello' }} {{ $client_name }},
                            </p>
                            
                            <p style="margin: 0 0 20px; color: #4b5563; font-size: 16px; line-height: 1.6;">
                                {{ app()->getLocale() == 'ar' 
                                    ? 'لقد طلبت نقل ملكية النطاق التالي:' 
                                    : 'You have requested to transfer ownership of the following domain:' }}
                            </p>
                            
                            <div style="margin: 20px 0; padding: 15px; background-color: #f3f4f6; border-radius: 8px; text-align: center;">
                                <span style="font-size: 18px; font-weight: bold; color: #1f2937;">{{ $domain }}</span>
                            </div>
                            
                            <p style="margin: 20px 0; color: #4b5563; font-size: 16px; line-height: 1.6;">
                                {{ app()->getLocale() == 'ar' 
                                    ? 'كود التحقق الخاص بك هو:' 
                                    : 'Your verification code is:' }}
                            </p>
                            
                            <!-- OTP Code -->
                            <div style="margin: 30px 0; text-align: center;">
                                <div style="display: inline-block; padding: 20px 40px; background: linear-gradient(135deg, #3b82f6, #2563eb); border-radius: 12px;">
                                    <span style="font-size: 36px; font-weight: bold; color: #ffffff; letter-spacing: 8px; font-family: 'Courier New', monospace;">{{ $otp }}</span>
                                </div>
                            </div>
                            
                            <!-- Warning -->
                            <div style="margin: 30px 0; padding: 15px; background-color: #fef3c7; border: 1px solid #f59e0b; border-radius: 8px;">
                                <p style="margin: 0; color: #92400e; font-size: 14px; line-height: 1.5;">
                                    <strong>{{ app()->getLocale() == 'ar' ? '⚠️ تحذير:' : '⚠️ Warning:' }}</strong>
                                    {{ app()->getLocale() == 'ar' 
                                        ? 'هذا الكود صالح لمدة 10 دقائق فقط. لا تشاركه مع أي شخص.' 
                                        : 'This code is valid for 10 minutes only. Do not share it with anyone.' }}
                                </p>
                            </div>
                            
                            <p style="margin: 20px 0 0; color: #6b7280; font-size: 14px; line-height: 1.6;">
                                {{ app()->getLocale() == 'ar' 
                                    ? 'إذا لم تطلب هذا الإجراء، يرجى تجاهل هذا البريد الإلكتروني وتأكد من أمان حسابك.' 
                                    : 'If you did not request this action, please ignore this email and ensure your account is secure.' }}
                            </p>
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
