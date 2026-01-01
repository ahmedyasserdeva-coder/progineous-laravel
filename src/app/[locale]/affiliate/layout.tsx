import type { Metadata } from 'next';
import Script from 'next/script';

type Props = {
  children: React.ReactNode;
  params: Promise<{ locale: string }>;
};

export async function generateMetadata({ params }: Props): Promise<Metadata> {
  const { locale } = await params;
  const isArabic = locale === 'ar';
  const baseUrl = process.env.NEXT_PUBLIC_SITE_URL || 'https://progineous.com';

  const title = isArabic
    ? 'برنامج الأفلييت | بروجينيوس - اربح عمولات على كل عملية بيع'
    : 'Affiliate Program | Pro Gineous - Earn Commissions on Every Sale';
  const description = isArabic
    ? 'انضم لبرنامج الأفلييت في بروجينيوس واربح حتى 125 دولار لكل عملية بيع. سجل مجاناً واحصل على روابط تتبع وأدوات تسويقية متقدمة.'
    : 'Join Pro Gineous Affiliate Program and earn up to $125 per sale. Sign up for free and get tracking links and advanced marketing tools.';

  return {
    title,
    description,
    keywords: isArabic
      ? [
          'برنامج أفلييت',
          'ربح عمولات',
          'التسويق بالعمولة',
          'أفلييت استضافة',
          'ربح من الإنترنت',
          'برنامج شركاء',
          'عمولة استضافة',
          'تسويق رقمي',
          'دخل إضافي',
          'برنامج إحالة',
          'شراكة تسويقية',
          'ربح مال',
          'تسويق استضافة',
          'برو جينيوس أفلييت',
          'عمولات مبيعات',
          // Arab Markets
          'افلييت مصر',
          'افلييت السعودية',
          'ربح من الانترنت مصر',
        ]
      : [
          'affiliate program',
          'earn commissions',
          'affiliate marketing',
          'hosting affiliate',
          'make money online',
          'partner program',
          'hosting commission',
          'digital marketing',
          'passive income',
          'referral program',
          'marketing partnership',
          'earn money',
          'hosting marketing',
          'pro gineous affiliate',
          'sales commissions',
          // Western Markets
          'affiliate program USA',
          'hosting affiliate UK',
          'web hosting affiliate',
          'best hosting affiliate program',
          'high paying affiliate',
          '$125 commission hosting',
        ],
    openGraph: {
      title: isArabic
        ? 'برنامج الأفلييت | بروجينيوس'
        : 'Affiliate Program | Pro Gineous',
      description: isArabic
        ? 'انضم لبرنامج الأفلييت واربح حتى 125 دولار لكل عملية بيع'
        : 'Join our affiliate program and earn up to $125 per sale',
      url: `${baseUrl}/${locale}/affiliate`,
      siteName: 'Pro Gineous',
      locale: isArabic ? 'ar_EG' : 'en_US',
      type: 'website',
      images: [
        {
          url: `/api/og?title=${encodeURIComponent(title)}&description=${encodeURIComponent(description)}&locale=${locale}&page=affiliate`,
          width: 1200,
          height: 630,
          alt: isArabic ? 'برنامج الأفلييت - بروجينيوس' : 'Affiliate Program - Pro Gineous',
        },
      ],
    },
    twitter: {
      card: 'summary_large_image',
      title: isArabic
        ? 'برنامج الأفلييت | بروجينيوس'
        : 'Affiliate Program | Pro Gineous',
      description: isArabic
        ? 'اربح حتى 125 دولار لكل عملية بيع'
        : 'Earn up to $125 per sale',
      images: [`/api/og?title=${encodeURIComponent(title)}&description=${encodeURIComponent(description)}&locale=${locale}&page=affiliate`],
    },
    alternates: {
      canonical: `${baseUrl}/${locale}/affiliate`,
      languages: {
        en: `${baseUrl}/en/affiliate`,
        ar: `${baseUrl}/ar/affiliate`,
        'en-US': `${baseUrl}/en/affiliate`,
        'en-GB': `${baseUrl}/en/affiliate`,
        'de-DE': `${baseUrl}/en/affiliate`,
        'fr-FR': `${baseUrl}/en/affiliate`,
      },
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

export default async function AffiliateLayout({ children, params }: Props) {
  const { locale } = await params;
  const isArabic = locale === 'ar';

  // Affiliate Program Schema
  const affiliateSchema = {
    '@context': 'https://schema.org',
    '@type': 'WebPage',
    name: isArabic ? 'برنامج الأفلييت - برو جينيوس' : 'Affiliate Program - Pro Gineous',
    description: isArabic
      ? 'اربح حتى $125 لكل عملية بيع مع برنامج الأفلييت'
      : 'Earn up to $125 per sale with our affiliate program',
    url: `https://progineous.com/${locale}/affiliate`,
    mainEntity: {
      '@type': 'Offer',
      name: isArabic ? 'برنامج الأفلييت' : 'Affiliate Program',
      description: isArabic
        ? 'اربح عمولات على كل عملية بيع'
        : 'Earn commissions on every sale',
      price: '125',
      priceCurrency: 'USD',
      availability: 'https://schema.org/InStock',
    },
  };

  // FAQ Schema
  const faqSchema = {
    '@context': 'https://schema.org',
    '@type': 'FAQPage',
    mainEntity: [
      {
        '@type': 'Question',
        name: isArabic ? 'كم يمكنني أن أربح من برنامج الأفلييت؟' : 'How much can I earn from the affiliate program?',
        acceptedAnswer: {
          '@type': 'Answer',
          text: isArabic
            ? 'يمكنك ربح حتى $125 لكل عملية بيع ناجحة، مع عمولات متكررة على التجديدات'
            : 'You can earn up to $125 per successful sale, with recurring commissions on renewals'
        }
      },
      {
        '@type': 'Question',
        name: isArabic ? 'كيف أنضم لبرنامج الأفلييت؟' : 'How do I join the affiliate program?',
        acceptedAnswer: {
          '@type': 'Answer',
          text: isArabic
            ? 'سجل مجاناً في صفحة الأفلييت واحصل على روابط التتبع الخاصة بك فوراً'
            : 'Sign up for free on the affiliate page and get your tracking links instantly'
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
        name: isArabic ? 'برنامج الأفلييت' : 'Affiliate Program',
        item: `https://progineous.com/${locale}/affiliate`,
      },
    ],
  };

  return (
    <>
      <Script
        id="affiliate-schema"
        type="application/ld+json"
        dangerouslySetInnerHTML={{ __html: JSON.stringify(affiliateSchema) }}
      />
      <Script
        id="affiliate-faq-schema"
        type="application/ld+json"
        dangerouslySetInnerHTML={{ __html: JSON.stringify(faqSchema) }}
      />
      <Script
        id="affiliate-breadcrumb-schema"
        type="application/ld+json"
        dangerouslySetInnerHTML={{ __html: JSON.stringify(breadcrumbSchema) }}
      />
      {children}
    </>
  );
}
