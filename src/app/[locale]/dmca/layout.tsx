import type { Metadata } from 'next';

type Props = {
  params: Promise<{ locale: string }>;
};

export async function generateMetadata({ params }: Props): Promise<Metadata> {
  const { locale } = await params;
  const isArabic = locale === 'ar';
  const baseUrl = process.env.NEXT_PUBLIC_SITE_URL || 'https://progineous.com';

  const title = isArabic
    ? 'سياسة DMCA | بروجينيوس - حقوق النشر والملكية الفكرية'
    : 'DMCA Policy | Pro Gineous - Copyright & Intellectual Property';
  const description = isArabic
    ? 'سياسة قانون الألفية الرقمية لحقوق النشر (DMCA) في بروجينيوس. كيفية الإبلاغ عن انتهاكات حقوق النشر والإجراءات المتبعة.'
    : 'Pro Gineous Digital Millennium Copyright Act (DMCA) Policy. How to report copyright infringement and procedures followed.';

  return {
    title,
    description,
    keywords: isArabic
      ? [
          'سياسة DMCA',
          'حقوق النشر',
          'الملكية الفكرية',
          'إشعار الإزالة',
          'انتهاك حقوق النشر',
          'طلب إزالة',
          'إشعار مضاد',
          'وكيل DMCA',
          'حماية المحتوى',
          'قانون الألفية الرقمية',
          'تقرير انتهاك',
          'بروجينيوس DMCA',
          'حقوق المؤلف',
          'محتوى مخالف',
          'إزالة محتوى',
        ]
      : [
          'DMCA policy',
          'copyright',
          'intellectual property',
          'takedown notice',
          'copyright infringement',
          'removal request',
          'counter notification',
          'DMCA agent',
          'content protection',
          'digital millennium',
          'infringement report',
          'pro gineous DMCA',
          'author rights',
          'infringing content',
          'content removal',
        ],
    openGraph: {
      title: isArabic
        ? 'سياسة DMCA | بروجينيوس'
        : 'DMCA Policy | Pro Gineous',
      description: isArabic
        ? 'سياسة حقوق النشر والإبلاغ عن الانتهاكات'
        : 'Copyright policy and reporting infringements',
      url: `${baseUrl}/${locale}/dmca`,
      siteName: 'Pro Gineous',
      locale: isArabic ? 'ar_EG' : 'en_US',
      type: 'website',
      images: [
        {
          url: `/api/og?title=${encodeURIComponent(title)}&description=${encodeURIComponent(description)}&locale=${locale}&page=default`,
          width: 1200,
          height: 630,
          alt: isArabic ? 'سياسة DMCA - بروجينيوس' : 'DMCA Policy - Pro Gineous',
        },
      ],
    },
    twitter: {
      card: 'summary_large_image',
      title: isArabic ? 'سياسة DMCA | بروجينيوس' : 'DMCA Policy | Pro Gineous',
      images: [`/api/og?title=${encodeURIComponent(title)}&description=${encodeURIComponent(description)}&locale=${locale}&page=default`],
    },
    alternates: {
      canonical: `${baseUrl}/${locale}/dmca`,
      languages: {
        en: `${baseUrl}/en/dmca`,
        ar: `${baseUrl}/ar/dmca`,
      },
    },
    robots: {
      index: true,
      follow: true,
    },
  };
}

export default function DMCALayout({ children }: { children: React.ReactNode }) {
  return <>{children}</>;
}
