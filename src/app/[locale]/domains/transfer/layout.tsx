import type { Metadata } from 'next';

type Props = {
  params: Promise<{ locale: string }>;
};

export async function generateMetadata({ params }: Props): Promise<Metadata> {
  const { locale } = await params;
  const isArabic = locale === 'ar';
  
  const title = isArabic 
    ? 'نقل النطاق | انقل نطاقك إلى بروجينيوس واحصل على سنة مجانية'
    : 'Domain Transfer | Transfer Your Domain to Pro Gineous & Get Free Year';
  
  const description = isArabic
    ? 'انقل نطاقك إلى بروجينيوس واحصل على سنة إضافية مجاناً! استمتع بحماية WHOIS مجانية، دعم فني 24/7، نقل سريع خلال 5-7 أيام، وإدارة DNS متقدمة. أسعار تنافسية لأكثر من 500 امتداد نطاق.'
    : 'Transfer your domain to Pro Gineous and get a FREE year extension! Enjoy free WHOIS privacy, 24/7 expert support, fast 5-7 day transfer, and advanced DNS management. Competitive prices for 500+ domain extensions.';

  const keywords = isArabic
    ? [
        'نقل النطاق',
        'نقل الدومين',
        'تحويل النطاق',
        'نقل نطاق بسنة مجانية',
        'نقل نطاق كوم',
        'نقل نطاق نت',
        'نقل نطاق السعودية',
        'رمز التفويض EPP',
        'كود نقل النطاق',
        'أفضل شركة نقل نطاقات',
        'نقل نطاق رخيص',
        'نقل نطاق سريع',
        'حماية WHOIS',
        'حماية خصوصية النطاق',
        'نقل نطاق مع DNS مجاني',
        'بروجينيوس نقل نطاق',
        'تحويل دومين',
        'نقل نطاق عربي',
        'نقل نطاق org',
        'نقل نطاق io',
        'نقل نطاق من جودادي',
        'نقل نطاق من نيم شيب',
        'أسعار نقل النطاقات',
        'كيفية نقل النطاق',
        'خطوات نقل الدومين',
      ]
    : [
        'domain transfer',
        'transfer domain',
        'domain migration',
        'transfer domain free year',
        'transfer .com domain',
        'transfer .net domain',
        'transfer .org domain',
        'EPP authorization code',
        'domain auth code',
        'best domain transfer service',
        'cheap domain transfer',
        'fast domain transfer',
        'WHOIS privacy protection',
        'domain privacy',
        'transfer domain with free DNS',
        'Pro Gineous domain transfer',
        'move domain registrar',
        'switch domain provider',
        'transfer .io domain',
        'transfer .co domain',
        'transfer from GoDaddy',
        'transfer from Namecheap',
        'domain transfer pricing',
        'how to transfer domain',
        'domain transfer steps',
      ];

  const baseUrl = process.env.NEXT_PUBLIC_SITE_URL || 'https://progineous.com';
  const canonicalUrl = `${baseUrl}/${locale}/domains/transfer`;
  
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
        'en': `${baseUrl}/en/domains/transfer`,
        'ar': `${baseUrl}/ar/domains/transfer`,
      },
    },
    openGraph: {
      type: 'website',
      locale: isArabic ? 'ar_SA' : 'en_US',
      alternateLocale: isArabic ? 'en_US' : 'ar_SA',
      url: canonicalUrl,
      title,
      description,
      siteName: 'Pro Gineous',
      images: [
        {
          url: `/api/og?title=${encodeURIComponent(title)}&description=${encodeURIComponent(description)}&locale=${locale}&page=default`,
          width: 1200,
          height: 630,
          alt: isArabic ? 'نقل النطاق - بروجينيوس' : 'Domain Transfer - Pro Gineous',
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
    other: {
      'og:price:currency': 'USD',
      'product:availability': 'in stock',
    },
  };
}

export default function DomainTransferLayout({
  children,
}: {
  children: React.ReactNode;
}) {
  return <>{children}</>;
}
