<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 40px 20px; }
        .container { max-width: 600px; margin: 0 auto; background: #ffffff; border-radius: 20px; overflow: hidden; box-shadow: 0 20px 60px rgba(0,0,0,0.3); }
        .header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 50px 30px; text-align: center; position: relative; }
        .header::before { content: ""; position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: url("data:image/svg+xml,%3Csvg width='100' height='100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M0 0h100v100H0z' fill='none'/%3E%3Cpath d='M50 10L90 90H10z' fill='%23fff' opacity='0.1'/%3E%3C/svg%3E"); opacity: 0.1; }
        .logo { width: 180px; height: auto; margin-bottom: 20px; filter: brightness(0) invert(1); position: relative; z-index: 1; }
        .header h1 { color: #ffffff; font-size: 32px; font-weight: 700; margin-bottom: 10px; position: relative; z-index: 1; text-shadow: 0 2px 10px rgba(0,0,0,0.2); }
        .header p { color: rgba(255,255,255,0.9); font-size: 16px; position: relative; z-index: 1; }
        .content { padding: 50px 40px; }
        .welcome-text { font-size: 18px; color: #333333; line-height: 1.8; margin-bottom: 30px; text-align: center; }
        .highlight { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; font-weight: 700; font-size: 20px; }
        .features { margin: 40px 0; }
        .feature-item { display: flex; align-items: flex-start; margin-bottom: 25px; padding: 20px; background: #f8f9fa; border-radius: 12px; transition: transform 0.3s; }
        .feature-item:hover { transform: translateX(5px); }
        .feature-icon { width: 50px; height: 50px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 15px; flex-shrink: 0; }
        .feature-icon svg { width: 24px; height: 24px; fill: white; }
        .feature-text { flex: 1; }
        .feature-text h3 { color: #667eea; font-size: 18px; margin-bottom: 8px; }
        .feature-text p { color: #666666; font-size: 14px; line-height: 1.6; }
        .cta-button { display: inline-block; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 16px 40px; text-decoration: none; border-radius: 50px; font-weight: 600; font-size: 16px; margin: 30px 0; box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4); transition: all 0.3s; }
        .cta-button:hover { transform: translateY(-3px); box-shadow: 0 15px 40px rgba(102, 126, 234, 0.5); }
        .footer { background: #f8f9fa; padding: 30px 40px; text-align: center; border-top: 3px solid #667eea; }
        .footer p { color: #666666; font-size: 14px; line-height: 1.8; margin-bottom: 15px; }
        .social-links { margin-top: 20px; }
        .social-links a { display: inline-block; margin: 0 10px; color: #667eea; text-decoration: none; font-weight: 600; transition: color 0.3s; }
        .social-links a:hover { color: #764ba2; }
        @media (max-width: 600px) {
            .content { padding: 30px 20px; }
            .header h1 { font-size: 26px; }
            .welcome-text { font-size: 16px; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="{{logo_url}}" alt="Pro Gineous" class="logo">
            <h1>Welcome to Pro Gineous! 🎉</h1>
            <p>Your journey to digital excellence starts now</p>
        </div>
        
        <div class="content">
            <div class="welcome-text">
                <p>Dear <span class="highlight">{{customer_name}}</span>,</p>
                <p style="margin-top: 20px;">
                    We are <strong>thrilled</strong> to have you join the Pro Gineous family! 🚀
                </p>
                <p style="margin-top: 15px;">
                    You've made the right choice by selecting Pro Gineous as your trusted technology partner. 
                    We're here to support you every step of the way on your digital journey.
                </p>
            </div>

            <div class="features">
                <div class="feature-item">
                    <div class="feature-icon">
                        <svg viewBox="0 0 24 24"><path d="M9 11H7v2h2v-2zm4 0h-2v2h2v-2zm4 0h-2v2h2v-2zm2-7h-1V2h-2v2H8V2H6v2H5c-1.11 0-1.99.9-1.99 2L3 20c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V9h14v11z"/></svg>
                    </div>
                    <div class="feature-text">
                        <h3>24/7 Technical Support</h3>
                        <p>Our specialized team is available around the clock to answer your questions and assist you anytime.</p>
                    </div>
                </div>

                <div class="feature-item">
                    <div class="feature-icon">
                        <svg viewBox="0 0 24 24"><path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm0 10.99h7c-.53 4.12-3.28 7.79-7 8.94V12H5V6.3l7-3.11v8.8z"/></svg>
                    </div>
                    <div class="feature-text">
                        <h3>Advanced Security & Protection</h3>
                        <p>We use the latest security technologies to protect your data and website from threats.</p>
                    </div>
                </div>

                <div class="feature-item">
                    <div class="feature-icon">
                        <svg viewBox="0 0 24 24"><path d="M13 2.05v3.03c3.39.49 6 3.39 6 6.92 0 .9-.18 1.75-.48 2.54l2.6 1.53c.56-1.24.88-2.62.88-4.07 0-5.18-3.95-9.45-9-9.95zM12 19c-3.87 0-7-3.13-7-7 0-3.53 2.61-6.43 6-6.92V2.05c-5.06.5-9 4.76-9 9.95 0 5.52 4.47 10 9.99 10 3.31 0 6.24-1.61 8.06-4.09l-2.6-1.53C16.17 17.98 14.21 19 12 19z"/></svg>
                    </div>
                    <div class="feature-text">
                        <h3>Ultra-Fast Performance</h3>
                        <p>Powerful servers and advanced acceleration technologies to ensure the best experience for your visitors.</p>
                    </div>
                </div>
            </div>

            <div style="text-align: center;">
                <p style="color: #666666; margin-bottom: 20px;">
                    <strong>Ready to get started?</strong><br>
                    Visit your control panel and start building your digital presence!
                </p>
                <a href="{{dashboard_url}}" class="cta-button">Go to Dashboard 🚀</a>
            </div>

            <div style="margin-top: 40px; padding: 25px; background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%); border-left: 4px solid #667eea; border-radius: 12px;">
                <p style="color: #667eea; font-weight: 600; margin-bottom: 10px;">💡 Pro Tip:</p>
                <p style="color: #666666; font-size: 14px; line-height: 1.6;">
                    Keep this email in a safe place. It contains important information you may need later.
                </p>
            </div>
        </div>

        <div class="footer">
            <p><strong>Thank you for your trust!</strong></p>
            <p>If you have any questions, don't hesitate to contact us.</p>
            <div class="social-links">
                <a href="{{support_url}}">Support</a>
                <a href="{{website_url}}">Website</a>
                <a href="{{contact_url}}">Contact Us</a>
            </div>
            <p style="margin-top: 20px; font-size: 12px; color: #999999;">
                © 2025 Pro Gineous. All Rights Reserved.
            </p>
        </div>
    </div>
</body>
</html>
