'use client';

import { useLocale } from 'next-intl';
import { useParams } from 'next/navigation';
import { Link } from '@/i18n/routing';
import { 
  CheckCircle, 
  XCircle, 
  Star,
  ArrowRight,
  Shield,
  Headphones,
  Zap,
  Globe,
  DollarSign,
  Server,
  Clock,
  Award
} from 'lucide-react';
import { cn } from '@/lib/utils';

const competitorData: Record<string, {
  name: string;
  nameAr: string;
  logo: string;
  founded: string;
  headquarters: string;
  headquartersAr: string;
  monthlyPrice: string;
  renewalPrice: string;
  arabicSupport: boolean;
  freeSSL: boolean;
  freeMigration: boolean;
  uptime: string;
  serverLocations: string;
  serverLocationsAr: string;
  rating: number;
  storage: string;
  websites: string;
  bandwidth: string;
}> = {
  hostinger: {
    name: 'Hostinger',
    nameAr: 'هوستينجر',
    logo: '/images/competitors/Hostinger_logo_purple.svg.png',
    founded: '2004',
    headquarters: 'Lithuania',
    headquartersAr: 'ليتوانيا',
    monthlyPrice: '$1.99',
    renewalPrice: '$10.99',
    arabicSupport: false,
    freeSSL: true,
    freeMigration: true,
    uptime: '99.9%',
    serverLocations: 'USA, UK, Netherlands, Singapore, Brazil, India, Indonesia',
    serverLocationsAr: 'أمريكا، بريطانيا، هولندا، سنغافورة، البرازيل، الهند، إندونيسيا',
    rating: 4.5,
    storage: '20 GB SSD',
    websites: '3 Websites',
    bandwidth: 'Unmetered'
  },
  godaddy: {
    name: 'GoDaddy',
    nameAr: 'جودادي',
    logo: '/images/competitors/GD_LOCKUP_RGB_BLACK.png',
    founded: '1997',
    headquarters: 'Arizona, USA',
    headquartersAr: 'أريزونا، أمريكا',
    monthlyPrice: '$5.99',
    renewalPrice: '$11.99',
    arabicSupport: false,
    freeSSL: false,
    freeMigration: false,
    uptime: '99.9%',
    serverLocations: 'USA, Europe, Asia Pacific',
    serverLocationsAr: 'أمريكا، أوروبا، آسيا والمحيط الهادئ',
    rating: 3.8,
    storage: '25 GB SSD',
    websites: '1 Website',
    bandwidth: 'Unmetered'
  },
  namecheap: {
    name: 'Namecheap',
    nameAr: 'نيم شيب',
    logo: '/images/competitors/Namecheap_Logo.svg.png',
    founded: '2000',
    headquarters: 'Arizona, USA',
    headquartersAr: 'أريزونا، أمريكا',
    monthlyPrice: '$1.98',
    renewalPrice: '$4.88',
    arabicSupport: false,
    freeSSL: true,
    freeMigration: true,
    uptime: '100%',
    serverLocations: 'USA, UK, EU, Singapore',
    serverLocationsAr: 'أمريكا، بريطانيا، أوروبا، سنغافورة',
    rating: 4.7,
    storage: '20 GB SSD',
    websites: '3 Websites',
    bandwidth: 'Unmetered'
  },
  hostgator: {
    name: 'HostGator',
    nameAr: 'هوست جيتور',
    logo: '/images/competitors/Hostgator-logo.png',
    founded: '2002',
    headquarters: 'Texas, USA',
    headquartersAr: 'تكساس، أمريكا',
    monthlyPrice: '$3.75',
    renewalPrice: '$9.99',
    arabicSupport: false,
    freeSSL: true,
    freeMigration: true,
    uptime: '99.9%',
    serverLocations: 'USA',
    serverLocationsAr: 'أمريكا',
    rating: 4.0,
    storage: 'Unmetered SSD',
    websites: '1 Website',
    bandwidth: 'Unmetered'
  },
  bluehost: {
    name: 'Bluehost',
    nameAr: 'بلوهوست',
    logo: '/images/competitors/Bluehost_logo.svg.png',
    founded: '2003',
    headquarters: 'Utah, USA',
    headquartersAr: 'يوتا، أمريكا',
    monthlyPrice: '$3.99',
    renewalPrice: '$9.99',
    arabicSupport: false,
    freeSSL: true,
    freeMigration: true,
    uptime: '99.99%',
    serverLocations: 'USA, India',
    serverLocationsAr: 'أمريكا، الهند',
    rating: 4.1,
    storage: '10 GB NVMe',
    websites: '10 Websites',
    bandwidth: 'Unmetered'
  },
  siteground: {
    name: 'SiteGround',
    nameAr: 'سايت جراوند',
    logo: '/images/competitors/SiteGround.Com_Inc._Logo.png',
    founded: '2004',
    headquarters: 'Bulgaria',
    headquartersAr: 'بلغاريا',
    monthlyPrice: '$2.99',
    renewalPrice: '$17.99',
    arabicSupport: false,
    freeSSL: true,
    freeMigration: true,
    uptime: '99.99%',
    serverLocations: 'USA, UK, Netherlands, Germany, Singapore, Australia',
    serverLocationsAr: 'أمريكا، بريطانيا، هولندا، ألمانيا، سنغافورة، أستراليا',
    rating: 4.9,
    storage: '10 GB SSD',
    websites: '1 Website',
    bandwidth: 'Unmetered'
  }
};

const proGineousData = {
  name: 'Pro Gineous',
  nameAr: 'برو جينيوس',
  logo: '/pro Gineous_logo.svg',
  founded: '2020',
  headquarters: 'Egypt',
  headquartersAr: 'مصر',
  monthlyPrice: '$2.00',
  renewalPrice: '$10.00',
  arabicSupport: true,
  freeSSL: true,
  freeMigration: true,
  uptime: '99.9%',
  serverLocations: 'Egypt, Netherlands, USA, Germany',
  serverLocationsAr: 'مصر، هولندا، أمريكا، ألمانيا',
  rating: 4.9,
  storage: '70 GB SSD',
  websites: '150 Websites',
  bandwidth: 'Unlimited'
};

export default function CompetitorComparePage() {
  const locale = useLocale();
  const params = useParams();
  const competitor = params.competitor as string;
  const isArabic = locale === 'ar';
  
  const comp = competitorData[competitor];
  
  if (!comp) {
    return (
      <div className="min-h-screen flex items-center justify-center">
        <p className="text-xl text-gray-600">
          {isArabic ? 'الصفحة غير موجودة' : 'Page not found'}
        </p>
      </div>
    );
  }

  const comparisonItems = [
    {
      feature: isArabic ? 'السعر الشهري (بداية)' : 'Monthly Price (Starting)',
      progineous: proGineousData.monthlyPrice,
      competitor: comp.monthlyPrice,
      winner: parseFloat(proGineousData.monthlyPrice.replace('$', '')) <= parseFloat(comp.monthlyPrice.replace('$', '')) ? 'progineous' : 'competitor'
    },
    {
      feature: isArabic ? 'سعر التجديد' : 'Renewal Price',
      progineous: proGineousData.renewalPrice,
      competitor: comp.renewalPrice,
      winner: parseFloat(proGineousData.renewalPrice.replace('$', '')) <= parseFloat(comp.renewalPrice.replace('$', '')) ? 'progineous' : 'competitor'
    },
    {
      feature: isArabic ? 'مساحة التخزين' : 'Storage',
      progineous: proGineousData.storage,
      competitor: comp.storage,
      winner: 'progineous' // Pro Gineous has more storage
    },
    {
      feature: isArabic ? 'عدد المواقع' : 'Websites',
      progineous: proGineousData.websites,
      competitor: comp.websites,
      winner: 'progineous' // Pro Gineous allows more websites
    },
    {
      feature: isArabic ? 'النطاق الترددي' : 'Bandwidth',
      progineous: proGineousData.bandwidth,
      competitor: comp.bandwidth,
      winner: 'tie'
    },
    {
      feature: isArabic ? 'دعم فني عربي' : 'Arabic Support',
      progineous: proGineousData.arabicSupport,
      competitor: comp.arabicSupport,
      winner: proGineousData.arabicSupport && !comp.arabicSupport ? 'progineous' : (comp.arabicSupport ? 'tie' : 'progineous')
    },
    {
      feature: isArabic ? 'SSL مجاني' : 'Free SSL',
      progineous: proGineousData.freeSSL,
      competitor: comp.freeSSL,
      winner: proGineousData.freeSSL && comp.freeSSL ? 'tie' : (proGineousData.freeSSL ? 'progineous' : 'competitor')
    },
    {
      feature: isArabic ? 'نقل مجاني' : 'Free Migration',
      progineous: proGineousData.freeMigration,
      competitor: comp.freeMigration,
      winner: proGineousData.freeMigration && comp.freeMigration ? 'tie' : (proGineousData.freeMigration ? 'progineous' : 'competitor')
    },
    {
      feature: isArabic ? 'ضمان التشغيل' : 'Uptime Guarantee',
      progineous: proGineousData.uptime,
      competitor: comp.uptime,
      winner: 'tie'
    },
    {
      feature: isArabic ? 'تقييم العملاء' : 'Customer Rating',
      progineous: `${proGineousData.rating}/5`,
      competitor: `${comp.rating}/5`,
      winner: proGineousData.rating >= comp.rating ? 'progineous' : 'competitor'
    }
  ];

  const renderValue = (value: boolean | string) => {
    if (typeof value === 'boolean') {
      return value ? (
        <CheckCircle className="w-6 h-6 text-green-500" />
      ) : (
        <XCircle className="w-6 h-6 text-red-500" />
      );
    }
    return <span className="font-semibold">{value}</span>;
  };

  const content = {
    vs: 'vs',
    winner: isArabic ? 'الفائز' : 'Winner',
    getStarted: isArabic ? 'ابدأ مع Pro Gineous' : 'Get Started with Pro Gineous',
    savings: isArabic ? 'وفر حتى 50% مقارنة بـ' : 'Save up to 50% compared to',
    conclusion: {
      title: isArabic ? 'الخلاصة: أيهما أفضل؟' : 'Conclusion: Which is Better?',
      text: isArabic
        ? `بناءً على المقارنة، Pro Gineous تقدم قيمة أفضل للعملاء العرب بفضل الأسعار التنافسية والدعم الفني باللغة العربية. بينما ${comp.nameAr} شركة معروفة عالمياً، إلا أن Pro Gineous تركز على خدمة السوق العربي بشكل أفضل.`
        : `Based on the comparison, Pro Gineous offers better value for Arab customers thanks to competitive pricing and Arabic technical support. While ${comp.name} is a globally known company, Pro Gineous focuses on serving the Arab market better.`
    }
  };

  // Calculate Pro Gineous wins
  const proGineousWins = comparisonItems.filter(item => item.winner === 'progineous').length;
  const competitorWins = comparisonItems.filter(item => item.winner === 'competitor').length;

  return (
    <div className="min-h-screen bg-gray-50">
      {/* Hero */}
      <section className="pt-32 pb-16 px-4 bg-white">
        <div className="max-w-6xl mx-auto text-center">
          <div className="flex items-center justify-center gap-8 md:gap-12 mb-8">
            <div className="text-center">
              <div className="h-16 mb-4 flex items-center justify-center">
                <img 
                  src={proGineousData.logo} 
                  alt="Pro Gineous"
                  className="h-12 max-w-[150px] object-contain"
                />
              </div>
              <h2 className="text-xl md:text-2xl font-bold text-gray-900">Pro Gineous</h2>
            </div>
            <span className="text-3xl md:text-4xl font-bold text-gray-400">{content.vs}</span>
            <div className="text-center">
              <div className="h-16 mb-4 flex items-center justify-center">
                <img 
                  src={comp.logo} 
                  alt={comp.name}
                  className="h-12 max-w-[150px] object-contain"
                />
              </div>
              <h2 className="text-xl md:text-2xl font-bold text-gray-900">{isArabic ? comp.nameAr : comp.name}</h2>
            </div>
          </div>
          
          <h1 className="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
            {isArabic 
              ? `مقارنة شاملة بين Pro Gineous و ${comp.nameAr} في 2026`
              : `Complete Comparison: Pro Gineous vs ${comp.name} in 2026`
            }
          </h1>
          
          {/* Score */}
          <div className="inline-flex items-center gap-4 bg-blue-50 px-6 py-3 rounded-full mt-6">
            <span className="text-blue-600 font-bold">{proGineousWins} {content.winner}</span>
            <span className="text-gray-400">-</span>
            <span className="text-gray-600">{competitorWins} {content.winner}</span>
          </div>
        </div>
      </section>

      {/* Comparison Table */}
      <section className="py-16 px-4">
        <div className="max-w-4xl mx-auto">
          <div className="bg-white rounded-2xl shadow-lg overflow-hidden">
            <div className="grid grid-cols-3 bg-gray-100 p-4 font-semibold text-gray-700">
              <div>{isArabic ? 'الميزة' : 'Feature'}</div>
              <div className="text-center text-blue-600">Pro Gineous</div>
              <div className="text-center">{isArabic ? comp.nameAr : comp.name}</div>
            </div>
            
            {comparisonItems.map((item, index) => (
              <div 
                key={index}
                className={cn(
                  "grid grid-cols-3 p-4 items-center",
                  index % 2 === 0 ? 'bg-white' : 'bg-gray-50',
                  item.winner === 'progineous' && 'border-l-4 border-blue-500'
                )}
              >
                <div className="text-gray-700">{item.feature}</div>
                <div className={cn(
                  "text-center flex justify-center",
                  item.winner === 'progineous' && 'text-blue-600'
                )}>
                  {renderValue(item.progineous)}
                </div>
                <div className={cn(
                  "text-center flex justify-center",
                  item.winner === 'competitor' && 'text-green-600'
                )}>
                  {renderValue(item.competitor)}
                </div>
              </div>
            ))}
          </div>

          {/* CTA */}
          <div className="mt-12 text-center">
            <p className="text-lg text-gray-600 mb-4">
              {content.savings} {isArabic ? comp.nameAr : comp.name}
            </p>
            <Link
              href="/hosting/shared"
              className="inline-flex items-center gap-2 px-8 py-4 bg-blue-600 text-white rounded-xl font-semibold hover:bg-blue-700 transition-colors"
            >
              {content.getStarted}
              <ArrowRight className="w-5 h-5" />
            </Link>
          </div>
        </div>
      </section>

      {/* SEO Content */}
      <section className="py-16 px-4 bg-white">
        <div className="max-w-4xl mx-auto prose prose-lg">
          <h2>{content.conclusion.title}</h2>
          <p>{content.conclusion.text}</p>
          
          {isArabic ? (
            <>
              <h3>لماذا يختار العملاء Pro Gineous بدلاً من {comp.nameAr}؟</h3>
              <ul>
                <li><strong>أسعار أقل:</strong> وفر حتى 50% من تكاليف الاستضافة السنوية</li>
                <li><strong>دعم عربي:</strong> تواصل بلغتك مع فريق الدعم الفني</li>
                <li><strong>سيرفرات قريبة:</strong> سرعة أفضل لزوار الشرق الأوسط</li>
                <li><strong>نقل مجاني:</strong> انتقل من {comp.nameAr} بدون أي تكلفة</li>
              </ul>
              
              <h3>هل {comp.nameAr} مناسب لموقعي؟</h3>
              <p>
                {comp.nameAr} خيار جيد للمواقع العالمية، لكن إذا كان جمهورك المستهدف في 
                مصر أو السعودية أو الإمارات أو أي دولة عربية، فإن Pro Gineous ستكون 
                الخيار الأفضل من حيث السرعة والدعم والأسعار.
              </p>

              <h3>كيف أنتقل من {comp.nameAr} إلى Pro Gineous؟</h3>
              <p>
                نقدم خدمة نقل مجانية كاملة. فقط اطلب استضافة جديدة وأرسل بيانات 
                حسابك القديم لفريق الدعم، وسنتولى كل شيء خلال 24 ساعة.
              </p>
            </>
          ) : (
            <>
              <h3>Why Customers Choose Pro Gineous Over {comp.name}?</h3>
              <ul>
                <li><strong>Lower prices:</strong> Save up to 50% on annual hosting costs</li>
                <li><strong>Arabic support:</strong> Communicate with support in your language</li>
                <li><strong>Closer servers:</strong> Better speed for Middle East visitors</li>
                <li><strong>Free migration:</strong> Move from {comp.name} at no cost</li>
              </ul>
              
              <h3>Is {comp.name} Right for My Website?</h3>
              <p>
                {comp.name} is a good choice for global websites, but if your target audience is in 
                Egypt, Saudi Arabia, UAE, or any Arab country, Pro Gineous will be the better choice 
                in terms of speed, support, and pricing.
              </p>

              <h3>How to Migrate from {comp.name} to Pro Gineous?</h3>
              <p>
                We offer a complete free migration service. Just order new hosting and send your 
                old account details to our support team, and we'll handle everything within 24 hours.
              </p>
            </>
          )}
        </div>
      </section>

      {/* JSON-LD Structured Data */}
      <script
        type="application/ld+json"
        dangerouslySetInnerHTML={{
          __html: JSON.stringify({
            '@context': 'https://schema.org',
            '@type': 'Article',
            headline: isArabic 
              ? `Pro Gineous vs ${comp.nameAr} - مقارنة شاملة 2026`
              : `Pro Gineous vs ${comp.name} - Complete Comparison 2026`,
            description: isArabic
              ? `مقارنة تفصيلية بين Pro Gineous و ${comp.nameAr}`
              : `Detailed comparison between Pro Gineous and ${comp.name}`,
            author: {
              '@type': 'Organization',
              name: 'Pro Gineous'
            },
            publisher: {
              '@type': 'Organization',
              name: 'Pro Gineous',
              logo: {
                '@type': 'ImageObject',
                url: 'https://progineous.com/images/logos/pro Gineous_white logo.svg'
              }
            },
            datePublished: '2026-01-01',
            dateModified: new Date().toISOString()
          })
        }}
      />

      {/* Comparison Schema */}
      <script
        type="application/ld+json"
        dangerouslySetInnerHTML={{
          __html: JSON.stringify({
            '@context': 'https://schema.org',
            '@type': 'Product',
            name: 'Pro Gineous Web Hosting',
            description: isArabic 
              ? 'استضافة مواقع احترافية مع دعم عربي'
              : 'Professional web hosting with Arabic support',
            brand: {
              '@type': 'Brand',
              name: 'Pro Gineous'
            },
            aggregateRating: {
              '@type': 'AggregateRating',
              ratingValue: proGineousData.rating,
              ratingCount: 2847,
              bestRating: 5,
              worstRating: 1
            },
            offers: {
              '@type': 'Offer',
              price: '2.00',
              priceCurrency: 'USD',
              priceValidUntil: '2026-12-31',
              availability: 'https://schema.org/InStock'
            }
          })
        }}
      />
    </div>
  );
}
