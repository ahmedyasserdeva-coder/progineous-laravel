import { NextRequest, NextResponse } from 'next/server';
import nodemailer from 'nodemailer';

export async function POST(request: NextRequest) {
  try {
    const body = await request.json();
    const { email, locale } = body;

    // Validate email
    if (!email) {
      return NextResponse.json(
        { error: locale === 'ar' ? 'البريد الإلكتروني مطلوب' : 'Email is required' },
        { status: 400 }
      );
    }

    // Simple email validation
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
      return NextResponse.json(
        { error: locale === 'ar' ? 'بريد إلكتروني غير صالح' : 'Invalid email address' },
        { status: 400 }
      );
    }

    // Create transporter with SMTP settings
    const transporter = nodemailer.createTransport({
      host: process.env.SMTP_HOST,
      port: parseInt(process.env.SMTP_PORT || '465'),
      secure: true,
      auth: {
        user: process.env.SMTP_USER,
        pass: process.env.SMTP_PASS,
      },
    });

    const isArabic = locale === 'ar';
    const currentDate = new Date().toLocaleDateString(isArabic ? 'ar-EG' : 'en-US', {
      year: 'numeric',
      month: 'long',
      day: 'numeric',
      hour: '2-digit',
      minute: '2-digit',
    });

    // Email to marketing team
    const marketingEmailHtml = `
      <!DOCTYPE html>
      <html>
        <head>
          <meta charset="UTF-8">
          <meta name="viewport" content="width=device-width, initial-scale=1.0">
        </head>
        <body style="margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f4f4;">
          <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background-color: #f4f4f4; padding: 40px 20px;">
            <tr>
              <td align="center">
                <table role="presentation" width="600" cellspacing="0" cellpadding="0" style="background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                  <!-- Header -->
                  <tr>
                    <td style="background: linear-gradient(135deg, #1d71b8 0%, #0d4a7a 100%); padding: 30px 40px; text-align: center;">
                      <img src="https://progineous.com/images/logos/pro%20Gineous_white%20logo.svg" alt="Pro Gineous" style="height: 40px; margin-bottom: 15px;">
                      <h1 style="color: #ffffff; margin: 0; font-size: 24px; font-weight: 600;">📧 New Newsletter Subscription</h1>
                    </td>
                  </tr>
                  <!-- Content -->
                  <tr>
                    <td style="padding: 40px;">
                      <div style="background-color: #f8fafc; border-radius: 8px; padding: 25px; margin-bottom: 20px;">
                        <h2 style="color: #1d71b8; margin: 0 0 20px 0; font-size: 18px;">Subscription Details</h2>
                        <table width="100%" cellspacing="0" cellpadding="8">
                          <tr>
                            <td style="color: #64748b; font-size: 14px; width: 120px;">Email:</td>
                            <td style="color: #1e293b; font-size: 14px; font-weight: 600;">
                              <a href="mailto:${email}" style="color: #1d71b8; text-decoration: none;">${email}</a>
                            </td>
                          </tr>
                          <tr>
                            <td style="color: #64748b; font-size: 14px;">Language:</td>
                            <td style="color: #1e293b; font-size: 14px;">${isArabic ? 'Arabic (العربية)' : 'English'}</td>
                          </tr>
                          <tr>
                            <td style="color: #64748b; font-size: 14px;">Date:</td>
                            <td style="color: #1e293b; font-size: 14px;">${currentDate}</td>
                          </tr>
                        </table>
                      </div>
                      <p style="color: #64748b; font-size: 13px; margin: 0;">
                        This subscriber has been sent a confirmation email automatically.
                      </p>
                    </td>
                  </tr>
                  <!-- Footer -->
                  <tr>
                    <td style="background-color: #f8fafc; padding: 20px 40px; text-align: center; border-top: 1px solid #e2e8f0;">
                      <p style="color: #94a3b8; font-size: 12px; margin: 0;">
                        © ${new Date().getFullYear()} Pro Gineous. All rights reserved.
                      </p>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
        </body>
      </html>
    `;

    // Confirmation email to subscriber
    const confirmationEmailHtml = isArabic ? `
      <!DOCTYPE html>
      <html dir="rtl" lang="ar">
        <head>
          <meta charset="UTF-8">
          <meta name="viewport" content="width=device-width, initial-scale=1.0">
        </head>
        <body style="margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f4f4;">
          <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background-color: #f4f4f4; padding: 40px 20px;">
            <tr>
              <td align="center">
                <table role="presentation" width="600" cellspacing="0" cellpadding="0" style="background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                  <!-- Header -->
                  <tr>
                    <td style="background: linear-gradient(135deg, #1d71b8 0%, #0d4a7a 100%); padding: 30px 40px; text-align: center;">
                      <img src="https://progineous.com/images/logos/pro%20Gineous_white%20logo.svg" alt="Pro Gineous" style="height: 40px; margin-bottom: 15px;">
                      <h1 style="color: #ffffff; margin: 0; font-size: 24px; font-weight: 600;">🎉 مرحباً بك في نشرتنا البريدية!</h1>
                    </td>
                  </tr>
                  <!-- Content -->
                  <tr>
                    <td style="padding: 40px; text-align: right;">
                      <p style="color: #1e293b; font-size: 16px; line-height: 1.8; margin: 0 0 20px 0;">
                        شكراً لاشتراكك في النشرة البريدية لـ Pro Gineous! 🚀
                      </p>
                      <p style="color: #64748b; font-size: 14px; line-height: 1.8; margin: 0 0 20px 0;">
                        أنت الآن من أوائل من سيحصل على:
                      </p>
                      <ul style="color: #64748b; font-size: 14px; line-height: 2; margin: 0 0 25px 0; padding-right: 20px;">
                        <li>آخر أخبار وتحديثات خدماتنا</li>
                        <li>عروض وخصومات حصرية</li>
                        <li>نصائح ومقالات تقنية مفيدة</li>
                        <li>إشعارات بالميزات والخدمات الجديدة</li>
                      </ul>
                      <div style="background-color: #f0f9ff; border-radius: 8px; padding: 20px; border-right: 4px solid #1d71b8;">
                        <p style="color: #1d71b8; font-size: 14px; margin: 0; font-weight: 500;">
                          💡 نصيحة: أضف support@progineous.com إلى جهات الاتصال لضمان وصول رسائلنا إلى صندوق الوارد.
                        </p>
                      </div>
                    </td>
                  </tr>
                  <!-- CTA -->
                  <tr>
                    <td style="padding: 0 40px 40px; text-align: center;">
                      <a href="https://progineous.com/ar" style="display: inline-block; background: linear-gradient(135deg, #1d71b8 0%, #0d4a7a 100%); color: #ffffff; text-decoration: none; padding: 14px 32px; border-radius: 8px; font-weight: 600; font-size: 14px;">
                        زيارة موقعنا
                      </a>
                    </td>
                  </tr>
                  <!-- Footer -->
                  <tr>
                    <td style="background-color: #f8fafc; padding: 25px 40px; text-align: center; border-top: 1px solid #e2e8f0;">
                      <p style="color: #64748b; font-size: 13px; margin: 0 0 10px 0;">
                        تابعنا على وسائل التواصل الاجتماعي
                      </p>
                      <p style="margin: 0 0 15px 0;">
                        <a href="https://facebook.com/progineous" style="color: #1d71b8; text-decoration: none; margin: 0 10px;">Facebook</a>
                        <a href="https://twitter.com/progineous" style="color: #1d71b8; text-decoration: none; margin: 0 10px;">Twitter</a>
                        <a href="https://linkedin.com/company/progineous" style="color: #1d71b8; text-decoration: none; margin: 0 10px;">LinkedIn</a>
                      </p>
                      <p style="color: #94a3b8; font-size: 12px; margin: 0;">
                        © ${new Date().getFullYear()} Pro Gineous. جميع الحقوق محفوظة.
                      </p>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
        </body>
      </html>
    ` : `
      <!DOCTYPE html>
      <html lang="en">
        <head>
          <meta charset="UTF-8">
          <meta name="viewport" content="width=device-width, initial-scale=1.0">
        </head>
        <body style="margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f4f4;">
          <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background-color: #f4f4f4; padding: 40px 20px;">
            <tr>
              <td align="center">
                <table role="presentation" width="600" cellspacing="0" cellpadding="0" style="background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                  <!-- Header -->
                  <tr>
                    <td style="background: linear-gradient(135deg, #1d71b8 0%, #0d4a7a 100%); padding: 30px 40px; text-align: center;">
                      <img src="https://progineous.com/images/logos/pro%20Gineous_white%20logo.svg" alt="Pro Gineous" style="height: 40px; margin-bottom: 15px;">
                      <h1 style="color: #ffffff; margin: 0; font-size: 24px; font-weight: 600;">🎉 Welcome to Our Newsletter!</h1>
                    </td>
                  </tr>
                  <!-- Content -->
                  <tr>
                    <td style="padding: 40px;">
                      <p style="color: #1e293b; font-size: 16px; line-height: 1.8; margin: 0 0 20px 0;">
                        Thank you for subscribing to the Pro Gineous newsletter! 🚀
                      </p>
                      <p style="color: #64748b; font-size: 14px; line-height: 1.8; margin: 0 0 20px 0;">
                        You're now among the first to receive:
                      </p>
                      <ul style="color: #64748b; font-size: 14px; line-height: 2; margin: 0 0 25px 0; padding-left: 20px;">
                        <li>Latest news and service updates</li>
                        <li>Exclusive offers and discounts</li>
                        <li>Helpful tips and technical articles</li>
                        <li>New features and services announcements</li>
                      </ul>
                      <div style="background-color: #f0f9ff; border-radius: 8px; padding: 20px; border-left: 4px solid #1d71b8;">
                        <p style="color: #1d71b8; font-size: 14px; margin: 0; font-weight: 500;">
                          💡 Tip: Add support@progineous.com to your contacts to ensure our emails reach your inbox.
                        </p>
                      </div>
                    </td>
                  </tr>
                  <!-- CTA -->
                  <tr>
                    <td style="padding: 0 40px 40px; text-align: center;">
                      <a href="https://progineous.com/en" style="display: inline-block; background: linear-gradient(135deg, #1d71b8 0%, #0d4a7a 100%); color: #ffffff; text-decoration: none; padding: 14px 32px; border-radius: 8px; font-weight: 600; font-size: 14px;">
                        Visit Our Website
                      </a>
                    </td>
                  </tr>
                  <!-- Footer -->
                  <tr>
                    <td style="background-color: #f8fafc; padding: 25px 40px; text-align: center; border-top: 1px solid #e2e8f0;">
                      <p style="color: #64748b; font-size: 13px; margin: 0 0 10px 0;">
                        Follow us on social media
                      </p>
                      <p style="margin: 0 0 15px 0;">
                        <a href="https://facebook.com/progineous" style="color: #1d71b8; text-decoration: none; margin: 0 10px;">Facebook</a>
                        <a href="https://twitter.com/progineous" style="color: #1d71b8; text-decoration: none; margin: 0 10px;">Twitter</a>
                        <a href="https://linkedin.com/company/progineous" style="color: #1d71b8; text-decoration: none; margin: 0 10px;">LinkedIn</a>
                      </p>
                      <p style="color: #94a3b8; font-size: 12px; margin: 0;">
                        © ${new Date().getFullYear()} Pro Gineous. All rights reserved.
                      </p>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
        </body>
      </html>
    `;

    // Send email to marketing team
    await transporter.sendMail({
      from: `"Pro Gineous Newsletter" <${process.env.SMTP_USER}>`,
      to: 'marketing@progineous.com',
      subject: `📧 New Newsletter Subscription: ${email}`,
      html: marketingEmailHtml,
    });

    // Send confirmation email to subscriber
    await transporter.sendMail({
      from: `"Pro Gineous" <${process.env.SMTP_USER}>`,
      to: email,
      subject: isArabic ? '🎉 مرحباً بك في نشرة Pro Gineous البريدية!' : '🎉 Welcome to Pro Gineous Newsletter!',
      html: confirmationEmailHtml,
    });

    return NextResponse.json({
      success: true,
      message: isArabic 
        ? 'تم الاشتراك بنجاح! تحقق من بريدك الإلكتروني للتأكيد.' 
        : 'Successfully subscribed! Check your email for confirmation.',
    });

  } catch (error) {
    console.error('Newsletter subscription error:', error);
    return NextResponse.json(
      { 
        error: 'Failed to subscribe. Please try again later.',
        details: error instanceof Error ? error.message : 'Unknown error'
      },
      { status: 500 }
    );
  }
}
