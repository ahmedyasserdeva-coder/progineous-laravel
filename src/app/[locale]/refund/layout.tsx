import type { Metadata } from 'next';

type Props = {
  params: Promise<{ locale: string }>;
};

export async function generateMetadata({ params }: Props): Promise<Metadata> {
  const { locale } = await params;
  const isArabic = locale === 'ar';
  const baseUrl = process.env.NEXT_PUBLIC_SITE_URL || 'https://progineous.com';

  const title = isArabic
    ? 'سياسة الاسترداد والفوترة | بروجينيوس - ضمان استرداد الأموال'
    : 'Refund & Billing Policy | Pro Gineous - Money Back Guarantee';
  const description = isArabic
    ? 'تعرف على سياسة الاسترداد والفوترة في بروجينيوس. ضمان استرداد الأموال خلال 30 يوماً، طرق الدفع، والتجديد التلقائي.'
    : 'Learn about Pro Gineous Refund & Billing Policy. 30-day money back guarantee, payment methods, and automatic renewal.';

  return {
    title,
    description,
    keywords: isArabic
      ? [
          'سياسة الاسترداد',
          'استرداد الأموال',
          'ضمان الاسترداد',
          'سياسة الفوترة',
          'طرق الدفع',
          'التجديد التلقائي',
          'إلغاء الخدمة',
          'فاتورة الاستضافة',
          'رسوم التجديد',
          'ضمان 30 يوم',
          'دفع الاستضافة',
          'بروجينيوس استرداد',
          'نزاعات الفوترة',
          'سياسة الإلغاء',
          'رد المبالغ',
        ]
      : [
          'refund policy',
          'money back',
          'refund guarantee',
          'billing policy',
          'payment methods',
          'automatic renewal',
          'service cancellation',
          'hosting invoice',
          'renewal fees',
          '30 day guarantee',
          'hosting payment',
          'pro gineous refund',
          'billing disputes',
          'cancellation policy',
          'chargeback',
        ],
    openGraph: {
      title: isArabic
        ? 'سياسة الاسترداد والفوترة | بروجينيوس'
        : 'Refund & Billing Policy | Pro Gineous',
      description: isArabic
        ? 'ضمان استرداد الأموال خلال 30 يوماً وسياسة الفوترة'
        : '30-day money back guarantee and billing policy',
      url: `${baseUrl}/${locale}/refund`,
      siteName: 'Pro Gineous',
      locale: isArabic ? 'ar_EG' : 'en_US',
      type: 'website',
      images: [
        {
          url: `/api/og?title=${encodeURIComponent(title)}&description=${encodeURIComponent(description)}&locale=${locale}&page=default`,
          width: 1200,
          height: 630,
          alt: isArabic ? 'سياسة الاسترداد - بروجينيوس' : 'Refund Policy - Pro Gineous',
        },
      ],
    },
    twitter: {
      card: 'summary_large_image',
      title: isArabic ? 'سياسة الاسترداد | بروجينيوس' : 'Refund Policy | Pro Gineous',
      images: [`/api/og?title=${encodeURIComponent(title)}&description=${encodeURIComponent(description)}&locale=${locale}&page=default`],
    },
    alternates: {
      canonical: `${baseUrl}/${locale}/refund`,
      languages: {
        en: `${baseUrl}/en/refund`,
        ar: `${baseUrl}/ar/refund`,
      },
    },
    robots: {
      index: true,
      follow: true,
    },
  };
}

export default function RefundLayout({ children }: { children: React.ReactNode }) {
  return <>{children}</>;
}
