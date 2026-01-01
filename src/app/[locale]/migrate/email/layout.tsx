import type { Metadata } from 'next';

type Props = {
  params: Promise<{ locale: string }>;
};

export async function generateMetadata({ params }: Props): Promise<Metadata> {
  const { locale } = await params;
  const isArabic = locale === 'ar';
  
  const title = isArabic 
    ? 'نقل البريد الإلكتروني مجاناً | انقل بريدك بدون فقدان بيانات - بروجينيوس'
    : 'Free Email Migration | Transfer Email with Zero Data Loss - Pro Gineous';
  
  const description = isArabic
    ? 'انقل بريدك الإلكتروني إلينا مجاناً بدون فقدان بيانات! نقل جميع الرسائل والمجلدات وجهات الاتصال والتقويمات. نقل مشفر 100% وآمن خلال 24-48 ساعة. نقل من Gmail، Outlook، Office 365، cPanel. خدمة في مصر والسعودية والإمارات وأمريكا وكندا وأوروبا.'
    : 'Migrate your email to us for FREE with zero data loss! Transfer all messages, folders, contacts, and calendars. 100% encrypted and secure transfer within 24-48 hours. Migrate from Gmail, Outlook, Office 365, cPanel. Service in USA, UK, Canada, Germany, France, Egypt, Saudi Arabia, UAE.';

  const keywords = isArabic
    ? [
        'نقل البريد الإلكتروني',
        'نقل الإيميل',
        'ترحيل البريد',
        'نقل بريد مجاني',
        'نقل صندوق البريد',
        'نقل جهات الاتصال',
        'نقل التقويم',
        'نقل من Gmail',
        'نقل من Outlook',
        'نقل بريد الشركة',
        'نقل البريد بدون فقدان',
        'نقل رسائل البريد',
        'تغيير مزود البريد',
        'نقل بريد آمن',
        'خدمة نقل البريد',
        'نقل Office 365',
        'نقل بريد cPanel',
        'نقل بريد مصر',
        'نقل بريد السعودية',
        'نقل إيميل الإمارات',
        'IMAP migration',
        'نقل بريد للشركات',
        'نقل البريد السحابي',
      ]
    : [
        'email migration',
        'email transfer',
        'email relocation',
        'free email migration',
        'mailbox migration',
        'contacts migration',
        'calendar migration',
        'migrate from Gmail',
        'migrate from Outlook',
        'business email migration',
        'email migration no data loss',
        'email messages transfer',
        'change email provider',
        'secure email migration',
        'email migration service',
        'Office 365 migration',
        'cPanel email migration',
        'IMAP migration',
        'email migration USA',
        'email transfer UK',
        'email migration Canada',
        'email migration Germany',
        'email migration France',
        'corporate email migration',
        'cloud email migration',
        'G Suite migration',
        'Exchange migration',
        'email hosting transfer',
        'bulk email migration',
        'managed email migration',
      ];

  const baseUrl = process.env.NEXT_PUBLIC_SITE_URL || 'https://progineous.com';
  const canonicalUrl = `${baseUrl}/${locale}/migrate/email`;
  
  return {
    title,
    description,
    keywords: keywords.join(', '),
    authors: [{ name: 'Pro Gineous' }],
    creator: 'Pro Gineous',
    publisher: 'Pro Gineous',
    robots: {
      index: true,
      follow: true,
      googleBot: {
        index: true,
        follow: true,
        'max-video-preview': -1,
        'max-image-preview': 'large',
        'max-snippet': -1,
      },
    },
    alternates: {
      canonical: canonicalUrl,
      languages: {
        'en': `${baseUrl}/en/migrate/email`,
        'ar': `${baseUrl}/ar/migrate/email`,
        'en-US': `${baseUrl}/en/migrate/email`,
        'en-GB': `${baseUrl}/en/migrate/email`,
        'en-CA': `${baseUrl}/en/migrate/email`,
        'en-AU': `${baseUrl}/en/migrate/email`,
        'de-DE': `${baseUrl}/en/migrate/email`,
        'fr-FR': `${baseUrl}/en/migrate/email`,
        'ar-EG': `${baseUrl}/ar/migrate/email`,
        'ar-SA': `${baseUrl}/ar/migrate/email`,
        'ar-AE': `${baseUrl}/ar/migrate/email`,
      },
    },
    openGraph: {
      type: 'website',
      locale: isArabic ? 'ar_SA' : 'en_US',
      alternateLocale: isArabic ? ['en_US', 'en_GB', 'de_DE', 'fr_FR'] : ['ar_SA', 'ar_EG', 'ar_AE'],
      url: canonicalUrl,
      title,
      description,
      siteName: 'Pro Gineous',
      images: [
        {
          url: `/api/og?title=${encodeURIComponent(title)}&description=${encodeURIComponent(description)}&locale=${locale}&page=default`,
          width: 1200,
          height: 630,
          alt: isArabic ? 'نقل البريد الإلكتروني مجاناً - بروجينيوس' : 'Free Email Migration - Pro Gineous',
        },
      ],
    },
    twitter: {
      card: 'summary_large_image',
      title,
      description,
      images: [`/api/og?title=${encodeURIComponent(title)}&description=${encodeURIComponent(description)}&locale=${locale}&page=default`],
      creator: '@progineous',
      site: '@progineous',
    },
  };
}

export default async function EmailMigrationLayout({
  children,
  params,
}: {
  children: React.ReactNode;
  params: Promise<{ locale: string }>;
}) {
  const { locale } = await params;
  const isArabic = locale === 'ar';
  const baseUrl = process.env.NEXT_PUBLIC_SITE_URL || 'https://progineous.com';

  const serviceSchema = {
    '@context': 'https://schema.org',
    '@type': 'Service',
    name: isArabic ? 'خدمة نقل البريد الإلكتروني المجانية' : 'Free Email Migration Service',
    description: isArabic
      ? 'نقل بريدك الإلكتروني مجاناً بدون فقدان أي بيانات مع فريق خبراء'
      : 'Migrate your email for FREE with zero data loss by expert team',
    provider: {
      '@type': 'Organization',
      name: 'Pro Gineous',
      url: baseUrl,
    },
    serviceType: 'Email Migration',
    areaServed: [
      { '@type': 'Country', name: 'United States' },
      { '@type': 'Country', name: 'United Kingdom' },
      { '@type': 'Country', name: 'Canada' },
      { '@type': 'Country', name: 'Germany' },
      { '@type': 'Country', name: 'France' },
      { '@type': 'Country', name: 'Australia' },
      { '@type': 'Country', name: 'Egypt' },
      { '@type': 'Country', name: 'Saudi Arabia' },
      { '@type': 'Country', name: 'United Arab Emirates' },
    ],
    offers: {
      '@type': 'Offer',
      price: '0',
      priceCurrency: 'USD',
      availability: 'https://schema.org/InStock',
      priceValidUntil: '2025-12-31',
    },
    termsOfService: `${baseUrl}/terms`,
  };

  const faqSchema = {
    '@context': 'https://schema.org',
    '@type': 'FAQPage',
    mainEntity: [
      {
        '@type': 'Question',
        name: isArabic ? 'هل سأفقد أي رسائل أثناء النقل؟' : 'Will I lose any emails during migration?',
        acceptedAnswer: {
          '@type': 'Answer',
          text: isArabic
            ? 'لا، نضمن نقل 100% من رسائلك ومجلداتك وجهات اتصالك بدون فقدان أي بيانات.'
            : 'No, we guarantee 100% transfer of all your emails, folders, and contacts with zero data loss.',
        },
      },
      {
        '@type': 'Question',
        name: isArabic ? 'من أين يمكنني نقل بريدي؟' : 'From where can I migrate my email?',
        acceptedAnswer: {
          '@type': 'Answer',
          text: isArabic
            ? 'يمكننا نقل بريدك من Gmail، Outlook، Office 365، cPanel، Plesk، أو أي مزود بريد آخر يدعم IMAP.'
            : 'We can migrate your email from Gmail, Outlook, Office 365, cPanel, Plesk, or any other provider supporting IMAP.',
        },
      },
      {
        '@type': 'Question',
        name: isArabic ? 'هل نقل البريد مجاني؟' : 'Is email migration free?',
        acceptedAnswer: {
          '@type': 'Answer',
          text: isArabic
            ? 'نعم، نقل البريد مجاني تماماً مع أي خطة استضافة بريد إلكتروني.'
            : 'Yes, email migration is completely free with any email hosting plan.',
        },
      },
    ],
  };

  const breadcrumbSchema = {
    '@context': 'https://schema.org',
    '@type': 'BreadcrumbList',
    itemListElement: [
      {
        '@type': 'ListItem',
        position: 1,
        name: isArabic ? 'الرئيسية' : 'Home',
        item: `${baseUrl}/${locale}`,
      },
      {
        '@type': 'ListItem',
        position: 2,
        name: isArabic ? 'نقل' : 'Migrate',
        item: `${baseUrl}/${locale}/migrate`,
      },
      {
        '@type': 'ListItem',
        position: 3,
        name: isArabic ? 'نقل البريد الإلكتروني' : 'Email Migration',
        item: `${baseUrl}/${locale}/migrate/email`,
      },
    ],
  };

  return (
    <>
      <script
        type="application/ld+json"
        dangerouslySetInnerHTML={{ __html: JSON.stringify(serviceSchema) }}
      />
      <script
        type="application/ld+json"
        dangerouslySetInnerHTML={{ __html: JSON.stringify(faqSchema) }}
      />
      <script
        type="application/ld+json"
        dangerouslySetInnerHTML={{ __html: JSON.stringify(breadcrumbSchema) }}
      />
      {children}
    </>
  );
}
