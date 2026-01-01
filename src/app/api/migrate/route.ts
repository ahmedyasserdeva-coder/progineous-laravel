import { NextRequest, NextResponse } from 'next/server';
import nodemailer from 'nodemailer';

export async function POST(request: NextRequest) {
  try {
    const data = await request.json();

    const {
      type = 'hosting', // 'hosting' or 'email'
      fullName,
      email,
      countryCode,
      phone,
      supportPin,
      // Hosting migration fields
      websiteUrl,
      hostingProvider,
      hostingType,
      controlPanel,
      // Email migration fields
      currentEmail,
      emailProvider,
      emailCount,
      notes,
    } = data;

    // Create transporter
    const smtpPort = parseInt(process.env.SMTP_PORT || '587');
    const transporter = nodemailer.createTransport({
      host: process.env.SMTP_HOST || 'smtp.gmail.com',
      port: smtpPort,
      secure: smtpPort === 465, // true for 465, false for other ports
      auth: {
        user: process.env.SMTP_USER,
        pass: process.env.SMTP_PASS,
      },
      tls: {
        rejectUnauthorized: false // Accept self-signed certificates
      }
    });

    // Determine email subject and content based on migration type
    const isEmailMigration = type === 'email';
    const migrationEmoji = isEmailMigration ? '📧' : '🚀';
    const migrationType = isEmailMigration ? 'Email Migration' : 'Hosting Migration';
    const recipientEmail = isEmailMigration ? 'migration@progineous.com' : 'migration@progineous.com';

    // Email content for team
    const mailOptions = {
      from: process.env.SMTP_FROM || 'noreply@progineous.com',
      to: recipientEmail,
      subject: `New ${migrationType} Request from ${fullName}`,
      html: isEmailMigration ? `
        <div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px;">
          <div style="background: linear-gradient(135deg, #1d71b8, #0f4c75); padding: 30px; border-radius: 10px 10px 0 0;">
            <h1 style="color: white; margin: 0; font-size: 24px;">${migrationEmoji} New Email Migration Request</h1>
          </div>
          
          <div style="background: #f9fafb; padding: 30px; border: 1px solid #e5e7eb; border-top: none; border-radius: 0 0 10px 10px;">
            <h2 style="color: #1d71b8; border-bottom: 2px solid #1d71b8; padding-bottom: 10px;">Customer Information</h2>
            <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
              <tr>
                <td style="padding: 10px 0; border-bottom: 1px solid #e5e7eb; font-weight: bold; width: 40%;">Full Name:</td>
                <td style="padding: 10px 0; border-bottom: 1px solid #e5e7eb;">${fullName}</td>
              </tr>
              <tr>
                <td style="padding: 10px 0; border-bottom: 1px solid #e5e7eb; font-weight: bold;">Email:</td>
                <td style="padding: 10px 0; border-bottom: 1px solid #e5e7eb;"><a href="mailto:${email}">${email}</a></td>
              </tr>
              <tr>
                <td style="padding: 10px 0; border-bottom: 1px solid #e5e7eb; font-weight: bold;">Phone:</td>
                <td style="padding: 10px 0; border-bottom: 1px solid #e5e7eb;">${countryCode} ${phone}</td>
              </tr>
              <tr>
                <td style="padding: 10px 0; border-bottom: 1px solid #e5e7eb; font-weight: bold;">Support PIN:</td>
                <td style="padding: 10px 0; border-bottom: 1px solid #e5e7eb;"><strong style="color: #1d71b8; font-size: 18px;">${supportPin}</strong></td>
              </tr>
            </table>

            <h2 style="color: #1d71b8; border-bottom: 2px solid #1d71b8; padding-bottom: 10px;">Email Migration Details</h2>
            <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
              <tr>
                <td style="padding: 10px 0; border-bottom: 1px solid #e5e7eb; font-weight: bold; width: 40%;">Current Email:</td>
                <td style="padding: 10px 0; border-bottom: 1px solid #e5e7eb;"><a href="mailto:${currentEmail}">${currentEmail}</a></td>
              </tr>
              <tr>
                <td style="padding: 10px 0; border-bottom: 1px solid #e5e7eb; font-weight: bold;">Email Provider:</td>
                <td style="padding: 10px 0; border-bottom: 1px solid #e5e7eb;">${emailProvider}</td>
              </tr>
              <tr>
                <td style="padding: 10px 0; border-bottom: 1px solid #e5e7eb; font-weight: bold;">Number of Accounts:</td>
                <td style="padding: 10px 0; border-bottom: 1px solid #e5e7eb;">${emailCount}</td>
              </tr>
            </table>

            ${notes ? `
              <h2 style="color: #1d71b8; border-bottom: 2px solid #1d71b8; padding-bottom: 10px;">Additional Notes</h2>
              <div style="background: white; padding: 15px; border-radius: 8px; border: 1px solid #e5e7eb;">
                <p style="margin: 0; white-space: pre-wrap;">${notes}</p>
              </div>
            ` : ''}

            <div style="margin-top: 30px; padding: 20px; background: #00D4AA20; border-radius: 8px; border-left: 4px solid #00D4AA;">
              <p style="margin: 0; color: #0f4c75;">
                <strong>⏰ Action Required:</strong> Please contact the customer within 24 hours to initiate the email migration process.
              </p>
            </div>
          </div>

          <div style="text-align: center; padding: 20px; color: #6b7280; font-size: 12px;">
            <p>This email was sent from Pro Gineous Email Migration Request Form</p>
            <p>© ${new Date().getFullYear()} Pro Gineous. All rights reserved.</p>
          </div>
        </div>
      ` : `
        <div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px;">
          <div style="background: linear-gradient(135deg, #1d71b8, #0f4c75); padding: 30px; border-radius: 10px 10px 0 0;">
            <h1 style="color: white; margin: 0; font-size: 24px;">🚀 New Migration Request</h1>
          </div>
          
          <div style="background: #f9fafb; padding: 30px; border: 1px solid #e5e7eb; border-top: none; border-radius: 0 0 10px 10px;">
            <h2 style="color: #1d71b8; border-bottom: 2px solid #1d71b8; padding-bottom: 10px;">Customer Information</h2>
            <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
              <tr>
                <td style="padding: 10px 0; border-bottom: 1px solid #e5e7eb; font-weight: bold; width: 40%;">Full Name:</td>
                <td style="padding: 10px 0; border-bottom: 1px solid #e5e7eb;">${fullName}</td>
              </tr>
              <tr>
                <td style="padding: 10px 0; border-bottom: 1px solid #e5e7eb; font-weight: bold;">Email:</td>
                <td style="padding: 10px 0; border-bottom: 1px solid #e5e7eb;"><a href="mailto:${email}">${email}</a></td>
              </tr>
              <tr>
                <td style="padding: 10px 0; border-bottom: 1px solid #e5e7eb; font-weight: bold;">Phone:</td>
                <td style="padding: 10px 0; border-bottom: 1px solid #e5e7eb;">${countryCode} ${phone}</td>
              </tr>
              <tr>
                <td style="padding: 10px 0; border-bottom: 1px solid #e5e7eb; font-weight: bold;">Support PIN:</td>
                <td style="padding: 10px 0; border-bottom: 1px solid #e5e7eb;"><strong style="color: #1d71b8; font-size: 18px;">${supportPin}</strong></td>
              </tr>
            </table>

            <h2 style="color: #1d71b8; border-bottom: 2px solid #1d71b8; padding-bottom: 10px;">Current Hosting Details</h2>
            <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
              <tr>
                <td style="padding: 10px 0; border-bottom: 1px solid #e5e7eb; font-weight: bold; width: 40%;">Website URL:</td>
                <td style="padding: 10px 0; border-bottom: 1px solid #e5e7eb;"><a href="${websiteUrl}" target="_blank">${websiteUrl}</a></td>
              </tr>
              <tr>
                <td style="padding: 10px 0; border-bottom: 1px solid #e5e7eb; font-weight: bold;">Hosting Provider:</td>
                <td style="padding: 10px 0; border-bottom: 1px solid #e5e7eb;">${hostingProvider}</td>
              </tr>
              <tr>
                <td style="padding: 10px 0; border-bottom: 1px solid #e5e7eb; font-weight: bold;">Hosting Type:</td>
                <td style="padding: 10px 0; border-bottom: 1px solid #e5e7eb;">${hostingType}</td>
              </tr>
              <tr>
                <td style="padding: 10px 0; border-bottom: 1px solid #e5e7eb; font-weight: bold;">Control Panel:</td>
                <td style="padding: 10px 0; border-bottom: 1px solid #e5e7eb;">${controlPanel}</td>
              </tr>
            </table>

            ${notes ? `
              <h2 style="color: #1d71b8; border-bottom: 2px solid #1d71b8; padding-bottom: 10px;">Additional Notes</h2>
              <div style="background: white; padding: 15px; border-radius: 8px; border: 1px solid #e5e7eb;">
                <p style="margin: 0; white-space: pre-wrap;">${notes}</p>
              </div>
            ` : ''}

            <div style="margin-top: 30px; padding: 20px; background: #00D4AA20; border-radius: 8px; border-left: 4px solid #00D4AA;">
              <p style="margin: 0; color: #0f4c75;">
                <strong>⏰ Action Required:</strong> Please contact the customer within 24 hours to initiate the migration process.
              </p>
            </div>
          </div>

          <div style="text-align: center; padding: 20px; color: #6b7280; font-size: 12px;">
            <p>This email was sent from Pro Gineous Migration Request Form</p>
            <p>© ${new Date().getFullYear()} Pro Gineous. All rights reserved.</p>
          </div>
        </div>
      `,
    };

    // Send email
    await transporter.sendMail(mailOptions);

    // Also send confirmation to customer
    const customerMailOptions = {
      from: process.env.SMTP_FROM || 'noreply@progineous.com',
      to: email,
      subject: `${migrationType} Request Received - Pro Gineous`,
      html: isEmailMigration ? `
        <div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px;">
          <div style="background: linear-gradient(135deg, #1d71b8, #0f4c75); padding: 30px; border-radius: 10px 10px 0 0; text-align: center;">
            <h1 style="color: white; margin: 0; font-size: 24px;">✅ Email Migration Request Received</h1>
          </div>
          
          <div style="background: #f9fafb; padding: 30px; border: 1px solid #e5e7eb; border-top: none; border-radius: 0 0 10px 10px;">
            <p style="font-size: 16px;">Dear <strong>${fullName}</strong>,</p>
            
            <p>Thank you for submitting your email migration request. We have received your request and our team will contact you within <strong>24 hours</strong> to begin the migration process.</p>
            
            <div style="background: white; padding: 20px; border-radius: 8px; border: 1px solid #e5e7eb; margin: 20px 0;">
              <h3 style="margin-top: 0; color: #1d71b8;">Request Summary:</h3>
              <p><strong>Email to Migrate:</strong> ${currentEmail}</p>
              <p><strong>Current Provider:</strong> ${emailProvider}</p>
              <p><strong>Number of Accounts:</strong> ${emailCount}</p>
              <p style="margin-bottom: 0;"><strong>Support PIN:</strong> ${supportPin}</p>
            </div>
            
            <div style="background: #00D4AA20; padding: 15px; border-radius: 8px; border-left: 4px solid #00D4AA;">
              <p style="margin: 0;"><strong>What's Next?</strong></p>
              <ul style="margin-bottom: 0;">
                <li>Our email migration specialist will review your request</li>
                <li>We'll contact you to collect email access credentials securely</li>
                <li>All your emails, contacts, and calendars will be migrated safely</li>
                <li>Zero downtime - your email will continue working during migration</li>
              </ul>
            </div>
            
            <p style="margin-top: 20px;">If you have any questions, feel free to reply to this email or contact us at <a href="mailto:migration@progineous.com">migration@progineous.com</a></p>
            
            <p>Best regards,<br><strong>Pro Gineous Migration Team</strong></p>
          </div>

          <div style="text-align: center; padding: 20px; color: #6b7280; font-size: 12px;">
            <p>© ${new Date().getFullYear()} Pro Gineous. All rights reserved.</p>
          </div>
        </div>
      ` : `
        <div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px;">
          <div style="background: linear-gradient(135deg, #1d71b8, #0f4c75); padding: 30px; border-radius: 10px 10px 0 0; text-align: center;">
            <h1 style="color: white; margin: 0; font-size: 24px;">✅ Migration Request Received</h1>
          </div>
          
          <div style="background: #f9fafb; padding: 30px; border: 1px solid #e5e7eb; border-top: none; border-radius: 0 0 10px 10px;">
            <p style="font-size: 16px;">Dear <strong>${fullName}</strong>,</p>
            
            <p>Thank you for submitting your migration request. We have received your request and our team will contact you within <strong>24 hours</strong> to begin the migration process.</p>
            
            <div style="background: white; padding: 20px; border-radius: 8px; border: 1px solid #e5e7eb; margin: 20px 0;">
              <h3 style="margin-top: 0; color: #1d71b8;">Request Summary:</h3>
              <p><strong>Website:</strong> ${websiteUrl}</p>
              <p><strong>Current Provider:</strong> ${hostingProvider}</p>
              <p style="margin-bottom: 0;"><strong>Support PIN:</strong> ${supportPin}</p>
            </div>
            
            <div style="background: #00D4AA20; padding: 15px; border-radius: 8px; border-left: 4px solid #00D4AA;">
              <p style="margin: 0;"><strong>What's Next?</strong></p>
              <ul style="margin-bottom: 0;">
                <li>Our migration specialist will review your request</li>
                <li>We'll contact you to collect access credentials securely</li>
                <li>Your website will be migrated with zero downtime</li>
              </ul>
            </div>
            
            <p style="margin-top: 20px;">If you have any questions, feel free to reply to this email or contact us at <a href="mailto:migration@progineous.com">migration@progineous.com</a></p>
            
            <p>Best regards,<br><strong>Pro Gineous Migration Team</strong></p>
          </div>

          <div style="text-align: center; padding: 20px; color: #6b7280; font-size: 12px;">
            <p>© ${new Date().getFullYear()} Pro Gineous. All rights reserved.</p>
          </div>
        </div>
      `,
    };

    await transporter.sendMail(customerMailOptions);

    return NextResponse.json({ success: true, message: 'Migration request submitted successfully' });
  } catch (error) {
    console.error('Migration request error:', error);
    return NextResponse.json(
      { success: false, message: 'Failed to submit migration request' },
      { status: 500 }
    );
  }
}
