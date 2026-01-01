'use client';

import { useState, useEffect, useRef, useMemo } from 'react';
import { useLocale } from 'next-intl';
import { Link } from '@/i18n/routing';
import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import { 
  ComposableMap, 
  Geographies, 
  Geography, 
  Marker,
  ZoomableGroup,
  Line 
} from 'react-simple-maps';
import { 
  Check, 
  Server, 
  Shield, 
  Zap, 
  Clock, 
  Globe, 
  Database,
  HardDrive,
  Lock,
  Headphones,
  ArrowRight,
  Star,
  ChevronDown,
  ChevronUp,
  Sparkles,
  Cpu,
  Gauge,
  Users,
  Minus,
  Cloud,
  Terminal,
  Activity,
  Box,
  Layers,
  Network,
  Wifi,
  MonitorPlay,
  Settings
} from 'lucide-react';
import { cn } from '@/lib/utils';

// Dynamic speed generator hook
function useDynamicSpeed(baseSpeed: number, variance: number = 5) {
  const [speed, setSpeed] = useState(baseSpeed);
  
  useEffect(() => {
    const interval = setInterval(() => {
      const newSpeed = baseSpeed + Math.floor(Math.random() * (variance * 2 + 1)) - variance;
      setSpeed(newSpeed);
    }, 800 + Math.random() * 400);
    
    return () => clearInterval(interval);
  }, [baseSpeed, variance]);
  
  return speed;
}

// Register GSAP plugins
if (typeof window !== 'undefined') {
  gsap.registerPlugin(ScrollTrigger);
}

export default function DedicatedHostingPage() {
  const locale = useLocale();
  const [billingPeriod, setBillingPeriod] = useState<'monthly' | 'yearly'>('monthly');
  const [openFaq, setOpenFaq] = useState<number | null>(0);
  const [selectedCategory, setSelectedCategory] = useState<'all' | 'intel' | 'amd' | 'gpu'>('all');
  
  const heroRef = useRef<HTMLDivElement>(null);
  const plansRef = useRef<HTMLDivElement>(null);
  const planCardsRef = useRef<(HTMLDivElement | null)[]>([]);
  
  // Dynamic speeds for network lines
  const speedNYLondon = useDynamicSpeed(100, 5);
  const speedLondonFrankfurt = useDynamicSpeed(40, 3);
  const speedFrankfurtDubai = useDynamicSpeed(80, 4);
  const speedDubaiSingapore = useDynamicSpeed(60, 4);
  const speedNYEgypt = useDynamicSpeed(120, 8);
  const speedLondonEgypt = useDynamicSpeed(50, 4);
  const speedFrankfurtEgypt = useDynamicSpeed(45, 3);
  const speedDubaiEgypt = useDynamicSpeed(25, 3);
  const speedSingaporeEgypt = useDynamicSpeed(70, 5);

  // GSAP Animation for Hero
  useEffect(() => {
    if (!heroRef.current) return;
    const ctx = gsap.context(() => {
      gsap.fromTo('.hero-title', 
        { opacity: 0, y: 50 }, 
        { opacity: 1, y: 0, duration: 1, ease: 'power3.out' }
      );
      gsap.fromTo('.hero-subtitle', 
        { opacity: 0, y: 30 }, 
        { opacity: 1, y: 0, duration: 1, delay: 0.2, ease: 'power3.out' }
      );
      gsap.fromTo('.hero-badge', 
        { opacity: 0, scale: 0.8 }, 
        { opacity: 1, scale: 1, duration: 0.6, delay: 0.4, ease: 'back.out' }
      );
      // Animate server rack
      gsap.fromTo('.server-rack', 
        { opacity: 0, x: 100 }, 
        { opacity: 1, x: 0, duration: 1.2, delay: 0.3, ease: 'power3.out' }
      );
      // Blinking server lights
      gsap.to('.server-light', {
        opacity: 0.3,
        duration: 0.5,
        repeat: -1,
        yoyo: true,
        stagger: 0.1
      });
    }, heroRef);
    return () => ctx.revert();
  }, []);

  const plans = [
    {
      name: 'Intel E3-1270',
      category: 'intel',
      badge: locale === 'ar' ? 'للمشاريع الصغيرة' : 'Small Projects',
      monthlyPrice: 140.00,
      yearlyPrice: 140.00,
      cpu: '4 / 8 @ 3.8 GHz',
      ram: '32 GB',
      storage: '2 x 240 GB SSD',
      bandwidth: '5 TB',
      network: '10 Gbps',
      features: [
        { text: 'IPv4 + IPv6', included: true },
        { text: locale === 'ar' ? 'صلاحيات Root كاملة' : 'Full Root Access', included: true },
        { text: locale === 'ar' ? 'حماية DDoS' : 'DDoS Protection', included: true },
        { text: locale === 'ar' ? 'دعم فني 24/7' : '24/7 Support', included: true },
      ],
      popular: false,
      baseLink: 'https://app.progineous.com/store/dedicated-hosting/intel-e3-1270'
    },
    {
      name: 'Intel E-2286G',
      category: 'intel',
      badge: locale === 'ar' ? 'للأعمال المتوسطة' : 'Medium Business',
      monthlyPrice: 200.00,
      yearlyPrice: 200.00,
      cpu: '6 / 12 @ 4.0 GHz',
      ram: '32 GB',
      storage: '2 x 960 GB SSD',
      bandwidth: '10 TB',
      network: '10 Gbps',
      features: [
        { text: 'IPv4 + IPv6', included: true },
        { text: locale === 'ar' ? 'صلاحيات Root كاملة' : 'Full Root Access', included: true },
        { text: locale === 'ar' ? 'حماية DDoS' : 'DDoS Protection', included: true },
        { text: locale === 'ar' ? 'دعم فني 24/7' : '24/7 Support', included: true },
      ],
      popular: true,
      baseLink: 'https://app.progineous.com/store/dedicated-hosting/intel-e-2286g'
    },
    {
      name: 'Intel E-2288G',
      category: 'intel',
      badge: locale === 'ar' ? 'للأعمال الكبيرة' : 'Large Business',
      monthlyPrice: 370.00,
      yearlyPrice: 370.00,
      cpu: '8 / 16 @ 3.7 GHz',
      ram: '128 GB',
      storage: '2 x 1.92 TB NVMe',
      bandwidth: '10 TB',
      network: '10 Gbps',
      features: [
        { text: 'IPv4 + IPv6', included: true },
        { text: locale === 'ar' ? 'صلاحيات Root كاملة' : 'Full Root Access', included: true },
        { text: locale === 'ar' ? 'حماية DDoS' : 'DDoS Protection', included: true },
        { text: locale === 'ar' ? 'دعم أولوية 24/7' : 'Priority 24/7 Support', included: true },
      ],
      popular: false,
      baseLink: 'https://app.progineous.com/store/dedicated-hosting/intel-e-2288g'
    },
    {
      name: 'AMD EPYC 7443P',
      category: 'amd',
      badge: locale === 'ar' ? 'للمؤسسات' : 'Enterprise',
      monthlyPrice: 780.00,
      yearlyPrice: 780.00,
      cpu: '24 / 48 @ 2.9 GHz',
      ram: '256 GB',
      storage: '2 x 480 GB SSD + 2 x 1.92 TB NVMe',
      bandwidth: '10 TB',
      network: '25 Gbps',
      features: [
        { text: 'IPv4 + IPv6', included: true },
        { text: locale === 'ar' ? 'صلاحيات Root كاملة' : 'Full Root Access', included: true },
        { text: locale === 'ar' ? 'حماية DDoS متقدمة' : 'Advanced DDoS Protection', included: true },
        { text: locale === 'ar' ? 'دعم VIP 24/7' : 'VIP 24/7 Support', included: true },
      ],
      popular: false,
      baseLink: 'https://app.progineous.com/store/dedicated-hosting/amd-epyc-7443p'
    },
    {
      name: 'AMD EPYC 9354P',
      category: 'amd',
      badge: locale === 'ar' ? 'قوة خارقة' : 'Ultimate Power',
      monthlyPrice: 1600.00,
      yearlyPrice: 1600.00,
      cpu: '32 / 64 @ 3.3 GHz',
      ram: '768 GB',
      storage: '2 x 480 GB SSD + 4 x 6.4 TB NVMe',
      bandwidth: '10 TB',
      network: '25 Gbps',
      features: [
        { text: 'IPv4 + IPv6', included: true },
        { text: locale === 'ar' ? 'صلاحيات Root كاملة' : 'Full Root Access', included: true },
        { text: locale === 'ar' ? 'حماية DDoS متقدمة' : 'Advanced DDoS Protection', included: true },
        { text: locale === 'ar' ? 'دعم VIP 24/7' : 'VIP 24/7 Support', included: true },
      ],
      popular: false,
      baseLink: 'https://app.progineous.com/store/dedicated-hosting/amd-epyc-9354p'
    },
    {
      name: '8x NVIDIA HGX H100',
      category: 'gpu',
      badge: locale === 'ar' ? 'AI & Deep Learning' : 'AI & Deep Learning',
      monthlyPrice: 45800.00,
      yearlyPrice: 45800.00,
      cpu: '112 / 224 @ 2.0 GHz',
      ram: '2048 GB',
      storage: '2 x 960 GB NVMe + 8 x 3.84 TB NVMe',
      bandwidth: '15 TB',
      network: '100 Gbps',
      features: [
        { text: '8x NVIDIA H100 80GB SXM', included: true },
        { text: 'NVLink & NVSwitch', included: true },
        { text: locale === 'ar' ? 'دعم مخصص للذكاء الاصطناعي' : 'Dedicated AI Support', included: true },
        { text: locale === 'ar' ? 'SLA مخصص' : 'Custom SLA', included: true },
      ],
      popular: false,
      baseLink: 'https://app.progineous.com/store/dedicated-hosting/8-x-nvidia-hgx-h100-gpu-sxm-80gb'
    }
  ];
  
  // Function to get the correct link with billing cycle
  const getPlanLink = (baseLink: string) => {
    const billingCycle = billingPeriod === 'yearly' ? 'annually' : 'monthly';
    return `${baseLink}?billingcycle=${billingCycle}`;
  };

  const filteredPlans = selectedCategory === 'all' 
    ? plans 
    : plans.filter(plan => plan.category === selectedCategory);

  const faqs = [
    { 
      question: locale === 'ar' ? 'ما هو الخادم المخصص؟' : 'What is a Dedicated Server?',
      answer: locale === 'ar' 
        ? 'الخادم المخصص هو خادم فعلي كامل مخصص لك وحدك. لا يوجد مشاركة للموارد مع أي عميل آخر، مما يوفر أقصى أداء وأمان وتحكم كامل.'
        : 'A dedicated server is a complete physical server exclusively assigned to you. No resource sharing with any other customer, providing maximum performance, security, and full control.'
    },
    { 
      question: locale === 'ar' ? 'ما الفرق بين Dedicated و VPS؟' : 'What\'s the difference between Dedicated and VPS?',
      answer: locale === 'ar'
        ? 'VPS هو جزء افتراضي من خادم فعلي مشترك، بينما الخادم المخصص هو خادم فعلي كامل لك وحدك. المخصص يوفر أداء أعلى وموارد أكثر وتحكم كامل بالهاردوير.'
        : 'VPS is a virtual portion of a shared physical server, while a dedicated server is a complete physical server just for you. Dedicated provides higher performance, more resources, and full hardware control.'
    },
    { 
      question: locale === 'ar' ? 'هل يمكنني تخصيص مواصفات الخادم؟' : 'Can I customize server specifications?',
      answer: locale === 'ar'
        ? 'نعم! يمكننا تخصيص المواصفات حسب احتياجاتك بما في ذلك RAM إضافي، أقراص تخزين، وعناوين IP. تواصل معنا للحصول على عرض مخصص.'
        : 'Yes! We can customize specifications according to your needs including additional RAM, storage drives, and IP addresses. Contact us for a custom quote.'
    },
    { 
      question: locale === 'ar' ? 'كم يستغرق تجهيز الخادم؟' : 'How long does server setup take?',
      answer: locale === 'ar'
        ? 'عادةً يتم تجهيز الخوادم القياسية خلال 24-48 ساعة. الخوادم المخصصة أو ذات المواصفات الخاصة قد تستغرق 3-5 أيام عمل.'
        : 'Standard servers are typically set up within 24-48 hours. Custom or special specification servers may take 3-5 business days.'
    },
    { 
      question: locale === 'ar' ? 'ما هو ضمان وقت التشغيل؟' : 'What is the uptime guarantee?',
      answer: locale === 'ar'
        ? 'نقدم ضمان وقت تشغيل 99.99% SLA مدعوم برصيد خدمة. مراكز بياناتنا مجهزة بطاقة احتياطية وتبريد متعدد المستويات.'
        : 'We offer 99.99% uptime SLA backed by service credit. Our data centers are equipped with redundant power and multi-level cooling.'
    },
  ];

  // JSON-LD Structured Data for SEO
  const structuredData = {
    '@context': 'https://schema.org',
    '@type': 'Product',
    name: locale === 'ar' ? 'سيرفرات مخصصة' : 'Dedicated Servers',
    description: locale === 'ar' 
      ? 'خوادم مخصصة بالكامل مع أحدث معالجات Intel و AMD. أداء لا مثيل له، أمان كامل، وتحكم مطلق'
      : 'Fully dedicated servers with latest Intel & AMD processors. Unmatched performance, complete security, and absolute control',
    image: 'https://progineous.com/og-dedicated-hosting.png',
    url: `https://progineous.com/${locale}/hosting/dedicated`,
    brand: {
      '@type': 'Brand',
      name: 'Pro Gineous'
    },
    offers: {
      '@type': 'AggregateOffer',
      lowPrice: '140',
      highPrice: '45800',
      priceCurrency: 'USD',
      offerCount: '6',
      offers: plans.map(plan => ({
        '@type': 'Offer',
        name: plan.name,
        description: plan.badge,
        price: plan.monthlyPrice,
        priceCurrency: 'USD',
        priceValidUntil: '2026-12-31',
        availability: 'https://schema.org/InStock',
        url: plan.baseLink
      }))
    },
    aggregateRating: {
      '@type': 'AggregateRating',
      ratingValue: '4.9',
      reviewCount: '847',
      bestRating: '5',
      worstRating: '1'
    }
  };

  const faqStructuredData = {
    '@context': 'https://schema.org',
    '@type': 'FAQPage',
    mainEntity: faqs.map(faq => ({
      '@type': 'Question',
      name: faq.question,
      acceptedAnswer: {
        '@type': 'Answer',
        text: faq.answer
      }
    }))
  };

  const breadcrumbStructuredData = {
    '@context': 'https://schema.org',
    '@type': 'BreadcrumbList',
    itemListElement: [
      {
        '@type': 'ListItem',
        position: 1,
        name: locale === 'ar' ? 'الرئيسية' : 'Home',
        item: `https://progineous.com/${locale}`
      },
      {
        '@type': 'ListItem',
        position: 2,
        name: locale === 'ar' ? 'الاستضافة' : 'Hosting',
        item: `https://progineous.com/${locale}/hosting`
      },
      {
        '@type': 'ListItem',
        position: 3,
        name: locale === 'ar' ? 'سيرفرات مخصصة' : 'Dedicated Servers',
        item: `https://progineous.com/${locale}/hosting/dedicated`
      }
    ]
  };

  return (
    <main className="min-h-screen bg-white">
      {/* JSON-LD Structured Data */}
      <script
        type="application/ld+json"
        dangerouslySetInnerHTML={{ __html: JSON.stringify(structuredData) }}
      />
      <script
        type="application/ld+json"
        dangerouslySetInnerHTML={{ __html: JSON.stringify(faqStructuredData) }}
      />
      <script
        type="application/ld+json"
        dangerouslySetInnerHTML={{ __html: JSON.stringify(breadcrumbStructuredData) }}
      />

      {/* Hero Section - Server Rack Design */}
      <section ref={heroRef} className="relative min-h-[90vh] flex items-center overflow-hidden">
        {/* Background */}
        <div className="absolute inset-0 bg-linear-to-br from-white via-gray-50 to-white">
          {/* Grid Pattern */}
          <div className="absolute inset-0 bg-[linear-gradient(rgba(59,130,246,0.03)_1px,transparent_1px),linear-gradient(90deg,rgba(59,130,246,0.03)_1px,transparent_1px)] bg-size-[50px_50px]"></div>
          {/* Radial Glow */}
          <div className="absolute top-1/2 left-1/4 w-200 h-200 bg-blue-500/10 rounded-full blur-3xl transform -translate-y-1/2"></div>
          <div className="absolute bottom-0 right-0 w-150 h-150 bg-orange-500/10 rounded-full blur-3xl"></div>
        </div>

        <div className="relative z-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-20">
          <div className="grid lg:grid-cols-2 gap-12 lg:gap-20 items-center">
            {/* Left Content */}
            <div className={locale === 'ar' ? 'order-2 lg:order-1 text-right' : 'order-2 lg:order-1'}>
              <div className="hero-badge inline-flex items-center gap-2 rounded-full bg-linear-to-r from-orange-500/20 to-red-500/20 border border-orange-500/30 px-5 py-2.5 text-sm font-semibold text-orange-400 mb-6">
                <Server className="h-4 w-4" />
                {locale === 'ar' ? 'خوادم مخصصة' : 'Dedicated Servers'}
              </div>
              
              <h1 className="hero-title text-4xl sm:text-5xl lg:text-6xl xl:text-7xl font-bold text-gray-900 mb-6 leading-tight">
                {locale === 'ar' ? 'قوة' : 'Raw'}
                <span className="bg-linear-to-r from-orange-400 via-red-500 to-orange-500 bg-clip-text text-transparent"> {locale === 'ar' ? 'خارقة' : 'Power'}</span>
                <br />
                {locale === 'ar' ? 'لمشاريعك' : 'For Your Projects'}
              </h1>
              
              <p className="hero-subtitle text-xl text-gray-600 mb-8 leading-relaxed max-w-xl">
                {locale === 'ar' 
                  ? 'خوادم مخصصة بالكامل مع أحدث معالجات Intel و AMD. أداء لا مثيل له، أمان كامل، وتحكم مطلق.'
                  : 'Fully dedicated servers with latest Intel & AMD processors. Unmatched performance, complete security, and absolute control.'}
              </p>

              {/* Stats */}
              <div className="grid grid-cols-3 gap-4 mb-8">
                <div className="bg-white backdrop-blur-sm rounded-2xl p-4 border border-gray-200 text-center">
                  <div className="text-3xl font-bold text-orange-400">99.99%</div>
                  <div className="text-gray-600 text-sm">{locale === 'ar' ? 'وقت التشغيل' : 'Uptime SLA'}</div>
                </div>
                <div className="bg-white backdrop-blur-sm rounded-2xl p-4 border border-gray-200 text-center">
                  <div className="text-3xl font-bold text-orange-400">100Gbps</div>
                  <div className="text-gray-600 text-sm">{locale === 'ar' ? 'سرعة الشبكة' : 'Network'}</div>
                </div>
                <div className="bg-white backdrop-blur-sm rounded-2xl p-4 border border-gray-200 text-center">
                  <div className="text-3xl font-bold text-orange-400">24/7</div>
                  <div className="text-gray-600 text-sm">{locale === 'ar' ? 'دعم فني' : 'Support'}</div>
                </div>
              </div>

              <div className="flex flex-wrap gap-4">
                <a href="#plans" className="group inline-flex items-center gap-2 rounded-xl bg-linear-to-r from-orange-500 to-red-500 px-8 py-4 font-semibold text-gray-900 hover:shadow-lg hover:shadow-orange-500/30 transition-all duration-300">
                  {locale === 'ar' ? 'استكشف الخطط' : 'Explore Plans'}
                  <ArrowRight className="h-5 w-5 group-hover:translate-x-1 transition-transform" />
                </a>
                <Link href="/contact" className="inline-flex items-center gap-2 rounded-xl bg-gray-100 border border-gray-200 px-8 py-4 font-semibold text-gray-900 hover:bg-gray-200 transition-all duration-300">
                  {locale === 'ar' ? 'تواصل معنا' : 'Contact Sales'}
                </Link>
              </div>
            </div>

            {/* Right - Server Rack Visualization */}
            <div className={cn("server-rack order-1 lg:order-2", locale === 'ar' ? 'lg:order-1' : '')}>
              <div className="relative">
                {/* Server Rack Frame */}
                <div className="relative bg-linear-to-b from-gray-100 to-gray-50 rounded-3xl p-6 border border-gray-200 shadow-2xl">
                  {/* Top Handle */}
                  <div className="absolute -top-3 left-1/2 -translate-x-1/2 w-32 h-2 bg-slate-600 rounded-full"></div>
                  
                  {/* Server Units */}
                  <div className="space-y-3">
                    {[1, 2, 3, 4].map((unit) => (
                      <div key={unit} className="relative bg-white rounded-xl p-4 border border-gray-200 group hover:border-orange-500/50 transition-colors">
                        <div className="flex items-center justify-between">
                          <div className="flex items-center gap-3">
                            {/* LED Lights */}
                            <div className="flex gap-1.5">
                              <div className={cn("server-light w-2 h-2 rounded-full", unit === 2 ? "bg-orange-500" : "bg-green-500")}></div>
                              <div className="server-light w-2 h-2 rounded-full bg-blue-500"></div>
                            </div>
                            {/* Server Info */}
                            <div>
                              <div className="text-gray-900 font-mono text-sm">SERVER-{unit.toString().padStart(2, '0')}</div>
                              <div className="text-gray-500 text-xs font-mono">
                                {unit === 1 ? 'Intel E-2288G' : unit === 2 ? 'AMD EPYC 7443P' : unit === 3 ? 'AMD EPYC 9354P' : 'NVIDIA H100'}
                              </div>
                            </div>
                          </div>
                          {/* Ventilation */}
                          <div className="flex gap-1">
                            {[...Array(6)].map((_, i) => (
                              <div key={i} className="w-1 h-6 bg-gray-200 rounded-full"></div>
                            ))}
                          </div>
                        </div>
                        {/* Activity Bar */}
                        <div className="mt-3 h-1 bg-gray-100 rounded-full overflow-hidden">
                          <div 
                            className={cn(
                              "h-full bg-linear-to-r from-orange-500 to-red-500 rounded-full transition-all duration-1000",
                              unit === 1 && "w-[40%]",
                              unit === 2 && "w-[60%]",
                              unit === 3 && "w-[80%]",
                              unit === 4 && "w-full"
                            )}
                          ></div>
                        </div>
                      </div>
                    ))}
                  </div>

                  {/* Bottom Status */}
                  <div className="mt-4 flex items-center justify-between text-xs text-gray-500">
                    <span className="flex items-center gap-2">
                      <span className="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                      {locale === 'ar' ? 'جميع الأنظمة تعمل' : 'All Systems Operational'}
                    </span>
                    <span className="font-mono">PWR: 98%</span>
                  </div>
                </div>

                {/* Decorative Elements */}
                <div className="absolute -bottom-4 -right-4 w-32 h-32 bg-orange-500/20 rounded-full blur-2xl"></div>
                <div className="absolute -top-4 -left-4 w-24 h-24 bg-blue-500/20 rounded-full blur-2xl"></div>
              </div>
            </div>
          </div>
        </div>

        {/* Scroll Indicator */}
        <div className="absolute bottom-8 left-1/2 -translate-x-1/2 animate-bounce">
          <ChevronDown className="h-8 w-8 text-gray-500" />
        </div>
      </section>

      {/* Features Section */}
      <section className="py-20 lg:py-28 bg-linear-to-b from-white to-gray-50 relative overflow-hidden">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="text-center mb-16">
            <div className="inline-flex items-center gap-2 rounded-full bg-orange-500/10 border border-orange-500/30 px-5 py-2.5 text-sm font-semibold text-orange-400 mb-6">
              <Sparkles className="h-4 w-4" />
              {locale === 'ar' ? 'لماذا الخوادم المخصصة؟' : 'Why Dedicated?'}
            </div>
            <h2 className="text-4xl font-bold text-gray-900 sm:text-5xl mb-4">
              {locale === 'ar' ? 'قوة لا تُضاهى' : 'Unmatched Power'}
            </h2>
            <p className="text-xl text-gray-600 max-w-2xl mx-auto">
              {locale === 'ar' 
                ? 'كل ما تحتاجه لتشغيل أكثر المشاريع تطلباً'
                : 'Everything you need to run the most demanding projects'}
            </p>
          </div>

          <div className="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
            {/* Feature 1 */}
            <div className="group bg-white backdrop-blur-sm rounded-3xl p-6 border border-gray-200 hover:border-orange-500/50 transition-all duration-300">
              <div className="w-14 h-14 rounded-2xl bg-linear-to-br from-orange-500 to-red-500 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                <Cpu className="h-7 w-7 text-gray-900" />
              </div>
              <h3 className="text-xl font-bold text-gray-900 mb-2">
                {locale === 'ar' ? 'موارد حصرية 100%' : '100% Exclusive Resources'}
              </h3>
              <p className="text-gray-600 text-sm">
                {locale === 'ar' 
                  ? 'لا مشاركة مع أي عميل آخر. كل الموارد لك وحدك.'
                  : 'No sharing with any other customer. All resources are yours alone.'}
              </p>
            </div>

            {/* Feature 2 */}
            <div className="group bg-white backdrop-blur-sm rounded-3xl p-6 border border-gray-200 hover:border-orange-500/50 transition-all duration-300">
              <div className="w-14 h-14 rounded-2xl bg-linear-to-br from-blue-500 to-cyan-500 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                <Shield className="h-7 w-7 text-gray-900" />
              </div>
              <h3 className="text-xl font-bold text-gray-900 mb-2">
                {locale === 'ar' ? 'أمان على مستوى المؤسسات' : 'Enterprise Security'}
              </h3>
              <p className="text-gray-600 text-sm">
                {locale === 'ar' 
                  ? 'حماية DDoS متقدمة وجدار حماية مخصص.'
                  : 'Advanced DDoS protection and dedicated firewall.'}
              </p>
            </div>

            {/* Feature 3 */}
            <div className="group bg-white backdrop-blur-sm rounded-3xl p-6 border border-gray-200 hover:border-orange-500/50 transition-all duration-300">
              <div className="w-14 h-14 rounded-2xl bg-linear-to-br from-green-500 to-emerald-500 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                <Terminal className="h-7 w-7 text-gray-900" />
              </div>
              <h3 className="text-xl font-bold text-gray-900 mb-2">
                {locale === 'ar' ? 'تحكم كامل' : 'Full Control'}
              </h3>
              <p className="text-gray-600 text-sm">
                {locale === 'ar' 
                  ? 'صلاحيات Root/Admin كاملة. ثبّت ما تريد.'
                  : 'Full Root/Admin access. Install whatever you need.'}
              </p>
            </div>

            {/* Feature 4 */}
            <div className="group bg-white backdrop-blur-sm rounded-3xl p-6 border border-gray-200 hover:border-orange-500/50 transition-all duration-300">
              <div className="w-14 h-14 rounded-2xl bg-linear-to-br from-cyan-500 to-orange-500 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                <Network className="h-7 w-7 text-gray-900" />
              </div>
              <h3 className="text-xl font-bold text-gray-900 mb-2">
                {locale === 'ar' ? 'شبكة فائقة السرعة' : 'Ultra-Fast Network'}
              </h3>
              <p className="text-gray-600 text-sm">
                {locale === 'ar' 
                  ? 'اتصال يصل إلى 100Gbps مع زمن استجابة منخفض.'
                  : 'Up to 100Gbps connection with low latency.'}
              </p>
            </div>
          </div>
        </div>
      </section>

      {/* Performance Stats Section */}
      <section className="py-20 lg:py-28 bg-white relative overflow-hidden">
        <div className="absolute inset-0">
          <div className="absolute top-0 right-0 w-96 h-96 bg-orange-500/5 rounded-full blur-3xl"></div>
          <div className="absolute bottom-0 left-0 w-96 h-96 bg-blue-500/5 rounded-full blur-3xl"></div>
        </div>
        
        <div className="relative z-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="text-center mb-16">
            <div className="inline-flex items-center gap-2 rounded-full bg-green-500/10 border border-green-500/30 px-5 py-2.5 text-sm font-semibold text-green-500 mb-6">
              <Activity className="h-4 w-4" />
              {locale === 'ar' ? 'إحصائيات الأداء' : 'Performance Stats'}
            </div>
            <h2 className="text-4xl font-bold text-gray-900 sm:text-5xl mb-4">
              {locale === 'ar' ? 'أرقام تتحدث عن' : 'Numbers That Speak'}
              <span className="bg-linear-to-r from-orange-400 to-red-500 bg-clip-text text-transparent"> {locale === 'ar' ? 'نفسها' : 'For Themselves'}</span>
            </h2>
          </div>

          <div className="grid grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8">
            {/* Stat 1 - Uptime */}
            <div className="group relative bg-linear-to-br from-green-50 to-emerald-50 rounded-3xl p-8 border border-green-200 hover:border-green-400 transition-all duration-300 text-center">
              <div className="absolute top-4 right-4 w-3 h-3 bg-green-500 rounded-full animate-pulse"></div>
              <div className="text-5xl lg:text-6xl font-bold text-gray-900 mb-2">
                99.99<span className="text-green-500">%</span>
              </div>
              <div className="text-gray-600 font-medium">
                {locale === 'ar' ? 'وقت التشغيل' : 'Uptime SLA'}
              </div>
              <div className="mt-3 text-sm text-gray-500">
                {locale === 'ar' ? 'مضمون' : 'Guaranteed'}
              </div>
            </div>

            {/* Stat 2 - Customers */}
            <div className="group relative bg-linear-to-br from-blue-50 to-cyan-50 rounded-3xl p-8 border border-blue-200 hover:border-blue-400 transition-all duration-300 text-center">
              <div className="text-5xl lg:text-6xl font-bold text-gray-900 mb-2">
                10K<span className="text-blue-500">+</span>
              </div>
              <div className="text-gray-600 font-medium">
                {locale === 'ar' ? 'عميل سعيد' : 'Happy Clients'}
              </div>
              <div className="mt-3 text-sm text-gray-500">
                {locale === 'ar' ? 'حول العالم' : 'Worldwide'}
              </div>
            </div>

            {/* Stat 3 - Support Response */}
            <div className="group relative bg-linear-to-br from-orange-50 to-red-50 rounded-3xl p-8 border border-orange-200 hover:border-orange-400 transition-all duration-300 text-center">
              <div className="text-5xl lg:text-6xl font-bold text-gray-900 mb-2">
                &lt;15<span className="text-orange-500">min</span>
              </div>
              <div className="text-gray-600 font-medium">
                {locale === 'ar' ? 'متوسط الاستجابة' : 'Avg. Response'}
              </div>
              <div className="mt-3 text-sm text-gray-500">
                {locale === 'ar' ? 'دعم فني' : 'Support Time'}
              </div>
            </div>

            {/* Stat 4 - Years */}
            <div className="group relative bg-linear-to-br from-cyan-50 to-teal-50 rounded-3xl p-8 border border-cyan-200 hover:border-cyan-400 transition-all duration-300 text-center">
              <div className="text-5xl lg:text-6xl font-bold text-gray-900 mb-2">
                15<span className="text-cyan-500">+</span>
              </div>
              <div className="text-gray-600 font-medium">
                {locale === 'ar' ? 'سنة خبرة' : 'Years Experience'}
              </div>
              <div className="mt-3 text-sm text-gray-500">
                {locale === 'ar' ? 'في الصناعة' : 'In Industry'}
              </div>
            </div>
          </div>
        </div>
      </section>

      {/* Use Cases Section */}
      <section className="py-20 lg:py-28 bg-gray-50 relative overflow-hidden">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="text-center mb-16">
            <div className="inline-flex items-center gap-2 rounded-full bg-blue-500/10 border border-blue-500/30 px-5 py-2.5 text-sm font-semibold text-blue-500 mb-6">
              <Layers className="h-4 w-4" />
              {locale === 'ar' ? 'حالات الاستخدام' : 'Use Cases'}
            </div>
            <h2 className="text-4xl font-bold text-gray-900 sm:text-5xl mb-4">
              {locale === 'ar' ? 'مثالي لـ' : 'Perfect For'}
              <span className="bg-linear-to-r from-blue-500 to-cyan-500 bg-clip-text text-transparent"> {locale === 'ar' ? 'كل الاحتياجات' : 'Every Need'}</span>
            </h2>
            <p className="text-xl text-gray-600 max-w-2xl mx-auto">
              {locale === 'ar' 
                ? 'خوادمنا المخصصة تدعم مختلف أنواع المشاريع والتطبيقات'
                : 'Our dedicated servers support all types of projects and applications'}
            </p>
          </div>

          <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            {/* Use Case 1 - Gaming */}
            <div className="group bg-white rounded-3xl p-6 border border-gray-200 hover:border-blue-500/50 hover:shadow-xl hover:shadow-blue-500/10 transition-all duration-300">
              <div className="w-16 h-16 rounded-2xl bg-linear-to-br from-blue-500 to-cyan-500 flex items-center justify-center mb-5 group-hover:scale-110 transition-transform">
                <MonitorPlay className="h-8 w-8 text-white" />
              </div>
              <h3 className="text-xl font-bold text-gray-900 mb-3">
                {locale === 'ar' ? 'خوادم الألعاب' : 'Game Servers'}
              </h3>
              <p className="text-gray-600 text-sm mb-4">
                {locale === 'ar' 
                  ? 'استضافة ألعاب بأقل تأخير ممكن. مثالي لـ Minecraft, CS2, ARK والمزيد.'
                  : 'Host games with minimal latency. Perfect for Minecraft, CS2, ARK and more.'}
              </p>
              <div className="flex flex-wrap gap-2">
                <span className="px-3 py-1 rounded-full bg-blue-100 text-blue-600 text-xs font-medium">Low Latency</span>
                <span className="px-3 py-1 rounded-full bg-blue-100 text-blue-600 text-xs font-medium">DDoS Protection</span>
              </div>
            </div>

            {/* Use Case 2 - E-commerce */}
            <div className="group bg-white rounded-3xl p-6 border border-gray-200 hover:border-green-500/50 hover:shadow-xl hover:shadow-green-500/10 transition-all duration-300">
              <div className="w-16 h-16 rounded-2xl bg-linear-to-br from-green-500 to-emerald-500 flex items-center justify-center mb-5 group-hover:scale-110 transition-transform">
                <Globe className="h-8 w-8 text-white" />
              </div>
              <h3 className="text-xl font-bold text-gray-900 mb-3">
                {locale === 'ar' ? 'التجارة الإلكترونية' : 'E-Commerce'}
              </h3>
              <p className="text-gray-600 text-sm mb-4">
                {locale === 'ar' 
                  ? 'متاجر إلكترونية سريعة وآمنة. دعم كامل لـ WooCommerce و Magento.'
                  : 'Fast and secure online stores. Full support for WooCommerce & Magento.'}
              </p>
              <div className="flex flex-wrap gap-2">
                <span className="px-3 py-1 rounded-full bg-green-100 text-green-600 text-xs font-medium">PCI Compliant</span>
                <span className="px-3 py-1 rounded-full bg-green-100 text-green-600 text-xs font-medium">SSL Ready</span>
              </div>
            </div>

            {/* Use Case 3 - AI/ML */}
            <div className="group bg-white rounded-3xl p-6 border border-gray-200 hover:border-orange-500/50 hover:shadow-xl hover:shadow-orange-500/10 transition-all duration-300">
              <div className="w-16 h-16 rounded-2xl bg-linear-to-br from-orange-500 to-red-500 flex items-center justify-center mb-5 group-hover:scale-110 transition-transform">
                <Cpu className="h-8 w-8 text-white" />
              </div>
              <h3 className="text-xl font-bold text-gray-900 mb-3">
                {locale === 'ar' ? 'الذكاء الاصطناعي' : 'AI & Machine Learning'}
              </h3>
              <p className="text-gray-600 text-sm mb-4">
                {locale === 'ar' 
                  ? 'قوة GPU هائلة لتدريب النماذج والاستدلال. دعم NVIDIA H100.'
                  : 'Massive GPU power for training and inference. NVIDIA H100 support.'}
              </p>
              <div className="flex flex-wrap gap-2">
                <span className="px-3 py-1 rounded-full bg-orange-100 text-orange-600 text-xs font-medium">GPU Optimized</span>
                <span className="px-3 py-1 rounded-full bg-orange-100 text-orange-600 text-xs font-medium">CUDA Ready</span>
              </div>
            </div>

            {/* Use Case 4 - Big Data */}
            <div className="group bg-white rounded-3xl p-6 border border-gray-200 hover:border-cyan-500/50 hover:shadow-xl hover:shadow-cyan-500/10 transition-all duration-300">
              <div className="w-16 h-16 rounded-2xl bg-linear-to-br from-cyan-500 to-blue-500 flex items-center justify-center mb-5 group-hover:scale-110 transition-transform">
                <Database className="h-8 w-8 text-white" />
              </div>
              <h3 className="text-xl font-bold text-gray-900 mb-3">
                {locale === 'ar' ? 'البيانات الضخمة' : 'Big Data & Analytics'}
              </h3>
              <p className="text-gray-600 text-sm mb-4">
                {locale === 'ar' 
                  ? 'معالجة وتحليل كميات هائلة من البيانات بسرعة فائقة.'
                  : 'Process and analyze massive amounts of data at blazing speeds.'}
              </p>
              <div className="flex flex-wrap gap-2">
                <span className="px-3 py-1 rounded-full bg-cyan-100 text-cyan-600 text-xs font-medium">NVMe Storage</span>
                <span className="px-3 py-1 rounded-full bg-cyan-100 text-cyan-600 text-xs font-medium">High Memory</span>
              </div>
            </div>

            {/* Use Case 5 - Streaming */}
            <div className="group bg-white rounded-3xl p-6 border border-gray-200 hover:border-red-500/50 hover:shadow-xl hover:shadow-red-500/10 transition-all duration-300">
              <div className="w-16 h-16 rounded-2xl bg-linear-to-br from-red-500 to-orange-500 flex items-center justify-center mb-5 group-hover:scale-110 transition-transform">
                <Activity className="h-8 w-8 text-white" />
              </div>
              <h3 className="text-xl font-bold text-gray-900 mb-3">
                {locale === 'ar' ? 'البث المباشر' : 'Media Streaming'}
              </h3>
              <p className="text-gray-600 text-sm mb-4">
                {locale === 'ar' 
                  ? 'بث فيديو وصوت بجودة عالية لآلاف المشاهدين في وقت واحد.'
                  : 'Stream high-quality video and audio to thousands of viewers simultaneously.'}
              </p>
              <div className="flex flex-wrap gap-2">
                <span className="px-3 py-1 rounded-full bg-red-100 text-red-600 text-xs font-medium">100Gbps</span>
                <span className="px-3 py-1 rounded-full bg-red-100 text-red-600 text-xs font-medium">CDN Ready</span>
              </div>
            </div>

            {/* Use Case 6 - SaaS */}
            <div className="group bg-white rounded-3xl p-6 border border-gray-200 hover:border-teal-500/50 hover:shadow-xl hover:shadow-teal-500/10 transition-all duration-300">
              <div className="w-16 h-16 rounded-2xl bg-linear-to-br from-teal-500 to-green-500 flex items-center justify-center mb-5 group-hover:scale-110 transition-transform">
                <Cloud className="h-8 w-8 text-white" />
              </div>
              <h3 className="text-xl font-bold text-gray-900 mb-3">
                {locale === 'ar' ? 'تطبيقات SaaS' : 'SaaS Applications'}
              </h3>
              <p className="text-gray-600 text-sm mb-4">
                {locale === 'ar' 
                  ? 'استضافة تطبيقات السحابة مع قابلية توسع غير محدودة.'
                  : 'Host cloud applications with unlimited scalability potential.'}
              </p>
              <div className="flex flex-wrap gap-2">
                <span className="px-3 py-1 rounded-full bg-teal-100 text-teal-600 text-xs font-medium">Auto-Scale</span>
                <span className="px-3 py-1 rounded-full bg-teal-100 text-teal-600 text-xs font-medium">Load Balanced</span>
              </div>
            </div>
          </div>
        </div>
      </section>

      {/* Data Center Locations Section */}
      <section className="py-20 lg:py-28 bg-white relative overflow-hidden">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="text-center mb-16">
            <div className="inline-flex items-center gap-2 rounded-full bg-cyan-500/10 border border-cyan-500/30 px-5 py-2.5 text-sm font-semibold text-cyan-500 mb-6">
              <Globe className="h-4 w-4" />
              {locale === 'ar' ? 'مواقعنا حول العالم' : 'Our Global Locations'}
            </div>
            <h2 className="text-4xl font-bold text-gray-900 sm:text-5xl mb-4">
              {locale === 'ar' ? 'مراكز بيانات' : 'Data Centers'}
              <span className="bg-linear-to-r from-cyan-500 to-blue-500 bg-clip-text text-transparent"> {locale === 'ar' ? 'عالمية' : 'Worldwide'}</span>
            </h2>
            <p className="text-xl text-gray-600 max-w-2xl mx-auto">
              {locale === 'ar' 
                ? 'اختر أقرب موقع لعملائك للحصول على أفضل أداء'
                : 'Choose the closest location to your customers for best performance'}
            </p>
          </div>

          {/* World Map Visual */}
          <div className="relative mb-12">
            <style>{`
              @keyframes dashMove {
                0% { stroke-dashoffset: 24; }
                100% { stroke-dashoffset: 0; }
              }
              @keyframes dashMoveReverse {
                0% { stroke-dashoffset: 0; }
                100% { stroke-dashoffset: 24; }
              }
              @keyframes speedPulse {
                0%, 100% { opacity: 1; }
                50% { opacity: 0.6; }
              }
              .send-line {
                stroke-dasharray: 6 6;
                animation: dashMove 1s linear infinite;
              }
              .receive-line {
                stroke-dasharray: 6 6;
                animation: dashMoveReverse 1s linear infinite;
              }
              .local-line {
                stroke-dasharray: 3 3;
                animation: dashMove 0.6s linear infinite;
              }
            `}</style>
            <div className="bg-linear-to-br from-gray-100 to-gray-200 rounded-3xl p-4 lg:p-6 border border-gray-300 overflow-hidden cursor-grab active:cursor-grabbing">
              <ComposableMap
                projection="geoMercator"
                projectionConfig={{
                  scale: 140,
                  center: [30, 35]
                }}
                width={800}
                height={350}
                style={{ width: '100%', height: 'auto', maxHeight: '350px' }}
              >
                <defs>
                  <filter id="glow">
                    <feGaussianBlur stdDeviation="2" result="coloredBlur"/>
                    <feMerge>
                      <feMergeNode in="coloredBlur"/>
                      <feMergeNode in="SourceGraphic"/>
                    </feMerge>
                  </filter>
                </defs>
                
                <ZoomableGroup center={[30, 35]} zoom={1} minZoom={0.8} maxZoom={4}>
                  <Geographies geography="https://cdn.jsdelivr.net/npm/world-atlas@2/countries-110m.json">
                    {({ geographies }) =>
                      geographies.map((geo) => (
                        <Geography
                          key={geo.rsmKey}
                          geography={geo}
                          fill="#E5E7EB"
                          stroke="#D1D5DB"
                          strokeWidth={0.5}
                          style={{
                            default: { outline: 'none' },
                            hover: { outline: 'none', fill: '#D1D5DB' },
                            pressed: { outline: 'none' }
                          }}
                        />
                      ))
                    }
                  </Geographies>
                  
                  {/* ===== SEND LINES (Green - shifted up) ===== */}
                  {/* NY -> London */}
                  <Line from={[-74.006, 42]} to={[-0.1276, 53]} stroke="#22C55E" strokeWidth={2} strokeLinecap="round" className="send-line" />
                  <Marker coordinates={[-37, 50]}>
                    <text fontSize={6} fill="#22C55E" fontWeight="bold" textAnchor="middle">
                      {speedNYLondon} Gbps
                    </text>
                  </Marker>
                  {/* London -> Frankfurt */}
                  <Line from={[-0.1276, 53]} to={[8.6821, 52]} stroke="#22C55E" strokeWidth={2} strokeLinecap="round" className="send-line" />
                  <Marker coordinates={[4, 55]}>
                    <text fontSize={5} fill="#22C55E" fontWeight="bold" textAnchor="middle">
                      {speedLondonFrankfurt} Gbps
                    </text>
                  </Marker>
                  {/* Frankfurt -> Dubai */}
                  <Line from={[8.6821, 52]} to={[55.2708, 27]} stroke="#22C55E" strokeWidth={2} strokeLinecap="round" className="send-line" />
                  <Marker coordinates={[32, 43]}>
                    <text fontSize={6} fill="#22C55E" fontWeight="bold" textAnchor="middle">
                      {speedFrankfurtDubai} Gbps
                    </text>
                  </Marker>
                  {/* Dubai -> Singapore */}
                  <Line from={[55.2708, 27]} to={[103.8198, 3]} stroke="#22C55E" strokeWidth={2} strokeLinecap="round" className="send-line" />
                  <Marker coordinates={[80, 18]}>
                    <text fontSize={6} fill="#22C55E" fontWeight="bold" textAnchor="middle">
                      {speedDubaiSingapore} Gbps
                    </text>
                  </Marker>
                  
                  {/* ===== RECEIVE LINES (Red - shifted down) ===== */}
                  {/* NY -> London (Receive - flows backward) */}
                  <Line from={[-74.006, 38]} to={[-0.1276, 49]} stroke="#EF4444" strokeWidth={2} strokeLinecap="round" className="receive-line" />
                  <Marker coordinates={[-37, 41]}>
                    <text fontSize={6} fill="#EF4444" fontWeight="bold" textAnchor="middle">
                      {speedNYLondon + Math.floor(Math.random() * 3) - 1} Gbps
                    </text>
                  </Marker>
                  {/* London -> Frankfurt (Receive - flows backward) */}
                  <Line from={[-0.1276, 49]} to={[8.6821, 48]} stroke="#EF4444" strokeWidth={2} strokeLinecap="round" className="receive-line" />
                  <Marker coordinates={[4, 46]}>
                    <text fontSize={5} fill="#EF4444" fontWeight="bold" textAnchor="middle">
                      {speedLondonFrankfurt + Math.floor(Math.random() * 2)} Gbps
                    </text>
                  </Marker>
                  {/* Frankfurt -> Dubai (Receive - flows backward) */}
                  <Line from={[8.6821, 48]} to={[55.2708, 23]} stroke="#EF4444" strokeWidth={2} strokeLinecap="round" className="receive-line" />
                  <Marker coordinates={[32, 32]}>
                    <text fontSize={6} fill="#EF4444" fontWeight="bold" textAnchor="middle">
                      {speedFrankfurtDubai - Math.floor(Math.random() * 2)} Gbps
                    </text>
                  </Marker>
                  {/* Dubai -> Singapore (Receive - flows backward) */}
                  <Line from={[55.2708, 23]} to={[103.8198, -1]} stroke="#EF4444" strokeWidth={2} strokeLinecap="round" className="receive-line" />
                  <Marker coordinates={[80, 8]}>
                    <text fontSize={6} fill="#EF4444" fontWeight="bold" textAnchor="middle">
                      {speedDubaiSingapore + Math.floor(Math.random() * 3) - 1} Gbps
                    </text>
                  </Marker>
                  
                  {/* ===== LOCAL LINES (Orange/Yellow - to nearby regions) ===== */}
                  {/* From New York - to nearby regions */}
                  <Line from={[-74.006, 40.7128]} to={[-95, 35]} stroke="#F97316" strokeWidth={1.5} strokeOpacity={0.6} strokeLinecap="round" className="local-line" />
                  <Line from={[-74.006, 40.7128]} to={[-120, 37]} stroke="#F97316" strokeWidth={1.5} strokeOpacity={0.6} strokeLinecap="round" className="local-line" />
                  <Line from={[-74.006, 40.7128]} to={[-80, 25]} stroke="#F97316" strokeWidth={1.5} strokeOpacity={0.6} strokeLinecap="round" className="local-line" />
                  
                  {/* From London - to nearby regions */}
                  <Line from={[-0.1276, 51.5074]} to={[-8, 40]} stroke="#F97316" strokeWidth={1.5} strokeOpacity={0.6} strokeLinecap="round" className="local-line" />
                  <Line from={[-0.1276, 51.5074]} to={[12, 42]} stroke="#F97316" strokeWidth={1.5} strokeOpacity={0.6} strokeLinecap="round" className="local-line" />
                  <Line from={[-0.1276, 51.5074]} to={[20, 60]} stroke="#F97316" strokeWidth={1.5} strokeOpacity={0.6} strokeLinecap="round" className="local-line" />
                  
                  {/* From Frankfurt - to nearby regions */}
                  <Line from={[8.6821, 50.1109]} to={[20, 52]} stroke="#F97316" strokeWidth={1.5} strokeOpacity={0.6} strokeLinecap="round" className="local-line" />
                  <Line from={[8.6821, 50.1109]} to={[25, 45]} stroke="#F97316" strokeWidth={1.5} strokeOpacity={0.6} strokeLinecap="round" className="local-line" />
                  <Line from={[8.6821, 50.1109]} to={[37, 55]} stroke="#F97316" strokeWidth={1.5} strokeOpacity={0.6} strokeLinecap="round" className="local-line" />
                  
                  {/* From Dubai - to nearby regions */}
                  <Line from={[55.2708, 25.2048]} to={[45, 33]} stroke="#F97316" strokeWidth={1.5} strokeOpacity={0.6} strokeLinecap="round" className="local-line" />
                  <Line from={[55.2708, 25.2048]} to={[40, 15]} stroke="#F97316" strokeWidth={1.5} strokeOpacity={0.6} strokeLinecap="round" className="local-line" />
                  <Line from={[55.2708, 25.2048]} to={[70, 30]} stroke="#F97316" strokeWidth={1.5} strokeOpacity={0.6} strokeLinecap="round" className="local-line" />
                  
                  {/* From Singapore - to nearby regions */}
                  <Line from={[103.8198, 1.3521]} to={[115, 5]} stroke="#F97316" strokeWidth={1.5} strokeOpacity={0.6} strokeLinecap="round" className="local-line" />
                  <Line from={[103.8198, 1.3521]} to={[121, 15]} stroke="#F97316" strokeWidth={1.5} strokeOpacity={0.6} strokeLinecap="round" className="local-line" />
                  <Line from={[103.8198, 1.3521]} to={[140, 35]} stroke="#F97316" strokeWidth={1.5} strokeOpacity={0.6} strokeLinecap="round" className="local-line" />
                  <Line from={[103.8198, 1.3521]} to={[145, -25]} stroke="#F97316" strokeWidth={1.5} strokeOpacity={0.6} strokeLinecap="round" className="local-line" />
                  
                  {/* ===== ACCESS POINTS - Global Coverage ===== */}
                  
                  {/* SOUTH AMERICA */}
                  {/* São Paulo, Brazil - connected to NY */}
                  <Line from={[-74.006, 40.7128]} to={[-46.6333, -23.5505]} stroke="#06B6D4" strokeWidth={1.5} strokeOpacity={0.5} strokeLinecap="round" className="local-line" />
                  {/* Buenos Aires, Argentina - connected to São Paulo */}
                  <Line from={[-46.6333, -23.5505]} to={[-58.3816, -34.6037]} stroke="#06B6D4" strokeWidth={1.5} strokeOpacity={0.5} strokeLinecap="round" className="local-line" />
                  {/* Santiago, Chile - connected to Buenos Aires */}
                  <Line from={[-58.3816, -34.6037]} to={[-70.6693, -33.4489]} stroke="#06B6D4" strokeWidth={1.5} strokeOpacity={0.5} strokeLinecap="round" className="local-line" />
                  {/* Bogotá, Colombia - connected to NY */}
                  <Line from={[-74.006, 40.7128]} to={[-74.0721, 4.7110]} stroke="#06B6D4" strokeWidth={1.5} strokeOpacity={0.5} strokeLinecap="round" className="local-line" />
                  
                  {/* AFRICA */}
                  {/* Lagos, Nigeria - connected to London */}
                  <Line from={[-0.1276, 51.5074]} to={[3.3792, 6.5244]} stroke="#06B6D4" strokeWidth={1.5} strokeOpacity={0.5} strokeLinecap="round" className="local-line" />
                  {/* Johannesburg, South Africa - connected to Dubai */}
                  <Line from={[55.2708, 25.2048]} to={[28.0473, -26.2041]} stroke="#06B6D4" strokeWidth={1.5} strokeOpacity={0.5} strokeLinecap="round" className="local-line" />
                  {/* Nairobi, Kenya - connected to Dubai */}
                  <Line from={[55.2708, 25.2048]} to={[36.8219, -1.2921]} stroke="#06B6D4" strokeWidth={1.5} strokeOpacity={0.5} strokeLinecap="round" className="local-line" />
                  {/* Casablanca, Morocco - connected to London */}
                  <Line from={[-0.1276, 51.5074]} to={[-7.5898, 33.5731]} stroke="#06B6D4" strokeWidth={1.5} strokeOpacity={0.5} strokeLinecap="round" className="local-line" />
                  
                  {/* OCEANIA */}
                  {/* Sydney, Australia - connected to Singapore */}
                  <Line from={[103.8198, 1.3521]} to={[151.2093, -33.8688]} stroke="#06B6D4" strokeWidth={1.5} strokeOpacity={0.5} strokeLinecap="round" className="local-line" />
                  {/* Auckland, New Zealand - connected to Sydney */}
                  <Line from={[151.2093, -33.8688]} to={[174.7633, -36.8485]} stroke="#06B6D4" strokeWidth={1.5} strokeOpacity={0.5} strokeLinecap="round" className="local-line" />
                  
                  {/* ASIA - Extended */}
                  {/* Tokyo, Japan - connected to Singapore */}
                  <Line from={[103.8198, 1.3521]} to={[139.6917, 35.6895]} stroke="#06B6D4" strokeWidth={1.5} strokeOpacity={0.5} strokeLinecap="round" className="local-line" />
                  {/* Seoul, South Korea - connected to Tokyo */}
                  <Line from={[139.6917, 35.6895]} to={[126.9780, 37.5665]} stroke="#06B6D4" strokeWidth={1.5} strokeOpacity={0.5} strokeLinecap="round" className="local-line" />
                  {/* Mumbai, India - connected to Dubai */}
                  <Line from={[55.2708, 25.2048]} to={[72.8777, 19.0760]} stroke="#06B6D4" strokeWidth={1.5} strokeOpacity={0.5} strokeLinecap="round" className="local-line" />
                  {/* Delhi, India - connected to Mumbai */}
                  <Line from={[72.8777, 19.0760]} to={[77.1025, 28.7041]} stroke="#06B6D4" strokeWidth={1.5} strokeOpacity={0.5} strokeLinecap="round" className="local-line" />
                  {/* Hong Kong - connected to Singapore */}
                  <Line from={[103.8198, 1.3521]} to={[114.1694, 22.3193]} stroke="#06B6D4" strokeWidth={1.5} strokeOpacity={0.5} strokeLinecap="round" className="local-line" />
                  {/* Bangkok, Thailand - connected to Singapore */}
                  <Line from={[103.8198, 1.3521]} to={[100.5018, 13.7563]} stroke="#06B6D4" strokeWidth={1.5} strokeOpacity={0.5} strokeLinecap="round" className="local-line" />
                  
                  {/* EUROPE - Extended */}
                  {/* Moscow, Russia - connected to Frankfurt */}
                  <Line from={[8.6821, 50.1109]} to={[37.6173, 55.7558]} stroke="#06B6D4" strokeWidth={1.5} strokeOpacity={0.5} strokeLinecap="round" className="local-line" />
                  {/* Stockholm, Sweden - connected to London */}
                  <Line from={[-0.1276, 51.5074]} to={[18.0686, 59.3293]} stroke="#06B6D4" strokeWidth={1.5} strokeOpacity={0.5} strokeLinecap="round" className="local-line" />
                  {/* Madrid, Spain - connected to London */}
                  <Line from={[-0.1276, 51.5074]} to={[-3.7038, 40.4168]} stroke="#06B6D4" strokeWidth={1.5} strokeOpacity={0.5} strokeLinecap="round" className="local-line" />
                  {/* Warsaw, Poland - connected to Frankfurt */}
                  <Line from={[8.6821, 50.1109]} to={[21.0122, 52.2297]} stroke="#06B6D4" strokeWidth={1.5} strokeOpacity={0.5} strokeLinecap="round" className="local-line" />
                  {/* Istanbul, Turkey - connected to Frankfurt */}
                  <Line from={[8.6821, 50.1109]} to={[28.9784, 41.0082]} stroke="#06B6D4" strokeWidth={1.5} strokeOpacity={0.5} strokeLinecap="round" className="local-line" />
                  
                  {/* NORTH AMERICA - Extended */}
                  {/* Toronto, Canada - connected to NY */}
                  <Line from={[-74.006, 40.7128]} to={[-79.3832, 43.6532]} stroke="#06B6D4" strokeWidth={1.5} strokeOpacity={0.5} strokeLinecap="round" className="local-line" />
                  {/* Los Angeles, USA - connected to NY */}
                  <Line from={[-74.006, 40.7128]} to={[-118.2437, 34.0522]} stroke="#06B6D4" strokeWidth={1.5} strokeOpacity={0.5} strokeLinecap="round" className="local-line" />
                  {/* Mexico City - connected to LA */}
                  <Line from={[-118.2437, 34.0522]} to={[-99.1332, 19.4326]} stroke="#06B6D4" strokeWidth={1.5} strokeOpacity={0.5} strokeLinecap="round" className="local-line" />
                  {/* Vancouver, Canada - connected to LA */}
                  <Line from={[-118.2437, 34.0522]} to={[-123.1207, 49.2827]} stroke="#06B6D4" strokeWidth={1.5} strokeOpacity={0.5} strokeLinecap="round" className="local-line" />
                  
                  {/* ===== ACCESS POINT MARKERS ===== */}
                  {[
                    // South America
                    { coordinates: [-46.6333, -23.5505], name: 'São Paulo' },
                    { coordinates: [-58.3816, -34.6037], name: 'Buenos Aires' },
                    { coordinates: [-70.6693, -33.4489], name: 'Santiago' },
                    { coordinates: [-74.0721, 4.7110], name: 'Bogotá' },
                    // Africa
                    { coordinates: [3.3792, 6.5244], name: 'Lagos' },
                    { coordinates: [28.0473, -26.2041], name: 'Johannesburg' },
                    { coordinates: [36.8219, -1.2921], name: 'Nairobi' },
                    { coordinates: [-7.5898, 33.5731], name: 'Casablanca' },
                    // Oceania
                    { coordinates: [151.2093, -33.8688], name: 'Sydney' },
                    { coordinates: [174.7633, -36.8485], name: 'Auckland' },
                    // Asia
                    { coordinates: [139.6917, 35.6895], name: 'Tokyo' },
                    { coordinates: [126.9780, 37.5665], name: 'Seoul' },
                    { coordinates: [72.8777, 19.0760], name: 'Mumbai' },
                    { coordinates: [77.1025, 28.7041], name: 'Delhi' },
                    { coordinates: [114.1694, 22.3193], name: 'Hong Kong' },
                    { coordinates: [100.5018, 13.7563], name: 'Bangkok' },
                    // Europe
                    { coordinates: [37.6173, 55.7558], name: 'Moscow' },
                    { coordinates: [18.0686, 59.3293], name: 'Stockholm' },
                    { coordinates: [-3.7038, 40.4168], name: 'Madrid' },
                    { coordinates: [21.0122, 52.2297], name: 'Warsaw' },
                    { coordinates: [28.9784, 41.0082], name: 'Istanbul' },
                    // North America
                    { coordinates: [-79.3832, 43.6532], name: 'Toronto' },
                    { coordinates: [-118.2437, 34.0522], name: 'Los Angeles' },
                    { coordinates: [-99.1332, 19.4326], name: 'Mexico City' },
                    { coordinates: [-123.1207, 49.2827], name: 'Vancouver' },
                  ].map(({ coordinates, name }) => (
                    <Marker key={name} coordinates={coordinates as [number, number]}>
                      {/* Small access point dot */}
                      <circle r={3} fill="#06B6D4" fillOpacity={0.7}>
                        <animate attributeName="r" values="2;3;2" dur="2s" repeatCount="indefinite" />
                      </circle>
                      <circle r={1.5} fill="white" fillOpacity={0.8} />
                    </Marker>
                  ))}
                  
                  {/* ===== ACCESS POINTS INTERCONNECTIONS (Light blue mesh) ===== */}
                  {/* South America mesh */}
                  <Line from={[-46.6333, -23.5505]} to={[-74.0721, 4.7110]} stroke="#06B6D4" strokeWidth={1} strokeOpacity={0.3} strokeLinecap="round" className="local-line" />
                  <Line from={[-70.6693, -33.4489]} to={[-74.0721, 4.7110]} stroke="#06B6D4" strokeWidth={1} strokeOpacity={0.3} strokeLinecap="round" className="local-line" />
                  
                  {/* Africa mesh */}
                  <Line from={[3.3792, 6.5244]} to={[-7.5898, 33.5731]} stroke="#06B6D4" strokeWidth={1} strokeOpacity={0.3} strokeLinecap="round" className="local-line" />
                  <Line from={[3.3792, 6.5244]} to={[36.8219, -1.2921]} stroke="#06B6D4" strokeWidth={1} strokeOpacity={0.3} strokeLinecap="round" className="local-line" />
                  <Line from={[36.8219, -1.2921]} to={[28.0473, -26.2041]} stroke="#06B6D4" strokeWidth={1} strokeOpacity={0.3} strokeLinecap="round" className="local-line" />
                  <Line from={[-7.5898, 33.5731]} to={[31.2357, 30.0444]} stroke="#06B6D4" strokeWidth={1} strokeOpacity={0.3} strokeLinecap="round" className="local-line" />
                  <Line from={[36.8219, -1.2921]} to={[31.2357, 30.0444]} stroke="#06B6D4" strokeWidth={1} strokeOpacity={0.3} strokeLinecap="round" className="local-line" />
                  
                  {/* Asia mesh */}
                  <Line from={[139.6917, 35.6895]} to={[114.1694, 22.3193]} stroke="#06B6D4" strokeWidth={1} strokeOpacity={0.3} strokeLinecap="round" className="local-line" />
                  <Line from={[126.9780, 37.5665]} to={[114.1694, 22.3193]} stroke="#06B6D4" strokeWidth={1} strokeOpacity={0.3} strokeLinecap="round" className="local-line" />
                  <Line from={[114.1694, 22.3193]} to={[100.5018, 13.7563]} stroke="#06B6D4" strokeWidth={1} strokeOpacity={0.3} strokeLinecap="round" className="local-line" />
                  <Line from={[100.5018, 13.7563]} to={[72.8777, 19.0760]} stroke="#06B6D4" strokeWidth={1} strokeOpacity={0.3} strokeLinecap="round" className="local-line" />
                  <Line from={[72.8777, 19.0760]} to={[77.1025, 28.7041]} stroke="#06B6D4" strokeWidth={1} strokeOpacity={0.3} strokeLinecap="round" className="local-line" />
                  <Line from={[77.1025, 28.7041]} to={[55.2708, 25.2048]} stroke="#06B6D4" strokeWidth={1} strokeOpacity={0.3} strokeLinecap="round" className="local-line" />
                  
                  {/* Oceania mesh */}
                  <Line from={[151.2093, -33.8688]} to={[139.6917, 35.6895]} stroke="#06B6D4" strokeWidth={1} strokeOpacity={0.3} strokeLinecap="round" className="local-line" />
                  
                  {/* Europe mesh */}
                  <Line from={[18.0686, 59.3293]} to={[37.6173, 55.7558]} stroke="#06B6D4" strokeWidth={1} strokeOpacity={0.3} strokeLinecap="round" className="local-line" />
                  <Line from={[21.0122, 52.2297]} to={[37.6173, 55.7558]} stroke="#06B6D4" strokeWidth={1} strokeOpacity={0.3} strokeLinecap="round" className="local-line" />
                  <Line from={[21.0122, 52.2297]} to={[18.0686, 59.3293]} stroke="#06B6D4" strokeWidth={1} strokeOpacity={0.3} strokeLinecap="round" className="local-line" />
                  <Line from={[-3.7038, 40.4168]} to={[-7.5898, 33.5731]} stroke="#06B6D4" strokeWidth={1} strokeOpacity={0.3} strokeLinecap="round" className="local-line" />
                  <Line from={[28.9784, 41.0082]} to={[21.0122, 52.2297]} stroke="#06B6D4" strokeWidth={1} strokeOpacity={0.3} strokeLinecap="round" className="local-line" />
                  <Line from={[28.9784, 41.0082]} to={[37.6173, 55.7558]} stroke="#06B6D4" strokeWidth={1} strokeOpacity={0.3} strokeLinecap="round" className="local-line" />
                  <Line from={[28.9784, 41.0082]} to={[31.2357, 30.0444]} stroke="#06B6D4" strokeWidth={1} strokeOpacity={0.3} strokeLinecap="round" className="local-line" />
                  <Line from={[-3.7038, 40.4168]} to={[8.6821, 50.1109]} stroke="#06B6D4" strokeWidth={1} strokeOpacity={0.3} strokeLinecap="round" className="local-line" />
                  
                  {/* North America mesh */}
                  <Line from={[-79.3832, 43.6532]} to={[-123.1207, 49.2827]} stroke="#06B6D4" strokeWidth={1} strokeOpacity={0.3} strokeLinecap="round" className="local-line" />
                  <Line from={[-118.2437, 34.0522]} to={[-79.3832, 43.6532]} stroke="#06B6D4" strokeWidth={1} strokeOpacity={0.3} strokeLinecap="round" className="local-line" />
                  <Line from={[-99.1332, 19.4326]} to={[-74.0721, 4.7110]} stroke="#06B6D4" strokeWidth={1} strokeOpacity={0.3} strokeLinecap="round" className="local-line" />
                  
                  {/* Cross-continental connections */}
                  <Line from={[-118.2437, 34.0522]} to={[139.6917, 35.6895]} stroke="#06B6D4" strokeWidth={1} strokeOpacity={0.2} strokeLinecap="round" className="local-line" />
                  <Line from={[28.9784, 41.0082]} to={[72.8777, 19.0760]} stroke="#06B6D4" strokeWidth={1} strokeOpacity={0.2} strokeLinecap="round" className="local-line" />
                  <Line from={[28.0473, -26.2041]} to={[151.2093, -33.8688]} stroke="#06B6D4" strokeWidth={1} strokeOpacity={0.2} strokeLinecap="round" className="local-line" />
                  <Line from={[-46.6333, -23.5505]} to={[3.3792, 6.5244]} stroke="#06B6D4" strokeWidth={1} strokeOpacity={0.2} strokeLinecap="round" className="local-line" />
                  
                  {/* ===== LINES TO EGYPT (Purple - from all data centers) ===== */}
                  <Line from={[-74.006, 40.7128]} to={[31.2357, 30.0444]} stroke="#A855F7" strokeWidth={2} strokeOpacity={0.7} strokeLinecap="round" className="send-line" />
                  <Marker coordinates={[-20, 36]}>
                    <text fontSize={5} fill="#A855F7" fontWeight="bold" textAnchor="middle">
                      {speedNYEgypt} Gbps
                    </text>
                  </Marker>
                  <Line from={[-0.1276, 51.5074]} to={[31.2357, 30.0444]} stroke="#A855F7" strokeWidth={2} strokeOpacity={0.7} strokeLinecap="round" className="send-line" />
                  <Marker coordinates={[15, 43]}>
                    <text fontSize={5} fill="#A855F7" fontWeight="bold" textAnchor="middle">
                      {speedLondonEgypt} Gbps
                    </text>
                  </Marker>
                  <Line from={[8.6821, 50.1109]} to={[31.2357, 30.0444]} stroke="#A855F7" strokeWidth={2} strokeOpacity={0.7} strokeLinecap="round" className="send-line" />
                  <Marker coordinates={[20, 42]}>
                    <text fontSize={5} fill="#A855F7" fontWeight="bold" textAnchor="middle">
                      {speedFrankfurtEgypt} Gbps
                    </text>
                  </Marker>
                  <Line from={[55.2708, 25.2048]} to={[31.2357, 30.0444]} stroke="#A855F7" strokeWidth={2} strokeOpacity={0.7} strokeLinecap="round" className="send-line" />
                  <Marker coordinates={[43, 29]}>
                    <text fontSize={5} fill="#A855F7" fontWeight="bold" textAnchor="middle">
                      {speedDubaiEgypt} Gbps
                    </text>
                  </Marker>
                  <Line from={[103.8198, 1.3521]} to={[31.2357, 30.0444]} stroke="#A855F7" strokeWidth={2} strokeOpacity={0.7} strokeLinecap="round" className="send-line" />
                  <Marker coordinates={[67, 18]}>
                    <text fontSize={5} fill="#A855F7" fontWeight="bold" textAnchor="middle">
                      {speedSingaporeEgypt} Gbps
                    </text>
                  </Marker>
                  
                  {/* Egypt Marker */}
                  <Marker coordinates={[31.2357, 30.0444]}>
                    <circle fill="#A855F7" fillOpacity={0.3}>
                      <animate attributeName="r" values="5;12;5" dur="2s" repeatCount="indefinite" />
                      <animate attributeName="opacity" values="0.4;0;0.4" dur="2s" repeatCount="indefinite" />
                    </circle>
                    <circle r={6} fill="#A855F7" fillOpacity={0.3} filter="url(#glow)" />
                    <circle r={4} fill="#A855F7" filter="url(#glow)">
                      <animate attributeName="r" values="4;5;4" dur="1.5s" repeatCount="indefinite" />
                    </circle>
                    <circle r={1.5} fill="white" fillOpacity={0.9} />
                  </Marker>
                  
                  {/* Data Center Markers */}
                  {[
                    { name: 'New York', coordinates: [-74.006, 40.7128], color: '#3B82F6' },
                    { name: 'London', coordinates: [-0.1276, 51.5074], color: '#22C55E' },
                    { name: 'Frankfurt', coordinates: [8.6821, 50.1109], color: '#F97316' },
                    { name: 'Dubai', coordinates: [55.2708, 25.2048], color: '#EAB308' },
                    { name: 'Singapore', coordinates: [103.8198, 1.3521], color: '#EF4444' },
                  ].map(({ name, coordinates, color }) => (
                    <Marker key={name} coordinates={coordinates as [number, number]}>
                      {/* Ripple effect */}
                      <circle fill={color} fillOpacity={0.3}>
                        <animate attributeName="r" values="6;16;6" dur="2s" repeatCount="indefinite" />
                        <animate attributeName="opacity" values="0.4;0;0.4" dur="2s" repeatCount="indefinite" />
                      </circle>
                      {/* Outer glow */}
                      <circle r={8} fill={color} fillOpacity={0.3} filter="url(#glow)" />
                      {/* Main dot */}
                      <circle r={5} fill={color} filter="url(#glow)">
                        <animate attributeName="r" values="5;6;5" dur="1.5s" repeatCount="indefinite" />
                      </circle>
                      {/* Inner bright core */}
                      <circle r={2} fill="white" fillOpacity={0.9} />
                    </Marker>
                  ))}
                </ZoomableGroup>
              </ComposableMap>
              
              {/* Legend */}
              <div className="absolute top-3 left-3 bg-white/90 backdrop-blur-sm rounded-lg px-3 py-2 text-xs border border-gray-200">
                <div className="flex items-center gap-2 mb-1">
                  <div className="w-6 h-0.5 rounded network-line-green"></div>
                  <span className="text-gray-600">{locale === 'ar' ? 'إرسال' : 'Upload'}</span>
                </div>
                <div className="flex items-center gap-2 mb-1">
                  <div className="w-6 h-0.5 rounded network-line-red"></div>
                  <span className="text-gray-600">{locale === 'ar' ? 'استقبال' : 'Download'}</span>
                </div>
                <div className="flex items-center gap-2 mb-1">
                  <div className="w-6 h-0.5 rounded network-line-orange"></div>
                  <span className="text-gray-600">{locale === 'ar' ? 'إقليمي' : 'Regional'}</span>
                </div>
                <div className="flex items-center gap-2 mb-1">
                  <div className="w-6 h-0.5 rounded network-line-cyan"></div>
                  <span className="text-gray-600">{locale === 'ar' ? 'نقاط وصول' : 'Access Points'}</span>
                </div>
                <div className="flex items-center gap-2">
                  <div className="w-6 h-0.5 rounded network-line-purple"></div>
                  <span className="text-gray-600">{locale === 'ar' ? 'مصر' : 'Egypt'}</span>
                </div>
              </div>
              
              <div className="absolute bottom-2 right-2 text-xs text-gray-400 bg-white/80 px-2 py-1 rounded">
                {locale === 'ar' ? 'اسحب للتنقل' : 'Drag to navigate'}
              </div>
            </div>
          </div>

          {/* Location Cards */}
          <div className="grid sm:grid-cols-2 lg:grid-cols-5 gap-4">
            {[
              { flag: '🇺🇸', city: locale === 'ar' ? 'نيويورك' : 'New York', country: 'USA', latency: '<10ms', color: 'blue' },
              { flag: '🇬🇧', city: locale === 'ar' ? 'لندن' : 'London', country: 'UK', latency: '<12ms', color: 'green' },
              { flag: '🇩🇪', city: locale === 'ar' ? 'فرانكفورت' : 'Frankfurt', country: 'Germany', latency: '<15ms', color: 'orange' },
              { flag: '🇦🇪', city: locale === 'ar' ? 'دبي' : 'Dubai', country: 'UAE', latency: '<8ms', color: 'yellow' },
              { flag: '🇸🇬', city: locale === 'ar' ? 'سنغافورة' : 'Singapore', country: '', latency: '<20ms', color: 'red' },
            ].map((location, index) => (
              <div 
                key={index}
                className={cn(
                  "bg-white rounded-2xl p-5 border border-gray-200 hover:border-gray-300 transition-all duration-300 text-center hover:shadow-lg",
                  location.color === 'blue' && "hover:border-blue-400",
                  location.color === 'green' && "hover:border-green-400",
                  location.color === 'orange' && "hover:border-orange-400",
                  location.color === 'yellow' && "hover:border-yellow-400",
                  location.color === 'red' && "hover:border-red-400"
                )}
              >
                <div className="text-4xl mb-3">{location.flag}</div>
                <div className="font-bold text-gray-900">{location.city}</div>
                {location.country && <div className="text-gray-500 text-sm">{location.country}</div>}
                <div className={cn(
                  "mt-3 inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold",
                  location.color === 'blue' && "bg-blue-100 text-blue-600",
                  location.color === 'green' && "bg-green-100 text-green-600",
                  location.color === 'orange' && "bg-orange-100 text-orange-600",
                  location.color === 'yellow' && "bg-yellow-100 text-yellow-600",
                  location.color === 'red' && "bg-red-100 text-red-600"
                )}>
                  <Zap className="h-3 w-3" />
                  {location.latency}
                </div>
              </div>
            ))}
          </div>

          {/* Features under map */}
          <div className="mt-12 grid sm:grid-cols-3 gap-6">
            <div className="flex items-center gap-4 bg-gray-50 rounded-2xl p-5">
              <div className="w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center">
                <Shield className="h-6 w-6 text-blue-600" />
              </div>
              <div>
                <div className="font-bold text-gray-900">{locale === 'ar' ? 'حماية Tier IV' : 'Tier IV Security'}</div>
                <div className="text-gray-500 text-sm">{locale === 'ar' ? 'أعلى معايير الأمان' : 'Highest security standards'}</div>
              </div>
            </div>
            <div className="flex items-center gap-4 bg-gray-50 rounded-2xl p-5">
              <div className="w-12 h-12 rounded-xl bg-green-100 flex items-center justify-center">
                <Zap className="h-6 w-6 text-green-600" />
              </div>
              <div>
                <div className="font-bold text-gray-900">{locale === 'ar' ? 'طاقة مستدامة' : 'Green Energy'}</div>
                <div className="text-gray-500 text-sm">{locale === 'ar' ? '100% طاقة متجددة' : '100% renewable power'}</div>
              </div>
            </div>
            <div className="flex items-center gap-4 bg-gray-50 rounded-2xl p-5">
              <div className="w-12 h-12 rounded-xl bg-orange-100 flex items-center justify-center">
                <Clock className="h-6 w-6 text-orange-600" />
              </div>
              <div>
                <div className="font-bold text-gray-900">{locale === 'ar' ? 'دعم محلي' : 'Local Support'}</div>
                <div className="text-gray-500 text-sm">{locale === 'ar' ? 'فريق في كل موقع' : 'Team at every location'}</div>
              </div>
            </div>
          </div>
        </div>
      </section>

      {/* Plans Section - Interactive Server Rack */}
      <section id="plans" ref={plansRef} className="py-20 lg:py-28 bg-linear-to-b from-slate-900 via-slate-800 to-slate-900 relative overflow-hidden">
        {/* Background Effects */}
        <div className="absolute inset-0">
          <div className="absolute inset-0 bg-[linear-gradient(rgba(249,115,22,0.03)_1px,transparent_1px),linear-gradient(90deg,rgba(249,115,22,0.03)_1px,transparent_1px)] bg-size-[40px_40px]" />
          <div className="absolute top-0 left-1/4 w-96 h-96 bg-orange-500/10 rounded-full blur-[100px]" />
          <div className="absolute bottom-0 right-1/4 w-96 h-96 bg-blue-500/10 rounded-full blur-[100px]" />
        </div>
        
        <div className="relative z-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          {/* Header */}
          <div className="text-center mb-16">
            <div className="inline-flex items-center gap-2 rounded-full bg-orange-500/10 border border-orange-500/30 px-5 py-2.5 text-sm font-semibold text-orange-400 mb-6">
              <Server className="h-4 w-4" />
              {locale === 'ar' ? 'خطط الخوادم المخصصة' : 'Dedicated Server Plans'}
            </div>
            <h2 className="text-4xl font-bold text-white sm:text-5xl mb-4">
              {locale === 'ar' ? 'اختر' : 'Choose Your'}
              <span className="bg-linear-to-r from-orange-400 to-red-500 bg-clip-text text-transparent"> {locale === 'ar' ? 'الخادم المثالي' : 'Perfect Server'}</span>
            </h2>
            
            {/* Filter & Billing Controls */}
            <div className="mt-8 flex flex-col sm:flex-row items-center justify-center gap-4">
              {/* Category Filter */}
              <div className="inline-flex items-center gap-1 rounded-2xl bg-slate-800/80 backdrop-blur-sm p-1.5 border border-slate-700">
                {[
                  { key: 'all', label: locale === 'ar' ? 'الكل' : 'All' },
                  { key: 'intel', label: 'Intel' },
                  { key: 'amd', label: 'AMD' },
                  { key: 'gpu', label: 'GPU' },
                ].map((cat) => (
                  <button
                    key={cat.key}
                    onClick={() => setSelectedCategory(cat.key as any)}
                    className={cn(
                      "px-5 py-2.5 rounded-xl text-sm font-semibold transition-all duration-300",
                      selectedCategory === cat.key 
                        ? "bg-linear-to-r from-orange-500 to-red-500 text-white shadow-lg shadow-orange-500/30" 
                        : "text-slate-400 hover:text-white"
                    )}
                  >
                    {cat.label}
                  </button>
                ))}
              </div>

              {/* Billing Toggle */}
              <div className="inline-flex items-center gap-1 rounded-xl bg-slate-800/80 p-1.5 border border-slate-700">
                <button
                  onClick={() => setBillingPeriod('monthly')}
                  className={cn(
                    "px-4 py-2 rounded-lg text-sm font-medium transition-all",
                    billingPeriod === 'monthly' 
                      ? "bg-slate-700 text-white" 
                      : "text-slate-400 hover:text-white"
                  )}
                >
                  {locale === 'ar' ? 'شهري' : 'Monthly'}
                </button>
                <button
                  onClick={() => setBillingPeriod('yearly')}
                  className={cn(
                    "px-4 py-2 rounded-lg text-sm font-medium transition-all",
                    billingPeriod === 'yearly' 
                      ? "bg-slate-700 text-white" 
                      : "text-slate-400 hover:text-white"
                  )}
                >
                  {locale === 'ar' ? 'سنوي' : 'Yearly'}
                </button>
              </div>
            </div>
          </div>

          {/* Server Rack Display */}
          <div className="max-w-5xl mx-auto">
            {/* Rack Frame */}
            <div className="relative bg-linear-to-b from-slate-800 to-slate-900 rounded-3xl border-4 border-slate-700 p-4 lg:p-6 shadow-2xl">
              {/* Rack Rails */}
              <div className="absolute left-2 lg:left-4 top-0 bottom-0 w-2 bg-linear-to-b from-slate-600 via-slate-500 to-slate-600 rounded-full" />
              <div className="absolute right-2 lg:right-4 top-0 bottom-0 w-2 bg-linear-to-b from-slate-600 via-slate-500 to-slate-600 rounded-full" />
              
              {/* Server Units */}
              <div className="space-y-3 lg:space-y-4 py-4">
                {filteredPlans.map((plan, index) => (
                  <div 
                    key={plan.name}
                    ref={(el) => { planCardsRef.current[index] = el; }}
                    className={cn(
                      "group relative mx-4 lg:mx-8 transition-all duration-500",
                      "hover:scale-[1.02] hover:z-10"
                    )}
                  >
                    {/* Server Unit - Like a real rack server */}
                    <div className={cn(
                      "relative rounded-xl overflow-hidden transition-all duration-300",
                      "bg-linear-to-r from-slate-800 via-slate-750 to-slate-800",
                      "border-2",
                      plan.popular 
                        ? "border-orange-500/50 shadow-lg shadow-orange-500/20" 
                        : "border-slate-600 hover:border-slate-500"
                    )}>
                      {/* Popular Badge */}
                      {plan.popular && (
                        <div className="absolute top-0 right-4 z-20">
                          <div className="bg-linear-to-r from-orange-500 to-red-500 text-white text-xs font-bold px-3 py-1 rounded-b-lg shadow-lg">
                            {locale === 'ar' ? '⭐ الأكثر طلباً' : '⭐ MOST POPULAR'}
                          </div>
                        </div>
                      )}
                      
                      {/* Server Front Panel */}
                      <div className="flex items-stretch">
                        {/* Left Panel - Status LEDs */}
                        <div className="hidden lg:flex flex-col items-center justify-center w-16 bg-slate-900/50 border-r border-slate-700 py-4 gap-2">
                          {/* Power LED */}
                          <div className="w-3 h-3 rounded-full bg-green-500 shadow-lg shadow-green-500/50 animate-pulse" />
                          {/* Activity LED */}
                          <div className="w-3 h-3 rounded-full bg-blue-400 shadow-lg shadow-blue-400/50 animate-[pulse_0.5s_ease-in-out_infinite]" />
                          {/* Network LED */}
                          <div className="w-3 h-3 rounded-full bg-orange-400 shadow-lg shadow-orange-400/50 animate-[pulse_0.3s_ease-in-out_infinite]" />
                          {/* Category Icon */}
                          <div className={cn(
                            "mt-2 p-2 rounded-lg",
                            plan.category === 'gpu' ? "bg-green-500/20" : 
                            plan.category === 'amd' ? "bg-red-500/20" : "bg-blue-500/20"
                          )}>
                            {plan.category === 'gpu' ? (
                              <Sparkles className="h-4 w-4 text-green-400" />
                            ) : (
                              <Cpu className={cn(
                                "h-4 w-4",
                                plan.category === 'amd' ? "text-red-400" : "text-blue-400"
                              )} />
                            )}
                          </div>
                        </div>
                        
                        {/* Main Content Area */}
                        <div className="flex-1 p-4 lg:p-5">
                          <div className="flex flex-col lg:flex-row lg:items-center gap-4">
                            {/* Server Info */}
                            <div className="flex-1">
                              <div className="flex items-center gap-3 mb-2">
                                {/* Mobile Category Icon */}
                                <div className={cn(
                                  "lg:hidden p-2 rounded-lg",
                                  plan.category === 'gpu' ? "bg-green-500/20" : 
                                  plan.category === 'amd' ? "bg-red-500/20" : "bg-blue-500/20"
                                )}>
                                  {plan.category === 'gpu' ? (
                                    <Sparkles className="h-5 w-5 text-green-400" />
                                  ) : (
                                    <Cpu className={cn(
                                      "h-5 w-5",
                                      plan.category === 'amd' ? "text-red-400" : "text-blue-400"
                                    )} />
                                  )}
                                </div>
                                <div>
                                  <h3 className="text-lg lg:text-xl font-bold text-white">{plan.name}</h3>
                                  <span className={cn(
                                    "text-xs font-medium px-2 py-0.5 rounded-full",
                                    plan.category === 'gpu' ? "bg-green-500/20 text-green-400" : 
                                    plan.category === 'amd' ? "bg-red-500/20 text-red-400" : "bg-blue-500/20 text-blue-400"
                                  )}>
                                    {plan.badge}
                                  </span>
                                </div>
                              </div>
                              
                              {/* Specs Bar - Like server info display */}
                              <div className="flex flex-wrap gap-2 lg:gap-4 mt-3">
                                {/* CPU */}
                                <div className="flex items-center gap-2 bg-slate-900/50 rounded-lg px-3 py-2">
                                  <Cpu className="h-4 w-4 text-blue-400" />
                                  <div>
                                    <div className="text-[10px] text-slate-500 uppercase tracking-wider">CPU</div>
                                    <div className="text-sm font-mono text-white">{plan.cpu}</div>
                                  </div>
                                </div>
                                
                                {/* RAM */}
                                <div className="flex items-center gap-2 bg-slate-900/50 rounded-lg px-3 py-2">
                                  <Database className="h-4 w-4 text-green-400" />
                                  <div>
                                    <div className="text-[10px] text-slate-500 uppercase tracking-wider">RAM</div>
                                    <div className="text-sm font-bold text-white">{plan.ram}</div>
                                  </div>
                                </div>
                                
                                {/* Storage */}
                                <div className="hidden sm:flex items-center gap-2 bg-slate-900/50 rounded-lg px-3 py-2">
                                  <HardDrive className="h-4 w-4 text-orange-400" />
                                  <div>
                                    <div className="text-[10px] text-slate-500 uppercase tracking-wider">{locale === 'ar' ? 'تخزين' : 'Storage'}</div>
                                    <div className="text-sm text-white">{plan.storage}</div>
                                  </div>
                                </div>
                                
                                {/* Network */}
                                <div className="hidden md:flex items-center gap-2 bg-slate-900/50 rounded-lg px-3 py-2">
                                  <Network className="h-4 w-4 text-cyan-400" />
                                  <div>
                                    <div className="text-[10px] text-slate-500 uppercase tracking-wider">{locale === 'ar' ? 'شبكة' : 'Network'}</div>
                                    <div className="text-sm font-bold text-white">{plan.network}</div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            
                            {/* Price & CTA */}
                            <div className="flex items-center gap-4 lg:flex-col lg:items-end">
                              <div className="text-start lg:text-end">
                                <div className="text-3xl lg:text-4xl font-black text-white">
                                  ${billingPeriod === 'yearly' ? (plan.yearlyPrice * 12).toLocaleString() : plan.monthlyPrice.toLocaleString()}
                                </div>
                                <div className="text-slate-400 text-sm">
                                  {billingPeriod === 'yearly' ? (locale === 'ar' ? '/سنة' : '/year') : (locale === 'ar' ? '/شهر' : '/month')}
                                </div>
                              </div>
                              <a
                                href={getPlanLink(plan.baseLink)}
                                target="_blank"
                                rel="noopener noreferrer"
                                className={cn(
                                  "inline-flex items-center gap-2 px-6 py-3 rounded-xl font-bold text-sm transition-all duration-300 whitespace-nowrap",
                                  plan.popular 
                                    ? "bg-linear-to-r from-orange-500 to-red-500 text-white hover:shadow-lg hover:shadow-orange-500/40 hover:scale-105"
                                    : "bg-slate-700 text-white hover:bg-slate-600 border border-slate-600"
                                )}
                              >
                                {locale === 'ar' ? 'اطلب الآن' : 'Deploy Now'}
                                <ArrowRight className="h-4 w-4" />
                              </a>
                            </div>
                          </div>
                          
                          {/* Expandable Features - Mobile */}
                          <div className="sm:hidden mt-3 pt-3 border-t border-slate-700/50">
                            <div className="grid grid-cols-2 gap-2 text-xs">
                              <div className="flex items-center gap-1 text-slate-400">
                                <HardDrive className="h-3 w-3" />
                                {plan.storage}
                              </div>
                              <div className="flex items-center gap-1 text-slate-400">
                                <Network className="h-3 w-3" />
                                {plan.network}
                              </div>
                            </div>
                          </div>
                        </div>
                        
                        {/* Right Panel - Ventilation Pattern */}
                        <div className="hidden lg:block w-20 bg-slate-900/30 border-l border-slate-700">
                          <div className="h-full flex flex-col justify-center gap-1 p-2">
                            {[...Array(8)].map((_, i) => (
                              <div key={i} className="h-1.5 bg-slate-700 rounded-full" />
                            ))}
                          </div>
                        </div>
                      </div>
                    </div>
                    
                    {/* Rack Mount Screws Visual */}
                    <div className="hidden lg:block absolute -left-2 top-1/2 -translate-y-1/2 w-2 h-2 rounded-full bg-slate-500 border border-slate-400" />
                    <div className="hidden lg:block absolute -right-2 top-1/2 -translate-y-1/2 w-2 h-2 rounded-full bg-slate-500 border border-slate-400" />
                  </div>
                ))}
              </div>
              
              {/* Rack Bottom - Cable Management */}
              <div className="mt-4 pt-4 border-t border-slate-700">
                <div className="flex items-center justify-center gap-4 text-slate-500 text-sm">
                  <div className="flex items-center gap-2">
                    <div className="w-2 h-2 rounded-full bg-green-500 animate-pulse" />
                    <span>{locale === 'ar' ? 'جميع الأنظمة تعمل' : 'All Systems Operational'}</span>
                  </div>
                  <div className="w-px h-4 bg-slate-700" />
                  <div className="flex items-center gap-2">
                    <Shield className="h-4 w-4 text-slate-500" />
                    <span>{locale === 'ar' ? 'حماية DDoS مفعّلة' : 'DDoS Protection Active'}</span>
                  </div>
                </div>
              </div>
            </div>
          </div>

          {/* Custom Config CTA */}
          <div className="mt-12 text-center">
            <p className="text-gray-600 mb-4">
              {locale === 'ar' 
                ? 'تحتاج مواصفات مخصصة؟ نحن نوفر خوادم بمواصفات حسب طلبك.'
                : 'Need custom specifications? We offer servers tailored to your requirements.'}
            </p>
            <Link 
              href="/contact"
              className="inline-flex items-center gap-2 text-orange-400 hover:text-orange-300 font-semibold transition-colors"
            >
              {locale === 'ar' ? 'تواصل للحصول على عرض مخصص' : 'Contact us for a custom quote'}
              <ArrowRight className="h-4 w-4" />
            </Link>
          </div>
        </div>
      </section>

      {/* FAQ Section */}
      <section className="py-20 lg:py-28 bg-white">
        <div className="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
          <div className="text-center mb-12">
            <h2 className="text-3xl font-bold text-gray-900 sm:text-4xl">
              {locale === 'ar' ? 'الأسئلة الشائعة' : 'Frequently Asked Questions'}
            </h2>
          </div>

          <div className="space-y-4">
            {faqs.map((faq, index) => (
              <div 
                key={index}
                className="bg-white backdrop-blur-sm rounded-2xl border border-gray-200 overflow-hidden"
              >
                <button
                  onClick={() => setOpenFaq(openFaq === index ? null : index)}
                  className="flex items-center justify-between w-full px-6 py-5 text-start"
                >
                  <span className="text-gray-900 font-semibold">{faq.question}</span>
                  {openFaq === index ? (
                    <ChevronUp className="h-5 w-5 text-orange-400 shrink-0" />
                  ) : (
                    <ChevronDown className="h-5 w-5 text-gray-600 shrink-0" />
                  )}
                </button>
                {openFaq === index && (
                  <div className="px-6 pb-5">
                    <p className="text-gray-600 leading-relaxed">{faq.answer}</p>
                  </div>
                )}
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* CTA Section */}
      <section className="py-20 lg:py-28 bg-linear-to-b from-white to-gray-50 relative overflow-hidden">
        <div className="absolute inset-0">
          <div className="absolute top-1/2 left-1/2 w-200 h-200 bg-orange-500/10 rounded-full blur-3xl transform -translate-x-1/2 -translate-y-1/2"></div>
        </div>

        <div className="relative z-10 mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 text-center">
          <h2 className="text-4xl font-bold text-gray-900 sm:text-5xl mb-6">
            {locale === 'ar' ? 'جاهز للبدء؟' : 'Ready to Get Started?'}
          </h2>
          <p className="text-xl text-gray-600 mb-8 max-w-2xl mx-auto">
            {locale === 'ar' 
              ? 'احصل على خادمك المخصص اليوم واستمتع بقوة وأداء لا مثيل لهما.'
              : 'Get your dedicated server today and enjoy unmatched power and performance.'}
          </p>
          <div className="flex flex-wrap justify-center gap-4">
            <a href="#plans" className="group inline-flex items-center gap-2 rounded-xl bg-linear-to-r from-orange-500 to-red-500 px-8 py-4 font-semibold text-gray-900 hover:shadow-lg hover:shadow-orange-500/30 transition-all duration-300">
              {locale === 'ar' ? 'اختر خطتك' : 'Choose Your Plan'}
              <ArrowRight className="h-5 w-5 group-hover:translate-x-1 transition-transform" />
            </a>
            <Link href="/contact" className="inline-flex items-center gap-2 rounded-xl bg-gray-100 border border-gray-200 px-8 py-4 font-semibold text-gray-900 hover:bg-gray-200 transition-all duration-300">
              <Headphones className="h-5 w-5" />
              {locale === 'ar' ? 'تحدث مع خبير' : 'Talk to an Expert'}
            </Link>
          </div>
        </div>
      </section>
    </main>
  );
}




