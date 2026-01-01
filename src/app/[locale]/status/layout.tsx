import { Metadata } from 'next';
import Script from 'next/script';

type Props = {
  params: Promise<{ locale: string }>;
  children: React.ReactNode;
};

export async function generateMetadata({ params }: Props): Promise<Metadata> {
  const { locale } = await params;
  const isArabic = locale === 'ar';

  return {
    title: isArabic ? 'حالة النظام | برو جينيوس' : 'System Status | Pro Gineous',
    description: isArabic 
      ? 'تحقق من حالة جميع خدمات برو جينيوس في الوقت الفعلي. استضافة المواقع، البريد الإلكتروني، DNS، قواعد البيانات، SSL، والمزيد. وقت تشغيل 99.99%.'
      : 'Check the real-time status of all Pro Gineous services. Web hosting, email, DNS, databases, SSL, and more. 99.99% uptime guarantee.',
    keywords: isArabic
      ? [
          'حالة الخادم',
          'حالة النظام',
          'وقت التشغيل',
          'استضافة مواقع',
          'برو جينيوس',
          'صيانة مجدولة',
          'حالة الخدمات',
          'مراقبة الخوادم',
          'انقطاع الخدمة',
          'أداء الموقع',
          'حالة DNS',
          'حالة البريد الإلكتروني',
          'حالة قاعدة البيانات',
          'حالة SSL',
          'حالة الاستضافة السحابية',
          'حالة الشبكة',
          'النسخ الاحتياطي',
          'وقت الاستجابة',
          'زمن الوصول',
          'حالة الخوادم الإقليمية',
          'استضافة الشرق الأوسط',
          'استضافة السعودية',
          'استضافة الإمارات',
          'استضافة مصر',
          'خدمات الاستضافة',
          'موثوقية الخادم',
          'ضمان وقت التشغيل',
          'حالة مركز البيانات',
          'أعطال الخدمة',
          'تحديثات النظام'
        ]
      : [
          'server status',
          'system status',
          'uptime monitoring',
          'web hosting status',
          'Pro Gineous',
          'scheduled maintenance',
          'service status',
          'server monitoring',
          'service outage',
          'website performance',
          'DNS status',
          'email server status',
          'database status',
          'SSL certificate status',
          'cloud hosting status',
          'network status',
          'backup status',
          'response time',
          'latency',
          'regional server status',
          'Middle East hosting',
          'Saudi Arabia hosting',
          'UAE hosting',
          'Egypt hosting',
          'hosting services',
          'server reliability',
          'uptime guarantee',
          'data center status',
          'service incidents',
          'system updates',
          'real-time status',
          'hosting uptime',
          'server health',
          'infrastructure status',
          'downtime alerts'
        ],
    openGraph: {
      title: isArabic ? 'حالة النظام | برو جينيوس' : 'System Status | Pro Gineous',
      description: isArabic 
        ? 'تحقق من حالة جميع خدمات برو جينيوس في الوقت الفعلي. وقت تشغيل 99.99%.'
        : 'Check the real-time status of all Pro Gineous services. 99.99% uptime guarantee.',
      type: 'website',
      locale: isArabic ? 'ar_EG' : 'en_US',
      siteName: 'Pro Gineous',
    },
    twitter: {
      card: 'summary_large_image',
      title: isArabic ? 'حالة النظام | برو جينيوس' : 'System Status | Pro Gineous',
      description: isArabic 
        ? 'تحقق من حالة جميع خدمات برو جينيوس في الوقت الفعلي.'
        : 'Check the real-time status of all Pro Gineous services.',
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
    other: {
      'revisit-after': '1 day',
      'rating': 'general',
      'referrer': 'origin-when-cross-origin',
    },
    alternates: {
      canonical: `https://progineous.com/${locale}/status`,
      languages: {
        'en': '/en/status',
        'ar': '/ar/status',
      },
    },
  };
}

export default async function StatusLayout({ children, params }: Props) {
  const { locale } = await params;
  const isArabic = locale === 'ar';

  // JSON-LD WebPage Schema for Status Page
  const statusPageSchema = {
    '@context': 'https://schema.org',
    '@type': 'WebPage',
    '@id': `https://progineous.com/${locale}/status#webpage`,
    url: `https://progineous.com/${locale}/status`,
    name: isArabic ? 'حالة النظام | برو جينيوس' : 'System Status | Pro Gineous',
    description: isArabic 
      ? 'تحقق من حالة جميع خدمات برو جينيوس في الوقت الفعلي'
      : 'Check the real-time status of all Pro Gineous services',
    isPartOf: {
      '@id': 'https://progineous.com/#website',
    },
    about: {
      '@type': 'Thing',
      name: isArabic ? 'حالة الخدمات' : 'Service Status',
    },
    mainEntity: {
      '@type': 'ItemList',
      name: isArabic ? 'قائمة الخدمات' : 'Services List',
      itemListElement: [
        { '@type': 'ListItem', position: 1, name: isArabic ? 'استضافة المواقع' : 'Web Hosting' },
        { '@type': 'ListItem', position: 2, name: isArabic ? 'خوادم البريد' : 'Email Servers' },
        { '@type': 'ListItem', position: 3, name: isArabic ? 'خوادم DNS' : 'DNS Servers' },
        { '@type': 'ListItem', position: 4, name: isArabic ? 'قواعد البيانات' : 'Databases' },
        { '@type': 'ListItem', position: 5, name: isArabic ? 'شهادات SSL' : 'SSL Certificates' },
        { '@type': 'ListItem', position: 6, name: isArabic ? 'الاستضافة السحابية' : 'Cloud Hosting' },
        { '@type': 'ListItem', position: 7, name: isArabic ? 'الشبكة' : 'Network' },
        { '@type': 'ListItem', position: 8, name: isArabic ? 'النسخ الاحتياطي' : 'Backup Services' },
      ],
    },
    speakable: {
      '@type': 'SpeakableSpecification',
      cssSelector: ['h1', '.status-banner', '.service-status'],
    },
    breadcrumb: {
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
          name: isArabic ? 'حالة النظام' : 'System Status',
          item: `https://progineous.com/${locale}/status`,
        },
      ],
    },
    dateModified: new Date().toISOString(),
    inLanguage: isArabic ? 'ar' : 'en',
  };

  return (
    <>
      <Script
        id="status-page-schema"
        type="application/ld+json"
        dangerouslySetInnerHTML={{ __html: JSON.stringify(statusPageSchema) }}
      />
      {children}
    </>
  );
}
