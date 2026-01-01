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
    ? 'استضافة Windows موزعين - Plesk و .NET Core | Pro Gineous'
    : 'Windows Reseller Hosting - Plesk & .NET Core | Pro Gineous';

  const description = isArabic
    ? 'ابدأ عملك في استضافة Windows بأسعار تبدأ من $34 شهرياً. Plesk، MS SQL 2019، .NET Core 8.x، ASP.NET، Windows Server 2022. مثالية لتطبيقات Microsoft.'
    : 'Start your Windows hosting business from $34/month. Plesk, MS SQL 2019, .NET Core 8.x, ASP.NET, Windows Server 2022. Perfect for Microsoft applications.';

  const keywordsAr = [
    'استضافة Windows موزعين',
    'Windows reseller hosting',
    'استضافة Plesk',
    'MS SQL hosting',
    '.NET Core استضافة',
    'ASP.NET hosting',
    'Windows Server 2022',
    'استضافة تطبيقات Microsoft',
    'بيع استضافة Windows',
    'ريسيلر Windows',
    'استضافة .NET',
    'قواعد بيانات SQL Server',
    'استضافة IIS',
    'Windows hosting عربي',
    'أفضل استضافة Windows',
    'استضافة موزعين Windows رخيصة',
    'Plesk reseller',
    'استضافة تطبيقات ويب',
    'MariaDB hosting',
    'PHP Windows hosting',
    // Arab Markets
    'استضافة Windows مصر',
    'استضافة Windows السعودية',
    'استضافة .NET الخليج',
  ];

  const keywordsEn = [
    'Windows reseller hosting',
    'Plesk reseller hosting',
    'MS SQL hosting',
    '.NET Core hosting',
    'ASP.NET hosting',
    'Windows Server 2022 hosting',
    'Microsoft hosting',
    'Windows hosting business',
    '.NET reseller hosting',
    'SQL Server hosting',
    'IIS hosting',
    'best Windows hosting',
    'cheap Windows reseller',
    'Plesk control panel',
    'Windows web hosting',
    'enterprise Windows hosting',
    'MariaDB Windows hosting',
    'PHP Windows hosting',
    'Windows VPS reseller',
    '.NET 8 hosting',
    // Western Markets
    'Windows hosting USA',
    'Windows hosting UK',
    'Windows hosting Germany',
    '.NET hosting USA',
    'ASP.NET hosting UK',
    'Windows Server hosting Europe',
  ];

  return {
    title,
    description,
    keywords: isArabic ? keywordsAr : keywordsEn,
    openGraph: {
      type: 'website',
      locale: isArabic ? 'ar_SA' : 'en_US',
      url: isArabic ? 'https://progineous.com/ar/hosting/windows-reseller' : 'https://progineous.com/en/hosting/windows-reseller',
      title,
      description,
      siteName: 'Pro Gineous',
      images: [
        {
          url: `/api/og?title=${encodeURIComponent(title)}&description=${encodeURIComponent(description)}&locale=${locale}&page=windows-reseller`,
          width: 1200,
          height: 630,
          alt: isArabic ? 'استضافة Windows موزعين من برو جينيوس' : 'Windows Reseller Hosting by Pro Gineous'
        }
      ]
    },
    twitter: {
      card: 'summary_large_image',
      title,
      description,
      images: [`/api/og?title=${encodeURIComponent(title)}&description=${encodeURIComponent(description)}&locale=${locale}&page=windows-reseller`],
    },
    alternates: {
      canonical: isArabic ? 'https://progineous.com/ar/hosting/windows-reseller' : 'https://progineous.com/en/hosting/windows-reseller',
      languages: {
        'ar-SA': 'https://progineous.com/ar/hosting/windows-reseller',
        'ar-EG': 'https://progineous.com/ar/hosting/windows-reseller',
        'en-US': 'https://progineous.com/en/hosting/windows-reseller',
        'en-GB': 'https://progineous.com/en/hosting/windows-reseller',
        'de-DE': 'https://progineous.com/en/hosting/windows-reseller',
        'fr-FR': 'https://progineous.com/en/hosting/windows-reseller',
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

export default async function WindowsResellerHostingLayout({
  children,
  params,
}: Props) {
  const { locale } = await params;
  const isArabic = locale === 'ar';

  // Product Schema
  const productSchema = {
    '@context': 'https://schema.org',
    '@type': 'Product',
    name: isArabic ? 'استضافة Windows موزعين' : 'Windows Reseller Hosting',
    description: isArabic
      ? 'استضافة Windows مع Plesk و .NET Core و MS SQL'
      : 'Windows hosting with Plesk, .NET Core, and MS SQL',
    brand: {
      '@type': 'Brand',
      name: 'Pro Gineous',
    },
    offers: {
      '@type': 'AggregateOffer',
      priceCurrency: 'USD',
      lowPrice: '34',
      highPrice: '120',
      offerCount: '4',
      availability: 'https://schema.org/InStock',
    },
    aggregateRating: {
      '@type': 'AggregateRating',
      ratingValue: '4.7',
      reviewCount: '312',
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
        name: isArabic ? 'الاستضافة' : 'Hosting',
        item: `https://progineous.com/${locale}/hosting`,
      },
      {
        '@type': 'ListItem',
        position: 3,
        name: isArabic ? 'استضافة Windows موزعين' : 'Windows Reseller',
        item: `https://progineous.com/${locale}/hosting/windows-reseller`,
      },
    ],
  };

  return (
    <>
      <Script
        id="windows-reseller-product-schema"
        type="application/ld+json"
        dangerouslySetInnerHTML={{ __html: JSON.stringify(productSchema) }}
      />
      <Script
        id="windows-reseller-breadcrumb-schema"
        type="application/ld+json"
        dangerouslySetInnerHTML={{ __html: JSON.stringify(breadcrumbSchema) }}
      />
      {children}
    </>
  );
}
