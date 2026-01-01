import type { Metadata } from 'next';

type Props = {
  params: Promise<{ locale: string }>;
};

export async function generateMetadata({ params }: Props): Promise<Metadata> {
  const { locale } = await params;
  const isArabic = locale === 'ar';
  
  const title = isArabic 
    ? 'XOVI NOW | أدوات SEO احترافية 100+ مليون كلمة مفتاحية من $19/شهر - بروجينيوس'
    : 'XOVI NOW | Professional SEO Tools 100M+ Keywords from $19/mo - Pro Gineous';
  
  const description = isArabic
    ? 'حسّن موقعك مع XOVI NOW. قاعدة بيانات 100+ مليون كلمة مفتاحية، تتبع الترتيب في 200+ دولة، تدقيق الموقع، تحليل المنافسين، ومستشار SEO شخصي. أسعار تبدأ من $19/شهر. خدمة SEO احترافية في مصر والسعودية والإمارات وأمريكا وكندا وأوروبا.'
    : 'Optimize your website with XOVI NOW. 100M+ keyword database, rank tracking in 200+ countries, site audit, competitor analysis, and personal SEO advisor. Starting at $19/mo. Professional SEO service in USA, UK, Canada, Germany, France, Egypt, Saudi Arabia, UAE.';

  const keywords = isArabic
    ? [
        'XOVI NOW',
        'أدوات SEO احترافية',
        'تحليل الكلمات المفتاحية',
        'تتبع الترتيب',
        'تدقيق الموقع',
        'تحليل المنافسين',
        'مستشار SEO',
        'تحسين محركات البحث',
        'بحث الكلمات المفتاحية',
        'تحليل SEO',
        'أدوات الويب ماستر',
        'تقرير SEO',
        'تحسين الظهور',
        'أدوات تسويق',
        'SEO للمحترفين',
        'SEO enterprise مصر',
        'تحليل SEO السعودية',
        'أدوات SEO الإمارات',
        'backlink analysis عربي',
        'site audit احترافي',
      ]
    : [
        'XOVI NOW',
        'professional SEO tools',
        'keyword analysis',
        'rank tracking',
        'site audit',
        'competitor analysis',
        'SEO advisor',
        'search engine optimization',
        'keyword research',
        'SEO analysis',
        'webmaster tools',
        'SEO report',
        'visibility optimization',
        'marketing tools',
        'professional SEO',
        'enterprise SEO USA',
        'SEO suite UK',
        'professional SEO Canada',
        'SEO tools Germany',
        'SEO platform France',
        'backlink analysis',
        'technical SEO audit',
        'SERP tracking',
        'SEO intelligence',
        'competitive analysis',
        'keyword gap analysis',
        'SEO monitoring',
        'rank checker',
        'SEO dashboard',
        'multi-country SEO',
      ];

  const baseUrl = process.env.NEXT_PUBLIC_SITE_URL || 'https://progineous.com';
  const canonicalUrl = `${baseUrl}/${locale}/market/xovi-now`;
  
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
        'en': `${baseUrl}/en/market/xovi-now`,
        'ar': `${baseUrl}/ar/market/xovi-now`,
        'en-US': `${baseUrl}/en/market/xovi-now`,
        'en-GB': `${baseUrl}/en/market/xovi-now`,
        'en-CA': `${baseUrl}/en/market/xovi-now`,
        'en-AU': `${baseUrl}/en/market/xovi-now`,
        'de-DE': `${baseUrl}/en/market/xovi-now`,
        'fr-FR': `${baseUrl}/en/market/xovi-now`,
        'ar-EG': `${baseUrl}/ar/market/xovi-now`,
        'ar-SA': `${baseUrl}/ar/market/xovi-now`,
        'ar-AE': `${baseUrl}/ar/market/xovi-now`,
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
          alt: isArabic ? 'XOVI NOW أدوات SEO احترافية - بروجينيوس' : 'XOVI NOW Professional SEO Tools - Pro Gineous',
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

export default async function XOVINowLayout({
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
    name: 'XOVI NOW',
    description: isArabic
      ? 'أدوات SEO احترافية مع قاعدة بيانات 100+ مليون كلمة مفتاحية وتتبع ترتيب في 200+ دولة'
      : 'Professional SEO tools with 100M+ keyword database and rank tracking in 200+ countries',
    brand: {
      '@type': 'Brand',
      name: 'XOVI',
    },
    offers: {
      '@type': 'AggregateOffer',
      lowPrice: '19',
      highPrice: '99',
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
      reviewCount: '1650',
      bestRating: '5',
      worstRating: '1',
    },
    category: 'Professional SEO Software',
  };

  const faqSchema = {
    '@context': 'https://schema.org',
    '@type': 'FAQPage',
    mainEntity: [
      {
        '@type': 'Question',
        name: isArabic ? 'ما الفرق بين XOVI NOW و marketgoo؟' : 'What is the difference between XOVI NOW and marketgoo?',
        acceptedAnswer: {
          '@type': 'Answer',
          text: isArabic
            ? 'XOVI NOW للمحترفين والوكالات مع قاعدة بيانات 100+ مليون كلمة وتتبع في 200+ دولة، بينما marketgoo للمبتدئين وأصحاب المواقع الصغيرة.'
            : 'XOVI NOW is for professionals and agencies with 100M+ keyword database and tracking in 200+ countries, while marketgoo is for beginners and small website owners.',
        },
      },
      {
        '@type': 'Question',
        name: isArabic ? 'كم دولة يمكنني تتبع الترتيب فيها؟' : 'How many countries can I track rankings in?',
        acceptedAnswer: {
          '@type': 'Answer',
          text: isArabic
            ? 'يمكنك تتبع ترتيب موقعك في أكثر من 200 دولة وبمستوى المدن في بعض الدول.'
            : 'You can track your website ranking in over 200 countries and at city level in some countries.',
        },
      },
      {
        '@type': 'Question',
        name: isArabic ? 'هل يتضمن تحليل الباكلينكات؟' : 'Does it include backlink analysis?',
        acceptedAnswer: {
          '@type': 'Answer',
          text: isArabic
            ? 'نعم، يتضمن تحليل شامل للباكلينكات مع اكتشاف الروابط السامة وتتبع الروابط الجديدة والمفقودة.'
            : 'Yes, it includes comprehensive backlink analysis with toxic link detection and new/lost link tracking.',
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
        name: 'XOVI NOW',
        item: `${baseUrl}/${locale}/market/xovi-now`,
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
