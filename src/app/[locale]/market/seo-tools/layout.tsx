import type { Metadata } from 'next';

type Props = {
  params: Promise<{ locale: string }>;
};

export async function generateMetadata({ params }: Props): Promise<Metadata> {
  const { locale } = await params;
  const isArabic = locale === 'ar';
  
  const title = isArabic 
    ? 'أدوات SEO | marketgoo تحسين محركات البحث من $4.99/شهر - بروجينيوس'
    : 'SEO Tools | marketgoo Search Engine Optimization from $4.99/mo - Pro Gineous';
  
  const description = isArabic
    ? 'حسّن ترتيب موقعك في محركات البحث مع marketgoo. تقارير SEO فورية، تتبع الكلمات المفتاحية، تحليل المنافسين، وخطة SEO مخصصة. أسعار تبدأ من $4.99/شهر. خدمة SEO في مصر والسعودية والإمارات وأمريكا وكندا وأوروبا.'
    : 'Improve your website ranking with marketgoo SEO tools. Instant SEO reports, keyword tracking, competitor analysis, and custom SEO plans. Starting at $4.99/mo. SEO service in USA, UK, Canada, Germany, France, Egypt, Saudi Arabia, UAE.';

  const keywords = isArabic
    ? [
        'أدوات SEO',
        'تحسين محركات البحث',
        'marketgoo',
        'تقرير SEO',
        'تتبع الكلمات المفتاحية',
        'تحليل المنافسين',
        'تحسين الموقع',
        'ترتيب جوجل',
        'أدوات تحسين المواقع',
        'خطة SEO',
        'تحليل SEO',
        'أدوات تسويق رقمي',
        'تحسين الظهور في البحث',
        'أدوات الويب ماستر',
        'تحسين المحتوى',
        'SEO مصر',
        'تحسين محركات البحث السعودية',
        'SEO الإمارات',
        'keyword research عربي',
        'تحليل موقع',
      ]
    : [
        'SEO tools',
        'search engine optimization',
        'marketgoo',
        'SEO report',
        'keyword tracking',
        'competitor analysis',
        'website optimization',
        'Google ranking',
        'website optimization tools',
        'SEO plan',
        'SEO analysis',
        'digital marketing tools',
        'search visibility',
        'webmaster tools',
        'content optimization',
        'SEO tools USA',
        'SEO software UK',
        'SEO platform Canada',
        'SEO tools Germany',
        'SEO service France',
        'keyword research tools',
        'SEO audit tool',
        'rank tracking software',
        'SEO checker',
        'website SEO analysis',
        'on-page SEO tools',
        'SEO optimization platform',
        'small business SEO',
        'DIY SEO tools',
        'affordable SEO software',
      ];

  const baseUrl = process.env.NEXT_PUBLIC_SITE_URL || 'https://progineous.com';
  const canonicalUrl = `${baseUrl}/${locale}/market/seo-tools`;
  
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
        'en': `${baseUrl}/en/market/seo-tools`,
        'ar': `${baseUrl}/ar/market/seo-tools`,
        'en-US': `${baseUrl}/en/market/seo-tools`,
        'en-GB': `${baseUrl}/en/market/seo-tools`,
        'en-CA': `${baseUrl}/en/market/seo-tools`,
        'en-AU': `${baseUrl}/en/market/seo-tools`,
        'de-DE': `${baseUrl}/en/market/seo-tools`,
        'fr-FR': `${baseUrl}/en/market/seo-tools`,
        'ar-EG': `${baseUrl}/ar/market/seo-tools`,
        'ar-SA': `${baseUrl}/ar/market/seo-tools`,
        'ar-AE': `${baseUrl}/ar/market/seo-tools`,
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
          alt: isArabic ? 'أدوات SEO marketgoo - بروجينيوس' : 'marketgoo SEO Tools - Pro Gineous',
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

export default async function SEOToolsLayout({
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
    name: 'marketgoo SEO Tools',
    description: isArabic
      ? 'أدوات SEO لتحسين ترتيب موقعك في محركات البحث مع تقارير وتحليلات متقدمة'
      : 'SEO tools to improve your website ranking with advanced reports and analytics',
    brand: {
      '@type': 'Brand',
      name: 'marketgoo',
    },
    offers: {
      '@type': 'AggregateOffer',
      lowPrice: '4.99',
      highPrice: '24.99',
      priceCurrency: 'USD',
      availability: 'https://schema.org/InStock',
      offerCount: 3,
      seller: {
        '@type': 'Organization',
        name: 'Pro Gineous',
      },
    },
    aggregateRating: {
      '@type': 'AggregateRating',
      ratingValue: '4.7',
      reviewCount: '1890',
      bestRating: '5',
      worstRating: '1',
    },
    category: 'SEO Software',
  };

  const faqSchema = {
    '@context': 'https://schema.org',
    '@type': 'FAQPage',
    mainEntity: [
      {
        '@type': 'Question',
        name: isArabic ? 'هل أحتاج خبرة في SEO لاستخدام الأداة؟' : 'Do I need SEO experience to use the tool?',
        acceptedAnswer: {
          '@type': 'Answer',
          text: isArabic
            ? 'لا، marketgoo مصمم للمبتدئين. يوفر خطة خطوة بخطوة سهلة الاتباع لتحسين موقعك.'
            : 'No, marketgoo is designed for beginners. It provides an easy-to-follow step-by-step plan to optimize your site.',
        },
      },
      {
        '@type': 'Question',
        name: isArabic ? 'ما الذي يتضمنه تقرير SEO؟' : 'What does the SEO report include?',
        acceptedAnswer: {
          '@type': 'Answer',
          text: isArabic
            ? 'التقرير يتضمن تحليل الكلمات المفتاحية، تحليل المنافسين، مشاكل التقنية، وتوصيات مخصصة.'
            : 'The report includes keyword analysis, competitor analysis, technical issues, and custom recommendations.',
        },
      },
      {
        '@type': 'Question',
        name: isArabic ? 'هل يمكنني تتبع ترتيب موقعي؟' : 'Can I track my website ranking?',
        acceptedAnswer: {
          '@type': 'Answer',
          text: isArabic
            ? 'نعم، يمكنك تتبع ترتيب موقعك لكلمات مفتاحية متعددة في محركات البحث المختلفة.'
            : 'Yes, you can track your website ranking for multiple keywords across different search engines.',
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
        name: isArabic ? 'أدوات SEO' : 'SEO Tools',
        item: `${baseUrl}/${locale}/market/seo-tools`,
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
