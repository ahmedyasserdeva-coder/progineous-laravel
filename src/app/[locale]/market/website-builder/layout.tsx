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
    ? 'منشئ المواقع | Weebly لإنشاء مواقع بدون برمجة - بروجينيوس'
    : 'Website Builder | Weebly Drag & Drop Site Creator - Pro Gineous';
  
  const description = isArabic
    ? 'أنشئ موقعك بسهولة مع Weebly. منشئ سحب وإفلات، قوالب احترافية، متجر إلكتروني، صفحات غير محدودة، وSEO مدمج. باقات مجانية ومدفوعة تبدأ من $8.99/شهر.'
    : 'Build your website easily with Weebly. Drag & drop builder, professional templates, eCommerce store, unlimited pages, and built-in SEO. Free and paid plans starting at $8.99/mo.';

  const keywords = isArabic
    ? [
        'منشئ المواقع',
        'Weebly',
        'إنشاء موقع',
        'موقع بدون برمجة',
        'سحب وإفلات',
        'قوالب مواقع',
        'متجر إلكتروني',
        'موقع مجاني',
        'تصميم موقع',
        'موقع للأعمال',
        'موقع شخصي',
        'بناء موقع سهل',
        'موقع احترافي',
        'استضافة مواقع',
        'موقع بدون خبرة',
        // Arab Markets
        'انشاء موقع مصر',
        'منشئ مواقع السعودية',
        'تصميم موقع الامارات',
      ]
    : [
        'website builder',
        'Weebly',
        'create website',
        'no-code website',
        'drag and drop',
        'website templates',
        'eCommerce store',
        'free website',
        'website design',
        'business website',
        'personal website',
        'easy website builder',
        'professional website',
        'web hosting',
        'beginner website',
        // Western Markets
        'website builder USA',
        'website builder UK',
        'best website builder 2026',
        'Weebly alternative',
        'small business website',
        'DIY website builder',
      ];

  const baseUrl = process.env.NEXT_PUBLIC_SITE_URL || 'https://progineous.com';
  const canonicalUrl = `${baseUrl}/${locale}/market/website-builder`;
  
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
        'en': `${baseUrl}/en/market/website-builder`,
        'ar': `${baseUrl}/ar/market/website-builder`,
        'en-US': `${baseUrl}/en/market/website-builder`,
        'en-GB': `${baseUrl}/en/market/website-builder`,
        'de-DE': `${baseUrl}/en/market/website-builder`,
        'fr-FR': `${baseUrl}/en/market/website-builder`,
      },
    },
    openGraph: {
      type: 'website',
      locale: isArabic ? 'ar_SA' : 'en_US',
      alternateLocale: isArabic ? 'en_US' : 'ar_SA',
      url: canonicalUrl,
      title,
      description,
      siteName: 'Pro Gineous',
      images: [
        {
          url: `/api/og?title=${encodeURIComponent(title)}&description=${encodeURIComponent(description)}&locale=${locale}&page=website-builder`,
          width: 1200,
          height: 630,
          alt: isArabic ? 'منشئ المواقع - بروجينيوس' : 'Website Builder - Pro Gineous',
        },
      ],
    },
    twitter: {
      card: 'summary_large_image',
      title,
      description,
      images: [`/api/og?title=${encodeURIComponent(title)}&description=${encodeURIComponent(description)}&locale=${locale}&page=website-builder`],
      creator: '@progineous',
      site: '@progineous',
    },
  };
}

export default async function WebsiteBuilderLayout({
  children,
  params,
}: Props) {
  const { locale } = await params;
  const isArabic = locale === 'ar';

  // Product Schema
  const productSchema = {
    '@context': 'https://schema.org',
    '@type': 'Product',
    name: isArabic ? 'منشئ المواقع Weebly' : 'Weebly Website Builder',
    description: isArabic
      ? 'أنشئ موقعك بسهولة مع سحب وإفلات وقوالب احترافية'
      : 'Build your website easily with drag & drop and professional templates',
    brand: {
      '@type': 'Brand',
      name: 'Weebly',
    },
    offers: {
      '@type': 'AggregateOffer',
      priceCurrency: 'USD',
      lowPrice: '0',
      highPrice: '29.99',
      offerCount: '4',
      availability: 'https://schema.org/InStock',
    },
    aggregateRating: {
      '@type': 'AggregateRating',
      ratingValue: '4.7',
      reviewCount: '1876',
      bestRating: '5',
      worstRating: '1',
    },
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
        name: isArabic ? 'المتجر' : 'Market',
        item: `https://progineous.com/${locale}/market`,
      },
      {
        '@type': 'ListItem',
        position: 3,
        name: isArabic ? 'منشئ المواقع' : 'Website Builder',
        item: `https://progineous.com/${locale}/market/website-builder`,
      },
    ],
  };

  return (
    <>
      <Script
        id="website-builder-product-schema"
        type="application/ld+json"
        dangerouslySetInnerHTML={{ __html: JSON.stringify(productSchema) }}
      />
      <Script
        id="website-builder-breadcrumb-schema"
        type="application/ld+json"
        dangerouslySetInnerHTML={{ __html: JSON.stringify(breadcrumbSchema) }}
      />
      {children}
    </>
  );
}
