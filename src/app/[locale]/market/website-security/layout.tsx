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
    ? 'أمان الموقع | SiteLock لحماية المواقع من البرامج الضارة - بروجينيوس'
    : 'Website Security | SiteLock Malware Protection - Pro Gineous';
  
  const description = isArabic
    ? 'احمِ موقعك مع SiteLock. فحص يومي للبرامج الضارة، إزالة تلقائية، جدار حماية WAF، شبكة CDN، وختم ثقة. باقات Find، Fix، و Defend. أسعار تبدأ من $24.99/سنة.'
    : 'Protect your website with SiteLock. Daily malware scanning, automatic removal, WAF firewall, CDN network, and trust seal. Find, Fix, and Defend plans. Starting at $24.99/year.';

  const keywords = isArabic
    ? [
        'أمان الموقع',
        'SiteLock',
        'حماية من البرامج الضارة',
        'فحص الموقع',
        'إزالة الفيروسات',
        'جدار حماية الموقع',
        'WAF',
        'حماية WordPress',
        'فحص SQL Injection',
        'فحص XSS',
        'ختم الثقة',
        'CDN',
        'تسريع الموقع',
        'حماية من الهجمات',
        'أمان الويب',
        // Arab Markets
        'حماية موقع مصر',
        'امان مواقع السعودية',
        'حماية مواقع الخليج',
      ]
    : [
        'website security',
        'SiteLock',
        'malware protection',
        'website scanning',
        'virus removal',
        'website firewall',
        'WAF',
        'WordPress protection',
        'SQL injection scan',
        'XSS scan',
        'trust seal',
        'CDN',
        'website acceleration',
        'attack protection',
        'web security',
        // Western Markets
        'website security USA',
        'website security UK',
        'SiteLock Germany',
        'malware removal service',
        'website protection 2026',
        'DDoS protection',
      ];

  const baseUrl = process.env.NEXT_PUBLIC_SITE_URL || 'https://progineous.com';
  const canonicalUrl = `${baseUrl}/${locale}/market/website-security`;
  
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
        'en': `${baseUrl}/en/market/website-security`,
        'ar': `${baseUrl}/ar/market/website-security`,
        'en-US': `${baseUrl}/en/market/website-security`,
        'en-GB': `${baseUrl}/en/market/website-security`,
        'de-DE': `${baseUrl}/en/market/website-security`,
        'fr-FR': `${baseUrl}/en/market/website-security`,
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
          url: `/api/og?title=${encodeURIComponent(title)}&description=${encodeURIComponent(description)}&locale=${locale}&page=website-security`,
          width: 1200,
          height: 630,
          alt: isArabic ? 'أمان الموقع - بروجينيوس' : 'Website Security - Pro Gineous',
        },
      ],
    },
    twitter: {
      card: 'summary_large_image',
      title,
      description,
      images: [`/api/og?title=${encodeURIComponent(title)}&description=${encodeURIComponent(description)}&locale=${locale}&page=website-security`],
      creator: '@progineous',
      site: '@progineous',
    },
  };
}

export default async function WebsiteSecurityLayout({
  children,
  params,
}: Props) {
  const { locale } = await params;
  const isArabic = locale === 'ar';

  // Product Schema
  const productSchema = {
    '@context': 'https://schema.org',
    '@type': 'Product',
    name: 'SiteLock',
    description: isArabic
      ? 'حماية موقعك من البرامج الضارة والهجمات الإلكترونية'
      : 'Protect your website from malware and cyber attacks',
    brand: {
      '@type': 'Brand',
      name: 'SiteLock',
    },
    offers: {
      '@type': 'AggregateOffer',
      priceCurrency: 'USD',
      lowPrice: '24.99',
      highPrice: '499.99',
      offerCount: '3',
      availability: 'https://schema.org/InStock',
    },
    aggregateRating: {
      '@type': 'AggregateRating',
      ratingValue: '4.8',
      reviewCount: '1543',
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
        name: isArabic ? 'أمان الموقع' : 'Website Security',
        item: `https://progineous.com/${locale}/market/website-security`,
      },
    ],
  };

  return (
    <>
      <Script
        id="website-security-product-schema"
        type="application/ld+json"
        dangerouslySetInnerHTML={{ __html: JSON.stringify(productSchema) }}
      />
      <Script
        id="website-security-breadcrumb-schema"
        type="application/ld+json"
        dangerouslySetInnerHTML={{ __html: JSON.stringify(breadcrumbSchema) }}
      />
      {children}
    </>
  );
}
