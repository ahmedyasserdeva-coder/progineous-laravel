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
    ? 'استضافة الموزعين - ابدأ عملك في الاستضافة | Pro Gineous'
    : 'Reseller Hosting - Start Your Hosting Business | Pro Gineous';

  const description = isArabic
    ? 'ابدأ عملك الخاص في الاستضافة بأسعار تبدأ من $17 شهرياً. استضافة موزعين مع WHM/cPanel، LiteSpeed، علامة بيضاء كاملة، Cloudflare CDN، وحتى 100 حساب. مثالية لرواد الأعمال.'
    : 'Start your own hosting business from $17/month. Reseller hosting with WHM/cPanel, LiteSpeed, full whitelabel, Cloudflare CDN, and up to 100 accounts. Perfect for entrepreneurs.';

  const keywordsAr = [
    'استضافة موزعين',
    'ريسيلر هوستنج',
    'بيع الاستضافة',
    'استضافة بالجملة',
    'WHM cPanel',
    'علامة بيضاء',
    'عمل استضافة',
    'ربح من الاستضافة',
    'استضافة LiteSpeed',
    'CloudLinux',
    'استضافة غير محدودة',
    'حسابات cPanel',
    'خوادم أسماء مخصصة',
    'reseller hosting',
    'استضافة موزعين رخيصة',
    'أفضل استضافة موزعين',
    'بدء عمل استضافة',
    'استضافة عرب',
    'Imunify360',
    'شهادات SSL مجانية',
    // Arab Markets
    'استضافة موزعين مصر',
    'استضافة موزعين السعودية',
    'استضافة موزعين الامارات',
    'ريسيلر هوستنج الخليج',
  ];

  const keywordsEn = [
    'reseller hosting',
    'web hosting reseller',
    'hosting business',
    'wholesale hosting',
    'WHM cPanel',
    'whitelabel hosting',
    'start hosting business',
    'hosting profit',
    'LiteSpeed reseller',
    'CloudLinux hosting',
    'unlimited reseller hosting',
    'cPanel accounts',
    'private nameservers',
    'cheap reseller hosting',
    'best reseller hosting',
    'reseller hosting plans',
    'hosting reseller program',
    'Imunify360',
    'free SSL certificates',
    'NVMe SSD hosting',
    // Western Markets
    'reseller hosting USA',
    'reseller hosting UK',
    'reseller hosting Germany',
    'reseller hosting Canada',
    'white label hosting USA',
    'hosting reseller UK',
    'start hosting business USA',
    'European reseller hosting',
  ];

  return {
    title,
    description,
    keywords: isArabic ? keywordsAr : keywordsEn,
    openGraph: {
      type: 'website',
      locale: isArabic ? 'ar_SA' : 'en_US',
      url: isArabic ? 'https://progineous.com/ar/hosting/reseller' : 'https://progineous.com/en/hosting/reseller',
      title,
      description,
      siteName: 'Pro Gineous',
      images: [
        {
          url: `/api/og?title=${encodeURIComponent(title)}&description=${encodeURIComponent(description)}&locale=${locale}&page=hosting-reseller`,
          width: 1200,
          height: 630,
          alt: isArabic ? 'استضافة الموزعين من برو جينيوس' : 'Reseller Hosting by Pro Gineous'
        }
      ]
    },
    twitter: {
      card: 'summary_large_image',
      title,
      description,
      images: [`/api/og?title=${encodeURIComponent(title)}&description=${encodeURIComponent(description)}&locale=${locale}&page=hosting-reseller`],
    },
    alternates: {
      canonical: isArabic ? 'https://progineous.com/ar/hosting/reseller' : 'https://progineous.com/en/hosting/reseller',
      languages: {
        'ar-SA': 'https://progineous.com/ar/hosting/reseller',
        'ar-EG': 'https://progineous.com/ar/hosting/reseller',
        'ar-AE': 'https://progineous.com/ar/hosting/reseller',
        'en-US': 'https://progineous.com/en/hosting/reseller',
        'en-GB': 'https://progineous.com/en/hosting/reseller',
        'de-DE': 'https://progineous.com/en/hosting/reseller',
        'fr-FR': 'https://progineous.com/en/hosting/reseller',
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

export default async function ResellerHostingLayout({
  children,
  params,
}: Props) {
  const { locale } = await params;
  const isArabic = locale === 'ar';

  // Product Schema for Reseller Hosting
  const productSchema = {
    '@context': 'https://schema.org',
    '@type': 'Product',
    name: isArabic ? 'استضافة الموزعين' : 'Reseller Hosting',
    description: isArabic
      ? 'ابدأ عملك في الاستضافة مع WHM/cPanel، LiteSpeed، وعلامة بيضاء كاملة'
      : 'Start your hosting business with WHM/cPanel, LiteSpeed, and full whitelabel',
    brand: {
      '@type': 'Brand',
      name: 'Pro Gineous',
    },
    offers: {
      '@type': 'AggregateOffer',
      priceCurrency: 'USD',
      lowPrice: '17',
      highPrice: '69',
      offerCount: '4',
      availability: 'https://schema.org/InStock',
    },
    aggregateRating: {
      '@type': 'AggregateRating',
      ratingValue: '4.8',
      reviewCount: '534',
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
        name: isArabic ? 'كيف يمكنني بيع الاستضافة لعملائي؟' : 'How can I sell hosting to my clients?',
        acceptedAnswer: {
          '@type': 'Answer',
          text: isArabic
            ? 'مع استضافة الموزعين تحصل على WHM لإدارة حسابات cPanel، خوادم أسماء خاصة باسمك، ويمكنك تحديد أسعارك وعلامتك التجارية'
            : 'With reseller hosting you get WHM to manage cPanel accounts, private nameservers with your brand, and you can set your own prices and branding'
        }
      },
      {
        '@type': 'Question',
        name: isArabic ? 'هل العملاء سيعرفون أنني موزع؟' : 'Will clients know I\'m a reseller?',
        acceptedAnswer: {
          '@type': 'Answer',
          text: isArabic
            ? 'لا، نوفر علامة بيضاء كاملة بما في ذلك خوادم أسماء باسم شركتك، لوحة تحكم بشعارك، وبدون أي إشارة لـ Pro Gineous'
            : 'No, we offer full whitelabel including private nameservers with your company name, branded control panel, and no Pro Gineous branding'
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
        name: isArabic ? 'استضافة الموزعين' : 'Reseller Hosting',
        item: `https://progineous.com/${locale}/hosting/reseller`,
      },
    ],
  };

  return (
    <>
      <Script
        id="reseller-product-schema"
        type="application/ld+json"
        dangerouslySetInnerHTML={{ __html: JSON.stringify(productSchema) }}
      />
      <Script
        id="reseller-faq-schema"
        type="application/ld+json"
        dangerouslySetInnerHTML={{ __html: JSON.stringify(faqSchema) }}
      />
      <Script
        id="reseller-breadcrumb-schema"
        type="application/ld+json"
        dangerouslySetInnerHTML={{ __html: JSON.stringify(breadcrumbSchema) }}
      />
      {children}
    </>
  );
}
