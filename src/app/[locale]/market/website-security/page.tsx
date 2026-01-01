'use client';

import { useState, useEffect, useRef } from 'react';
import { useLocale } from 'next-intl';
import { Link } from '@/i18n/routing';
import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import {
  Shield,
  ShieldCheck,
  ShieldAlert,
  Check,
  X,
  ChevronDown,
  ChevronUp,
  ArrowRight,
  Globe,
  Zap,
  Bug,
  Scan,
  Lock,
  BadgeCheck,
  AlertTriangle,
  RefreshCw,
  Clock,
  Headphones,
  FileSearch,
  Server,
  Gauge,
} from 'lucide-react';
import { cn } from '@/lib/utils';

// Register GSAP plugins
if (typeof window !== 'undefined') {
  gsap.registerPlugin(ScrollTrigger);
}

// SiteLock Plan Interface
interface SiteLockPlan {
  id: string;
  name: string;
  nameAr: string;
  price: number;
  description: string;
  descriptionAr: string;
  cartLink: string;
  popular?: boolean;
  features: {
    name: string;
    nameAr: string;
    value: string | boolean;
  }[];
}

// SiteLock Plans Data
const sitelockPlans: SiteLockPlan[] = [
  {
    id: 'find',
    name: 'Find',
    nameAr: 'اكتشف',
    price: 24.99,
    description: 'Scans your sites for malware and vulnerabilities',
    descriptionAr: 'يفحص مواقعك بحثاً عن البرامج الضارة والثغرات',
    cartLink: 'https://app.progineous.com/store/sitelock/find',
    features: [
      { name: 'Daily Malware Scanning', nameAr: 'فحص البرامج الضارة يومياً', value: true },
      { name: 'Number of Pages', nameAr: 'عدد الصفحات', value: '25' },
      { name: 'Daily Blacklist Monitoring', nameAr: 'مراقبة القائمة السوداء يومياً', value: true },
      { name: 'SiteLock Risk Score', nameAr: 'تقييم مخاطر SiteLock', value: true },
      { name: 'Website Application Scan', nameAr: 'فحص تطبيق الموقع', value: 'One Time' },
      { name: 'SQL Injection Scan', nameAr: 'فحص حقن SQL', value: 'One Time' },
      { name: 'Cross Site (XSS) Scan', nameAr: 'فحص XSS', value: 'One Time' },
      { name: 'SiteLock™ Trust Seal', nameAr: 'ختم ثقة SiteLock™', value: true },
      { name: 'Daily SMART Scans', nameAr: 'فحوصات SMART اليومية', value: false },
      { name: 'Automatic Malware Removal', nameAr: 'إزالة البرامج الضارة تلقائياً', value: false },
      { name: 'TrueShield Protection', nameAr: 'حماية TrueShield', value: false },
      { name: 'WordPress Scan', nameAr: 'فحص WordPress', value: false },
      { name: 'Spam Blacklist Monitoring', nameAr: 'مراقبة قائمة السبام', value: false },
      { name: 'Web Application Firewall', nameAr: 'جدار حماية التطبيقات', value: false },
      { name: 'Global CDN', nameAr: 'شبكة CDN العالمية', value: false },
      { name: 'Content Acceleration', nameAr: 'تسريع المحتوى', value: false },
    ],
  },
  {
    id: 'fix',
    name: 'Fix',
    nameAr: 'إصلاح',
    price: 99.99,
    description: 'Finds and removes malicious code automatically',
    descriptionAr: 'يكتشف ويزيل الأكواد الضارة تلقائياً',
    cartLink: 'https://app.progineous.com/store/sitelock/fix',
    popular: true,
    features: [
      { name: 'Daily Malware Scanning', nameAr: 'فحص البرامج الضارة يومياً', value: true },
      { name: 'Number of Pages', nameAr: 'عدد الصفحات', value: '500' },
      { name: 'Daily Blacklist Monitoring', nameAr: 'مراقبة القائمة السوداء يومياً', value: true },
      { name: 'SiteLock Risk Score', nameAr: 'تقييم مخاطر SiteLock', value: true },
      { name: 'Website Application Scan', nameAr: 'فحص تطبيق الموقع', value: 'Daily' },
      { name: 'SQL Injection Scan', nameAr: 'فحص حقن SQL', value: 'Daily' },
      { name: 'Cross Site (XSS) Scan', nameAr: 'فحص XSS', value: 'Daily' },
      { name: 'SiteLock™ Trust Seal', nameAr: 'ختم ثقة SiteLock™', value: true },
      { name: 'Daily SMART Scans', nameAr: 'فحوصات SMART اليومية', value: true },
      { name: 'Automatic Malware Removal', nameAr: 'إزالة البرامج الضارة تلقائياً', value: true },
      { name: 'TrueShield Protection', nameAr: 'حماية TrueShield', value: true },
      { name: 'WordPress Scan', nameAr: 'فحص WordPress', value: true },
      { name: 'Spam Blacklist Monitoring', nameAr: 'مراقبة قائمة السبام', value: true },
      { name: 'Web Application Firewall', nameAr: 'جدار حماية التطبيقات', value: false },
      { name: 'Global CDN', nameAr: 'شبكة CDN العالمية', value: false },
      { name: 'Content Acceleration', nameAr: 'تسريع المحتوى', value: false },
    ],
  },
  {
    id: 'defend',
    name: 'Defend',
    nameAr: 'دفاع',
    price: 299.99,
    description: 'Find, fix and prevent threats with website acceleration',
    descriptionAr: 'اكتشف وأصلح وامنع التهديدات مع تسريع الموقع',
    cartLink: 'https://app.progineous.com/store/sitelock/defend',
    features: [
      { name: 'Daily Malware Scanning', nameAr: 'فحص البرامج الضارة يومياً', value: true },
      { name: 'Number of Pages', nameAr: 'عدد الصفحات', value: '500' },
      { name: 'Daily Blacklist Monitoring', nameAr: 'مراقبة القائمة السوداء يومياً', value: true },
      { name: 'SiteLock Risk Score', nameAr: 'تقييم مخاطر SiteLock', value: true },
      { name: 'Website Application Scan', nameAr: 'فحص تطبيق الموقع', value: 'Daily' },
      { name: 'SQL Injection Scan', nameAr: 'فحص حقن SQL', value: 'Daily' },
      { name: 'Cross Site (XSS) Scan', nameAr: 'فحص XSS', value: 'Daily' },
      { name: 'SiteLock™ Trust Seal', nameAr: 'ختم ثقة SiteLock™', value: true },
      { name: 'Daily SMART Scans', nameAr: 'فحوصات SMART اليومية', value: true },
      { name: 'Automatic Malware Removal', nameAr: 'إزالة البرامج الضارة تلقائياً', value: true },
      { name: 'TrueShield Protection', nameAr: 'حماية TrueShield', value: true },
      { name: 'WordPress Scan', nameAr: 'فحص WordPress', value: true },
      { name: 'Spam Blacklist Monitoring', nameAr: 'مراقبة قائمة السبام', value: true },
      { name: 'Web Application Firewall', nameAr: 'جدار حماية التطبيقات', value: true },
      { name: 'Global CDN', nameAr: 'شبكة CDN العالمية', value: true },
      { name: 'Content Acceleration', nameAr: 'تسريع المحتوى', value: true },
    ],
  },
];

// Features Data
const sitelockFeatures = [
  {
    icon: Scan,
    title: { en: 'Malware Scan', ar: 'فحص البرامج الضارة' },
    description: {
      en: 'Proactively monitors for and alerts you about any malware that is detected on your website.',
      ar: 'يراقب بشكل استباقي وينبهك بشأن أي برامج ضارة يتم اكتشافها على موقعك.',
    },
  },
  {
    icon: Bug,
    title: { en: 'Automatic Malware Removal', ar: 'إزالة البرامج الضارة تلقائياً' },
    description: {
      en: 'If a scan finds anything, SiteLock will safely remove any known malware automatically.',
      ar: 'إذا وجد الفحص أي شيء، سيقوم SiteLock بإزالة أي برامج ضارة معروفة بأمان وتلقائياً.',
    },
  },
  {
    icon: FileSearch,
    title: { en: 'Vulnerability Scan', ar: 'فحص الثغرات' },
    description: {
      en: 'Automatically checks your applications to ensure they\'re up-to-date and secured against known vulnerabilities.',
      ar: 'يتحقق تلقائياً من تطبيقاتك للتأكد من أنها محدثة ومؤمنة ضد الثغرات المعروفة.',
    },
  },
  {
    icon: Shield,
    title: { en: 'OWASP Protection', ar: 'حماية OWASP' },
    description: {
      en: 'Get protection against the top 10 web app security flaws as recognised by OWASP, the Open Web Application Security Project.',
      ar: 'احصل على حماية ضد أهم 10 ثغرات أمنية لتطبيقات الويب المعترف بها من OWASP.',
    },
  },
  {
    icon: BadgeCheck,
    title: { en: 'SiteLock™ Trust Seal', ar: 'ختم ثقة SiteLock™' },
    description: {
      en: 'Give your visitors added confidence by showing your website is protected by SiteLock.',
      ar: 'امنح زوارك ثقة إضافية بإظهار أن موقعك محمي بواسطة SiteLock.',
    },
  },
  {
    icon: Lock,
    title: { en: 'Firewall', ar: 'جدار الحماية' },
    description: {
      en: 'The TrueShield™ Web Application Firewall protects your website against hackers and attacks.',
      ar: 'يحمي جدار حماية TrueShield™ موقعك ضد المخترقين والهجمات.',
    },
  },
  {
    icon: ShieldCheck,
    title: { en: 'Protect Your Reputation', ar: 'احمِ سمعتك' },
    description: {
      en: 'Daily scans help detect malware early before search engines have a chance to find it and blacklist your site.',
      ar: 'تساعد الفحوصات اليومية في اكتشاف البرامج الضارة مبكراً قبل أن تجدها محركات البحث وتضع موقعك في القائمة السوداء.',
    },
  },
  {
    icon: Zap,
    title: { en: 'Fast Automated Setup', ar: 'إعداد آلي سريع' },
    description: {
      en: 'Instant and fully automated setup gives you protection immediately without anything to install.',
      ar: 'إعداد فوري وآلي بالكامل يمنحك الحماية فوراً دون الحاجة لتثبيت أي شيء.',
    },
  },
  {
    icon: Globe,
    title: { en: 'Content Delivery Network (CDN)', ar: 'شبكة توصيل المحتوى (CDN)' },
    description: {
      en: 'Speed up your website by distributing it globally and serving it to your visitors from the closest location.',
      ar: 'سرّع موقعك بتوزيعه عالمياً وتقديمه لزوارك من أقرب موقع.',
    },
  },
];

// Emergency Response Features
const emergencyFeatures = [
  {
    icon: Clock,
    title: { en: 'Immediate Response', ar: 'استجابة فورية' },
    description: {
      en: 'Get our fastest response time with analysis and work to recover your site started within 30 minutes.',
      ar: 'احصل على أسرع وقت استجابة مع التحليل والعمل على استرداد موقعك خلال 30 دقيقة.',
    },
  },
  {
    icon: Bug,
    title: { en: 'Complete Malware Removal', ar: 'إزالة كاملة للبرامج الضارة' },
    description: {
      en: 'If our automatic technology is unable to remove the malicious content we\'ll perform manual cleaning.',
      ar: 'إذا لم تتمكن تقنيتنا الآلية من إزالة المحتوى الضار، سنقوم بالتنظيف اليدوي.',
    },
  },
  {
    icon: Zap,
    title: { en: 'Priority Treatment', ar: 'معاملة ذات أولوية' },
    description: {
      en: 'With the emergency package you get fast tracked straight to the top of the queue.',
      ar: 'مع الحزمة الطارئة تحصل على مسار سريع مباشرة إلى أعلى قائمة الانتظار.',
    },
  },
  {
    icon: ShieldCheck,
    title: { en: '7 Day Aftercare', ar: 'رعاية لمدة 7 أيام' },
    description: {
      en: 'We\'ll continue to monitor your site for 7 days to ensure that your site remains malware-free post recovery.',
      ar: 'سنستمر في مراقبة موقعك لمدة 7 أيام لضمان بقائه خالياً من البرامج الضارة بعد الاسترداد.',
    },
  },
  {
    icon: RefreshCw,
    title: { en: 'Real-time Updates', ar: 'تحديثات فورية' },
    description: {
      en: 'Track progress with our real-time updates throughout the process of cleaning and recovering your site.',
      ar: 'تتبع التقدم مع تحديثاتنا الفورية طوال عملية تنظيف واسترداد موقعك.',
    },
  },
  {
    icon: BadgeCheck,
    title: { en: 'One-off Payment', ar: 'دفعة واحدة' },
    description: {
      en: 'The emergency service is available for a single one-off fee, there\'s no recurring fees or subscription.',
      ar: 'الخدمة الطارئة متاحة برسوم لمرة واحدة فقط، لا توجد رسوم متكررة أو اشتراك.',
    },
  },
];

// FAQ Data
const faqs = [
  {
    question: { en: 'What is SiteLock?', ar: 'ما هو SiteLock؟' },
    answer: {
      en: 'SiteLock is a cloud-based website security solution that protects your website from cyber threats, malware, and vulnerabilities. It provides daily scanning, automatic malware removal, and a trust seal to boost visitor confidence.',
      ar: 'SiteLock هو حل أمان مواقع قائم على السحابة يحمي موقعك من التهديدات السيبرانية والبرامج الضارة والثغرات. يوفر فحصاً يومياً وإزالة تلقائية للبرامج الضارة وختم ثقة لتعزيز ثقة الزوار.',
    },
  },
  {
    question: { en: 'What does SiteLock do?', ar: 'ماذا يفعل SiteLock؟' },
    answer: {
      en: 'SiteLock scans your website for malware, vulnerabilities, and security threats. It automatically removes malicious code, protects against SQL injection and XSS attacks, monitors blacklists, and provides a trust seal for your website.',
      ar: 'يفحص SiteLock موقعك بحثاً عن البرامج الضارة والثغرات والتهديدات الأمنية. يزيل الأكواد الضارة تلقائياً، ويحمي من حقن SQL وهجمات XSS، ويراقب القوائم السوداء، ويوفر ختم ثقة لموقعك.',
    },
  },
  {
    question: { en: 'What types of issues does SiteLock scan for?', ar: 'ما أنواع المشاكل التي يفحصها SiteLock؟' },
    answer: {
      en: 'SiteLock scans for malware, viruses, SQL injection vulnerabilities, cross-site scripting (XSS), application vulnerabilities, spam, and checks if your site has been blacklisted by search engines or security services.',
      ar: 'يفحص SiteLock البرامج الضارة والفيروسات وثغرات حقن SQL والبرمجة عبر المواقع (XSS) وثغرات التطبيقات والسبام، ويتحقق مما إذا كان موقعك قد تم إدراجه في القائمة السوداء بواسطة محركات البحث أو خدمات الأمان.',
    },
  },
  {
    question: { en: 'What are vulnerabilities and malware?', ar: 'ما هي الثغرات والبرامج الضارة؟' },
    answer: {
      en: 'Vulnerabilities are security weaknesses in your website or applications that hackers can exploit. Malware is malicious software designed to damage, disrupt, or gain unauthorized access to your website or visitors\' data.',
      ar: 'الثغرات هي نقاط ضعف أمنية في موقعك أو تطبيقاتك يمكن للمخترقين استغلالها. البرامج الضارة هي برمجيات خبيثة مصممة لإتلاف أو تعطيل أو الوصول غير المصرح به إلى موقعك أو بيانات زوارك.',
    },
  },
  {
    question: { en: 'Will SiteLock impact website performance?', ar: 'هل سيؤثر SiteLock على أداء الموقع؟' },
    answer: {
      en: 'No, SiteLock is designed to have minimal impact on your website\'s performance. In fact, the Defend plan includes a CDN (Content Delivery Network) that can actually speed up your website by serving content from servers closest to your visitors.',
      ar: 'لا، تم تصميم SiteLock ليكون له تأثير ضئيل على أداء موقعك. في الواقع، تتضمن خطة Defend شبكة CDN يمكنها فعلياً تسريع موقعك من خلال تقديم المحتوى من الخوادم الأقرب لزوارك.',
    },
  },
  {
    question: { en: 'What is the SiteLock Trust Seal?', ar: 'ما هو ختم ثقة SiteLock؟' },
    answer: {
      en: 'The SiteLock Trust Seal is a badge you can display on your website that shows visitors your site is scanned and secured by SiteLock. This seal is proven to increase customer confidence and improve conversion rates.',
      ar: 'ختم ثقة SiteLock هو شارة يمكنك عرضها على موقعك تُظهر للزوار أن موقعك يتم فحصه وتأمينه بواسطة SiteLock. ثبت أن هذا الختم يزيد من ثقة العملاء ويحسن معدلات التحويل.',
    },
  },
];

export default function WebsiteSecurityPage() {
  const locale = useLocale();
  const isRTL = locale === 'ar';
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
          stagger: 0.15,
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

  // JSON-LD Structured Data
  const baseUrl = process.env.NEXT_PUBLIC_SITE_URL || 'https://progineous.com';
  
  const serviceSchema = {
    '@context': 'https://schema.org',
    '@type': 'Service',
    name: isRTL ? 'حماية الموقع SiteLock' : 'SiteLock Website Security',
    description: isRTL
      ? 'خدمة حماية المواقع من البرامج الضارة مع فحص يومي وإزالة تلقائية'
      : 'Website protection service with daily malware scanning and automatic removal',
    provider: {
      '@type': 'Organization',
      name: 'Pro Gineous',
      url: baseUrl,
    },
    serviceType: 'Website Security',
    areaServed: 'Worldwide',
    hasOfferCatalog: {
      '@type': 'OfferCatalog',
      name: isRTL ? 'خطط SiteLock' : 'SiteLock Plans',
      itemListElement: sitelockPlans.map((plan, index) => ({
        '@type': 'Offer',
        itemOffered: {
          '@type': 'Service',
          name: isRTL ? plan.nameAr : plan.name,
          description: isRTL ? plan.descriptionAr : plan.description,
        },
        price: plan.price,
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
      { '@type': 'ListItem', position: 3, name: isRTL ? 'أمان الموقع' : 'Website Security', item: `${baseUrl}/${locale}/market/website-security` },
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

        {/* Floating Shield Icons */}
        <div className="absolute top-20 left-10 opacity-20">
          <Shield className="w-24 h-24 animate-pulse" />
        </div>
        <div className="absolute bottom-20 right-10 opacity-20">
          <ShieldCheck className="w-32 h-32 animate-pulse" style={{ animationDelay: '1s' }} />
        </div>

        <div className="container mx-auto px-4 py-20 md:py-28 relative z-10">
          <div ref={heroRef} className="max-w-4xl mx-auto text-center">
            {/* SiteLock Logo */}
            <div className="mb-6">
              <img 
                src="https://app.progineous.com/assets/img/marketconnect/sitelock/logo.png" 
                alt="SiteLock" 
                className="h-12 mx-auto brightness-0 invert"
              />
            </div>

            <h1 className="text-4xl md:text-5xl lg:text-6xl font-bold mb-6">
              {isRTL 
                ? 'افحص موقعك تلقائياً بحثاً عن البرامج الضارة واحمِ سمعتك'
                : 'Automatically scan your website for malware and protect online reputation'}
            </h1>
            
            <p className="text-xl md:text-2xl text-blue-100 mb-8">
              {isRTL
                ? 'أمان الموقع وحماية من البرامج الضارة لموقعك'
                : 'Website security & malware protection for your website'}
            </p>

            <p className="text-lg text-blue-200 mb-10 max-w-3xl mx-auto">
              {isRTL
                ? 'SiteLock™، الشركة الرائدة عالمياً في أمان المواقع، تحمي موقعك لتمنحك راحة البال. فحص البرامج الضارة اليومي من SiteLock يحدد الثغرات والأكواد الضارة المعروفة ويزيلها تلقائياً من موقعك لحماية موقعك وزوارك من التهديدات.'
                : "SiteLock™, the global leader in website security, protects your website to give you peace of mind. SiteLock's Daily Malware Scanning identifies vulnerabilities and known malicious code and automatically removes it from your website to protect your website and visitors against threats."}
            </p>

            <div className="flex flex-col sm:flex-row gap-4 justify-center">
              <a
                href="#plans"
                className="px-8 py-4 bg-white text-[#1d71b8] rounded-xl font-semibold hover:bg-blue-50 transition-all flex items-center justify-center gap-2"
              >
                {isRTL ? 'عرض الخطط' : 'View Plans'}
                <ArrowRight className={cn("w-5 h-5", isRTL && "rotate-180")} />
              </a>
              <a
                href="#features"
                className="px-8 py-4 border-2 border-white/30 text-white rounded-xl font-semibold hover:bg-white/10 transition-all"
              >
                {isRTL ? 'تعرف على المزيد' : 'Learn More'}
              </a>
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

      {/* Plans Section */}
      <section id="plans" className="py-20 bg-gray-50">
        <div className="container mx-auto px-4">
          <div className="text-center mb-12">
            <h2 className="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
              {isRTL ? 'قارن خطط SiteLock' : 'Compare SiteLock Plans'}
            </h2>
            <p className="text-gray-600 text-lg">
              {isRTL ? 'ميزات أمان احترافية لموقعك' : 'Professional security features for your website'}
            </p>
          </div>

          <div ref={plansRef} className="grid md:grid-cols-3 gap-8 max-w-6xl mx-auto">
            {sitelockPlans.map((plan) => (
              <div
                key={plan.id}
                className={cn(
                  "relative bg-white rounded-2xl shadow-lg overflow-hidden transition-transform hover:scale-105",
                  plan.popular && "ring-2 ring-[#1d71b8]"
                )}
              >
                {plan.popular && (
                  <div className="absolute top-0 right-0 bg-[#1d71b8] text-white px-4 py-1 text-sm font-semibold rounded-bl-xl">
                    {isRTL ? 'الأكثر شيوعاً' : 'Most Popular'}
                  </div>
                )}

                <div className="p-6">
                  {/* Plan Header */}
                  <div className="text-center mb-6">
                    <h3 className="text-2xl font-bold text-gray-900 mb-2">
                      {isRTL ? plan.nameAr : plan.name}
                    </h3>
                    <div className="flex items-baseline justify-center gap-1">
                      <span className="text-4xl font-bold text-[#1d71b8]">${plan.price}</span>
                      <span className="text-gray-500">/{isRTL ? 'سنة' : 'yr'}</span>
                    </div>
                    <p className="text-gray-600 mt-2 text-sm">
                      {isRTL ? plan.descriptionAr : plan.description}
                    </p>
                  </div>

                  {/* Features List */}
                  <ul className="space-y-3 mb-6">
                    {plan.features.map((feature, idx) => (
                      <li key={idx} className="flex items-center gap-3 text-sm">
                        {feature.value === false ? (
                          <X className="w-5 h-5 text-gray-300 shrink-0" />
                        ) : (
                          <Check className="w-5 h-5 text-green-500 shrink-0" />
                        )}
                        <span className={cn(
                          feature.value === false ? "text-gray-400" : "text-gray-700"
                        )}>
                          {isRTL ? feature.nameAr : feature.name}
                        </span>
                        {typeof feature.value === 'string' && (
                          <span className="ml-auto text-[#1d71b8] font-medium">
                            {feature.value}
                          </span>
                        )}
                      </li>
                    ))}
                  </ul>

                  {/* Buy Button */}
                  <a
                    href={plan.cartLink}
                    target="_blank"
                    rel="noopener noreferrer"
                    className={cn(
                      "w-full py-3 rounded-xl font-semibold transition-all flex items-center justify-center gap-2",
                      plan.popular
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

      {/* Features Section */}
      <section id="features" className="py-20 bg-white">
        <div className="container mx-auto px-4">
          <div className="text-center mb-12">
            <h2 className="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
              {isRTL ? 'ميزات SiteLock' : 'SiteLock Features'}
            </h2>
            <p className="text-gray-600 text-lg max-w-2xl mx-auto">
              {isRTL 
                ? 'يوفر مجموعة من الميزات المصممة لحماية موقعك وسمعة عملك'
                : 'Provides a range of features designed to protect both your website and your business\' reputation'}
            </p>
          </div>

          <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-6xl mx-auto">
            {sitelockFeatures.map((feature, index) => (
              <div
                key={index}
                className="bg-gray-50 rounded-xl p-6 hover:shadow-lg transition-shadow"
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

      {/* Emergency Response Section */}
      <section className="py-20 bg-gradient-to-br from-red-600 to-red-800 text-white">
        <div className="container mx-auto px-4">
          <div className="text-center mb-12">
            <div className="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-6">
              <AlertTriangle className="w-8 h-8" />
            </div>
            <h2 className="text-3xl md:text-4xl font-bold mb-4">
              {isRTL ? 'هل تم اختراق موقعك؟' : 'Website Hacked?'}
            </h2>
            <p className="text-xl text-red-100">
              {isRTL ? 'أصلحه الآن مع استجابة SiteLock الطارئة' : 'Fix it now with SiteLock Emergency Response'}
            </p>
            <p className="text-red-200 mt-4 max-w-2xl mx-auto">
              {isRTL
                ? 'إذا تعرض موقعك للهجوم والاختراق، احصل على مساعدة طارئة فورية لاستعادة موقعك بسرعة.'
                : 'If your website has been attacked and compromised get immediate emergency assistance to quickly recover your site.'}
            </p>
          </div>

          <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-6 max-w-5xl mx-auto mb-12">
            {emergencyFeatures.map((feature, index) => (
              <div
                key={index}
                className="bg-white/10 backdrop-blur-sm rounded-xl p-6"
              >
                <div className="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center mb-4">
                  <feature.icon className="w-5 h-5" />
                </div>
                <h3 className="text-lg font-semibold mb-2">
                  {isRTL ? feature.title.ar : feature.title.en}
                </h3>
                <p className="text-red-100 text-sm">
                  {isRTL ? feature.description.ar : feature.description.en}
                </p>
              </div>
            ))}
          </div>

          {/* Emergency CTA */}
          <div className="text-center">
            <div className="inline-block bg-white/10 backdrop-blur-sm rounded-2xl p-8">
              <p className="text-2xl font-bold mb-2">
                {isRTL ? 'فقط $199.99 دولار' : 'Only $199.99 USD'}
              </p>
              <p className="text-red-200 mb-6">
                {isRTL ? 'دفعة واحدة لـ 7 أيام من الحماية' : 'One Time for 7 days of protection'}
              </p>
              <a
                href="https://app.progineous.com/cart/order"
                target="_blank"
                rel="noopener noreferrer"
                className="inline-flex items-center gap-2 px-8 py-4 bg-white text-red-600 rounded-xl font-semibold hover:bg-red-50 transition-all"
              >
                {isRTL ? 'اشترِ الآن' : 'Buy Now'}
                <ArrowRight className={cn("w-5 h-5", isRTL && "rotate-180")} />
              </a>
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
            {isRTL ? 'احمِ موقعك اليوم' : 'Protect Your Website Today'}
          </h2>
          <p className="text-blue-100 text-lg mb-8 max-w-2xl mx-auto">
            {isRTL
              ? 'احصل على ختم ثقة SiteLock الذي يبني ثقة العملاء وثبت أنه يزيد المبيعات ومعدلات التحويل.'
              : 'Get the SiteLock Trust Seal which builds customer confidence and is proven to increase sales and conversion rates.'}
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
