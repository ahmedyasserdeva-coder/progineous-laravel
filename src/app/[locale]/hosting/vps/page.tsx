'use client';

import { useState, useEffect, useRef } from 'react';
import { useTranslations, useLocale } from 'next-intl';
import { Link } from '@/i18n/routing';
import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import { 
  Check, 
  Server, 
  Shield, 
  Zap, 
  Clock, 
  Globe, 
  Database,
  HardDrive,
  Mail,
  Lock,
  RefreshCw,
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
  Activity,
  Terminal,
  Settings,
  Network
} from 'lucide-react';
import { cn } from '@/lib/utils';

// Register GSAP plugins
if (typeof window !== 'undefined') {
  gsap.registerPlugin(ScrollTrigger);
}

export default function VPSHostingPage() {
  const locale = useLocale();
  const [billingPeriod, setBillingPeriod] = useState<'monthly' | 'yearly'>('monthly');
  const [openFaq, setOpenFaq] = useState<number | null>(0);
  
  const plansRef = useRef<HTMLDivElement>(null);
  const planCardsRef = useRef<(HTMLDivElement | null)[]>([]);
  const priceRefs = useRef<(HTMLSpanElement | null)[]>([]);
  const allPlansRef = useRef<HTMLDivElement>(null);
  const featuresRef = useRef<HTMLDivElement>(null);
  const featureCardsRef = useRef<(HTMLDivElement | null)[]>([]);

  // GSAP Animation for All Plans Include section
  useEffect(() => {
    if (!allPlansRef.current) return;
    const ctx = gsap.context(() => {
      const titleEl = allPlansRef.current?.querySelector('.all-plans-title');
      if (titleEl) {
        gsap.fromTo(
          titleEl,
          { opacity: 0, y: 30 },
          { opacity: 1, y: 0, duration: 0.8, ease: 'power3.out',
            scrollTrigger: { trigger: allPlansRef.current, start: 'top 80%' }
          }
        );
      }
      const row1 = allPlansRef.current?.querySelector('.marquee-row-1');
      const row2 = allPlansRef.current?.querySelector('.marquee-row-2');
      const isRTL = locale === 'ar';
      if (row1) gsap.to(row1, { x: isRTL ? '25%' : '-25%', duration: 30, ease: 'none', repeat: -1 });
      if (row2) gsap.to(row2, { x: isRTL ? '-25%' : '25%', duration: 35, ease: 'none', repeat: -1 });
    }, allPlansRef);
    return () => ctx.revert();
  }, [locale]);

  // GSAP Animation for Features Section
  useEffect(() => {
    if (!featuresRef.current) return;
    const ctx = gsap.context(() => {
      const cards = featureCardsRef.current.filter(Boolean);
      cards.forEach((card, index) => {
        gsap.fromTo(card, { opacity: 0, y: 60 },
          { opacity: 1, y: 0, duration: 0.8, delay: index * 0.1, ease: 'power3.out',
            scrollTrigger: { trigger: card, start: 'top 85%' }
          }
        );
      });
    }, featuresRef);
    return () => ctx.revert();
  }, []);

  const plans = [
    {
      name: 'VPS 103',
      description: locale === 'ar' ? 'مثالي للمشاريع الصغيرة' : 'Perfect for small projects',
      monthlyPrice: 15.00,
      yearlyPrice: 15.00,
      features: [
        { text: locale === 'ar' ? '1 نواة vCPU Intel' : '1 vCPU Core Intel', included: true },
        { text: locale === 'ar' ? '2 جيجا RAM' : '2 GB RAM', included: true },
        { text: locale === 'ar' ? '50 جيجا NVMe SSD' : '50 GB NVMe SSD', included: true },
        { text: locale === 'ar' ? '1000 جيجا باندويث' : '1000 GB Bandwidth', included: true },
        { text: locale === 'ar' ? 'صلاحيات Root كاملة' : 'Full Root Access', included: true },
        { text: locale === 'ar' ? 'عنوان IPv4 مخصص' : 'Dedicated IPv4', included: true },
        { text: locale === 'ar' ? 'لوحة تحكم مجانية' : 'Free Control Panel', included: true },
        { text: locale === 'ar' ? 'دعم فني 24/7' : '24/7 Support', included: true },
      ],
      popular: false,
      color: 'blue',
      pid: 47,
      link: 'https://app.progineous.com/cart.php?a=add&pid=47'
    },
    {
      name: 'VPS 102',
      description: locale === 'ar' ? 'للمواقع والتطبيقات المتوسطة' : 'For medium websites & apps',
      monthlyPrice: 30.00,
      yearlyPrice: 30.00,
      features: [
        { text: locale === 'ar' ? '2 نواة vCPU Intel' : '2 vCPU Cores Intel', included: true },
        { text: locale === 'ar' ? '4 جيجا RAM' : '4 GB RAM', included: true },
        { text: locale === 'ar' ? '100 جيجا NVMe SSD' : '100 GB NVMe SSD', included: true },
        { text: locale === 'ar' ? '1000 جيجا باندويث' : '1000 GB Bandwidth', included: true },
        { text: locale === 'ar' ? 'صلاحيات Root كاملة' : 'Full Root Access', included: true },
        { text: locale === 'ar' ? 'عنوان IPv4 مخصص' : 'Dedicated IPv4', included: true },
        { text: locale === 'ar' ? 'لوحة تحكم مجانية' : 'Free Control Panel', included: true },
        { text: locale === 'ar' ? 'دعم فني 24/7' : '24/7 Support', included: true },
      ],
      popular: true,
      color: 'blue',
      pid: 48,
      link: 'https://app.progineous.com/cart.php?a=add&pid=48'
    },
    {
      name: 'VPS 101',
      description: locale === 'ar' ? 'للأعمال والمتاجر الكبيرة' : 'For businesses & large stores',
      monthlyPrice: 65.00,
      yearlyPrice: 65.00,
      features: [
        { text: locale === 'ar' ? '4 نواة vCPU Intel' : '4 vCPU Cores Intel', included: true },
        { text: locale === 'ar' ? '8 جيجا RAM' : '8 GB RAM', included: true },
        { text: locale === 'ar' ? '200 جيجا NVMe SSD' : '200 GB NVMe SSD', included: true },
        { text: locale === 'ar' ? 'باندويث غير محدود 5Mbps' : 'Unlimited Bandwidth 5Mbps', included: true },
        { text: locale === 'ar' ? 'صلاحيات Root كاملة' : 'Full Root Access', included: true },
        { text: locale === 'ar' ? 'عنوان IPv4 مخصص' : 'Dedicated IPv4', included: true },
        { text: locale === 'ar' ? 'لوحة تحكم مجانية' : 'Free Control Panel', included: true },
        { text: locale === 'ar' ? 'دعم أولوية 24/7' : 'Priority 24/7 Support', included: true },
      ],
      popular: false,
      color: 'blue',
      pid: 49,
      link: 'https://app.progineous.com/cart.php?a=add&pid=49'
    },
    {
      name: 'VPS 100',
      description: locale === 'ar' ? 'للمشاريع الضخمة والمؤسسات' : 'For enterprise & large projects',
      monthlyPrice: 85.00,
      yearlyPrice: 85.00,
      features: [
        { text: locale === 'ar' ? '8 نواة vCPU Intel' : '8 vCPU Cores Intel', included: true },
        { text: locale === 'ar' ? '16 جيجا RAM' : '16 GB RAM', included: true },
        { text: locale === 'ar' ? '200 جيجا NVMe SSD' : '200 GB NVMe SSD', included: true },
        { text: locale === 'ar' ? 'باندويث غير محدود 5Mbps' : 'Unlimited Bandwidth 5Mbps', included: true },
        { text: locale === 'ar' ? 'صلاحيات Root كاملة' : 'Full Root Access', included: true },
        { text: locale === 'ar' ? 'عنوان IPv4 مخصص' : 'Dedicated IPv4', included: true },
        { text: locale === 'ar' ? 'لوحة تحكم مجانية' : 'Free Control Panel', included: true },
        { text: locale === 'ar' ? 'دعم أولوية VIP 24/7' : 'VIP Priority 24/7 Support', included: true },
      ],
      popular: false,
      color: 'blue',
      pid: 68,
      link: 'https://app.progineous.com/cart.php?a=add&pid=68'
    }
  ];

  const faqs = [
    { question: locale === 'ar' ? 'ما هو VPS؟' : 'What is a VPS?',
      answer: locale === 'ar' ? 'VPS (الخادم الافتراضي الخاص) هو خادم افتراضي يعمل على خادم فعلي مشترك، لكنه يوفر لك موارد مخصصة (CPU, RAM, Storage) وصلاحيات root كاملة كما لو كان خادماً خاصاً بك.' : 'A VPS (Virtual Private Server) is a virtual server running on a shared physical server, but it provides you with dedicated resources (CPU, RAM, Storage) and full root access as if it were your own private server.' },
    { question: locale === 'ar' ? 'متى أحتاج VPS بدلاً من الاستضافة المشتركة؟' : 'When do I need VPS instead of Shared Hosting?',
      answer: locale === 'ar' ? 'تحتاج VPS عندما يتجاوز موقعك موارد الاستضافة المشتركة، أو تحتاج صلاحيات root، أو تريد تثبيت برامج خاصة، أو تحتاج أماناً وأداءً أعلى.' : 'You need VPS when your site exceeds shared hosting resources, you need root access, want to install custom software, or need higher security and performance.' },
    { question: locale === 'ar' ? 'هل يمكنني ترقية خطتي لاحقاً؟' : 'Can I upgrade my plan later?',
      answer: locale === 'ar' ? 'نعم! يمكنك ترقية خطة VPS الخاصة بك في أي وقت بسهولة من خلال لوحة التحكم أو بالتواصل مع الدعم الفني.' : 'Yes! You can easily upgrade your VPS plan anytime through the control panel or by contacting our support team.' },
    { question: locale === 'ar' ? 'ما نظام التشغيل المتاح؟' : 'What operating systems are available?',
      answer: locale === 'ar' ? 'نوفر مجموعة واسعة من أنظمة التشغيل تشمل Ubuntu, CentOS, Debian, AlmaLinux, Rocky Linux, وWindows Server.' : 'We offer a wide range of operating systems including Ubuntu, CentOS, Debian, AlmaLinux, Rocky Linux, and Windows Server.' },
    { question: locale === 'ar' ? 'هل تقدمون دعماً مُداراً؟' : 'Do you offer managed support?',
      answer: locale === 'ar' ? 'نعم، نقدم خدمات الإدارة الكاملة كخيار إضافي تشمل التحديثات والأمان والنسخ الاحتياطي والمراقبة على مدار الساعة.' : 'Yes, we offer fully managed services as an add-on including updates, security, backups, and 24/7 monitoring.' },
  ];

  const stats = [
    { value: '99.9%', label: locale === 'ar' ? 'ضمان التشغيل' : 'Uptime SLA' },
    { value: 'NVMe', label: locale === 'ar' ? 'تخزين فائق السرعة' : 'Ultra-Fast Storage' },
    { value: '24/7', label: locale === 'ar' ? 'دعم متخصص' : 'Expert Support' },
    { value: 'Root', label: locale === 'ar' ? 'صلاحيات كاملة' : 'Full Access' },
  ];

  // JSON-LD Structured Data for SEO
  const structuredData = {
    '@context': 'https://schema.org',
    '@type': 'Product',
    name: locale === 'ar' ? 'سيرفرات VPS الافتراضية' : 'Virtual Private Servers (VPS)',
    description: locale === 'ar' 
      ? 'خوادم VPS افتراضية بصلاحيات Root كاملة، موارد مخصصة، وأداء فائق مع NVMe SSD'
      : 'Virtual Private Servers with full Root access, dedicated resources, and superior performance with NVMe SSD',
    image: 'https://progineous.com/og-vps-hosting.png',
    url: `https://progineous.com/${locale}/hosting/vps`,
    brand: {
      '@type': 'Brand',
      name: 'Pro Gineous'
    },
    offers: {
      '@type': 'AggregateOffer',
      lowPrice: '15',
      highPrice: '85',
      priceCurrency: 'USD',
      offerCount: '4',
      offers: plans.map(plan => ({
        '@type': 'Offer',
        name: plan.name,
        description: plan.description,
        price: plan.monthlyPrice,
        priceCurrency: 'USD',
        priceValidUntil: '2026-12-31',
        availability: 'https://schema.org/InStock',
        url: plan.link
      }))
    },
    aggregateRating: {
      '@type': 'AggregateRating',
      ratingValue: '4.9',
      reviewCount: '1256',
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
        name: locale === 'ar' ? 'سيرفرات VPS' : 'VPS Servers',
        item: `https://progineous.com/${locale}/hosting/vps`
      }
    ]
  };

  return (
    <div className="min-h-screen bg-white">
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

      {/* Hero Section - VPS Unique Style with Terminal */}
      <section className="relative overflow-hidden bg-slate-950 py-20 lg:py-28">
        {/* Animated Grid Background */}
        <div className="absolute inset-0">
          <div className="absolute inset-0 bg-[linear-gradient(to_right,#1e293b_1px,transparent_1px),linear-gradient(to_bottom,#1e293b_1px,transparent_1px)] bg-size-[4rem_4rem]"></div>
          <div className="absolute inset-0 bg-linear-to-t from-slate-950 via-transparent to-slate-950"></div>
        </div>
        
        {/* Glowing Orbs */}
        <div className="absolute top-20 ltr:left-20 rtl:right-20 w-72 h-72 bg-blue-500/20 rounded-full blur-[100px] animate-pulse"></div>
        <div className="absolute bottom-20 ltr:right-20 rtl:left-20 w-96 h-96 bg-cyan-500/20 rounded-full blur-[120px] animate-pulse delay-1000"></div>
        
        <div className="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="grid lg:grid-cols-2 gap-12 items-center">
            {/* Left Content */}
            <div className="text-center lg:text-start">
              <div className="mb-6 inline-flex items-center gap-2 rounded-full border border-blue-500/30 bg-blue-500/10 px-4 py-2 backdrop-blur-sm">
                <span className="relative flex h-2 w-2">
                  <span className="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                  <span className="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                </span>
                <span className="text-sm font-medium text-blue-300">
                  {locale === 'ar' ? 'خوادم جاهزة للنشر' : 'Servers Ready to Deploy'}
                </span>
              </div>
              
              <h1 className="text-4xl font-extrabold text-white sm:text-5xl lg:text-6xl">
                {locale === 'ar' ? 'خوادم' : 'Virtual'}
                <span className="block bg-linear-to-r from-blue-400 via-cyan-400 to-teal-400 bg-clip-text text-transparent">
                  {locale === 'ar' ? 'VPS الافتراضية' : 'Private Servers'}
                </span>
              </h1>
              
              <p className="mt-6 text-lg text-slate-400 max-w-xl">
                {locale === 'ar'
                  ? 'تحكم كامل مع صلاحيات Root، موارد مخصصة، وأداء فائق. انشر خادمك في دقائق.'
                  : 'Full control with Root access, dedicated resources, and superior performance. Deploy your server in minutes.'}
              </p>
              
              {/* Stats Row */}
              <div className="mt-8 grid grid-cols-4 gap-4">
                {stats.map((stat, index) => (
                  <div key={index} className="text-center lg:text-start">
                    <div className="text-2xl font-bold text-white lg:text-3xl">{stat.value}</div>
                    <div className="text-xs text-slate-500">{stat.label}</div>
                  </div>
                ))}
              </div>
              
              {/* CTA Buttons */}
              <div className="mt-10 flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                <a href="#pricing" className="group inline-flex items-center justify-center gap-2 rounded-xl bg-linear-to-r from-blue-600 to-cyan-600 px-8 py-4 text-base font-semibold text-white shadow-lg shadow-blue-500/25 transition-all hover:shadow-xl hover:shadow-blue-500/40 hover:scale-105">
                  {locale === 'ar' ? 'ابدأ الآن' : 'Get Started'}
                  <ArrowRight className="h-5 w-5 rtl:rotate-180 transition-transform group-hover:translate-x-1 rtl:group-hover:-translate-x-1" />
                </a>
                <a href="#comparison" className="inline-flex items-center justify-center gap-2 rounded-xl border border-slate-700 bg-slate-800/50 px-8 py-4 text-base font-semibold text-white backdrop-blur-sm transition-all hover:bg-slate-800 hover:border-slate-600">
                  {locale === 'ar' ? 'قارن الخطط' : 'Compare Plans'}
                </a>
              </div>
            </div>
            
            {/* Right Content - Terminal */}
            <div className="relative hidden lg:block">
              <div className="relative rounded-2xl border border-slate-800 bg-slate-900/80 backdrop-blur-sm shadow-2xl overflow-hidden">
                {/* Terminal Header */}
                <div className="flex items-center gap-2 px-4 py-3 bg-slate-800/50 border-b border-slate-700">
                  <div className="flex gap-2">
                    <div className="w-3 h-3 rounded-full bg-red-500"></div>
                    <div className="w-3 h-3 rounded-full bg-yellow-500"></div>
                    <div className="w-3 h-3 rounded-full bg-green-500"></div>
                  </div>
                  <span className="text-slate-400 text-sm font-mono mx-auto">root@vps-server:~</span>
                </div>
                
                {/* Terminal Content */}
                <div className="p-6 font-mono text-sm space-y-3">
                  <div className="flex items-start gap-2">
                    <span className="text-green-400">$</span>
                    <span className="text-slate-300">ssh root@your-vps.progineous.com</span>
                  </div>
                  <div className="text-slate-500">Connected to VPS Server...</div>
                  <div className="flex items-start gap-2">
                    <span className="text-green-400">root@vps:~#</span>
                    <span className="text-slate-300">neofetch</span>
                  </div>
                  <div className="mt-4 grid grid-cols-2 gap-x-8 gap-y-1 text-xs">
                    <div className="text-cyan-400">OS:</div>
                    <div className="text-slate-400">Ubuntu 24.04 LTS</div>
                    <div className="text-cyan-400">CPU:</div>
                    <div className="text-slate-400">Intel Xeon @ 3.5GHz</div>
                    <div className="text-cyan-400">RAM:</div>
                    <div className="text-slate-400">2GB - 16GB DDR4</div>
                    <div className="text-cyan-400">Storage:</div>
                    <div className="text-slate-400">NVMe SSD</div>
                    <div className="text-cyan-400">Network:</div>
                    <div className="text-slate-400">1Gbps Port</div>
                    <div className="text-cyan-400">Uptime:</div>
                    <div className="text-slate-400">99.9% SLA</div>
                  </div>
                  <div className="flex items-start gap-2 mt-4">
                    <span className="text-green-400">root@vps:~#</span>
                    <span className="text-slate-300 animate-pulse">_</span>
                  </div>
                </div>
              </div>
              
              {/* Floating Badges */}
              <div className="absolute -top-4 -right-4 px-4 py-2 rounded-full bg-linear-to-r from-green-500 to-emerald-500 text-white text-sm font-bold shadow-lg">
                {locale === 'ar' ? 'نشر فوري' : 'Instant Deploy'}
              </div>
              <div className="absolute -bottom-4 -left-4 px-4 py-2 rounded-xl bg-slate-800 border border-slate-700 text-slate-300 text-sm font-medium shadow-lg">
                <span className="text-blue-400">$15</span>/mo {locale === 'ar' ? 'يبدأ من' : 'Starting at'}
              </div>
            </div>
          </div>
        </div>
        
        {/* Bottom Wave */}
        <div className="absolute bottom-0 left-0 right-0">
          <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg" className="w-full">
            <path d="M0 120L60 110C120 100 240 80 360 70C480 60 600 60 720 65C840 70 960 80 1080 85C1200 90 1320 90 1380 90L1440 90V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0Z" fill="white"/>
          </svg>
        </div>
      </section>

      {/* All Plans Include Section - Modern Light Style */}
      <section ref={allPlansRef} className="py-20 lg:py-28 bg-linear-to-b from-white to-gray-50 overflow-hidden relative">
        <div className="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="text-center mb-16 all-plans-title">
            <span className="inline-flex items-center gap-2 rounded-full bg-blue-100 px-4 py-2 text-sm font-medium text-blue-700 mb-4">
              <Check className="h-4 w-4" />
              {locale === 'ar' ? 'مميزات أساسية' : 'Core Features'}
            </span>
            <h2 className="text-3xl font-bold text-gray-900 sm:text-4xl lg:text-5xl">
              {locale === 'ar' ? 'جميع الخطط تشمل' : 'All Plans Include'}
            </h2>
            <p className="mt-4 text-gray-600 max-w-2xl mx-auto">
              {locale === 'ar' ? 'احصل على هذه المميزات مع أي خطة VPS تختارها' : 'Get these features with any VPS plan you choose'}
            </p>
          </div>
          
          <div className="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            {/* Feature 1 - Root Access (Large) */}
            <div className="col-span-2 row-span-2 group relative rounded-3xl bg-linear-to-br from-blue-600 to-cyan-600 p-8 overflow-hidden shadow-xl">
              <div className="absolute inset-0 bg-black/10 opacity-0 group-hover:opacity-100 transition-opacity"></div>
              <div className="relative z-10">
                <div className="w-16 h-16 rounded-2xl bg-white/20 backdrop-blur-sm flex items-center justify-center mb-6">
                  <Terminal className="h-8 w-8 text-white" />
                </div>
                <h3 className="text-2xl font-bold text-white mb-3">{locale === 'ar' ? 'صلاحيات Root كاملة' : 'Full Root Access'}</h3>
                <p className="text-white/80 text-base leading-relaxed">{locale === 'ar' ? 'تحكم كامل في خادمك. ثبّت أي برنامج، عدّل أي إعداد، واستخدم SSH بحرية تامة.' : 'Complete control over your server. Install any software, modify any setting, and use SSH with full freedom.'}</p>
                <div className="flex flex-wrap items-center gap-2 mt-6">
                  <span className="px-4 py-2 rounded-full bg-white/20 backdrop-blur-sm text-white text-sm font-medium">SSH</span>
                  <span className="px-4 py-2 rounded-full bg-white/20 backdrop-blur-sm text-white text-sm font-medium">sudo</span>
                  <span className="px-4 py-2 rounded-full bg-white/20 backdrop-blur-sm text-white text-sm font-medium">SFTP</span>
                </div>
              </div>
              {/* Decorative */}
              <div className="absolute -bottom-10 -right-10 w-40 h-40 bg-white/10 rounded-full blur-2xl"></div>
            </div>
            
            {/* Feature 2 - NVMe Storage */}
            <div className="group rounded-2xl bg-white border border-gray-200 p-6 hover:shadow-xl hover:border-blue-300 transition-all duration-300">
              <div className="w-12 h-12 rounded-xl bg-linear-to-br from-blue-500 to-blue-600 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform shadow-lg shadow-blue-500/25">
                <HardDrive className="h-6 w-6 text-white" />
              </div>
              <h4 className="font-bold text-gray-900 text-lg mb-1">{locale === 'ar' ? 'تخزين NVMe' : 'NVMe Storage'}</h4>
              <p className="text-gray-500 text-sm">{locale === 'ar' ? 'أسرع 10x من SSD' : '10x Faster than SSD'}</p>
            </div>
            
            {/* Feature 3 - DDoS Protection */}
            <div className="group rounded-2xl bg-white border border-gray-200 p-6 hover:shadow-xl hover:border-red-300 transition-all duration-300">
              <div className="w-12 h-12 rounded-xl bg-linear-to-br from-red-500 to-orange-500 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform shadow-lg shadow-red-500/25">
                <Shield className="h-6 w-6 text-white" />
              </div>
              <h4 className="font-bold text-gray-900 text-lg mb-1">{locale === 'ar' ? 'حماية DDoS' : 'DDoS Protection'}</h4>
              <p className="text-gray-500 text-sm">{locale === 'ar' ? 'حماية متقدمة' : 'Advanced Protection'}</p>
            </div>
            
            {/* Feature 4 - Dedicated IP */}
            <div className="group rounded-2xl bg-white border border-gray-200 p-6 hover:shadow-xl hover:border-green-300 transition-all duration-300">
              <div className="w-12 h-12 rounded-xl bg-linear-to-br from-green-500 to-emerald-500 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform shadow-lg shadow-green-500/25">
                <Network className="h-6 w-6 text-white" />
              </div>
              <h4 className="font-bold text-gray-900 text-lg mb-1">{locale === 'ar' ? 'IPv4 مخصص' : 'Dedicated IPv4'}</h4>
              <p className="text-gray-500 text-sm">{locale === 'ar' ? 'عنوان IP خاص بك' : 'Your Own IP Address'}</p>
            </div>
            
            {/* Feature 5 - Control Panel */}
            <div className="group rounded-2xl bg-white border border-gray-200 p-6 hover:shadow-xl hover:border-purple-300 transition-all duration-300">
              <div className="w-12 h-12 rounded-xl bg-linear-to-br from-purple-500 to-pink-500 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform shadow-lg shadow-purple-500/25">
                <Settings className="h-6 w-6 text-white" />
              </div>
              <h4 className="font-bold text-gray-900 text-lg mb-1">{locale === 'ar' ? 'لوحة تحكم' : 'Control Panel'}</h4>
              <p className="text-gray-500 text-sm">{locale === 'ar' ? 'إدارة سهلة' : 'Easy Management'}</p>
            </div>
            
            {/* Feature 6 - Instant Reinstall (Medium) */}
            <div className="col-span-2 group rounded-2xl bg-white border border-gray-200 p-6 hover:shadow-xl hover:border-cyan-300 transition-all duration-300">
              <div className="flex items-start gap-4">
                <div className="w-14 h-14 rounded-xl bg-linear-to-br from-cyan-500 to-teal-500 flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform shadow-lg shadow-cyan-500/25">
                  <RefreshCw className="h-7 w-7 text-white" />
                </div>
                <div>
                  <h4 className="font-bold text-gray-900 text-lg mb-1">{locale === 'ar' ? 'إعادة تثبيت فوري' : 'Instant OS Reinstall'}</h4>
                  <p className="text-gray-500 text-sm">{locale === 'ar' ? 'أعد تثبيت نظام التشغيل في دقائق. اختر من Ubuntu, CentOS, Debian, Windows والمزيد.' : 'Reinstall your OS in minutes. Choose from Ubuntu, CentOS, Debian, Windows & more.'}</p>
                </div>
              </div>
            </div>
            
            {/* Feature 7 - 24/7 Support */}
            <div className="group rounded-2xl bg-white border border-gray-200 p-6 hover:shadow-xl hover:border-amber-300 transition-all duration-300">
              <div className="w-12 h-12 rounded-xl bg-linear-to-br from-amber-500 to-yellow-500 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform shadow-lg shadow-amber-500/25">
                <Headphones className="h-6 w-6 text-white" />
              </div>
              <h4 className="font-bold text-gray-900 text-lg mb-1">{locale === 'ar' ? 'دعم 24/7' : '24/7 Support'}</h4>
              <p className="text-gray-500 text-sm">{locale === 'ar' ? 'دعم متخصص' : 'Expert Support'}</p>
            </div>
            
            {/* Feature 8 - 99.9% Uptime */}
            <div className="group rounded-2xl bg-white border border-gray-200 p-6 hover:shadow-xl hover:border-indigo-300 transition-all duration-300">
              <div className="w-12 h-12 rounded-xl bg-linear-to-br from-indigo-500 to-blue-500 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform shadow-lg shadow-indigo-500/25">
                <Activity className="h-6 w-6 text-white" />
              </div>
              <h4 className="font-bold text-gray-900 text-lg mb-1">{locale === 'ar' ? 'ضمان 99.9%' : '99.9% Uptime'}</h4>
              <p className="text-gray-500 text-sm">{locale === 'ar' ? 'موثوقية عالية' : 'High Reliability'}</p>
            </div>
          </div>
        </div>
      </section>

      {/* Why Choose Section - Modern Bento Grid */}
      <section className="py-20 lg:py-28 bg-linear-to-b from-gray-50 via-white to-gray-50 overflow-hidden">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          {/* Header */}
          <div className="text-center mb-16">
            <div className="inline-flex items-center gap-2 rounded-full bg-linear-to-r from-blue-500/10 to-cyan-500/10 border border-blue-200 px-5 py-2.5 text-sm font-semibold text-blue-700 mb-6">
              <Sparkles className="h-4 w-4" />
              {locale === 'ar' ? 'لماذا VPS؟' : 'Why VPS?'}
            </div>
            <h2 className="text-4xl font-bold text-gray-900 sm:text-5xl lg:text-6xl mb-4">
              {locale === 'ar' ? 'لماذا تختار استضافة' : 'Why Choose'}
              <span className="bg-linear-to-r from-blue-600 to-cyan-600 bg-clip-text text-transparent"> VPS</span>
              {locale === 'ar' ? '؟' : ' Hosting?'}
            </h2>
            <p className="text-xl text-gray-600 max-w-2xl mx-auto">
              {locale === 'ar' 
                ? 'قوة الخوادم المخصصة بتكلفة معقولة'
                : 'The power of dedicated servers at an affordable price'}
            </p>
          </div>

          {/* Bento Grid Layout */}
          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            
            {/* Card 1 - Dedicated Resources (Large) */}
            <div className="lg:col-span-2 group relative rounded-3xl bg-linear-to-br from-blue-600 to-blue-700 p-8 lg:p-10 overflow-hidden">
              {/* Background Pattern */}
              <div className="absolute inset-0 opacity-10">
                <div className="absolute top-0 right-0 w-96 h-96 bg-white rounded-full blur-3xl transform translate-x-1/2 -translate-y-1/2"></div>
                <div className="absolute bottom-0 left-0 w-64 h-64 bg-cyan-300 rounded-full blur-3xl transform -translate-x-1/2 translate-y-1/2"></div>
              </div>
              
              <div className="relative z-10 flex flex-col lg:flex-row items-start lg:items-center gap-8">
                <div className="flex-1">
                  <div className="inline-flex items-center gap-2 rounded-full bg-white/20 backdrop-blur-sm px-4 py-2 text-sm font-medium text-white mb-4">
                    <Cpu className="h-4 w-4" />
                    {locale === 'ar' ? 'الميزة الرئيسية' : 'Main Feature'}
                  </div>
                  <h3 className="text-3xl lg:text-4xl font-bold text-white mb-4">
                    {locale === 'ar' ? 'موارد مخصصة 100%' : '100% Dedicated Resources'}
                  </h3>
                  <p className="text-blue-100 text-lg leading-relaxed mb-6">
                    {locale === 'ar'
                      ? 'موارد CPU و RAM مخصصة لك وحدك. لا تتأثر بالمواقع الأخرى على نفس الخادم، مما يضمن أداءً ثابتاً على مدار الساعة.'
                      : 'CPU and RAM resources dedicated exclusively to you. Unaffected by other sites on the same server, ensuring consistent performance 24/7.'}
                  </p>
                  <div className="flex flex-wrap gap-3">
                    <span className="px-4 py-2 rounded-full bg-white/20 backdrop-blur-sm text-white text-sm font-medium">
                      {locale === 'ar' ? 'أداء ثابت' : 'Consistent Performance'}
                    </span>
                    <span className="px-4 py-2 rounded-full bg-white/20 backdrop-blur-sm text-white text-sm font-medium">
                      {locale === 'ar' ? 'بدون مشاركة' : 'No Sharing'}
                    </span>
                  </div>
                </div>
                
                {/* 3D-like Stats Display */}
                <div className="shrink-0 w-full lg:w-auto">
                  <div className="grid grid-cols-2 gap-4">
                    <div className="bg-white/10 backdrop-blur-sm rounded-2xl p-5 text-center border border-white/20">
                      <div className="text-3xl font-bold text-white mb-1">8</div>
                      <div className="text-blue-200 text-sm">vCPU Cores</div>
                    </div>
                    <div className="bg-white/10 backdrop-blur-sm rounded-2xl p-5 text-center border border-white/20">
                      <div className="text-3xl font-bold text-white mb-1">16GB</div>
                      <div className="text-blue-200 text-sm">RAM</div>
                    </div>
                    <div className="bg-white/10 backdrop-blur-sm rounded-2xl p-5 text-center border border-white/20">
                      <div className="text-3xl font-bold text-white mb-1">200GB</div>
                      <div className="text-blue-200 text-sm">NVMe SSD</div>
                    </div>
                    <div className="bg-white/10 backdrop-blur-sm rounded-2xl p-5 text-center border border-white/20">
                      <div className="text-3xl font-bold text-white mb-1">∞</div>
                      <div className="text-blue-200 text-sm">Bandwidth</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            {/* Card 2 - Full Control */}
            <div className="group relative rounded-3xl bg-white border border-gray-200 p-8 hover:border-blue-300 hover:shadow-2xl hover:shadow-blue-500/10 transition-all duration-500 overflow-hidden">
              <div className="absolute top-0 right-0 w-32 h-32 bg-linear-to-br from-blue-500/10 to-cyan-500/10 rounded-full blur-2xl transform translate-x-1/2 -translate-y-1/2 group-hover:scale-150 transition-transform duration-500"></div>
              
              <div className="relative z-10">
                <div className="w-14 h-14 rounded-2xl bg-linear-to-br from-slate-800 to-slate-900 flex items-center justify-center mb-6 shadow-lg group-hover:scale-110 transition-transform duration-300">
                  <Terminal className="h-7 w-7 text-green-400" />
                </div>
                <h3 className="text-2xl font-bold text-gray-900 mb-3">
                  {locale === 'ar' ? 'تحكم كامل' : 'Full Root Access'}
                </h3>
                <p className="text-gray-600 leading-relaxed mb-5">
                  {locale === 'ar'
                    ? 'صلاحيات root كاملة لتثبيت أي برنامج وتخصيص الإعدادات بحرية.'
                    : 'Full root privileges to install any software and customize settings freely.'}
                </p>
                
                {/* Terminal Preview */}
                <div className="bg-slate-900 rounded-xl p-4 font-mono text-sm">
                  <div className="flex items-center gap-2 mb-3">
                    <div className="w-3 h-3 rounded-full bg-red-500"></div>
                    <div className="w-3 h-3 rounded-full bg-yellow-500"></div>
                    <div className="w-3 h-3 rounded-full bg-green-500"></div>
                  </div>
                  <div className="text-green-400">
                    <span className="text-gray-500">$</span> sudo apt install nginx
                  </div>
                  <div className="text-gray-400 mt-1">
                    <span className="text-cyan-400">✓</span> nginx installed successfully
                  </div>
                </div>
              </div>
            </div>

            {/* Card 3 - Security */}
            <div className="group relative rounded-3xl bg-white border border-gray-200 p-8 hover:border-sky-300 hover:shadow-2xl hover:shadow-sky-500/10 transition-all duration-500 overflow-hidden">
              <div className="absolute top-0 right-0 w-32 h-32 bg-linear-to-br from-sky-500/10 to-blue-500/10 rounded-full blur-2xl transform translate-x-1/2 -translate-y-1/2 group-hover:scale-150 transition-transform duration-500"></div>
              
              <div className="relative z-10">
                <div className="w-14 h-14 rounded-2xl bg-linear-to-br from-sky-500 to-blue-600 flex items-center justify-center mb-6 shadow-lg shadow-sky-500/25 group-hover:scale-110 transition-transform duration-300">
                  <Shield className="h-7 w-7 text-white" />
                </div>
                <h3 className="text-2xl font-bold text-gray-900 mb-3">
                  {locale === 'ar' ? 'أمان معزول' : 'Isolated Security'}
                </h3>
                <p className="text-gray-600 leading-relaxed mb-5">
                  {locale === 'ar'
                    ? 'بيئة معزولة تماماً توفر أماناً أعلى لبياناتك وتطبيقاتك.'
                    : 'Completely isolated environment providing higher security for your data.'}
                </p>
                
                {/* Security Features */}
                <div className="space-y-3">
                  <div className="flex items-center gap-3">
                    <div className="w-8 h-8 rounded-lg bg-sky-100 flex items-center justify-center">
                      <Check className="h-4 w-4 text-sky-600" />
                    </div>
                    <span className="text-gray-700 text-sm font-medium">{locale === 'ar' ? 'عزل كامل' : 'Full Isolation'}</span>
                  </div>
                  <div className="flex items-center gap-3">
                    <div className="w-8 h-8 rounded-lg bg-sky-100 flex items-center justify-center">
                      <Check className="h-4 w-4 text-sky-600" />
                    </div>
                    <span className="text-gray-700 text-sm font-medium">{locale === 'ar' ? 'جدار حماية متقدم' : 'Advanced Firewall'}</span>
                  </div>
                  <div className="flex items-center gap-3">
                    <div className="w-8 h-8 rounded-lg bg-sky-100 flex items-center justify-center">
                      <Check className="h-4 w-4 text-sky-600" />
                    </div>
                    <span className="text-gray-700 text-sm font-medium">{locale === 'ar' ? 'حماية DDoS' : 'DDoS Protection'}</span>
                  </div>
                </div>
              </div>
            </div>

            {/* Card 4 - Scalability */}
            <div className="group relative rounded-3xl bg-white border border-gray-200 p-8 hover:border-cyan-300 hover:shadow-2xl hover:shadow-cyan-500/10 transition-all duration-500 overflow-hidden">
              <div className="absolute top-0 right-0 w-32 h-32 bg-linear-to-br from-cyan-500/10 to-teal-500/10 rounded-full blur-2xl transform translate-x-1/2 -translate-y-1/2 group-hover:scale-150 transition-transform duration-500"></div>
              
              <div className="relative z-10">
                <div className="w-14 h-14 rounded-2xl bg-linear-to-br from-cyan-500 to-teal-600 flex items-center justify-center mb-6 shadow-lg shadow-cyan-500/25 group-hover:scale-110 transition-transform duration-300">
                  <Activity className="h-7 w-7 text-white" />
                </div>
                <h3 className="text-2xl font-bold text-gray-900 mb-3">
                  {locale === 'ar' ? 'قابلية التوسع' : 'Easy Scalability'}
                </h3>
                <p className="text-gray-600 leading-relaxed mb-5">
                  {locale === 'ar'
                    ? 'قم بترقية مواردك بسهولة مع نمو مشروعك دون توقف.'
                    : 'Easily upgrade your resources as your project grows without downtime.'}
                </p>
                
                {/* Scalability Visual */}
                <div className="flex items-end gap-2 h-16">
                  <div className="w-8 h-4 rounded bg-cyan-200 group-hover:h-8 transition-all duration-500"></div>
                  <div className="w-8 h-6 rounded bg-cyan-300 group-hover:h-10 transition-all duration-500 delay-75"></div>
                  <div className="w-8 h-8 rounded bg-cyan-400 group-hover:h-12 transition-all duration-500 delay-100"></div>
                  <div className="w-8 h-10 rounded bg-cyan-500 group-hover:h-14 transition-all duration-500 delay-150"></div>
                  <div className="w-8 h-12 rounded bg-cyan-600 group-hover:h-16 transition-all duration-500 delay-200"></div>
                </div>
              </div>
            </div>

            {/* Card 5 - 24/7 Support */}
            <div className="group relative rounded-3xl bg-white border border-gray-200 p-8 hover:border-green-300 hover:shadow-2xl hover:shadow-green-500/10 transition-all duration-500 overflow-hidden">
              <div className="absolute top-0 right-0 w-32 h-32 bg-linear-to-br from-green-500/10 to-emerald-500/10 rounded-full blur-2xl transform translate-x-1/2 -translate-y-1/2 group-hover:scale-150 transition-transform duration-500"></div>
              
              <div className="relative z-10">
                <div className="w-14 h-14 rounded-2xl bg-linear-to-br from-green-500 to-emerald-600 flex items-center justify-center mb-6 shadow-lg shadow-green-500/25 group-hover:scale-110 transition-transform duration-300">
                  <Headphones className="h-7 w-7 text-white" />
                </div>
                <h3 className="text-2xl font-bold text-gray-900 mb-3">
                  {locale === 'ar' ? 'دعم على مدار الساعة' : '24/7 Expert Support'}
                </h3>
                <p className="text-gray-600 leading-relaxed mb-5">
                  {locale === 'ar'
                    ? 'فريق دعم متخصص جاهز لمساعدتك في أي وقت.'
                    : 'Expert support team ready to help you anytime.'}
                </p>
                
                {/* Support Visual */}
                <div className="flex items-center gap-4">
                  <div className="flex -space-x-3">
                    <div className="w-10 h-10 rounded-full bg-linear-to-br from-green-400 to-green-500 flex items-center justify-center text-white text-sm font-bold border-2 border-white">A</div>
                    <div className="w-10 h-10 rounded-full bg-linear-to-br from-blue-400 to-blue-500 flex items-center justify-center text-white text-sm font-bold border-2 border-white">M</div>
                    <div className="w-10 h-10 rounded-full bg-linear-to-br from-cyan-400 to-cyan-500 flex items-center justify-center text-white text-sm font-bold border-2 border-white">S</div>
                  </div>
                  <div>
                    <div className="text-sm font-semibold text-gray-900">{locale === 'ar' ? 'متوسط الرد' : 'Avg Response'}</div>
                    <div className="text-green-600 font-bold">&lt; 5 {locale === 'ar' ? 'دقائق' : 'minutes'}</div>
                  </div>
                </div>
              </div>
            </div>

            {/* Card 6 - Performance (Full Width) */}
            <div className="lg:col-span-3 group relative rounded-3xl bg-linear-to-br from-slate-900 to-slate-800 p-8 lg:p-10 overflow-hidden">
              {/* Background Effects */}
              <div className="absolute inset-0">
                <div className="absolute top-1/2 left-1/2 w-96 h-96 bg-blue-500/20 rounded-full blur-3xl transform -translate-x-1/2 -translate-y-1/2"></div>
                <div className="absolute top-0 right-0 w-64 h-64 bg-cyan-500/10 rounded-full blur-3xl"></div>
              </div>
              
              <div className="relative z-10 flex flex-col lg:flex-row items-center gap-8">
                {/* Performance Metrics */}
                <div className="shrink-0 grid grid-cols-2 gap-4 w-full lg:w-auto">
                  <div className="bg-white/5 backdrop-blur-sm rounded-2xl p-6 text-center border border-white/10 group-hover:border-blue-500/30 transition-colors">
                    <Zap className="h-8 w-8 text-yellow-400 mx-auto mb-3" />
                    <div className="text-2xl font-bold text-white mb-1">99.9%</div>
                    <div className="text-gray-400 text-sm">Uptime SLA</div>
                  </div>
                  <div className="bg-white/5 backdrop-blur-sm rounded-2xl p-6 text-center border border-white/10 group-hover:border-cyan-500/30 transition-colors">
                    <Gauge className="h-8 w-8 text-cyan-400 mx-auto mb-3" />
                    <div className="text-2xl font-bold text-white mb-1">&lt;10ms</div>
                    <div className="text-gray-400 text-sm">Network Latency</div>
                  </div>
                  <div className="bg-white/5 backdrop-blur-sm rounded-2xl p-6 text-center border border-white/10 group-hover:border-green-500/30 transition-colors">
                    <HardDrive className="h-8 w-8 text-green-400 mx-auto mb-3" />
                    <div className="text-2xl font-bold text-white mb-1">NVMe</div>
                    <div className="text-gray-400 text-sm">Fast Storage</div>
                  </div>
                  <div className="bg-white/5 backdrop-blur-sm rounded-2xl p-6 text-center border border-white/10 group-hover:border-blue-500/30 transition-colors">
                    <Globe className="h-8 w-8 text-blue-400 mx-auto mb-3" />
                    <div className="text-2xl font-bold text-white mb-1">10Gbps</div>
                    <div className="text-gray-400 text-sm">Network Speed</div>
                  </div>
                </div>
                
                <div className="flex-1 text-center lg:text-start">
                  <div className="inline-flex items-center gap-2 rounded-full bg-blue-500/20 px-4 py-2 text-sm font-medium text-blue-300 mb-4">
                    <Zap className="h-4 w-4" />
                    {locale === 'ar' ? 'أداء خارق' : 'Blazing Fast'}
                  </div>
                  <h3 className="text-3xl lg:text-4xl font-bold text-white mb-4">
                    {locale === 'ar' ? 'أداء بلا حدود' : 'Unlimited Performance'}
                  </h3>
                  <p className="text-gray-300 text-lg leading-relaxed">
                    {locale === 'ar'
                      ? 'خوادم مجهزة بأحدث معالجات AMD EPYC وأقراص NVMe فائقة السرعة، مع شبكة 10Gbps لضمان أفضل أداء لمشاريعك.'
                      : 'Servers equipped with latest AMD EPYC processors and ultra-fast NVMe SSDs, with 10Gbps network ensuring the best performance for your projects.'}
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      {/* Pricing Section - Modern Design */}
      <section id="pricing" ref={plansRef} className="py-20 lg:py-32 bg-linear-to-b from-slate-900 via-slate-900 to-slate-800 overflow-hidden relative">
        {/* Background Effects */}
        <div className="absolute inset-0">
          <div className="absolute top-0 left-1/4 w-96 h-96 bg-blue-500/20 rounded-full blur-3xl"></div>
          <div className="absolute bottom-0 right-1/4 w-96 h-96 bg-cyan-500/20 rounded-full blur-3xl"></div>
          <div className="absolute inset-0 bg-[linear-gradient(rgba(255,255,255,0.02)_1px,transparent_1px),linear-gradient(90deg,rgba(255,255,255,0.02)_1px,transparent_1px)] bg-size-[64px_64px]"></div>
        </div>

        <div className="relative z-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          {/* Header */}
          <div className="text-center mb-16">
            <div className="inline-flex items-center gap-2 rounded-full bg-blue-500/20 border border-blue-500/30 px-5 py-2.5 text-sm font-semibold text-blue-300 mb-6">
              <Server className="h-4 w-4" />
              {locale === 'ar' ? 'خطط VPS' : 'VPS Plans'}
            </div>
            <h2 className="text-4xl font-bold text-white sm:text-5xl lg:text-6xl mb-4">
              {locale === 'ar' ? 'اختر' : 'Choose Your'}
              <span className="bg-linear-to-r from-blue-400 to-cyan-400 bg-clip-text text-transparent"> {locale === 'ar' ? 'خطة VPS المناسبة' : 'Perfect VPS Plan'}</span>
            </h2>
            <p className="text-xl text-gray-400 max-w-2xl mx-auto">
              {locale === 'ar' ? 'خوادم VPS بأداء عالي وموارد مخصصة لمشروعك' : 'High-performance VPS servers with dedicated resources for your project'}
            </p>
            
            {/* Billing Toggle */}
            <div className="mt-10 inline-flex items-center gap-2 rounded-2xl bg-slate-800/80 backdrop-blur-sm p-2 border border-slate-700">
              <button
                onClick={() => setBillingPeriod('monthly')}
                className={cn(
                  "px-6 py-3 rounded-xl text-sm font-semibold transition-all duration-300",
                  billingPeriod === 'monthly' 
                    ? "bg-linear-to-r from-blue-500 to-cyan-500 text-white shadow-lg shadow-blue-500/25" 
                    : "text-gray-400 hover:text-white"
                )}
              >
                {locale === 'ar' ? 'شهري' : 'Monthly'}
              </button>
              <button
                onClick={() => setBillingPeriod('yearly')}
                className={cn(
                  "px-6 py-3 rounded-xl text-sm font-semibold transition-all duration-300",
                  billingPeriod === 'yearly' 
                    ? "bg-linear-to-r from-blue-500 to-cyan-500 text-white shadow-lg shadow-blue-500/25" 
                    : "text-gray-400 hover:text-white"
                )}
              >
                {locale === 'ar' ? 'سنوي' : 'Yearly'}
              </button>
            </div>
          </div>

          {/* Plans - Horizontal Layout */}
          <div className="space-y-6">
            {plans.map((plan, index) => (
              <div 
                key={plan.name} 
                ref={(el) => { planCardsRef.current[index] = el; }}
                className={cn(
                  "group relative rounded-3xl transition-all duration-500",
                  plan.popular 
                    ? "bg-linear-to-r from-blue-500 to-cyan-500 p-0.5" 
                    : "bg-linear-to-r from-slate-700/50 to-slate-800/50 p-px"
                )}
              >
                {/* Popular Badge */}
                {plan.popular && (
                  <div className="absolute -top-4 left-6 z-20">
                    <span className="inline-flex items-center gap-2 rounded-full bg-linear-to-r from-amber-400 to-orange-400 px-5 py-2 text-sm font-bold text-amber-900 shadow-lg shadow-amber-500/30">
                      <Star className="h-4 w-4 fill-current" /> 
                      {locale === 'ar' ? 'الأكثر طلباً' : 'Most Popular'}
                    </span>
                  </div>
                )}

                <div className={cn(
                  "rounded-3xl p-6 lg:p-8 transition-all duration-500",
                  plan.popular 
                    ? "bg-slate-900" 
                    : "bg-slate-800/80 backdrop-blur-sm group-hover:bg-slate-800"
                )}>
                  <div className="flex flex-col lg:flex-row lg:items-center gap-6 lg:gap-8">
                    
                    {/* Plan Name & Description */}
                    <div className="flex items-center gap-4 lg:w-64 shrink-0">
                      <div className={cn(
                        "flex items-center justify-center w-14 h-14 rounded-2xl transition-transform duration-300 group-hover:scale-110",
                        plan.popular 
                          ? "bg-linear-to-br from-blue-500 to-cyan-500 shadow-lg shadow-blue-500/30" 
                          : "bg-slate-700"
                      )}>
                        <Server className={cn("h-7 w-7", plan.popular ? "text-white" : "text-blue-400")} />
                      </div>
                      <div>
                        <h3 className="text-xl font-bold text-white">{plan.name}</h3>
                        <p className="text-gray-400 text-sm">{plan.description}</p>
                      </div>
                    </div>

                    {/* Specs */}
                    <div className="flex flex-wrap items-center gap-3 lg:gap-4 flex-1">
                      <div className="flex items-center gap-2 bg-slate-900/50 rounded-xl px-4 py-2.5 border border-slate-700/50">
                        <Cpu className="h-5 w-5 text-blue-400" />
                        <span className="text-white font-bold">
                          {index === 0 ? '1' : index === 1 ? '2' : index === 2 ? '4' : '8'} vCPU
                        </span>
                      </div>
                      <div className="flex items-center gap-2 bg-slate-900/50 rounded-xl px-4 py-2.5 border border-slate-700/50">
                        <Database className="h-5 w-5 text-cyan-400" />
                        <span className="text-white font-bold">
                          {index === 0 ? '2' : index === 1 ? '4' : index === 2 ? '8' : '16'} GB RAM
                        </span>
                      </div>
                      <div className="flex items-center gap-2 bg-slate-900/50 rounded-xl px-4 py-2.5 border border-slate-700/50">
                        <HardDrive className="h-5 w-5 text-green-400" />
                        <span className="text-white font-bold">
                          {index === 0 ? '50' : index === 1 ? '100' : '200'} GB NVMe
                        </span>
                      </div>
                      <div className="flex items-center gap-2 bg-slate-900/50 rounded-xl px-4 py-2.5 border border-slate-700/50">
                        <Globe className="h-5 w-5 text-purple-400" />
                        <span className="text-white font-bold">
                          {index < 2 ? '1TB BW' : '∞ BW'}
                        </span>
                      </div>
                    </div>

                    {/* Price & CTA */}
                    <div className="flex items-center gap-6 lg:shrink-0">
                      <div className="text-center lg:text-right">
                        <div className="flex items-baseline gap-1">
                          <span className="text-gray-400 text-lg">$</span>
                          <span 
                            ref={(el) => { priceRefs.current[index] = el; }} 
                            className={cn(
                              "text-4xl font-extrabold",
                              plan.popular 
                                ? "bg-linear-to-r from-blue-400 to-cyan-400 bg-clip-text text-transparent" 
                                : "text-white"
                            )}
                          >
                            {billingPeriod === 'yearly' ? (plan.yearlyPrice * 12).toFixed(0) : plan.monthlyPrice.toFixed(0)}
                          </span>
                          <span className="text-gray-400">{billingPeriod === 'yearly' ? '/yr' : '/mo'}</span>
                        </div>
                        <p className="text-gray-500 text-xs mt-1">
                          {billingPeriod === 'yearly' 
                            ? (locale === 'ar' ? `$${plan.yearlyPrice.toFixed(0)}/شهر` : `$${plan.yearlyPrice.toFixed(0)}/mo`)
                            : (locale === 'ar' ? 'شهرياً' : 'monthly')}
                        </p>
                      </div>
                      
                      <a 
                        href={`${plan.link}&billingcycle=${billingPeriod}`} 
                        target="_blank" 
                        rel="noopener noreferrer"
                        className={cn(
                          "group/btn flex items-center justify-center gap-2 rounded-xl px-6 py-3.5 font-semibold transition-all duration-300 whitespace-nowrap",
                          plan.popular 
                            ? "bg-linear-to-r from-blue-500 to-cyan-500 text-white hover:shadow-lg hover:shadow-blue-500/30 hover:scale-[1.02]" 
                            : "bg-slate-700 text-white hover:bg-slate-600"
                        )}
                      >
                        {locale === 'ar' ? 'اطلب الآن' : 'Get Started'}
                        <ArrowRight className="h-4 w-4 group-hover/btn:translate-x-1 transition-transform" />
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            ))}
          </div>

          {/* Trust Badges */}
          <div className="mt-16 flex flex-wrap items-center justify-center gap-8 text-gray-400">
            <div className="flex items-center gap-2">
              <Shield className="h-5 w-5 text-green-400" />
              <span className="text-sm">{locale === 'ar' ? 'ضمان استرداد 30 يوم' : '30-Day Money Back'}</span>
            </div>
            <div className="flex items-center gap-2">
              <Zap className="h-5 w-5 text-yellow-400" />
              <span className="text-sm">{locale === 'ar' ? 'تفعيل فوري' : 'Instant Setup'}</span>
            </div>
            <div className="flex items-center gap-2">
              <Headphones className="h-5 w-5 text-blue-400" />
              <span className="text-sm">{locale === 'ar' ? 'دعم 24/7' : '24/7 Support'}</span>
            </div>
            <div className="flex items-center gap-2">
              <Activity className="h-5 w-5 text-cyan-400" />
              <span className="text-sm">{locale === 'ar' ? '99.9% Uptime' : '99.9% Uptime SLA'}</span>
            </div>
          </div>
        </div>
      </section>

      {/* Comparison Table */}
      <section className="py-16 lg:py-24 bg-white">
        <div className="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
          <div className="text-center mb-12">
            <span className="inline-flex items-center gap-2 rounded-full bg-blue-100 px-4 py-2 text-sm font-semibold text-blue-700 mb-4">
              <Gauge className="h-4 w-4" />
              {locale === 'ar' ? 'مقارنة شاملة' : 'Full Comparison'}
            </span>
            <h2 className="text-3xl font-bold text-gray-900 sm:text-4xl lg:text-5xl">
              {locale === 'ar' ? 'قارن خطط VPS' : 'Compare VPS Plans'}
            </h2>
          </div>
          
          <div className="overflow-x-auto rounded-2xl border border-gray-200 shadow-lg">
            <table className="w-full text-sm">
              <thead>
                <tr className="bg-linear-to-r from-blue-600 to-blue-600 text-white">
                  <th className="px-4 py-4 text-start font-semibold">{locale === 'ar' ? 'المواصفات' : 'Specs'}</th>
                  <th className="px-4 py-4 text-center font-semibold">VPS 103</th>
                  <th className="px-4 py-4 text-center font-semibold bg-blue-700/50">
                    <div className="flex items-center justify-center gap-1">
                      <Star className="h-3 w-3 text-amber-300" />
                      VPS 102
                    </div>
                  </th>
                  <th className="px-4 py-4 text-center font-semibold">VPS 101</th>
                  <th className="px-4 py-4 text-center font-semibold">VPS 100</th>
                </tr>
              </thead>
              <tbody className="divide-y divide-gray-100">
                {/* Price */}
                <tr className="bg-blue-50">
                  <td className="px-4 py-3 font-semibold text-gray-900">{locale === 'ar' ? 'السعر الشهري' : 'Monthly Price'}</td>
                  <td className="px-4 py-3 text-center"><span className="text-xl font-bold text-blue-600">$15</span></td>
                  <td className="px-4 py-3 text-center bg-blue-100/50"><span className="text-xl font-bold text-blue-600">$30</span></td>
                  <td className="px-4 py-3 text-center"><span className="text-xl font-bold text-blue-600">$65</span></td>
                  <td className="px-4 py-3 text-center"><span className="text-xl font-bold text-blue-600">$85</span></td>
                </tr>
                {/* vCPU */}
                <tr className="bg-white">
                  <td className="px-4 py-3 font-medium text-gray-900 flex items-center gap-2">
                    <Cpu className="h-4 w-4 text-blue-500" />
                    vCPU Cores
                  </td>
                  <td className="px-4 py-3 text-center font-semibold text-gray-700">1</td>
                  <td className="px-4 py-3 text-center font-semibold text-gray-700 bg-blue-100/50">2</td>
                  <td className="px-4 py-3 text-center font-semibold text-gray-700">4</td>
                  <td className="px-4 py-3 text-center font-semibold text-gray-700">8</td>
                </tr>
                {/* RAM */}
                <tr className="bg-gray-50">
                  <td className="px-4 py-3 font-medium text-gray-900 flex items-center gap-2">
                    <Database className="h-4 w-4 text-blue-500" />
                    RAM
                  </td>
                  <td className="px-4 py-3 text-center font-semibold text-gray-700">2 GB</td>
                  <td className="px-4 py-3 text-center font-semibold text-gray-700 bg-blue-100/50">4 GB</td>
                  <td className="px-4 py-3 text-center font-semibold text-gray-700">8 GB</td>
                  <td className="px-4 py-3 text-center font-semibold text-gray-700">16 GB</td>
                </tr>
                {/* Storage */}
                <tr className="bg-white">
                  <td className="px-4 py-3 font-medium text-gray-900 flex items-center gap-2">
                    <HardDrive className="h-4 w-4 text-blue-500" />
                    NVMe Storage
                  </td>
                  <td className="px-4 py-3 text-center font-semibold text-gray-700">50 GB</td>
                  <td className="px-4 py-3 text-center font-semibold text-gray-700 bg-blue-100/50">100 GB</td>
                  <td className="px-4 py-3 text-center font-semibold text-gray-700">200 GB</td>
                  <td className="px-4 py-3 text-center font-semibold text-gray-700">200 GB</td>
                </tr>
                {/* Bandwidth */}
                <tr className="bg-gray-50">
                  <td className="px-4 py-3 font-medium text-gray-900 flex items-center gap-2">
                    <Activity className="h-4 w-4 text-blue-500" />
                    Bandwidth
                  </td>
                  <td className="px-4 py-3 text-center font-semibold text-gray-700">1 TB</td>
                  <td className="px-4 py-3 text-center font-semibold text-gray-700 bg-blue-100/50">1 TB</td>
                  <td className="px-4 py-3 text-center font-semibold text-gray-700">{locale === 'ar' ? 'غير محدود' : 'Unlimited'}</td>
                  <td className="px-4 py-3 text-center font-semibold text-gray-700">{locale === 'ar' ? 'غير محدود' : 'Unlimited'}</td>
                </tr>
                {/* Root Access */}
                <tr className="bg-white">
                  <td className="px-4 py-3 font-medium text-gray-900 flex items-center gap-2">
                    <Terminal className="h-4 w-4 text-blue-500" />
                    Root Access
                  </td>
                  <td className="px-4 py-3 text-center"><Check className="h-5 w-5 text-blue-500 mx-auto" /></td>
                  <td className="px-4 py-3 text-center bg-blue-100/50"><Check className="h-5 w-5 text-blue-500 mx-auto" /></td>
                  <td className="px-4 py-3 text-center"><Check className="h-5 w-5 text-blue-500 mx-auto" /></td>
                  <td className="px-4 py-3 text-center"><Check className="h-5 w-5 text-blue-500 mx-auto" /></td>
                </tr>
                {/* Dedicated IP */}
                <tr className="bg-gray-50">
                  <td className="px-4 py-3 font-medium text-gray-900 flex items-center gap-2">
                    <Network className="h-4 w-4 text-blue-500" />
                    Dedicated IPv4
                  </td>
                  <td className="px-4 py-3 text-center"><Check className="h-5 w-5 text-blue-500 mx-auto" /></td>
                  <td className="px-4 py-3 text-center bg-blue-100/50"><Check className="h-5 w-5 text-blue-500 mx-auto" /></td>
                  <td className="px-4 py-3 text-center"><Check className="h-5 w-5 text-blue-500 mx-auto" /></td>
                  <td className="px-4 py-3 text-center"><Check className="h-5 w-5 text-blue-500 mx-auto" /></td>
                </tr>
                {/* DDoS Protection */}
                <tr className="bg-white">
                  <td className="px-4 py-3 font-medium text-gray-900 flex items-center gap-2">
                    <Shield className="h-4 w-4 text-blue-500" />
                    DDoS Protection
                  </td>
                  <td className="px-4 py-3 text-center"><Check className="h-5 w-5 text-blue-500 mx-auto" /></td>
                  <td className="px-4 py-3 text-center bg-blue-100/50"><Check className="h-5 w-5 text-blue-500 mx-auto" /></td>
                  <td className="px-4 py-3 text-center"><Check className="h-5 w-5 text-blue-500 mx-auto" /></td>
                  <td className="px-4 py-3 text-center"><Check className="h-5 w-5 text-blue-500 mx-auto" /></td>
                </tr>
                {/* Support */}
                <tr className="bg-gray-50">
                  <td className="px-4 py-3 font-medium text-gray-900 flex items-center gap-2">
                    <Headphones className="h-4 w-4 text-blue-500" />
                    {locale === 'ar' ? 'الدعم' : 'Support'}
                  </td>
                  <td className="px-4 py-3 text-center text-xs font-medium text-gray-600">24/7</td>
                  <td className="px-4 py-3 text-center text-xs font-medium text-gray-600 bg-blue-100/50">24/7</td>
                  <td className="px-4 py-3 text-center text-xs font-medium text-blue-600">{locale === 'ar' ? 'أولوية' : 'Priority'}</td>
                  <td className="px-4 py-3 text-center text-xs font-medium text-blue-600">VIP</td>
                </tr>
              </tbody>
              <tfoot>
                <tr className="bg-gray-50">
                  <td className="px-4 py-4"></td>
                  <td className="px-4 py-4 text-center">
                    <a href="#" className="inline-flex items-center gap-1 rounded-full bg-blue-600 px-4 py-2 text-xs font-semibold text-white transition-all hover:bg-blue-700">
                      {locale === 'ar' ? 'اطلب' : 'Order'}
                    </a>
                  </td>
                  <td className="px-4 py-4 text-center bg-blue-100/50">
                    <a href="#" className="inline-flex items-center gap-1 rounded-full bg-blue-600 px-4 py-2 text-xs font-semibold text-white transition-all hover:bg-blue-700 shadow-lg">
                      {locale === 'ar' ? 'اطلب' : 'Order'}
                      <Star className="h-3 w-3" />
                    </a>
                  </td>
                  <td className="px-4 py-4 text-center">
                    <a href="#" className="inline-flex items-center gap-1 rounded-full bg-blue-600 px-4 py-2 text-xs font-semibold text-white transition-all hover:bg-blue-700">
                      {locale === 'ar' ? 'اطلب' : 'Order'}
                    </a>
                  </td>
                  <td className="px-4 py-4 text-center">
                    <a href="#" className="inline-flex items-center gap-1 rounded-full bg-blue-600 px-4 py-2 text-xs font-semibold text-white transition-all hover:bg-blue-700">
                      {locale === 'ar' ? 'اطلب' : 'Order'}
                    </a>
                  </td>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>
      </section>

      {/* FAQ Section */}
      <section className="py-16 lg:py-24 bg-linear-to-b from-gray-50 to-white relative overflow-hidden">
        <div className="absolute inset-0 overflow-hidden pointer-events-none">
          <div className="absolute top-20 ltr:left-10 rtl:right-10 w-72 h-72 bg-blue-500/5 rounded-full blur-3xl" />
          <div className="absolute bottom-20 ltr:right-10 rtl:left-10 w-96 h-96 bg-blue-500/5 rounded-full blur-3xl" />
        </div>
        <div className="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 relative z-10">
          <div className="text-center mb-12">
            <span className="inline-flex items-center gap-2 rounded-full bg-blue-100 px-4 py-2 text-sm font-semibold text-blue-700 mb-4">
              <Headphones className="h-4 w-4" />
              {locale === 'ar' ? 'مركز المساعدة' : 'Help Center'}
            </span>
            <h2 className="text-3xl font-bold text-gray-900 sm:text-4xl lg:text-5xl">
              {locale === 'ar' ? 'الأسئلة الشائعة' : 'VPS FAQs'}
            </h2>
          </div>
          <div className="space-y-4">
            {faqs.map((faq, index) => (
              <div key={index} className={cn("group rounded-2xl border-2 transition-all duration-300",
                openFaq === index ? "border-blue-500 bg-white shadow-lg shadow-blue-500/10" : "border-gray-200 bg-white hover:border-gray-300 hover:shadow-md")}>
                <button onClick={() => setOpenFaq(openFaq === index ? null : index)} className="flex w-full items-center justify-between px-6 py-5 text-start gap-4">
                  <div className="flex items-center gap-4">
                    <div className={cn("shrink-0 w-10 h-10 rounded-xl flex items-center justify-center text-sm font-bold transition-colors",
                      openFaq === index ? "bg-blue-500 text-white" : "bg-gray-100 text-gray-500 group-hover:bg-blue-100 group-hover:text-blue-600")}>
                      {String(index + 1).padStart(2, '0')}
                    </div>
                    <span className={cn("font-semibold text-lg transition-colors", openFaq === index ? "text-blue-600" : "text-gray-900")}>{faq.question}</span>
                  </div>
                  <div className={cn("shrink-0 w-10 h-10 rounded-full flex items-center justify-center transition-all",
                    openFaq === index ? "bg-blue-500 text-white rotate-180" : "bg-gray-100 text-gray-500 group-hover:bg-blue-100 group-hover:text-blue-600")}>
                    <ChevronDown className="h-5 w-5" />
                  </div>
                </button>
                <div className={cn("overflow-hidden transition-all duration-300", openFaq === index ? "max-h-96" : "max-h-0")}>
                  <div className="px-6 pb-6 ltr:pl-20 rtl:pr-20">
                    <div className="p-4 rounded-xl bg-linear-to-br from-gray-50 to-white border border-gray-100">
                      <p className="text-gray-600 leading-relaxed">{faq.answer}</p>
                    </div>
                  </div>
                </div>
              </div>
            ))}
          </div>
          <div className="mt-12 text-center">
            <p className="text-gray-600 mb-4">{locale === 'ar' ? 'لم تجد إجابة لسؤالك؟' : "Didn't find your answer?"}</p>
            <Link href="/contact" className="inline-flex items-center gap-2 rounded-full bg-blue-600 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-500/25 transition-all hover:bg-blue-700 hover:shadow-xl hover:scale-105">
              <Headphones className="h-4 w-4" />
              {locale === 'ar' ? 'تواصل مع الدعم' : 'Contact Support'}
              <ArrowRight className="h-4 w-4 rtl:rotate-180" />
            </Link>
          </div>
        </div>
      </section>

      {/* CTA Section */}
      <section className="py-16 lg:py-24">
        <div className="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
          <div className="rounded-3xl bg-linear-to-br from-blue-600 to-blue-700 px-8 py-16 lg:py-20 text-center">
            <h2 className="text-3xl font-bold text-white sm:text-4xl lg:text-5xl">
              {locale === 'ar' ? 'جاهز للبدء مع VPS؟' : 'Ready to Start with VPS?'}
            </h2>
            <p className="mx-auto mt-4 max-w-xl text-lg text-white/70">
              {locale === 'ar' ? 'احصل على خادمك الافتراضي الخاص الآن مع ضمان استرداد المال لمدة 30 يوم' : 'Get your virtual private server now with a 30-day money-back guarantee'}
            </p>
            <div className="mt-10 flex flex-col items-center justify-center gap-4 sm:flex-row">
              <a href="#pricing" className="inline-flex items-center gap-2 rounded-full bg-white px-8 py-4 text-base font-semibold text-blue-700 transition-all hover:bg-white/90 hover:scale-105">
                {locale === 'ar' ? 'ابدأ الآن بـ $15/شهر' : 'Start Now for $15/mo'}
                <ArrowRight className="h-5 w-5 rtl:rotate-180" />
              </a>
              <Link href="/contact" className="inline-flex items-center gap-2 rounded-full border border-white/30 px-8 py-4 text-base font-semibold text-white transition-all hover:bg-white/10">
                {locale === 'ar' ? 'تحدث مع المبيعات' : 'Talk to Sales'}
              </Link>
            </div>
          </div>
        </div>
      </section>
    </div>
  );
}


