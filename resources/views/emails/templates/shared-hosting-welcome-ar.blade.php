<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>معلومات استضافتك</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 40px 20px; }
        .container { max-width: 650px; margin: 0 auto; background: #ffffff; border-radius: 20px; overflow: hidden; box-shadow: 0 20px 60px rgba(0,0,0,0.3); }
        .header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 40px 30px; text-align: center; }
        .logo { width: 160px; height: auto; margin-bottom: 15px; filter: brightness(0) invert(1); }
        .header h1 { color: #ffffff; font-size: 28px; font-weight: 700; margin-bottom: 8px; }
        .header p { color: rgba(255,255,255,0.9); font-size: 15px; }
        .content { padding: 40px; }
        .alert-box { background: linear-gradient(135deg, rgba(220, 53, 69, 0.1) 0%, rgba(220, 53, 69, 0.05) 100%); border-right: 4px solid #dc3545; padding: 20px; border-radius: 12px; margin-bottom: 30px; }
        .alert-box .icon { display: inline-block; width: 40px; height: 40px; background: #dc3545; border-radius: 50%; text-align: center; line-height: 40px; color: white; font-size: 20px; margin-left: 15px; float: right; }
        .alert-box h3 { color: #dc3545; font-size: 18px; margin-bottom: 10px; }
        .alert-box p { color: #721c24; font-size: 14px; line-height: 1.6; }
        .info-card { background: #f8f9fa; border-radius: 15px; padding: 30px; margin: 25px 0; border: 2px solid #e9ecef; }
        .info-card h2 { color: #667eea; font-size: 22px; margin-bottom: 20px; text-align: center; border-bottom: 2px solid #667eea; padding-bottom: 15px; }
        .info-row { display: flex; padding: 15px 0; border-bottom: 1px solid #dee2e6; align-items: center; }
        .info-row:last-child { border-bottom: none; }
        .info-label { font-weight: 600; color: #495057; min-width: 140px; display: flex; align-items: center; }
        .info-label .icon { margin-left: 8px; color: #667eea; }
        .info-value { flex: 1; font-family: "Courier New", monospace; background: white; padding: 12px 15px; border-radius: 8px; color: #212529; border: 1px solid #dee2e6; direction: ltr; text-align: left; }
        .login-button { display: block; background: linear-gradient(135deg, #28a745 0%, #20c997 100%); color: white; padding: 18px; text-align: center; text-decoration: none; border-radius: 12px; font-weight: 700; font-size: 18px; margin: 30px 0; box-shadow: 0 10px 25px rgba(40, 167, 69, 0.3); transition: all 0.3s; }
        .login-button:hover { transform: translateY(-3px); box-shadow: 0 15px 35px rgba(40, 167, 69, 0.4); }
        .tips-box { background: linear-gradient(135deg, rgba(23, 162, 184, 0.1) 0%, rgba(23, 162, 184, 0.05) 100%); border-right: 4px solid #17a2b8; padding: 25px; border-radius: 12px; margin: 30px 0; }
        .tips-box h3 { color: #17a2b8; font-size: 18px; margin-bottom: 15px; }
        .tips-box ul { margin-right: 20px; }
        .tips-box li { color: #0c5460; margin-bottom: 10px; line-height: 1.6; }
        .footer { background: #f8f9fa; padding: 25px; text-align: center; border-top: 3px solid #667eea; }
        .footer p { color: #666666; font-size: 13px; line-height: 1.8; }
        @media (max-width: 600px) {
            .content { padding: 25px 20px; }
            .info-row { flex-direction: column; align-items: flex-start; }
            .info-label { margin-bottom: 8px; }
            .info-value { width: 100%; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="{{logo_url}}" alt="Pro Gineous" class="logo">
            <h1>🎉 مبروك! استضافتك جاهزة</h1>
            <p>معلومات الدخول الخاصة بك</p>
        </div>
        
        <div class="content">
            <div class="alert-box">
                <div class="icon">⚠️</div>
                <h3>معلومات سرية - احتفظ بها بأمان!</h3>
                <p>
                    هذا البريد يحتوي على معلومات حساسة للدخول إلى استضافتك. 
                    <strong>الرجاء الاحتفاظ به في مكان آمن</strong> وعدم مشاركته مع أي شخص.
                </p>
            </div>

            <p style="font-size: 16px; color: #333; line-height: 1.8; margin-bottom: 25px; text-align: center;">
                عزيزي/عزيزتي <strong style="color: #667eea;">{{customer_name}}</strong>،<br>
                تم تفعيل استضافتك بنجاح! 🎊 فيما يلي معلومات الدخول الخاصة بك:
            </p>

            <div class="info-card">
                <h2>📋 معلومات الدخول إلى cPanel</h2>
                
                <div class="info-row">
                    <div class="info-label">
                        <span class="icon">🌐</span>
                        رابط تسجيل الدخول:
                    </div>
                    <div class="info-value">{{cpanel_url}}</div>
                </div>

                <div class="info-row">
                    <div class="info-label">
                        <span class="icon">👤</span>
                        اسم المستخدم:
                    </div>
                    <div class="info-value">{{cpanel_username}}</div>
                </div>

                <div class="info-row">
                    <div class="info-label">
                        <span class="icon">🔑</span>
                        كلمة المرور:
                    </div>
                    <div class="info-value">{{cpanel_password}}</div>
                </div>

                <div class="info-row">
                    <div class="info-label">
                        <span class="icon">🏷️</span>
                        الباقة:
                    </div>
                    <div class="info-value">{{package_name}}</div>
                </div>

                <div class="info-row">
                    <div class="info-label">
                        <span class="icon">🌍</span>
                        النطاق:
                    </div>
                    <div class="info-value">{{domain}}</div>
                </div>
            </div>

            <a href="{{cpanel_url}}" class="login-button">
                🚀 تسجيل الدخول إلى cPanel الآن
            </a>

            <div class="tips-box">
                <h3>💡 نصائح مهمة للبدء:</h3>
                <ul>
                    <li><strong>قم بتغيير كلمة المرور:</strong> بعد أول تسجيل دخول، نوصي بشدة بتغيير كلمة المرور لحماية حسابك.</li>
                    <li><strong>قم بإعداد البريد الإلكتروني:</strong> يمكنك إنشاء حسابات بريد إلكتروني احترافية باسم نطاقك من cPanel.</li>
                    <li><strong>قم بتثبيت SSL:</strong> تأكد من تفعيل شهادة SSL المجانية لحماية زوار موقعك.</li>
                    <li><strong>أنشئ نسخة احتياطية:</strong> قم بإعداد نسخ احتياطية تلقائية لحماية بياناتك.</li>
                    <li><strong>تحقق من موارد الاستضافة:</strong> راقب استهلاك الموارد من لوحة cPanel بانتظام.</li>
                </ul>
            </div>

            <div style="background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%); padding: 25px; border-radius: 12px; text-align: center; margin-top: 30px;">
                <h3 style="color: #667eea; margin-bottom: 15px;">هل تحتاج مساعدة؟</h3>
                <p style="color: #666; margin-bottom: 15px;">فريق الدعم الفني متاح 24/7 لمساعدتك</p>
                <p style="margin: 10px 0;">
                    <a href="{{support_url}}" style="color: #667eea; text-decoration: none; font-weight: 600;">📧 افتح تذكرة دعم</a>
                </p>
                <p style="margin: 10px 0;">
                    <a href="{{docs_url}}" style="color: #667eea; text-decoration: none; font-weight: 600;">📚 مركز المساعدة</a>
                </p>
            </div>
        </div>

        <div class="footer">
            <p><strong>شكراً لاختيارك Pro Gineous!</strong></p>
            <p>نحن سعداء بخدمتك ونتطلع لنجاح مشروعك 🚀</p>
            <p style="margin-top: 15px; font-size: 12px; color: #999;">
                © 2025 Pro Gineous. جميع الحقوق محفوظة.
            </p>
        </div>
    </div>
</body>
</html>
