'use client';

import { useState, useEffect, useRef } from 'react';
import { useLocale } from 'next-intl';
import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import {
  Check,
  ChevronDown,
  ChevronUp,
  ArrowRight,
  Search,
  TrendingUp,
  BarChart3,
  FileText,
  Users,
  Target,
  Zap,
  LineChart,
  Award,
} from 'lucide-react';
import { cn } from '@/lib/utils';

// Register GSAP plugins
if (typeof window !== 'undefined') {
  gsap.registerPlugin(ScrollTrigger);
}

// marketgoo Plans
const seoPlans = [
  {
    id: 'lite',
    name: 'Lite',
    nameAr: 'لايت',
    price: 4.99,
    period: { en: '/mo', ar: '/شهر' },
    popular: false,
    features: {
      searchSubmission: true,
      googleAnalytics: true,
      pdfReport: true,
      pagesScanned: { en: 'Up to 50', ar: 'حتى 50' },
      competitorTracking: { en: 'Up to 2', ar: 'حتى 2' },
      keywordTracking: { en: 'Up to 5', ar: 'حتى 5' },
      reportUpdate: { en: 'Weekly', ar: 'أسبوعي' },
      seoPlan: { en: 'Limited', ar: 'محدود' },
      progressReport: true,
    },
    cartLink: 'https://app.progineous.com/store/marketgoo/lite-1',
    buttonText: { en: 'Signup Now', ar: 'سجل الآن' },
  },
  {
    id: 'pro',
    name: 'PRO',
    nameAr: 'برو',
    price: 14.99,
    period: { en: '/mo', ar: '/شهر' },
    popular: true,
    badge: { en: 'Best value!', ar: 'أفضل قيمة!' },
    features: {
      searchSubmission: true,
      googleAnalytics: true,
      pdfReport: true,
      pagesScanned: { en: 'Up to 1000', ar: 'حتى 1000' },
      competitorTracking: { en: 'Up to 4', ar: 'حتى 4' },
      keywordTracking: { en: 'Up to 20', ar: 'حتى 20' },
      reportUpdate: { en: 'Daily', ar: 'يومي' },
      seoPlan: { en: 'Complete with step-by-step guide', ar: 'كامل مع دليل خطوة بخطوة' },
      progressReport: true,
    },
    cartLink: 'https://app.progineous.com/store/marketgoo/pro-1',
    buttonText: { en: 'Signup Now', ar: 'سجل الآن' },
  },
];

// Feature rows for comparison table
const featureRows = [
  { key: 'searchSubmission', label: { en: 'Search engine submission', ar: 'إرسال لمحركات البحث' }, isBoolean: true },
  { key: 'googleAnalytics', label: { en: 'Connect Google Analytics', ar: 'ربط Google Analytics' }, isBoolean: true },
  { key: 'pdfReport', label: { en: 'Download SEO report as PDF', ar: 'تحميل تقرير SEO كـ PDF' }, isBoolean: true },
  { key: 'pagesScanned', label: { en: 'Pages scanned', ar: 'الصفحات الممسوحة' }, isBoolean: false },
  { key: 'competitorTracking', label: { en: 'Competitor tracking', ar: 'تتبع المنافسين' }, isBoolean: false },
  { key: 'keywordTracking', label: { en: 'Keyword tracking & optimization', ar: 'تتبع وتحسين الكلمات المفتاحية' }, isBoolean: false },
  { key: 'reportUpdate', label: { en: 'Updated report & plan', ar: 'تحديث التقرير والخطة' }, isBoolean: false },
  { key: 'seoPlan', label: { en: 'Custom SEO Plan', ar: 'خطة SEO مخصصة' }, isBoolean: false },
  { key: 'progressReport', label: { en: 'Monthly progress report', ar: 'تقرير تقدم شهري' }, isBoolean: true },
];

// How it works steps
const howItWorks = [
  {
    number: 1,
    icon: 'https://app.progineous.com/assets/img/marketconnect/marketgoo/1-signup.svg',
    title: { en: 'Sign Up and get instant SEO Report', ar: 'سجل واحصل على تقرير SEO فوري' },
  },
  {
    number: 2,
    icon: 'https://app.progineous.com/assets/img/marketconnect/marketgoo/2-get-seo-plan.svg',
    title: { en: 'Get your easy SEO plan', ar: 'احصل على خطة SEO السهلة' },
  },
  {
    number: 3,
    icon: 'https://app.progineous.com/assets/img/marketconnect/marketgoo/3-follow-instructions.svg',
    title: { en: 'Follow the simple step-by-step instructions', ar: 'اتبع التعليمات البسيطة خطوة بخطوة' },
  },
  {
    number: 4,
    icon: 'https://app.progineous.com/assets/img/marketconnect/marketgoo/4-start-improving.svg',
    title: { en: 'Start Improving', ar: 'ابدأ التحسين' },
    description: {
      en: 'Put your SEO plan into action (with no experts needed) and get a monthly progress report',
      ar: 'نفذ خطة SEO الخاصة بك (بدون الحاجة لخبراء) واحصل على تقرير تقدم شهري',
    },
  },
  {
    number: 5,
    icon: 'https://app.progineous.com/assets/img/marketconnect/marketgoo/5-track-monitor.svg',
    title: { en: 'Track & Monitor', ar: 'تتبع وراقب' },
    description: {
      en: "See how your competitors rank for the keywords you're focusing on, and track their site's popularity",
      ar: 'شاهد ترتيب منافسيك للكلمات المفتاحية التي تركز عليها، وتتبع شعبية مواقعهم',
    },
  },
];

// FAQs
const faqs = [
  {
    question: { en: 'Should I choose Lite or Pro?', ar: 'هل أختار Lite أم Pro؟' },
    answer: {
      en: 'Choose Lite if you\'re just getting started with SEO and want basic tracking. Choose Pro for comprehensive SEO tools, daily updates, more keywords, and a complete step-by-step guide.',
      ar: 'اختر Lite إذا كنت تبدأ للتو مع SEO وتريد تتبعًا أساسيًا. اختر Pro للحصول على أدوات SEO شاملة وتحديثات يومية والمزيد من الكلمات المفتاحية ودليل كامل خطوة بخطوة.',
    },
    hasVideo: true,
    videoId: '394484913',
  },
  {
    question: { en: 'Does marketgoo make the recommended changes or do I?', ar: 'هل يقوم marketgoo بإجراء التغييرات الموصى بها أم أنا؟' },
    answer: {
      en: "marketgoo is a Do-it-Yourself tool, so while we help you with analysing your site and giving recommendations, along with tasks and instructions for you to optimize your site, we don't make these changes for you.",
      ar: 'marketgoo هو أداة افعلها بنفسك، لذا بينما نساعدك في تحليل موقعك وتقديم التوصيات، إلى جانب المهام والتعليمات لتحسين موقعك، فإننا لا نقوم بهذه التغييرات نيابة عنك.',
    },
  },
  {
    question: { en: 'Why do I need SEO?', ar: 'لماذا أحتاج SEO؟' },
    answer: {
      en: "You work on your SEO in order to improve your site's rankings in search results. This leads to attracting more traffic - and ideally, to convert that traffic into customers and leads.",
      ar: 'أنت تعمل على SEO لتحسين ترتيب موقعك في نتائج البحث. هذا يؤدي إلى جذب المزيد من الزيارات - ومن الناحية المثالية، تحويل هذه الزيارات إلى عملاء.',
    },
  },
];

// Testimonial
const testimonial = {
  quote: {
    en: '"marketgoo made the complicated simple for me. I never knew where to start with SEO until I started using this service. Literally, I more than doubled my traffic when I started using this."',
    ar: '"جعل marketgoo المعقد بسيطًا بالنسبة لي. لم أكن أعرف من أين أبدأ مع SEO حتى بدأت باستخدام هذه الخدمة. حرفيًا، ضاعفت حركة المرور لدي عندما بدأت باستخدامها."',
  },
  author: 'Heather Figi',
  company: 'Music for Young Violinists',
  image: 'https://app.progineous.com/assets/img/marketconnect/marketgoo/user-testimonial-1.jpg',
  caseStudyLink: 'https://www.marketgoo.com/blog-post/2018/08/30/review-music-for-violinists/',
};

export default function SEOToolsPage() {
  const locale = useLocale();
  const isRTL = locale === 'ar';
  const [expandedFaq, setExpandedFaq] = useState<number | null>(null);
  const heroRef = useRef<HTMLDivElement>(null);

  useEffect(() => {
    // Hero animations
    const ctx = gsap.context(() => {
      gsap.from('.hero-content > *', {
        y: 50,
        opacity: 0,
        duration: 0.8,
        stagger: 0.15,
        ease: 'power3.out',
      });

      // Animate steps
      gsap.from('.step-item', {
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

      // Animate pricing cards
      gsap.from('.pricing-card', {
        scrollTrigger: {
          trigger: '.pricing-section',
          start: 'top 80%',
        },
        y: 50,
        opacity: 0,
        duration: 0.6,
        stagger: 0.2,
        ease: 'power3.out',
      });

      // Animate testimonial
      gsap.from('.testimonial-card', {
        scrollTrigger: {
          trigger: '.testimonial-section',
          start: 'top 80%',
        },
        scale: 0.95,
        opacity: 0,
        duration: 0.8,
        ease: 'power3.out',
      });
    }, heroRef);

    return () => ctx.revert();
  }, []);

  // JSON-LD Structured Data
  const baseUrl = process.env.NEXT_PUBLIC_SITE_URL || 'https://progineous.com';
  
  const serviceSchema = {
    '@context': 'https://schema.org',
    '@type': 'SoftwareApplication',
    name: 'marketgoo SEO Tools',
    description: isRTL
      ? 'أدوات تحسين محركات البحث لتحليل الموقع وتتبع الكلمات المفتاحية'
      : 'SEO tools for website analysis and keyword tracking',
    applicationCategory: 'BusinessApplication',
    operatingSystem: 'Web',
    offers: {
      '@type': 'AggregateOffer',
      lowPrice: '4.99',
      highPrice: '14.99',
      priceCurrency: 'USD',
      offerCount: seoPlans.length,
    },
  };

  const breadcrumbSchema = {
    '@context': 'https://schema.org',
    '@type': 'BreadcrumbList',
    itemListElement: [
      { '@type': 'ListItem', position: 1, name: isRTL ? 'الرئيسية' : 'Home', item: `${baseUrl}/${locale}` },
      { '@type': 'ListItem', position: 2, name: isRTL ? 'السوق' : 'Market', item: `${baseUrl}/${locale}/market` },
      { '@type': 'ListItem', position: 3, name: isRTL ? 'أدوات SEO' : 'SEO Tools', item: `${baseUrl}/${locale}/market/seo-tools` },
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
      <script type="application/ld+json" dangerouslySetInnerHTML={{ __html: JSON.stringify(breadcrumbSchema) }} />
      <script type="application/ld+json" dangerouslySetInnerHTML={{ __html: JSON.stringify(faqSchema) }} />

      {/* Hero Section */}
      <section className="relative bg-gradient-to-br from-[#1d71b8] via-[#1a5a94] to-[#134067] text-white overflow-hidden">
        {/* Background Pattern */}
        <div className="absolute inset-0 opacity-10">
          <div
            className="absolute inset-0"
            style={{
              backgroundImage: `url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.4'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E")`,
            }}
          />
        </div>

        <div className="container mx-auto px-4 py-20 md:py-28 relative z-10">
          <div className="hero-content max-w-4xl mx-auto text-center">
            {/* Logo */}
            <div className="mb-8">
              <img
                src="https://app.progineous.com/assets/img/marketconnect/marketgoo/logo.svg"
                alt="marketgoo"
                className="h-12 md:h-16 mx-auto"
              />
            </div>

            <h1 className="text-4xl md:text-5xl lg:text-6xl font-bold mb-6">
              {isRTL ? 'حسّن حركة المرور لموقعك' : "Improve your Site's traffic"}
            </h1>

            <p className="text-xl md:text-2xl text-white/90 mb-8">
              {isRTL ? 'ونمِّ أعمالك مع marketgoo' : 'and Grow your Business with marketgoo'}
            </p>

            <a
              href="#pricing"
              className="inline-flex items-center gap-2 bg-white text-[#1d71b8] px-8 py-4 rounded-xl font-semibold text-lg hover:bg-gray-100 transition-all duration-300 hover:scale-105 shadow-lg"
            >
              {isRTL ? 'ابدأ الآن' : 'Get Started'}
              <ArrowRight className={cn('w-5 h-5', isRTL && 'rotate-180')} />
            </a>
          </div>
        </div>

        {/* Wave Bottom */}
        <div className="absolute bottom-0 left-0 right-0">
          <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path
              d="M0 120L60 105C120 90 240 60 360 45C480 30 600 30 720 37.5C840 45 960 60 1080 67.5C1200 75 1320 75 1380 75L1440 75V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0Z"
              fill="#f9fafb"
            />
          </svg>
        </div>
      </section>

      {/* How It Works Section */}
      <section className="steps-section py-20 bg-gray-50">
        <div className="container mx-auto px-4">
          <div className="max-w-6xl mx-auto">
            <div className="grid grid-cols-1 md:grid-cols-5 gap-6">
              {howItWorks.map((step, index) => (
                <div
                  key={index}
                  className="step-item flex flex-col items-center text-center"
                >
                  <div className="relative mb-4">
                    <div className="w-20 h-20 bg-white rounded-full shadow-lg flex items-center justify-center">
                      <img src={step.icon} alt={step.title.en} className="w-12 h-12" />
                    </div>
                    <div className="absolute -top-2 -right-2 w-8 h-8 bg-[#1d71b8] text-white rounded-full flex items-center justify-center font-bold text-sm">
                      {step.number}
                    </div>
                  </div>
                  <h3 className="font-semibold text-gray-800 mb-2">
                    {isRTL ? step.title.ar : step.title.en}
                  </h3>
                  {step.description && (
                    <p className="text-sm text-gray-600">
                      {isRTL ? step.description.ar : step.description.en}
                    </p>
                  )}
                </div>
              ))}
            </div>
          </div>
        </div>
      </section>

      {/* Pricing Section */}
      <section id="pricing" className="pricing-section py-20 bg-white">
        <div className="container mx-auto px-4">
          <div className="max-w-5xl mx-auto">
            {/* Comparison Table */}
            <div className="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-200">
              {/* Table Header */}
              <div className="grid grid-cols-3 bg-gray-50 border-b border-gray-200">
                <div className="p-6"></div>
                {seoPlans.map((plan, index) => (
                  <div
                    key={plan.id}
                    className={cn(
                      'pricing-card p-6 text-center',
                      plan.popular && 'bg-[#1d71b8] text-white'
                    )}
                  >
                    {plan.popular && plan.badge && (
                      <div className="inline-block bg-yellow-400 text-yellow-900 text-xs font-bold px-3 py-1 rounded-full mb-2">
                        {isRTL ? plan.badge.ar : plan.badge.en}
                      </div>
                    )}
                    <h3 className="text-2xl font-bold mb-2">
                      {isRTL ? plan.nameAr : plan.name}
                    </h3>
                    <div className="text-3xl font-bold mb-1">
                      ${plan.price}
                      <span className="text-base font-normal">
                        {isRTL ? plan.period.ar : plan.period.en}
                      </span>
                    </div>
                  </div>
                ))}
              </div>

              {/* Feature Rows */}
              {featureRows.map((row, index) => (
                <div
                  key={row.key}
                  className={cn(
                    'grid grid-cols-3 border-b border-gray-100',
                    index % 2 === 0 ? 'bg-white' : 'bg-gray-50/50'
                  )}
                >
                  <div className="p-4 font-medium text-gray-700 flex items-center">
                    {isRTL ? row.label.ar : row.label.en}
                  </div>
                  {seoPlans.map((plan) => {
                    const value = plan.features[row.key as keyof typeof plan.features];
                    return (
                      <div
                        key={plan.id}
                        className={cn(
                          'p-4 text-center flex items-center justify-center',
                          plan.popular && 'bg-[#1d71b8]/5'
                        )}
                      >
                        {row.isBoolean ? (
                          value ? (
                            <img
                              src="https://app.progineous.com/assets/img/marketconnect/marketgoo/icon-check.svg"
                              alt="Yes"
                              className="w-6 h-6"
                            />
                          ) : (
                            <span className="text-gray-300">—</span>
                          )
                        ) : (
                          <span className={cn(
                            'text-sm',
                            plan.popular ? 'text-[#1d71b8] font-semibold' : 'text-gray-600'
                          )}>
                            {typeof value === 'object' && value !== null
                              ? (isRTL ? (value as { ar: string }).ar : (value as { en: string }).en)
                              : String(value)}
                          </span>
                        )}
                      </div>
                    );
                  })}
                </div>
              ))}

              {/* Action Buttons Row */}
              <div className="grid grid-cols-3 bg-gray-50">
                <div className="p-6"></div>
                {seoPlans.map((plan) => (
                  <div key={plan.id} className={cn('p-6 text-center', plan.popular && 'bg-[#1d71b8]/5')}>
                    <a
                      href={plan.cartLink}
                      className={cn(
                        'inline-flex items-center justify-center gap-2 px-8 py-3 rounded-xl font-semibold transition-all duration-300 hover:scale-105',
                        plan.popular
                          ? 'bg-[#1d71b8] text-white hover:bg-[#165a93] shadow-lg'
                          : 'bg-gray-800 text-white hover:bg-gray-700'
                      )}
                    >
                      {isRTL ? plan.buttonText.ar : plan.buttonText.en}
                      <ArrowRight className={cn('w-4 h-4', isRTL && 'rotate-180')} />
                    </a>
                  </div>
                ))}
              </div>
            </div>
          </div>
        </div>
      </section>

      {/* Testimonial Section */}
      <section className="testimonial-section py-20 bg-gray-50">
        <div className="container mx-auto px-4">
          <div className="max-w-4xl mx-auto">
            <div className="testimonial-card bg-white rounded-2xl shadow-xl p-8 md:p-12">
              <div className="flex flex-col md:flex-row items-center gap-8">
                <div className="flex-1">
                  <p className="text-xl md:text-2xl text-gray-700 italic mb-6">
                    {isRTL ? testimonial.quote.ar : testimonial.quote.en}
                  </p>
                  <div className="flex items-center gap-4">
                    <img
                      src={testimonial.image}
                      alt={testimonial.author}
                      className="w-16 h-16 rounded-full object-cover"
                    />
                    <div>
                      <h4 className="font-bold text-gray-800">{testimonial.author}</h4>
                      <p className="text-gray-600">{testimonial.company}</p>
                    </div>
                  </div>
                  <a
                    href={testimonial.caseStudyLink}
                    target="_blank"
                    rel="noopener noreferrer"
                    className="inline-flex items-center gap-2 text-[#1d71b8] font-semibold mt-4 hover:underline"
                  >
                    {isRTL ? 'اقرأ دراسة الحالة' : 'Read the case study'}
                    <ArrowRight className={cn('w-4 h-4', isRTL && 'rotate-180')} />
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      {/* FAQs Section */}
      <section className="py-20 bg-white">
        <div className="container mx-auto px-4">
          <div className="max-w-3xl mx-auto">
            <h2 className="text-3xl md:text-4xl font-bold text-center text-gray-800 mb-12">
              {isRTL ? 'الأسئلة الشائعة والدعم' : 'FAQs and Support'}
            </h2>

            {/* Video Comparison */}
            <div className="mb-12">
              <h3 className="text-xl font-semibold text-center text-gray-700 mb-6">
                {isRTL ? 'شاهد مقارنة الفيديو للخطط' : 'See a Video comparison of the Plans'}
              </h3>
              <div className="rounded-xl overflow-hidden shadow-lg">
                <div style={{ padding: '56.25% 0 0 0', position: 'relative' }}>
                  <iframe
                    src="https://player.vimeo.com/video/394484913?h=8f5d5e5c5e&badge=0&autopause=0&player_id=0&app_id=58479"
                    style={{ position: 'absolute', top: 0, left: 0, width: '100%', height: '100%' }}
                    frameBorder="0"
                    allow="autoplay; fullscreen; picture-in-picture; clipboard-write; encrypted-media"
                    allowFullScreen
                    title="marketgoo Lite vs Pro comparison"
                  />
                </div>
              </div>
            </div>

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
      <section className="py-20 bg-gradient-to-r from-[#1d71b8] to-[#2485d1]">
        <div className="container mx-auto px-4 text-center">
          <h2 className="text-3xl md:text-4xl font-bold text-white mb-6">
            {isRTL ? 'ابدأ في تحسين ترتيب موقعك اليوم' : 'Start Improving Your Rankings Today'}
          </h2>
          <p className="text-xl text-white/90 mb-8 max-w-2xl mx-auto">
            {isRTL
              ? 'احصل على تقرير SEO فوري وخطة عمل مخصصة لتحسين ظهور موقعك في محركات البحث'
              : 'Get an instant SEO report and a custom action plan to improve your site\'s visibility in search engines'}
          </p>
          <a
            href="#pricing"
            className="inline-flex items-center gap-2 bg-white text-[#1d71b8] px-8 py-4 rounded-xl font-semibold text-lg hover:bg-gray-100 transition-all duration-300 hover:scale-105 shadow-lg"
          >
            {isRTL ? 'اختر خطتك' : 'Choose Your Plan'}
            <ArrowRight className={cn('w-5 h-5', isRTL && 'rotate-180')} />
          </a>
        </div>
      </section>
    </div>
  );
}
