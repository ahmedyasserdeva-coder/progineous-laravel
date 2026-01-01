import type { Metadata } from 'next';
import Script from 'next/script';

type Props = {
  params: Promise<{ locale: string }>;
  children: React.ReactNode;
};

export async function generateMetadata({ params }: Props): Promise<Metadata> {
  const { locale } = await params;
  const isArabic = locale === 'ar';

  const title = isArabic 
    ? 'مقارنة شركات الاستضافة 2026 - Pro Gineous vs المنافسين | أسعار حقيقية'
    : 'Web Hosting Comparison 2026 - Pro Gineous vs Competitors | Real Prices';

  const description = isArabic
    ? 'قارن بين Pro Gineous وأفضل شركات الاستضافة (Hostinger, GoDaddy, Namecheap, Bluehost, SiteGround) بأسعار 2026 الحقيقية. مقارنة شاملة للسعر والمساحة وعدد المواقع والدعم الفني العربي.'
    : 'Compare Pro Gineous with top hosting companies (Hostinger, GoDaddy, Namecheap, Bluehost, SiteGround) with real 2026 prices. Complete comparison of price, storage, websites, and Arabic support.';

  const keywordsAr = [
    // مقارنة عامة
    'مقارنة شركات الاستضافة',
    'مقارنة شركات الاستضافة 2026',
    'افضل استضافة 2026',
    'افضل شركة استضافة',
    'مقارنة اسعار الاستضافة',
    'ارخص استضافة',
    'استضافة رخيصة',
    // Pro Gineous vs المنافسين
    'Pro Gineous vs Hostinger',
    'Pro Gineous vs GoDaddy',
    'Pro Gineous vs Namecheap',
    'Pro Gineous vs Bluehost',
    'Pro Gineous vs SiteGround',
    'Pro Gineous vs HostGator',
    'برو جينيوس مقابل هوستينجر',
    'برو جينيوس مقابل جودادي',
    // بدائل
    'بديل Hostinger',
    'بديل GoDaddy',
    'بديل Bluehost',
    'بديل SiteGround',
    'بديل هوستينجر',
    'بديل جودادي',
    'بديل بلوهوست',
    // عيوب المنافسين
    'عيوب Hostinger',
    'عيوب GoDaddy',
    'عيوب Bluehost',
    'عيوب SiteGround',
    'عيوب هوستينجر',
    'مشاكل جودادي',
    // استهداف جغرافي
    'استضافة عربية',
    'استضافة سعودية',
    'استضافة مصرية',
    'استضافة اماراتية',
    'استضافة كويتية',
    'استضافة قطرية',
    'استضافة اردنية',
    'افضل استضافة عربية',
    'استضافة بدعم عربي',
    // أسئلة شائعة
    'هل Hostinger جيد',
    'هل GoDaddy جيد',
    'ايهما افضل Hostinger او GoDaddy',
    'ارخص من Hostinger',
    'ارخص من GoDaddy',
    'افضل من Hostinger',
    'افضل من GoDaddy',
  ];

  const keywordsEn = [
    // General comparison
    'hosting comparison',
    'hosting comparison 2026',
    'best hosting 2026',
    'best web hosting company',
    'hosting price comparison',
    'cheapest hosting',
    'cheap web hosting',
    'affordable hosting',
    // Pro Gineous vs competitors
    'Pro Gineous vs Hostinger',
    'Pro Gineous vs GoDaddy',
    'Pro Gineous vs Namecheap',
    'Pro Gineous vs Bluehost',
    'Pro Gineous vs SiteGround',
    'Pro Gineous vs HostGator',
    // Alternatives
    'Hostinger alternative',
    'GoDaddy alternative',
    'Bluehost alternative',
    'SiteGround alternative',
    'HostGator alternative',
    'Namecheap alternative',
    'best Hostinger alternative',
    'best GoDaddy alternative',
    // Competitor issues
    'Hostinger problems',
    'GoDaddy problems',
    'Bluehost problems',
    'Hostinger cons',
    'GoDaddy cons',
    'is Hostinger good',
    'is GoDaddy good',
    'is Bluehost good',
    // Regional targeting
    'middle east hosting',
    'arabic support hosting',
    'best value hosting',
    'Egypt hosting',
    'Saudi Arabia hosting',
    'UAE hosting',
    'Arab hosting',
    // FAQ keywords
    'which is better Hostinger or GoDaddy',
    'cheaper than Hostinger',
    'cheaper than GoDaddy',
    'better than Hostinger',
    'better than GoDaddy',
    'Hostinger vs GoDaddy vs Pro Gineous',
  ];

  return {
    title,
    description,
    keywords: isArabic ? keywordsAr : keywordsEn,
    openGraph: {
      type: 'website',
      locale: isArabic ? 'ar_SA' : 'en_US',
      url: isArabic ? 'https://progineous.com/ar/compare' : 'https://progineous.com/en/compare',
      title,
      description,
      siteName: 'Pro Gineous',
      images: [
        {
          url: `/api/og?title=${encodeURIComponent(title)}&description=${encodeURIComponent(description)}&locale=${locale}&page=compare`,
          width: 1200,
          height: 630,
          alt: isArabic ? 'مقارنة شركات الاستضافة' : 'Hosting Comparison'
        }
      ]
    },
    twitter: {
      card: 'summary_large_image',
      title,
      description,
      images: [`/api/og?title=${encodeURIComponent(title)}&description=${encodeURIComponent(description)}&locale=${locale}&page=compare`],
    },
    alternates: {
      canonical: isArabic ? 'https://progineous.com/ar/compare' : 'https://progineous.com/en/compare',
      languages: {
        'ar-SA': 'https://progineous.com/ar/compare',
        'en-US': 'https://progineous.com/en/compare',
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

export default async function CompareLayout({ children, params }: Props) {
  const { locale } = await params;
  const isArabic = locale === 'ar';

  // ItemList Schema for comparison page
  const comparisonSchema = {
    '@context': 'https://schema.org',
    '@type': 'ItemList',
    name: isArabic ? 'مقارنة شركات الاستضافة 2026' : 'Web Hosting Comparison 2026',
    description: isArabic 
      ? 'مقارنة شاملة بين أفضل شركات الاستضافة في العالم'
      : 'Comprehensive comparison of top web hosting companies',
    numberOfItems: 6,
    itemListElement: [
      {
        '@type': 'ListItem',
        position: 1,
        item: {
          '@type': 'Product',
          name: 'Pro Gineous',
          description: isArabic ? 'استضافة عربية مع دعم فني محلي' : 'Arabic hosting with local support',
          offers: { '@type': 'Offer', price: '2.00', priceCurrency: 'USD' },
          aggregateRating: { '@type': 'AggregateRating', ratingValue: '4.9', reviewCount: '2847' }
        }
      },
      {
        '@type': 'ListItem',
        position: 2,
        item: {
          '@type': 'Product',
          name: 'Hostinger',
          offers: { '@type': 'Offer', price: '1.99', priceCurrency: 'USD' }
        }
      },
      {
        '@type': 'ListItem',
        position: 3,
        item: {
          '@type': 'Product',
          name: 'GoDaddy',
          offers: { '@type': 'Offer', price: '5.99', priceCurrency: 'USD' }
        }
      },
      {
        '@type': 'ListItem',
        position: 4,
        item: {
          '@type': 'Product',
          name: 'Namecheap',
          offers: { '@type': 'Offer', price: '1.98', priceCurrency: 'USD' }
        }
      },
      {
        '@type': 'ListItem',
        position: 5,
        item: {
          '@type': 'Product',
          name: 'Bluehost',
          offers: { '@type': 'Offer', price: '3.99', priceCurrency: 'USD' }
        }
      },
      {
        '@type': 'ListItem',
        position: 6,
        item: {
          '@type': 'Product',
          name: 'SiteGround',
          offers: { '@type': 'Offer', price: '2.99', priceCurrency: 'USD' }
        }
      }
    ]
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
        name: isArabic ? 'مقارنة الاستضافة' : 'Hosting Comparison',
        item: `https://progineous.com/${locale}/compare`,
      },
    ],
  };

  // FAQ Schema
  const faqSchema = {
    '@context': 'https://schema.org',
    '@type': 'FAQPage',
    mainEntity: [
      {
        '@type': 'Question',
        name: isArabic ? 'ما الفرق بين Pro Gineous و Hostinger؟' : 'What is the difference between Pro Gineous and Hostinger?',
        acceptedAnswer: {
          '@type': 'Answer',
          text: isArabic
            ? 'Pro Gineous توفر مساحة تخزين 70GB مقابل 20GB في Hostinger، و150 موقع مقابل 3 مواقع فقط، بالإضافة لدعم فني عربي على مدار الساعة وسيرفرات أقرب للشرق الأوسط.'
            : 'Pro Gineous offers 70GB storage vs 20GB on Hostinger, 150 websites vs only 3 websites, plus 24/7 Arabic support and servers closer to the Middle East.',
        },
      },
      {
        '@type': 'Question',
        name: isArabic ? 'هل Pro Gineous أرخص من المنافسين؟' : 'Is Pro Gineous cheaper than competitors?',
        acceptedAnswer: {
          '@type': 'Answer',
          text: isArabic
            ? 'نعم، بسعر $2/شهر تحصل على 70GB تخزين و150 موقع، بينما المنافسين يقدمون 10-25GB و1-10 مواقع بنفس السعر أو أعلى. أسعار التجديد لدينا أيضاً أقل بـ44% من SiteGround.'
            : 'Yes, at $2/month you get 70GB storage and 150 websites, while competitors offer 10-25GB and 1-10 websites at similar or higher prices. Our renewal prices are also 44% lower than SiteGround.',
        },
      },
      {
        '@type': 'Question',
        name: isArabic ? 'لماذا أختار Pro Gineous؟' : 'Why should I choose Pro Gineous?',
        acceptedAnswer: {
          '@type': 'Answer',
          text: isArabic
            ? 'لأنها الشركة الوحيدة التي توفر: دعم فني عربي حقيقي 24/7، سيرفرات في مصر للسرعة، مساحة ومواقع أكبر بنفس السعر، وأسعار تجديد منخفضة.'
            : 'Because it\'s the only company offering: real 24/7 Arabic support, Egypt servers for speed, more storage and websites at the same price, and low renewal rates.',
        },
      },
    ],
  };

  return (
    <>
      <Script
        id="comparison-list-schema"
        type="application/ld+json"
        dangerouslySetInnerHTML={{ __html: JSON.stringify(comparisonSchema) }}
      />
      <Script
        id="comparison-breadcrumb-schema"
        type="application/ld+json"
        dangerouslySetInnerHTML={{ __html: JSON.stringify(breadcrumbSchema) }}
      />
      <Script
        id="comparison-faq-schema"
        type="application/ld+json"
        dangerouslySetInnerHTML={{ __html: JSON.stringify(faqSchema) }}
      />
      {children}
    </>
  );
}
