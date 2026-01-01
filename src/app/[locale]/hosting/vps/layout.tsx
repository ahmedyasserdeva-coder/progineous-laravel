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
    ? 'سيرفرات VPS - خوادم افتراضية خاصة سريعة وآمنة | Pro Gineous'
    : 'VPS Servers - Fast & Secure Virtual Private Servers | Pro Gineous';

  const description = isArabic
    ? 'احصل على سيرفر VPS قوي بأسعار تبدأ من $15 شهرياً. خوادم افتراضية بصلاحيات Root كاملة، NVMe SSD، معالجات Intel، دعم 24/7. مثالية للمطورين والشركات والمتاجر الإلكترونية.'
    : 'Get a powerful VPS server starting from $15/month. Virtual servers with full Root access, NVMe SSD, Intel processors, 24/7 support. Perfect for developers, businesses, and e-commerce stores.';

  const keywordsAr = [
    'سيرفر VPS',
    'خادم افتراضي خاص',
    'VPS رخيص',
    'استضافة VPS',
    'سيرفر لينكس',
    'سيرفر ويندوز',
    'خادم مخصص',
    'Root Access',
    'سيرفر NVMe',
    'VPS سريع',
    'خادم افتراضي',
    'استضافة سيرفر',
    'VPS عربي',
    'سيرفر للمتاجر',
    'VPS للمطورين',
    'خادم Ubuntu',
    'سيرفر CentOS',
    'استضافة موثوقة',
    'شراء VPS',
    'أفضل VPS'
  ];

  const keywordsEn = [
    'VPS server',
    'virtual private server',
    'cheap VPS',
    'VPS hosting',
    'Linux server',
    'Windows VPS',
    'dedicated server',
    'Root access VPS',
    'NVMe VPS',
    'fast VPS',
    'virtual server',
    'server hosting',
    'cloud VPS',
    'VPS for ecommerce',
    'developer VPS',
    'Ubuntu server',
    'CentOS VPS',
    'reliable VPS',
    'buy VPS',
    'best VPS hosting'
  ];

  return {
    title,
    description,
    keywords: isArabic ? keywordsAr : keywordsEn,
    openGraph: {
      type: 'website',
      locale: isArabic ? 'ar_SA' : 'en_US',
      url: isArabic ? 'https://progineous.com/ar/hosting/vps' : 'https://progineous.com/en/hosting/vps',
      title,
      description,
      siteName: 'Pro Gineous',
      images: [
        {
          url: `/api/og?title=${encodeURIComponent(title)}&description=${encodeURIComponent(description)}&locale=${locale}&page=hosting-vps`,
          width: 1200,
          height: 630,
          alt: isArabic ? 'سيرفرات VPS من برو جينيوس' : 'VPS Servers by Pro Gineous'
        }
      ]
    },
    twitter: {
      card: 'summary_large_image',
      title,
      description,
      images: [`/api/og?title=${encodeURIComponent(title)}&description=${encodeURIComponent(description)}&locale=${locale}&page=hosting-vps`],
    },
    alternates: {
      canonical: isArabic ? 'https://progineous.com/ar/hosting/vps' : 'https://progineous.com/en/hosting/vps',
      languages: {
        'ar-SA': 'https://progineous.com/ar/hosting/vps',
        'en-US': 'https://progineous.com/en/hosting/vps',
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
      'price-range': '$15-$100',
    },
  };
}

export default async function VPSHostingLayout({ children, params }: Props) {
  const { locale } = await params;
  const isArabic = locale === 'ar';

  // JSON-LD Product Schema for VPS
  const productSchema = {
    '@context': 'https://schema.org',
    '@type': 'Product',
    name: isArabic ? 'سيرفرات VPS' : 'VPS Servers',
    description: isArabic
      ? 'خوادم افتراضية خاصة بصلاحيات Root كاملة ومعالجات Intel وأقراص NVMe SSD'
      : 'Virtual Private Servers with full Root access, Intel processors, and NVMe SSD storage',
    brand: {
      '@type': 'Brand',
      name: 'Pro Gineous',
    },
    offers: {
      '@type': 'AggregateOffer',
      priceCurrency: 'USD',
      lowPrice: '15',
      highPrice: '100',
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
      reviewCount: '892',
      bestRating: '5',
      worstRating: '1',
    },
    category: 'VPS Hosting',
    url: `https://progineous.com/${locale}/hosting/vps`,
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
        name: isArabic ? 'سيرفرات VPS' : 'VPS Servers',
        item: `https://progineous.com/${locale}/hosting/vps`,
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
        name: isArabic ? 'ما الفرق بين VPS والاستضافة المشتركة؟' : 'What is the difference between VPS and shared hosting?',
        acceptedAnswer: {
          '@type': 'Answer',
          text: isArabic
            ? 'VPS يوفر موارد مخصصة (رام، معالج، تخزين) لموقعك فقط مع صلاحيات Root كاملة، بينما الاستضافة المشتركة تتشارك الموارد مع مواقع أخرى.'
            : 'VPS provides dedicated resources (RAM, CPU, storage) exclusively for your site with full Root access, while shared hosting shares resources with other websites.',
        },
      },
      {
        '@type': 'Question',
        name: isArabic ? 'هل يمكنني تثبيت أي برنامج على VPS؟' : 'Can I install any software on my VPS?',
        acceptedAnswer: {
          '@type': 'Answer',
          text: isArabic
            ? 'نعم، مع صلاحيات Root الكاملة يمكنك تثبيت أي برنامج أو نظام تشغيل تحتاجه بما في ذلك Docker، Node.js، Python، وغيرها.'
            : 'Yes, with full Root access you can install any software or operating system you need including Docker, Node.js, Python, and more.',
        },
      },
      {
        '@type': 'Question',
        name: isArabic ? 'هل تقدمون دعم مُدار للـ VPS؟' : 'Do you offer managed VPS support?',
        acceptedAnswer: {
          '@type': 'Answer',
          text: isArabic
            ? 'نعم، نقدم خطط VPS مُدارة بالكامل حيث نهتم بالتحديثات والأمان والنسخ الاحتياطي، بالإضافة إلى دعم فني 24/7.'
            : 'Yes, we offer fully managed VPS plans where we handle updates, security, and backups, plus 24/7 technical support.',
        },
      },
    ],
  };

  return (
    <>
      <Script
        id="vps-product-schema"
        type="application/ld+json"
        dangerouslySetInnerHTML={{ __html: JSON.stringify(productSchema) }}
      />
      <Script
        id="vps-breadcrumb-schema"
        type="application/ld+json"
        dangerouslySetInnerHTML={{ __html: JSON.stringify(breadcrumbSchema) }}
      />
      <Script
        id="vps-faq-schema"
        type="application/ld+json"
        dangerouslySetInnerHTML={{ __html: JSON.stringify(faqSchema) }}
      />
      {children}
    </>
  );
}
