'use client';

import { useState, useEffect, useRef } from 'react';
import { useLocale } from 'next-intl';
import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import {
  Check,
  ArrowRight,
  Server,
  Shield,
  Clock,
  Headphones,
  Zap,
  RefreshCw,
  CheckCircle,
  ArrowRightLeft,
  Globe,
  Database,
  Lock,
  Users,
  Star,
  ChevronDown,
  ChevronUp,
} from 'lucide-react';
import { cn } from '@/lib/utils';

// Register GSAP plugins
if (typeof window !== 'undefined') {
  gsap.registerPlugin(ScrollTrigger);
}

// Migration Steps
const migrationSteps = [
  {
    step: 1,
    title: { en: 'Submit Request', ar: 'تقديم الطلب' },
    description: {
      en: 'Fill out our simple migration form with your current hosting details.',
      ar: 'املأ نموذج النقل البسيط مع تفاصيل استضافتك الحالية.',
    },
    icon: Globe,
  },
  {
    step: 2,
    title: { en: 'We Review & Plan', ar: 'المراجعة والتخطيط' },
    description: {
      en: 'Our experts review your website and create a customized migration plan.',
      ar: 'يراجع خبراؤنا موقعك ويضعون خطة نقل مخصصة.',
    },
    icon: Database,
  },
  {
    step: 3,
    title: { en: 'Secure Migration', ar: 'النقل الآمن' },
    description: {
      en: 'We migrate your files, databases, and emails with zero data loss.',
      ar: 'ننقل ملفاتك وقواعد بياناتك وبريدك بدون فقدان للبيانات.',
    },
    icon: Lock,
  },
  {
    step: 4,
    title: { en: 'Testing & Go Live', ar: 'الاختبار والإطلاق' },
    description: {
      en: 'We test everything thoroughly before pointing your domain to the new server.',
      ar: 'نختبر كل شيء بدقة قبل توجيه نطاقك للسيرفر الجديد.',
    },
    icon: CheckCircle,
  },
];

// Features
const features = [
  {
    title: { en: 'Zero Downtime', ar: 'بدون توقف' },
    description: {
      en: 'Your website stays online throughout the entire migration process.',
      ar: 'موقعك يبقى متاحاً طوال عملية النقل بالكامل.',
    },
    icon: Clock,
  },
  {
    title: { en: 'Free Migration', ar: 'نقل مجاني' },
    description: {
      en: 'We handle everything at no extra cost when you sign up for hosting.',
      ar: 'نتولى كل شيء بدون تكلفة إضافية عند اشتراكك في الاستضافة.',
    },
    icon: RefreshCw,
  },
  {
    title: { en: 'Expert Team', ar: 'فريق خبراء' },
    description: {
      en: 'Our migration specialists have moved thousands of websites safely.',
      ar: 'متخصصو النقل لدينا نقلوا آلاف المواقع بأمان.',
    },
    icon: Users,
  },
  {
    title: { en: 'Data Security', ar: 'أمان البيانات' },
    description: {
      en: 'Your data is encrypted and protected throughout the migration.',
      ar: 'بياناتك مشفرة ومحمية طوال عملية النقل.',
    },
    icon: Shield,
  },
  {
    title: { en: '24/7 Support', ar: 'دعم على مدار الساعة' },
    description: {
      en: 'Get help anytime during the migration process.',
      ar: 'احصل على المساعدة في أي وقت خلال عملية النقل.',
    },
    icon: Headphones,
  },
  {
    title: { en: 'Fast Transfer', ar: 'نقل سريع' },
    description: {
      en: 'Most migrations are completed within 24-48 hours.',
      ar: 'معظم عمليات النقل تكتمل خلال 24-48 ساعة.',
    },
    icon: Zap,
  },
];

// What We Migrate
const whatWeMigrate = [
  { en: 'Website Files & Folders', ar: 'ملفات ومجلدات الموقع' },
  { en: 'MySQL/MariaDB Databases', ar: 'قواعد بيانات MySQL/MariaDB' },
  { en: 'Email Accounts & Data', ar: 'حسابات البريد والبيانات' },
  { en: 'SSL Certificates', ar: 'شهادات SSL' },
  { en: 'Cron Jobs & Settings', ar: 'المهام المجدولة والإعدادات' },
  { en: 'DNS Records', ar: 'سجلات DNS' },
  { en: 'WordPress Sites', ar: 'مواقع ووردبريس' },
  { en: 'E-commerce Stores', ar: 'متاجر التجارة الإلكترونية' },
];

// FAQs
const faqs = [
  {
    question: { en: 'How long does the migration take?', ar: 'كم تستغرق عملية النقل؟' },
    answer: {
      en: 'Most migrations are completed within 24-48 hours. Complex websites with large databases may take longer, but we\'ll keep you informed throughout the process.',
      ar: 'معظم عمليات النقل تكتمل خلال 24-48 ساعة. المواقع المعقدة ذات قواعد البيانات الكبيرة قد تستغرق وقتاً أطول، لكننا سنبقيك على اطلاع طوال العملية.',
    },
  },
  {
    question: { en: 'Will my website go offline during migration?', ar: 'هل سيتوقف موقعي أثناء النقل؟' },
    answer: {
      en: 'No! We use a seamless migration process that keeps your website online. We only switch DNS after everything is tested and working perfectly on our servers.',
      ar: 'لا! نستخدم عملية نقل سلسة تبقي موقعك متاحاً. نقوم بتغيير DNS فقط بعد اختبار كل شيء والتأكد من عمله بشكل مثالي على سيرفراتنا.',
    },
  },
  {
    question: { en: 'Is the migration really free?', ar: 'هل النقل مجاني فعلاً؟' },
    answer: {
      en: 'Yes! Migration is completely free when you sign up for any of our hosting plans. There are no hidden fees or charges.',
      ar: 'نعم! النقل مجاني تماماً عند اشتراكك في أي من خطط الاستضافة لدينا. لا توجد رسوم أو تكاليف مخفية.',
    },
  },
  {
    question: { en: 'What information do you need from me?', ar: 'ما المعلومات التي تحتاجونها مني؟' },
    answer: {
      en: 'We\'ll need your current hosting control panel login details (cPanel, Plesk, etc.) and any specific instructions about your website. Our team will handle the rest.',
      ar: 'سنحتاج بيانات تسجيل الدخول للوحة تحكم استضافتك الحالية (cPanel، Plesk، إلخ) وأي تعليمات خاصة بموقعك. فريقنا سيتولى الباقي.',
    },
  },
  {
    question: { en: 'Can you migrate my WordPress website?', ar: 'هل يمكنكم نقل موقع ووردبريس الخاص بي؟' },
    answer: {
      en: 'Absolutely! We specialize in WordPress migrations and ensure all your themes, plugins, and content are transferred perfectly.',
      ar: 'بالتأكيد! نحن متخصصون في نقل ووردبريس ونضمن نقل جميع القوالب والإضافات والمحتوى بشكل مثالي.',
    },
  },
  {
    question: { en: 'What if something goes wrong?', ar: 'ماذا لو حدث خطأ ما؟' },
    answer: {
      en: 'We create full backups before starting any migration. If anything goes wrong, we can restore your website to its original state immediately.',
      ar: 'نقوم بإنشاء نسخ احتياطية كاملة قبل بدء أي عملية نقل. إذا حدث أي خطأ، يمكننا استعادة موقعك لحالته الأصلية فوراً.',
    },
  },
];

// Testimonials
const testimonials = [
  {
    name: { en: 'Ahmed Hassan', ar: 'أحمد حسن' },
    role: { en: 'E-commerce Owner', ar: 'صاحب متجر إلكتروني' },
    content: {
      en: 'The migration was seamless! My online store was moved without any downtime. The team was professional and kept me updated throughout.',
      ar: 'كان النقل سلساً! تم نقل متجري الإلكتروني بدون أي توقف. الفريق كان محترفاً وأبقاني على اطلاع طوال الوقت.',
    },
    rating: 5,
  },
  {
    name: { en: 'Sarah Johnson', ar: 'سارة جونسون' },
    role: { en: 'Blogger', ar: 'مدونة' },
    content: {
      en: 'I was worried about losing my blog posts, but they migrated everything perfectly. Even my email accounts were moved without issues!',
      ar: 'كنت قلقة من فقدان مقالات مدونتي، لكنهم نقلوا كل شيء بشكل مثالي. حتى حسابات بريدي تم نقلها بدون مشاكل!',
    },
    rating: 5,
  },
  {
    name: { en: 'Mohamed Ali', ar: 'محمد علي' },
    role: { en: 'Web Developer', ar: 'مطور ويب' },
    content: {
      en: 'As a developer, I appreciate their attention to detail. They handled multiple WordPress sites and complex databases flawlessly.',
      ar: 'كمطور، أقدر اهتمامهم بالتفاصيل. تعاملوا مع عدة مواقع ووردبريس وقواعد بيانات معقدة بشكل مثالي.',
    },
    rating: 5,
  },
];

export default function MigrateHostingPage() {
  const locale = useLocale();
  const isRTL = locale === 'ar';
  const [expandedFaq, setExpandedFaq] = useState<number | null>(null);
  const [isSubmitting, setIsSubmitting] = useState(false);
  const [submitStatus, setSubmitStatus] = useState<'idle' | 'success' | 'error'>('idle');
  const heroRef = useRef<HTMLDivElement>(null);
  const formRef = useRef<HTMLFormElement>(null);

  const handleSubmit = async (e: React.FormEvent<HTMLFormElement>) => {
    e.preventDefault();
    setIsSubmitting(true);
    setSubmitStatus('idle');

    const form = e.currentTarget;
    const formData = new FormData(form);

    // Get Support PIN from individual inputs
    const pinInputs = form.querySelectorAll('input[name^="pin"]');
    let supportPin = '';
    pinInputs.forEach((input) => {
      supportPin += (input as HTMLInputElement).value;
    });

    const data = {
      fullName: formData.get('fullName'),
      email: formData.get('email'),
      countryCode: formData.get('countryCode'),
      phone: formData.get('phone'),
      supportPin,
      websiteUrl: formData.get('websiteUrl'),
      hostingProvider: formData.get('hostingProvider'),
      hostingType: formData.get('hostingType'),
      controlPanel: formData.get('controlPanel'),
      notes: formData.get('notes'),
    };

    try {
      const response = await fetch('/api/migrate', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify(data),
      });

      if (response.ok) {
        setSubmitStatus('success');
        form.reset();
        // Clear PIN inputs
        pinInputs.forEach((input) => {
          (input as HTMLInputElement).value = '';
        });
      } else {
        setSubmitStatus('error');
      }
    } catch (error) {
      console.error('Submit error:', error);
      setSubmitStatus('error');
    } finally {
      setIsSubmitting(false);
    }
  };

  useEffect(() => {
    const ctx = gsap.context(() => {
      gsap.from('.hero-content > *', {
        y: 50,
        opacity: 0,
        duration: 0.8,
        stagger: 0.15,
        ease: 'power3.out',
      });

      // Set initial state to visible first
      gsap.set('.step-card', { opacity: 1, y: 0 });
      gsap.set('.feature-card', { opacity: 1, y: 0 });

      gsap.from('.step-card', {
        scrollTrigger: {
          trigger: '.steps-section',
          start: 'top 80%',
        },
        y: 30,
        opacity: 0,
        duration: 0.6,
        stagger: 0.15,
        ease: 'power3.out',
      });

      gsap.from('.feature-card', {
        scrollTrigger: {
          trigger: '.features-section',
          start: 'top 80%',
        },
        y: 30,
        opacity: 0,
        duration: 0.6,
        stagger: 0.1,
        ease: 'power3.out',
      });
    }, heroRef);

    return () => ctx.revert();
  }, []);

  // JSON-LD Structured Data
  const baseUrl = process.env.NEXT_PUBLIC_SITE_URL || 'https://progineous.com';
  
  const serviceSchema = {
    '@context': 'https://schema.org',
    '@type': 'Service',
    name: isRTL ? 'خدمة نقل الاستضافة المجانية' : 'Free Hosting Migration Service',
    description: isRTL
      ? 'خدمة نقل مواقع احترافية مجانية بدون توقف مع فريق خبراء'
      : 'Professional free website migration service with zero downtime by expert team',
    provider: {
      '@type': 'Organization',
      name: 'Pro Gineous',
      url: baseUrl,
    },
    serviceType: 'Website Migration',
    areaServed: 'Worldwide',
    offers: {
      '@type': 'Offer',
      price: '0',
      priceCurrency: 'USD',
      description: isRTL ? 'نقل مجاني مع أي خطة استضافة' : 'Free migration with any hosting plan',
    },
  };

  const howToSchema = {
    '@context': 'https://schema.org',
    '@type': 'HowTo',
    name: isRTL ? 'كيفية نقل موقعك إلى بروجينيوس' : 'How to Migrate Your Website to Pro Gineous',
    description: isRTL ? 'خطوات نقل موقعك بسهولة وأمان' : 'Steps to migrate your website easily and securely',
    totalTime: 'P2D',
    step: migrationSteps.map((step, index) => ({
      '@type': 'HowToStep',
      position: index + 1,
      name: isRTL ? step.title.ar : step.title.en,
      text: isRTL ? step.description.ar : step.description.en,
    })),
  };

  const breadcrumbSchema = {
    '@context': 'https://schema.org',
    '@type': 'BreadcrumbList',
    itemListElement: [
      { '@type': 'ListItem', position: 1, name: isRTL ? 'الرئيسية' : 'Home', item: `${baseUrl}/${locale}` },
      { '@type': 'ListItem', position: 2, name: isRTL ? 'النقل' : 'Migration', item: `${baseUrl}/${locale}/migrate` },
      { '@type': 'ListItem', position: 3, name: isRTL ? 'نقل الاستضافة' : 'Hosting Migration', item: `${baseUrl}/${locale}/migrate/hosting` },
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
    <div ref={heroRef} className={cn('min-h-screen bg-gray-50', isRTL && 'rtl')}>
      {/* JSON-LD Structured Data */}
      <script type="application/ld+json" dangerouslySetInnerHTML={{ __html: JSON.stringify(serviceSchema) }} />
      <script type="application/ld+json" dangerouslySetInnerHTML={{ __html: JSON.stringify(howToSchema) }} />
      <script type="application/ld+json" dangerouslySetInnerHTML={{ __html: JSON.stringify(breadcrumbSchema) }} />
      <script type="application/ld+json" dangerouslySetInnerHTML={{ __html: JSON.stringify(faqSchema) }} />

      {/* Hero Section */}
      <section className="relative bg-linear-to-br from-[#1d71b8] via-[#1a5f9a] to-[#0f4c75] text-white overflow-hidden">
        <div className="absolute inset-0 opacity-10">
          <div className="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg_width=%2760%27_height=%2760%27_viewBox=%270_0_60_60%27_xmlns=%27http://www.w3.org/2000/svg%27%3E%3Cg_fill=%27none%27_fill-rule=%27evenodd%27%3E%3Cg_fill=%27%23ffffff%27_fill-opacity=%270.1%27%3E%3Cpath_d=%27M36_34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6_34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6_4V0H4v4H0v2h4v4h2V6h4V4H6z%27/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')]" />
        </div>

        <div className="container mx-auto px-4 pt-16 pb-32 md:pt-24 md:pb-40 relative z-10">
          <div className="hero-content max-w-4xl mx-auto text-center">
            <div className="inline-flex items-center gap-2 bg-white/10 backdrop-blur-sm rounded-full px-4 py-2 mb-6">
              <ArrowRightLeft className="w-4 h-4" />
              <span className="text-sm font-medium">
                {isRTL ? 'نقل مجاني 100%' : '100% Free Migration'}
              </span>
            </div>
            
            <h1 className="text-4xl md:text-5xl lg:text-6xl font-bold mb-6">
              {isRTL ? 'انقل استضافتك إلينا' : 'Migrate Your Hosting'}
              <span className="block text-[#00D4AA] mt-2">
                {isRTL ? 'بدون أي متاعب' : 'Hassle-Free'}
              </span>
            </h1>
            
            <p className="text-lg md:text-xl text-white/80 mb-8 max-w-2xl mx-auto">
              {isRTL
                ? 'دع فريق الخبراء لدينا ينقل موقعك بأمان وبدون توقف. نحن نتولى كل شيء من الملفات إلى قواعد البيانات والبريد الإلكتروني.'
                : 'Let our expert team move your website safely with zero downtime. We handle everything from files to databases and emails.'}
            </p>

            <div className="flex flex-col sm:flex-row gap-4 justify-center">
              <a
                href="#request-form"
                className="inline-flex items-center justify-center gap-2 bg-[#00D4AA] text-black px-8 py-4 rounded-xl font-semibold text-lg hover:bg-[#00B894] transition-all duration-300 hover:scale-105 shadow-lg"
              >
                {isRTL ? 'ابدأ النقل المجاني' : 'Start Free Migration'}
                <ArrowRight className={cn('w-5 h-5', isRTL && 'rotate-180')} />
              </a>
              <a
                href="/hosting/shared"
                className="inline-flex items-center justify-center gap-2 bg-white/10 backdrop-blur-sm text-white px-8 py-4 rounded-xl font-semibold text-lg hover:bg-white/20 transition-all duration-300 border border-white/20"
              >
                {isRTL ? 'عرض خطط الاستضافة' : 'View Hosting Plans'}
              </a>
            </div>

            {/* Trust Badges */}
            <div className="mt-12 flex flex-wrap justify-center gap-6 text-sm text-white/70">
              <div className="flex items-center gap-2">
                <CheckCircle className="w-5 h-5 text-[#00D4AA]" />
                {isRTL ? 'بدون توقف' : 'Zero Downtime'}
              </div>
              <div className="flex items-center gap-2">
                <CheckCircle className="w-5 h-5 text-[#00D4AA]" />
                {isRTL ? 'نقل آمن' : 'Secure Transfer'}
              </div>
              <div className="flex items-center gap-2">
                <CheckCircle className="w-5 h-5 text-[#00D4AA]" />
                {isRTL ? 'دعم 24/7' : '24/7 Support'}
              </div>
            </div>
          </div>
        </div>

        <div className="absolute bottom-0 left-0 right-0">
          <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path
              d="M0 120L60 105C120 90 240 60 360 45C480 30 600 30 720 37.5C840 45 960 60 1080 67.5C1200 75 1320 75 1380 75L1440 75V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0Z"
              fill="#f9fafb"
            />
          </svg>
        </div>
      </section>

      {/* How It Works - Interactive Steps */}
      <section className="steps-section py-24 bg-white overflow-hidden relative">
        {/* Background Pattern */}
        <div className="absolute inset-0 opacity-5">
          <div className="absolute inset-0 bg-[radial-gradient(circle_at_2px_2px,#1d71b8_1px,transparent_0)] bg-size-[40px_40px]" />
        </div>
        
        <div className="container mx-auto px-4 relative z-10">
          <div className="max-w-6xl mx-auto">
            {/* Header with animated number */}
            <div className="flex flex-col lg:flex-row items-center gap-8 mb-16">
              <div className="shrink-0">
                <div className="relative">
                  <div className="w-32 h-32 bg-linear-to-br from-[#1d71b8] to-[#00D4AA] rounded-3xl rotate-3 flex items-center justify-center shadow-2xl">
                    <span className="text-6xl font-black text-white">4</span>
                  </div>
                  <div className="absolute -bottom-2 -right-2 bg-white rounded-full px-3 py-1 shadow-lg text-sm font-bold text-gray-700">
                    {isRTL ? 'خطوات' : 'Steps'}
                  </div>
                </div>
              </div>
              <div className="text-center lg:text-start">
                <h2 className="text-4xl md:text-5xl font-bold text-gray-800 mb-4">
                  {isRTL ? 'كيف يعمل النقل؟' : 'How Migration Works'}
                </h2>
                <p className="text-xl text-gray-600 max-w-xl">
                  {isRTL
                    ? 'عملية مبسطة تماماً - نحن نتولى كل شيء من البداية للنهاية'
                    : 'Completely streamlined process - we handle everything from start to finish'}
                </p>
              </div>
            </div>

            {/* Steps Grid - 2x2 */}
            <div className="grid md:grid-cols-2 gap-6 mb-12">
              {migrationSteps.map((step, index) => {
                const Icon = step.icon;
                const gradients = [
                  'from-blue-600 to-cyan-500',
                  'from-violet-600 to-purple-500',
                  'from-amber-500 to-orange-500',
                  'from-emerald-500 to-teal-500'
                ];
                const bgColors = [
                  'bg-blue-50 hover:bg-blue-100',
                  'bg-violet-50 hover:bg-violet-100',
                  'bg-amber-50 hover:bg-amber-100',
                  'bg-emerald-50 hover:bg-emerald-100'
                ];
                const borderColors = [
                  'border-blue-200 hover:border-blue-400',
                  'border-violet-200 hover:border-violet-400',
                  'border-amber-200 hover:border-amber-400',
                  'border-emerald-200 hover:border-emerald-400'
                ];
                
                return (
                  <div
                    key={step.step}
                    className={cn(
                      'step-card group relative rounded-3xl p-8 border-2 transition-all duration-500 cursor-pointer',
                      bgColors[index],
                      borderColors[index]
                    )}
                  >
                    {/* Step Number Badge */}
                    <div className={cn(
                      'absolute -top-5 start-8 w-10 h-10 rounded-2xl flex items-center justify-center text-white font-bold text-lg shadow-lg bg-linear-to-br',
                      gradients[index]
                    )}>
                      {step.step}
                    </div>
                    
                    {/* Arrow to next step */}
                    {index < migrationSteps.length - 1 && (
                      <div className={cn(
                        'absolute hidden md:flex items-center justify-center',
                        index % 2 === 0 
                          ? 'top-1/2 -end-6 -translate-y-1/2' 
                          : 'bottom-0 start-1/2 -translate-x-1/2 translate-y-full py-3'
                      )}>
                        {index % 2 === 0 ? (
                          <ArrowRight className={cn('w-8 h-8 text-gray-300', isRTL && 'rotate-180')} />
                        ) : index === 1 ? (
                          <ChevronDown className="w-8 h-8 text-gray-300" />
                        ) : null}
                      </div>
                    )}
                    
                    <div className="flex items-start gap-6 mt-4">
                      {/* Icon */}
                      <div className={cn(
                        'w-16 h-16 rounded-2xl flex items-center justify-center transition-transform duration-300 group-hover:scale-110 group-hover:rotate-3 bg-linear-to-br text-white shadow-lg',
                        gradients[index]
                      )}>
                        <Icon className="w-8 h-8" />
                      </div>
                      
                      {/* Content */}
                      <div className="flex-1">
                        <h3 className="text-2xl font-bold text-gray-800 mb-2 group-hover:text-gray-900">
                          {isRTL ? step.title.ar : step.title.en}
                        </h3>
                        <p className="text-gray-600 text-lg leading-relaxed">
                          {isRTL ? step.description.ar : step.description.en}
                        </p>
                      </div>
                    </div>
                    
                    {/* Decorative corner */}
                    <div className={cn(
                      'absolute bottom-0 end-0 w-24 h-24 rounded-tl-[60px] opacity-10 transition-opacity group-hover:opacity-20 bg-linear-to-br',
                      gradients[index]
                    )} />
                  </div>
                );
              })}
            </div>

            {/* Bottom Stats Bar */}
            <div className="bg-linear-to-r from-gray-900 via-gray-800 to-gray-900 rounded-3xl p-8 text-white">
              <div className="grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
                <div className="space-y-2">
                  <div className="text-4xl font-black text-[#00D4AA]">24h</div>
                  <div className="text-gray-400 text-sm">{isRTL ? 'متوسط وقت النقل' : 'Avg. Migration Time'}</div>
                </div>
                <div className="space-y-2">
                  <div className="text-4xl font-black text-[#00D4AA]">0%</div>
                  <div className="text-gray-400 text-sm">{isRTL ? 'وقت التوقف' : 'Downtime'}</div>
                </div>
                <div className="space-y-2">
                  <div className="text-4xl font-black text-[#00D4AA]">100%</div>
                  <div className="text-gray-400 text-sm">{isRTL ? 'أمان البيانات' : 'Data Security'}</div>
                </div>
                <div className="space-y-2">
                  <div className="text-4xl font-black text-[#00D4AA]">$0</div>
                  <div className="text-gray-400 text-sm">{isRTL ? 'تكلفة النقل' : 'Migration Cost'}</div>
                </div>
              </div>
              
              <div className="mt-8 pt-8 border-t border-gray-700 flex flex-col sm:flex-row items-center justify-between gap-4">
                <div className="flex items-center gap-3">
                  <div className="flex -space-x-2">
                    <div className="w-10 h-10 rounded-full bg-linear-to-br from-blue-500 to-cyan-500 flex items-center justify-center text-white text-sm font-bold border-2 border-gray-800">A</div>
                    <div className="w-10 h-10 rounded-full bg-linear-to-br from-violet-500 to-purple-500 flex items-center justify-center text-white text-sm font-bold border-2 border-gray-800">M</div>
                    <div className="w-10 h-10 rounded-full bg-linear-to-br from-amber-500 to-orange-500 flex items-center justify-center text-white text-sm font-bold border-2 border-gray-800">S</div>
                  </div>
                  <span className="text-gray-300">
                    {isRTL ? '+10,000 موقع تم نقله بنجاح' : '+10,000 sites migrated successfully'}
                  </span>
                </div>
                <a
                  href="#request-form"
                  className="inline-flex items-center gap-2 bg-[#00D4AA] text-black px-6 py-3 rounded-xl font-bold hover:bg-[#00B894] transition-all duration-300 hover:scale-105"
                >
                  {isRTL ? 'ابدأ النقل المجاني' : 'Start Free Migration'}
                  <ArrowRight className={cn('w-5 h-5', isRTL && 'rotate-180')} />
                </a>
              </div>
            </div>
          </div>
        </div>
      </section>

      {/* Features */}
      <section className="features-section py-20 bg-white overflow-hidden">
        <div className="container mx-auto px-4">
          <div className="text-center mb-16">
            <span className="inline-block px-4 py-2 bg-[#1d71b8]/10 text-[#1d71b8] rounded-full text-sm font-semibold mb-4">
              {isRTL ? 'مميزاتنا' : 'Our Advantages'}
            </span>
            <h2 className="text-3xl md:text-4xl font-bold text-gray-800 mb-4">
              {isRTL ? 'لماذا تختارنا للنقل؟' : 'Why Choose Us for Migration?'}
            </h2>
            <p className="text-lg text-gray-600 max-w-2xl mx-auto">
              {isRTL
                ? 'نقدم أفضل خدمة نقل مع ضمان كامل'
                : 'We offer the best migration service with full guarantee'}
            </p>
          </div>

          <div className="max-w-6xl mx-auto">
            {/* Main Feature - Free Migration */}
            <div className="relative bg-linear-to-br from-[#1d71b8] to-[#0f4c75] rounded-3xl p-8 md:p-12 mb-8 text-white overflow-hidden">
              <div className="absolute top-0 end-0 w-64 h-64 bg-white/5 rounded-full -translate-y-1/2 translate-x-1/2" />
              <div className="absolute bottom-0 start-0 w-48 h-48 bg-white/5 rounded-full translate-y-1/2 -translate-x-1/2" />
              
              <div className="relative z-10 grid md:grid-cols-2 gap-8 items-center">
                <div>
                  <div className="inline-flex items-center gap-2 bg-[#00D4AA] text-black px-4 py-2 rounded-full text-sm font-bold mb-6">
                    <RefreshCw className="w-4 h-4" />
                    {isRTL ? 'نقل مجاني 100%' : '100% FREE'}
                  </div>
                  <h3 className="text-2xl md:text-3xl font-bold mb-4">
                    {isRTL ? 'نقل مجاني بالكامل' : 'Completely Free Migration'}
                  </h3>
                  <p className="text-white/80 text-lg mb-6">
                    {isRTL
                      ? 'نتولى كل شيء بدون تكلفة إضافية عند اشتراكك في الاستضافة. فريقنا المتخصص سينقل موقعك بالكامل.'
                      : 'We handle everything at no extra cost when you sign up for hosting. Our dedicated team will migrate your entire website.'}
                  </p>
                  <div className="flex flex-wrap gap-4">
                    <div className="flex items-center gap-2">
                      <CheckCircle className="w-5 h-5 text-[#00D4AA]" />
                      <span>{isRTL ? 'بدون رسوم مخفية' : 'No Hidden Fees'}</span>
                    </div>
                    <div className="flex items-center gap-2">
                      <CheckCircle className="w-5 h-5 text-[#00D4AA]" />
                      <span>{isRTL ? 'نقل غير محدود' : 'Unlimited Transfers'}</span>
                    </div>
                  </div>
                </div>
                <div className="flex justify-center">
                  <div className="relative">
                    <div className="w-48 h-48 md:w-56 md:h-56 bg-white/10 rounded-full flex items-center justify-center backdrop-blur-sm">
                      <div className="w-36 h-36 md:w-44 md:h-44 bg-white/10 rounded-full flex items-center justify-center">
                        <div className="text-center">
                          <span className="block text-5xl md:text-6xl font-bold">$0</span>
                          <span className="text-white/70">{isRTL ? 'تكلفة النقل' : 'Migration Cost'}</span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            {/* Feature Grid */}
            <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
              {features.filter((_, i) => i !== 1).map((feature, index) => {
                const Icon = feature.icon;
                const colors = [
                  { bg: 'bg-blue-50', icon: 'text-blue-600', border: 'border-blue-100' },
                  { bg: 'bg-emerald-50', icon: 'text-emerald-600', border: 'border-emerald-100' },
                  { bg: 'bg-purple-50', icon: 'text-purple-600', border: 'border-purple-100' },
                  { bg: 'bg-orange-50', icon: 'text-orange-600', border: 'border-orange-100' },
                  { bg: 'bg-pink-50', icon: 'text-pink-600', border: 'border-pink-100' },
                ];
                const color = colors[index % colors.length];
                
                return (
                  <div
                    key={index}
                    className={cn(
                      'feature-card group relative bg-white rounded-2xl p-6 border-2 transition-all duration-300 hover:shadow-xl hover:-translate-y-1',
                      color.border
                    )}
                  >
                    <div className={cn(
                      'w-14 h-14 rounded-2xl flex items-center justify-center mb-5 transition-transform group-hover:scale-110',
                      color.bg
                    )}>
                      <Icon className={cn('w-7 h-7', color.icon)} />
                    </div>
                    <h3 className="text-xl font-bold text-gray-800 mb-3">
                      {isRTL ? feature.title.ar : feature.title.en}
                    </h3>
                    <p className="text-gray-600">
                      {isRTL ? feature.description.ar : feature.description.en}
                    </p>
                    <div className={cn(
                      'absolute bottom-0 start-0 end-0 h-1 rounded-b-2xl opacity-0 group-hover:opacity-100 transition-opacity',
                      color.icon.replace('text-', 'bg-')
                    )} />
                  </div>
                );
              })}
            </div>

            {/* Stats */}
            <div className="mt-12 grid grid-cols-2 md:grid-cols-4 gap-6">
              {[
                { number: '10K+', label: { en: 'Sites Migrated', ar: 'موقع تم نقله' } },
                { number: '99.9%', label: { en: 'Success Rate', ar: 'نسبة النجاح' } },
                { number: '24h', label: { en: 'Average Time', ar: 'متوسط الوقت' } },
                { number: '0', label: { en: 'Data Loss', ar: 'فقدان البيانات' } },
              ].map((stat, index) => (
                <div key={index} className="text-center p-6 bg-gray-50 rounded-2xl">
                  <div className="text-3xl md:text-4xl font-bold text-[#1d71b8] mb-2">{stat.number}</div>
                  <div className="text-gray-600 text-sm">{isRTL ? stat.label.ar : stat.label.en}</div>
                </div>
              ))}
            </div>
          </div>
        </div>
      </section>

      {/* What We Migrate */}
      <section className="py-20 bg-gray-50">
        <div className="container mx-auto px-4">
          <div className="max-w-5xl mx-auto">
            <div className="grid lg:grid-cols-2 gap-12 items-center">
              <div>
                <h2 className="text-3xl md:text-4xl font-bold text-gray-800 mb-4">
                  {isRTL ? 'ماذا ننقل؟' : 'What We Migrate'}
                </h2>
                <p className="text-lg text-gray-600 mb-8">
                  {isRTL
                    ? 'ننقل كل شيء تحتاجه لتشغيل موقعك بشكل مثالي على سيرفراتنا.'
                    : 'We migrate everything you need to run your website perfectly on our servers.'}
                </p>
                <div className="grid grid-cols-2 gap-4">
                  {whatWeMigrate.map((item, index) => (
                    <div key={index} className="flex items-center gap-3">
                      <div className="w-6 h-6 bg-[#00D4AA] rounded-full flex items-center justify-center shrink-0">
                        <Check className="w-4 h-4 text-white" />
                      </div>
                      <span className="text-gray-700">
                        {isRTL ? item.ar : item.en}
                      </span>
                    </div>
                  ))}
                </div>
              </div>
              <div className="bg-linear-to-br from-[#1d71b8] to-[#0f4c75] rounded-2xl p-8 text-white">
                <Server className="w-16 h-16 mb-6 opacity-80" />
                <h3 className="text-2xl font-bold mb-4">
                  {isRTL ? 'نقل متعدد المواقع' : 'Multiple Site Migration'}
                </h3>
                <p className="text-white/80 mb-6">
                  {isRTL
                    ? 'لديك أكثر من موقع؟ لا مشكلة! يمكننا نقل جميع مواقعك في نفس الوقت.'
                    : 'Have multiple websites? No problem! We can migrate all your sites at once.'}
                </p>
                <ul className="space-y-3">
                  <li className="flex items-center gap-2">
                    <CheckCircle className="w-5 h-5 text-[#00D4AA]" />
                    {isRTL ? 'مواقع ووردبريس متعددة' : 'Multiple WordPress Sites'}
                  </li>
                  <li className="flex items-center gap-2">
                    <CheckCircle className="w-5 h-5 text-[#00D4AA]" />
                    {isRTL ? 'متاجر WooCommerce' : 'WooCommerce Stores'}
                  </li>
                  <li className="flex items-center gap-2">
                    <CheckCircle className="w-5 h-5 text-[#00D4AA]" />
                    {isRTL ? 'تطبيقات مخصصة' : 'Custom Applications'}
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </section>

      {/* Testimonials */}
      <section className="py-20 bg-white">
        <div className="container mx-auto px-4">
          <div className="text-center mb-16">
            <h2 className="text-3xl md:text-4xl font-bold text-gray-800 mb-4">
              {isRTL ? 'ماذا يقول عملاؤنا' : 'What Our Customers Say'}
            </h2>
          </div>

          <div className="max-w-6xl mx-auto">
            <div className="grid md:grid-cols-3 gap-6">
              {testimonials.map((testimonial, index) => (
                <div
                  key={index}
                  className="bg-gray-50 rounded-2xl p-6 border border-gray-100"
                >
                  <div className="flex gap-1 mb-4">
                    {[...Array(testimonial.rating)].map((_, i) => (
                      <Star key={i} className="w-5 h-5 fill-yellow-400 text-yellow-400" />
                    ))}
                  </div>
                  <p className="text-gray-600 mb-6">
                    "{isRTL ? testimonial.content.ar : testimonial.content.en}"
                  </p>
                  <div>
                    <p className="font-bold text-gray-800">
                      {isRTL ? testimonial.name.ar : testimonial.name.en}
                    </p>
                    <p className="text-sm text-gray-500">
                      {isRTL ? testimonial.role.ar : testimonial.role.en}
                    </p>
                  </div>
                </div>
              ))}
            </div>
          </div>
        </div>
      </section>

      {/* Request Form Section */}
      <section id="request-form" className="py-20 bg-gray-50">
        <div className="container mx-auto px-4">
          <div className="max-w-3xl mx-auto">
            <div className="text-center mb-12">
              <h2 className="text-3xl md:text-4xl font-bold text-gray-800 mb-4">
                {isRTL ? 'طلب نقل مجاني' : 'Request Free Migration'}
              </h2>
              <p className="text-lg text-gray-600">
                {isRTL
                  ? 'املأ النموذج أدناه وسيتواصل معك فريقنا خلال 24 ساعة'
                  : 'Fill out the form below and our team will contact you within 24 hours'}
              </p>
            </div>

            {submitStatus === 'success' && (
              <div className="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl">
                <div className="flex items-center gap-3">
                  <CheckCircle className="w-6 h-6 text-green-600" />
                  <div>
                    <p className="font-semibold text-green-800">
                      {isRTL ? 'تم إرسال طلبك بنجاح!' : 'Your request has been submitted successfully!'}
                    </p>
                    <p className="text-green-700 text-sm">
                      {isRTL ? 'سيتواصل معك فريقنا خلال 24 ساعة' : 'Our team will contact you within 24 hours'}
                    </p>
                  </div>
                </div>
              </div>
            )}

            {submitStatus === 'error' && (
              <div className="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl">
                <p className="text-red-800">
                  {isRTL ? 'حدث خطأ أثناء إرسال طلبك. يرجى المحاولة مرة أخرى.' : 'An error occurred while submitting your request. Please try again.'}
                </p>
              </div>
            )}

            <form ref={formRef} onSubmit={handleSubmit} className="bg-white rounded-2xl shadow-xl p-8">
              <div className="grid md:grid-cols-2 gap-6 mb-6">
                <div>
                  <label className="block text-sm font-medium text-gray-700 mb-2">
                    {isRTL ? 'الاسم الكامل' : 'Full Name'} <span className="text-red-500">*</span>
                  </label>
                  <input
                    type="text"
                    name="fullName"
                    required
                    pattern="^[A-Za-z\s]+$"
                    title={isRTL ? 'يرجى إدخال أحرف إنجليزية فقط بدون أرقام' : 'Please enter English letters only, no numbers'}
                    onInput={(e) => {
                      const input = e.target as HTMLInputElement;
                      input.value = input.value.replace(/[^A-Za-z\s]/g, '');
                    }}
                    className="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#1d71b8] focus:border-transparent outline-none transition-all"
                    placeholder={isRTL ? 'أدخل اسمك بالإنجليزية' : 'Enter your name in English'}
                  />
                  <p className="text-xs text-gray-500 mt-1">
                    {isRTL ? 'أحرف إنجليزية فقط' : 'English letters only'}
                  </p>
                </div>
                <div>
                  <label className="block text-sm font-medium text-gray-700 mb-2">
                    {isRTL ? 'البريد الإلكتروني' : 'Email Address'} <span className="text-red-500">*</span>
                  </label>
                  <input
                    type="email"
                    name="email"
                    required
                    pattern="^[A-Za-z0-9._%+\-]+@[A-Za-z0-9.\-]+\.[A-Za-z]{2,}$"
                    title={isRTL ? 'يرجى إدخال بريد إلكتروني صحيح بأحرف إنجليزية' : 'Please enter a valid email address in English'}
                    onInput={(e) => {
                      const input = e.target as HTMLInputElement;
                      input.value = input.value.replace(/[^A-Za-z0-9._%+\-@]/g, '');
                    }}
                    className="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#1d71b8] focus:border-transparent outline-none transition-all"
                    placeholder={isRTL ? 'example@email.com' : 'example@email.com'}
                  />
                  <p className="text-xs text-gray-500 mt-1">
                    {isRTL ? 'أحرف إنجليزية فقط' : 'English characters only'}
                  </p>
                </div>
              </div>

              <div className="grid md:grid-cols-2 gap-6 mb-6">
                <div>
                  <label className="block text-sm font-medium text-gray-700 mb-2">
                    {isRTL ? 'رقم الهاتف' : 'Phone Number'} <span className="text-red-500">*</span>
                  </label>
                  <div className="flex gap-2">
                    <select
                      name="countryCode"
                      title={isRTL ? 'كود الدولة' : 'Country Code'}
                      className="w-28 px-3 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#1d71b8] focus:border-transparent outline-none transition-all text-sm"
                      defaultValue="+20"
                    >
                      <option value="+20">🇪🇬 +20</option>
                      <option value="+966">🇸🇦 +966</option>
                      <option value="+971">🇦🇪 +971</option>
                      <option value="+965">🇰🇼 +965</option>
                      <option value="+974">🇶🇦 +974</option>
                      <option value="+973">🇧🇭 +973</option>
                      <option value="+968">🇴🇲 +968</option>
                      <option value="+962">🇯🇴 +962</option>
                      <option value="+961">🇱🇧 +961</option>
                      <option value="+970">🇵🇸 +970</option>
                      <option value="+964">🇮🇶 +964</option>
                      <option value="+212">🇲🇦 +212</option>
                      <option value="+216">🇹🇳 +216</option>
                      <option value="+213">🇩🇿 +213</option>
                      <option value="+249">🇸🇩 +249</option>
                      <option value="+218">🇱🇾 +218</option>
                      <option value="+967">🇾🇪 +967</option>
                      <option value="+963">🇸🇾 +963</option>
                      <option value="+1">🇺🇸 +1</option>
                      <option value="+44">🇬🇧 +44</option>
                      <option value="+49">🇩🇪 +49</option>
                      <option value="+33">🇫🇷 +33</option>
                      <option value="+90">🇹🇷 +90</option>
                      <option value="+91">🇮🇳 +91</option>
                      <option value="+92">🇵🇰 +92</option>
                    </select>
                    <input
                      type="tel"
                      name="phone"
                      required
                      maxLength={13}
                      pattern="^[0-9]{1,13}$"
                      title={isRTL ? 'يرجى إدخال أرقام فقط (حد أقصى 13 رقم)' : 'Please enter numbers only (max 13 digits)'}
                      onInput={(e) => {
                        const input = e.target as HTMLInputElement;
                        input.value = input.value.replace(/[^0-9]/g, '').slice(0, 13);
                      }}
                      className="flex-1 px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#1d71b8] focus:border-transparent outline-none transition-all"
                      placeholder={isRTL ? 'رقم الهاتف' : 'Phone number'}
                    />
                  </div>
                </div>
                <div>
                  <label className="block text-sm font-medium text-gray-700 mb-2">
                    {isRTL ? 'رمز الدعم (Support PIN)' : 'Support PIN'} <span className="text-red-500">*</span>
                  </label>
                  <div className={cn("flex gap-2", isRTL && "flex-row-reverse")}>
                    {[0, 1, 2, 3, 4, 5].map((index) => (
                      <input
                        key={index}
                        type="text"
                        name={`pin${index}`}
                        inputMode="numeric"
                        maxLength={1}
                        required
                        aria-label={`PIN digit ${index + 1}`}
                        placeholder="0"
                        className="w-12 h-12 text-center text-xl font-bold border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-[#1d71b8] focus:border-[#1d71b8] outline-none transition-all placeholder:text-gray-300"
                        onInput={(e) => {
                          const input = e.target as HTMLInputElement;
                          input.value = input.value.replace(/[^0-9]/g, '');
                          if (input.value && input.nextElementSibling) {
                            (input.nextElementSibling as HTMLInputElement).focus();
                          }
                        }}
                        onKeyDown={(e) => {
                          const input = e.target as HTMLInputElement;
                          if (e.key === 'Backspace' && !input.value && input.previousElementSibling) {
                            (input.previousElementSibling as HTMLInputElement).focus();
                          }
                        }}
                        onPaste={(e) => {
                          e.preventDefault();
                          const paste = e.clipboardData.getData('text').replace(/[^0-9]/g, '').slice(0, 6);
                          const inputs = (e.target as HTMLInputElement).parentElement?.querySelectorAll('input');
                          if (inputs) {
                            paste.split('').forEach((char, i) => {
                              if (inputs[i]) {
                                (inputs[i] as HTMLInputElement).value = char;
                              }
                            });
                            if (inputs[paste.length - 1]) {
                              (inputs[paste.length - 1] as HTMLInputElement).focus();
                            }
                          }
                        }}
                      />
                    ))}
                  </div>
                  <p className="text-xs text-gray-500 mt-2">
                    {isRTL 
                      ? 'تجده في لوحة تحكم حسابك في Pro Gineous' 
                      : 'Found in your Pro Gineous account dashboard'}
                  </p>
                </div>
              </div>

              <div className="bg-amber-50 border border-amber-200 rounded-xl p-4 mb-6">
                <p className="text-amber-800 text-sm">
                  {isRTL 
                    ? '⚠️ يجب أن يكون لديك حساب نشط ومشترك في إحدى خطط الاستضافة لدينا لإتمام عملية النقل المجاني.' 
                    : '⚠️ You must have an active account with an active hosting plan to complete the free migration.'}
                </p>
              </div>

              <div className="mb-6">
                <label className="block text-sm font-medium text-gray-700 mb-2">
                  {isRTL ? 'رابط الموقع الحالي' : 'Current Website URL'} <span className="text-red-500">*</span>
                </label>
                <input
                  type="url"
                  name="websiteUrl"
                  required
                  pattern="^[A-Za-z0-9:/.?=&_\-#%+]+$"
                  title={isRTL ? 'يرجى إدخال رابط صحيح بأحرف إنجليزية فقط' : 'Please enter a valid URL with English characters only'}
                  onInput={(e) => {
                    const input = e.target as HTMLInputElement;
                    input.value = input.value.replace(/[^\x00-\x7F]/g, '');
                  }}
                  className="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#1d71b8] focus:border-transparent outline-none transition-all"
                  placeholder="https://example.com"
                />
              </div>

              <div className="mb-6">
                <label htmlFor="currentHost" className="block text-sm font-medium text-gray-700 mb-2">
                  {isRTL ? 'شركة الاستضافة الحالية' : 'Current Hosting Provider'} <span className="text-red-500">*</span>
                </label>
                <select 
                  id="currentHost"
                  name="hostingProvider"
                  required
                  title={isRTL ? 'شركة الاستضافة الحالية' : 'Current Hosting Provider'}
                  className="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#1d71b8] focus:border-transparent outline-none transition-all"
                >
                  <option value="">{isRTL ? 'اختر شركة الاستضافة...' : 'Select hosting provider...'}</option>
                  <optgroup label={isRTL ? 'شركات عالمية' : 'Global Providers'}>
                    <option value="GoDaddy">GoDaddy</option>
                    <option value="Bluehost">Bluehost</option>
                    <option value="Hostinger">Hostinger</option>
                    <option value="Namecheap">Namecheap</option>
                    <option value="SiteGround">SiteGround</option>
                    <option value="HostGator">HostGator</option>
                    <option value="dreamhost">DreamHost</option>
                    <option value="a2hosting">A2 Hosting</option>
                    <option value="ionos">IONOS (1&1)</option>
                    <option value="cloudways">Cloudways</option>
                    <option value="digitalocean">DigitalOcean</option>
                    <option value="aws">Amazon AWS</option>
                    <option value="googlecloud">Google Cloud</option>
                    <option value="vultr">Vultr</option>
                    <option value="linode">Linode</option>
                    <option value="hetzner">Hetzner</option>
                    <option value="contabo">Contabo</option>
                  </optgroup>
                  <option value="Other">{isRTL ? 'أخرى (حدد في الملاحظات)' : 'Other (specify in notes)'}</option>
                </select>
              </div>

              <div className="mb-6">
                <label htmlFor="hostingType" className="block text-sm font-medium text-gray-700 mb-2">
                  {isRTL ? 'نوع الاستضافة الحالية' : 'Current Hosting Type'} <span className="text-red-500">*</span>
                </label>
                <select 
                  id="hostingType"
                  name="hostingType"
                  required
                  title={isRTL ? 'نوع الاستضافة الحالية' : 'Current Hosting Type'}
                  className="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#1d71b8] focus:border-transparent outline-none transition-all"
                >
                  <option value="">{isRTL ? 'اختر نوع الاستضافة...' : 'Select hosting type...'}</option>
                  <option value="Shared Hosting">{isRTL ? 'استضافة مشتركة' : 'Shared Hosting'}</option>
                  <option value="VPS Hosting">{isRTL ? 'سيرفر افتراضي VPS' : 'VPS Hosting'}</option>
                  <option value="Dedicated Server">{isRTL ? 'سيرفر مخصص' : 'Dedicated Server'}</option>
                  <option value="Cloud Hosting">{isRTL ? 'استضافة سحابية' : 'Cloud Hosting'}</option>
                  <option value="WordPress Hosting">{isRTL ? 'استضافة ووردبريس' : 'WordPress Hosting'}</option>
                  <option value="Reseller Hosting">{isRTL ? 'استضافة موزعين' : 'Reseller Hosting'}</option>
                  <option value="Other">{isRTL ? 'أخرى' : 'Other'}</option>
                </select>
              </div>

              <div className="mb-6">
                <label htmlFor="controlPanel" className="block text-sm font-medium text-gray-700 mb-2">
                  {isRTL ? 'نوع لوحة التحكم الحالية' : 'Current Control Panel'} <span className="text-red-500">*</span>
                </label>
                <select 
                  id="controlPanel"
                  name="controlPanel"
                  required
                  title={isRTL ? 'نوع لوحة التحكم الحالية' : 'Current Control Panel'}
                  className="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#1d71b8] focus:border-transparent outline-none transition-all"
                >
                  <option value="">{isRTL ? 'اختر...' : 'Select...'}</option>
                  <option value="cPanel">cPanel</option>
                  <option value="Plesk">Plesk</option>
                  <option value="DirectAdmin">DirectAdmin</option>
                  <option value="CyberPanel">CyberPanel</option>
                  <option value="CentOS Web Panel">CentOS Web Panel</option>
                  <option value="HestiaCP">HestiaCP</option>
                  <option value="ISPConfig">ISPConfig</option>
                  <option value="VestaCP">VestaCP</option>
                  <option value="Other">{isRTL ? 'أخرى' : 'Other'}</option>
                </select>
              </div>

              <div className="mb-6">
                <label className="block text-sm font-medium text-gray-700 mb-2">
                  {isRTL ? 'ملاحظات إضافية' : 'Additional Notes'}
                </label>
                <textarea
                  name="notes"
                  rows={4}
                  className="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#1d71b8] focus:border-transparent outline-none transition-all resize-none"
                  placeholder={isRTL ? 'أي معلومات إضافية عن موقعك...' : 'Any additional information about your website...'}
                />
              </div>

              <button
                type="submit"
                disabled={isSubmitting}
                className="w-full bg-[#1d71b8] text-white py-4 rounded-xl font-semibold text-lg hover:bg-[#1a5f9a] transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2"
              >
                {isSubmitting ? (
                  <>
                    <svg className="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                      <circle className="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" strokeWidth="4"></circle>
                      <path className="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    {isRTL ? 'جاري الإرسال...' : 'Submitting...'}
                  </>
                ) : (
                  isRTL ? 'إرسال طلب النقل' : 'Submit Migration Request'
                )}
              </button>

              <p className="text-center text-sm text-gray-500 mt-4">
                {isRTL
                  ? 'سيتواصل معك فريقنا خلال 24 ساعة لبدء عملية النقل'
                  : 'Our team will contact you within 24 hours to start the migration process'}
              </p>
            </form>
          </div>
        </div>
      </section>

      {/* FAQs */}
      <section className="py-20 bg-white">
        <div className="container mx-auto px-4">
          <div className="max-w-3xl mx-auto">
            <h2 className="text-3xl md:text-4xl font-bold text-center text-gray-800 mb-12">
              {isRTL ? 'الأسئلة الشائعة' : 'Frequently Asked Questions'}
            </h2>

            <div className="space-y-4">
              {faqs.map((faq, index) => (
                <div
                  key={index}
                  className="bg-gray-50 rounded-xl overflow-hidden border border-gray-200"
                >
                  <button
                    onClick={() => setExpandedFaq(expandedFaq === index ? null : index)}
                    className="w-full px-6 py-4 flex items-center justify-between text-left hover:bg-gray-100 transition-colors"
                  >
                    <span className="font-semibold text-gray-800">
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
        </div>
      </section>

      {/* CTA Section */}
      <section className="py-20 bg-linear-to-r from-[#1d71b8] to-[#0f4c75]">
        <div className="container mx-auto px-4 text-center">
          <h2 className="text-3xl md:text-4xl font-bold text-white mb-6">
            {isRTL ? 'جاهز للانتقال إلى استضافة أفضل؟' : 'Ready to Move to Better Hosting?'}
          </h2>
          <p className="text-xl text-white/80 mb-8 max-w-2xl mx-auto">
            {isRTL
              ? 'ابدأ اليوم واحصل على نقل مجاني بالكامل مع ضمان استرداد الأموال لمدة 30 يوماً'
              : 'Start today and get completely free migration with 30-day money back guarantee'}
          </p>
          <div className="flex flex-col sm:flex-row gap-4 justify-center">
            <a
              href="#request-form"
              className="inline-flex items-center justify-center gap-2 bg-[#00D4AA] text-black px-8 py-4 rounded-xl font-semibold text-lg hover:bg-[#00B894] transition-all duration-300 hover:scale-105"
            >
              {isRTL ? 'ابدأ النقل المجاني' : 'Start Free Migration'}
              <ArrowRight className={cn('w-5 h-5', isRTL && 'rotate-180')} />
            </a>
            <a
              href="/hosting/shared"
              className="inline-flex items-center justify-center gap-2 bg-white/10 text-white px-8 py-4 rounded-xl font-semibold text-lg hover:bg-white/20 transition-all duration-300 border border-white/20"
            >
              {isRTL ? 'عرض الخطط والأسعار' : 'View Plans & Pricing'}
            </a>
          </div>
        </div>
      </section>
    </div>
  );
}
