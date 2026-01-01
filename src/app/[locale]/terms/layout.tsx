import type { Metadata } from 'next';

type Props = {
  params: Promise<{ locale: string }>;
};

export async function generateMetadata({ params }: Props): Promise<Metadata> {
  const { locale } = await params;
  const isArabic = locale === 'ar';
  const baseUrl = process.env.NEXT_PUBLIC_SITE_URL || 'https://progineous.com';

  const title = isArabic
    ? 'شروط الخدمة | الشروط والأحكام الشاملة - بروجينيوس'
    : 'Terms of Service | Comprehensive Terms and Conditions - Pro Gineous';
  const description = isArabic
    ? 'اقرأ شروط الخدمة والأحكام الخاصة ببروجينيوس. تعرف على حقوقك ومسؤولياتك عند استخدام خدمات الاستضافة والنطاقات وVPS والسيرفرات المخصصة. شروط واضحة وشفافة.'
    : 'Read Pro Gineous Terms of Service and Conditions. Learn about your rights and responsibilities when using our hosting, domains, VPS, and dedicated servers. Clear and transparent terms.';

  return {
    title,
    description,
    keywords: isArabic
      ? [
          'شروط الخدمة',
          'الشروط والأحكام',
          'سياسة الخدمة',
          'اتفاقية المستخدم',
          'شروط الاستضافة',
          'شروط النطاقات',
          'حقوق المستخدم',
          'مسؤوليات العميل',
          'سياسة الاستخدام',
          'عقد الخدمة',
          'قواعد الاستضافة',
          'بروجينيوس شروط',
          'اتفاقية الاستضافة',
          'شروط VPS',
          'شروط الموزعين',
          'terms مصر',
          'شروط الخدمة السعودية',
          'سياسة الإمارات',
          'hosting agreement عربي',
          'SLA اتفاقية',
        ]
      : [
          'terms of service',
          'terms and conditions',
          'service policy',
          'user agreement',
          'hosting terms',
          'domain terms',
          'user rights',
          'customer responsibilities',
          'usage policy',
          'service contract',
          'hosting rules',
          'pro gineous terms',
          'hosting agreement',
          'vps terms',
          'reseller terms',
          'terms of service USA',
          'hosting terms UK',
          'service agreement Canada',
          'AGB Germany',
          'CGV France',
          'SLA agreement',
          'acceptable use policy',
          'service level agreement',
          'refund policy',
          'cancellation terms',
        ],
    openGraph: {
      title: isArabic
        ? 'شروط الخدمة | بروجينيوس'
        : 'Terms of Service | Pro Gineous',
      description: isArabic
        ? 'الشروط والأحكام الخاصة باستخدام خدمات بروجينيوس'
        : 'Terms and conditions for using Pro Gineous services',
      url: `${baseUrl}/${locale}/terms`,
      siteName: 'Pro Gineous',
      locale: isArabic ? 'ar_EG' : 'en_US',
      type: 'website',
      images: [
        {
          url: `/api/og?title=${encodeURIComponent(title)}&description=${encodeURIComponent(description)}&locale=${locale}&page=default`,
          width: 1200,
          height: 630,
          alt: isArabic ? 'شروط الخدمة - بروجينيوس' : 'Terms of Service - Pro Gineous',
        },
      ],
    },
    twitter: {
      card: 'summary_large_image',
      title: isArabic ? 'شروط الخدمة | بروجينيوس' : 'Terms of Service | Pro Gineous',
      images: [`/api/og?title=${encodeURIComponent(title)}&description=${encodeURIComponent(description)}&locale=${locale}&page=default`],
    },
    alternates: {
      canonical: `${baseUrl}/${locale}/terms`,
      languages: {
        'en': `${baseUrl}/en/terms`,
        'ar': `${baseUrl}/ar/terms`,
        'en-US': `${baseUrl}/en/terms`,
        'en-GB': `${baseUrl}/en/terms`,
        'en-CA': `${baseUrl}/en/terms`,
        'en-AU': `${baseUrl}/en/terms`,
        'de-DE': `${baseUrl}/en/terms`,
        'fr-FR': `${baseUrl}/en/terms`,
        'ar-EG': `${baseUrl}/ar/terms`,
        'ar-SA': `${baseUrl}/ar/terms`,
        'ar-AE': `${baseUrl}/ar/terms`,
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

export default async function TermsLayout({
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
    name: isArabic ? 'شروط الخدمة' : 'Terms of Service',
    description: isArabic
      ? 'شروط الخدمة والأحكام لموقع بروجينيوس'
      : 'Terms of Service and Conditions for Pro Gineous website',
    url: `${baseUrl}/${locale}/terms`,
    mainEntity: {
      '@type': 'Article',
      headline: isArabic ? 'شروط الخدمة' : 'Terms of Service',
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
        name: isArabic ? 'شروط الخدمة' : 'Terms of Service',
        item: `${baseUrl}/${locale}/terms`,
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
