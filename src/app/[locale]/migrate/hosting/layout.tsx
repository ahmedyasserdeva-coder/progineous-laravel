import type { Metadata } from 'next';

type Props = {
  params: Promise<{ locale: string }>;
};

export async function generateMetadata({ params }: Props): Promise<Metadata> {
  const { locale } = await params;
  const isArabic = locale === 'ar';
  
  const title = isArabic 
    ? 'نقل الاستضافة مجاناً | انقل موقعك بدون توقف خلال 24 ساعة - بروجينيوس'
    : 'Free Hosting Migration | Zero Downtime Website Transfer in 24 Hours - Pro Gineous';
  
  const description = isArabic
    ? 'انقل موقعك إلينا مجاناً بدون أي توقف! فريق خبراء ينقل ملفاتك وقواعد بياناتك وبريدك الإلكتروني بأمان خلال 24-48 ساعة. نقل مشفر 100% مع دعم فني 24/7. نقل WordPress، cPanel، Plesk مجاناً في مصر والسعودية والإمارات وأمريكا وكندا وأوروبا.'
    : 'Migrate your website to us for FREE with zero downtime! Expert team transfers your files, databases, and emails safely within 24-48 hours. 100% encrypted migration with 24/7 support. Free WordPress, cPanel, Plesk migration. Trusted in USA, UK, Canada, Germany, France, Egypt, Saudi Arabia, UAE.';

  const keywords = isArabic
    ? [
        'نقل الاستضافة',
        'نقل الموقع',
        'نقل موقع مجاني',
        'نقل استضافة مجاني',
        'ترحيل الموقع',
        'نقل بدون توقف',
        'نقل قاعدة البيانات',
        'نقل ملفات الموقع',
        'نقل ووردبريس',
        'نقل استضافة آمن',
        'خدمة نقل المواقع',
        'نقل سيرفر',
        'تغيير الاستضافة',
        'نقل الموقع لسيرفر جديد',
        'نقل موقع احترافي',
        'نقل cPanel',
        'نقل Plesk',
        'نقل استضافة مصر',
        'نقل استضافة السعودية',
        'نقل استضافة الإمارات',
        'نقل استضافة الأردن',
        'نقل استضافة الكويت',
        'migration hosting مجاني',
        'نقل موقع للخارج',
        'نقل استضافة للسحابة',
      ]
    : [
        'hosting migration',
        'website transfer',
        'free website migration',
        'free hosting migration',
        'website relocation',
        'zero downtime migration',
        'database migration',
        'website files transfer',
        'WordPress migration',
        'secure hosting migration',
        'website migration service',
        'server migration',
        'change hosting provider',
        'transfer to new server',
        'professional site migration',
        'cPanel migration',
        'Plesk migration',
        'hosting migration USA',
        'website transfer UK',
        'migration service Canada',
        'hosting migration Germany',
        'free migration France',
        'website transfer Australia',
        'hosting migration Europe',
        'migrate web hosting',
        'switch hosting provider',
        'move website to new host',
        'hosting transfer service',
        'full website migration',
        'managed migration service',
      ];

  const baseUrl = process.env.NEXT_PUBLIC_SITE_URL || 'https://progineous.com';
  const canonicalUrl = `${baseUrl}/${locale}/migrate/hosting`;
  
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
        'en': `${baseUrl}/en/migrate/hosting`,
        'ar': `${baseUrl}/ar/migrate/hosting`,
        'en-US': `${baseUrl}/en/migrate/hosting`,
        'en-GB': `${baseUrl}/en/migrate/hosting`,
        'en-CA': `${baseUrl}/en/migrate/hosting`,
        'en-AU': `${baseUrl}/en/migrate/hosting`,
        'de-DE': `${baseUrl}/en/migrate/hosting`,
        'fr-FR': `${baseUrl}/en/migrate/hosting`,
        'ar-EG': `${baseUrl}/ar/migrate/hosting`,
        'ar-SA': `${baseUrl}/ar/migrate/hosting`,
        'ar-AE': `${baseUrl}/ar/migrate/hosting`,
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
          alt: isArabic ? 'نقل الاستضافة مجاناً - بروجينيوس' : 'Free Hosting Migration - Pro Gineous',
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

export default async function HostingMigrationLayout({
  children,
  params,
}: {
  children: React.ReactNode;
  params: Promise<{ locale: string }>;
}) {
  const { locale } = await params;
  const isArabic = locale === 'ar';
  const baseUrl = process.env.NEXT_PUBLIC_SITE_URL || 'https://progineous.com';

  const serviceSchema = {
    '@context': 'https://schema.org',
    '@type': 'Service',
    name: isArabic ? 'خدمة نقل الاستضافة المجانية' : 'Free Hosting Migration Service',
    description: isArabic
      ? 'نقل موقعك إلينا مجاناً بدون توقف مع فريق خبراء متخصص'
      : 'Migrate your website to us for FREE with zero downtime by expert team',
    provider: {
      '@type': 'Organization',
      name: 'Pro Gineous',
      url: baseUrl,
    },
    serviceType: 'Website Migration',
    areaServed: [
      { '@type': 'Country', name: 'United States' },
      { '@type': 'Country', name: 'United Kingdom' },
      { '@type': 'Country', name: 'Canada' },
      { '@type': 'Country', name: 'Germany' },
      { '@type': 'Country', name: 'France' },
      { '@type': 'Country', name: 'Australia' },
      { '@type': 'Country', name: 'Egypt' },
      { '@type': 'Country', name: 'Saudi Arabia' },
      { '@type': 'Country', name: 'United Arab Emirates' },
    ],
    offers: {
      '@type': 'Offer',
      price: '0',
      priceCurrency: 'USD',
      availability: 'https://schema.org/InStock',
      priceValidUntil: '2025-12-31',
    },
    termsOfService: `${baseUrl}/terms`,
  };

  const faqSchema = {
    '@context': 'https://schema.org',
    '@type': 'FAQPage',
    mainEntity: [
      {
        '@type': 'Question',
        name: isArabic ? 'هل نقل الموقع مجاني حقاً؟' : 'Is the website migration really free?',
        acceptedAnswer: {
          '@type': 'Answer',
          text: isArabic
            ? 'نعم، نقل الموقع مجاني 100% لجميع خطط الاستضافة. فريقنا ينقل ملفاتك وقواعد البيانات والبريد الإلكتروني بدون أي رسوم.'
            : 'Yes, website migration is 100% free for all hosting plans. Our team transfers your files, databases, and emails at no charge.',
        },
      },
      {
        '@type': 'Question',
        name: isArabic ? 'كم يستغرق نقل الموقع؟' : 'How long does website migration take?',
        acceptedAnswer: {
          '@type': 'Answer',
          text: isArabic
            ? 'عادة يتم نقل الموقع خلال 24-48 ساعة حسب حجم الموقع. المواقع الصغيرة قد تنتقل خلال ساعات.'
            : 'Usually migration is completed within 24-48 hours depending on website size. Small websites may be migrated within hours.',
        },
      },
      {
        '@type': 'Question',
        name: isArabic ? 'هل سيتوقف موقعي أثناء النقل؟' : 'Will my website go down during migration?',
        acceptedAnswer: {
          '@type': 'Answer',
          text: isArabic
            ? 'لا، نضمن نقل بدون توقف. نحتفظ بموقعك القديم حتى يتم التأكد من عمل النسخة الجديدة بشكل كامل.'
            : 'No, we guarantee zero downtime migration. We keep your old site running until the new copy is fully verified.',
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
        name: isArabic ? 'نقل' : 'Migrate',
        item: `${baseUrl}/${locale}/migrate`,
      },
      {
        '@type': 'ListItem',
        position: 3,
        name: isArabic ? 'نقل الاستضافة' : 'Hosting Migration',
        item: `${baseUrl}/${locale}/migrate/hosting`,
      },
    ],
  };

  return (
    <>
      <script
        type="application/ld+json"
        dangerouslySetInnerHTML={{ __html: JSON.stringify(serviceSchema) }}
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
