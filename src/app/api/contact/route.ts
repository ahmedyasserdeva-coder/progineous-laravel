import { NextRequest, NextResponse } from 'next/server';
import nodemailer from 'nodemailer';

export async function POST(request: NextRequest) {
  try {
    const body = await request.json();
    const { name, email, phone, subject, department, message } = body;

    // Validate required fields
    if (!name || !email || !phone || !subject || !message) {
      return NextResponse.json(
        { error: 'Missing required fields' },
        { status: 400 }
      );
    }

    // Create transporter with SMTP settings
    const transporter = nodemailer.createTransport({
      host: process.env.SMTP_HOST,
      port: parseInt(process.env.SMTP_PORT || '465'),
      secure: true, // true for 465, false for other ports
      auth: {
        user: process.env.SMTP_USER,
        pass: process.env.SMTP_PASS,
      },
    });

    // Department labels
    const departmentLabels: Record<string, string> = {
      support: 'Technical Support',
      sales: 'Sales & Inquiries',
      billing: 'Billing & Accounts',
      partnerships: 'Partnerships',
      other: 'Other'
    };

    const departmentLabel = departmentLabels[department] || department;

    // Email to company (contact@progineous.com)
    const companyEmailHtml = `
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <style>
    body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
    .container { max-width: 600px; margin: 0 auto; padding: 20px; }
    .header { background: linear-gradient(135deg, #1d71b8, #0d4a7a); color: white; padding: 30px; text-align: center; border-radius: 10px 10px 0 0; }
    .content { background: #f9f9f9; padding: 30px; border: 1px solid #e0e0e0; }
    .field { margin-bottom: 15px; }
    .label { font-weight: bold; color: #1d71b8; }
    .value { margin-top: 5px; padding: 10px; background: white; border-radius: 5px; border: 1px solid #e0e0e0; }
    .message-box { margin-top: 20px; padding: 20px; background: white; border-radius: 5px; border-left: 4px solid #1d71b8; }
    .footer { text-align: center; padding: 20px; color: #666; font-size: 12px; }
  </style>
</head>
<body>
  <div class="container">
    <div class="header">
      <h1 style="margin: 0;">New Contact Form Submission</h1>
      <p style="margin: 10px 0 0 0; opacity: 0.9;">Pro Gineous Hosting</p>
    </div>
    <div class="content">
      <div class="field">
        <div class="label">Name:</div>
        <div class="value">${name}</div>
      </div>
      <div class="field">
        <div class="label">Email:</div>
        <div class="value"><a href="mailto:${email}">${email}</a></div>
      </div>
      <div class="field">
        <div class="label">Phone:</div>
        <div class="value"><a href="tel:${phone}">${phone}</a></div>
      </div>
      <div class="field">
        <div class="label">Department:</div>
        <div class="value">${departmentLabel}</div>
      </div>
      <div class="field">
        <div class="label">Subject:</div>
        <div class="value">${subject}</div>
      </div>
      <div class="message-box">
        <div class="label">Message:</div>
        <p style="margin-top: 10px; white-space: pre-wrap;">${message}</p>
      </div>
    </div>
    <div class="footer">
      <p>This message was sent from the Pro Gineous website contact form.</p>
      <p>Received at: ${new Date().toLocaleString('en-US', { timeZone: 'Africa/Cairo' })}</p>
    </div>
  </div>
</body>
</html>
    `;

    // Confirmation email to customer
    const customerEmailHtml = `
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <style>
    body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
    .container { max-width: 600px; margin: 0 auto; padding: 20px; }
    .header { background: linear-gradient(135deg, #1d71b8, #0d4a7a); color: white; padding: 30px; text-align: center; border-radius: 10px 10px 0 0; }
    .logo { font-size: 24px; font-weight: bold; }
    .content { background: #f9f9f9; padding: 30px; border: 1px solid #e0e0e0; }
    .highlight { background: white; padding: 20px; border-radius: 10px; border: 1px solid #e0e0e0; margin: 20px 0; }
    .footer { text-align: center; padding: 20px; color: #666; font-size: 12px; border-top: 1px solid #e0e0e0; }
    .button { display: inline-block; background: #1d71b8; color: white; padding: 12px 30px; text-decoration: none; border-radius: 5px; margin-top: 20px; }
  </style>
</head>
<body>
  <div class="container">
    <div class="header">
      <div class="logo">Pro Gineous</div>
      <p style="margin: 10px 0 0 0; opacity: 0.9;">Thank You for Contacting Us!</p>
    </div>
    <div class="content">
      <h2 style="color: #1d71b8; margin-top: 0;">Hello ${name},</h2>
      <p>Thank you for reaching out to Pro Gineous! We have received your message and our team will get back to you as soon as possible.</p>
      
      <div class="highlight">
        <h3 style="margin-top: 0; color: #1d71b8;">Your Message Summary:</h3>
        <p><strong>Subject:</strong> ${subject}</p>
        <p><strong>Department:</strong> ${departmentLabel}</p>
        <p><strong>Message:</strong></p>
        <p style="background: #f0f0f0; padding: 15px; border-radius: 5px; white-space: pre-wrap;">${message}</p>
      </div>
      
      <p><strong>What's next?</strong></p>
      <ul>
        <li>Our team typically responds within 24 hours</li>
        <li>For urgent matters, contact us via WhatsApp: +20 107 079 8859</li>
        <li>Check your spam folder if you don't hear from us</li>
      </ul>
      
      <center>
        <a href="https://progineous.com" class="button" style="color: white;">Visit Our Website</a>
      </center>
    </div>
    <div class="footer">
      <p><strong>Pro Gineous Hosting</strong></p>
      <p>Beni Suef, Egypt | Commercial Register: 90088</p>
      <p>
        <a href="https://progineous.com">Website</a> | 
        <a href="mailto:support@progineous.com">Support</a> | 
        <a href="https://wa.me/201070798859">WhatsApp</a>
      </p>
      <p style="margin-top: 15px; font-size: 11px; color: #999;">
        This is an automated confirmation email. Please do not reply directly to this message.
      </p>
    </div>
  </div>
</body>
</html>
    `;

    // Send email to company
    await transporter.sendMail({
      from: `"Pro Gineous Contact Form" <${process.env.SMTP_FROM}>`,
      to: 'contact@progineous.com',
      replyTo: email,
      subject: `[Contact Form] ${subject} - ${departmentLabel}`,
      html: companyEmailHtml,
    });

    // Send confirmation email to customer
    await transporter.sendMail({
      from: `"Pro Gineous" <${process.env.SMTP_FROM}>`,
      to: email,
      subject: 'We received your message - Pro Gineous',
      html: customerEmailHtml,
    });

    return NextResponse.json({ 
      success: true, 
      message: 'Email sent successfully' 
    });

  } catch (error) {
    console.error('Contact form error:', error);
    return NextResponse.json(
      { error: 'Failed to send email. Please try again later.' },
      { status: 500 }
    );
  }
}
