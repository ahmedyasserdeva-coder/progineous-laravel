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
    ? 'استضافة سحابية مُدارة - سيرفرات كلاود سريعة وآمنة | Pro Gineous'
    : 'Managed Cloud Hosting - Fast & Secure Cloud Servers | Pro Gineous';

  const description = isArabic
    ? 'احصل على استضافة سحابية مُدارة بالكامل بأسعار تبدأ من $4 شهرياً. سيرفرات كلاود بمعالجات الجيل 13، NVMe SSD، حماية DDoS، دعم 24/7، وضمان استرداد 30 يوم. مثالية للمواقع الكبيرة والمتاجر الإلكترونية.'
    : 'Get fully managed cloud hosting starting from $4/month. Cloud servers with Gen 13 processors, NVMe SSD, DDoS protection, 24/7 support, and 30-day money-back guarantee. Perfect for large websites and e-commerce stores.';

  const keywordsAr = [
    'استضافة سحابية',
    'استضافة كلاود',
    'سيرفر كلاود',
    'استضافة مُدارة',
    'كلاود هوستنج',
    'استضافة VPS',
    'سيرفر سحابي',
    'استضافة متاجر',
    'استضافة ووردبريس سريعة',
    'استضافة NVMe',
    'سيرفر مخصص',
    'استضافة أداء عالي',
    'استضافة آمنة',
    'كلاود سيرفر',
    'استضافة أعمال',
    'سيرفر LiteSpeed',
    'استضافة موثوقة',
    'أفضل استضافة سحابية',
    'شراء سيرفر كلاود',
    'استضافة cPanel كلاود'
  ];

  const keywordsEn = [
    'cloud hosting',
    'managed cloud hosting',
    'cloud server',
    'VPS hosting',
    'cloud VPS',
    'managed VPS',
    'high performance hosting',
    'NVMe cloud hosting',
    'WordPress cloud hosting',
    'ecommerce hosting',
    'business cloud hosting',
    'LiteSpeed cloud',
    'cPanel cloud hosting',
    'scalable hosting',
    'reliable cloud hosting',
    'secure cloud hosting',
    'best cloud hosting',
    'cloud server hosting',
    'dedicated cloud',
    'Gen 13 cloud hosting'
  ];

  return {
    title,
    description,
    keywords: isArabic ? keywordsAr : keywordsEn,
    openGraph: {
      type: 'website',
      locale: isArabic ? 'ar_SA' : 'en_US',
      url: isArabic ? 'https://progineous.com/ar/hosting/cloud' : 'https://progineous.com/en/hosting/cloud',
      title,
      description,
      siteName: 'Pro Gineous',
      images: [
        {
          url: `/api/og?title=${encodeURIComponent(title)}&description=${encodeURIComponent(description)}&locale=${locale}&page=hosting-cloud`,
          width: 1200,
          height: 630,
          alt: isArabic ? 'استضافة سحابية من برو جينيوس' : 'Cloud Hosting by Pro Gineous'
        }
      ]
    },
    twitter: {
      card: 'summary_large_image',
      title,
      description,
      images: [`/api/og?title=${encodeURIComponent(title)}&description=${encodeURIComponent(description)}&locale=${locale}&page=hosting-cloud`],
    },
    alternates: {
      canonical: isArabic ? 'https://progineous.com/ar/hosting/cloud' : 'https://progineous.com/en/hosting/cloud',
      languages: {
        'ar-SA': 'https://progineous.com/ar/hosting/cloud',
        'en-US': 'https://progineous.com/en/hosting/cloud',
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
      'price-range': '$4-$50',
    },
  };
}

export default async function CloudHostingLayout({ children, params }: Props) {
  const { locale } = await params;
  const isArabic = locale === 'ar';

  // JSON-LD Product Schema for Cloud Hosting
  const productSchema = {
    '@context': 'https://schema.org',
    '@type': 'Product',
    name: isArabic ? 'استضافة سحابية مُدارة' : 'Managed Cloud Hosting',
    description: isArabic
      ? 'استضافة سحابية بأداء عالي مع معالجات الجيل 13 و NVMe SSD وحماية DDoS'
      : 'High-performance cloud hosting with Gen 13 processors, NVMe SSD, and DDoS protection',
    brand: {
      '@type': 'Brand',
      name: 'Pro Gineous',
    },
    offers: {
      '@type': 'AggregateOffer',
      priceCurrency: 'USD',
      lowPrice: '4',
      highPrice: '50',
      offerCount: '5',
      availability: 'https://schema.org/InStock',
      priceValidUntil: '2026-12-31',
      seller: {
        '@type': 'Organization',
        name: 'Pro Gineous',
      },
    },
    aggregateRating: {
      '@type': 'AggregateRating',
      ratingValue: '4.9',
      reviewCount: '1456',
      bestRating: '5',
      worstRating: '1',
    },
    category: 'Cloud Hosting',
    url: `https://progineous.com/${locale}/hosting/cloud`,
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
        name: isArabic ? 'استضافة سحابية' : 'Cloud Hosting',
        item: `https://progineous.com/${locale}/hosting/cloud`,
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
        name: isArabic ? 'ما هي الاستضافة السحابية المُدارة؟' : 'What is managed cloud hosting?',
        acceptedAnswer: {
          '@type': 'Answer',
          text: isArabic
            ? 'الاستضافة السحابية المُدارة توفر لك موارد سحابية مخصصة مع إدارة كاملة من فريقنا التقني، بما في ذلك التحديثات والأمان والنسخ الاحتياطي.'
            : 'Managed cloud hosting provides dedicated cloud resources with full management from our technical team, including updates, security, and backups.',
        },
      },
      {
        '@type': 'Question',
        name: isArabic ? 'ما الفرق بين الاستضافة السحابية والمشتركة؟' : 'What is the difference between cloud and shared hosting?',
        acceptedAnswer: {
          '@type': 'Answer',
          text: isArabic
            ? 'الاستضافة السحابية توفر موارد مخصصة وقابلة للتوسع بسهولة مع أداء أعلى وموثوقية أكبر، بينما المشتركة تتشارك الموارد مع مواقع أخرى.'
            : 'Cloud hosting provides dedicated, easily scalable resources with higher performance and reliability, while shared hosting shares resources with other websites.',
        },
      },
      {
        '@type': 'Question',
        name: isArabic ? 'هل الاستضافة السحابية مناسبة للمتاجر الإلكترونية؟' : 'Is cloud hosting suitable for e-commerce stores?',
        acceptedAnswer: {
          '@type': 'Answer',
          text: isArabic
            ? 'نعم، الاستضافة السحابية مثالية للمتاجر الإلكترونية بفضل الأداء العالي، الأمان المتقدم، وإمكانية التوسع لاستيعاب الزيارات المرتفعة.'
            : 'Yes, cloud hosting is ideal for e-commerce stores thanks to high performance, advanced security, and scalability to handle high traffic.',
        },
      },
    ],
  };

  return (
    <>
      <Script
        id="cloud-hosting-product-schema"
        type="application/ld+json"
        dangerouslySetInnerHTML={{ __html: JSON.stringify(productSchema) }}
      />
      <Script
        id="cloud-hosting-breadcrumb-schema"
        type="application/ld+json"
        dangerouslySetInnerHTML={{ __html: JSON.stringify(breadcrumbSchema) }}
      />
      <Script
        id="cloud-hosting-faq-schema"
        type="application/ld+json"
        dangerouslySetInnerHTML={{ __html: JSON.stringify(faqSchema) }}
      />
      {children}
    </>
  );
}
