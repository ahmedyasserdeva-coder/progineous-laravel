import { NextRequest, NextResponse } from 'next/server';
import nodemailer from 'nodemailer';

// إعداد ناقل البريد الإلكتروني
const transporter = nodemailer.createTransport({
  host: process.env.SMTP_HOST || 'smtp.hostinger.com',
  port: parseInt(process.env.SMTP_PORT || '465'),
  secure: true,
  auth: {
    user: process.env.SMTP_USER || 'noreply@progineous.com',
    pass: process.env.SMTP_PASS,
  },
});

export async function POST(request: NextRequest) {
  try {
    const body = await request.json();
    const { name, email, phone, ratings, comment, locale, timestamp } = body;

    // التحقق من البيانات
    if (!name || !email || !phone || !ratings || Object.keys(ratings).length === 0) {
      return NextResponse.json(
        { success: false, error: 'Missing required fields' },
        { status: 400 }
      );
    }

    // حساب متوسط التقييم
    const ratingValues = Object.values(ratings) as number[];
    const averageRating = ratingValues.reduce((a, b) => a + b, 0) / ratingValues.length;

    // الكوبون الثابت
    const couponCode = 'pg-2026';

    // تجهيز البيانات
    const feedbackData = {
      name,
      email,
      phone,
      ratings,
      averageRating: Math.round(averageRating * 10) / 10,
      comment: comment || '',
      locale,
      timestamp,
      couponCode,
    };

    // إرسال البريد الإلكتروني
    await sendFeedbackEmail(feedbackData);

    return NextResponse.json({
      success: true,
      message: 'Feedback submitted successfully',
      couponCode,
    });

  } catch (error) {
    console.error('Error processing feedback:', error);
    return NextResponse.json(
      { success: false, error: 'Internal server error' },
      { status: 500 }
    );
  }
}

// إرسال بريد إلكتروني بتفاصيل التقييم
async function sendFeedbackEmail(data: {
  name: string;
  email: string;
  phone: string;
  ratings: Record<string, number>;
  averageRating: number;
  comment: string;
  locale: string;
  timestamp: string;
  couponCode: string;
}) {
  const ratingLabels: Record<string, { en: string; ar: string }> = {
    overall: { en: 'Overall Experience', ar: 'التقييم العام' },
    performance: { en: 'Performance & Speed', ar: 'الأداء والسرعة' },
    design: { en: 'Design & Interface', ar: 'التصميم والواجهة' },
    support: { en: 'Customer Support', ar: 'الدعم الفني' },
    value: { en: 'Value for Money', ar: 'القيمة مقابل السعر' },
  };

  const ratingsHtml = Object.entries(data.ratings)
    .map(([key, value]) => {
      const label = ratingLabels[key] || { en: key, ar: key };
      const stars = '⭐'.repeat(value) + '☆'.repeat(5 - value);
      return `<tr>
        <td style="padding: 8px; border-bottom: 1px solid #eee;">${label.ar} / ${label.en}</td>
        <td style="padding: 8px; border-bottom: 1px solid #eee;">${stars} (${value}/5)</td>
      </tr>`;
    })
    .join('');

  const emailHtml = `
    <!DOCTYPE html>
    <html dir="rtl">
    <head>
      <meta charset="UTF-8">
      <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f5f5f5; margin: 0; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .header { background: linear-gradient(135deg, #1d71b8, #0d4a7a); color: white; padding: 30px; text-align: center; }
        .header h1 { margin: 0; font-size: 24px; }
        .content { padding: 30px; }
        .info-box { background: #f8fafc; border-radius: 8px; padding: 20px; margin-bottom: 20px; }
        .info-row { display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #e2e8f0; }
        .info-row:last-child { border-bottom: none; }
        .label { color: #64748b; font-weight: 500; }
        .value { color: #1e293b; font-weight: 600; }
        .rating-table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        .rating-table th { background: #1d71b8; color: white; padding: 12px; text-align: right; }
        .avg-rating { background: linear-gradient(135deg, #1d71b8, #0d4a7a); color: white; padding: 20px; border-radius: 8px; text-align: center; margin: 20px 0; }
        .avg-rating .number { font-size: 48px; font-weight: bold; }
        .comment-box { background: #fffbeb; border-right: 4px solid #f59e0b; padding: 15px; border-radius: 0 8px 8px 0; margin: 20px 0; }
        .coupon-box { background: #dcfce7; border: 2px dashed #22c55e; padding: 15px; border-radius: 8px; text-align: center; margin: 20px 0; }
        .coupon-code { font-size: 24px; font-weight: bold; color: #16a34a; letter-spacing: 2px; }
        .footer { background: #f1f5f9; padding: 20px; text-align: center; color: #64748b; font-size: 14px; }
      </style>
    </head>
    <body>
      <div class="container">
        <div class="header">
          <h1>📝 تقييم جديد من العميل</h1>
          <p style="margin: 10px 0 0; opacity: 0.9;">New Customer Feedback</p>
        </div>
        
        <div class="content">
          <div class="info-box">
            <div class="info-row">
              <span class="label">الاسم / Name:</span>
              <span class="value">${data.name}</span>
            </div>
            <div class="info-row">
              <span class="label">البريد / Email:</span>
              <span class="value"><a href="mailto:${data.email}">${data.email}</a></span>
            </div>
            <div class="info-row">
              <span class="label">الهاتف / Phone:</span>
              <span class="value"><a href="tel:${data.phone}" dir="ltr">${data.phone}</a></span>
            </div>
            <div class="info-row">
              <span class="label">اللغة / Language:</span>
              <span class="value">${data.locale === 'ar' ? 'العربية' : 'English'}</span>
            </div>
            <div class="info-row">
              <span class="label">التاريخ / Date:</span>
              <span class="value">${new Date(data.timestamp).toLocaleString('ar-EG', { dateStyle: 'full', timeStyle: 'short' })}</span>
            </div>
          </div>

          <div class="avg-rating">
            <div class="number">${data.averageRating}</div>
            <div>متوسط التقييم من 5 / Average Rating out of 5</div>
          </div>

          <h3 style="color: #1d71b8; border-bottom: 2px solid #1d71b8; padding-bottom: 10px;">
            📊 تفاصيل التقييم / Rating Details
          </h3>
          <table class="rating-table">
            <thead>
              <tr>
                <th>الفئة / Category</th>
                <th>التقييم / Rating</th>
              </tr>
            </thead>
            <tbody>
              ${ratingsHtml}
            </tbody>
          </table>

          ${data.comment ? `
            <h3 style="color: #f59e0b;">💬 تعليق العميل / Customer Comment</h3>
            <div class="comment-box">
              <p style="margin: 0; line-height: 1.8;">${data.comment}</p>
            </div>
          ` : ''}

          <div class="coupon-box">
            <p style="margin: 0 0 10px; color: #16a34a;">🎁 تم إرسال كود الخصم للعميل:</p>
            <div class="coupon-code">${data.couponCode}</div>
            <p style="margin: 10px 0 0; font-size: 14px; color: #64748b;">خصم 15% على أي خدمة</p>
            <p style="margin: 5px 0 0; font-size: 14px; color: #dc2626; font-weight: bold;">⏰ صالح حتى: 31 يناير 2026</p>
          </div>
        </div>

        <div class="footer">
          <p style="margin: 0;">Pro Gineous - Customer Feedback System</p>
          <p style="margin: 5px 0 0;">© ${new Date().getFullYear()} All Rights Reserved</p>
        </div>
      </div>
    </body>
    </html>
  `;

  const mailOptions = {
    from: `"Pro Gineous Feedback" <${process.env.SMTP_USER || 'noreply@progineous.com'}>`,
    to: 'marketing@progineous.com',
    subject: `📝 تقييم جديد من ${data.name} - متوسط التقييم: ${data.averageRating}/5`,
    html: emailHtml,
    replyTo: data.email,
  };

  try {
    await transporter.sendMail(mailOptions);
    console.log('Feedback email sent successfully to marketing@progineous.com');
  } catch (error) {
    console.error('Failed to send feedback email:', error);
    // لا نريد أن يفشل الطلب بسبب فشل إرسال البريد
  }
}
