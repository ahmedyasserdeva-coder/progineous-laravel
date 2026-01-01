import type { Metadata } from 'next';
import Script from 'next/script';

type Props = {
  params: Promise<{ locale: string }>;
  children: React.ReactNode;
};

export async function generateMetadata({ params }: Props): Promise<Metadata> {
  const { locale } = await params;
  const isArabic = locale === 'ar';

  const title = isArabic 
    ? 'تسجيل النطاقات - احجز دومينك الآن بأفضل الأسعار | Pro Gineous'
    : 'Domain Registration - Register Your Domain at Best Prices | Pro Gineous';

  const description = isArabic
    ? 'سجّل نطاقك الآن بأسعار تبدأ من $1.80 فقط! أكثر من 500 امتداد متاح (.com, .net, .sa, .io, .ai). حماية WHOIS مجانية، إدارة DNS كاملة، قفل النقل، ودعم فني 24/7. ابحث عن نطاقك المثالي الآن.'
    : 'Register your domain now starting from just $1.80! 500+ extensions available (.com, .net, .sa, .io, .ai). Free WHOIS protection, full DNS management, transfer lock, and 24/7 support. Find your perfect domain now.';

  const keywordsAr = [
    'تسجيل نطاق',
    'حجز دومين',
    'شراء نطاق',
    'نطاق رخيص',
    'دومين سعودي',
    'نطاق .com',
    'نطاق .net',
    'نطاق .sa',
    'نطاق .io',
    'نطاق .ai',
    'البحث عن نطاق',
    'اسم نطاق',
    'تجديد نطاق',
    'نقل نطاق',
    'حماية WHOIS',
    'إدارة DNS',
    'أفضل أسعار النطاقات',
    'حجز دومين عربي',
    'نطاق للموقع',
    'domain registration',
    'أرخص نطاق',
    'نطاقات جديدة',
    'امتدادات نطاقات',
    'TLD',
    'نطاق أعمال'
  ];

  const keywordsEn = [
    'domain registration',
    'buy domain',
    'register domain',
    'cheap domain',
    'domain names',
    '.com domain',
    '.net domain',
    '.sa domain',
    '.io domain',
    '.ai domain',
    'domain search',
    'domain name',
    'domain renewal',
    'domain transfer',
    'WHOIS protection',
    'DNS management',
    'best domain prices',
    'domain registrar',
    'new domains',
    'domain extensions',
    'TLD pricing',
    'business domain',
    'professional domain',
    'domain hosting',
    'domain availability'
  ];

  return {
    title,
    description,
    keywords: isArabic ? keywordsAr : keywordsEn,
    openGraph: {
      type: 'website',
      locale: isArabic ? 'ar_SA' : 'en_US',
      url: isArabic ? 'https://progineous.com/ar/domains' : 'https://progineous.com/en/domains',
      title,
      description,
      siteName: 'Pro Gineous',
      images: [
        {
          url: `/api/og?title=${encodeURIComponent(title)}&description=${encodeURIComponent(description)}&locale=${locale}&page=domains`,
          width: 1200,
          height: 630,
          alt: isArabic ? 'تسجيل النطاقات من برو جينيوس' : 'Domain Registration by Pro Gineous'
        }
      ]
    },
    twitter: {
      card: 'summary_large_image',
      title,
      description,
      images: [`/api/og?title=${encodeURIComponent(title)}&description=${encodeURIComponent(description)}&locale=${locale}&page=domains`],
    },
    alternates: {
      canonical: isArabic ? 'https://progineous.com/ar/domains' : 'https://progineous.com/en/domains',
      languages: {
        'ar-SA': 'https://progineous.com/ar/domains',
        'en-US': 'https://progineous.com/en/domains',
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
    other: {
      'revisit-after': '3 days',
      'rating': 'general',
      'referrer': 'origin-when-cross-origin',
      'price-range': '$1.80-$50',
    },
  };
}

export default async function DomainsLayout({ children, params }: Props) {
  const { locale } = await params;
  const isArabic = locale === 'ar';

  // JSON-LD Service Schema for Domain Registration
  const serviceSchema = {
    '@context': 'https://schema.org',
    '@type': 'Service',
    name: isArabic ? 'تسجيل النطاقات' : 'Domain Registration',
    description: isArabic
      ? 'خدمة تسجيل وإدارة النطاقات مع أكثر من 500 امتداد متاح'
      : 'Domain registration and management service with 500+ extensions available',
    provider: {
      '@type': 'Organization',
      name: 'Pro Gineous',
      url: 'https://progineous.com',
    },
    areaServed: 'Worldwide',
    hasOfferCatalog: {
      '@type': 'OfferCatalog',
      name: isArabic ? 'امتدادات النطاقات' : 'Domain Extensions',
      itemListElement: [
        {
          '@type': 'Offer',
          itemOffered: { '@type': 'Service', name: '.com Domain' },
          priceCurrency: 'USD',
          price: '10.99',
        },
        {
          '@type': 'Offer',
          itemOffered: { '@type': 'Service', name: '.net Domain' },
          priceCurrency: 'USD',
          price: '12.99',
        },
        {
          '@type': 'Offer',
          itemOffered: { '@type': 'Service', name: '.io Domain' },
          priceCurrency: 'USD',
          price: '39.99',
        },
        {
          '@type': 'Offer',
          itemOffered: { '@type': 'Service', name: '.ai Domain' },
          priceCurrency: 'USD',
          price: '79.99',
        },
      ],
    },
    aggregateRating: {
      '@type': 'AggregateRating',
      ratingValue: '4.8',
      reviewCount: '2134',
      bestRating: '5',
      worstRating: '1',
    },
    url: `https://progineous.com/${locale}/domains`,
  };

  // JSON-LD BreadcrumbList
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
        name: isArabic ? 'النطاقات' : 'Domains',
        item: `https://progineous.com/${locale}/domains`,
      },
    ],
  };

  // JSON-LD FAQ Schema
  const faqSchema = {
    '@context': 'https://schema.org',
    '@type': 'FAQPage',
    mainEntity: [
      {
        '@type': 'Question',
        name: isArabic ? 'كيف أختار اسم نطاق مناسب؟' : 'How do I choose a suitable domain name?',
        acceptedAnswer: {
          '@type': 'Answer',
          text: isArabic
            ? 'اختر اسم قصير وسهل التذكر، يعكس علامتك التجارية أو محتوى موقعك. تجنب الأرقام والشرطات، واختر امتداد يناسب جمهورك (.com للعالمي، .sa للسعودية).'
            : 'Choose a short, memorable name that reflects your brand or content. Avoid numbers and hyphens, and select an extension that fits your audience (.com for global, country codes for local).',
        },
      },
      {
        '@type': 'Question',
        name: isArabic ? 'هل حماية WHOIS مجانية؟' : 'Is WHOIS protection free?',
        acceptedAnswer: {
          '@type': 'Answer',
          text: isArabic
            ? 'نعم، نقدم حماية WHOIS مجانية لجميع النطاقات، مما يحافظ على خصوصية معلوماتك الشخصية من الظهور في سجلات WHOIS العامة.'
            : 'Yes, we offer free WHOIS protection for all domains, keeping your personal information private from public WHOIS records.',
        },
      },
      {
        '@type': 'Question',
        name: isArabic ? 'هل يمكنني نقل نطاقي إليكم؟' : 'Can I transfer my domain to you?',
        acceptedAnswer: {
          '@type': 'Answer',
          text: isArabic
            ? 'نعم، نقل النطاق سهل ومجاني! فقط احصل على رمز النقل من مسجلك الحالي واتبع خطوات النقل. سنضيف سنة مجانية على فترة تسجيلك.'
            : 'Yes, domain transfer is easy and free! Just get the transfer code from your current registrar and follow our transfer steps. We\'ll add a free year to your registration.',
        },
      },
    ],
  };

  return (
    <>
      <Script
        id="domains-service-schema"
        type="application/ld+json"
        dangerouslySetInnerHTML={{ __html: JSON.stringify(serviceSchema) }}
      />
      <Script
        id="domains-breadcrumb-schema"
        type="application/ld+json"
        dangerouslySetInnerHTML={{ __html: JSON.stringify(breadcrumbSchema) }}
      />
      <Script
        id="domains-faq-schema"
        type="application/ld+json"
        dangerouslySetInnerHTML={{ __html: JSON.stringify(faqSchema) }}
      />
      {children}
    </>
  );
}
