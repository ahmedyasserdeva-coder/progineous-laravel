import type { Metadata } from 'next';

type Props = {
  params: Promise<{ locale: string; competitor: string }>;
  children: React.ReactNode;
};

const competitorData: Record<string, { name: string; nameAr: string }> = {
  hostinger: { name: 'Hostinger', nameAr: 'هوستينجر' },
  godaddy: { name: 'GoDaddy', nameAr: 'جودادي' },
  namecheap: { name: 'Namecheap', nameAr: 'نيم شيب' },
  hostgator: { name: 'HostGator', nameAr: 'هوست جيتور' },
  bluehost: { name: 'Bluehost', nameAr: 'بلوهوست' },
  siteground: { name: 'SiteGround', nameAr: 'سايت جراوند' },
};

export async function generateMetadata({ params }: Props): Promise<Metadata> {
  const { locale, competitor } = await params;
  const isArabic = locale === 'ar';
  const comp = competitorData[competitor] || { name: competitor, nameAr: competitor };

  const title = isArabic 
    ? `Pro Gineous vs ${comp.nameAr} - مقارنة شاملة 2026 | أيهما أفضل؟`
    : `Pro Gineous vs ${comp.name} - Complete Comparison 2026 | Which is Better?`;

  const description = isArabic
    ? `مقارنة تفصيلية بين Pro Gineous و ${comp.nameAr}. اكتشف الأسعار، المميزات، الأداء، والدعم الفني. أيهما أفضل لموقعك في ${new Date().getFullYear()}؟`
    : `Detailed comparison between Pro Gineous and ${comp.name}. Discover pricing, features, performance, and support. Which is better for your website in ${new Date().getFullYear()}?`;

  const keywords = isArabic ? [
    // مقارنة مباشرة
    `${comp.nameAr} vs Pro Gineous`,
    `Pro Gineous vs ${comp.nameAr}`,
    `${comp.nameAr} مقابل برو جينيوس`,
    `مقارنة ${comp.nameAr} و Pro Gineous`,
    `مقارنة ${comp.nameAr}`,
    `مراجعة ${comp.nameAr}`,
    `تقييم ${comp.nameAr}`,
    // بدائل
    `بديل ${comp.nameAr}`,
    `بديل ${comp.name}`,
    `أفضل بديل لـ ${comp.nameAr}`,
    `افضل من ${comp.nameAr}`,
    `أرخص من ${comp.nameAr}`,
    // تقييم المنافس
    `هل ${comp.nameAr} جيد`,
    `هل ${comp.nameAr} موثوق`,
    `عيوب ${comp.nameAr}`,
    `مشاكل ${comp.nameAr}`,
    `سلبيات ${comp.nameAr}`,
    `تجربتي مع ${comp.nameAr}`,
    `اراء عن ${comp.nameAr}`,
    `${comp.nameAr} 2026`,
    // استهداف عام
    'أفضل استضافة 2026',
    'استضافة رخيصة',
    'استضافة عربية',
    'استضافة بدعم عربي',
    'أفضل شركة استضافة',
    'مقارنة شركات الاستضافة'
  ] : [
    // Direct comparison
    `${comp.name} vs Pro Gineous`,
    `Pro Gineous vs ${comp.name}`,
    `${comp.name} comparison`,
    `${comp.name} vs Pro Gineous comparison`,
    `compare ${comp.name} and Pro Gineous`,
    `${comp.name} review`,
    `${comp.name} review 2026`,
    // Alternatives
    `${comp.name} alternative`,
    `${comp.name} alternative 2026`,
    `best ${comp.name} alternative`,
    `better than ${comp.name}`,
    `cheaper than ${comp.name}`,
    // Competitor evaluation
    `is ${comp.name} good`,
    `is ${comp.name} reliable`,
    `${comp.name} pros and cons`,
    `${comp.name} problems`,
    `${comp.name} issues`,
    `${comp.name} complaints`,
    `should I use ${comp.name}`,
    `${comp.name} honest review`,
    // General targeting
    'best hosting 2026',
    'cheap hosting',
    'web hosting comparison',
    'best web hosting',
    'affordable web hosting',
    'hosting with Arabic support'
  ];

  return {
    title,
    description,
    keywords,
    openGraph: {
      type: 'article',
      locale: isArabic ? 'ar_SA' : 'en_US',
      url: `https://progineous.com/${locale}/compare/${competitor}`,
      title,
      description,
      siteName: 'Pro Gineous',
      images: [
        {
          url: `/api/og?title=${encodeURIComponent(title)}&description=${encodeURIComponent(description)}&locale=${locale}&page=compare`,
          width: 1200,
          height: 630,
          alt: title
        }
      ]
    },
    twitter: {
      card: 'summary_large_image',
      title,
      description,
    },
    alternates: {
      canonical: `https://progineous.com/${locale}/compare/${competitor}`,
      languages: {
        'ar-SA': `https://progineous.com/ar/compare/${competitor}`,
        'en-US': `https://progineous.com/en/compare/${competitor}`,
      }
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

export function generateStaticParams() {
  return Object.keys(competitorData).map((competitor) => ({
    competitor,
  }));
}

export default function CompetitorCompareLayout({ children }: { children: React.ReactNode }) {
  return children;
}
