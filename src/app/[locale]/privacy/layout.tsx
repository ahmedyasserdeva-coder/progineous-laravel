import type { Metadata } from 'next';

type Props = {
  params: Promise<{ locale: string }>;
};

export async function generateMetadata({ params }: Props): Promise<Metadata> {
  const { locale } = await params;
  const isArabic = locale === 'ar';
  const baseUrl = process.env.NEXT_PUBLIC_SITE_URL || 'https://progineous.com';

  const title = isArabic
    ? 'سياسة الخصوصية | حماية بياناتك متوافقة مع GDPR - بروجينيوس'
    : 'Privacy Policy | GDPR Compliant Data Protection - Pro Gineous';
  const description = isArabic
    ? 'تعرف على كيفية جمع واستخدام وحماية بياناتك الشخصية في بروجينيوس. نلتزم بأعلى معايير حماية الخصوصية ومتوافقون مع GDPR وقوانين حماية البيانات في الاتحاد الأوروبي وأمريكا والشرق الأوسط.'
    : 'Learn how Pro Gineous collects, uses, and protects your personal data. We are committed to the highest privacy protection standards, GDPR compliant, and follow data protection laws in EU, USA, and Middle East.';

  return {
    title,
    description,
    keywords: isArabic
      ? [
          'سياسة الخصوصية',
          'حماية البيانات',
          'خصوصية المستخدم',
          'جمع البيانات',
          'ملفات تعريف الارتباط',
          'حقوق الخصوصية',
          'أمان البيانات',
          'معلومات شخصية',
          'سرية المعلومات',
          'GDPR',
          'حماية المعلومات',
          'بروجينيوس خصوصية',
          'سياسة البيانات',
          'تخزين البيانات',
          'مشاركة البيانات',
          'حماية البيانات مصر',
          'خصوصية السعودية',
          'GDPR الإمارات',
          'cookies policy عربي',
          'data protection',
        ]
      : [
          'privacy policy',
          'data protection',
          'user privacy',
          'data collection',
          'cookies',
          'privacy rights',
          'data security',
          'personal information',
          'information confidentiality',
          'GDPR',
          'information protection',
          'pro gineous privacy',
          'data policy',
          'data storage',
          'data sharing',
          'privacy policy USA',
          'GDPR compliance UK',
          'data protection Canada',
          'privacy Germany',
          'RGPD France',
          'CCPA compliance',
          'cookie policy',
          'data processing',
          'user consent',
          'privacy rights',
        ],
    openGraph: {
      title: isArabic
        ? 'سياسة الخصوصية | بروجينيوس'
        : 'Privacy Policy | Pro Gineous',
      description: isArabic
        ? 'كيف نحمي خصوصيتك وبياناتك الشخصية'
        : 'How we protect your privacy and personal data',
      url: `${baseUrl}/${locale}/privacy`,
      siteName: 'Pro Gineous',
      locale: isArabic ? 'ar_EG' : 'en_US',
      type: 'website',
      images: [
        {
          url: `/api/og?title=${encodeURIComponent(title)}&description=${encodeURIComponent(description)}&locale=${locale}&page=default`,
          width: 1200,
          height: 630,
          alt: isArabic ? 'سياسة الخصوصية - بروجينيوس' : 'Privacy Policy - Pro Gineous',
        },
      ],
    },
    twitter: {
      card: 'summary_large_image',
      title: isArabic ? 'سياسة الخصوصية | بروجينيوس' : 'Privacy Policy | Pro Gineous',
      images: [`/api/og?title=${encodeURIComponent(title)}&description=${encodeURIComponent(description)}&locale=${locale}&page=default`],
    },
    alternates: {
      canonical: `${baseUrl}/${locale}/privacy`,
      languages: {
        'en': `${baseUrl}/en/privacy`,
        'ar': `${baseUrl}/ar/privacy`,
        'en-US': `${baseUrl}/en/privacy`,
        'en-GB': `${baseUrl}/en/privacy`,
        'en-CA': `${baseUrl}/en/privacy`,
        'en-AU': `${baseUrl}/en/privacy`,
        'de-DE': `${baseUrl}/en/privacy`,
        'fr-FR': `${baseUrl}/en/privacy`,
        'ar-EG': `${baseUrl}/ar/privacy`,
        'ar-SA': `${baseUrl}/ar/privacy`,
        'ar-AE': `${baseUrl}/ar/privacy`,
      },
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

export default async function PrivacyLayout({
  children,
  params,
}: {
  children: React.ReactNode;
  params: Promise<{ locale: string }>;
}) {
  const { locale } = await params;
  const isArabic = locale === 'ar';
  const baseUrl = process.env.NEXT_PUBLIC_SITE_URL || 'https://progineous.com';

  const webPageSchema = {
    '@context': 'https://schema.org',
    '@type': 'WebPage',
    name: isArabic ? 'سياسة الخصوصية' : 'Privacy Policy',
    description: isArabic
      ? 'سياسة الخصوصية وحماية البيانات لموقع بروجينيوس'
      : 'Privacy Policy and Data Protection for Pro Gineous website',
    url: `${baseUrl}/${locale}/privacy`,
    mainEntity: {
      '@type': 'Article',
      headline: isArabic ? 'سياسة الخصوصية' : 'Privacy Policy',
      author: {
        '@type': 'Organization',
        name: 'Pro Gineous',
      },
      publisher: {
        '@type': 'Organization',
        name: 'Pro Gineous',
        url: baseUrl,
      },
      datePublished: '2024-01-01',
      dateModified: '2025-01-01',
    },
    isPartOf: {
      '@type': 'WebSite',
      name: 'Pro Gineous',
      url: baseUrl,
    },
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
        name: isArabic ? 'سياسة الخصوصية' : 'Privacy Policy',
        item: `${baseUrl}/${locale}/privacy`,
      },
    ],
  };

  return (
    <>
      <script
        type="application/ld+json"
        dangerouslySetInnerHTML={{ __html: JSON.stringify(webPageSchema) }}
      />
      <script
        type="application/ld+json"
        dangerouslySetInnerHTML={{ __html: JSON.stringify(breadcrumbSchema) }}
      />
      {children}
    </>
  );
}
