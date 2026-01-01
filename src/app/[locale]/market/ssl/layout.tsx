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
    ? 'شهادات SSL | شهادات أمان للمواقع من DigiCert و GeoTrust - بروجينيوس'
    : 'SSL Certificates | Website Security from DigiCert & GeoTrust - Pro Gineous';
  
  const description = isArabic
    ? 'احصل على شهادة SSL لموقعك من أفضل العلامات التجارية: DigiCert، GeoTrust، RapidSSL. شهادات DV، OV، EV، و Wildcard. تشفير 256-bit وضمان يصل إلى $1.75 مليون. أسعار تبدأ من $17.95/سنة.'
    : 'Get SSL certificates from top brands: DigiCert, GeoTrust, RapidSSL. DV, OV, EV, and Wildcard certificates. 256-bit encryption and warranty up to $1.75M. Starting at $17.95/year.';

  const keywords = isArabic
    ? [
        'شهادة SSL',
        'شهادات أمان',
        'HTTPS',
        'تشفير الموقع',
        'DigiCert',
        'GeoTrust',
        'RapidSSL',
        'شهادة Wildcard',
        'شهادة EV SSL',
        'شهادة OV SSL',
        'شهادة DV SSL',
        'حماية الموقع',
        'قفل الأمان',
        'SSL رخيص',
        'شراء شهادة SSL',
        // Arab Markets
        'شهادة SSL مصر',
        'شهادة SSL السعودية',
        'شهادة SSL الامارات',
      ]
    : [
        'SSL certificate',
        'security certificates',
        'HTTPS',
        'website encryption',
        'DigiCert',
        'GeoTrust',
        'RapidSSL',
        'Wildcard certificate',
        'EV SSL certificate',
        'OV SSL certificate',
        'DV SSL certificate',
        'website protection',
        'padlock security',
        'cheap SSL',
        'buy SSL certificate',
        // Western Markets
        'SSL certificate USA',
        'SSL certificate UK',
        'SSL certificate Germany',
        'SSL certificate France',
        'SSL certificate Canada',
        'best SSL 2026',
        'GDPR SSL',
      ];

  const baseUrl = process.env.NEXT_PUBLIC_SITE_URL || 'https://progineous.com';
  const canonicalUrl = `${baseUrl}/${locale}/market/ssl`;
  
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
        'en': `${baseUrl}/en/market/ssl`,
        'ar': `${baseUrl}/ar/market/ssl`,
        'en-US': `${baseUrl}/en/market/ssl`,
        'en-GB': `${baseUrl}/en/market/ssl`,
        'de-DE': `${baseUrl}/en/market/ssl`,
        'fr-FR': `${baseUrl}/en/market/ssl`,
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
          url: `/api/og?title=${encodeURIComponent(title)}&description=${encodeURIComponent(description)}&locale=${locale}&page=ssl`,
          width: 1200,
          height: 630,
          alt: isArabic ? 'شهادات SSL - بروجينيوس' : 'SSL Certificates - Pro Gineous',
        },
      ],
    },
    twitter: {
      card: 'summary_large_image',
      title,
      description,
      images: [`/api/og?title=${encodeURIComponent(title)}&description=${encodeURIComponent(description)}&locale=${locale}&page=ssl`],
      creator: '@progineous',
      site: '@progineous',
    },
  };
}

export default async function SSLLayout({
  children,
  params,
}: Props) {
  const { locale } = await params;
  const isArabic = locale === 'ar';

  // Product Schema for SSL
  const productSchema = {
    '@context': 'https://schema.org',
    '@type': 'Product',
    name: isArabic ? 'شهادات SSL' : 'SSL Certificates',
    description: isArabic
      ? 'شهادات SSL من DigiCert و GeoTrust و RapidSSL'
      : 'SSL Certificates from DigiCert, GeoTrust, and RapidSSL',
    brand: {
      '@type': 'Brand',
      name: 'Pro Gineous',
    },
    offers: {
      '@type': 'AggregateOffer',
      priceCurrency: 'USD',
      lowPrice: '17.95',
      highPrice: '500',
      offerCount: '15+',
      availability: 'https://schema.org/InStock',
    },
    aggregateRating: {
      '@type': 'AggregateRating',
      ratingValue: '4.9',
      reviewCount: '1234',
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
        name: isArabic ? 'ما الفرق بين شهادات DV و OV و EV؟' : 'What\'s the difference between DV, OV, and EV certificates?',
        acceptedAnswer: {
          '@type': 'Answer',
          text: isArabic
            ? 'DV للتحقق من الدومين فقط، OV للتحقق من الشركة، وEV للتحقق الموسع مع شريط أخضر في المتصفح'
            : 'DV validates domain only, OV validates organization, and EV provides extended validation with green bar in browser'
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
        name: isArabic ? 'المتجر' : 'Market',
        item: `https://progineous.com/${locale}/market`,
      },
      {
        '@type': 'ListItem',
        position: 3,
        name: isArabic ? 'شهادات SSL' : 'SSL Certificates',
        item: `https://progineous.com/${locale}/market/ssl`,
      },
    ],
  };

  return (
    <>
      <Script
        id="ssl-product-schema"
        type="application/ld+json"
        dangerouslySetInnerHTML={{ __html: JSON.stringify(productSchema) }}
      />
      <Script
        id="ssl-faq-schema"
        type="application/ld+json"
        dangerouslySetInnerHTML={{ __html: JSON.stringify(faqSchema) }}
      />
      <Script
        id="ssl-breadcrumb-schema"
        type="application/ld+json"
        dangerouslySetInnerHTML={{ __html: JSON.stringify(breadcrumbSchema) }}
      />
      {children}
    </>
  );
}
