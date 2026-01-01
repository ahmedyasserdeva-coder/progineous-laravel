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
    ? 'سيرفرات مخصصة - خوادم Dedicated قوية Intel و AMD | Pro Gineous'
    : 'Dedicated Servers - Powerful Intel & AMD Servers | Pro Gineous';

  const description = isArabic
    ? 'احصل على سيرفر مخصص بالكامل بأسعار تبدأ من $140 شهرياً. خوادم Intel و AMD بأداء لا مثيل له، 99.99% SLA، شبكة 100Gbps، حماية DDoS، ودعم 24/7. مثالية للمشاريع الكبيرة والمؤسسات.'
    : 'Get a fully dedicated server starting from $140/month. Intel & AMD servers with unmatched performance, 99.99% SLA, 100Gbps network, DDoS protection, and 24/7 support. Perfect for large projects and enterprises.';

  const keywordsAr = [
    'سيرفر مخصص',
    'خادم مخصص',
    'dedicated server',
    'استضافة مخصصة',
    'سيرفر Intel',
    'سيرفر AMD',
    'سيرفر EPYC',
    'خادم فعلي',
    'سيرفر للشركات',
    'استضافة مؤسسات',
    'سيرفر GPU',
    'NVIDIA H100',
    'سيرفر AI',
    'استضافة ألعاب',
    'سيرفر قوي',
    'bare metal server',
    'سيرفر NVMe',
    'خادم بدون مشاركة',
    'استضافة أداء عالي',
    'أفضل سيرفر مخصص',
    // Arab Markets
    'سيرفر مخصص مصر',
    'سيرفر مخصص السعودية',
    'سيرفر مخصص الامارات',
    'سيرفر مخصص الخليج',
  ];

  const keywordsEn = [
    'dedicated server',
    'dedicated hosting',
    'Intel dedicated server',
    'AMD dedicated server',
    'AMD EPYC server',
    'bare metal server',
    'enterprise server',
    'GPU server',
    'NVIDIA H100 server',
    'AI server hosting',
    'game server hosting',
    'high performance server',
    'NVMe dedicated server',
    'unmanaged dedicated server',
    'managed dedicated server',
    'colocation alternative',
    'dedicated server hosting',
    'powerful server',
    'best dedicated server',
    'dedicated server provider',
    // Western Markets
    'dedicated server USA',
    'dedicated server UK',
    'dedicated server Germany',
    'dedicated server France',
    'dedicated server Canada',
    'Frankfurt dedicated server',
    'London dedicated server',
    'New York dedicated server',
    'GDPR compliant server',
    'European dedicated server',
  ];

  return {
    title,
    description,
    keywords: isArabic ? keywordsAr : keywordsEn,
    openGraph: {
      type: 'website',
      locale: isArabic ? 'ar_SA' : 'en_US',
      url: isArabic ? 'https://progineous.com/ar/hosting/dedicated' : 'https://progineous.com/en/hosting/dedicated',
      title,
      description,
      siteName: 'Pro Gineous',
      images: [
        {
          url: `/api/og?title=${encodeURIComponent(title)}&description=${encodeURIComponent(description)}&locale=${locale}&page=hosting-dedicated`,
          width: 1200,
          height: 630,
          alt: isArabic ? 'سيرفرات مخصصة من برو جينيوس' : 'Dedicated Servers by Pro Gineous'
        }
      ]
    },
    twitter: {
      card: 'summary_large_image',
      title,
      description,
      images: [`/api/og?title=${encodeURIComponent(title)}&description=${encodeURIComponent(description)}&locale=${locale}&page=hosting-dedicated`],
    },
    alternates: {
      canonical: isArabic ? 'https://progineous.com/ar/hosting/dedicated' : 'https://progineous.com/en/hosting/dedicated',
      languages: {
        'ar-SA': 'https://progineous.com/ar/hosting/dedicated',
        'ar-EG': 'https://progineous.com/ar/hosting/dedicated',
        'ar-AE': 'https://progineous.com/ar/hosting/dedicated',
        'en-US': 'https://progineous.com/en/hosting/dedicated',
        'en-GB': 'https://progineous.com/en/hosting/dedicated',
        'de-DE': 'https://progineous.com/en/hosting/dedicated',
        'fr-FR': 'https://progineous.com/en/hosting/dedicated',
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

export default async function DedicatedHostingLayout({
  children,
  params,
}: Props) {
  const { locale } = await params;
  const isArabic = locale === 'ar';

  // Product Schema for Dedicated Server
  const productSchema = {
    '@context': 'https://schema.org',
    '@type': 'Product',
    name: isArabic ? 'سيرفرات مخصصة' : 'Dedicated Servers',
    description: isArabic
      ? 'خوادم مخصصة بالكامل مع معالجات Intel و AMD، حماية DDoS، وشبكة 100Gbps'
      : 'Fully dedicated servers with Intel & AMD processors, DDoS protection, and 100Gbps network',
    brand: {
      '@type': 'Brand',
      name: 'Pro Gineous',
    },
    offers: {
      '@type': 'AggregateOffer',
      priceCurrency: 'USD',
      lowPrice: '140',
      highPrice: '2000',
      offerCount: '10+',
      availability: 'https://schema.org/InStock',
    },
    aggregateRating: {
      '@type': 'AggregateRating',
      ratingValue: '4.9',
      reviewCount: '456',
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
        name: isArabic ? 'ما هي مواصفات السيرفرات المخصصة المتاحة؟' : 'What are the dedicated server specifications available?',
        acceptedAnswer: {
          '@type': 'Answer',
          text: isArabic
            ? 'نوفر سيرفرات بمعالجات Intel Xeon و AMD EPYC، من 32GB حتى 512GB RAM، أقراص NVMe SSD، وشبكة حتى 100Gbps'
            : 'We offer servers with Intel Xeon and AMD EPYC processors, from 32GB to 512GB RAM, NVMe SSD storage, and up to 100Gbps network'
        }
      },
      {
        '@type': 'Question',
        name: isArabic ? 'هل تقدمون سيرفرات GPU للذكاء الاصطناعي؟' : 'Do you offer GPU servers for AI?',
        acceptedAnswer: {
          '@type': 'Answer',
          text: isArabic
            ? 'نعم، نوفر سيرفرات GPU مع NVIDIA H100 و A100 للتعلم الآلي والذكاء الاصطناعي'
            : 'Yes, we offer GPU servers with NVIDIA H100 and A100 for machine learning and AI workloads'
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
        name: isArabic ? 'سيرفرات مخصصة' : 'Dedicated Servers',
        item: `https://progineous.com/${locale}/hosting/dedicated`,
      },
    ],
  };

  return (
    <>
      <Script
        id="dedicated-product-schema"
        type="application/ld+json"
        dangerouslySetInnerHTML={{ __html: JSON.stringify(productSchema) }}
      />
      <Script
        id="dedicated-faq-schema"
        type="application/ld+json"
        dangerouslySetInnerHTML={{ __html: JSON.stringify(faqSchema) }}
      />
      <Script
        id="dedicated-breadcrumb-schema"
        type="application/ld+json"
        dangerouslySetInnerHTML={{ __html: JSON.stringify(breadcrumbSchema) }}
      />
      {children}
    </>
  );
}
