import type { Metadata } from 'next';

type Props = {
  params: Promise<{ locale: string }>;
};

export async function generateMetadata({ params }: Props): Promise<Metadata> {
  const { locale } = await params;
  const isArabic = locale === 'ar';
  const baseUrl = process.env.NEXT_PUBLIC_SITE_URL || 'https://progineous.com';

  const title = isArabic
    ? 'سياسة الاستخدام المقبول | بروجينيوس - قواعد الاستخدام'
    : 'Acceptable Use Policy | Pro Gineous - Usage Guidelines';
  const description = isArabic
    ? 'تعرف على سياسة الاستخدام المقبول في بروجينيوس. القواعد والإرشادات للاستخدام الآمن والقانوني لخدمات الاستضافة.'
    : 'Learn about Pro Gineous Acceptable Use Policy. Rules and guidelines for safe and legal use of hosting services.';

  return {
    title,
    description,
    keywords: isArabic
      ? [
          'سياسة الاستخدام المقبول',
          'قواعد الاستخدام',
          'محتوى محظور',
          'أنشطة غير قانونية',
          'إساءة الاستخدام',
          'سياسة الأمان',
          'قواعد الاستضافة',
          'محتوى مسموح',
          'سياسة المحتوى',
          'انتهاك السياسة',
          'عقوبات الانتهاك',
          'بروجينيوس AUP',
          'قواعد الخادم',
          'سياسة البريد',
          'مكافحة الاحتيال',
        ]
      : [
          'acceptable use policy',
          'usage rules',
          'prohibited content',
          'illegal activities',
          'abuse policy',
          'security policy',
          'hosting rules',
          'allowed content',
          'content policy',
          'policy violation',
          'violation penalties',
          'pro gineous AUP',
          'server rules',
          'email policy',
          'anti-fraud',
        ],
    openGraph: {
      title: isArabic
        ? 'سياسة الاستخدام المقبول | بروجينيوس'
        : 'Acceptable Use Policy | Pro Gineous',
      description: isArabic
        ? 'قواعد وإرشادات استخدام خدمات بروجينيوس'
        : 'Rules and guidelines for using Pro Gineous services',
      url: `${baseUrl}/${locale}/aup`,
      siteName: 'Pro Gineous',
      locale: isArabic ? 'ar_EG' : 'en_US',
      type: 'website',
      images: [
        {
          url: `/api/og?title=${encodeURIComponent(title)}&description=${encodeURIComponent(description)}&locale=${locale}&page=default`,
          width: 1200,
          height: 630,
          alt: isArabic ? 'سياسة الاستخدام المقبول - بروجينيوس' : 'Acceptable Use Policy - Pro Gineous',
        },
      ],
    },
    twitter: {
      card: 'summary_large_image',
      title: isArabic ? 'سياسة الاستخدام المقبول | بروجينيوس' : 'Acceptable Use Policy | Pro Gineous',
      images: [`/api/og?title=${encodeURIComponent(title)}&description=${encodeURIComponent(description)}&locale=${locale}&page=default`],
    },
    alternates: {
      canonical: `${baseUrl}/${locale}/aup`,
      languages: {
        en: `${baseUrl}/en/aup`,
        ar: `${baseUrl}/ar/aup`,
      },
    },
    robots: {
      index: true,
      follow: true,
    },
  };
}

export default function AUPLayout({ children }: { children: React.ReactNode }) {
  return <>{children}</>;
}
