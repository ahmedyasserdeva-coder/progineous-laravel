import { setRequestLocale } from 'next-intl/server';
import { HeroSection } from '@/components/home/HeroSection';
import { AllPlansMarquee } from '@/components/home/AllPlansMarquee';
import { FeaturesSection } from '@/components/home/FeaturesSection';
import { HostingSuccessSection } from '@/components/home/HostingSuccessSection';
import { BetterHostingSection } from '@/components/home/BetterHostingSection';
import { ExpertsSection } from '@/components/home/ExpertsSection';
import { BrandSection } from '@/components/home/BrandSection';
import { SupportSection } from '@/components/home/SupportSection';
import { FAQSection } from '@/components/home/FAQSection';
import { CTASection } from '@/components/home/CTASection';

type Props = {
  params: Promise<{ locale: string }>;
};

// JSON-LD Structured Data for SEO
function generateStructuredData(locale: string) {
  const isArabic = locale === 'ar';
  
  const organizationSchema = {
    '@context': 'https://schema.org',
    '@type': 'Organization',
    name: 'Pro Gineous',
    url: 'https://progineous.com',
    logo: 'https://progineous.com/pro Gineous_favico.svg',
    description: isArabic 
      ? 'برو جينيوس - أفضل خدمات استضافة المواقع والسيرفرات السحابية وتسجيل النطاقات'
      : 'Pro Gineous - Best web hosting, cloud servers and domain registration services',
    foundingDate: '2010',
    contactPoint: {
      '@type': 'ContactPoint',
      telephone: '+1-XXX-XXX-XXXX',
      contactType: 'customer service',
      availableLanguage: ['English', 'Arabic'],
      areaServed: 'Worldwide'
    },
    sameAs: [
      'https://twitter.com/progineous',
      'https://facebook.com/progineous',
      'https://linkedin.com/company/progineous'
    ]
  };

  const websiteSchema = {
    '@context': 'https://schema.org',
    '@type': 'WebSite',
    name: 'Pro Gineous',
    url: 'https://progineous.com',
    potentialAction: {
      '@type': 'SearchAction',
      target: 'https://progineous.com/search?q={search_term_string}',
      'query-input': 'required name=search_term_string'
    }
  };

  const servicesSchema = {
    '@context': 'https://schema.org',
    '@type': 'ItemList',
    name: isArabic ? 'خدمات الاستضافة' : 'Hosting Services',
    itemListElement: [
      {
        '@type': 'ListItem',
        position: 1,
        item: {
          '@type': 'Service',
          name: isArabic ? 'استضافة مشتركة' : 'Shared Hosting',
          description: isArabic ? 'استضافة مشتركة مثالية للمواقع الصغيرة والمدونات' : 'Shared hosting perfect for small websites and blogs',
          offers: {
            '@type': 'Offer',
            price: '2',
            priceCurrency: 'USD',
            priceValidUntil: '2026-12-31',
            availability: 'https://schema.org/InStock'
          }
        }
      },
      {
        '@type': 'ListItem',
        position: 2,
        item: {
          '@type': 'Service',
          name: isArabic ? 'استضافة سحابية' : 'Cloud Hosting',
          description: isArabic ? 'استضافة سحابية قابلة للتوسع مع أداء عالي' : 'Scalable cloud hosting with high performance',
          offers: {
            '@type': 'Offer',
            price: '4',
            priceCurrency: 'USD',
            priceValidUntil: '2026-12-31',
            availability: 'https://schema.org/InStock'
          }
        }
      },
      {
        '@type': 'ListItem',
        position: 3,
        item: {
          '@type': 'Service',
          name: isArabic ? 'سيرفرات VPS' : 'VPS Hosting',
          description: isArabic ? 'سيرفرات VPS مع تحكم كامل وأداء مضمون' : 'VPS servers with full control and guaranteed performance',
          offers: {
            '@type': 'Offer',
            price: '14.99',
            priceCurrency: 'USD',
            priceValidUntil: '2026-12-31',
            availability: 'https://schema.org/InStock'
          }
        }
      },
      {
        '@type': 'ListItem',
        position: 4,
        item: {
          '@type': 'Service',
          name: isArabic ? 'سيرفرات مخصصة' : 'Dedicated Servers',
          description: isArabic ? 'سيرفرات مخصصة بقوة وأداء غير محدود' : 'Dedicated servers with unlimited power and performance',
          offers: {
            '@type': 'Offer',
            price: '140',
            priceCurrency: 'USD',
            priceValidUntil: '2026-12-31',
            availability: 'https://schema.org/InStock'
          }
        }
      }
    ]
  };

  // BreadcrumbList Schema for better navigation in search results
  const breadcrumbSchema = {
    '@context': 'https://schema.org',
    '@type': 'BreadcrumbList',
    itemListElement: [
      {
        '@type': 'ListItem',
        position: 1,
        name: isArabic ? 'الرئيسية' : 'Home',
        item: `https://progineous.com/${locale}`
      }
    ]
  };

  // SoftwareApplication Schema for hosting control panel
  const softwareSchema = {
    '@context': 'https://schema.org',
    '@type': 'SoftwareApplication',
    name: 'Pro Gineous Hosting Panel',
    applicationCategory: 'WebApplication',
    operatingSystem: 'Web Browser',
    offers: {
      '@type': 'Offer',
      price: '0',
      priceCurrency: 'USD'
    },
    aggregateRating: {
      '@type': 'AggregateRating',
      ratingValue: '4.9',
      ratingCount: '2847',
      bestRating: '5',
      worstRating: '1'
    }
  };

  const faqSchema = {
    '@context': 'https://schema.org',
    '@type': 'FAQPage',
    mainEntity: isArabic ? [
      {
        '@type': 'Question',
        name: 'ما هي الاستضافة المشتركة؟',
        acceptedAnswer: {
          '@type': 'Answer',
          text: 'الاستضافة المشتركة هي نوع من استضافة الويب حيث يتشارك عدة مواقع في موارد خادم واحد. إنها خيار فعال من حيث التكلفة للمواقع الصغيرة والمتوسطة.'
        }
      },
      {
        '@type': 'Question',
        name: 'هل تقدمون شهادات SSL مجانية؟',
        acceptedAnswer: {
          '@type': 'Answer',
          text: 'نعم! جميع خططنا تتضمن شهادات SSL مجانية من Let\'s Encrypt لتأمين موقعك وحماية بيانات زوارك.'
        }
      },
      {
        '@type': 'Question',
        name: 'ما هو ضمان وقت التشغيل؟',
        acceptedAnswer: {
          '@type': 'Answer',
          text: 'نضمن وقت تشغيل بنسبة 99.9%. خوادمنا مراقبة على مدار الساعة ونستخدم أحدث التقنيات لضمان استمرارية عمل موقعك.'
        }
      },
      {
        '@type': 'Question',
        name: 'هل Pro Gineous أفضل من Hostinger؟',
        acceptedAnswer: {
          '@type': 'Answer',
          text: 'نعم، Pro Gineous تقدم أسعاراً أقل، دعماً فنياً باللغة العربية على مدار الساعة، وسيرفرات أقرب للشرق الأوسط مما يعني سرعة أفضل لزوار مواقعك.'
        }
      },
      {
        '@type': 'Question',
        name: 'كم سعر الاستضافة في مصر؟',
        acceptedAnswer: {
          '@type': 'Answer',
          text: 'تبدأ أسعار الاستضافة من $2 شهرياً فقط مع Pro Gineous. نقدم خطط استضافة مشتركة، سحابية، VPS، وسيرفرات مخصصة بأسعار تناسب السوق المصري والعربي.'
        }
      },
      {
        '@type': 'Question',
        name: 'ما أفضل استضافة لموقع ووردبريس؟',
        acceptedAnswer: {
          '@type': 'Answer',
          text: 'استضافتنا مُحسّنة لووردبريس مع LiteSpeed Cache وPHP 8.3 وNVMe SSD لأداء فائق السرعة. كما نقدم تثبيت ووردبريس بنقرة واحدة.'
        }
      }
    ] : [
      {
        '@type': 'Question',
        name: 'What is shared hosting?',
        acceptedAnswer: {
          '@type': 'Answer',
          text: 'Shared hosting is a type of web hosting where multiple websites share resources on a single server. It\'s a cost-effective option for small to medium websites.'
        }
      },
      {
        '@type': 'Question',
        name: 'Do you offer free SSL certificates?',
        acceptedAnswer: {
          '@type': 'Answer',
          text: 'Yes! All our plans include free SSL certificates from Let\'s Encrypt to secure your website and protect your visitors\' data.'
        }
      },
      {
        '@type': 'Question',
        name: 'What is your uptime guarantee?',
        acceptedAnswer: {
          '@type': 'Answer',
          text: 'We guarantee 99.9% uptime. Our servers are monitored 24/7 and we use the latest technologies to ensure your website stays online.'
        }
      },
      {
        '@type': 'Question',
        name: 'Is Pro Gineous better than Hostinger?',
        acceptedAnswer: {
          '@type': 'Answer',
          text: 'Yes, Pro Gineous offers lower prices, 24/7 Arabic technical support, and servers closer to the Middle East meaning better speed for your visitors.'
        }
      },
      {
        '@type': 'Question',
        name: 'How much is web hosting in Egypt?',
        acceptedAnswer: {
          '@type': 'Answer',
          text: 'Hosting prices start from just $2/month with Pro Gineous. We offer shared, cloud, VPS, and dedicated server plans at prices suitable for the Egyptian and Arab market.'
        }
      },
      {
        '@type': 'Question',
        name: 'What is the best hosting for WordPress?',
        acceptedAnswer: {
          '@type': 'Answer',
          text: 'Our hosting is optimized for WordPress with LiteSpeed Cache, PHP 8.3, and NVMe SSD for lightning-fast performance. We also offer one-click WordPress installation.'
        }
      }
    ]
  };

  // Review Schema for star ratings in search results
  const reviewSchema = {
    '@context': 'https://schema.org',
    '@type': 'Product',
    name: isArabic ? 'استضافة Pro Gineous' : 'Pro Gineous Web Hosting',
    description: isArabic 
      ? 'أفضل استضافة مواقع في مصر والسعودية والإمارات مع دعم عربي 24/7'
      : 'Best web hosting in Egypt, Saudi Arabia, and UAE with 24/7 Arabic support',
    brand: {
      '@type': 'Brand',
      name: 'Pro Gineous'
    },
    aggregateRating: {
      '@type': 'AggregateRating',
      ratingValue: '4.9',
      reviewCount: '4523',
      bestRating: '5',
      worstRating: '1'
    },
    review: [
      {
        '@type': 'Review',
        author: {
          '@type': 'Person',
          name: isArabic ? 'أحمد محمد' : 'Ahmed Mohamed'
        },
        datePublished: '2025-12-15',
        reviewBody: isArabic 
          ? 'أفضل استضافة تعاملت معها. الدعم الفني ممتاز والسرعة رائعة. أنصح بها بشدة!'
          : 'Best hosting I have ever used. Excellent support and amazing speed. Highly recommended!',
        reviewRating: {
          '@type': 'Rating',
          ratingValue: '5',
          bestRating: '5',
          worstRating: '1'
        }
      },
      {
        '@type': 'Review',
        author: {
          '@type': 'Person',
          name: isArabic ? 'سارة أحمد' : 'Sarah Ahmed'
        },
        datePublished: '2025-11-20',
        reviewBody: isArabic 
          ? 'نقلت موقعي من GoDaddy وفرق السرعة واضح جداً. الأسعار ممتازة والدعم بالعربي ميزة كبيرة.'
          : 'Migrated my site from GoDaddy and the speed difference is huge. Great prices and Arabic support is a big plus.',
        reviewRating: {
          '@type': 'Rating',
          ratingValue: '5',
          bestRating: '5',
          worstRating: '1'
        }
      },
      {
        '@type': 'Review',
        author: {
          '@type': 'Person',
          name: isArabic ? 'محمد علي' : 'Mohamed Ali'
        },
        datePublished: '2025-10-05',
        reviewBody: isArabic 
          ? 'استخدم Pro Gineous لـ 3 مواقع ووردبريس. الأداء ممتاز والسيرفرات سريعة جداً.'
          : 'Using Pro Gineous for 3 WordPress sites. Excellent performance and very fast servers.',
        reviewRating: {
          '@type': 'Rating',
          ratingValue: '5',
          bestRating: '5',
          worstRating: '1'
        }
      }
    ],
    offers: {
      '@type': 'AggregateOffer',
      lowPrice: '2',
      highPrice: '140',
      priceCurrency: 'USD',
      offerCount: '12',
      availability: 'https://schema.org/InStock'
    }
  };

  return [organizationSchema, websiteSchema, servicesSchema, faqSchema, breadcrumbSchema, softwareSchema, reviewSchema];
}

export default async function HomePage({ params }: Props) {
  const { locale } = await params;
  setRequestLocale(locale);

  const structuredData = generateStructuredData(locale);

  return (
    <>
      {/* JSON-LD Structured Data for SEO */}
      {structuredData.map((schema, index) => (
        <script
          key={index}
          type="application/ld+json"
          dangerouslySetInnerHTML={{ __html: JSON.stringify(schema) }}
        />
      ))}
      
      <HeroSection />
      <AllPlansMarquee />
      <FeaturesSection />
      <HostingSuccessSection />
      <BetterHostingSection />
      <ExpertsSection />
      <BrandSection />
      <SupportSection />
      <FAQSection />
      <CTASection />
    </>
  );
}
