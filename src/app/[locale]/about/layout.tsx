import type { Metadata } from 'next';
import Script from 'next/script';

type Props = {
  children: React.ReactNode;
  params: Promise<{ locale: string }>;
};

export async function generateMetadata({ params }: Props): Promise<Metadata> {
  const { locale } = await params;
  const isArabic = locale === 'ar';
  const baseUrl = process.env.NEXT_PUBLIC_SITE_URL || 'https://progineous.com';

  const title = isArabic
    ? 'من نحن | بروجينيوس - شريكك الموثوق في استضافة المواقع'
    : 'About Us | Pro Gineous - Your Trusted Web Hosting Partner';
  const description = isArabic
    ? 'تعرف على بروجينيوس - شركة استضافة مواقع رائدة في مصر والشرق الأوسط. نقدم حلول استضافة موثوقة وعالية الأداء مع دعم على مدار الساعة ووقت تشغيل 99.9%.'
    : 'Learn about Pro Gineous - A leading web hosting company in Egypt and the Middle East. We provide reliable, high-performance hosting solutions with 24/7 support and 99.9% uptime.';

  return {
    title,
    description,
    keywords: isArabic
      ? [
          'من نحن بروجينيوس',
          'شركة استضافة مصرية',
          'استضافة مواقع مصر',
          'أحمد ياسر مؤسس بروجينيوس',
          'خدمات الاستضافة',
          'رؤية بروجينيوس',
          'مهمة بروجينيوس',
          'قيم الشركة',
          'البنية التحتية للاستضافة',
          'دعم عملاء عربي',
          'استضافة موثوقة',
          'هوية الشركة',
          'شركة تقنية مصرية',
          'مزود استضافة الشرق الأوسط',
          'بني سويف مصر',
          // Arab Markets
          'شركة استضافة السعودية',
          'شركة استضافة الامارات',
          'شركة استضافة الخليج',
        ]
      : [
          'about pro gineous',
          'egyptian hosting company',
          'web hosting egypt',
          'ahmed yasser founder',
          'hosting services',
          'pro gineous vision',
          'pro gineous mission',
          'company values',
          'hosting infrastructure',
          'arabic customer support',
          'reliable hosting',
          'brand identity',
          'egyptian tech company',
          'middle east hosting provider',
          'beni suef egypt',
          // Western Markets
          'hosting company USA',
          'hosting company UK',
          'hosting company Germany',
          'international hosting provider',
          'global web hosting',
          'about us web hosting',
        ],
    openGraph: {
      title,
      description: isArabic
        ? 'تعرف على بروجينيوس - شركة استضافة مواقع رائدة في مصر والشرق الأوسط منذ 2020. نخدم أكثر من 10,000 عميل بوقت تشغيل 99.9%.'
        : 'Learn about Pro Gineous - A leading web hosting company in Egypt and the Middle East since 2020. Serving 10,000+ clients with 99.9% uptime.',
      url: `${baseUrl}/${locale}/about`,
      siteName: 'Pro Gineous',
      locale: isArabic ? 'ar_EG' : 'en_US',
      type: 'website',
      images: [
        {
          url: `/api/og?title=${encodeURIComponent(title)}&description=${encodeURIComponent(description)}&locale=${locale}&page=about`,
          width: 1200,
          height: 630,
          alt: isArabic ? 'بروجينيوس - من نحن' : 'Pro Gineous - About Us',
        },
      ],
    },
    twitter: {
      card: 'summary_large_image',
      title: isArabic
        ? 'من نحن | بروجينيوس'
        : 'About Us | Pro Gineous',
      description: isArabic
        ? 'شريكك الموثوق في استضافة المواقع والخدمات الرقمية منذ 2020'
        : 'Your trusted partner in web hosting and digital services since 2020',
      images: [`/api/og?title=${encodeURIComponent(title)}&description=${encodeURIComponent(description)}&locale=${locale}&page=about`],
    },
    alternates: {
      canonical: `${baseUrl}/${locale}/about`,
      languages: {
        en: `${baseUrl}/en/about`,
        ar: `${baseUrl}/ar/about`,
        'en-US': `${baseUrl}/en/about`,
        'en-GB': `${baseUrl}/en/about`,
        'de-DE': `${baseUrl}/en/about`,
        'fr-FR': `${baseUrl}/en/about`,
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

export default async function AboutLayout({ children, params }: Props) {
  const { locale } = await params;
  const isArabic = locale === 'ar';

  // AboutPage Schema
  const aboutPageSchema = {
    '@context': 'https://schema.org',
    '@type': 'AboutPage',
    name: isArabic ? 'من نحن - برو جينيوس' : 'About Us - Pro Gineous',
    description: isArabic
      ? 'تعرف على برو جينيوس - شركة استضافة مواقع رائدة'
      : 'Learn about Pro Gineous - A leading web hosting company',
    url: `https://progineous.com/${locale}/about`,
    mainEntity: {
      '@type': 'Organization',
      name: 'Pro Gineous',
      foundingDate: '2020',
      numberOfEmployees: '10-50',
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
        name: isArabic ? 'من نحن' : 'About Us',
        item: `https://progineous.com/${locale}/about`,
      },
    ],
  };

  return (
    <>
      <Script
        id="about-page-schema"
        type="application/ld+json"
        dangerouslySetInnerHTML={{ __html: JSON.stringify(aboutPageSchema) }}
      />
      <Script
        id="about-breadcrumb-schema"
        type="application/ld+json"
        dangerouslySetInnerHTML={{ __html: JSON.stringify(breadcrumbSchema) }}
      />
      {children}
    </>
  );
}
