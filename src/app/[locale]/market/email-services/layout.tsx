import type { Metadata } from 'next';

type Props = {
  params: Promise<{ locale: string }>;
};

export async function generateMetadata({ params }: Props): Promise<Metadata> {
  const { locale } = await params;
  const isArabic = locale === 'ar';
  
  const title = isArabic 
    ? 'خدمات البريد الإلكتروني | SpamExperts فلترة وحماية البريد من $2.99/شهر - بروجينيوس'
    : 'Email Services | SpamExperts Email Filtering & Protection from $2.99/mo - Pro Gineous';
  
  const description = isArabic
    ? 'احمِ بريدك الإلكتروني مع SpamExperts. فلترة البريد الوارد والصادر وأرشفة البريد. تخلص من الرسائل المزعجة والفيروسات بدقة 99.98%. حماية شاملة بأسعار تبدأ من $2.99/شهر. خدمة في مصر والسعودية والإمارات وأمريكا وكندا وأوروبا.'
    : 'Protect your email with SpamExperts. Incoming/outgoing email filtering and archiving services. Eliminate spam and viruses with 99.98% accuracy. Complete protection starting at $2.99/mo. Service in USA, UK, Canada, Germany, France, Egypt, Saudi Arabia, UAE.';

  const keywords = isArabic
    ? [
        'فلترة البريد الإلكتروني',
        'حماية البريد من الفيروسات',
        'فلترة الرسائل المزعجة',
        'أرشفة البريد الإلكتروني',
        'حماية البريد الوارد',
        'فلترة البريد الصادر',
        'SpamExperts',
        'حماية البريد للشركات',
        'مكافحة السبام',
        'أمان البريد الإلكتروني',
        'حماية SMTP',
        'فلترة البرامج الضارة',
        'خدمات البريد للأعمال',
        'حماية البريد السحابية',
        'تصفية الرسائل الإلكترونية',
        'email filtering مصر',
        'حماية بريد السعودية',
        'فلترة بريد الإمارات',
        'anti-spam عربي',
        'حماية بريد الشركات',
      ]
    : [
        'email filtering',
        'email virus protection',
        'spam filtering',
        'email archiving',
        'incoming email protection',
        'outgoing email filtering',
        'SpamExperts',
        'business email protection',
        'anti-spam service',
        'email security',
        'SMTP protection',
        'malware filtering',
        'business email services',
        'cloud email protection',
        'email filtering service',
        'email filtering USA',
        'spam protection UK',
        'email security Canada',
        'anti-spam Germany',
        'email filtering France',
        'enterprise email protection',
        'email gateway security',
        'email threat protection',
        'phishing protection',
        'email compliance',
        'email continuity',
        'secure email gateway',
        'email antivirus',
        'professional email protection',
        'managed email security',
      ];

  const baseUrl = process.env.NEXT_PUBLIC_SITE_URL || 'https://progineous.com';
  const canonicalUrl = `${baseUrl}/${locale}/market/email-services`;
  
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
        'en': `${baseUrl}/en/market/email-services`,
        'ar': `${baseUrl}/ar/market/email-services`,
        'en-US': `${baseUrl}/en/market/email-services`,
        'en-GB': `${baseUrl}/en/market/email-services`,
        'en-CA': `${baseUrl}/en/market/email-services`,
        'en-AU': `${baseUrl}/en/market/email-services`,
        'de-DE': `${baseUrl}/en/market/email-services`,
        'fr-FR': `${baseUrl}/en/market/email-services`,
        'ar-EG': `${baseUrl}/ar/market/email-services`,
        'ar-SA': `${baseUrl}/ar/market/email-services`,
        'ar-AE': `${baseUrl}/ar/market/email-services`,
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
          alt: isArabic ? 'خدمات البريد الإلكتروني SpamExperts - بروجينيوس' : 'SpamExperts Email Services - Pro Gineous',
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

export default async function EmailServicesLayout({
  children,
  params,
}: {
  children: React.ReactNode;
  params: Promise<{ locale: string }>;
}) {
  const { locale } = await params;
  const isArabic = locale === 'ar';
  const baseUrl = process.env.NEXT_PUBLIC_SITE_URL || 'https://progineous.com';

  const productSchema = {
    '@context': 'https://schema.org',
    '@type': 'Product',
    name: 'SpamExperts Email Protection',
    description: isArabic
      ? 'فلترة البريد الإلكتروني وحمايته من الرسائل المزعجة والفيروسات بدقة 99.98%'
      : 'Email filtering and protection from spam and viruses with 99.98% accuracy',
    brand: {
      '@type': 'Brand',
      name: 'SpamExperts',
    },
    offers: {
      '@type': 'AggregateOffer',
      lowPrice: '2.99',
      highPrice: '12.99',
      priceCurrency: 'USD',
      availability: 'https://schema.org/InStock',
      offerCount: 4,
      seller: {
        '@type': 'Organization',
        name: 'Pro Gineous',
      },
    },
    aggregateRating: {
      '@type': 'AggregateRating',
      ratingValue: '4.9',
      reviewCount: '2340',
      bestRating: '5',
      worstRating: '1',
    },
    category: 'Email Security Service',
  };

  const faqSchema = {
    '@context': 'https://schema.org',
    '@type': 'FAQPage',
    mainEntity: [
      {
        '@type': 'Question',
        name: isArabic ? 'ما نسبة دقة فلترة الرسائل المزعجة؟' : 'What is the spam filtering accuracy?',
        acceptedAnswer: {
          '@type': 'Answer',
          text: isArabic
            ? 'دقة الفلترة تصل إلى 99.98% مع نسبة false positives أقل من 0.0001%.'
            : 'Filtering accuracy reaches 99.98% with false positive rate less than 0.0001%.',
        },
      },
      {
        '@type': 'Question',
        name: isArabic ? 'هل تتضمن حماية من الفيروسات؟' : 'Does it include virus protection?',
        acceptedAnswer: {
          '@type': 'Answer',
          text: isArabic
            ? 'نعم، تتضمن حماية كاملة من الفيروسات والبرامج الضارة وهجمات التصيد.'
            : 'Yes, it includes complete protection from viruses, malware, and phishing attacks.',
        },
      },
      {
        '@type': 'Question',
        name: isArabic ? 'هل يمكنني أرشفة البريد الإلكتروني؟' : 'Can I archive emails?',
        acceptedAnswer: {
          '@type': 'Answer',
          text: isArabic
            ? 'نعم، نوفر خدمة أرشفة البريد الإلكتروني للامتثال التنظيمي وحفظ السجلات.'
            : 'Yes, we provide email archiving service for regulatory compliance and record keeping.',
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
        name: isArabic ? 'السوق' : 'Market',
        item: `${baseUrl}/${locale}/market`,
      },
      {
        '@type': 'ListItem',
        position: 3,
        name: isArabic ? 'خدمات البريد الإلكتروني' : 'Email Services',
        item: `${baseUrl}/${locale}/market/email-services`,
      },
    ],
  };

  return (
    <>
      <script
        type="application/ld+json"
        dangerouslySetInnerHTML={{ __html: JSON.stringify(productSchema) }}
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
