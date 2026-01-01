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
  Activity
} from 'lucide-react';
import { cn } from '@/lib/utils';

// Register GSAP plugins
if (typeof window !== 'undefined') {
  gsap.registerPlugin(ScrollTrigger);
}

export default function CloudHostingPage() {
  const locale = useLocale();
  const [billingPeriod, setBillingPeriod] = useState<'monthly' | 'yearly'>('yearly');
  const [openFaq, setOpenFaq] = useState<number | null>(0);
  const [expandedPlans, setExpandedPlans] = useState<string[]>([]);
  const [expandedSections, setExpandedSections] = useState<string[]>(['storage', 'performance']);
  
  const plansRef = useRef<HTMLDivElement>(null);
  const planCardsRef = useRef<(HTMLDivElement | null)[]>([]);
  const priceRefs = useRef<(HTMLSpanElement | null)[]>([]);
  const tableRef = useRef<HTMLDivElement>(null);
  const allPlansRef = useRef<HTMLDivElement>(null);
  const featuresRef = useRef<HTMLDivElement>(null);
  const featureCardsRef = useRef<(HTMLDivElement | null)[]>([]);

  const toggleSection = (section: string) => {
    setExpandedSections(prev => 
      prev.includes(section) 
        ? prev.filter(s => s !== section)
        : [...prev, section]
    );
  };

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

  // GSAP Animation for price change
  useEffect(() => {
    const prices = priceRefs.current.filter(Boolean);
    gsap.fromTo(prices, { scale: 0.5, opacity: 0, y: 20 },
      { scale: 1, opacity: 1, y: 0, duration: 0.4, ease: 'back.out(1.7)', stagger: 0.1 }
    );
  }, [billingPeriod]);

  // PLACEHOLDER_PLANS

  const plans = [
    {
      name: 'Gen 103',
      description: locale === 'ar' ? 'مثالية للمشاريع الناشئة' : 'Perfect for startups',
      monthlyPrice: 6.00,
      yearlyPrice: 4.00,
      features: [
        { text: locale === 'ar' ? '🎁 دومين .COM مجاني للسنة الأولى' : '🎁 Free .COM domain 1st year', included: true, highlight: true },
        { text: locale === 'ar' ? '5 مواقع' : '5 Websites', included: true },
        { text: locale === 'ar' ? '30 جيجا NVMe' : '30 GB NVMe', included: true },
        { text: locale === 'ar' ? '2 جيجا RAM' : '2GB RAM', included: true },
        { text: locale === 'ar' ? '2 نواة معالج الجيل 13' : '2 Cores Gen 13', included: true },
        { text: locale === 'ar' ? 'نطاق ترددي غير محدود' : 'Unmetered bandwidth', included: true },
        { text: locale === 'ar' ? 'شهادة SSL مجانية' : 'Free SSL certificate', included: true },
        { text: locale === 'ar' ? '50 صندوق بريد' : '50 Email Accounts', included: true },
        { text: locale === 'ar' ? 'نسخ احتياطي تلقائي' : 'AutoBackup', included: true },
        { text: locale === 'ar' ? 'لوحة تحكم cPanel' : 'cPanel Control Panel', included: true },
      ],
      popular: false,
      color: 'emerald',
      pid: 41,
      link: 'https://app.progineous.com/cart.php?a=add&pid=41'
    },
    {
      name: 'Gen 102',
      description: locale === 'ar' ? 'الأفضل للأعمال المتنامية' : 'Best for growing businesses',
      monthlyPrice: 8.00,
      yearlyPrice: 5.30,
      features: [
        { text: locale === 'ar' ? '🎁 دومين .COM مجاني للسنة الأولى' : '🎁 Free .COM domain 1st year', included: true, highlight: true },
        { text: locale === 'ar' ? 'مواقع غير محدودة' : 'Unlimited Websites', included: true },
        { text: locale === 'ar' ? '40 جيجا NVMe' : '40 GB NVMe', included: true },
        { text: locale === 'ar' ? '4 جيجا RAM' : '4GB RAM', included: true },
        { text: locale === 'ar' ? '4 نواة معالج الجيل 13' : '4 Cores Gen 13', included: true },
        { text: locale === 'ar' ? 'نطاق ترددي غير محدود' : 'Unmetered bandwidth', included: true },
        { text: locale === 'ar' ? 'شهادة SSL مجانية' : 'Free SSL certificate', included: true },
        { text: locale === 'ar' ? 'صناديق بريد غير محدودة' : 'Unlimited Email Accounts', included: true },
        { text: locale === 'ar' ? 'نسخ احتياطي تلقائي' : 'AutoBackup', included: true },
        { text: locale === 'ar' ? 'لوحة تحكم cPanel' : 'cPanel Control Panel', included: true },
      ],
      popular: true,
      color: 'emerald',
      pid: 42,
      link: 'https://app.progineous.com/cart.php?a=add&pid=42'
    },
    {
      name: 'Gen 101',
      description: locale === 'ar' ? 'للمشاريع الكبيرة والمتاجر' : 'For large projects & stores',
      monthlyPrice: 12.00,
      yearlyPrice: 8.61,
      features: [
        { text: locale === 'ar' ? '🎁 دومين .COM مجاني للسنة الأولى' : '🎁 Free .COM domain 1st year', included: true, highlight: true },
        { text: locale === 'ar' ? 'مواقع غير محدودة' : 'Unlimited Websites', included: true },
        { text: locale === 'ar' ? '60 جيجا NVMe' : '60 GB NVMe', included: true },
        { text: locale === 'ar' ? '8 جيجا RAM' : '8GB RAM', included: true },
        { text: locale === 'ar' ? '8 نواة معالج الجيل 13' : '8 Cores Gen 13', included: true },
        { text: locale === 'ar' ? 'نطاق ترددي غير محدود' : 'Unmetered bandwidth', included: true },
        { text: locale === 'ar' ? 'شهادة SSL مجانية' : 'Free SSL certificate', included: true },
        { text: locale === 'ar' ? 'صناديق بريد غير محدودة' : 'Unlimited Email Accounts', included: true },
        { text: locale === 'ar' ? 'نسخ احتياطي تلقائي' : 'AutoBackup', included: true },
        { text: locale === 'ar' ? 'لوحة تحكم cPanel' : 'cPanel Control Panel', included: true },
        { text: locale === 'ar' ? 'مراكز بيانات UK و US' : 'UK & US Datacenters', included: true },
      ],
      popular: false,
      color: 'emerald',
      pid: 43,
      link: 'https://app.progineous.com/cart.php?a=add&pid=43'
    }
  ];

  // PLACEHOLDER_FEATURES

  const features = [
    { icon: Activity, title: locale === 'ar' ? 'موثوقية لا مثيل لها' : 'Unmatched Reliability',
      description: locale === 'ar' ? 'بنية تحتية عالية التوفر تضمن بقاء موقعك متاحاً حتى في أوقات الذروة' : 'High-availability infrastructure ensures your website stays online during peak traffic' },
    { icon: Zap, title: locale === 'ar' ? 'أداء فائق السرعة' : 'Blazing-Fast Performance',
      description: locale === 'ar' ? 'أوقات تحميل سريعة للغاية مع حلول التخزين المحسنة' : 'Lightning-fast loading times with optimized storage solutions' },
    { icon: Shield, title: locale === 'ar' ? 'حماية قوية' : 'Ironclad Security',
      description: locale === 'ar' ? 'حماية بياناتك مع جدار حماية من الجيل التالي' : 'Protect your data with next-generation firewall and proactive security' },
    { icon: Headphones, title: locale === 'ar' ? 'إدارة متخصصة' : 'Expert Management',
      description: locale === 'ar' ? 'فريقنا يتولى التفاصيل التقنية لتركز على عملك' : 'Our team handles the technical details, so you can focus on your business' },
  ];

  const faqs = [
    { question: locale === 'ar' ? 'ما هي استضافة الكلاود؟' : 'What is Cloud Hosting?',
      answer: locale === 'ar' ? 'استضافة الكلاود تجمع بين أداء وموثوقية الخادم الخاص الافتراضي (VPS) مع سهولة استخدام الاستضافة المشتركة. تستفيد من شبكة من السيرفرات لضمان أداء فائق وتوفر عالي.' : 'Cloud hosting blends VPS performance and reliability with shared hosting simplicity. It leverages a network of servers, guaranteeing superior performance and availability.' },
    { question: locale === 'ar' ? 'متى تكون استضافة الكلاود مناسبة لي؟' : 'When Does Cloud Hosting Make Sense for Me?',
      answer: locale === 'ar' ? 'إذا كنت تحتاج إلى موارد أكثر من الاستضافة المشتركة، أو تتوقع نمواً في حركة المرور، أو تحتاج لأداء أفضل لموقعك أو تطبيقك.' : 'When you need more resources than shared hosting, expect traffic growth, or need better performance for your website or application.' },
    { question: locale === 'ar' ? 'ما فوائد استضافة الكلاود المُدارة؟' : 'What Are the Benefits of Managed Cloud Hosting?',
      answer: locale === 'ar' ? 'نتولى جميع الجوانب التقنية من التحديثات والأمان والنسخ الاحتياطي، مما يتيح لك التركيز على عملك.' : 'We handle all technical aspects from updates, security, and backups, allowing you to focus on your business.' },
    { question: locale === 'ar' ? 'هل تأتي مع لوحة تحكم؟' : 'Does Cloud Hosting Come with a Control Panel?',
      answer: locale === 'ar' ? 'نعم، جميع خططنا تأتي مع لوحة تحكم cPanel سهلة الاستخدام لإدارة موقعك وبريدك وقواعد بياناتك.' : 'Yes, all our plans come with easy-to-use cPanel control panel to manage your site, email, and databases.' },
    { question: locale === 'ar' ? 'ما الفرق بين الاستضافة المشتركة والكلاود؟' : 'What Is the Difference Between Shared and Cloud Hosting?',
      answer: locale === 'ar' ? 'الاستضافة المشتركة تشارك الموارد مع مواقع أخرى، بينما الكلاود توفر موارد مخصصة (RAM, CPU) لموقعك مع قابلية توسع أفضل.' : 'Shared hosting shares resources with other sites, while cloud provides dedicated resources (RAM, CPU) for your site with better scalability.' },
  ];

  const stats = [
    { value: '100%', label: locale === 'ar' ? 'ضمان التشغيل' : 'Uptime SLA' },
    { value: '8x', label: locale === 'ar' ? 'أسرع أداء' : 'Faster Speed' },
    { value: '24/7', label: locale === 'ar' ? 'دعم متخصص' : 'Expert Support' },
    { value: '30', label: locale === 'ar' ? 'يوم ضمان' : 'Day Guarantee' },
  ];

  // JSON-LD Structured Data for SEO
  const structuredData = {
    '@context': 'https://schema.org',
    '@type': 'Product',
    name: locale === 'ar' ? 'استضافة سحابية مُدارة' : 'Managed Cloud Hosting',
    description: locale === 'ar' 
      ? 'استضافة سحابية مُدارة بالكامل مع معالجات الجيل 13، NVMe SSD، وموارد مخصصة لموقعك'
      : 'Fully managed cloud hosting with Gen 13 processors, NVMe SSD, and dedicated resources for your website',
    image: 'https://progineous.com/og-cloud-hosting.png',
    url: `https://progineous.com/${locale}/hosting/cloud`,
    brand: {
      '@type': 'Brand',
      name: 'Pro Gineous'
    },
    offers: {
      '@type': 'AggregateOffer',
      lowPrice: '4',
      highPrice: '12',
      priceCurrency: 'USD',
      offerCount: '3',
      offers: plans.map(plan => ({
        '@type': 'Offer',
        name: plan.name,
        description: plan.description,
        price: plan.yearlyPrice,
        priceCurrency: 'USD',
        priceValidUntil: '2026-12-31',
        availability: 'https://schema.org/InStock',
        url: plan.link
      }))
    },
    aggregateRating: {
      '@type': 'AggregateRating',
      ratingValue: '4.9',
      reviewCount: '1847',
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
        name: locale === 'ar' ? 'استضافة سحابية' : 'Cloud Hosting',
        item: `https://progineous.com/${locale}/hosting/cloud`
      }
    ]
  };

  // PLACEHOLDER_JSX

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

      {/* Hero Section - Cloud Style */}
      <section className="relative overflow-hidden bg-linear-to-br from-emerald-900 via-teal-800 to-cyan-700 py-20 lg:py-28">
        <div className="absolute inset-0 opacity-10">
          <div className="absolute inset-0 hero-dots-pattern"></div>
        </div>
        <div className="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="text-center">
            <div className="mb-6 inline-flex items-center gap-2 rounded-full bg-white/10 px-4 py-2 backdrop-blur-sm">
              <Cloud className="h-4 w-4 text-emerald-400" />
              <span className="text-sm font-medium text-white">
                {locale === 'ar' ? 'استضافة سحابية مُدارة بالكامل' : 'Fully Managed Cloud Hosting'}
              </span>
            </div>
            <h1 className="text-3xl font-extrabold text-white sm:text-4xl md:text-5xl lg:text-6xl">
              {locale === 'ar' ? 'استضافة سحابية مُدارة' : 'Managed Cloud Hosting'}
              <span className="mt-2 block text-emerald-400">
                {locale === 'ar' ? 'سيرفرات آمنة وموثوقة' : 'Secure & Reliable Servers'}
              </span>
            </h1>
            <p className="mx-auto mt-6 max-w-2xl text-lg text-white/80">
              {locale === 'ar'
                ? 'مع خدمات استضافة الويب السحابية المُدارة، يمكنك التركيز على تنمية مشاريعك بفضل فريق الخبراء الذي يهتم بالجانب التقني.'
                : 'With managed cloud hosting services, focus on growing your projects thanks to our expert team handling the backend.'}
            </p>
            <div className="mt-10 flex flex-wrap items-center justify-center gap-8 lg:gap-16">
              {stats.map((stat, index) => (
                <div key={index} className="text-center">
                  <div className="text-3xl font-bold text-white lg:text-4xl">{stat.value}</div>
                  <div className="mt-1 text-sm text-white/60">{stat.label}</div>
                </div>
              ))}
            </div>
            <div className="mt-10">
              <a href="#pricing" className="inline-flex items-center gap-2 rounded-full bg-white px-8 py-4 text-base font-semibold text-emerald-700 shadow-lg transition-all hover:bg-white/90 hover:shadow-xl">
                {locale === 'ar' ? 'اختر خطتك' : 'Choose Your Plan'}
                <ArrowRight className="h-5 w-5 rtl:rotate-180" />
              </a>
            </div>
          </div>
        </div>
        <div className="absolute bottom-0 left-0 right-0">
          <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg" className="w-full">
            <path d="M0 120L60 110C120 100 240 80 360 70C480 60 600 60 720 65C840 70 960 80 1080 85C1200 90 1320 90 1380 90L1440 90V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0Z" fill="white"/>
          </svg>
        </div>
      </section>

      {/* PLACEHOLDER_ALLPLANS */}

      {/* All Plans Include Section - Bento Grid */}
      <section ref={allPlansRef} className="py-16 lg:py-20 bg-white overflow-hidden">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="text-center mb-12 all-plans-title">
            <h2 className="text-2xl font-bold text-gray-900 sm:text-3xl lg:text-4xl">
              {locale === 'ar' ? 'جميع الخطط تشمل' : 'All Plans Include'}
            </h2>
          </div>
          
          <div className="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            {/* Large Card */}
            <div className="col-span-2 row-span-2 rounded-3xl bg-linear-to-br from-emerald-500 to-teal-600 p-6 text-white flex flex-col justify-between min-h-50">
              <div>
                <div className="w-12 h-12 rounded-2xl bg-white/20 flex items-center justify-center mb-4">
                  <Cpu className="h-6 w-6" />
                </div>
                <h3 className="text-xl font-bold">{locale === 'ar' ? 'معالجات الجيل 13' : 'Gen 13 Processors'}</h3>
                <p className="text-white/70 text-sm mt-2">{locale === 'ar' ? 'أحدث معالجات Intel للأداء الفائق' : 'Latest Intel processors for superior performance'}</p>
              </div>
              <div className="flex items-center gap-2 mt-4">
                <span className="px-3 py-1 rounded-full bg-white/20 text-xs font-medium">2-8 Cores</span>
                <span className="px-3 py-1 rounded-full bg-white/20 text-xs font-medium">NVMe SSD</span>
              </div>
            </div>
            
            {/* Small Cards */}
            <div className="rounded-2xl bg-emerald-50 p-5 flex flex-col items-center justify-center text-center hover:shadow-lg transition-shadow">
              <div className="w-10 h-10 rounded-xl bg-emerald-100 flex items-center justify-center mb-3">
                <Shield className="h-5 w-5 text-emerald-600" />
              </div>
              <span className="font-semibold text-gray-900 text-sm">{locale === 'ar' ? 'شهادة SSL' : 'Free SSL'}</span>
            </div>
            
            <div className="rounded-2xl bg-teal-50 p-5 flex flex-col items-center justify-center text-center hover:shadow-lg transition-shadow">
              <div className="w-10 h-10 rounded-xl bg-teal-100 flex items-center justify-center mb-3">
                <Gauge className="h-5 w-5 text-teal-600" />
              </div>
              <span className="font-semibold text-gray-900 text-sm">cPanel</span>
            </div>
            
            <div className="rounded-2xl bg-cyan-50 p-5 flex flex-col items-center justify-center text-center hover:shadow-lg transition-shadow">
              <div className="w-10 h-10 rounded-xl bg-cyan-100 flex items-center justify-center mb-3">
                <RefreshCw className="h-5 w-5 text-cyan-600" />
              </div>
              <span className="font-semibold text-gray-900 text-sm">{locale === 'ar' ? 'نسخ احتياطي' : 'Auto Backup'}</span>
            </div>
            
            <div className="rounded-2xl bg-amber-50 p-5 flex flex-col items-center justify-center text-center hover:shadow-lg transition-shadow">
              <div className="w-10 h-10 rounded-xl bg-amber-100 flex items-center justify-center mb-3">
                <Headphones className="h-5 w-5 text-amber-600" />
              </div>
              <span className="font-semibold text-gray-900 text-sm">{locale === 'ar' ? 'دعم 24/7' : '24/7 Support'}</span>
            </div>
            
            {/* Wide Card */}
            <div className="col-span-2 rounded-2xl bg-linear-to-r from-teal-50 to-emerald-50 p-5 flex items-center gap-4 hover:shadow-lg transition-shadow">
              <div className="w-12 h-12 rounded-xl bg-teal-100 flex items-center justify-center shrink-0">
                <Globe className="h-6 w-6 text-teal-600" />
              </div>
              <div>
                <span className="font-semibold text-gray-900">{locale === 'ar' ? 'مراكز بيانات عالمية' : 'Global Datacenters'}</span>
                <p className="text-gray-500 text-sm">{locale === 'ar' ? 'UK & US' : 'UK & US Locations'}</p>
              </div>
            </div>
            
            <div className="rounded-2xl bg-rose-50 p-5 flex flex-col items-center justify-center text-center hover:shadow-lg transition-shadow">
              <div className="w-10 h-10 rounded-xl bg-rose-100 flex items-center justify-center mb-3">
                <Mail className="h-5 w-5 text-rose-600" />
              </div>
              <span className="font-semibold text-gray-900 text-sm">{locale === 'ar' ? 'بريد إلكتروني' : 'Email Hosting'}</span>
            </div>
            
            <div className="rounded-2xl bg-violet-50 p-5 flex flex-col items-center justify-center text-center hover:shadow-lg transition-shadow">
              <div className="w-10 h-10 rounded-xl bg-violet-100 flex items-center justify-center mb-3">
                <Database className="h-5 w-5 text-violet-600" />
              </div>
              <span className="font-semibold text-gray-900 text-sm">MySQL</span>
            </div>
            
            {/* Wide Card 2 */}
            <div className="col-span-2 rounded-2xl bg-linear-to-r from-emerald-600 to-teal-600 p-5 flex items-center justify-between text-white hover:shadow-lg transition-shadow">
              <div className="flex items-center gap-4">
                <div className="w-12 h-12 rounded-xl bg-white/20 flex items-center justify-center">
                  <Zap className="h-6 w-6" />
                </div>
                <div>
                  <span className="font-semibold">{locale === 'ar' ? 'سيرفرات LiteSpeed' : 'LiteSpeed Servers'}</span>
                  <p className="text-white/70 text-sm">CloudLinux</p>
                </div>
              </div>
              <span className="px-3 py-1 rounded-full bg-white/20 text-sm font-medium">8x {locale === 'ar' ? 'أسرع' : 'Faster'}</span>
            </div>
            
            <div className="rounded-2xl bg-sky-50 p-5 flex flex-col items-center justify-center text-center hover:shadow-lg transition-shadow">
              <div className="w-10 h-10 rounded-xl bg-sky-100 flex items-center justify-center mb-3">
                <Lock className="h-5 w-5 text-sky-600" />
              </div>
              <span className="font-semibold text-gray-900 text-sm">{locale === 'ar' ? 'حماية DDoS' : 'DDoS Protection'}</span>
            </div>
            
            <div className="rounded-2xl bg-orange-50 p-5 flex flex-col items-center justify-center text-center hover:shadow-lg transition-shadow">
              <div className="w-10 h-10 rounded-xl bg-orange-100 flex items-center justify-center mb-3">
                <HardDrive className="h-5 w-5 text-orange-600" />
              </div>
              <span className="font-semibold text-gray-900 text-sm">NVMe SSD</span>
            </div>
          </div>
        </div>
      </section>

      {/* PLACEHOLDER_PRICING */}

      {/* Why Choose Section - Zigzag Layout */}
      <section className="py-16 lg:py-24 bg-linear-to-b from-gray-50 to-white">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="text-center mb-16">
            <span className="inline-flex items-center gap-2 rounded-full bg-emerald-100 px-4 py-2 text-sm font-semibold text-emerald-700 mb-4">
              <Sparkles className="h-4 w-4" />
              {locale === 'ar' ? 'لماذا نحن؟' : 'Why Us?'}
            </span>
            <h2 className="text-3xl font-bold text-gray-900 sm:text-4xl lg:text-5xl">
              {locale === 'ar' ? 'لماذا تختار Pro Gineous' : 'Why Choose Pro Gineous'}
              <span className="block text-emerald-600 mt-2">
                {locale === 'ar' ? 'لاستضافة سيرفرك السحابي؟' : 'For Your Cloud Server Hosting?'}
              </span>
            </h2>
          </div>

          <div className="space-y-16 lg:space-y-24">
            {/* Row 1 - Box Left, Text Right */}
            <div className="grid lg:grid-cols-2 gap-8 lg:gap-16 items-center">
              <div className="relative flex items-center justify-center">
                <Activity className="h-48 w-48 text-emerald-500" />
              </div>
              <div className="text-center lg:text-start">
                <h3 className="text-2xl lg:text-3xl font-bold text-gray-900 mb-4">
                  {locale === 'ar' ? 'موثوقية لا مثيل لها' : 'Unmatched Reliability'}
                </h3>
                <p className="text-gray-600 text-lg leading-relaxed">
                  {locale === 'ar'
                    ? 'بنيتنا التحتية عالية التوفر تضمن بقاء موقعك أو تطبيقك متاحاً، حتى أثناء ذروة حركة المرور.'
                    : 'Our high-availability infrastructure ensures your website or application stays online, even during peak traffic.'}
                </p>
                <div className="mt-6 flex flex-wrap gap-3 justify-center lg:justify-start">
                  <span className="px-4 py-2 rounded-full bg-emerald-100 text-emerald-700 text-sm font-medium">100% Uptime SLA</span>
                  <span className="px-4 py-2 rounded-full bg-emerald-100 text-emerald-700 text-sm font-medium">24/7 Monitoring</span>
                </div>
              </div>
            </div>

            {/* Row 2 - Text Left, Box Right */}
            <div className="grid lg:grid-cols-2 gap-8 lg:gap-16 items-center">
              <div className="text-center lg:text-start order-2 lg:order-1">
                <h3 className="text-2xl lg:text-3xl font-bold text-gray-900 mb-4">
                  {locale === 'ar' ? 'أداء فائق السرعة' : 'Blazing-Fast Performance'}
                </h3>
                <p className="text-gray-600 text-lg leading-relaxed">
                  {locale === 'ar'
                    ? 'استمتع بأوقات تحميل فائقة السرعة مع حلول التخزين المحسنة، المدعومة بأحدث التقنيات.'
                    : 'Experience lightning-fast loading times with our optimized storage solutions, powered by cutting-edge technology.'}
                </p>
                <div className="mt-6 flex flex-wrap gap-3 justify-center lg:justify-start">
                  <span className="px-4 py-2 rounded-full bg-amber-100 text-amber-700 text-sm font-medium">NVMe SSD</span>
                  <span className="px-4 py-2 rounded-full bg-amber-100 text-amber-700 text-sm font-medium">Gen 13 CPU</span>
                  <span className="px-4 py-2 rounded-full bg-amber-100 text-amber-700 text-sm font-medium">LiteSpeed</span>
                </div>
              </div>
              <div className="relative flex items-center justify-center order-1 lg:order-2">
                <Zap className="h-48 w-48 text-amber-500" />
              </div>
            </div>

            {/* Row 3 - Box Left, Text Right */}
            <div className="grid lg:grid-cols-2 gap-8 lg:gap-16 items-center">
              <div className="relative flex items-center justify-center">
                <Shield className="h-48 w-48 text-rose-500" />
              </div>
              <div className="text-center lg:text-start">
                <h3 className="text-2xl lg:text-3xl font-bold text-gray-900 mb-4">
                  {locale === 'ar' ? 'حماية قوية' : 'Ironclad Security'}
                </h3>
                <p className="text-gray-600 text-lg leading-relaxed">
                  {locale === 'ar'
                    ? 'احمِ بياناتك مع جدار حماية من الجيل التالي وإجراءات أمنية استباقية.'
                    : 'Protect your data with our next-generation firewall and proactive security measures.'}
                </p>
                <div className="mt-6 flex flex-wrap gap-3 justify-center lg:justify-start">
                  <span className="px-4 py-2 rounded-full bg-rose-100 text-rose-700 text-sm font-medium">Fortiguard Labs</span>
                  <span className="px-4 py-2 rounded-full bg-rose-100 text-rose-700 text-sm font-medium">DDoS Protection</span>
                </div>
              </div>
            </div>

            {/* Row 4 - Text Left, Box Right */}
            <div className="grid lg:grid-cols-2 gap-8 lg:gap-16 items-center">
              <div className="text-center lg:text-start order-2 lg:order-1">
                <h3 className="text-2xl lg:text-3xl font-bold text-gray-900 mb-4">
                  {locale === 'ar' ? 'إدارة متخصصة' : 'Expert Management'}
                </h3>
                <p className="text-gray-600 text-lg leading-relaxed">
                  {locale === 'ar'
                    ? 'فريق الخبراء لدينا يتولى التفاصيل التقنية، حتى تتمكن من التركيز على عملك.'
                    : 'Our team of experts handles the technical details, so you can focus on your business.'}
                </p>
                <div className="mt-6 flex flex-wrap gap-3 justify-center lg:justify-start">
                  <span className="px-4 py-2 rounded-full bg-cyan-100 text-cyan-700 text-sm font-medium">24/7 Support</span>
                  <span className="px-4 py-2 rounded-full bg-cyan-100 text-cyan-700 text-sm font-medium">Free Migration</span>
                </div>
              </div>
              <div className="relative flex items-center justify-center order-1 lg:order-2">
                <Users className="h-48 w-48 text-cyan-500" />
              </div>
            </div>
          </div>
        </div>
      </section>

      {/* Pricing Section */}
      <section id="pricing" ref={plansRef} className="py-16 lg:py-24 bg-linear-to-b from-gray-50 to-white">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="text-center mb-12">
            <span className="inline-flex items-center gap-2 rounded-full bg-emerald-100 px-4 py-2 text-sm font-semibold text-emerald-700 mb-4">
              <Cloud className="h-4 w-4" />
              {locale === 'ar' ? 'خطط الاستضافة السحابية' : 'Cloud Hosting Plans'}
            </span>
            <h2 className="text-3xl font-bold text-gray-900 sm:text-4xl">
              {locale === 'ar' ? 'اختر خطتك المثالية' : 'Choose Your Perfect Plan'}
            </h2>
            <p className="mt-4 text-gray-600 max-w-2xl mx-auto">
              {locale === 'ar' ? 'موارد مخصصة مع أداء فائق وموثوقية عالية' : 'Dedicated resources with superior performance and high reliability'}
            </p>
            
            {/* Billing Toggle */}
            <div className="mt-8 inline-flex items-center gap-4 rounded-full bg-gray-100 p-1">
              <button
                onClick={() => setBillingPeriod('monthly')}
                className={cn(
                  "px-6 py-2 rounded-full text-sm font-semibold transition-all",
                  billingPeriod === 'monthly' ? "bg-white text-emerald-700 shadow-sm" : "text-gray-600 hover:text-gray-900"
                )}
              >
                {locale === 'ar' ? 'شهري' : 'Monthly'}
              </button>
              <button
                onClick={() => setBillingPeriod('yearly')}
                className={cn(
                  "px-6 py-2 rounded-full text-sm font-semibold transition-all flex items-center gap-2",
                  billingPeriod === 'yearly' ? "bg-white text-emerald-700 shadow-sm" : "text-gray-600 hover:text-gray-900"
                )}
              >
                {locale === 'ar' ? 'سنوي' : 'Yearly'}
                <span className="px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-700 text-xs font-bold">
                  {locale === 'ar' ? 'وفر 30%' : 'Save 30%'}
                </span>
              </button>
            </div>
          </div>
          <div className="grid gap-8 lg:grid-cols-3">
            {plans.map((plan, index) => (
              <div key={plan.name} ref={(el) => { planCardsRef.current[index] = el; }}
                className={cn("relative rounded-3xl p-8 transition-all", plan.popular ? "bg-linear-to-br from-emerald-600 to-teal-700 text-white shadow-2xl scale-105 z-10" : "bg-white border-2 border-gray-100 hover:border-emerald-200 hover:shadow-xl")}>
                {plan.popular && (
                  <div className="absolute -top-4 left-1/2 -translate-x-1/2">
                    <span className="inline-flex items-center gap-1 rounded-full bg-yellow-400 px-4 py-1 text-sm font-bold text-yellow-900">
                      <Star className="h-4 w-4" /> {locale === 'ar' ? 'الأكثر شعبية' : 'Most Popular'}
                    </span>
                  </div>
                )}
                <div className="text-center mb-6">
                  <h3 className={cn("text-2xl font-bold", plan.popular ? "text-white" : "text-gray-900")}>{plan.name}</h3>
                  <p className={cn("mt-1 text-sm", plan.popular ? "text-white/70" : "text-gray-500")}>{plan.description}</p>
                </div>
                <div className="text-center mb-6">
                  <span ref={(el) => { priceRefs.current[index] = el; }} className={cn("text-5xl font-extrabold", plan.popular ? "text-white" : "text-gray-900")}>
                    ${billingPeriod === 'yearly' ? plan.yearlyPrice.toFixed(2) : plan.monthlyPrice.toFixed(2)}
                  </span>
                  <span className={cn("text-lg", plan.popular ? "text-white/70" : "text-gray-500")}>/mo</span>
                  <p className={cn("mt-2 text-sm", plan.popular ? "text-white/60" : "text-gray-400")}>
                    {billingPeriod === 'yearly' 
                      ? (locale === 'ar' ? `يُدفع $${(plan.yearlyPrice * 12).toFixed(0)} سنوياً` : `Billed $${(plan.yearlyPrice * 12).toFixed(0)}/year`)
                      : (locale === 'ar' ? 'يُدفع شهرياً' : 'Billed monthly')}
                  </p>
                </div>
                <ul className="space-y-3 mb-8">
                  {plan.features.slice(0, 8).map((feature, i) => (
                    <li key={i} className="flex items-start gap-3">
                      <Check className={cn("h-5 w-5 shrink-0 mt-0.5", plan.popular ? "text-emerald-300" : "text-emerald-500")} />
                      <span className={cn("text-sm", plan.popular ? "text-white/90" : "text-gray-600", feature.highlight && "font-semibold")}>{feature.text}</span>
                    </li>
                  ))}
                </ul>
                <a href={`${plan.link}&billingcycle=${billingPeriod === 'yearly' ? 'annually' : 'monthly'}`} target="_blank" rel="noopener noreferrer"
                  className={cn("block w-full rounded-xl py-4 text-center font-semibold transition-all",
                    plan.popular ? "bg-white text-emerald-700 hover:bg-white/90" : "bg-emerald-600 text-white hover:bg-emerald-700")}>
                  {locale === 'ar' ? 'اشترك الآن' : 'Get Started'}
                </a>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* PLACEHOLDER_FEATURES */}

      {/* Features Section - Bento Grid */}
      <section ref={featuresRef} className="py-16 lg:py-24 bg-white">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="text-center mb-12">
            <span className="inline-flex items-center gap-2 rounded-full bg-teal-100 px-4 py-2 text-sm font-semibold text-teal-700 mb-4">
              <Sparkles className="h-4 w-4" />
              {locale === 'ar' ? 'مميزات حصرية' : 'Exclusive Features'}
            </span>
            <h2 className="text-3xl font-bold text-gray-900 sm:text-4xl">
              {locale === 'ar' ? 'لماذا تختار استضافتنا السحابية؟' : 'Why Choose Our Cloud Hosting?'}
            </h2>
          </div>
          <div className="grid gap-6 lg:grid-cols-12">
            {/* Large Card - Performance */}
            <div ref={(el) => { featureCardsRef.current[0] = el; }}
              className="lg:col-span-7 group relative rounded-3xl bg-linear-to-br from-emerald-600 to-teal-700 p-8 text-white overflow-hidden min-h-80 hover:shadow-xl transition-shadow">
              <div className="relative z-10">
                <div className="feature-icon inline-flex h-14 w-14 items-center justify-center rounded-2xl bg-white/20 backdrop-blur-sm mb-4">
                  <Zap className="h-7 w-7" />
                </div>
                <h3 className="text-2xl font-bold mb-3">{locale === 'ar' ? 'أداء فائق السرعة' : 'Blazing-Fast Performance'}</h3>
                <p className="text-white/80 max-w-md">{locale === 'ar' ? 'سيرفرات بمعالجات الجيل 13 مع تخزين NVMe SSD لأداء استثنائي' : 'Gen 13 processors with NVMe SSD storage for exceptional performance'}</p>
                <div className="mt-6 flex items-center gap-6">
                  <div><div className="text-3xl font-bold">100%</div><div className="text-white/60 text-sm">{locale === 'ar' ? 'ضمان التشغيل' : 'Uptime SLA'}</div></div>
                  <div><div className="text-3xl font-bold">&lt;50ms</div><div className="text-white/60 text-sm">{locale === 'ar' ? 'زمن الاستجابة' : 'Response'}</div></div>
                </div>
              </div>
              <Zap className="absolute bottom-4 ltr:right-4 rtl:left-4 h-32 w-32 text-white/5" />
            </div>
            {/* Security Card */}
            <div ref={(el) => { featureCardsRef.current[1] = el; }}
              className="lg:col-span-5 group relative rounded-3xl bg-emerald-50 p-8 overflow-hidden min-h-70 hover:shadow-xl transition-shadow">
              <div className="feature-icon inline-flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-100 text-emerald-600 mb-4">
                <Shield className="h-6 w-6" />
              </div>
              <h3 className="text-xl font-bold text-gray-900 mb-2">{locale === 'ar' ? 'حماية قوية' : 'Ironclad Security'}</h3>
              <p className="text-gray-600">{locale === 'ar' ? 'محمي بواسطة Fortiguard Labs مع جدار حماية متقدم' : 'Secured by Fortiguard Labs with advanced firewall'}</p>
              <div className="mt-6 flex flex-wrap gap-2">
                {['DDoS', 'Firewall', 'SSL', 'Malware Scan'].map((tag) => (
                  <span key={tag} className="px-3 py-1 rounded-full bg-emerald-100 text-emerald-700 text-xs font-medium">{tag}</span>
                ))}
              </div>
              <Shield className="absolute bottom-4 ltr:right-4 rtl:left-4 h-24 w-24 text-emerald-100" />
            </div>
            {/* Reliability Card */}
            <div ref={(el) => { featureCardsRef.current[2] = el; }}
              className="lg:col-span-4 group relative rounded-3xl bg-teal-50 p-8 overflow-hidden hover:shadow-xl transition-shadow">
              <div className="relative z-10">
                <div className="feature-icon inline-flex h-12 w-12 items-center justify-center rounded-xl bg-teal-100 text-teal-600 mb-4">
                  <Activity className="h-6 w-6" />
                </div>
                <h3 className="text-xl font-bold text-gray-900 mb-2">{locale === 'ar' ? 'موثوقية عالية' : 'High Reliability'}</h3>
                <p className="text-gray-600 text-sm">{locale === 'ar' ? 'بنية تحتية عالية التوفر تضمن بقاء موقعك متاحاً' : 'High-availability infrastructure keeps your site online'}</p>
              </div>
              <Activity className="absolute -bottom-2 ltr:-right-2 rtl:-left-2 h-24 w-24 text-teal-100/50" />
            </div>
            {/* Support Card */}
            <div ref={(el) => { featureCardsRef.current[3] = el; }}
              className="lg:col-span-4 group relative rounded-3xl bg-cyan-50 p-8 overflow-hidden hover:shadow-xl transition-shadow">
              <div className="relative z-10">
                <div className="feature-icon inline-flex h-12 w-12 items-center justify-center rounded-xl bg-cyan-100 text-cyan-600 mb-4">
                  <Headphones className="h-6 w-6" />
                </div>
                <h3 className="text-xl font-bold text-gray-900 mb-2">{locale === 'ar' ? 'إدارة متخصصة' : 'Expert Management'}</h3>
                <p className="text-gray-600 text-sm">{locale === 'ar' ? 'فريقنا يتولى التفاصيل التقنية لتركز على عملك' : 'Our team handles technical details for you'}</p>
              </div>
              <Headphones className="absolute -bottom-2 ltr:-right-2 rtl:-left-2 h-24 w-24 text-cyan-100/50" />
            </div>
            {/* cPanel Card */}
            <div ref={(el) => { featureCardsRef.current[4] = el; }}
              className="lg:col-span-4 group relative rounded-3xl bg-linear-to-br from-amber-50 to-orange-50 p-8 overflow-hidden hover:shadow-xl transition-shadow">
              <div className="flex gap-4 mb-4">
                <div className="feature-icon inline-flex h-12 w-12 items-center justify-center rounded-xl bg-amber-100 text-amber-600"><Globe className="h-6 w-6" /></div>
                <div className="feature-icon inline-flex h-12 w-12 items-center justify-center rounded-xl bg-orange-100 text-orange-600"><Gauge className="h-6 w-6" /></div>
              </div>
              <h3 className="text-xl font-bold text-gray-900 mb-2">{locale === 'ar' ? 'SSL + cPanel' : 'Free SSL + cPanel'}</h3>
              <p className="text-gray-600 text-sm">{locale === 'ar' ? 'شهادة SSL مجانية مع لوحة تحكم cPanel سهلة' : 'Free SSL certificate with easy-to-use cPanel'}</p>
            </div>
          </div>
        </div>
      </section>

      {/* Comparison Table */}
      <section className="py-16 lg:py-24 bg-white">
        <div className="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
          <div className="text-center mb-12">
            <span className="inline-flex items-center gap-2 rounded-full bg-emerald-100 px-4 py-2 text-sm font-semibold text-emerald-700 mb-4">
              <Gauge className="h-4 w-4" />
              {locale === 'ar' ? 'مقارنة شاملة' : 'Full Comparison'}
            </span>
            <h2 className="text-3xl font-bold text-gray-900 sm:text-4xl lg:text-5xl">
              {locale === 'ar' ? 'قارن خطط الاستضافة السحابية' : 'Compare Cloud Hosting Plans'}
            </h2>
            <p className="mt-4 text-lg text-gray-600 max-w-2xl mx-auto">
              {locale === 'ar' ? 'اختر الخطة المناسبة لاحتياجاتك' : 'Choose the right plan for your needs'}
            </p>
          </div>
          
          <div className="overflow-x-auto rounded-2xl border border-gray-200 shadow-lg">
            <table className="w-full text-sm">
              {/* Header */}
              <thead>
                <tr className="bg-linear-to-r from-emerald-600 to-teal-600 text-white">
                  <th className="px-6 py-5 text-start font-semibold text-base">{locale === 'ar' ? 'المميزات' : 'Features'}</th>
                  <th className="px-6 py-5 text-center font-semibold text-base">
                    <div className="flex flex-col items-center">
                      <span>Gen 103</span>
                      <span className="text-emerald-200 text-xs mt-1">{locale === 'ar' ? 'للمبتدئين' : 'Starter'}</span>
                    </div>
                  </th>
                  <th className="px-6 py-5 text-center font-semibold text-base bg-emerald-700/50">
                    <div className="flex flex-col items-center">
                      <div className="flex items-center gap-2">
                        <Star className="h-4 w-4 text-amber-300" />
                        <span>Gen 102</span>
                      </div>
                      <span className="text-emerald-200 text-xs mt-1">{locale === 'ar' ? 'الأكثر طلباً' : 'Most Popular'}</span>
                    </div>
                  </th>
                  <th className="px-6 py-5 text-center font-semibold text-base">
                    <div className="flex flex-col items-center">
                      <span>Gen 101</span>
                      <span className="text-emerald-200 text-xs mt-1">{locale === 'ar' ? 'للأعمال' : 'Business'}</span>
                    </div>
                  </th>
                </tr>
              </thead>
              <tbody className="divide-y divide-gray-100">
                {/* Pricing Row */}
                <tr className="bg-emerald-50">
                  <td className="px-6 py-4 font-semibold text-gray-900">{locale === 'ar' ? 'السعر الشهري' : 'Monthly Price'}</td>
                  <td className="px-6 py-4 text-center">
                    <span className="text-2xl font-bold text-emerald-600">$6</span>
                    <span className="text-gray-500 text-xs">/{locale === 'ar' ? 'شهر' : 'mo'}</span>
                  </td>
                  <td className="px-6 py-4 text-center bg-emerald-100/50">
                    <span className="text-2xl font-bold text-emerald-600">$8</span>
                    <span className="text-gray-500 text-xs">/{locale === 'ar' ? 'شهر' : 'mo'}</span>
                  </td>
                  <td className="px-6 py-4 text-center">
                    <span className="text-2xl font-bold text-emerald-600">$12</span>
                    <span className="text-gray-500 text-xs">/{locale === 'ar' ? 'شهر' : 'mo'}</span>
                  </td>
                </tr>
                {/* Yearly Price Row */}
                <tr className="bg-white">
                  <td className="px-6 py-4 font-semibold text-gray-900">{locale === 'ar' ? 'السعر السنوي' : 'Yearly Price'}</td>
                  <td className="px-6 py-4 text-center">
                    <span className="text-2xl font-bold text-emerald-600">$4</span>
                    <span className="text-gray-500 text-xs">/{locale === 'ar' ? 'شهر' : 'mo'}</span>
                  </td>
                  <td className="px-6 py-4 text-center bg-emerald-100/50">
                    <span className="text-2xl font-bold text-emerald-600">$5.30</span>
                    <span className="text-gray-500 text-xs">/{locale === 'ar' ? 'شهر' : 'mo'}</span>
                  </td>
                  <td className="px-6 py-4 text-center">
                    <span className="text-2xl font-bold text-emerald-600">$8.61</span>
                    <span className="text-gray-500 text-xs">/{locale === 'ar' ? 'شهر' : 'mo'}</span>
                  </td>
                </tr>
                {/* RAM */}
                <tr className="bg-gray-50">
                  <td className="px-6 py-4 font-medium text-gray-900 flex items-center gap-2">
                    <Database className="h-4 w-4 text-emerald-500" />
                    {locale === 'ar' ? 'الذاكرة العشوائية' : 'RAM Memory'}
                  </td>
                  <td className="px-6 py-4 text-center font-semibold text-gray-700">2 GB</td>
                  <td className="px-6 py-4 text-center font-semibold text-gray-700 bg-emerald-100/50">4 GB</td>
                  <td className="px-6 py-4 text-center font-semibold text-gray-700">8 GB</td>
                </tr>
                {/* CPU */}
                <tr className="bg-white">
                  <td className="px-6 py-4 font-medium text-gray-900 flex items-center gap-2">
                    <Cpu className="h-4 w-4 text-emerald-500" />
                    {locale === 'ar' ? 'نواة المعالج' : 'CPU Cores'}
                  </td>
                  <td className="px-6 py-4 text-center font-semibold text-gray-700">2 {locale === 'ar' ? 'نواة' : 'Cores'}</td>
                  <td className="px-6 py-4 text-center font-semibold text-gray-700 bg-emerald-100/50">4 {locale === 'ar' ? 'نواة' : 'Cores'}</td>
                  <td className="px-6 py-4 text-center font-semibold text-gray-700">8 {locale === 'ar' ? 'نواة' : 'Cores'}</td>
                </tr>
                {/* Storage */}
                <tr className="bg-gray-50">
                  <td className="px-6 py-4 font-medium text-gray-900 flex items-center gap-2">
                    <HardDrive className="h-4 w-4 text-emerald-500" />
                    {locale === 'ar' ? 'التخزين NVMe' : 'NVMe Storage'}
                  </td>
                  <td className="px-6 py-4 text-center font-semibold text-gray-700">30 GB</td>
                  <td className="px-6 py-4 text-center font-semibold text-gray-700 bg-emerald-100/50">40 GB</td>
                  <td className="px-6 py-4 text-center font-semibold text-gray-700">60 GB</td>
                </tr>
                {/* Bandwidth */}
                <tr className="bg-white">
                  <td className="px-6 py-4 font-medium text-gray-900 flex items-center gap-2">
                    <Activity className="h-4 w-4 text-emerald-500" />
                    {locale === 'ar' ? 'الباندويث' : 'Bandwidth'}
                  </td>
                  <td className="px-6 py-4 text-center font-semibold text-gray-700">1 TB</td>
                  <td className="px-6 py-4 text-center font-semibold text-gray-700 bg-emerald-100/50">2 TB</td>
                  <td className="px-6 py-4 text-center font-semibold text-gray-700">{locale === 'ar' ? 'غير محدود' : 'Unlimited'}</td>
                </tr>
                {/* Websites */}
                <tr className="bg-gray-50">
                  <td className="px-6 py-4 font-medium text-gray-900 flex items-center gap-2">
                    <Globe className="h-4 w-4 text-emerald-500" />
                    {locale === 'ar' ? 'المواقع' : 'Websites'}
                  </td>
                  <td className="px-6 py-4 text-center font-semibold text-gray-700">1</td>
                  <td className="px-6 py-4 text-center font-semibold text-gray-700 bg-emerald-100/50">5</td>
                  <td className="px-6 py-4 text-center font-semibold text-gray-700">{locale === 'ar' ? 'غير محدود' : 'Unlimited'}</td>
                </tr>
                {/* Email Accounts */}
                <tr className="bg-white">
                  <td className="px-6 py-4 font-medium text-gray-900 flex items-center gap-2">
                    <Mail className="h-4 w-4 text-emerald-500" />
                    {locale === 'ar' ? 'حسابات البريد' : 'Email Accounts'}
                  </td>
                  <td className="px-6 py-4 text-center font-semibold text-gray-700">10</td>
                  <td className="px-6 py-4 text-center font-semibold text-gray-700 bg-emerald-100/50">50</td>
                  <td className="px-6 py-4 text-center font-semibold text-gray-700">{locale === 'ar' ? 'غير محدود' : 'Unlimited'}</td>
                </tr>
                {/* Databases */}
                <tr className="bg-gray-50">
                  <td className="px-6 py-4 font-medium text-gray-900 flex items-center gap-2">
                    <Server className="h-4 w-4 text-emerald-500" />
                    {locale === 'ar' ? 'قواعد البيانات' : 'MySQL Databases'}
                  </td>
                  <td className="px-6 py-4 text-center font-semibold text-gray-700">5</td>
                  <td className="px-6 py-4 text-center font-semibold text-gray-700 bg-emerald-100/50">20</td>
                  <td className="px-6 py-4 text-center font-semibold text-gray-700">{locale === 'ar' ? 'غير محدود' : 'Unlimited'}</td>
                </tr>
                {/* Free SSL */}
                <tr className="bg-white">
                  <td className="px-6 py-4 font-medium text-gray-900 flex items-center gap-2">
                    <Lock className="h-4 w-4 text-emerald-500" />
                    {locale === 'ar' ? 'شهادة SSL مجانية' : 'Free SSL Certificate'}
                  </td>
                  <td className="px-6 py-4 text-center"><Check className="h-5 w-5 text-emerald-500 mx-auto" /></td>
                  <td className="px-6 py-4 text-center bg-emerald-100/50"><Check className="h-5 w-5 text-emerald-500 mx-auto" /></td>
                  <td className="px-6 py-4 text-center"><Check className="h-5 w-5 text-emerald-500 mx-auto" /></td>
                </tr>
                {/* Daily Backup */}
                <tr className="bg-gray-50">
                  <td className="px-6 py-4 font-medium text-gray-900 flex items-center gap-2">
                    <RefreshCw className="h-4 w-4 text-emerald-500" />
                    {locale === 'ar' ? 'نسخ احتياطي يومي' : 'Daily Backup'}
                  </td>
                  <td className="px-6 py-4 text-center"><Check className="h-5 w-5 text-emerald-500 mx-auto" /></td>
                  <td className="px-6 py-4 text-center bg-emerald-100/50"><Check className="h-5 w-5 text-emerald-500 mx-auto" /></td>
                  <td className="px-6 py-4 text-center"><Check className="h-5 w-5 text-emerald-500 mx-auto" /></td>
                </tr>
                {/* cPanel */}
                <tr className="bg-white">
                  <td className="px-6 py-4 font-medium text-gray-900 flex items-center gap-2">
                    <Gauge className="h-4 w-4 text-emerald-500" />
                    {locale === 'ar' ? 'لوحة تحكم cPanel' : 'cPanel Control'}
                  </td>
                  <td className="px-6 py-4 text-center"><Check className="h-5 w-5 text-emerald-500 mx-auto" /></td>
                  <td className="px-6 py-4 text-center bg-emerald-100/50"><Check className="h-5 w-5 text-emerald-500 mx-auto" /></td>
                  <td className="px-6 py-4 text-center"><Check className="h-5 w-5 text-emerald-500 mx-auto" /></td>
                </tr>
                {/* DDoS Protection */}
                <tr className="bg-gray-50">
                  <td className="px-6 py-4 font-medium text-gray-900 flex items-center gap-2">
                    <Shield className="h-4 w-4 text-emerald-500" />
                    {locale === 'ar' ? 'حماية DDoS' : 'DDoS Protection'}
                  </td>
                  <td className="px-6 py-4 text-center"><Check className="h-5 w-5 text-emerald-500 mx-auto" /></td>
                  <td className="px-6 py-4 text-center bg-emerald-100/50"><Check className="h-5 w-5 text-emerald-500 mx-auto" /></td>
                  <td className="px-6 py-4 text-center"><Check className="h-5 w-5 text-emerald-500 mx-auto" /></td>
                </tr>
                {/* Priority Support */}
                <tr className="bg-white">
                  <td className="px-6 py-4 font-medium text-gray-900 flex items-center gap-2">
                    <Headphones className="h-4 w-4 text-emerald-500" />
                    {locale === 'ar' ? 'دعم أولوية' : 'Priority Support'}
                  </td>
                  <td className="px-6 py-4 text-center"><Minus className="h-5 w-5 text-gray-300 mx-auto" /></td>
                  <td className="px-6 py-4 text-center bg-emerald-100/50"><Check className="h-5 w-5 text-emerald-500 mx-auto" /></td>
                  <td className="px-6 py-4 text-center"><Check className="h-5 w-5 text-emerald-500 mx-auto" /></td>
                </tr>
                {/* Dedicated IP */}
                <tr className="bg-gray-50">
                  <td className="px-6 py-4 font-medium text-gray-900 flex items-center gap-2">
                    <Cloud className="h-4 w-4 text-emerald-500" />
                    {locale === 'ar' ? 'IP مخصص' : 'Dedicated IP'}
                  </td>
                  <td className="px-6 py-4 text-center"><Minus className="h-5 w-5 text-gray-300 mx-auto" /></td>
                  <td className="px-6 py-4 text-center bg-emerald-100/50"><Minus className="h-5 w-5 text-gray-300 mx-auto" /></td>
                  <td className="px-6 py-4 text-center"><Check className="h-5 w-5 text-emerald-500 mx-auto" /></td>
                </tr>
              </tbody>
              {/* CTA Row */}
              <tfoot>
                <tr className="bg-gray-50">
                  <td className="px-6 py-6"></td>
                  <td className="px-6 py-6 text-center">
                    <a href="https://app.progineous.com/cart.php?a=add&pid=41&billingcycle=annually" target="_blank" rel="noopener noreferrer" className="inline-flex items-center gap-2 rounded-full bg-emerald-600 px-5 py-2.5 text-sm font-semibold text-white transition-all hover:bg-emerald-700 hover:scale-105">
                      {locale === 'ar' ? 'اطلب الآن' : 'Order Now'}
                    </a>
                  </td>
                  <td className="px-6 py-6 text-center bg-emerald-100/50">
                    <a href="https://app.progineous.com/cart.php?a=add&pid=42&billingcycle=annually" target="_blank" rel="noopener noreferrer" className="inline-flex items-center gap-2 rounded-full bg-emerald-600 px-5 py-2.5 text-sm font-semibold text-white transition-all hover:bg-emerald-700 hover:scale-105 shadow-lg shadow-emerald-500/25">
                      {locale === 'ar' ? 'اطلب الآن' : 'Order Now'}
                      <Star className="h-4 w-4" />
                    </a>
                  </td>
                  <td className="px-6 py-6 text-center">
                    <a href="https://app.progineous.com/cart.php?a=add&pid=43&billingcycle=annually" target="_blank" rel="noopener noreferrer" className="inline-flex items-center gap-2 rounded-full bg-emerald-600 px-5 py-2.5 text-sm font-semibold text-white transition-all hover:bg-emerald-700 hover:scale-105">
                      {locale === 'ar' ? 'اطلب الآن' : 'Order Now'}
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
          <div className="absolute top-20 ltr:left-10 rtl:right-10 w-72 h-72 bg-emerald-500/5 rounded-full blur-3xl" />
          <div className="absolute bottom-20 ltr:right-10 rtl:left-10 w-96 h-96 bg-teal-500/5 rounded-full blur-3xl" />
        </div>
        <div className="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 relative z-10">
          <div className="text-center mb-12">
            <span className="inline-flex items-center gap-2 rounded-full bg-emerald-100 px-4 py-2 text-sm font-semibold text-emerald-700 mb-4">
              <Headphones className="h-4 w-4" />
              {locale === 'ar' ? 'مركز المساعدة' : 'Help Center'}
            </span>
            <h2 className="text-3xl font-bold text-gray-900 sm:text-4xl lg:text-5xl">
              {locale === 'ar' ? 'الأسئلة الشائعة' : 'Cloud Hosting FAQs'}
            </h2>
          </div>
          <div className="space-y-4">
            {faqs.map((faq, index) => (
              <div key={index} className={cn("group rounded-2xl border-2 transition-all duration-300",
                openFaq === index ? "border-emerald-500 bg-white shadow-lg shadow-emerald-500/10" : "border-gray-200 bg-white hover:border-gray-300 hover:shadow-md")}>
                <button onClick={() => setOpenFaq(openFaq === index ? null : index)} className="flex w-full items-center justify-between px-6 py-5 text-start gap-4">
                  <div className="flex items-center gap-4">
                    <div className={cn("shrink-0 w-10 h-10 rounded-xl flex items-center justify-center text-sm font-bold transition-colors",
                      openFaq === index ? "bg-emerald-500 text-white" : "bg-gray-100 text-gray-500 group-hover:bg-emerald-100 group-hover:text-emerald-600")}>
                      {String(index + 1).padStart(2, '0')}
                    </div>
                    <span className={cn("font-semibold text-lg transition-colors", openFaq === index ? "text-emerald-600" : "text-gray-900")}>{faq.question}</span>
                  </div>
                  <div className={cn("shrink-0 w-10 h-10 rounded-full flex items-center justify-center transition-all",
                    openFaq === index ? "bg-emerald-500 text-white rotate-180" : "bg-gray-100 text-gray-500 group-hover:bg-emerald-100 group-hover:text-emerald-600")}>
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
            <Link href="/contact" className="inline-flex items-center gap-2 rounded-full bg-emerald-600 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-emerald-500/25 transition-all hover:bg-emerald-700 hover:shadow-xl hover:scale-105">
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
          <div className="rounded-3xl bg-linear-to-br from-emerald-600 to-teal-700 px-8 py-16 lg:py-20 text-center">
            <h2 className="text-3xl font-bold text-white sm:text-4xl lg:text-5xl">
              {locale === 'ar' ? 'جاهز للانتقال للسحابة؟' : 'Ready to Go Cloud?'}
            </h2>
            <p className="mx-auto mt-4 max-w-xl text-lg text-white/70">
              {locale === 'ar' ? 'انضم إلى آلاف العملاء السعداء واحصل على استضافة سحابية موثوقة اليوم' : 'Join thousands of happy customers and get reliable cloud hosting today'}
            </p>
            <div className="mt-10 flex flex-col items-center justify-center gap-4 sm:flex-row">
              <a href="#pricing" className="inline-flex items-center gap-2 rounded-full bg-white px-8 py-4 text-base font-semibold text-emerald-700 transition-all hover:bg-white/90 hover:scale-105">
                {locale === 'ar' ? 'ابدأ الآن بـ $4/شهر' : 'Start Now for $4/mo'}
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

