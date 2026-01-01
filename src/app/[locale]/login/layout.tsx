import type { Metadata } from 'next';

type Props = {
  params: Promise<{ locale: string }>;
};

export async function generateMetadata({ params }: Props): Promise<Metadata> {
  const { locale } = await params;
  const isArabic = locale === 'ar';
  const baseUrl = process.env.NEXT_PUBLIC_SITE_URL || 'https://progineous.com';

  const title = isArabic
    ? 'تسجيل الدخول | بروجينيوس - لوحة تحكم العملاء'
    : 'Login | Pro Gineous - Client Dashboard';
  const description = isArabic
    ? 'سجل دخولك إلى حسابك في بروجينيوس للوصول إلى لوحة التحكم وإدارة خدمات الاستضافة والنطاقات والفواتير.'
    : 'Sign in to your Pro Gineous account to access your dashboard and manage your hosting services, domains, and billing.';

  return {
    title,
    description,
    keywords: isArabic
      ? [
          'تسجيل الدخول',
          'لوحة تحكم العملاء',
          'حساب العميل',
          'إدارة الاستضافة',
          'لوحة التحكم',
          'تسجيل دخول آمن',
          'حساب بروجينيوس',
          'إدارة النطاقات',
          'الفواتير',
          'دعم العملاء',
          'WHMCS',
          'cPanel',
          'لوحة إدارة',
          'حساب الاستضافة',
          'دخول العميل',
        ]
      : [
          'login',
          'client dashboard',
          'customer account',
          'hosting management',
          'control panel',
          'secure login',
          'pro gineous account',
          'domain management',
          'billing',
          'customer support',
          'WHMCS',
          'cPanel',
          'admin panel',
          'hosting account',
          'client login',
        ],
    openGraph: {
      title: isArabic
        ? 'تسجيل الدخول | بروجينيوس'
        : 'Login | Pro Gineous',
      description: isArabic
        ? 'سجل دخولك للوصول إلى لوحة تحكم حسابك'
        : 'Sign in to access your account dashboard',
      url: `${baseUrl}/${locale}/login`,
      siteName: 'Pro Gineous',
      locale: isArabic ? 'ar_EG' : 'en_US',
      type: 'website',
      images: [
        {
          url: `/api/og?title=${encodeURIComponent(title)}&description=${encodeURIComponent(description)}&locale=${locale}&page=default`,
          width: 1200,
          height: 630,
          alt: isArabic ? 'تسجيل الدخول - بروجينيوس' : 'Login - Pro Gineous',
        },
      ],
    },
    twitter: {
      card: 'summary_large_image',
      title: isArabic ? 'تسجيل الدخول | بروجينيوس' : 'Login | Pro Gineous',
      images: [`/api/og?title=${encodeURIComponent(title)}&description=${encodeURIComponent(description)}&locale=${locale}&page=default`],
    },
    alternates: {
      canonical: `${baseUrl}/${locale}/login`,
      languages: {
        en: `${baseUrl}/en/login`,
        ar: `${baseUrl}/ar/login`,
      },
    },
    robots: {
      index: false,
      follow: true,
    },
  };
}

export default function LoginLayout({ children }: { children: React.ReactNode }) {
  return <>{children}</>;
}
