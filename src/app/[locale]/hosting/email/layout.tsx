import type { Metadata } from 'next';
import Script from 'next/script';

type Props = {
  children: React.ReactNode;
  params: Promise<{ locale: string }>;
};

export async function generateMetadata({ params }: Props): Promise<Metadata> {
  const { locale } = await params;
  const isArabic = locale === 'ar';

  const title = isArabic 
    ? 'استضافة بريد إلكتروني احترافي - OX App Suite | Pro Gineous'
    : 'Professional Email Hosting - OX App Suite | Pro Gineous';

  const description = isArabic
    ? 'احصل على بريد إلكتروني احترافي بنطاقك الخاص بأسعار تبدأ من $1.69 شهرياً. OX App Suite مع صناديق بريد حتى 25 جيجا، تخزين سحابي، تطبيقات Office، تقويم مشترك، وحماية من السبام. مثالي للشركات.'
    : 'Get professional email with your own domain starting from $1.69/month. OX App Suite with up to 25GB mailboxes, cloud storage, Office apps, shared calendars, and spam protection. Perfect for businesses.';

  const keywordsAr = [
    'بريد إلكتروني احترافي',
    'استضافة بريد',
    'بريد بنطاقك',
    'OX App Suite',
    'بريد الشركات',
    'بريد إلكتروني آمن',
    'صندوق بريد كبير',
    'بريد مع Office',
    'تخزين سحابي',
    'بريد IMAP',
    'تقويم مشترك',
    'CardDAV CalDAV',
    'بريد بدون إعلانات',
    'حماية من السبام',
    'بريد موثوق',
    'email hosting',
    'بريد أعمال',
    'ترحيل بريد',
    'webmail',
    'أفضل بريد إلكتروني',
    // Arab Markets
    'بريد الكتروني مصر',
    'بريد الكتروني السعودية',
    'بريد الكتروني الامارات',
  ];

  const keywordsEn = [
    'professional email hosting',
    'business email',
    'email with own domain',
    'OX App Suite',
    'corporate email',
    'secure email hosting',
    'large mailbox',
    'email with Office',
    'cloud storage email',
    'IMAP email hosting',
    'shared calendars',
    'CardDAV CalDAV',
    'ad-free email',
    'spam protection',
    'reliable email',
    'email hosting service',
    'business email hosting',
    'email migration',
    'webmail hosting',
    'best email hosting',
    // Western Markets
    'email hosting USA',
    'email hosting UK',
    'email hosting Germany',
    'GDPR compliant email',
    'business email USA',
    'business email UK',
    'custom domain email',
    'enterprise email hosting',
  ];

  return {
    title,
    description,
    keywords: isArabic ? keywordsAr : keywordsEn,
    openGraph: {
      type: 'website',
      locale: isArabic ? 'ar_SA' : 'en_US',
      url: isArabic ? 'https://progineous.com/ar/hosting/email' : 'https://progineous.com/en/hosting/email',
      title,
      description,
      siteName: 'Pro Gineous',
      images: [
        {
          url: `/api/og?title=${encodeURIComponent(title)}&description=${encodeURIComponent(description)}&locale=${locale}&page=hosting-email`,
          width: 1200,
          height: 630,
          alt: isArabic ? 'استضافة بريد إلكتروني من برو جينيوس' : 'Email Hosting by Pro Gineous'
        }
      ]
    },
    twitter: {
      card: 'summary_large_image',
      title,
      description,
      images: [`/api/og?title=${encodeURIComponent(title)}&description=${encodeURIComponent(description)}&locale=${locale}&page=hosting-email`],
    },
    alternates: {
      canonical: isArabic ? 'https://progineous.com/ar/hosting/email' : 'https://progineous.com/en/hosting/email',
      languages: {
        'ar-SA': 'https://progineous.com/ar/hosting/email',
        'ar-EG': 'https://progineous.com/ar/hosting/email',
        'ar-AE': 'https://progineous.com/ar/hosting/email',
        'en-US': 'https://progineous.com/en/hosting/email',
        'en-GB': 'https://progineous.com/en/hosting/email',
        'de-DE': 'https://progineous.com/en/hosting/email',
        'fr-FR': 'https://progineous.com/en/hosting/email',
      }
    },
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
  };
}

export default async function EmailHostingLayout({
  children,
  params,
}: Props) {
  const { locale } = await params;
  const isArabic = locale === 'ar';

  // Product Schema for Email Hosting
  const productSchema = {
    '@context': 'https://schema.org',
    '@type': 'Product',
    name: isArabic ? 'استضافة بريد إلكتروني احترافي' : 'Professional Email Hosting',
    description: isArabic
      ? 'بريد إلكتروني احترافي مع OX App Suite، تخزين سحابي، وتطبيقات Office'
      : 'Professional email with OX App Suite, cloud storage, and Office apps',
    brand: {
      '@type': 'Brand',
      name: 'Pro Gineous',
    },
    offers: {
      '@type': 'AggregateOffer',
      priceCurrency: 'USD',
      lowPrice: '1.69',
      highPrice: '8.99',
      offerCount: '4',
      availability: 'https://schema.org/InStock',
    },
    aggregateRating: {
      '@type': 'AggregateRating',
      ratingValue: '4.8',
      reviewCount: '623',
      bestRating: '5',
      worstRating: '1',
    },
  };

  // FAQ Schema
  const faqSchema = {
    '@context': 'https://schema.org',
    '@type': 'FAQPage',
    mainEntity: [
      {
        '@type': 'Question',
        name: isArabic ? 'ما هو OX App Suite؟' : 'What is OX App Suite?',
        acceptedAnswer: {
          '@type': 'Answer',
          text: isArabic
            ? 'OX App Suite هو منصة بريد إلكتروني احترافية تشمل Webmail، تطبيقات Office (Word، Excel، PowerPoint)، تخزين سحابي، وتقويم مشترك'
            : 'OX App Suite is a professional email platform that includes Webmail, Office apps (Word, Excel, PowerPoint), cloud storage, and shared calendars'
        }
      },
      {
        '@type': 'Question',
        name: isArabic ? 'هل يمكن ترحيل بريدي الحالي؟' : 'Can I migrate my existing email?',
        acceptedAnswer: {
          '@type': 'Answer',
          text: isArabic
            ? 'نعم، نوفر ترحيل مجاني لجميع صناديق البريد من Gmail، Outlook، أو أي مزود آخر مع الحفاظ على جميع الرسائل'
            : 'Yes, we offer free migration for all mailboxes from Gmail, Outlook, or any other provider while preserving all messages'
        }
      },
    ],
  };

  // Breadcrumb Schema
  const breadcrumbSchema = {
    '@context': 'https://schema.org',
    '@type': 'BreadcrumbList',
    itemListElement: [
      {
        '@type': 'ListItem',
        position: 1,
        name: isArabic ? 'الرئيسية' : 'Home',
        item: `https://progineous.com/${locale}`,
      },
      {
        '@type': 'ListItem',
        position: 2,
        name: isArabic ? 'الاستضافة' : 'Hosting',
        item: `https://progineous.com/${locale}/hosting`,
      },
      {
        '@type': 'ListItem',
        position: 3,
        name: isArabic ? 'استضافة البريد' : 'Email Hosting',
        item: `https://progineous.com/${locale}/hosting/email`,
      },
    ],
  };

  return (
    <>
      <Script
        id="email-product-schema"
        type="application/ld+json"
        dangerouslySetInnerHTML={{ __html: JSON.stringify(productSchema) }}
      />
      <Script
        id="email-faq-schema"
        type="application/ld+json"
        dangerouslySetInnerHTML={{ __html: JSON.stringify(faqSchema) }}
      />
      <Script
        id="email-breadcrumb-schema"
        type="application/ld+json"
        dangerouslySetInnerHTML={{ __html: JSON.stringify(breadcrumbSchema) }}
      />
      {children}
    </>
  );
}
