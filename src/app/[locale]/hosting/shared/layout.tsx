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
    ? 'استضافة مشتركة - أفضل استضافة مواقع رخيصة وسريعة | Pro Gineous'
    : 'Shared Hosting - Best Cheap & Fast Web Hosting | Pro Gineous';

  const description = isArabic
    ? 'احصل على أفضل استضافة مشتركة بأسعار تبدأ من $2 شهرياً. استضافة سريعة مع LiteSpeed، شهادة SSL مجانية، cPanel، نقل مجاني، دعم 24/7، وضمان استرداد 30 يوم. مثالية للمواقع الصغيرة والمدونات ومواقع الأعمال.'
    : 'Get the best shared hosting starting from $2/month. Fast hosting with LiteSpeed, free SSL, cPanel, free migration, 24/7 support, and 30-day money-back guarantee. Perfect for small websites, blogs, and business sites.';

  const keywordsAr = [
    'استضافة مشتركة',
    'استضافة مواقع رخيصة',
    'استضافة ووردبريس',
    'أرخص استضافة',
    'استضافة cPanel',
    'استضافة LiteSpeed',
    'استضافة مع SSL مجاني',
    'استضافة مدونة',
    'استضافة موقع شخصي',
    'استضافة أعمال صغيرة',
    'شراء استضافة',
    'أفضل شركة استضافة',
    'استضافة سريعة',
    'استضافة موثوقة',
    'استضافة عربية',
    'استضافة سعودية',
    'نقل موقع مجاني',
    'استضافة NVMe SSD',
    'استضافة غير محدودة',
    'حجز استضافة'
  ];

  const keywordsEn = [
    'shared hosting',
    'cheap web hosting',
    'WordPress hosting',
    'affordable hosting',
    'cPanel hosting',
    'LiteSpeed hosting',
    'free SSL hosting',
    'blog hosting',
    'personal website hosting',
    'small business hosting',
    'buy web hosting',
    'best hosting company',
    'fast hosting',
    'reliable hosting',
    'budget hosting',
    'starter hosting',
    'free website migration',
    'NVMe SSD hosting',
    'unlimited hosting',
    'web hosting plans'
  ];

  return {
    title,
    description,
    keywords: isArabic ? keywordsAr : keywordsEn,
    openGraph: {
      type: 'website',
      locale: isArabic ? 'ar_SA' : 'en_US',
      url: isArabic ? 'https://progineous.com/ar/hosting/shared' : 'https://progineous.com/en/hosting/shared',
      title,
      description,
      siteName: 'Pro Gineous',
      images: [
        {
          url: `/api/og?title=${encodeURIComponent(title)}&description=${encodeURIComponent(description)}&locale=${locale}&page=hosting-shared`,
          width: 1200,
          height: 630,
          alt: isArabic ? 'استضافة مشتركة من برو جينيوس' : 'Shared Hosting by Pro Gineous'
        }
      ]
    },
    twitter: {
      card: 'summary_large_image',
      title,
      description,
      images: [`/api/og?title=${encodeURIComponent(title)}&description=${encodeURIComponent(description)}&locale=${locale}&page=hosting-shared`],
    },
    alternates: {
      canonical: isArabic ? 'https://progineous.com/ar/hosting/shared' : 'https://progineous.com/en/hosting/shared',
      languages: {
        'ar-SA': 'https://progineous.com/ar/hosting/shared',
        'en-US': 'https://progineous.com/en/hosting/shared',
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
      'revisit-after': '7 days',
      'rating': 'general',
      'referrer': 'origin-when-cross-origin',
      'price-range': '$2-$20',
    },
  };
}

export default async function SharedHostingLayout({ children, params }: Props) {
  const { locale } = await params;
  const isArabic = locale === 'ar';

  // JSON-LD Product Schema for Shared Hosting
  const productSchema = {
    '@context': 'https://schema.org',
    '@type': 'Product',
    name: isArabic ? 'استضافة مشتركة' : 'Shared Hosting',
    description: isArabic
      ? 'استضافة مواقع مشتركة سريعة وموثوقة مع LiteSpeed و cPanel'
      : 'Fast and reliable shared web hosting with LiteSpeed and cPanel',
    brand: {
      '@type': 'Brand',
      name: 'Pro Gineous',
    },
    offers: {
      '@type': 'AggregateOffer',
      priceCurrency: 'USD',
      lowPrice: '2',
      highPrice: '20',
      offerCount: '4',
      availability: 'https://schema.org/InStock',
      priceValidUntil: '2026-12-31',
      seller: {
        '@type': 'Organization',
        name: 'Pro Gineous',
      },
    },
    aggregateRating: {
      '@type': 'AggregateRating',
      ratingValue: '4.8',
      reviewCount: '1247',
      bestRating: '5',
      worstRating: '1',
    },
    category: 'Web Hosting',
    url: `https://progineous.com/${locale}/hosting/shared`,
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
        name: isArabic ? 'الاستضافة' : 'Hosting',
        item: `https://progineous.com/${locale}/hosting`,
      },
      {
        '@type': 'ListItem',
        position: 3,
        name: isArabic ? 'استضافة مشتركة' : 'Shared Hosting',
        item: `https://progineous.com/${locale}/hosting/shared`,
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
        name: isArabic ? 'ما هي الاستضافة المشتركة؟' : 'What is shared hosting?',
        acceptedAnswer: {
          '@type': 'Answer',
          text: isArabic
            ? 'الاستضافة المشتركة هي نوع من استضافة الويب حيث يتشارك عدة مواقع في موارد خادم واحد، مما يجعلها خياراً اقتصادياً للمواقع الصغيرة والمتوسطة.'
            : 'Shared hosting is a type of web hosting where multiple websites share the resources of a single server, making it an economical option for small to medium websites.',
        },
      },
      {
        '@type': 'Question',
        name: isArabic ? 'هل الاستضافة المشتركة آمنة؟' : 'Is shared hosting secure?',
        acceptedAnswer: {
          '@type': 'Answer',
          text: isArabic
            ? 'نعم، نحن نوفر حماية متقدمة تشمل شهادة SSL مجانية، حماية DDoS، وجدار حماية متقدم لجميع حسابات الاستضافة المشتركة.'
            : 'Yes, we provide advanced security including free SSL certificates, DDoS protection, and advanced firewall for all shared hosting accounts.',
        },
      },
      {
        '@type': 'Question',
        name: isArabic ? 'هل يمكنني ترقية خطتي لاحقاً؟' : 'Can I upgrade my plan later?',
        acceptedAnswer: {
          '@type': 'Answer',
          text: isArabic
            ? 'بالطبع! يمكنك الترقية في أي وقت إلى خطة أعلى أو إلى استضافة سحابية أو VPS بسهولة من لوحة التحكم.'
            : 'Absolutely! You can upgrade anytime to a higher plan or to cloud/VPS hosting easily from your control panel.',
        },
      },
    ],
  };

  return (
    <>
      <Script
        id="shared-hosting-product-schema"
        type="application/ld+json"
        dangerouslySetInnerHTML={{ __html: JSON.stringify(productSchema) }}
      />
      <Script
        id="shared-hosting-breadcrumb-schema"
        type="application/ld+json"
        dangerouslySetInnerHTML={{ __html: JSON.stringify(breadcrumbSchema) }}
      />
      <Script
        id="shared-hosting-faq-schema"
        type="application/ld+json"
        dangerouslySetInnerHTML={{ __html: JSON.stringify(faqSchema) }}
      />
      {children}
    </>
  );
}
