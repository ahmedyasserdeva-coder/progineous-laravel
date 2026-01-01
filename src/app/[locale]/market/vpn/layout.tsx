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
    ? 'NordVPN | خدمة VPN آمنة وسريعة لحماية خصوصيتك - بروجينيوس'
    : 'NordVPN | Secure & Fast VPN Service for Privacy Protection - Pro Gineous';
  
  const description = isArabic
    ? 'احمِ خصوصيتك على الإنترنت مع NordVPN. أكثر من 5500 خادم، سرعة 6730+ Mbps، حماية من التهديدات، إخفاء IP، وتصفح آمن على Wi-Fi العام. أسعار تبدأ من $4.99/شهر.'
    : 'Protect your online privacy with NordVPN. 5500+ servers, 6730+ Mbps speed, threat protection, IP hiding, and secure browsing on public Wi-Fi. Starting at $4.99/mo.';

  const keywords = isArabic
    ? [
        'VPN',
        'NordVPN',
        'خدمة VPN',
        'حماية الخصوصية',
        'إخفاء IP',
        'تصفح آمن',
        'VPN سريع',
        'فتح المواقع المحجوبة',
        'حماية Wi-Fi',
        'تشفير الاتصال',
        'VPN للسعودية',
        'VPN للإمارات',
        'حماية من الهاكرز',
        'تصفح مجهول',
        'VPN رخيص',
        // Arab Markets
        'VPN مصر',
        'VPN الخليج',
        'افضل VPN عربي',
      ]
    : [
        'VPN',
        'NordVPN',
        'VPN service',
        'privacy protection',
        'hide IP',
        'secure browsing',
        'fast VPN',
        'unblock websites',
        'Wi-Fi protection',
        'encrypted connection',
        'best VPN',
        'online security',
        'hacker protection',
        'anonymous browsing',
        'cheap VPN',
        // Western Markets
        'VPN USA',
        'VPN UK',
        'VPN Germany',
        'VPN France',
        'VPN Canada',
        'best VPN 2026',
        'NordVPN deal',
        'private internet access',
      ];

  const baseUrl = process.env.NEXT_PUBLIC_SITE_URL || 'https://progineous.com';
  const canonicalUrl = `${baseUrl}/${locale}/market/vpn`;
  
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
        'en': `${baseUrl}/en/market/vpn`,
        'ar': `${baseUrl}/ar/market/vpn`,
        'en-US': `${baseUrl}/en/market/vpn`,
        'en-GB': `${baseUrl}/en/market/vpn`,
        'de-DE': `${baseUrl}/en/market/vpn`,
        'fr-FR': `${baseUrl}/en/market/vpn`,
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
          url: `/api/og?title=${encodeURIComponent(title)}&description=${encodeURIComponent(description)}&locale=${locale}&page=vpn`,
          width: 1200,
          height: 630,
          alt: isArabic ? 'NordVPN - بروجينيوس' : 'NordVPN - Pro Gineous',
        },
      ],
    },
    twitter: {
      card: 'summary_large_image',
      title,
      description,
      images: [`/api/og?title=${encodeURIComponent(title)}&description=${encodeURIComponent(description)}&locale=${locale}&page=vpn`],
      creator: '@progineous',
      site: '@progineous',
    },
  };
}

export default async function VPNLayout({
  children,
  params,
}: Props) {
  const { locale } = await params;
  const isArabic = locale === 'ar';

  // Product Schema
  const productSchema = {
    '@context': 'https://schema.org',
    '@type': 'Product',
    name: 'NordVPN',
    description: isArabic
      ? 'خدمة VPN آمنة وسريعة مع أكثر من 5500 خادم'
      : 'Secure and fast VPN service with 5500+ servers',
    brand: {
      '@type': 'Brand',
      name: 'NordVPN',
    },
    offers: {
      '@type': 'AggregateOffer',
      priceCurrency: 'USD',
      lowPrice: '4.99',
      highPrice: '14.99',
      offerCount: '3',
      availability: 'https://schema.org/InStock',
    },
    aggregateRating: {
      '@type': 'AggregateRating',
      ratingValue: '4.8',
      reviewCount: '2345',
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
        name: 'VPN',
        item: `https://progineous.com/${locale}/market/vpn`,
      },
    ],
  };

  return (
    <>
      <Script
        id="vpn-product-schema"
        type="application/ld+json"
        dangerouslySetInnerHTML={{ __html: JSON.stringify(productSchema) }}
      />
      <Script
        id="vpn-breadcrumb-schema"
        type="application/ld+json"
        dangerouslySetInnerHTML={{ __html: JSON.stringify(breadcrumbSchema) }}
      />
      {children}
    </>
  );
}
