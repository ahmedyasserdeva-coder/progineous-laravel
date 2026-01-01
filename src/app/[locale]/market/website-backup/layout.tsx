import type { Metadata } from 'next';

type Props = {
  params: Promise<{ locale: string }>;
};

export async function generateMetadata({ params }: Props): Promise<Metadata> {
  const { locale } = await params;
  const isArabic = locale === 'ar';
  
  const title = isArabic 
    ? 'نسخ احتياطي للموقع | CodeGuard حماية وأرشفة المواقع من $2.09/شهر - بروجينيوس'
    : 'Website Backup | CodeGuard Cloud Backup & Protection from $2.09/mo - Pro Gineous';
  
  const description = isArabic
    ? 'احمِ موقعك مع CodeGuard. نسخ احتياطي يومي تلقائي، استعادة بنقرة واحدة، مراقبة تغييرات الملفات، واكتشاف البرامج الضارة. مساحات من 1GB إلى 200GB. الأسعار تبدأ من $2.09/شهر. حماية سحابية في مصر والسعودية والإمارات وأمريكا وكندا وأوروبا.'
    : 'Protect your website with CodeGuard cloud backup. Automatic daily backups, one-click restore, file change monitoring, and malware detection. Storage from 1GB to 200GB. Starting at $2.09/mo. Cloud protection in USA, UK, Canada, Germany, France, Egypt, Saudi Arabia, UAE.';

  const keywords = isArabic
    ? [
        'نسخ احتياطي للموقع',
        'CodeGuard',
        'حماية الموقع',
        'استعادة الموقع',
        'نسخ احتياطي سحابي',
        'نسخ احتياطي WordPress',
        'أرشفة الموقع',
        'حماية الملفات',
        'مراقبة الملفات',
        'اكتشاف البرامج الضارة',
        'نسخ احتياطي يومي',
        'استعادة الملفات',
        'حماية قاعدة البيانات',
        'نسخ احتياطي FTP',
        'آلة الزمن للموقع',
        'backup موقع مصر',
        'نسخ احتياطي السعودية',
        'نسخ احتياطي الإمارات',
        'حماية موقع الكترونية',
        'disaster recovery',
        'نسخة احتياطية آمنة',
      ]
    : [
        'website backup',
        'CodeGuard',
        'site protection',
        'website restore',
        'cloud backup',
        'WordPress backup',
        'site archiving',
        'file protection',
        'file monitoring',
        'malware detection',
        'daily backup',
        'file restore',
        'database backup',
        'FTP backup',
        'website time machine',
        'automatic backup USA',
        'cloud backup UK',
        'website backup Canada',
        'site backup Germany',
        'backup service France',
        'disaster recovery',
        'data protection',
        'website security backup',
        'offsite backup',
        'incremental backup',
        'backup automation',
        'website versioning',
        'backup and restore',
        'secure cloud backup',
        'managed backup service',
      ];

  const baseUrl = process.env.NEXT_PUBLIC_SITE_URL || 'https://progineous.com';
  const canonicalUrl = `${baseUrl}/${locale}/market/website-backup`;
  
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
        'en': `${baseUrl}/en/market/website-backup`,
        'ar': `${baseUrl}/ar/market/website-backup`,
        'en-US': `${baseUrl}/en/market/website-backup`,
        'en-GB': `${baseUrl}/en/market/website-backup`,
        'en-CA': `${baseUrl}/en/market/website-backup`,
        'en-AU': `${baseUrl}/en/market/website-backup`,
        'de-DE': `${baseUrl}/en/market/website-backup`,
        'fr-FR': `${baseUrl}/en/market/website-backup`,
        'ar-EG': `${baseUrl}/ar/market/website-backup`,
        'ar-SA': `${baseUrl}/ar/market/website-backup`,
        'ar-AE': `${baseUrl}/ar/market/website-backup`,
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
          alt: isArabic ? 'نسخ احتياطي للموقع CodeGuard - بروجينيوس' : 'CodeGuard Website Backup - Pro Gineous',
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

export default async function WebsiteBackupLayout({
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
    name: 'CodeGuard Website Backup',
    description: isArabic
      ? 'نسخ احتياطي سحابي يومي تلقائي مع استعادة بنقرة واحدة ومراقبة الملفات'
      : 'Automatic daily cloud backup with one-click restore and file monitoring',
    brand: {
      '@type': 'Brand',
      name: 'CodeGuard',
    },
    offers: {
      '@type': 'AggregateOffer',
      lowPrice: '2.09',
      highPrice: '34.99',
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
      reviewCount: '1580',
      bestRating: '5',
      worstRating: '1',
    },
    category: 'Website Backup Service',
  };

  const faqSchema = {
    '@context': 'https://schema.org',
    '@type': 'FAQPage',
    mainEntity: [
      {
        '@type': 'Question',
        name: isArabic ? 'كم مرة يتم النسخ الاحتياطي؟' : 'How often are backups made?',
        acceptedAnswer: {
          '@type': 'Answer',
          text: isArabic
            ? 'يتم النسخ الاحتياطي تلقائياً يومياً. يمكنك أيضاً إجراء نسخ احتياطي يدوي في أي وقت.'
            : 'Backups are made automatically daily. You can also perform manual backup at any time.',
        },
      },
      {
        '@type': 'Question',
        name: isArabic ? 'هل يمكنني استعادة ملف واحد فقط؟' : 'Can I restore just one file?',
        acceptedAnswer: {
          '@type': 'Answer',
          text: isArabic
            ? 'نعم، يمكنك استعادة ملف واحد، مجلد، أو الموقع بالكامل من أي نقطة زمنية.'
            : 'Yes, you can restore a single file, folder, or the entire website from any point in time.',
        },
      },
      {
        '@type': 'Question',
        name: isArabic ? 'هل النسخ الاحتياطية آمنة؟' : 'Are backups secure?',
        acceptedAnswer: {
          '@type': 'Answer',
          text: isArabic
            ? 'نعم، جميع النسخ مشفرة ومخزنة في مراكز بيانات آمنة متعددة.'
            : 'Yes, all backups are encrypted and stored in multiple secure data centers.',
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
        name: isArabic ? 'نسخ احتياطي للموقع' : 'Website Backup',
        item: `${baseUrl}/${locale}/market/website-backup`,
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
