<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('crm.email_verification') }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #e8f4fd 0%, #f0f9ff 100%);
            margin: 0;
            padding: 20px;
            direction: {{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }};
        }
        .email-wrapper {
            max-width: 600px;
            margin: 0 auto;
        }
        .email-container {
            background-color: #ffffff;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(29, 113, 184, 0.15);
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, #1d71b8 0%, #0f5a99 100%);
            padding: 40px 30px;
            text-align: center;
            position: relative;
        }
        .logo {
            max-width: 200px;
            height: auto;
            margin-bottom: 20px;
        }
        .header h1 {
            color: #ffffff;
            margin: 0;
            font-size: 28px;
            font-weight: 600;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .header-tagline {
            color: #e0f2fe;
            font-size: 14px;
            margin-top: 8px;
            font-style: italic;
        }
        .content {
            padding: 50px 40px;
            text-align: center;
        }
        .lock-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #1d71b8 0%, #0f5a99 100%);
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 30px;
            box-shadow: 0 8px 16px rgba(29, 113, 184, 0.3);
        }
        .lock-icon svg {
            width: 40px;
            height: 40px;
            fill: #ffffff;
        }
        .greeting {
            color: #1e293b;
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 15px;
        }
        .message {
            color: #475569;
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 35px;
        }
        .otp-container {
            background: linear-gradient(135deg, #e0f2fe 0%, #bae6fd 100%);
            border: 3px solid #1d71b8;
            border-radius: 12px;
            padding: 25px;
            margin: 30px 0;
            box-shadow: 0 4px 6px rgba(29, 113, 184, 0.1);
        }
        .otp-label {
            color: #1d71b8;
            font-size: 14px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 10px;
        }
        .otp-box {
            background: #ffffff;
            color: #1d71b8;
            font-size: 42px;
            font-weight: bold;
            letter-spacing: 12px;
            padding: 20px;
            border-radius: 8px;
            display: inline-block;
            font-family: 'Courier New', monospace;
            border: 2px solid #1d71b8;
            box-shadow: 0 2px 4px rgba(29, 113, 184, 0.2);
        }
        .timer-section {
            background: #fef3c7;
            border-left: 4px solid #f59e0b;
            padding: 15px 20px;
            margin: 30px 0;
            border-radius: 8px;
            text-align: {{ app()->getLocale() == 'ar' ? 'right' : 'left' }};
        }
        .timer-icon {
            color: #f59e0b;
            font-size: 20px;
            margin-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}: 10px;
        }
        .timer-text {
            color: #92400e;
            font-size: 14px;
            font-weight: 600;
            display: inline;
        }
        .security-notice {
            background: #fef2f2;
            border-left: 4px solid #ef4444;
            padding: 20px;
            margin: 30px 0;
            border-radius: 8px;
            text-align: {{ app()->getLocale() == 'ar' ? 'right' : 'left' }};
        }
        .security-notice-title {
            color: #dc2626;
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .security-notice-text {
            color: #7f1d1d;
            font-size: 14px;
            line-height: 1.6;
        }
        .footer {
            background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
            padding: 30px;
            text-align: center;
            border-top: 3px solid #1d71b8;
        }
        .footer-logo {
            max-width: 150px;
            height: auto;
            margin-bottom: 15px;
            opacity: 0.7;
        }
        .footer-text {
            color: #64748b;
            font-size: 13px;
            line-height: 1.6;
            margin-bottom: 10px;
        }
        .footer-links {
            margin-top: 15px;
        }
        .footer-link {
            color: #1d71b8;
            text-decoration: none;
            font-size: 13px;
            margin: 0 10px;
        }
        .footer-link:hover {
            text-decoration: underline;
        }
        .divider {
            height: 1px;
            background: linear-gradient(to right, transparent, #cbd5e1, transparent);
            margin: 20px 0;
        }
        @media only screen and (max-width: 600px) {
            body {
                padding: 10px;
            }
            .content {
                padding: 30px 20px;
            }
            .otp-box {
                font-size: 32px;
                letter-spacing: 8px;
            }
            .header h1 {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <div class="email-container">
            <!-- Header -->
            <div class="header">
                <img src="{{ asset('logo/pro Gineous_white logo.svg') }}" alt="Pro Gineous" class="logo">
                <h1>{{ __('crm.email_verification') }}</h1>
                <p class="header-tagline">Unlocking Potential</p>
            </div>
            
            <!-- Content -->
            <div class="content">
                <!-- Lock Icon -->
                <div class="lock-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path d="M12 1C8.676 1 6 3.676 6 7v2H5c-1.103 0-2 .897-2 2v9c0 1.103.897 2 2 2h14c1.103 0 2-.897 2-2v-9c0-1.103-.897-2-2-2h-1V7c0-3.324-2.676-6-6-6zm0 2c2.276 0 4 1.724 4 4v2H8V7c0-2.276 1.724-4 4-4zm0 10c1.103 0 2 .897 2 2s-.897 2-2 2-2-.897-2-2 .897-2 2-2z"/>
                    </svg>
                </div>
                
                <!-- Greeting -->
                <h2 class="greeting">{{ app()->getLocale() == 'ar' ? 'مرحباً بك!' : 'Welcome!' }}</h2>
                
                <!-- Message -->
                <p class="message">{{ __('crm.otp_email_message') }}</p>
                
                <!-- OTP Container -->
                <div class="otp-container">
                    <div class="otp-label">{{ app()->getLocale() == 'ar' ? 'رمز التحقق' : 'Verification Code' }}</div>
                    <div class="otp-box">{{ $otp }}</div>
                </div>
                
                <!-- Timer Section -->
                <div class="timer-section">
                    <span class="timer-icon">⏰</span>
                    <span class="timer-text">{{ __('crm.otp_expires_in') }}</span>
                </div>
                
                <div class="divider"></div>
                
                <!-- Security Notice -->
                <div class="security-notice">
                    <div class="security-notice-title">
                        <span>🔐</span>
                        <span>{{ app()->getLocale() == 'ar' ? 'تنبيه أمني' : 'Security Notice' }}</span>
                    </div>
                    <p class="security-notice-text">{{ __('crm.otp_security_warning') }}</p>
                </div>
            </div>
            
            <!-- Footer -->
            <div class="footer">
                <img src="{{ asset('logo/pro Gineous_logo.svg') }}" alt="Pro Gineous" class="footer-logo">
                
                <p class="footer-text">{{ __('crm.automated_email_notice') }}</p>
                
                <div class="divider"></div>
                
                <div class="footer-links">
                    <a href="{{ config('app.url') }}" class="footer-link">{{ app()->getLocale() == 'ar' ? 'الموقع الإلكتروني' : 'Website' }}</a>
                    <span style="color: #cbd5e1;">|</span>
                    <a href="#" class="footer-link">{{ app()->getLocale() == 'ar' ? 'الدعم الفني' : 'Support' }}</a>
                    <span style="color: #cbd5e1;">|</span>
                    <a href="#" class="footer-link">{{ app()->getLocale() == 'ar' ? 'سياسة الخصوصية' : 'Privacy' }}</a>
                </div>
                
                <p class="footer-text" style="margin-top: 15px; font-size: 12px; color: #94a3b8;">
                    © {{ date('Y') }} Pro Gineous. {{ app()->getLocale() == 'ar' ? 'جميع الحقوق محفوظة' : 'All rights reserved' }}.
                </p>
            </div>
        </div>
    </div>
</body>
</html>
