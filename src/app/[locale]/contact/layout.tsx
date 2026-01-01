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
    ? 'اتصل بنا | بروجينيوس - تواصل مع فريق الدعم'
    : 'Contact Us | Pro Gineous - Get in Touch with Our Team';
  const description = isArabic
    ? 'تواصل مع فريق بروجينيوس للحصول على الدعم الفني أو المبيعات أو الاستفسارات. دعم متوفر على مدار الساعة عبر البريد الإلكتروني والواتساب والدردشة المباشرة.'
    : 'Contact Pro Gineous team for technical support, sales, or inquiries. 24/7 support available via email, WhatsApp, and live chat.';

  return {
    title,
    description,
    keywords: isArabic
      ? [
          'اتصل بنا بروجينيوس',
          'دعم فني استضافة',
          'تواصل معنا',
          'رقم بروجينيوس',
          'بريد بروجينيوس',
          'واتساب بروجينيوس',
          'عنوان بروجينيوس',
          'دعم عملاء استضافة',
          'مساعدة استضافة مواقع',
          'استفسارات الاستضافة',
          'بني سويف مصر',
          'دعم عربي',
          'خدمة عملاء',
          'نظام تذاكر الدعم',
          'دردشة مباشرة',
          // Arab Markets
          'دعم استضافة السعودية',
          'دعم استضافة الامارات',
        ]
      : [
          'contact pro gineous',
          'hosting support',
          'get in touch',
          'pro gineous phone',
          'pro gineous email',
          'pro gineous whatsapp',
          'pro gineous address',
          'hosting customer support',
          'web hosting help',
          'hosting inquiries',
          'beni suef egypt',
          'arabic support',
          'customer service',
          'support ticket system',
          'live chat support',
          // Western Markets
          'contact hosting USA',
          'hosting support UK',
          '24/7 hosting support',
          'international support',
          'multilingual support',
        ],
    openGraph: {
      title: isArabic
        ? 'اتصل بنا | بروجينيوس'
        : 'Contact Us | Pro Gineous',
      description: isArabic
        ? 'تواصل مع فريقنا للحصول على الدعم الفني والمبيعات. دعم على مدار الساعة.'
        : 'Get in touch with our team for technical support and sales. 24/7 support available.',
      url: `${baseUrl}/${locale}/contact`,
      siteName: 'Pro Gineous',
      locale: isArabic ? 'ar_EG' : 'en_US',
      type: 'website',
      images: [
        {
          url: `/api/og?title=${encodeURIComponent(title)}&description=${encodeURIComponent(description)}&locale=${locale}&page=contact`,
          width: 1200,
          height: 630,
          alt: isArabic ? 'اتصل بنا - بروجينيوس' : 'Contact Us - Pro Gineous',
        },
      ],
    },
    twitter: {
      card: 'summary_large_image',
      title: isArabic
        ? 'اتصل بنا | بروجينيوس'
        : 'Contact Us | Pro Gineous',
      description: isArabic
        ? 'تواصل معنا للحصول على الدعم الفني والمبيعات'
        : 'Get in touch for technical support and sales',
      images: [`/api/og?title=${encodeURIComponent(title)}&description=${encodeURIComponent(description)}&locale=${locale}&page=contact`],
    },
    alternates: {
      canonical: `${baseUrl}/${locale}/contact`,
      languages: {
        en: `${baseUrl}/en/contact`,
        ar: `${baseUrl}/ar/contact`,
        'en-US': `${baseUrl}/en/contact`,
        'en-GB': `${baseUrl}/en/contact`,
        'de-DE': `${baseUrl}/en/contact`,
        'fr-FR': `${baseUrl}/en/contact`,
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

export default async function ContactLayout({ children, params }: Props) {
  const { locale } = await params;
  const isArabic = locale === 'ar';

  // ContactPage Schema
  const contactPageSchema = {
    '@context': 'https://schema.org',
    '@type': 'ContactPage',
    name: isArabic ? 'اتصل بنا - برو جينيوس' : 'Contact Us - Pro Gineous',
    description: isArabic
      ? 'تواصل مع فريق برو جينيوس للدعم الفني والمبيعات'
      : 'Contact Pro Gineous team for technical support and sales',
    url: `https://progineous.com/${locale}/contact`,
    mainEntity: {
      '@type': 'Organization',
      name: 'Pro Gineous',
      telephone: '+201070798859',
      email: 'support@progineous.com',
      contactPoint: [
        {
          '@type': 'ContactPoint',
          telephone: '+201070798859',
          contactType: 'customer service',
          availableLanguage: ['Arabic', 'English'],
          hoursAvailable: {
            '@type': 'OpeningHoursSpecification',
            dayOfWeek: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
            opens: '00:00',
            closes: '23:59',
          },
        },
      ],
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
        name: isArabic ? 'اتصل بنا' : 'Contact Us',
        item: `https://progineous.com/${locale}/contact`,
      },
    ],
  };

  return (
    <>
      <Script
        id="contact-page-schema"
        type="application/ld+json"
        dangerouslySetInnerHTML={{ __html: JSON.stringify(contactPageSchema) }}
      />
      <Script
        id="contact-breadcrumb-schema"
        type="application/ld+json"
        dangerouslySetInnerHTML={{ __html: JSON.stringify(breadcrumbSchema) }}
      />
      {children}
    </>
  );
}
