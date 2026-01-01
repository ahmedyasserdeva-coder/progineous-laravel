import type { Metadata } from 'next';

type Props = {
  params: Promise<{ locale: string }>;
};

export async function generateMetadata({ params }: Props): Promise<Metadata> {
  const { locale } = await params;
  const isArabic = locale === 'ar';
  const baseUrl = process.env.NEXT_PUBLIC_SITE_URL || 'https://progineous.com';

  const title = isArabic
    ? 'برنامج إحالة صديق | اربح حتى $100 لكل إحالة - بروجينيوس'
    : 'Refer a Friend Program | Earn Up to $100 Per Referral - Pro Gineous';
  const description = isArabic
    ? 'انضم لبرنامج إحالة صديق واربح حتى $100 لكل إحالة ناجحة. صديقك يحصل على $20 رصيد مجاناً. برنامج مكافآت مزدوج من بروجينيوس. متاح في مصر والسعودية والإمارات وأمريكا وكندا وأوروبا.'
    : 'Join our Refer a Friend program and earn up to $100 per successful referral. Your friend gets $20 credit free. Double rewards program from Pro Gineous. Available in USA, UK, Canada, Germany, France, Egypt, Saudi Arabia, UAE.';

  return {
    title,
    description,
    keywords: isArabic
      ? [
          'إحالة صديق',
          'برنامج إحالة',
          'مكافآت إحالة',
          'ربح مال',
          'رابط إحالة',
          'عمولة إحالة',
          'دعوة صديق',
          'مكافأة الصديق',
          'رصيد مجاني',
          'برنامج مكافآت',
          'ربح من الإنترنت',
          'بروجينيوس إحالة',
          'استضافة مكافآت',
          'فائدة مزدوجة',
          'تسويق بالإحالة',
          'referral مصر',
          'إحالة السعودية',
          'مكافآت الإمارات',
          'affiliate عربي',
          'ربح دولارات',
        ]
      : [
          'refer a friend',
          'referral program',
          'referral rewards',
          'earn money',
          'referral link',
          'referral commission',
          'invite friend',
          'friend reward',
          'free credit',
          'rewards program',
          'make money online',
          'pro gineous referral',
          'hosting rewards',
          'double benefit',
          'referral marketing',
          'referral program USA',
          'refer friend UK',
          'hosting referral Canada',
          'referral bonus Germany',
          'invite program France',
          'passive income hosting',
          'hosting affiliate',
          'customer referral',
          'referral earnings',
          'friend discount',
        ],
    openGraph: {
      title: isArabic
        ? 'برنامج إحالة صديق | بروجينيوس'
        : 'Refer a Friend Program | Pro Gineous',
      description: isArabic
        ? 'اربح حتى $100 لكل إحالة + صديقك يحصل على $20 رصيد'
        : 'Earn up to $100 per referral + your friend gets $20 credit',
      url: `${baseUrl}/${locale}/refer-friend`,
      siteName: 'Pro Gineous',
      locale: isArabic ? 'ar_EG' : 'en_US',
      type: 'website',
      images: [
        {
          url: `/api/og?title=${encodeURIComponent(title)}&description=${encodeURIComponent(description)}&locale=${locale}&page=default`,
          width: 1200,
          height: 630,
          alt: isArabic ? 'إحالة صديق - بروجينيوس' : 'Refer a Friend - Pro Gineous',
        },
      ],
    },
    twitter: {
      card: 'summary_large_image',
      title: isArabic
        ? 'إحالة صديق | بروجينيوس'
        : 'Refer a Friend | Pro Gineous',
      description: isArabic
        ? 'اربح أنت وصديقك معاً!'
        : 'You and your friend both earn!',
      images: [`/api/og?title=${encodeURIComponent(title)}&description=${encodeURIComponent(description)}&locale=${locale}&page=default`],
    },
    alternates: {
      canonical: `${baseUrl}/${locale}/refer-friend`,
      languages: {
        'en': `${baseUrl}/en/refer-friend`,
        'ar': `${baseUrl}/ar/refer-friend`,
        'en-US': `${baseUrl}/en/refer-friend`,
        'en-GB': `${baseUrl}/en/refer-friend`,
        'en-CA': `${baseUrl}/en/refer-friend`,
        'en-AU': `${baseUrl}/en/refer-friend`,
        'de-DE': `${baseUrl}/en/refer-friend`,
        'fr-FR': `${baseUrl}/en/refer-friend`,
        'ar-EG': `${baseUrl}/ar/refer-friend`,
        'ar-SA': `${baseUrl}/ar/refer-friend`,
        'ar-AE': `${baseUrl}/ar/refer-friend`,
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

export default async function ReferFriendLayout({
  children,
  params,
}: {
  children: React.ReactNode;
  params: Promise<{ locale: string }>;
}) {
  const { locale } = await params;
  const isArabic = locale === 'ar';
  const baseUrl = process.env.NEXT_PUBLIC_SITE_URL || 'https://progineous.com';

  const referralSchema = {
    '@context': 'https://schema.org',
    '@type': 'Service',
    name: isArabic ? 'برنامج إحالة صديق' : 'Refer a Friend Program',
    description: isArabic
      ? 'اربح حتى $100 لكل إحالة ناجحة وصديقك يحصل على $20 رصيد مجاني'
      : 'Earn up to $100 per successful referral and your friend gets $20 free credit',
    provider: {
      '@type': 'Organization',
      name: 'Pro Gineous',
      url: baseUrl,
    },
    serviceType: 'Referral Program',
    areaServed: [
      { '@type': 'Country', name: 'United States' },
      { '@type': 'Country', name: 'United Kingdom' },
      { '@type': 'Country', name: 'Canada' },
      { '@type': 'Country', name: 'Germany' },
      { '@type': 'Country', name: 'France' },
      { '@type': 'Country', name: 'Egypt' },
      { '@type': 'Country', name: 'Saudi Arabia' },
      { '@type': 'Country', name: 'United Arab Emirates' },
    ],
    offers: {
      '@type': 'Offer',
      price: '0',
      priceCurrency: 'USD',
      availability: 'https://schema.org/InStock',
      description: isArabic
        ? 'اربح حتى $100 عمولة + $20 رصيد لصديقك'
        : 'Earn up to $100 commission + $20 credit for your friend',
    },
  };

  const faqSchema = {
    '@context': 'https://schema.org',
    '@type': 'FAQPage',
    mainEntity: [
      {
        '@type': 'Question',
        name: isArabic ? 'كم يمكنني أن أربح من كل إحالة؟' : 'How much can I earn per referral?',
        acceptedAnswer: {
          '@type': 'Answer',
          text: isArabic
            ? 'يمكنك ربح حتى $100 لكل إحالة ناجحة حسب قيمة اشتراك صديقك.'
            : 'You can earn up to $100 per successful referral depending on your friend\'s subscription value.',
        },
      },
      {
        '@type': 'Question',
        name: isArabic ? 'ماذا يحصل صديقي؟' : 'What does my friend get?',
        acceptedAnswer: {
          '@type': 'Answer',
          text: isArabic
            ? 'صديقك يحصل على $20 رصيد مجاني عند التسجيل باستخدام رابط الإحالة الخاص بك.'
            : 'Your friend gets $20 free credit when they sign up using your referral link.',
        },
      },
      {
        '@type': 'Question',
        name: isArabic ? 'هل هناك حد لعدد الإحالات؟' : 'Is there a limit to referrals?',
        acceptedAnswer: {
          '@type': 'Answer',
          text: isArabic
            ? 'لا، يمكنك إحالة عدد غير محدود من الأصدقاء وكسب مكافآت على كل إحالة ناجحة.'
            : 'No, you can refer unlimited friends and earn rewards on every successful referral.',
        },
      },
    ],
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
        name: isArabic ? 'إحالة صديق' : 'Refer a Friend',
        item: `${baseUrl}/${locale}/refer-friend`,
      },
    ],
  };

  return (
    <>
      <script
        type="application/ld+json"
        dangerouslySetInnerHTML={{ __html: JSON.stringify(referralSchema) }}
      />
      <script
        type="application/ld+json"
        dangerouslySetInnerHTML={{ __html: JSON.stringify(faqSchema) }}
      />
      <script
        type="application/ld+json"
        dangerouslySetInnerHTML={{ __html: JSON.stringify(breadcrumbSchema) }}
      />
      {children}
    </>
  );
}
