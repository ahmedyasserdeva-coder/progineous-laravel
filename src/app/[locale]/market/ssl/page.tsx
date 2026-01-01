'use client';

import { useState, useEffect, useRef } from 'react';
import { useLocale } from 'next-intl';
import { Link } from '@/i18n/routing';
import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import {
  Shield,
  Lock,
  Check,
  ChevronDown,
  ChevronUp,
  Sparkles,
  ArrowRight,
  Globe,
  Zap,
  Award,
  Clock,
  RefreshCw,
  ShieldCheck,
  BadgeCheck,
  Building2,
  CreditCard,
  FileText,
  Server,
  Chrome,
  Search,
  TrendingUp,
} from 'lucide-react';
import { cn } from '@/lib/utils';

// Register GSAP plugins
if (typeof window !== 'undefined') {
  gsap.registerPlugin(ScrollTrigger);
}

// SSL Certificate Types
type SSLType = 'dv' | 'ov' | 'ev' | 'wildcard';

interface SSLCertificate {
  id: string;
  name: string;
  brand: string;
  type: SSLType;
  issuance: string;
  warranty: string;
  greatFor: string;
  browserSupport: string;
  cartLink: string; // Direct cart link
  prices: {
    yearly: number;
    twoYears: number;
    threeYears: number;
  };
  features: string[];
  popular?: boolean;
}

const sslCertificates: SSLCertificate[] = [
  // Domain Validation (DV)
  {
    id: 'rapidssl',
    name: 'RapidSSL',
    brand: 'RapidSSL',
    type: 'dv',
    issuance: 'Minutes',
    warranty: '$10,000',
    greatFor: 'Personal Websites',
    browserSupport: '99.9%',
    cartLink: 'https://app.progineous.com/store/ssl-certificates/rapidssl',
    prices: { yearly: 17.95, twoYears: 16.50, threeYears: 15.67 },
    features: ['Secures primary domain', 'Issued in minutes', 'Enables HTTPS & padlock', '256-bit encryption'],
  },
  {
    id: 'geotrust-quickssl',
    name: 'GeoTrust QuickSSL Premium',
    brand: 'GeoTrust',
    type: 'dv',
    issuance: 'Minutes',
    warranty: '$500,000',
    greatFor: 'Small Business',
    browserSupport: '99.9%',
    cartLink: 'https://app.progineous.com/store/ssl-certificates/geotrust-quickssl-premium',
    prices: { yearly: 79.00, twoYears: 73.00, threeYears: 69.67 },
    features: ['Secures primary domain', 'Issued in minutes', '$500K warranty', 'Trust site seal'],
    popular: true,
  },
  // Wildcard
  {
    id: 'rapidssl-wildcard',
    name: 'RapidSSL Wildcard',
    brand: 'RapidSSL',
    type: 'wildcard',
    issuance: 'Minutes',
    warranty: '$10,000',
    greatFor: 'Personal Websites',
    browserSupport: '99.9%',
    cartLink: 'https://app.progineous.com/store/ssl-certificates/rapidssl-wildcard',
    prices: { yearly: 149.00, twoYears: 137.50, threeYears: 131.33 },
    features: ['Unlimited subdomains', 'Issued in minutes', 'Enables HTTPS & padlock', '256-bit encryption'],
  },
  {
    id: 'geotrust-quickssl-wildcard',
    name: 'GeoTrust QuickSSL Premium Wildcard',
    brand: 'GeoTrust',
    type: 'wildcard',
    issuance: 'Minutes',
    warranty: '$500,000',
    greatFor: 'Small Business',
    browserSupport: '99.9%',
    cartLink: 'https://app.progineous.com/store/ssl-certificates/geotrust-quickssl-premium-wildcard',
    prices: { yearly: 279.00, twoYears: 244.13, threeYears: 178.33 },
    features: ['Unlimited subdomains', 'Issued in minutes', '$500K warranty', 'Trust site seal'],
    popular: true,
  },
  {
    id: 'geotrust-truebiz-wildcard',
    name: 'GeoTrust True BusinessID Wildcard',
    brand: 'GeoTrust',
    type: 'wildcard',
    issuance: '1-3 Days',
    warranty: '$1,250,000',
    greatFor: 'Business & Ecommerce',
    browserSupport: '99.9%',
    cartLink: 'https://app.progineous.com/store/ssl-certificates/geotrust-true-business-id-wildcard',
    prices: { yearly: 439.00, twoYears: 406.00, threeYears: 387.67 },
    features: ['Unlimited subdomains', 'Organization validated', '$1.25M warranty', 'Trust site seal'],
  },
  // Organization Validation (OV)
  {
    id: 'geotrust-truebiz',
    name: 'GeoTrust True BusinessID',
    brand: 'GeoTrust',
    type: 'ov',
    issuance: '1-3 Days',
    warranty: '$1,250,000',
    greatFor: 'Business',
    browserSupport: '99.9%',
    cartLink: 'https://app.progineous.com/store/ssl-certificates/geotrust-true-businessid',
    prices: { yearly: 159.00, twoYears: 147.00, threeYears: 140.33 },
    features: ['Organization validated', 'Shows company identity', '$1.25M warranty', 'Trust site seal'],
    popular: true,
  },
  {
    id: 'digicert-secure-site',
    name: 'DigiCert Secure Site',
    brand: 'DigiCert',
    type: 'ov',
    issuance: '1-3 Days',
    warranty: '$1,500,000',
    greatFor: 'Business',
    browserSupport: '99.9%',
    cartLink: 'https://app.progineous.com/store/ssl-certificates/digicert-secure-site',
    prices: { yearly: 448.00, twoYears: 386.50, threeYears: 373.00 },
    features: ['Organization validated', 'DigiCert trusted', '$1.5M warranty', 'Trust site seal'],
  },
  {
    id: 'digicert-secure-site-pro',
    name: 'DigiCert Secure Site Pro',
    brand: 'DigiCert',
    type: 'ov',
    issuance: '1-3 Days',
    warranty: '$1,500,000',
    greatFor: 'Business + Ecommerce',
    browserSupport: '99.9%',
    cartLink: 'https://app.progineous.com/store/ssl-certificates/digicert-secure-site-pro',
    prices: { yearly: 995.00, twoYears: 876.00, threeYears: 845.00 },
    features: ['Organization validated', 'Priority support', '$1.5M warranty', 'Malware scanning'],
  },
  // Extended Validation (EV)
  {
    id: 'geotrust-truebiz-ev',
    name: 'GeoTrust True BusinessID with EV',
    brand: 'GeoTrust',
    type: 'ev',
    issuance: '1-5 Days',
    warranty: '$1,500,000',
    greatFor: 'Business & Ecommerce',
    browserSupport: '99.9%',
    cartLink: 'https://app.progineous.com/store/ssl-certificates/geotrust-true-business-id-with-ev',
    prices: { yearly: 249.00, twoYears: 230.00, threeYears: 161.33 },
    features: ['Extended validation', 'Green address bar', '$1.5M warranty', 'Highest trust level'],
    popular: true,
  },
  {
    id: 'digicert-secure-site-ev',
    name: 'DigiCert Secure Site with EV',
    brand: 'DigiCert',
    type: 'ev',
    issuance: '1-5 Days',
    warranty: '$1,500,000',
    greatFor: 'Business & Ecommerce',
    browserSupport: '99.9%',
    cartLink: 'https://app.progineous.com/store/ssl-certificates/digicert-secure-site-ev',
    prices: { yearly: 995.00, twoYears: 876.00, threeYears: 845.00 },
    features: ['Extended validation', 'DigiCert trusted', '$1.5M warranty', 'Priority support'],
  },
  {
    id: 'digicert-secure-site-pro-ev',
    name: 'DigiCert Secure Site Pro with EV',
    brand: 'DigiCert',
    type: 'ev',
    issuance: '1-5 Days',
    warranty: '$1,750,000',
    greatFor: 'Business & Ecommerce',
    browserSupport: '99.9%',
    cartLink: 'https://app.progineous.com/store/ssl-certificates/digicert-secure-site-pro-ev',
    prices: { yearly: 1499.00, twoYears: 1276.00, threeYears: 1231.00 },
    features: ['Extended validation', 'Priority support', '$1.75M warranty', 'Malware scanning'],
  },
];

const sslTypes = [
  {
    id: 'dv' as SSLType,
    name: { en: 'Domain Validation (DV)', ar: 'التحقق من النطاق (DV)' },
    description: { 
      en: 'Basic protection for personal websites and blogs',
      ar: 'حماية أساسية للمواقع الشخصية والمدونات'
    },
    icon: Shield,
    color: 'blue',
  },
  {
    id: 'wildcard' as SSLType,
    name: { en: 'Wildcard SSL', ar: 'SSL Wildcard' },
    description: { 
      en: 'Secure unlimited subdomains on a single certificate',
      ar: 'تأمين عدد غير محدود من النطاقات الفرعية'
    },
    icon: Globe,
    color: 'purple',
  },
  {
    id: 'ov' as SSLType,
    name: { en: 'Organization Validation (OV)', ar: 'التحقق من المنظمة (OV)' },
    description: { 
      en: 'Business-level protection with identity verification',
      ar: 'حماية على مستوى الأعمال مع التحقق من الهوية'
    },
    icon: Building2,
    color: 'green',
  },
  {
    id: 'ev' as SSLType,
    name: { en: 'Extended Validation (EV)', ar: 'التحقق الممتد (EV)' },
    description: { 
      en: 'Highest level of trust for ecommerce and banking',
      ar: 'أعلى مستوى من الثقة للتجارة الإلكترونية والبنوك'
    },
    icon: BadgeCheck,
    color: 'amber',
  },
];

const features = [
  {
    icon: Lock,
    title: { en: 'Encrypt Sensitive Data', ar: 'تشفير البيانات الحساسة' },
    description: { en: '256-bit encryption for all data', ar: 'تشفير 256-بت لجميع البيانات' },
  },
  {
    icon: CreditCard,
    title: { en: 'Secure Transactions', ar: 'معاملات آمنة' },
    description: { en: 'Protect online payments', ar: 'حماية المدفوعات عبر الإنترنت' },
  },
  {
    icon: BadgeCheck,
    title: { en: 'Prove Legitimacy', ar: 'إثبات المصداقية' },
    description: { en: 'Show visitors you\'re trusted', ar: 'أظهر للزوار أنك موثوق' },
  },
  {
    icon: Zap,
    title: { en: 'Strongest & Fastest', ar: 'الأقوى والأسرع' },
    description: { en: 'Industry-leading encryption', ar: 'تشفير رائد في الصناعة' },
  },
  {
    icon: Chrome,
    title: { en: '99.9% Browser Support', ar: 'دعم 99.9% من المتصفحات' },
    description: { en: 'Works on all major browsers', ar: 'يعمل على جميع المتصفحات الرئيسية' },
  },
  {
    icon: TrendingUp,
    title: { en: 'Boost SEO Ranking', ar: 'تحسين ترتيب SEO' },
    description: { en: 'Google favors HTTPS sites', ar: 'جوجل يفضل مواقع HTTPS' },
  },
  {
    icon: Clock,
    title: { en: 'Quick Issuance', ar: 'إصدار سريع' },
    description: { en: 'DV certs issued in minutes', ar: 'شهادات DV تصدر في دقائق' },
  },
  {
    icon: RefreshCw,
    title: { en: 'Free Reissues', ar: 'إعادة إصدار مجانية' },
    description: { en: 'Unlimited reissues included', ar: 'إعادة إصدار غير محدودة' },
  },
];

const faqs = [
  {
    question: { en: 'What is SSL?', ar: 'ما هو SSL؟' },
    answer: { 
      en: 'SSL (Secure Sockets Layer) certificates are fundamental to internet security. They establish an encrypted connection between a browser and a server, allowing data to be transmitted securely.',
      ar: 'شهادات SSL (طبقة المقابس الآمنة) أساسية لأمان الإنترنت. تنشئ اتصالاً مشفراً بين المتصفح والخادم، مما يسمح بنقل البيانات بشكل آمن.'
    },
  },
  {
    question: { en: 'Which SSL certificate do I need?', ar: 'ما هي شهادة SSL التي أحتاجها؟' },
    answer: { 
      en: 'DV certificates are great for personal sites and blogs. OV certificates are ideal for business websites. EV certificates provide the highest trust for ecommerce and banking. Wildcard certificates secure unlimited subdomains.',
      ar: 'شهادات DV رائعة للمواقع الشخصية والمدونات. شهادات OV مثالية لمواقع الأعمال. شهادات EV توفر أعلى مستوى ثقة للتجارة الإلكترونية والبنوك. شهادات Wildcard تؤمن عدداً غير محدود من النطاقات الفرعية.'
    },
  },
  {
    question: { en: 'How long does issuance take?', ar: 'كم يستغرق الإصدار؟' },
    answer: { 
      en: 'DV certificates are typically issued within minutes. OV certificates take 1-3 days as they require organization verification. EV certificates take 1-5 days due to extended validation requirements.',
      ar: 'يتم إصدار شهادات DV عادةً في غضون دقائق. تستغرق شهادات OV من 1-3 أيام لأنها تتطلب التحقق من المنظمة. تستغرق شهادات EV من 1-5 أيام بسبب متطلبات التحقق الممتد.'
    },
  },
  {
    question: { en: 'What is a Wildcard SSL?', ar: 'ما هو SSL Wildcard؟' },
    answer: { 
      en: 'A Wildcard SSL certificate secures your main domain and unlimited subdomains (e.g., mail.example.com, shop.example.com). It\'s cost-effective if you have multiple subdomains.',
      ar: 'شهادة SSL Wildcard تؤمن نطاقك الرئيسي وعدداً غير محدود من النطاقات الفرعية (مثل mail.example.com، shop.example.com). إنها فعالة من حيث التكلفة إذا كان لديك نطاقات فرعية متعددة.'
    },
  },
  {
    question: { en: 'Do SSL certificates affect SEO?', ar: 'هل تؤثر شهادات SSL على SEO؟' },
    answer: { 
      en: 'Yes! Google uses HTTPS as a ranking factor. Websites with SSL certificates tend to rank higher in search results. Chrome and Firefox also mark non-HTTPS sites as "Not Secure".',
      ar: 'نعم! جوجل يستخدم HTTPS كعامل ترتيب. المواقع التي تحتوي على شهادات SSL تميل إلى الحصول على ترتيب أعلى في نتائج البحث. كروم وفايرفوكس يضعان علامة "غير آمن" على المواقع بدون HTTPS.'
    },
  },
];

export default function SSLCertificatesPage() {
  const locale = useLocale();
  const isRTL = locale === 'ar';
  
  const [selectedType, setSelectedType] = useState<SSLType | 'all'>('all');
  const [selectedPeriod, setSelectedPeriod] = useState<'yearly' | 'twoYears' | 'threeYears'>('yearly');
  const [openFaq, setOpenFaq] = useState<number | null>(0);
  
  const heroRef = useRef<HTMLDivElement>(null);

  // Filter certificates by type
  const filteredCertificates = selectedType === 'all' 
    ? sslCertificates 
    : sslCertificates.filter(cert => cert.type === selectedType);

  // GSAP animations
  useEffect(() => {
    const ctx = gsap.context(() => {
      gsap.from('.hero-animate', {
        y: 30,
        opacity: 0,
        duration: 0.8,
        stagger: 0.1,
        ease: 'power3.out',
      });
    }, heroRef);

    return () => ctx.revert();
  }, []);

  const getPrice = (cert: SSLCertificate) => {
    return cert.prices[selectedPeriod];
  };

  const getPeriodLabel = () => {
    switch (selectedPeriod) {
      case 'yearly': return isRTL ? '/سنة' : '/yr';
      case 'twoYears': return isRTL ? '/سنتين' : '/2yrs';
      case 'threeYears': return isRTL ? '/3 سنوات' : '/3yrs';
    }
  };

  const getTypeColor = (type: SSLType) => {
    switch (type) {
      case 'dv': return 'blue';
      case 'wildcard': return 'purple';
      case 'ov': return 'green';
      case 'ev': return 'amber';
    }
  };

  // JSON-LD Structured Data
  const baseUrl = process.env.NEXT_PUBLIC_SITE_URL || 'https://progineous.com';
  
  const serviceSchema = {
    '@context': 'https://schema.org',
    '@type': 'Service',
    name: isRTL ? 'شهادات SSL' : 'SSL Certificates',
    description: isRTL
      ? 'شهادات SSL من أفضل العلامات التجارية DigiCert و GeoTrust و RapidSSL'
      : 'SSL certificates from top brands DigiCert, GeoTrust, and RapidSSL',
    provider: {
      '@type': 'Organization',
      name: 'Pro Gineous',
      url: baseUrl,
    },
    serviceType: 'SSL Certificate',
    areaServed: 'Worldwide',
    hasOfferCatalog: {
      '@type': 'OfferCatalog',
      name: isRTL ? 'شهادات SSL' : 'SSL Certificates',
      itemListElement: sslCertificates.slice(0, 5).map((cert, index) => ({
        '@type': 'Offer',
        itemOffered: { '@type': 'Service', name: cert.name },
        price: cert.prices.yearly,
        priceCurrency: 'USD',
        position: index + 1,
      })),
    },
  };

  const breadcrumbSchema = {
    '@context': 'https://schema.org',
    '@type': 'BreadcrumbList',
    itemListElement: [
      { '@type': 'ListItem', position: 1, name: isRTL ? 'الرئيسية' : 'Home', item: `${baseUrl}/${locale}` },
      { '@type': 'ListItem', position: 2, name: isRTL ? 'السوق' : 'Market', item: `${baseUrl}/${locale}/market` },
      { '@type': 'ListItem', position: 3, name: isRTL ? 'شهادات SSL' : 'SSL Certificates', item: `${baseUrl}/${locale}/market/ssl` },
    ],
  };

  const faqSchema = {
    '@context': 'https://schema.org',
    '@type': 'FAQPage',
    mainEntity: faqs.map((faq) => ({
      '@type': 'Question',
      name: isRTL ? faq.question.ar : faq.question.en,
      acceptedAnswer: {
        '@type': 'Answer',
        text: isRTL ? faq.answer.ar : faq.answer.en,
      },
    })),
  };

  return (
    <main className="min-h-screen bg-white">
      {/* JSON-LD Structured Data */}
      <script type="application/ld+json" dangerouslySetInnerHTML={{ __html: JSON.stringify(serviceSchema) }} />
      <script type="application/ld+json" dangerouslySetInnerHTML={{ __html: JSON.stringify(breadcrumbSchema) }} />
      <script type="application/ld+json" dangerouslySetInnerHTML={{ __html: JSON.stringify(faqSchema) }} />

      {/* Hero Section */}
      <section
        ref={heroRef}
        className="relative min-h-[500px] lg:min-h-[550px] overflow-hidden"
      >
        {/* Background */}
        <div className="absolute inset-0 bg-gradient-to-br from-[#0a1628] via-[#0f3460] to-[#1d71b8]" />
        
        {/* Pattern Overlay */}
        <div className="absolute inset-0 opacity-10">
          <div className="absolute inset-0" style={{ backgroundImage: 'radial-gradient(circle at 2px 2px, white 1px, transparent 0)', backgroundSize: '40px 40px' }}></div>
        </div>
        
        {/* Content */}
        <div className="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10 max-w-6xl">
          <div className="flex flex-col items-center justify-center min-h-[500px] lg:min-h-[550px] py-20 text-center">
            
            {/* Badge */}
            <div className="hero-animate mb-6">
              <span className="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 backdrop-blur-sm text-white text-sm font-medium">
                <Lock className="w-4 h-4 text-green-400" />
                {isRTL ? 'حماية موقعك' : 'Secure Your Site'}
              </span>
            </div>
            
            {/* Title */}
            <h1 className="hero-animate text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-4">
              {isRTL ? 'شهادات SSL' : 'SSL Certificates'}
            </h1>
            
            {/* Subtitle */}
            <p className="hero-animate text-lg text-white/70 max-w-2xl mb-8">
              {isRTL
                ? 'أمّن موقعك وأضف الثقة لزوارك. مع مجموعة من العلامات التجارية، لدينا الشهادة المناسبة لجميع احتياجات أمان موقعك'
                : 'Secure your site and add trust & confidence for your visitors. With a range of brands, we have the right certificate for all your site security needs'}
            </p>
            
            {/* Quick Stats */}
            <div className="hero-animate flex flex-wrap justify-center gap-8 text-white/80">
              <div className="flex items-center gap-2">
                <Check className="w-5 h-5 text-green-400" />
                <span>{isRTL ? 'تشفير 256-بت' : '256-bit Encryption'}</span>
              </div>
              <div className="flex items-center gap-2">
                <Check className="w-5 h-5 text-green-400" />
                <span>{isRTL ? 'إصدار في دقائق' : 'Issued in Minutes'}</span>
              </div>
              <div className="flex items-center gap-2">
                <Check className="w-5 h-5 text-green-400" />
                <span>{isRTL ? 'ضمان حتى $1.75M' : 'Up to $1.75M Warranty'}</span>
              </div>
            </div>
          </div>
        </div>
        
        {/* Wave */}
        <div className="absolute -bottom-1 left-0 right-0">
          <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg" className="w-full block" preserveAspectRatio="none" style={{ height: '60px' }}>
            <path d="M0 120L60 110C120 100 240 80 360 70C480 60 600 60 720 65C840 70 960 80 1080 85C1200 90 1320 90 1380 90L1440 90V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0Z" fill="white"/>
          </svg>
        </div>
      </section>

      {/* SSL Types Section */}
      <section className="py-16 bg-white">
        <div className="container mx-auto px-4 max-w-6xl">
          <div className="text-center mb-12">
            <h2 className="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
              {isRTL ? 'اختر مستوى الأمان' : 'Choose Your Level of Security'}
            </h2>
            <p className="text-gray-600 max-w-2xl mx-auto">
              {isRTL
                ? 'لدينا أنواع مختلفة من شهادات SSL لتناسب احتياجاتك'
                : 'We have different types of SSL certificates to suit your needs'}
            </p>
          </div>
          
          <div className="grid md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
            {sslTypes.map((type) => (
              <button
                key={type.id}
                onClick={() => setSelectedType(type.id)}
                className={cn(
                  "p-6 rounded-2xl border-2 text-left transition-all",
                  selectedType === type.id
                    ? `border-${type.color}-500 bg-${type.color}-50`
                    : "border-gray-200 hover:border-gray-300 bg-white"
                )}
              >
                <div className={cn(
                  "w-12 h-12 rounded-xl flex items-center justify-center mb-4",
                  type.color === 'blue' && "bg-blue-100 text-blue-600",
                  type.color === 'purple' && "bg-purple-100 text-purple-600",
                  type.color === 'green' && "bg-green-100 text-green-600",
                  type.color === 'amber' && "bg-amber-100 text-amber-600",
                )}>
                  <type.icon className="w-6 h-6" />
                </div>
                <h3 className="font-bold text-gray-900 mb-2">
                  {type.name[locale as 'en' | 'ar']}
                </h3>
                <p className="text-sm text-gray-600">
                  {type.description[locale as 'en' | 'ar']}
                </p>
              </button>
            ))}
          </div>
          
          {/* Show All Button */}
          <div className="text-center">
            <button
              onClick={() => setSelectedType('all')}
              className={cn(
                "px-6 py-3 rounded-xl font-medium transition-all",
                selectedType === 'all'
                  ? "bg-[#1d71b8] text-white"
                  : "bg-gray-100 text-gray-700 hover:bg-gray-200"
              )}
            >
              {isRTL ? 'عرض جميع الشهادات' : 'View All Certificates'}
            </button>
          </div>
        </div>
      </section>

      {/* Pricing Section */}
      <section className="py-16 bg-gray-50">
        <div className="container mx-auto px-4 max-w-7xl">
          <div className="text-center mb-8">
            <h2 className="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
              {isRTL ? 'أسعار الشهادات' : 'Certificate Pricing'}
            </h2>
            
            {/* Period Selector */}
            <div className="inline-flex bg-white rounded-xl p-1 border border-gray-200 shadow-sm">
              <button
                onClick={() => setSelectedPeriod('yearly')}
                className={cn(
                  "px-6 py-2 rounded-lg font-medium transition-all",
                  selectedPeriod === 'yearly'
                    ? "bg-[#1d71b8] text-white"
                    : "text-gray-600 hover:bg-gray-100"
                )}
              >
                {isRTL ? 'سنة' : '1 Year'}
              </button>
              <button
                onClick={() => setSelectedPeriod('twoYears')}
                className={cn(
                  "px-6 py-2 rounded-lg font-medium transition-all",
                  selectedPeriod === 'twoYears'
                    ? "bg-[#1d71b8] text-white"
                    : "text-gray-600 hover:bg-gray-100"
                )}
              >
                {isRTL ? 'سنتين' : '2 Years'}
              </button>
              <button
                onClick={() => setSelectedPeriod('threeYears')}
                className={cn(
                  "px-6 py-2 rounded-lg font-medium transition-all relative",
                  selectedPeriod === 'threeYears'
                    ? "bg-[#1d71b8] text-white"
                    : "text-gray-600 hover:bg-gray-100"
                )}
              >
                {isRTL ? '3 سنوات' : '3 Years'}
                <span className="absolute -top-2 -right-2 px-2 py-0.5 bg-green-500 text-white text-xs rounded-full">
                  {isRTL ? 'وفّر' : 'Save'}
                </span>
              </button>
            </div>
          </div>
          
          {/* Certificates Grid */}
          <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            {filteredCertificates.map((cert) => (
              <div
                key={cert.id}
                className={cn(
                  "relative bg-white rounded-2xl border-2 overflow-hidden transition-all hover:shadow-xl",
                  cert.popular ? "border-[#1d71b8]" : "border-gray-200"
                )}
              >
                {cert.popular && (
                  <div className="absolute top-0 right-0 bg-[#1d71b8] text-white px-4 py-1 text-xs font-bold rounded-bl-xl">
                    {isRTL ? 'الأكثر شعبية' : 'POPULAR'}
                  </div>
                )}
                
                <div className="p-6">
                  {/* Brand & Type */}
                  <div className="flex items-center justify-between mb-4">
                    <span className={cn(
                      "px-3 py-1 rounded-full text-xs font-bold",
                      cert.type === 'dv' && "bg-blue-100 text-blue-700",
                      cert.type === 'wildcard' && "bg-purple-100 text-purple-700",
                      cert.type === 'ov' && "bg-green-100 text-green-700",
                      cert.type === 'ev' && "bg-amber-100 text-amber-700",
                    )}>
                      {cert.type.toUpperCase()}
                    </span>
                    <span className="text-sm text-gray-500">{cert.brand}</span>
                  </div>
                  
                  {/* Name */}
                  <h3 className="text-xl font-bold text-gray-900 mb-4">
                    {cert.name}
                  </h3>
                  
                  {/* Price */}
                  <div className="mb-4">
                    <span className="text-4xl font-bold text-[#1d71b8]">
                      ${getPrice(cert).toFixed(2)}
                    </span>
                    <span className="text-gray-500">{getPeriodLabel()}</span>
                  </div>
                  
                  {/* Quick Info */}
                  <div className="grid grid-cols-2 gap-3 mb-4 text-sm">
                    <div className="flex items-center gap-2 text-gray-600">
                      <Clock className="w-4 h-4" />
                      {cert.issuance}
                    </div>
                    <div className="flex items-center gap-2 text-gray-600">
                      <Shield className="w-4 h-4" />
                      {cert.warranty}
                    </div>
                    <div className="flex items-center gap-2 text-gray-600">
                      <Building2 className="w-4 h-4" />
                      {cert.greatFor}
                    </div>
                    <div className="flex items-center gap-2 text-gray-600">
                      <Chrome className="w-4 h-4" />
                      {cert.browserSupport}
                    </div>
                  </div>
                  
                  {/* Features */}
                  <ul className="space-y-2 mb-6">
                    {cert.features.map((feature, idx) => (
                      <li key={idx} className="flex items-center gap-2 text-sm text-gray-600">
                        <Check className="w-4 h-4 text-green-500 shrink-0" />
                        {feature}
                      </li>
                    ))}
                  </ul>
                  
                  {/* Buy Button */}
                  <a
                    href={cert.cartLink}
                    target="_blank"
                    rel="noopener noreferrer"
                    className={cn(
                      "w-full py-3 rounded-xl font-semibold transition-all flex items-center justify-center gap-2",
                      cert.popular
                        ? "bg-[#1d71b8] hover:bg-[#155a94] text-white"
                        : "bg-gray-100 hover:bg-gray-200 text-gray-800"
                    )}
                  >
                    {isRTL ? 'اشترِ الآن' : 'Buy Now'}
                    <ArrowRight className={cn("w-4 h-4", isRTL && "rotate-180")} />
                  </a>
                </div>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* What is SSL Section */}
      <section className="py-20 bg-white">
        <div className="container mx-auto px-4 max-w-6xl">
          <div className="grid lg:grid-cols-2 gap-12 items-center">
            <div>
              <h2 className="text-3xl md:text-4xl font-bold text-gray-900 mb-6">
                {isRTL ? 'ما هو SSL؟' : 'What is SSL?'}
              </h2>
              <p className="text-gray-600 mb-6">
                {isRTL
                  ? 'شهادات SSL أساسية لأمان الإنترنت. تُستخدم لإنشاء اتصال مشفر والسماح بنقل البيانات بشكل آمن بين المتصفح أو كمبيوتر المستخدم والخادم أو الموقع.'
                  : 'SSL Certificates are fundamental to internet security. They are used to establish an encrypted connection and allow data to be transmitted securely between a browser or user\'s computer and a server or website.'}
              </p>
              <ul className="space-y-4">
                <li className="flex items-start gap-3">
                  <div className="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center shrink-0">
                    <Check className="w-5 h-5 text-green-600" />
                  </div>
                  <span className="text-gray-700">
                    {isRTL ? 'ينشئ اتصالاً آمناً بين المتصفح والخادم' : 'Establishes a secure connection between browser and server'}
                  </span>
                </li>
                <li className="flex items-start gap-3">
                  <div className="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center shrink-0">
                    <Check className="w-5 h-5 text-green-600" />
                  </div>
                  <span className="text-gray-700">
                    {isRTL ? 'يشفر الاتصال لحماية المعلومات الحساسة' : 'Encrypts communication to protect sensitive information'}
                  </span>
                </li>
                <li className="flex items-start gap-3">
                  <div className="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center shrink-0">
                    <Check className="w-5 h-5 text-green-600" />
                  </div>
                  <span className="text-gray-700">
                    {isRTL ? 'يضع قفلاً بجوار عنوان الويب في المتصفح' : 'Places a padlock next to your web address in the browser'}
                  </span>
                </li>
                <li className="flex items-start gap-3">
                  <div className="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center shrink-0">
                    <Check className="w-5 h-5 text-green-600" />
                  </div>
                  <span className="text-gray-700">
                    {isRTL ? 'يصادق على هوية المنظمة' : 'Authenticates an organization\'s identity'}
                  </span>
                </li>
              </ul>
            </div>
            <div className="relative">
              <div className="bg-gradient-to-br from-[#1d71b8]/10 to-[#1d71b8]/5 rounded-3xl p-8">
                <div className="bg-white rounded-2xl shadow-xl p-6">
                  <div className="flex items-center gap-3 mb-4">
                    <div className="w-3 h-3 rounded-full bg-red-400"></div>
                    <div className="w-3 h-3 rounded-full bg-yellow-400"></div>
                    <div className="w-3 h-3 rounded-full bg-green-400"></div>
                  </div>
                  <div className="bg-gray-100 rounded-lg p-3 flex items-center gap-3">
                    <Lock className="w-5 h-5 text-green-600" />
                    <span className="text-green-600 font-medium">https://</span>
                    <span className="text-gray-700">www.example.com</span>
                    <ShieldCheck className="w-5 h-5 text-green-600 ms-auto" />
                  </div>
                  <div className="mt-6 p-4 bg-green-50 rounded-xl border border-green-200">
                    <div className="flex items-center gap-3 mb-2">
                      <BadgeCheck className="w-6 h-6 text-green-600" />
                      <span className="font-bold text-green-700">
                        {isRTL ? 'الاتصال آمن' : 'Connection is Secure'}
                      </span>
                    </div>
                    <p className="text-sm text-green-600">
                      {isRTL
                        ? 'معلوماتك (مثل كلمات المرور أو بطاقات الائتمان) خاصة عند إرسالها إلى هذا الموقع'
                        : 'Your information (for example, passwords or credit cards) is private when it is sent to this site'}
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      {/* Features Section */}
      <section className="py-20 bg-gray-50">
        <div className="container mx-auto px-4 max-w-6xl">
          <div className="text-center mb-12">
            <h2 className="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
              {isRTL ? 'مميزات شهاداتنا' : 'Certificate Features'}
            </h2>
            <p className="text-gray-600 max-w-2xl mx-auto">
              {isRTL
                ? 'جميع شهاداتنا تأتي مع هذه المميزات القوية'
                : 'All our certificates come with these powerful features'}
            </p>
          </div>
          
          <div className="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
            {features.map((feature, index) => (
              <div
                key={index}
                className="bg-white p-6 rounded-2xl border border-gray-200 hover:border-[#1d71b8]/30 hover:shadow-lg transition-all"
              >
                <div className="w-12 h-12 bg-[#1d71b8]/10 rounded-xl flex items-center justify-center mb-4">
                  <feature.icon className="w-6 h-6 text-[#1d71b8]" />
                </div>
                <h3 className="font-bold text-gray-900 mb-2">
                  {feature.title[locale as 'en' | 'ar']}
                </h3>
                <p className="text-sm text-gray-600">
                  {feature.description[locale as 'en' | 'ar']}
                </p>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* Brands Section */}
      <section className="py-16 bg-white">
        <div className="container mx-auto px-4 max-w-6xl">
          <div className="text-center mb-8">
            <p className="text-gray-500 font-medium">
              {isRTL ? 'شهاداتنا من أكثر العلامات التجارية ثقة في أمان الإنترنت' : 'Our SSL certificates are from the most trusted brands in online security'}
            </p>
          </div>
          <div className="flex flex-wrap justify-center items-center gap-12 opacity-60 grayscale hover:grayscale-0 hover:opacity-100 transition-all">
            <div className="text-2xl font-bold text-gray-700">RapidSSL</div>
            <div className="text-2xl font-bold text-gray-700">GeoTrust</div>
            <div className="text-2xl font-bold text-gray-700">DigiCert</div>
          </div>
        </div>
      </section>

      {/* FAQ Section */}
      <section className="py-20 bg-gray-50">
        <div className="container mx-auto px-4 max-w-4xl">
          <div className="text-center mb-12">
            <h2 className="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
              {isRTL ? 'الأسئلة الشائعة' : 'Frequently Asked Questions'}
            </h2>
          </div>
          
          <div className="space-y-4">
            {faqs.map((faq, index) => (
              <div
                key={index}
                className="bg-white rounded-2xl border border-gray-200 overflow-hidden"
              >
                <button
                  onClick={() => setOpenFaq(openFaq === index ? null : index)}
                  className="w-full flex items-center justify-between p-6 text-left"
                >
                  <span className="font-semibold text-gray-900">
                    {faq.question[locale as 'en' | 'ar']}
                  </span>
                  {openFaq === index ? (
                    <ChevronUp className="w-5 h-5 text-gray-500" />
                  ) : (
                    <ChevronDown className="w-5 h-5 text-gray-500" />
                  )}
                </button>
                {openFaq === index && (
                  <div className="px-6 pb-6">
                    <p className="text-gray-600">
                      {faq.answer[locale as 'en' | 'ar']}
                    </p>
                  </div>
                )}
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* CTA Section */}
      <section className="py-20 bg-gradient-to-r from-[#1d71b8] to-[#155a94]">
        <div className="container mx-auto px-4 max-w-4xl text-center">
          <Lock className="w-16 h-16 text-white/20 mx-auto mb-6" />
          <h2 className="text-3xl md:text-4xl font-bold text-white mb-4">
            {isRTL ? 'أمّن موقعك اليوم' : 'Secure Your Site Today'}
          </h2>
          <p className="text-white/80 mb-8 max-w-2xl mx-auto">
            {isRTL
              ? 'لا تدع موقعك يُعرض كـ "غير آمن". أضف SSL اليوم وزد من ثقة زوارك وترتيبك في محركات البحث.'
              : 'Don\'t let your site display as "Not Secure". Add SSL today and increase visitor trust and your search engine ranking.'}
          </p>
          <div className="flex flex-wrap justify-center gap-4">
            <a
              href="https://app.progineous.com/store/ssl-certificates"
              target="_blank"
              rel="noopener noreferrer"
              className="px-8 py-4 bg-white hover:bg-gray-100 text-[#1d71b8] font-semibold rounded-xl transition-colors inline-flex items-center gap-2"
            >
              {isRTL ? 'تصفح جميع الشهادات' : 'Browse All Certificates'}
              <ArrowRight className={cn("w-5 h-5", isRTL && "rotate-180")} />
            </a>
            <Link
              href="/contact"
              className="px-8 py-4 bg-white/10 hover:bg-white/20 text-white font-semibold rounded-xl transition-colors backdrop-blur-sm"
            >
              {isRTL ? 'تحتاج مساعدة؟' : 'Need Help?'}
            </Link>
          </div>
        </div>
      </section>
    </main>
  );
}
