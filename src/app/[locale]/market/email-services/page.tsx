'use client';

import { useState, useEffect, useRef } from 'react';
import { useLocale } from 'next-intl';
import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import {
  Mail,
  Shield,
  ShieldCheck,
  Server,
  Archive,
  Check,
  ChevronDown,
  ChevronUp,
  ArrowRight,
  Inbox,
  Send,
  Lock,
  Clock,
  Users,
  FileText,
  Zap,
  Eye,
  Ban,
} from 'lucide-react';
import { cn } from '@/lib/utils';

// Register GSAP plugins
if (typeof window !== 'undefined') {
  gsap.registerPlugin(ScrollTrigger);
}

// Email Service Plans
const emailPlans = [
  {
    id: 'incoming',
    name: 'Incoming Email Filtering',
    nameAr: 'فلترة البريد الوارد',
    tagline: { en: 'Protect your network', ar: 'احمِ شبكتك' },
    description: {
      en: 'Eliminate Spam and Viruses from email before they ever reach your network',
      ar: 'تخلص من الرسائل المزعجة والفيروسات قبل أن تصل إلى شبكتك',
    },
    price: 2.99,
    period: { en: '/mo/domain', ar: '/شهر/نطاق' },
    icon: Inbox,
    color: 'blue',
    cartLink: 'https://app.progineous.com/store/email-services/incoming-scanning',
  },
  {
    id: 'outgoing',
    name: 'Outgoing Email Filtering',
    nameAr: 'فلترة البريد الصادر',
    tagline: { en: 'Safeguard your reputation', ar: 'احمِ سمعتك' },
    description: {
      en: 'Prevent Spam and Viruses from ever unknowingly leaving your network',
      ar: 'امنع الرسائل المزعجة والفيروسات من مغادرة شبكتك دون علمك',
    },
    price: 2.99,
    period: { en: '/mo/domain', ar: '/شهر/نطاق' },
    icon: Send,
    color: 'green',
    cartLink: 'https://app.progineous.com/store/email-services/outgoing-scanning',
  },
  {
    id: 'archiving',
    name: 'Email Archiving',
    nameAr: 'أرشفة البريد الإلكتروني',
    tagline: { en: 'Backup and Compliance', ar: 'النسخ الاحتياطي والامتثال' },
    description: {
      en: 'Never lose an email again and ensure email data integrity for legal compliance',
      ar: 'لا تفقد بريداً إلكترونياً مرة أخرى وضمان سلامة البيانات للامتثال القانوني',
    },
    price: 68.99,
    period: { en: '/yr/domain', ar: '/سنة/نطاق' },
    icon: Archive,
    color: 'purple',
    cartLink: 'https://app.progineous.com/store/email-services/incoming-and-archiving-bundle',
  },
];

// Incoming Filter Benefits
const incomingBenefits = [
  { en: 'Full Inbox protection at competitive prices', ar: 'حماية كاملة للبريد بأسعار تنافسية' },
  { en: 'Extremely accurate filtering', ar: 'فلترة دقيقة للغاية' },
  { en: 'Easy configuration', ar: 'إعداد سهل' },
  { en: 'Increase inbound email continuity and redundancy', ar: 'زيادة استمرارية البريد الوارد والتكرار' },
  { en: 'Various reporting options', ar: 'خيارات تقارير متنوعة' },
  { en: 'Friendly interface to keep you in full control', ar: 'واجهة سهلة للتحكم الكامل' },
  { en: 'Increase employee productivity', ar: 'زيادة إنتاجية الموظفين' },
  { en: 'Compatible with any mail server', ar: 'متوافق مع أي خادم بريد' },
];

// Features
const features = [
  {
    icon: Shield,
    title: { en: 'Nearly 100% Accuracy', ar: 'دقة تقارب 100%' },
    description: {
      en: 'Block nearly 100% of viruses, malware and spam before they reach your inbox',
      ar: 'احظر ما يقرب من 100% من الفيروسات والبرامج الضارة والرسائل المزعجة قبل وصولها',
    },
  },
  {
    icon: Zap,
    title: { en: 'Fast Setup', ar: 'إعداد سريع' },
    description: {
      en: 'Setup is fast, automated and will be up and running protecting your email in minutes',
      ar: 'الإعداد سريع وآلي وسيعمل لحماية بريدك في دقائق',
    },
  },
  {
    icon: Eye,
    title: { en: 'Full Control', ar: 'تحكم كامل' },
    description: {
      en: 'Comprehensive control panel with log-search, quarantine, and many other tools',
      ar: 'لوحة تحكم شاملة مع البحث في السجلات والحجر الصحي وأدوات أخرى',
    },
  },
  {
    icon: Lock,
    title: { en: 'Secure Storage', ar: 'تخزين آمن' },
    description: {
      en: 'Email Archiving includes 10GB of compressed email storage by default',
      ar: 'أرشفة البريد تشمل 10 جيجابايت من التخزين المضغوط افتراضياً',
    },
  },
];

// How It Works Steps
const howItWorks = [
  {
    step: 1,
    title: { en: 'Domain Deployment', ar: 'نشر النطاق' },
    description: {
      en: 'Your domain is automatically deployed to the Incoming Filter and filtering is activated',
      ar: 'يتم نشر نطاقك تلقائياً إلى فلتر الوارد وتفعيل الفلترة',
    },
  },
  {
    step: 2,
    title: { en: 'Email Analysis', ar: 'تحليل البريد' },
    description: {
      en: 'Email passes through the SpamExperts filtering cloud where it is securely analyzed and scanned in real time',
      ar: 'يمر البريد عبر سحابة فلترة SpamExperts حيث يتم تحليله ومسحه في الوقت الفعلي',
    },
  },
  {
    step: 3,
    title: { en: 'Spam Quarantine', ar: 'حجر الرسائل المزعجة' },
    description: {
      en: 'Any message detected as spam is moved to quarantine, while non-spam is sent to your email server',
      ar: 'يتم نقل أي رسالة مكتشفة كرسالة مزعجة إلى الحجر الصحي، بينما يُرسل البريد السليم لخادمك',
    },
  },
  {
    step: 4,
    title: { en: 'Monitor & Control', ar: 'المراقبة والتحكم' },
    description: {
      en: 'Monitor quarantine through the SpamPanel, email reports, or directly in your email client',
      ar: 'راقب الحجر الصحي عبر SpamPanel أو تقارير البريد أو مباشرة في برنامج بريدك',
    },
  },
];

// FAQ Data
const faqs = [
  {
    question: { en: 'How does it work?', ar: 'كيف يعمل؟' },
    answer: {
      en: 'Email is routed through SpamExperts intelligent self-learning servers that will detect and block spam before it ever reaches you.',
      ar: 'يتم توجيه البريد عبر خوادم SpamExperts الذكية ذاتية التعلم التي تكتشف وتحظر الرسائل المزعجة قبل وصولها إليك.',
    },
  },
  {
    question: { en: 'How accurate is the filtering?', ar: 'ما مدى دقة الفلترة؟' },
    answer: {
      en: 'Thanks to processing millions of emails every day, our email filters have an industry leading rate with close to 100% accuracy.',
      ar: 'بفضل معالجة ملايين رسائل البريد يومياً، فلاتر البريد لدينا تتمتع بمعدل رائد في الصناعة بدقة تقارب 100%.',
    },
  },
  {
    question: { en: 'Can I recover messages that get blocked?', ar: 'هل يمكنني استرداد الرسائل المحظورة؟' },
    answer: {
      en: 'Yes, a comprehensive control panel with log-search, quarantine, and many other tools allows you to check the status of any email which passed through the system.',
      ar: 'نعم، لوحة تحكم شاملة مع البحث في السجلات والحجر الصحي وأدوات أخرى تتيح لك التحقق من حالة أي بريد مر عبر النظام.',
    },
  },
  {
    question: { en: 'How long does it take to setup?', ar: 'كم يستغرق الإعداد؟' },
    answer: {
      en: 'Setup is fast, automated and it will be up and running protecting your email in minutes.',
      ar: 'الإعداد سريع وآلي وسيعمل لحماية بريدك في دقائق.',
    },
  },
  {
    question: { en: 'What is Email Archiving?', ar: 'ما هي أرشفة البريد الإلكتروني؟' },
    answer: {
      en: 'Email is so important nowadays, with archiving email is securely stored, giving you extra confidence and peace of mind.',
      ar: 'البريد الإلكتروني مهم جداً هذه الأيام، مع الأرشفة يتم تخزين البريد بشكل آمن مما يمنحك الثقة وراحة البال.',
    },
  },
  {
    question: { en: 'How much email can I store?', ar: 'كم يمكنني تخزين من البريد؟' },
    answer: {
      en: 'Email Archiving includes 10GB of compressed email storage by default. If you need more storage, additional 10GB licenses can be added.',
      ar: 'أرشفة البريد تشمل 10 جيجابايت من التخزين المضغوط افتراضياً. إذا كنت بحاجة لمزيد من التخزين، يمكن إضافة تراخيص 10 جيجابايت إضافية.',
    },
  },
];

// Additional Options for Incoming
const incomingAdditionalOptions = [
  {
    id: 'outgoing-addon',
    name: { en: 'Add Outgoing Filtering', ar: 'إضافة فلترة البريد الصادر' },
    price: 2.99,
    period: { en: '/mo more', ar: '/شهر إضافي' },
    link: 'https://app.progineous.com/store/email-services/incoming-and-outgoing-bundle',
  },
  {
    id: 'archiving-addon',
    name: { en: 'Add Incoming Archiving', ar: 'إضافة أرشفة الوارد' },
    price: 4.00,
    period: { en: '/mo more', ar: '/شهر إضافي' },
    link: 'https://app.progineous.com/store/email-services/incoming-and-archiving-bundle',
  },
  {
    id: 'both-addon',
    name: { en: 'Add Outgoing Filtering and Archiving', ar: 'إضافة فلترة الصادر والأرشفة' },
    price: 7.48,
    period: { en: '/mo more', ar: '/شهر إضافي' },
    link: 'https://app.progineous.com/store/email-services/incoming-outgoing-and-archiving-bundle',
  },
];

// Additional Options for Outgoing
const outgoingAdditionalOptions = [
  {
    id: 'incoming-addon',
    name: { en: 'Add Incoming Filtering', ar: 'إضافة فلترة البريد الوارد' },
    price: 2.99,
    period: { en: '/mo more', ar: '/شهر إضافي' },
    link: 'https://app.progineous.com/store/email-services/incoming-and-outgoing-bundle',
  },
  {
    id: 'archiving-addon',
    name: { en: 'Add Outgoing Archiving', ar: 'إضافة أرشفة الصادر' },
    price: 4.00,
    period: { en: '/mo more', ar: '/شهر إضافي' },
    link: 'https://app.progineous.com/store/email-services/outgoing-and-archiving-bundle',
  },
  {
    id: 'both-addon',
    name: { en: 'Add Incoming Filtering and Archiving', ar: 'إضافة فلترة الوارد والأرشفة' },
    price: 7.48,
    period: { en: '/mo more', ar: '/شهر إضافي' },
    link: 'https://app.progineous.com/store/email-services/incoming-outgoing-and-archiving-bundle',
  },
];

export default function EmailServicesPage() {
  const locale = useLocale();
  const isRTL = locale === 'ar';
  const [expandedFaq, setExpandedFaq] = useState<number | null>(null);
  const [selectedProduct, setSelectedProduct] = useState<'incoming' | 'outgoing'>('incoming');
  const heroRef = useRef<HTMLDivElement>(null);

  useEffect(() => {
    // Hero animation
    if (heroRef.current) {
      gsap.fromTo(
        heroRef.current.children,
        { opacity: 0, y: 30 },
        { opacity: 1, y: 0, duration: 0.8, stagger: 0.2, ease: 'power3.out' }
      );
    }
  }, []);

  const toggleFaq = (index: number) => {
    setExpandedFaq(expandedFaq === index ? null : index);
  };

  const getColorClasses = (color: string) => {
    switch (color) {
      case 'blue':
        return {
          bg: 'bg-blue-500',
          bgLight: 'bg-blue-100',
          text: 'text-blue-600',
          border: 'border-blue-500',
          hover: 'hover:bg-blue-600',
        };
      case 'green':
        return {
          bg: 'bg-green-500',
          bgLight: 'bg-green-100',
          text: 'text-green-600',
          border: 'border-green-500',
          hover: 'hover:bg-green-600',
        };
      case 'purple':
        return {
          bg: 'bg-purple-500',
          bgLight: 'bg-purple-100',
          text: 'text-purple-600',
          border: 'border-purple-500',
          hover: 'hover:bg-purple-600',
        };
      default:
        return {
          bg: 'bg-blue-500',
          bgLight: 'bg-blue-100',
          text: 'text-blue-600',
          border: 'border-blue-500',
          hover: 'hover:bg-blue-600',
        };
    }
  };

  // JSON-LD Structured Data
  const baseUrl = process.env.NEXT_PUBLIC_SITE_URL || 'https://progineous.com';
  
  const serviceSchema = {
    '@context': 'https://schema.org',
    '@type': 'Service',
    name: isRTL ? 'خدمات فلترة البريد الإلكتروني' : 'Email Filtering Services',
    description: isRTL
      ? 'خدمات فلترة البريد الوارد والصادر وأرشفة البريد الإلكتروني مع حماية من الفيروسات والرسائل المزعجة'
      : 'Incoming and outgoing email filtering and archiving services with virus and spam protection',
    provider: {
      '@type': 'Organization',
      name: 'Pro Gineous',
      url: baseUrl,
    },
    serviceType: 'Email Security',
    areaServed: 'Worldwide',
    hasOfferCatalog: {
      '@type': 'OfferCatalog',
      name: isRTL ? 'خطط خدمات البريد' : 'Email Services Plans',
      itemListElement: emailPlans.map((plan, index) => ({
        '@type': 'Offer',
        itemOffered: {
          '@type': 'Service',
          name: isRTL ? plan.nameAr : plan.name,
          description: isRTL ? plan.description.ar : plan.description.en,
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
      { '@type': 'ListItem', position: 3, name: isRTL ? 'خدمات البريد' : 'Email Services', item: `${baseUrl}/${locale}/market/email-services` },
    ],
  };

  return (
    <main className={cn("min-h-screen bg-white", isRTL && "rtl")}>
      {/* JSON-LD Structured Data */}
      <script type="application/ld+json" dangerouslySetInnerHTML={{ __html: JSON.stringify(serviceSchema) }} />
      <script type="application/ld+json" dangerouslySetInnerHTML={{ __html: JSON.stringify(breadcrumbSchema) }} />

      {/* Hero Section */}
      <section className="relative bg-gradient-to-br from-[#1a1f36] via-[#252b48] to-[#1a1f36] text-white overflow-hidden min-h-[60vh] flex items-center">
        {/* Background Pattern */}
        <div className="absolute inset-0 opacity-10">
          <div className="absolute inset-0" style={{
            backgroundImage: `radial-gradient(circle at 20% 30%, rgba(59, 130, 246, 0.4) 0%, transparent 50%),
                              radial-gradient(circle at 80% 70%, rgba(147, 51, 234, 0.3) 0%, transparent 50%)`,
          }} />
        </div>

        {/* Floating Mail Icons */}
        <div className="absolute top-20 right-10 opacity-10">
          <Mail className="w-48 h-48" />
        </div>
        <div className="absolute bottom-20 left-10 opacity-10">
          <Shield className="w-32 h-32" />
        </div>

        <div className="container mx-auto px-4 py-20 relative z-10">
          <div ref={heroRef} className="max-w-4xl mx-auto text-center">
            {/* SpamExperts Logo */}
            <div className="mb-8 flex items-center justify-center">
              <img 
                src="https://app.progineous.com/assets/img/marketconnect/spamexperts/logo_white.png" 
                alt="SpamExperts" 
                className="h-12 object-contain"
              />
            </div>

            <h1 className="text-4xl md:text-5xl font-bold mb-4">
              {isRTL ? 'أمان البريد الإلكتروني' : 'Email Security,'}
              <br />
              <span className="text-blue-400">
                {isRTL ? 'مصمم لك' : 'Built for You'}
              </span>
            </h1>
            
            <h2 className="text-2xl md:text-3xl text-gray-300 mb-6">
              {isRTL ? 'استعد السيطرة على صندوق بريدك' : 'Take back control of your inbox'}
            </h2>

            <p className="text-lg text-gray-400 mb-8 max-w-2xl mx-auto">
              {isRTL
                ? 'احظر ما يقرب من 100% من الفيروسات والبرامج الضارة والرسائل المزعجة قبل أن تصل إلى صندوق بريدك'
                : 'Block nearly 100% of viruses, malware and spam before they ever reach your inbox'}
            </p>

            <div className="flex flex-wrap justify-center gap-4">
              <a
                href="#plans"
                className="inline-flex items-center gap-2 px-8 py-4 bg-blue-600 rounded-xl font-semibold hover:bg-blue-700 transition-all shadow-lg shadow-blue-500/30"
              >
                {isRTL ? 'ابدأ الآن' : 'Get Started'}
                <ArrowRight className={cn("w-5 h-5", isRTL && "rotate-180")} />
              </a>
              <a
                href="#how-it-works"
                className="inline-flex items-center gap-2 px-8 py-4 bg-white/10 backdrop-blur-sm rounded-xl font-semibold hover:bg-white/20 transition-all"
              >
                {isRTL ? 'كيف يعمل' : 'How It Works'}
              </a>
            </div>
          </div>
        </div>
      </section>

      {/* Plans Section */}
      <section id="plans" className="py-20 bg-gray-50">
        <div className="container mx-auto px-4">
          <div className="text-center mb-12">
            <h2 className="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
              {isRTL ? 'اختر خدمتك' : 'Choose Your Service'}
            </h2>
            <p className="text-gray-600 max-w-2xl mx-auto">
              {isRTL
                ? 'حلول أمان البريد الإلكتروني الاحترافية لحماية عملك'
                : 'Professional email security solutions to protect your business'}
            </p>
          </div>

          <div className="grid md:grid-cols-3 gap-8 max-w-5xl mx-auto">
            {emailPlans.map((plan) => {
              const colors = getColorClasses(plan.color);
              const PlanIcon = plan.icon;
              
              return (
                <div
                  key={plan.id}
                  className="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all overflow-hidden"
                >
                  <div className={cn("p-6 text-white", colors.bg)}>
                    <div className="w-14 h-14 bg-white/20 rounded-xl flex items-center justify-center mb-4">
                      <PlanIcon className="w-7 h-7" />
                    </div>
                    <h3 className="text-xl font-bold mb-1">
                      {isRTL ? plan.nameAr : plan.name}
                    </h3>
                    <p className="text-white/80 text-sm">
                      {isRTL ? plan.tagline.ar : plan.tagline.en}
                    </p>
                  </div>

                  <div className="p-6">
                    <p className="text-gray-600 text-sm mb-6">
                      {isRTL ? plan.description.ar : plan.description.en}
                    </p>

                    <div className="flex items-baseline gap-1 mb-6">
                      <span className="text-sm text-gray-500">{isRTL ? 'من' : 'From'}</span>
                      <span className={cn("text-3xl font-bold", colors.text)}>${plan.price}</span>
                      <span className="text-gray-500 text-sm">USD{isRTL ? plan.period.ar : plan.period.en}</span>
                    </div>

                    <div className="flex gap-2">
                      <a
                        href={plan.cartLink}
                        target="_blank"
                        rel="noopener noreferrer"
                        className={cn(
                          "flex-1 inline-flex items-center justify-center gap-2 py-3 rounded-xl font-semibold text-white transition-all",
                          colors.bg,
                          colors.hover
                        )}
                      >
                        {isRTL ? 'اشترِ الآن' : 'Buy Now'}
                      </a>
                      <a
                        href={`#${plan.id}-features`}
                        className="px-4 py-3 border border-gray-200 rounded-xl font-semibold text-gray-600 hover:bg-gray-50 transition-all"
                      >
                        {isRTL ? 'التفاصيل' : 'Learn More'}
                      </a>
                    </div>
                  </div>
                </div>
              );
            })}
          </div>

          {/* Powered By */}
          <div className="text-center mt-12">
            <p className="text-gray-500 mb-4">{isRTL ? 'مدعوم بواسطة' : 'Powered by:'}</p>
            <img 
              src="https://app.progineous.com/assets/img/marketconnect/spamexperts/logo.png" 
              alt="SpamExperts" 
              className="h-8 mx-auto"
            />
          </div>
        </div>
      </section>

      {/* Incoming Features Section */}
      <section id="incoming-features" className="py-20 bg-white">
        <div className="container mx-auto px-4">
          <div className="text-center mb-12">
            <div className="w-16 h-16 bg-blue-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
              <Inbox className="w-8 h-8 text-blue-600" />
            </div>
            <h2 className="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
              {isRTL ? 'مزايا فلترة البريد الوارد' : 'Incoming email filtering gives you all these benefits...'}
            </h2>
          </div>

          <div className="grid md:grid-cols-2 lg:grid-cols-4 gap-4 max-w-5xl mx-auto mb-16">
            {incomingBenefits.map((benefit, index) => (
              <div
                key={index}
                className="flex items-center gap-3 bg-gray-50 rounded-xl p-4"
              >
                <div className="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                  <Check className="w-4 h-4 text-green-600" />
                </div>
                <span className="text-gray-700 text-sm">
                  {isRTL ? benefit.ar : benefit.en}
                </span>
              </div>
            ))}
          </div>

          <div className="bg-blue-50 rounded-2xl p-8 max-w-4xl mx-auto">
            <p className="text-gray-600 leading-relaxed">
              {isRTL
                ? 'تقوم فلترة البريد الوارد بفلترة جميع البريد الوارد وإزالة الرسائل المزعجة والفيروسات قبل أن تصل هذه التهديدات إلى شبكتك بمعدل دقة يقارب 100%. تتيح لك لوحة التحكم الشاملة البقاء في تحكم كامل. علاوة على ذلك، في حالة تعطل خادم البريد الخاص بك، سيتم وضع بريدك في قائمة الانتظار. يمكن الوصول إلى البريد في قائمة الانتظار وقراءته والرد عليه عبر واجهة الويب مما يضيف إلى استمرارية بريدك الوارد!'
                : 'Incoming Email Filtering filters all inbound email and eliminates spam and viruses before these threats reach your network at a nearly 100% accuracy rate. The extensive control-panel allows you to remain in full control. Moreover, in case your email server is down, your email will be queued. Queued email can be accessed, read, and replied to via the web-interface adding to your inbound email continuity!'}
            </p>
            <div className="mt-6 text-center">
              <a
                href="https://app.progineous.com/store/email-services/incoming-scanning"
                target="_blank"
                rel="noopener noreferrer"
                className="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 text-white rounded-xl font-semibold hover:bg-blue-700 transition-all"
              >
                {isRTL ? 'اطلب الآن' : 'Order Now'}
                <ArrowRight className={cn("w-4 h-4", isRTL && "rotate-180")} />
              </a>
            </div>
          </div>
        </div>
      </section>

      {/* Outgoing Features Section */}
      <section id="outgoing-features" className="py-20 bg-gray-50">
        <div className="container mx-auto px-4">
          <div className="text-center mb-12">
            <div className="w-16 h-16 bg-green-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
              <Send className="w-8 h-8 text-green-600" />
            </div>
            <h2 className="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
              {isRTL ? 'مزايا فلترة البريد الصادر' : 'Outgoing email filtering gives you all these benefits...'}
            </h2>
          </div>

          <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-4 max-w-4xl mx-auto mb-16">
            <div className="flex items-center gap-3 bg-white rounded-xl p-4 shadow-sm">
              <div className="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                <Check className="w-4 h-4 text-green-600" />
              </div>
              <span className="text-gray-700 text-sm">
                {isRTL ? 'لا مزيد من القوائم السوداء' : 'No more blacklisting'}
              </span>
            </div>
            <div className="flex items-center gap-3 bg-white rounded-xl p-4 shadow-sm">
              <div className="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                <Check className="w-4 h-4 text-green-600" />
              </div>
              <span className="text-gray-700 text-sm">
                {isRTL ? 'حماية سمعة علامتك التجارية وأنظمة IT' : 'Protect the reputation of your brand and IT-systems'}
              </span>
            </div>
            <div className="flex items-center gap-3 bg-white rounded-xl p-4 shadow-sm">
              <div className="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                <Check className="w-4 h-4 text-green-600" />
              </div>
              <span className="text-gray-700 text-sm">
                {isRTL ? 'تجنب تكاليف إزالة الحظر' : 'Avoid de-listing related costs'}
              </span>
            </div>
            <div className="flex items-center gap-3 bg-white rounded-xl p-4 shadow-sm">
              <div className="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                <Check className="w-4 h-4 text-green-600" />
              </div>
              <span className="text-gray-700 text-sm">
                {isRTL ? 'زيادة استمرارية وتسليم البريد الصادر' : 'Increase outbound email continuity and delivery'}
              </span>
            </div>
            <div className="flex items-center gap-3 bg-white rounded-xl p-4 shadow-sm">
              <div className="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                <Check className="w-4 h-4 text-green-600" />
              </div>
              <span className="text-gray-700 text-sm">
                {isRTL ? 'تعزيز إنتاجية الموظفين' : 'Enhance employee productivity'}
              </span>
            </div>
            <div className="flex items-center gap-3 bg-white rounded-xl p-4 shadow-sm">
              <div className="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                <Check className="w-4 h-4 text-green-600" />
              </div>
              <span className="text-gray-700 text-sm">
                {isRTL ? 'تحسين إدارة الإساءة' : 'Improve abuse manageability'}
              </span>
            </div>
          </div>

          {/* What is outgoing filtering */}
          <div className="bg-green-50 rounded-2xl p-8 max-w-4xl mx-auto mb-8">
            <h3 className="text-xl font-bold text-gray-900 mb-4">
              {isRTL ? 'ما هي فلترة البريد الصادر؟' : 'What is outgoing filtering?'}
            </h3>
            <p className="text-gray-600 leading-relaxed">
              {isRTL
                ? 'فلترة البريد الصادر ضرورية لحماية سمعة البنية التحتية لتكنولوجيا المعلومات وضمان وصول جميع رسائلك الصادرة بأمان إلى وجهتها. هذا الحل الاحترافي سيحظر الرسائل المزعجة والفيروسات من مغادرة شبكتك ويمنع إدراج عنوان IP الخاص بك في القوائم السوداء مرة أخرى. علاوة على ذلك، يوفر لك فلتر SpamExperts الصادر التقارير والأدوات لاكتشاف الحسابات المخترقة وإغلاق المستخدمين المرسلين للرسائل المزعجة.'
                : 'Outgoing Email Filtering is vital to safeguard your IT infrastructure reputation and ensure all your outgoing email arrives safely where it should. This professional solution will block spam and viruses from leaving your network and prevent your IP(s) from being blacklisted ever again. Moreover, the SpamExperts Outgoing Filter gives you the reporting and tools to detect compromised accounts and lock-down spamming users.'}
            </p>
          </div>

          {/* Why you need it */}
          <div className="bg-white border border-green-200 rounded-2xl p-8 max-w-4xl mx-auto">
            <h3 className="text-xl font-bold text-gray-900 mb-4">
              {isRTL ? 'لماذا تحتاجها؟' : 'Why you need it?'}
            </h3>
            <p className="text-gray-600 leading-relaxed">
              {isRTL
                ? 'هل سبق لشبكتك أن أرسلت رسائل مزعجة دون علمك؟ بسبب نقاط ضعف الشبكة، يمكن اختراق أي جهاز تقريباً لإرسال SMTP صادر، مما يسمح بإرسال رسائل مزعجة أو برامج ضارة من شبكتك دون أن تعلم! لذلك، من الضروري الاستثمار في حل فلتر صادر احترافي. حافظ على سمعة شركتك الجيدة، وأوقف الرسائل المزعجة من مغادرة شبكتك، وتجنب الإدراج في القوائم السوداء حتى يصل بريدك دائماً إلى المكان المقصود.'
                : "Has your network ever sent out spam email without your knowledge? Due to network weaknesses almost any device can be compromised to transmit outbound SMTP, allowing spam or malware to be sent out from your network without you even knowing it! Therefore, it's critical you invest in a professional Outgoing Filter solution. Maintain your company's good reputation, stop spam from leaving your network and prevent being blacklisted so that your email always arrives where it is meant to go."}
            </p>
            <div className="mt-6 text-center">
              <a
                href="https://app.progineous.com/store/email-services/outgoing-scanning"
                target="_blank"
                rel="noopener noreferrer"
                className="inline-flex items-center gap-2 px-6 py-3 bg-green-600 text-white rounded-xl font-semibold hover:bg-green-700 transition-all"
              >
                {isRTL ? 'اطلب الآن' : 'Order Now'}
                <ArrowRight className={cn("w-4 h-4", isRTL && "rotate-180")} />
              </a>
            </div>
          </div>
        </div>
      </section>

      {/* Archiving Features Section */}
      <section id="archiving-features" className="py-20 bg-white">
        <div className="container mx-auto px-4">
          <div className="text-center mb-12">
            <div className="w-16 h-16 bg-purple-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
              <Archive className="w-8 h-8 text-purple-600" />
            </div>
            <h2 className="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
              {isRTL ? 'مزايا أرشفة البريد الإلكتروني' : 'Email archiving gives you all these benefits...'}
            </h2>
          </div>

          <div className="grid md:grid-cols-2 lg:grid-cols-4 gap-4 max-w-5xl mx-auto mb-16">
            <div className="flex items-center gap-3 bg-purple-50 rounded-xl p-4 col-span-2">
              <div className="w-6 h-6 bg-purple-200 rounded-full flex items-center justify-center flex-shrink-0">
                <Check className="w-4 h-4 text-purple-600" />
              </div>
              <span className="text-purple-700 text-sm font-semibold">
                {isRTL ? 'يشمل فلترة البريد الوارد والصادر!' : 'Includes Incoming and Outgoing Email Filtering!'}
              </span>
            </div>
            <div className="flex items-center gap-3 bg-gray-50 rounded-xl p-4">
              <div className="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                <Check className="w-4 h-4 text-green-600" />
              </div>
              <span className="text-gray-700 text-sm">
                {isRTL ? 'لا تفقد أي بريد إلكتروني أبداً!' : 'Never lose an email again!'}
              </span>
            </div>
            <div className="flex items-center gap-3 bg-gray-50 rounded-xl p-4">
              <div className="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                <Check className="w-4 h-4 text-green-600" />
              </div>
              <span className="text-gray-700 text-sm">
                {isRTL ? 'تحقيق الامتثال القانوني' : 'Achieve legal compliance'}
              </span>
            </div>
            <div className="flex items-center gap-3 bg-gray-50 rounded-xl p-4">
              <div className="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                <Check className="w-4 h-4 text-green-600" />
              </div>
              <span className="text-gray-700 text-sm">
                {isRTL ? 'تحسين أداء نظام IT' : 'Improve IT system performance'}
              </span>
            </div>
            <div className="flex items-center gap-3 bg-gray-50 rounded-xl p-4">
              <div className="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                <Check className="w-4 h-4 text-green-600" />
              </div>
              <span className="text-gray-700 text-sm">
                {isRTL ? 'إدارة حماية البيانات سهلة الاستخدام' : 'User friendly data-protection management'}
              </span>
            </div>
            <div className="flex items-center gap-3 bg-gray-50 rounded-xl p-4">
              <div className="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                <Check className="w-4 h-4 text-green-600" />
              </div>
              <span className="text-gray-700 text-sm">
                {isRTL ? 'استمرارية بريد إضافية ودعم التسجيل وإعادة التسليم السهلة' : 'Added email continuity, journaling support, and easy re-delivery'}
              </span>
            </div>
            <div className="flex items-center gap-3 bg-gray-50 rounded-xl p-4">
              <div className="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                <Check className="w-4 h-4 text-green-600" />
              </div>
              <span className="text-gray-700 text-sm">
                {isRTL ? 'أرشيف مضغوط ومشفر وآمن' : 'Compressed, encrypted and secure archive'}
              </span>
            </div>
          </div>

          {/* Email Archiving description */}
          <div className="bg-purple-50 rounded-2xl p-8 max-w-4xl mx-auto mb-8">
            <h3 className="text-xl font-bold text-gray-900 mb-4">
              {isRTL ? 'أرشفة البريد الإلكتروني' : 'Email Archiving'}
            </h3>
            <p className="text-gray-600 leading-relaxed">
              {isRTL
                ? 'أرشفة البريد الإلكتروني تحفظ وتحمي جميع رسائل البريد الواردة والصادرة للوصول إليها لاحقاً. إنها طريقة رائعة لاسترداد رسائل البريد المفقودة أو المحذوفة عن طريق الخطأ، وتسريع الاستجابة للتدقيق، وتأمين رسائل الملكية الفكرية والمرفقات، وكذلك لأغراض "eDiscovery" في حالة التقاضي.'
                : 'Email Archiving preserves and protects all inbound and outbound email messages for later access. It is a great way to recover lost or accidentally deleted emails, accelerate audit response, secure intellectual property emails and attachments, as well as for "eDiscovery" purposes in case of litigation.'}
            </p>
          </div>

          {/* Why you need it */}
          <div className="bg-white border border-purple-200 rounded-2xl p-8 max-w-4xl mx-auto">
            <h3 className="text-xl font-bold text-gray-900 mb-4">
              {isRTL ? 'لماذا تحتاجها' : 'Why you need it'}
            </h3>
            <p className="text-gray-600 leading-relaxed mb-4">
              {isRTL
                ? 'هل تبحث بشدة عن بريد إلكتروني مهم من العام الماضي، لكن لا يمكنك العثور عليه وتخاطر بغرامة أو خسارة صفقة تجارية مهمة نتيجة لذلك؟ امنع هذا بحل أرشفة بريد إلكتروني احترافي. أرشفة البريد الإلكتروني أداة حيوية للحفاظ على نسخة احتياطية آمنة من جميع البريد والامتثال القانوني.'
                : "Are you desperately looking for an important email from last year, but can't seem to find it and you're risking a fine or losing an important business deal as the result of this? Prevent this with a professional Email Archiving solution. Email Archiving is a critical tool to preserve a secure backup of all email and be legally compliant."}
            </p>
            <p className="text-gray-600 leading-relaxed">
              {isRTL
                ? 'في الوقت نفسه، نظراً لأن تبادلات البريد الإلكتروني لها قوة قضائية وملزمة قانونياً، أصبح الامتثال للبريد الإلكتروني مصدر قلق بالغ الأهمية للمؤسسات. لذلك، يُعد إلزامياً في بعض الصناعات الحفاظ على نسخة احتياطية آمنة من جميع رسائل البريد والامتثال القانوني.'
                : 'At the same time, as email exchanges have judicial power and are legally binding, email compliance has become an extremely important concern for organizations. Therefore it is mandatory in certain industries to preserve a secure backup of all email messages and be legally compliant.'}
            </p>
            <div className="mt-6 text-center">
              <a
                href="https://app.progineous.com/store/email-services/incoming-and-archiving-bundle"
                target="_blank"
                rel="noopener noreferrer"
                className="inline-flex items-center gap-2 px-6 py-3 bg-purple-600 text-white rounded-xl font-semibold hover:bg-purple-700 transition-all"
              >
                {isRTL ? 'اطلب الآن' : 'Order Now'}
                <ArrowRight className={cn("w-4 h-4", isRTL && "rotate-180")} />
              </a>
            </div>
          </div>
        </div>
      </section>

      {/* Why You Need Section */}
      <section className="py-20 bg-gradient-to-br from-[#1a1f36] to-[#252b48] text-white">
        <div className="container mx-auto px-4">
          <div className="max-w-4xl mx-auto">
            <h2 className="text-3xl md:text-4xl font-bold text-center mb-8">
              {isRTL ? 'لماذا تحتاج فلتر وارد احترافي؟' : 'Why do you need a professional Incoming Filter?'}
            </h2>
            
            <p className="text-xl text-gray-300 text-center mb-12">
              {isRTL
                ? 'توقف عن المخاطرة بتهديدات شبكة تكنولوجيا المعلومات. إذا كان صندوق بريدك مزدحماً بالرسائل المزعجة كل يوم، فهذه علامة على أنك تحتاج حل فلتر وارد احترافي. احصل على حماية كاملة لصندوق بريدك وقل وداعاً للرسائل المزعجة والفيروسات والبرامج الضارة!'
                : "Stop running the risk of IT network threats. If your Inbox is crowded with unsolicited bulk mail every day, then that's a sign you need a professional Incoming Filter solution. Get full protection for your Inbox and say goodbye to spam, virus and malware threats!"}
            </p>

            <div className="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
              {features.map((feature, index) => {
                const FeatureIcon = feature.icon;
                return (
                  <div
                    key={index}
                    className="bg-white/10 backdrop-blur-sm rounded-xl p-6 text-center"
                  >
                    <div className="w-14 h-14 bg-blue-500/20 rounded-xl flex items-center justify-center mx-auto mb-4">
                      <FeatureIcon className="w-7 h-7 text-blue-400" />
                    </div>
                    <h3 className="font-semibold mb-2">
                      {isRTL ? feature.title.ar : feature.title.en}
                    </h3>
                    <p className="text-gray-400 text-sm">
                      {isRTL ? feature.description.ar : feature.description.en}
                    </p>
                  </div>
                );
              })}
            </div>
          </div>
        </div>
      </section>

      {/* How It Works Section */}
      <section id="how-it-works" className="py-20 bg-white">
        <div className="container mx-auto px-4">
          <h2 className="text-3xl md:text-4xl font-bold text-center text-gray-900 mb-12">
            {isRTL ? 'كيف يعمل' : 'How it works'}
          </h2>

          <div className="max-w-4xl mx-auto">
            <div className="grid md:grid-cols-2 gap-8">
              {howItWorks.map((step, index) => (
                <div
                  key={index}
                  className="flex gap-4"
                >
                  <div className="w-12 h-12 bg-blue-600 rounded-xl flex items-center justify-center flex-shrink-0 text-white font-bold text-lg">
                    {step.step}
                  </div>
                  <div>
                    <h3 className="font-semibold text-gray-900 mb-2">
                      {isRTL ? step.title.ar : step.title.en}
                    </h3>
                    <p className="text-gray-600 text-sm">
                      {isRTL ? step.description.ar : step.description.en}
                    </p>
                  </div>
                </div>
              ))}
            </div>

            <div className="mt-12 bg-blue-50 rounded-2xl p-8 text-center">
              <p className="text-gray-700 mb-4">
                {isRTL
                  ? 'لا تحتاج تدريب أو إعدادات وكل شيء يعمل من الصندوق!'
                  : 'No training or configurations are required and everything works out of the box!'}
              </p>
              <p className="text-gray-600 text-sm">
                {isRTL
                  ? 'لا مزيد من إضاعة الوقت في التعامل مع الرسائل المزعجة، ركز طاقتك على مهام العمل، بينما تبقى في تحكم كامل.'
                  : 'No more wasted time in dealing with spam, simply focus your energy on business tasks, while you remain in full control.'}
              </p>
            </div>
          </div>
        </div>
      </section>

      {/* Pricing Calculator Section */}
      <section className="py-20 bg-gray-50">
        <div className="container mx-auto px-4">
          <h2 className="text-3xl md:text-4xl font-bold text-center text-gray-900 mb-4">
            {isRTL ? 'سجّل وابدأ' : 'Sign Up and Get Started'}
          </h2>

          <div className="max-w-2xl mx-auto mt-12">
            <div className="bg-white rounded-2xl shadow-lg p-8">
              {/* Product Selection */}
              <div className="mb-8">
                <h3 className="font-semibold text-gray-900 mb-4">
                  {isRTL ? 'اختر المنتج' : 'Choose Product'}
                </h3>
                <div className="flex gap-4">
                  <button
                    onClick={() => setSelectedProduct('incoming')}
                    className={cn(
                      "flex-1 py-3 px-4 rounded-xl font-medium transition-all",
                      selectedProduct === 'incoming'
                        ? "bg-blue-600 text-white"
                        : "bg-gray-100 text-gray-600 hover:bg-gray-200"
                    )}
                  >
                    {isRTL ? 'فلترة الوارد' : 'Incoming Filtering'}
                  </button>
                  <button
                    onClick={() => setSelectedProduct('outgoing')}
                    className={cn(
                      "flex-1 py-3 px-4 rounded-xl font-medium transition-all",
                      selectedProduct === 'outgoing'
                        ? "bg-blue-600 text-white"
                        : "bg-gray-100 text-gray-600 hover:bg-gray-200"
                    )}
                  >
                    {isRTL ? 'فلترة الصادر' : 'Outgoing Filtering'}
                  </button>
                </div>
              </div>

              {/* Additional Options */}
              <div className="mb-8">
                <h3 className="font-semibold text-gray-900 mb-4">
                  {isRTL ? 'خيارات إضافية' : 'Additional Options'}
                </h3>
                <div className="space-y-3">
                  {(selectedProduct === 'incoming' ? incomingAdditionalOptions : outgoingAdditionalOptions).map((option) => (
                    <a
                      key={option.id}
                      href={option.link}
                      target="_blank"
                      rel="noopener noreferrer"
                      className="flex items-center justify-between bg-gray-50 rounded-xl p-4 hover:bg-gray-100 transition-colors cursor-pointer"
                    >
                      <span className="text-gray-700">
                        {isRTL ? option.name.ar : option.name.en}
                      </span>
                      <span className="text-blue-600 font-semibold">
                        ${option.price} USD{isRTL ? option.period.ar : option.period.en}
                      </span>
                    </a>
                  ))}
                </div>
              </div>

              {/* Base Price */}
              <div className="border-t pt-6 mb-6">
                <div className="flex items-center justify-between mb-4">
                  <span className="text-gray-600">{isRTL ? 'السعر الأساسي' : 'Base Price'}</span>
                  <span className="text-2xl font-bold text-gray-900">$2.99 USD/{isRTL ? 'شهر' : 'mo'}</span>
                </div>
              </div>

              {/* Order Button */}
              <a
                href={selectedProduct === 'incoming' 
                  ? 'https://app.progineous.com/store/email-services/incoming-scanning'
                  : 'https://app.progineous.com/store/email-services/outgoing-scanning'
                }
                target="_blank"
                rel="noopener noreferrer"
                className="w-full inline-flex items-center justify-center gap-2 py-4 bg-blue-600 text-white rounded-xl font-semibold hover:bg-blue-700 transition-all"
              >
                {isRTL ? 'اطلب الآن' : 'Order Now'}
                <ArrowRight className={cn("w-5 h-5", isRTL && "rotate-180")} />
              </a>
            </div>
          </div>
        </div>
      </section>

      {/* FAQ Section */}
      <section className="py-20 bg-white">
        <div className="container mx-auto px-4">
          <h2 className="text-3xl md:text-4xl font-bold text-center text-gray-900 mb-12">
            {isRTL ? 'الأسئلة الشائعة' : 'Frequently Asked Questions'}
          </h2>

          <div className="max-w-3xl mx-auto space-y-4">
            {faqs.map((faq, index) => (
              <div
                key={index}
                className="bg-gray-50 rounded-xl overflow-hidden"
              >
                <button
                  onClick={() => toggleFaq(index)}
                  className="w-full px-6 py-4 flex items-center justify-between text-left hover:bg-gray-100 transition-colors"
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
      <section className="py-16 bg-gradient-to-r from-blue-600 to-blue-700">
        <div className="container mx-auto px-4 text-center">
          <h2 className="text-3xl font-bold text-white mb-4">
            {isRTL ? 'احمِ بريدك الإلكتروني اليوم' : 'Protect Your Email Today'}
          </h2>
          <p className="text-blue-100 mb-8 max-w-2xl mx-auto">
            {isRTL
              ? 'ابدأ في حماية عملك من الرسائل المزعجة والفيروسات والبرامج الضارة'
              : 'Start protecting your business from spam, viruses, and malware'}
          </p>
          <a
            href="https://app.progineous.com/store/email-services/incoming-scanning"
            target="_blank"
            rel="noopener noreferrer"
            className="inline-flex items-center gap-2 px-8 py-4 bg-white text-blue-600 rounded-xl font-semibold hover:bg-blue-50 transition-all"
          >
            {isRTL ? 'ابدأ من $2.99/شهر' : 'Get Started from $2.99/mo'}
            <ArrowRight className={cn("w-5 h-5", isRTL && "rotate-180")} />
          </a>
        </div>
      </section>
    </main>
  );
}
