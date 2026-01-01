import type { Metadata } from 'next';

type Props = {
  params: Promise<{ locale: string }>;
};

export async function generateMetadata({ params }: Props): Promise<Metadata> {
  const { locale } = await params;
  const isArabic = locale === 'ar';
  
  const title = isArabic 
    ? 'SocialBee | إدارة وجدولة السوشيال ميديا من $29/شهر - بروجينيوس'
    : 'SocialBee | Social Media Management & Scheduling from $29/mo - Pro Gineous';
  
  const description = isArabic
    ? 'أدر حساباتك على السوشيال ميديا بسهولة مع SocialBee. جدولة المنشورات، إنشاء محتوى بالذكاء الاصطناعي، تحليلات متقدمة، ودعم لجميع المنصات (تويتر، انستغرام، فيسبوك، لينكد إن، تيك توك). أسعار تبدأ من $29/شهر. خدمة في مصر والسعودية والإمارات وأمريكا وكندا وأوروبا.'
    : 'Manage your social media easily with SocialBee. Schedule posts, AI content creation, advanced analytics, support for all platforms (Twitter, Instagram, Facebook, LinkedIn, TikTok). Starting at $29/mo. Service in USA, UK, Canada, Germany, France, Egypt, Saudi Arabia, UAE.';

  const keywords = isArabic
    ? [
        'إدارة السوشيال ميديا',
        'جدولة المنشورات',
        'SocialBee',
        'أتمتة السوشيال ميديا',
        'إدارة حسابات التواصل',
        'جدولة تويتر',
        'جدولة انستغرام',
        'جدولة فيسبوك',
        'جدولة لينكد إن',
        'أدوات السوشيال ميديا',
        'تحليلات السوشيال ميديا',
        'محتوى الذكاء الاصطناعي',
        'تسويق السوشيال ميديا',
        'إدارة المحتوى',
        'أدوات التسويق الرقمي',
        'social media مصر',
        'إدارة حسابات السعودية',
        'تسويق الإمارات',
        'جدولة تيك توك',
        'AI content عربي',
      ]
    : [
        'social media management',
        'post scheduling',
        'SocialBee',
        'social media automation',
        'social accounts management',
        'Twitter scheduling',
        'Instagram scheduling',
        'Facebook scheduling',
        'LinkedIn scheduling',
        'social media tools',
        'social media analytics',
        'AI content creation',
        'social media marketing',
        'content management',
        'digital marketing tools',
        'social media management USA',
        'post scheduling UK',
        'social automation Canada',
        'social media tools Germany',
        'content scheduling France',
        'TikTok scheduling',
        'social media scheduler',
        'bulk social posting',
        'content calendar',
        'social media planner',
        'engagement tools',
        'social media dashboard',
        'multi-platform posting',
        'social media workflow',
        'team collaboration social',
      ];

  const baseUrl = process.env.NEXT_PUBLIC_SITE_URL || 'https://progineous.com';
  const canonicalUrl = `${baseUrl}/${locale}/market/socialbee`;
  
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
        'en': `${baseUrl}/en/market/socialbee`,
        'ar': `${baseUrl}/ar/market/socialbee`,
        'en-US': `${baseUrl}/en/market/socialbee`,
        'en-GB': `${baseUrl}/en/market/socialbee`,
        'en-CA': `${baseUrl}/en/market/socialbee`,
        'en-AU': `${baseUrl}/en/market/socialbee`,
        'de-DE': `${baseUrl}/en/market/socialbee`,
        'fr-FR': `${baseUrl}/en/market/socialbee`,
        'ar-EG': `${baseUrl}/ar/market/socialbee`,
        'ar-SA': `${baseUrl}/ar/market/socialbee`,
        'ar-AE': `${baseUrl}/ar/market/socialbee`,
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
          alt: isArabic ? 'SocialBee إدارة السوشيال ميديا - بروجينيوس' : 'SocialBee Social Media Management - Pro Gineous',
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

export default async function SocialBeeLayout({
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
    name: 'SocialBee',
    description: isArabic
      ? 'منصة إدارة وجدولة السوشيال ميديا مع إنشاء محتوى بالذكاء الاصطناعي'
      : 'Social media management and scheduling platform with AI content creation',
    brand: {
      '@type': 'Brand',
      name: 'SocialBee',
    },
    offers: {
      '@type': 'AggregateOffer',
      lowPrice: '29',
      highPrice: '179',
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
      ratingValue: '4.8',
      reviewCount: '3250',
      bestRating: '5',
      worstRating: '1',
    },
    category: 'Social Media Software',
  };

  const faqSchema = {
    '@context': 'https://schema.org',
    '@type': 'FAQPage',
    mainEntity: [
      {
        '@type': 'Question',
        name: isArabic ? 'ما المنصات المدعومة؟' : 'What platforms are supported?',
        acceptedAnswer: {
          '@type': 'Answer',
          text: isArabic
            ? 'يدعم SocialBee تويتر، انستغرام، فيسبوك، لينكد إن، بنترست، تيك توك، ويوتيوب.'
            : 'SocialBee supports Twitter, Instagram, Facebook, LinkedIn, Pinterest, TikTok, and YouTube.',
        },
      },
      {
        '@type': 'Question',
        name: isArabic ? 'هل يمكنني إنشاء محتوى بالذكاء الاصطناعي؟' : 'Can I create AI content?',
        acceptedAnswer: {
          '@type': 'Answer',
          text: isArabic
            ? 'نعم، SocialBee يتضمن AI Copilot لإنشاء منشورات وأفكار محتوى بالذكاء الاصطناعي.'
            : 'Yes, SocialBee includes AI Copilot for creating posts and content ideas using AI.',
        },
      },
      {
        '@type': 'Question',
        name: isArabic ? 'هل يمكنني إدارة حسابات متعددة؟' : 'Can I manage multiple accounts?',
        acceptedAnswer: {
          '@type': 'Answer',
          text: isArabic
            ? 'نعم، يمكنك إدارة حسابات متعددة من لوحة تحكم واحدة وجدولة منشورات لكل منها.'
            : 'Yes, you can manage multiple accounts from a single dashboard and schedule posts for each.',
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
        name: 'SocialBee',
        item: `${baseUrl}/${locale}/market/socialbee`,
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
