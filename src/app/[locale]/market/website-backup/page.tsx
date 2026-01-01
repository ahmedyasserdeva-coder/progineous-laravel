'use client';

import { useState, useEffect, useRef } from 'react';
import { useLocale } from 'next-intl';
import { Link } from '@/i18n/routing';
import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import {
  Shield,
  Database,
  Cloud,
  Check,
  ChevronDown,
  ChevronUp,
  ArrowRight,
  RefreshCw,
  Clock,
  Bell,
  Bug,
  HardDrive,
  FileCode,
  Mail,
  Settings,
  Zap,
  History,
  Server,
  Lock,
} from 'lucide-react';
import { cn } from '@/lib/utils';

// Register GSAP plugins
if (typeof window !== 'undefined') {
  gsap.registerPlugin(ScrollTrigger);
}

// CodeGuard Plan Interface
interface CodeGuardPlan {
  id: string;
  name: string;
  storage: string;
  price: number;
  cartLink: string;
  popular?: boolean;
}

// CodeGuard Plans Data
const codeguardPlans: CodeGuardPlan[] = [
  {
    id: '1gb',
    name: '1GB',
    storage: '1 GB',
    price: 2.09,
    cartLink: 'https://app.progineous.com/store/codeguard/1gb-lite',
  },
  {
    id: '5gb',
    name: '5GB',
    storage: '5 GB',
    price: 3.49,
    cartLink: 'https://app.progineous.com/store/codeguard/5gb-personal',
  },
  {
    id: '10gb',
    name: '10GB',
    storage: '10 GB',
    price: 6.28,
    cartLink: 'https://app.progineous.com/store/codeguard/10gb-professional',
    popular: true,
  },
  {
    id: '25gb',
    name: '25GB',
    storage: '25 GB',
    price: 13.97,
    cartLink: 'https://app.progineous.com/store/codeguard/25gb-business',
  },
  {
    id: '50gb',
    name: '50GB',
    storage: '50 GB',
    price: 20.95,
    cartLink: 'https://app.progineous.com/store/codeguard/50gb-business-plus',
  },
  {
    id: '100gb',
    name: '100GB',
    storage: '100 GB',
    price: 34.91,
    cartLink: 'https://app.progineous.com/store/codeguard/100gb-power',
  },
  {
    id: '200gb',
    name: '200GB',
    storage: '200 GB',
    price: 55.86,
    cartLink: 'https://app.progineous.com/store/codeguard/200gb-power-plus',
  },
];

// Hero Features
const heroFeatures = [
  {
    icon: Cloud,
    title: { en: 'Automatic Daily Backups', ar: 'نسخ احتياطي يومي تلقائي' },
  },
  {
    icon: History,
    title: { en: 'Website Time Machine', ar: 'آلة الزمن للموقع' },
  },
  {
    icon: Settings,
    title: { en: 'WordPress Plugin Updates', ar: 'تحديثات إضافات WordPress' },
  },
  {
    icon: Bell,
    title: { en: 'File Change Alert Monitoring', ar: 'مراقبة تنبيهات تغيير الملفات' },
  },
  {
    icon: Bug,
    title: { en: 'Malware Detection and Restore', ar: 'اكتشاف البرامج الضارة والاستعادة' },
  },
];

// Features Data
const codeguardFeatures = [
  {
    icon: Cloud,
    title: { en: 'Daily Automatic Website Backups', ar: 'نسخ احتياطي يومي تلقائي للموقع' },
    description: {
      en: 'Secure your website with automated daily backups stored offsite with built-in redundancy.',
      ar: 'أمّن موقعك بنسخ احتياطية يومية تلقائية مخزنة خارج الموقع مع تكرار مدمج.',
    },
  },
  {
    icon: Database,
    title: { en: 'Unlimited Files & Databases', ar: 'ملفات وقواعد بيانات غير محدودة' },
    description: {
      en: 'Backup an unlimited number of files and databases - you are restricted only by the storage space you use.',
      ar: 'انسخ عدداً غير محدود من الملفات وقواعد البيانات - أنت مقيد فقط بمساحة التخزين التي تستخدمها.',
    },
  },
  {
    icon: RefreshCw,
    title: { en: 'One-Click Restores', ar: 'استعادة بنقرة واحدة' },
    description: {
      en: 'A simple restore process makes it easy to rollback a single file or your entire website to a previous version.',
      ar: 'عملية استعادة بسيطة تجعل من السهل استرجاع ملف واحد أو موقعك بالكامل إلى إصدار سابق.',
    },
  },
  {
    icon: Bug,
    title: { en: 'Malware Monitoring', ar: 'مراقبة البرامج الضارة' },
    description: {
      en: 'Rest easy knowing CodeGuard is diligently checking your site for changes every day.',
      ar: 'كن مطمئناً لأن CodeGuard يتحقق بجدية من موقعك بحثاً عن التغييرات كل يوم.',
    },
  },
  {
    icon: Settings,
    title: { en: 'Automatic WordPress Updates', ar: 'تحديثات WordPress التلقائية' },
    description: {
      en: 'Automatically update WordPress and its plugins to keep it secure with auto recovery in case of problems.',
      ar: 'قم بتحديث WordPress وإضافاته تلقائياً للحفاظ على أمانه مع استرداد تلقائي في حالة حدوث مشاكل.',
    },
  },
  {
    icon: Bell,
    title: { en: 'File Change Monitoring', ar: 'مراقبة تغيير الملفات' },
    description: {
      en: 'Get notified by email anytime something changes within the source code of your site.',
      ar: 'احصل على إشعار بالبريد الإلكتروني في أي وقت يتغير فيه شيء في الكود المصدري لموقعك.',
    },
  },
  {
    icon: Server,
    title: { en: 'Staging of Restores', ar: 'اختبار الاستعادة' },
    description: {
      en: 'Quickly test any backed up site with simple and automated staging prior to restore.',
      ar: 'اختبر بسرعة أي موقع منسوخ احتياطياً مع اختبار بسيط وآلي قبل الاستعادة.',
    },
  },
  {
    icon: Mail,
    title: { en: 'Email Backup', ar: 'نسخ احتياطي للبريد الإلكتروني' },
    description: {
      en: 'Get protection for your emails too as they are backed up as part of your websites files.',
      ar: 'احصل على حماية لبريدك الإلكتروني أيضاً حيث يتم نسخه احتياطياً كجزء من ملفات موقعك.',
    },
  },
  {
    icon: Zap,
    title: { en: 'Full Automation', ar: 'أتمتة كاملة' },
    description: {
      en: 'Completely hands free setup and ongoing backups with automated notifications if things go wrong.',
      ar: 'إعداد بدون تدخل بالكامل ونسخ احتياطي مستمر مع إشعارات آلية إذا حدث خطأ.',
    },
  },
];

// FAQ Data
const faqs = [
  {
    question: { en: 'What is CodeGuard?', ar: 'ما هو CodeGuard؟' },
    answer: {
      en: 'CodeGuard is a fully automated website backup service that gives you complete protection against data loss and malware.',
      ar: 'CodeGuard هي خدمة نسخ احتياطي آلية بالكامل للمواقع تمنحك حماية كاملة ضد فقدان البيانات والبرامج الضارة.',
    },
  },
  {
    question: { en: 'Why do I need CodeGuard?', ar: 'لماذا أحتاج CodeGuard؟' },
    answer: {
      en: 'CodeGuard provides an independent offsite backup solution for your website along with daily monitoring to ensure your website is online and malware free.',
      ar: 'يوفر CodeGuard حل نسخ احتياطي مستقل خارج الموقع لموقعك مع مراقبة يومية لضمان أن موقعك متصل وخالٍ من البرامج الضارة.',
    },
  },
  {
    question: { en: 'How does it work?', ar: 'كيف يعمل؟' },
    answer: {
      en: 'CodeGuard takes daily automated snapshots of your website. Using these snapshots, you can restore your entire site or a specific file to an earlier version at any time.',
      ar: 'يأخذ CodeGuard لقطات آلية يومية لموقعك. باستخدام هذه اللقطات، يمكنك استعادة موقعك بالكامل أو ملف معين إلى إصدار سابق في أي وقت.',
    },
  },
  {
    question: { en: 'What if I run out of storage?', ar: 'ماذا لو نفدت مساحة التخزين؟' },
    answer: {
      en: 'Switching plans is easy! You can upgrade and increase your disk storage allowance in just a few simple clicks via our client area.',
      ar: 'التبديل بين الخطط سهل! يمكنك الترقية وزيادة حصة تخزين القرص الخاصة بك ببضع نقرات بسيطة من خلال منطقة العملاء.',
    },
  },
  {
    question: { en: 'Where are backups stored?', ar: 'أين يتم تخزين النسخ الاحتياطية؟' },
    answer: {
      en: 'Backups are stored on Amazon Web Services Simple Storage System which provides market leading resiliance and redundancy for your backups.',
      ar: 'يتم تخزين النسخ الاحتياطية على نظام تخزين Amazon Web Services البسيط الذي يوفر مرونة وتكراراً رائدين في السوق لنسخك الاحتياطية.',
    },
  },
  {
    question: { en: 'Are the backups encrypted?', ar: 'هل النسخ الاحتياطية مشفرة؟' },
    answer: {
      en: 'Yes, backups are stored encrypted using the AES-256 Encryption Standard.',
      ar: 'نعم، يتم تخزين النسخ الاحتياطية مشفرة باستخدام معيار التشفير AES-256.',
    },
  },
  {
    question: { en: 'Do you backup databases?', ar: 'هل تنسخون قواعد البيانات احتياطياً؟' },
    answer: {
      en: 'Yes, databases can be backed up also. Database backups are supported for MySQL and MSSQL databases.',
      ar: 'نعم، يمكن نسخ قواعد البيانات احتياطياً أيضاً. النسخ الاحتياطي لقواعد البيانات مدعوم لقواعد بيانات MySQL و MSSQL.',
    },
  },
  {
    question: { en: 'What is File Change Alert Monitoring?', ar: 'ما هي مراقبة تنبيهات تغيير الملفات؟' },
    answer: {
      en: 'CodeGuard can monitor and notify you by email when your website changes to alert you to new threats and malware.',
      ar: 'يمكن لـ CodeGuard مراقبتك وإعلامك بالبريد الإلكتروني عندما يتغير موقعك لتنبيهك إلى التهديدات الجديدة والبرامج الضارة.',
    },
  },
  {
    question: { en: 'What happens if my site gets infected?', ar: 'ماذا يحدث إذا أصيب موقعي؟' },
    answer: {
      en: "With CodeGuard's daily snapshots, if your website gets attacked, you can restore to a previous uninfected version at any time.",
      ar: 'مع لقطات CodeGuard اليومية، إذا تعرض موقعك للهجوم، يمكنك الاستعادة إلى إصدار سابق غير مصاب في أي وقت.',
    },
  },
];

export default function WebsiteBackupPage() {
  const locale = useLocale();
  const isRTL = locale === 'ar';
  const [selectedPlan, setSelectedPlan] = useState<string>('10gb');
  const [expandedFaq, setExpandedFaq] = useState<number | null>(null);
  const heroRef = useRef<HTMLDivElement>(null);
  const plansRef = useRef<HTMLDivElement>(null);

  useEffect(() => {
    // Hero animation
    if (heroRef.current) {
      gsap.fromTo(
        heroRef.current.children,
        { opacity: 0, y: 30 },
        { opacity: 1, y: 0, duration: 0.8, stagger: 0.2, ease: 'power3.out' }
      );
    }

    // Plans animation
    if (plansRef.current) {
      gsap.fromTo(
        plansRef.current.children,
        { opacity: 0, y: 50 },
        {
          opacity: 1,
          y: 0,
          duration: 0.6,
          stagger: 0.1,
          ease: 'power3.out',
          scrollTrigger: {
            trigger: plansRef.current,
            start: 'top 80%',
          },
        }
      );
    }
  }, []);

  const toggleFaq = (index: number) => {
    setExpandedFaq(expandedFaq === index ? null : index);
  };

  const currentPlan = codeguardPlans.find(p => p.id === selectedPlan) || codeguardPlans[2];

  // JSON-LD Structured Data
  const baseUrl = process.env.NEXT_PUBLIC_SITE_URL || 'https://progineous.com';
  
  const serviceSchema = {
    '@context': 'https://schema.org',
    '@type': 'SoftwareApplication',
    name: 'CodeGuard Website Backup',
    description: isRTL
      ? 'خدمة النسخ الاحتياطي اليومي التلقائي للمواقع مع استعادة بنقرة واحدة'
      : 'Automatic daily website backup service with one-click restore',
    applicationCategory: 'UtilitiesApplication',
    operatingSystem: 'Web',
    offers: {
      '@type': 'AggregateOffer',
      lowPrice: '2.09',
      highPrice: '55.86',
      priceCurrency: 'USD',
      offerCount: codeguardPlans.length,
    },
  };

  const breadcrumbSchema = {
    '@context': 'https://schema.org',
    '@type': 'BreadcrumbList',
    itemListElement: [
      { '@type': 'ListItem', position: 1, name: isRTL ? 'الرئيسية' : 'Home', item: `${baseUrl}/${locale}` },
      { '@type': 'ListItem', position: 2, name: isRTL ? 'السوق' : 'Market', item: `${baseUrl}/${locale}/market` },
      { '@type': 'ListItem', position: 3, name: isRTL ? 'نسخ احتياطي' : 'Website Backup', item: `${baseUrl}/${locale}/market/website-backup` },
    ],
  };

  return (
    <main className={cn("min-h-screen bg-gray-50", isRTL && "rtl")}>
      {/* JSON-LD Structured Data */}
      <script type="application/ld+json" dangerouslySetInnerHTML={{ __html: JSON.stringify(serviceSchema) }} />
      <script type="application/ld+json" dangerouslySetInnerHTML={{ __html: JSON.stringify(breadcrumbSchema) }} />

      {/* Hero Section */}
      <section className="relative bg-gradient-to-br from-[#1d71b8] via-[#155a94] to-[#0d3d66] text-white overflow-hidden">
        {/* Background Pattern */}
        <div className="absolute inset-0 opacity-10">
          <div className="absolute inset-0" style={{
            backgroundImage: `url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.4'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E")`,
          }} />
        </div>

        {/* Floating Icons */}
        <div className="absolute top-20 left-10 opacity-20">
          <Cloud className="w-24 h-24 animate-pulse" />
        </div>
        <div className="absolute bottom-20 right-10 opacity-20">
          <Database className="w-32 h-32 animate-pulse" style={{ animationDelay: '1s' }} />
        </div>

        <div className="container mx-auto px-4 py-20 md:py-28 relative z-10">
          <div className="grid lg:grid-cols-2 gap-12 items-center">
            <div ref={heroRef}>
              {/* CodeGuard Logo */}
              <div className="mb-6 flex items-center gap-3">
                <div className="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                  <Shield className="w-7 h-7" />
                </div>
                <span className="text-2xl font-bold">CodeGuard</span>
              </div>

              <h1 className="text-4xl md:text-5xl font-bold mb-6">
                {isRTL 
                  ? 'احمِ موقعك بنسخ احتياطي يومي تلقائي'
                  : 'Protect your website with daily automated backups'}
              </h1>
              
              <p className="text-xl text-blue-100 mb-8">
                {isRTL
                  ? 'احصل على حماية ضد الفيروسات والمخترقين وحتى كودك عندما يتسبب بطريق الخطأ في تعطل موقعك مع CodeGuard Website Backup.'
                  : 'Get protection against viruses, hackers and even your own code accidentally breaking your site with CodeGuard Website Backup.'}
              </p>

              <div className="flex flex-col sm:flex-row gap-4">
                <a
                  href="#plans"
                  className="px-8 py-4 bg-white text-[#1d71b8] rounded-xl font-semibold hover:bg-blue-50 transition-all flex items-center justify-center gap-2"
                >
                  {isRTL ? 'عرض الخطط' : 'View Plans'}
                  <ArrowRight className={cn("w-5 h-5", isRTL && "rotate-180")} />
                </a>
                <a
                  href="#features"
                  className="px-8 py-4 border-2 border-white/30 text-white rounded-xl font-semibold hover:bg-white/10 transition-all text-center"
                >
                  {isRTL ? 'تعرف على المزيد' : 'Learn More'}
                </a>
              </div>
            </div>

            {/* Hero Illustration */}
            <div className="hidden lg:flex items-center justify-center">
              <div className="relative">
                {/* Main Cloud Icon */}
                <div className="w-64 h-64 bg-white/10 rounded-full flex items-center justify-center backdrop-blur-sm">
                  <Cloud className="w-32 h-32 text-white/80" />
                </div>
                {/* Floating elements */}
                <div className="absolute -top-4 -right-4 w-16 h-16 bg-green-400/20 rounded-xl flex items-center justify-center animate-bounce" style={{ animationDelay: '0.5s' }}>
                  <Check className="w-8 h-8 text-green-400" />
                </div>
                <div className="absolute -bottom-4 -left-4 w-16 h-16 bg-blue-400/20 rounded-xl flex items-center justify-center animate-bounce" style={{ animationDelay: '1s' }}>
                  <Database className="w-8 h-8 text-blue-300" />
                </div>
                <div className="absolute top-1/2 -right-8 w-12 h-12 bg-white/10 rounded-lg flex items-center justify-center animate-pulse">
                  <Lock className="w-6 h-6 text-white/60" />
                </div>
              </div>
            </div>
          </div>
        </div>

        {/* Wave Divider */}
        <div className="absolute bottom-0 left-0 right-0">
          <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" className="w-full h-[60px] md:h-[120px]">
            <path d="M0 120L60 105C120 90 240 60 360 45C480 30 600 30 720 37.5C840 45 960 60 1080 67.5C1200 75 1320 75 1380 75L1440 75V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0Z" fill="#f9fafb"/>
          </svg>
        </div>
      </section>

      {/* Stats Section */}
      <section className="py-16 bg-gray-50">
        <div className="container mx-auto px-4">
          <div className="text-center mb-12">
            <h2 className="text-2xl md:text-3xl font-bold text-gray-900 mb-4">
              {isRTL 
                ? 'كل 0.65 ثانية، يتم إصابة صفحة ويب جديدة ببرامج ضارة.'
                : 'Every 0.65 seconds, a new web page is infected with malware.'}
            </h2>
            <p className="text-gray-600 max-w-3xl mx-auto">
              {isRTL
                ? 'احمِ موقعك من فقدان البيانات والتلف، وكذلك من التهديدات من الفيروسات والمخترقين والبرامج الضارة مع النسخ الاحتياطي اليومي التلقائي للموقع من CodeGuard.'
                : 'Protect your site from data loss and corruption, as well as against threats from viruses, hackers and malware with Daily Automated Website Backups from CodeGuard.'}
            </p>
          </div>

          {/* Hero Features */}
          <div className="grid grid-cols-2 md:grid-cols-5 gap-4 max-w-5xl mx-auto">
            {heroFeatures.map((feature, index) => (
              <div
                key={index}
                className="bg-white rounded-xl p-4 text-center shadow-sm hover:shadow-md transition-shadow"
              >
                <div className="w-12 h-12 bg-[#1d71b8]/10 rounded-xl flex items-center justify-center mx-auto mb-3">
                  <feature.icon className="w-6 h-6 text-[#1d71b8]" />
                </div>
                <p className="text-sm font-medium text-gray-700">
                  {isRTL ? feature.title.ar : feature.title.en}
                </p>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* Plans Section */}
      <section id="plans" className="py-20 bg-white">
        <div className="container mx-auto px-4">
          <div className="text-center mb-12">
            <h2 className="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
              {isRTL ? 'اختر مساحة التخزين الاحتياطي' : 'Choose Backup Storage'}
            </h2>
          </div>

          {/* Storage Tabs */}
          <div ref={plansRef} className="flex flex-wrap justify-center gap-2 mb-8 max-w-3xl mx-auto">
            {codeguardPlans.map((plan) => (
              <button
                key={plan.id}
                onClick={() => setSelectedPlan(plan.id)}
                className={cn(
                  "px-6 py-3 rounded-xl font-semibold transition-all",
                  selectedPlan === plan.id
                    ? "bg-[#1d71b8] text-white shadow-lg"
                    : "bg-gray-100 text-gray-700 hover:bg-gray-200"
                )}
              >
                {plan.storage}
              </button>
            ))}
          </div>

          {/* Selected Plan Details */}
          <div className="max-w-lg mx-auto">
            <div className="bg-gradient-to-br from-[#1d71b8] to-[#155a94] rounded-2xl p-8 text-white text-center shadow-xl">
              <div className="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4">
                <HardDrive className="w-8 h-8" />
              </div>
              <h3 className="text-3xl font-bold mb-2">{currentPlan.storage}</h3>
              <p className="text-blue-100 mb-4">{isRTL ? 'مساحة تخزين النسخ الاحتياطي' : 'Backup Storage Space'}</p>
              <div className="flex items-baseline justify-center gap-1 mb-6">
                <span className="text-5xl font-bold">${currentPlan.price}</span>
                <span className="text-blue-200">USD/{isRTL ? 'شهرياً' : 'Monthly'}</span>
              </div>
              <a
                href={currentPlan.cartLink}
                target="_blank"
                rel="noopener noreferrer"
                className="inline-flex items-center gap-2 px-8 py-4 bg-white text-[#1d71b8] rounded-xl font-semibold hover:bg-blue-50 transition-all"
              >
                {isRTL ? 'اطلب الآن' : 'Order Now'}
                <ArrowRight className={cn("w-5 h-5", isRTL && "rotate-180")} />
              </a>
            </div>
          </div>

          {/* All Plans Included Features */}
          <div className="mt-12 text-center">
            <p className="text-gray-600 mb-4">
              {isRTL ? 'جميع الخطط تتضمن:' : 'All plans include:'}
            </p>
            <div className="flex flex-wrap justify-center gap-4">
              {[
                { en: 'Daily Backups', ar: 'نسخ احتياطي يومي' },
                { en: 'Unlimited Files', ar: 'ملفات غير محدودة' },
                { en: 'One-Click Restore', ar: 'استعادة بنقرة واحدة' },
                { en: 'Malware Monitoring', ar: 'مراقبة البرامج الضارة' },
                { en: 'Email Backup', ar: 'نسخ احتياطي للبريد' },
              ].map((feature, idx) => (
                <div key={idx} className="flex items-center gap-2 text-sm text-gray-700">
                  <Check className="w-4 h-4 text-green-500" />
                  {isRTL ? feature.ar : feature.en}
                </div>
              ))}
            </div>
          </div>
        </div>
      </section>

      {/* Features Section */}
      <section id="features" className="py-20 bg-gray-50">
        <div className="container mx-auto px-4">
          <div className="text-center mb-12">
            <h2 className="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
              {isRTL ? 'ميزات CodeGuard' : 'CodeGuard Features'}
            </h2>
          </div>

          <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-6xl mx-auto">
            {codeguardFeatures.map((feature, index) => (
              <div
                key={index}
                className="bg-white rounded-xl p-6 hover:shadow-lg transition-shadow"
              >
                <div className="w-12 h-12 bg-[#1d71b8]/10 rounded-xl flex items-center justify-center mb-4">
                  <feature.icon className="w-6 h-6 text-[#1d71b8]" />
                </div>
                <h3 className="text-lg font-semibold text-gray-900 mb-2">
                  {isRTL ? feature.title.ar : feature.title.en}
                </h3>
                <p className="text-gray-600 text-sm">
                  {isRTL ? feature.description.ar : feature.description.en}
                </p>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* Security Info Section */}
      <section className="py-20 bg-white">
        <div className="container mx-auto px-4">
          <div className="grid lg:grid-cols-2 gap-12 items-center max-w-6xl mx-auto">
            <div className="flex items-center justify-center">
              {/* Backup Illustration */}
              <div className="relative bg-gradient-to-br from-[#1d71b8]/10 to-[#1d71b8]/5 rounded-3xl p-12">
                <div className="grid grid-cols-3 gap-4">
                  {[1, 2, 3, 4, 5, 6].map((i) => (
                    <div key={i} className={cn(
                      "w-16 h-16 rounded-xl flex items-center justify-center transition-all",
                      i === 3 ? "bg-[#1d71b8] text-white scale-110 shadow-lg" : "bg-white shadow-sm"
                    )}>
                      <History className={cn("w-8 h-8", i !== 3 && "text-[#1d71b8]")} />
                    </div>
                  ))}
                </div>
                <div className="absolute -bottom-4 left-1/2 -translate-x-1/2 bg-green-500 text-white px-4 py-2 rounded-full text-sm font-medium flex items-center gap-2">
                  <RefreshCw className="w-4 h-4" />
                  {isRTL ? 'استعادة بنقرة واحدة' : 'One-Click Restore'}
                </div>
              </div>
            </div>
            <div>
              <h2 className="text-3xl md:text-4xl font-bold text-gray-900 mb-6">
                {isRTL ? 'استعادة موقعك في أي وقت' : 'Restore Your Site Anytime'}
              </h2>
              <p className="text-gray-600 mb-6">
                {isRTL
                  ? 'مع CodeGuard Website Backup، يتم نسخ موقعك احتياطياً يومياً وإذا حدثت كارثة، يمكنك استعادة موقعك إلى نقطة سابقة في الوقت بنقرة زر واحدة.'
                  : 'With CodeGuard Website Backup, your website is backed up daily and if disaster strikes, you can restore your site to a previous point in time at the click of a button.'}
              </p>
              <ul className="space-y-4">
                <li className="flex items-start gap-3">
                  <div className="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center shrink-0">
                    <Check className="w-5 h-5 text-green-600" />
                  </div>
                  <span className="text-gray-700">
                    {isRTL ? 'النسخ الاحتياطية مخزنة على AWS مع تكرار' : 'Backups stored on AWS with redundancy'}
                  </span>
                </li>
                <li className="flex items-start gap-3">
                  <div className="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center shrink-0">
                    <Lock className="w-5 h-5 text-green-600" />
                  </div>
                  <span className="text-gray-700">
                    {isRTL ? 'تشفير AES-256 لجميع النسخ الاحتياطية' : 'AES-256 encryption for all backups'}
                  </span>
                </li>
                <li className="flex items-start gap-3">
                  <div className="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center shrink-0">
                    <Database className="w-5 h-5 text-green-600" />
                  </div>
                  <span className="text-gray-700">
                    {isRTL ? 'دعم قواعد بيانات MySQL و MSSQL' : 'MySQL and MSSQL database support'}
                  </span>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </section>

      {/* FAQ Section */}
      <section className="py-20 bg-gray-50">
        <div className="container mx-auto px-4">
          <div className="text-center mb-12">
            <h2 className="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
              {isRTL ? 'الأسئلة الشائعة' : 'Frequently Asked Questions'}
            </h2>
          </div>

          <div className="max-w-3xl mx-auto space-y-4">
            {faqs.map((faq, index) => (
              <div
                key={index}
                className="bg-white rounded-xl shadow-sm overflow-hidden"
              >
                <button
                  onClick={() => toggleFaq(index)}
                  className="w-full px-6 py-4 flex items-center justify-between text-left hover:bg-gray-50 transition-colors"
                >
                  <span className="font-semibold text-gray-900">
                    {isRTL ? faq.question.ar : faq.question.en}
                  </span>
                  {expandedFaq === index ? (
                    <ChevronUp className="w-5 h-5 text-gray-500" />
                  ) : (
                    <ChevronDown className="w-5 h-5 text-gray-500" />
                  )}
                </button>
                {expandedFaq === index && (
                  <div className="px-6 pb-4">
                    <p className="text-gray-600">
                      {isRTL ? faq.answer.ar : faq.answer.en}
                    </p>
                  </div>
                )}
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* CTA Section */}
      <section className="py-20 bg-[#1d71b8]">
        <div className="container mx-auto px-4 text-center">
          <h2 className="text-3xl md:text-4xl font-bold text-white mb-6">
            {isRTL ? 'ابدأ بحماية موقعك اليوم' : 'Start Protecting Your Website Today'}
          </h2>
          <p className="text-blue-100 text-lg mb-8 max-w-2xl mx-auto">
            {isRTL
              ? 'لا تنتظر حتى فوات الأوان. احصل على نسخ احتياطي يومي تلقائي لموقعك ابتداءً من $3.49 فقط شهرياً.'
              : "Don't wait until it's too late. Get daily automated backups for your website starting at just $3.49/month."}
          </p>
          <a
            href="#plans"
            className="inline-flex items-center gap-2 px-8 py-4 bg-white text-[#1d71b8] rounded-xl font-semibold hover:bg-blue-50 transition-all"
          >
            {isRTL ? 'ابدأ الآن' : 'Get Started Now'}
            <ArrowRight className={cn("w-5 h-5", isRTL && "rotate-180")} />
          </a>
        </div>
      </section>
    </main>
  );
}
