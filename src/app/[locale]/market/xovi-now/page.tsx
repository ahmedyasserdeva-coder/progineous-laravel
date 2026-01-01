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
  Settings,
  Eye,
  Briefcase,
} from 'lucide-react';
import { cn } from '@/lib/utils';

// Register GSAP plugins
if (typeof window !== 'undefined') {
  gsap.registerPlugin(ScrollTrigger);
}

// XOVI NOW Plans
const xoviPlans = [
  {
    id: 'starter',
    name: 'XOVI NOW Starter',
    nameAr: 'XOVI NOW المبتدئ',
    price: 19,
    period: { en: '/mo', ar: '/شهر' },
    popular: false,
    features: {
      projects: 1,
      fullAccessAccounts: 1,
      readOnlyAccounts: 0,
      competitorBenchmarking: true,
      competitorsPerProject: 2,
      keywordResearch: true,
      rankTracker: true,
      keywordCrawls: 500,
      keywordCheck: { en: 'Weekly', ar: 'أسبوعي' },
      siteAudit: true,
      pagesToCrawl: { en: '500 per project', ar: '500 لكل مشروع' },
      seoAdvisor: true,
      textOptimizer: true,
    },
    cartLink: 'https://app.progineous.com/cart.php?a=add&pid=18',
  },
  {
    id: 'professional',
    name: 'XOVI NOW Professional',
    nameAr: 'XOVI NOW الاحترافي',
    price: 79,
    period: { en: '/mo', ar: '/شهر' },
    popular: true,
    features: {
      projects: 5,
      fullAccessAccounts: 2,
      readOnlyAccounts: 1,
      competitorBenchmarking: true,
      competitorsPerProject: 3,
      keywordResearch: true,
      rankTracker: true,
      keywordCrawls: 2500,
      keywordCheck: { en: 'Up to Daily', ar: 'حتى يومي' },
      siteAudit: true,
      pagesToCrawl: { en: '10k per project', ar: '10 آلاف لكل مشروع' },
      seoAdvisor: true,
      textOptimizer: true,
    },
    cartLink: 'https://app.progineous.com/cart.php?a=add&pid=19',
  },
];

// Feature rows for comparison
const featureRows = [
  { key: 'projects', label: { en: 'Projects', ar: 'المشاريع' }, isBoolean: false },
  { key: 'fullAccessAccounts', label: { en: 'Full-Access Accounts', ar: 'حسابات وصول كامل' }, isBoolean: false },
  { key: 'readOnlyAccounts', label: { en: 'Read-Only Accounts', ar: 'حسابات قراءة فقط' }, isBoolean: false },
  { key: 'competitorBenchmarking', label: { en: 'Competitor Benchmarking', ar: 'قياس أداء المنافسين' }, isBoolean: true },
  { key: 'competitorsPerProject', label: { en: 'Competitors per project', ar: 'المنافسين لكل مشروع' }, isBoolean: false },
  { key: 'keywordResearch', label: { en: 'Keyword Research', ar: 'بحث الكلمات المفتاحية' }, isBoolean: true },
  { key: 'rankTracker', label: { en: 'Rank Tracker', ar: 'تتبع الترتيب' }, isBoolean: true },
  { key: 'keywordCrawls', label: { en: 'Keyword crawls', ar: 'زحف الكلمات المفتاحية' }, isBoolean: false },
  { key: 'keywordCheck', label: { en: 'Keyword check', ar: 'فحص الكلمات المفتاحية' }, isBoolean: false },
  { key: 'siteAudit', label: { en: 'Site Audit', ar: 'تدقيق الموقع' }, isBoolean: true },
  { key: 'pagesToCrawl', label: { en: 'Pages to crawl', ar: 'الصفحات للزحف' }, isBoolean: false },
  { key: 'seoAdvisor', label: { en: 'SEO Advisor', ar: 'مستشار SEO' }, isBoolean: true },
  { key: 'textOptimizer', label: { en: 'SEO Text Optimizer', ar: 'محسن النصوص SEO' }, isBoolean: true },
];

// Product Tour Features
const productFeatures = [
  {
    id: 'keywords',
    name: { en: 'Keywords', ar: 'الكلمات المفتاحية' },
    icon: Search,
    title: { en: 'A 100M+ keyword database for research and inspiration', ar: 'قاعدة بيانات أكثر من 100 مليون كلمة مفتاحية للبحث والإلهام' },
    features: [
      { en: 'Get comprehensive keyword data', ar: 'احصل على بيانات شاملة للكلمات المفتاحية' },
      { en: "Find out which keywords your website's ranking for", ar: 'اكتشف الكلمات المفتاحية التي يحتل موقعك ترتيباً لها' },
      { en: 'Identify promising keywords for better traffic', ar: 'حدد كلمات مفتاحية واعدة لحركة مرور أفضل' },
      { en: "Analyze your competition's keywords and rankings", ar: 'حلل كلمات منافسيك وترتيباتهم' },
      { en: 'Compare international markets', ar: 'قارن الأسواق الدولية' },
      { en: 'Profit from a 100M+ keyword database', ar: 'استفد من قاعدة بيانات أكثر من 100 مليون كلمة' },
    ],
  },
  {
    id: 'advisor',
    name: { en: 'Advisor', ar: 'المستشار' },
    icon: Zap,
    title: { en: 'Your personal SEO assistant', ar: 'مساعدك الشخصي في SEO' },
    features: [
      { en: 'No expert knowledge needed', ar: 'لا حاجة لمعرفة خبير' },
      { en: 'Get personalized recommendations', ar: 'احصل على توصيات مخصصة' },
      { en: 'Track your progress with tasks', ar: 'تتبع تقدمك بالمهام' },
      { en: 'Prioritized by importance', ar: 'مرتبة حسب الأهمية' },
    ],
  },
  {
    id: 'rank-tracker',
    name: { en: 'Rank Tracker', ar: 'متتبع الترتيب' },
    icon: TrendingUp,
    title: { en: 'Monitor your search engine rankings', ar: 'راقب ترتيباتك في محركات البحث' },
    features: [
      { en: 'Track keyword rankings over time', ar: 'تتبع ترتيب الكلمات المفتاحية بمرور الوقت' },
      { en: 'Monitor competitors rankings', ar: 'راقب ترتيبات المنافسين' },
      { en: 'Get visibility score insights', ar: 'احصل على رؤى درجة الظهور' },
      { en: 'Historical data access', ar: 'الوصول للبيانات التاريخية' },
    ],
  },
  {
    id: 'site-audit',
    name: { en: 'Site Audit', ar: 'تدقيق الموقع' },
    icon: Settings,
    title: { en: 'Comprehensive website analysis', ar: 'تحليل شامل للموقع' },
    features: [
      { en: 'Identify technical SEO issues', ar: 'حدد مشاكل SEO التقنية' },
      { en: 'Get actionable recommendations', ar: 'احصل على توصيات قابلة للتنفيذ' },
      { en: 'Monitor website health', ar: 'راقب صحة الموقع' },
      { en: 'Weekly automated audits', ar: 'تدقيقات تلقائية أسبوعية' },
    ],
  },
  {
    id: 'text-optimizer',
    name: { en: 'Text Optimizer', ar: 'محسن النصوص' },
    icon: FileText,
    title: { en: 'Optimize your content for search engines', ar: 'حسّن محتواك لمحركات البحث' },
    features: [
      { en: 'Keyword optimization suggestions', ar: 'اقتراحات تحسين الكلمات المفتاحية' },
      { en: 'Content quality analysis', ar: 'تحليل جودة المحتوى' },
      { en: 'Readability improvements', ar: 'تحسينات سهولة القراءة' },
      { en: 'Competition comparison', ar: 'مقارنة بالمنافسين' },
    ],
  },
  {
    id: 'benchmarking',
    name: { en: 'Benchmarking', ar: 'قياس الأداء' },
    icon: BarChart3,
    title: { en: 'Compare your performance with competitors', ar: 'قارن أداءك مع المنافسين' },
    features: [
      { en: 'Side-by-side competitor analysis', ar: 'تحليل مقارن للمنافسين' },
      { en: 'Visibility comparison', ar: 'مقارنة الظهور' },
      { en: 'Keyword gap analysis', ar: 'تحليل فجوة الكلمات المفتاحية' },
      { en: 'Market position tracking', ar: 'تتبع موقعك في السوق' },
    ],
  },
];

// Target Audiences
const audiences = [
  {
    id: 'freelancers',
    title: { en: 'Freelancers', ar: 'المستقلين' },
    description: {
      en: "XOVI NOW was designed to provide immediate value for your personal website or your clients' sites, from an initial site audit through recommendations to improve your search engine results.",
      ar: 'تم تصميم XOVI NOW لتوفير قيمة فورية لموقعك الشخصي أو مواقع عملائك، من التدقيق الأولي للموقع إلى التوصيات لتحسين نتائج محركات البحث.',
    },
    icon: Users,
  },
  {
    id: 'smb',
    title: { en: 'Small and Medium-sized Businesses', ar: 'الشركات الصغيرة والمتوسطة' },
    description: {
      en: "You don't have to be an SEO expert to improve your business's Google rankings. XOVI NOW will identify the best keywords for your business while also keeping an eye on the performance of your competitors.",
      ar: 'لا تحتاج أن تكون خبيراً في SEO لتحسين ترتيب عملك في Google. سيحدد XOVI NOW أفضل الكلمات المفتاحية لعملك مع مراقبة أداء منافسيك.',
    },
    icon: Briefcase,
  },
];

// FAQs
const faqs = [
  {
    question: { en: 'What is SEO?', ar: 'ما هو SEO؟' },
    answer: {
      en: 'SEO is an acronym for Search Engine Optimization. It is an essential online marketing strategy dedicated to driving prospective customers to your website. Its goal is to optimize a website to gain top positions for selected keywords on search engines.',
      ar: 'SEO هو اختصار لـ Search Engine Optimization (تحسين محركات البحث). وهي استراتيجية تسويق عبر الإنترنت ضرورية لجذب العملاء المحتملين إلى موقعك. هدفها تحسين الموقع للحصول على مراكز متقدمة للكلمات المفتاحية المختارة.',
    },
  },
  {
    question: { en: 'Why Do I Need SEO?', ar: 'لماذا أحتاج SEO؟' },
    answer: {
      en: 'Every day, millions of people use search engines to find information or services. A study shows that 68% of the web\'s traffic comes from search engines. 53% of this traffic has its origins in organic search. If your business is not listed in search results, people will most likely choose your competition.',
      ar: 'يستخدم ملايين الأشخاص محركات البحث يومياً للعثور على معلومات أو خدمات. تظهر دراسة أن 68% من حركة المرور على الويب تأتي من محركات البحث. إذا لم يكن عملك مدرجاً في نتائج البحث، فمن المحتمل أن يختار الناس منافسيك.',
    },
  },
  {
    question: { en: 'What Can SEO Do For Me?', ar: 'ماذا يمكن أن يقدم لي SEO؟' },
    answer: {
      en: 'With the help of SEO, users can find your business, products, and services online—and buy them. SEO maximizes your chances to be listed in top positions for keywords crucial to your business. The better your position, the more people will find their way to your website.',
      ar: 'بمساعدة SEO، يمكن للمستخدمين العثور على عملك ومنتجاتك وخدماتك عبر الإنترنت وشرائها. يزيد SEO فرصك في الظهور في المراكز الأولى للكلمات المفتاحية الحاسمة لعملك.',
    },
  },
  {
    question: { en: 'Why Are Keywords Important?', ar: 'لماذا الكلمات المفتاحية مهمة؟' },
    answer: {
      en: 'Keywords are the terms people type into search engines. Ranking for the right keywords means your website appears when potential customers search for what you offer. Choosing and optimizing for relevant keywords is fundamental to SEO success.',
      ar: 'الكلمات المفتاحية هي المصطلحات التي يكتبها الناس في محركات البحث. الترتيب للكلمات الصحيحة يعني ظهور موقعك عندما يبحث العملاء المحتملون عما تقدمه.',
    },
  },
  {
    question: { en: 'How to use the Advisor?', ar: 'كيف أستخدم المستشار؟' },
    answer: {
      en: "Check out the advisor's board by clicking Advisor in the top navigation bar. It is a Kanban board helping you organize your tasks by status. Tasks are color coded by importance: Red (High), Yellow (Medium), Blue (Low). You can drag and drop as you complete tasks.",
      ar: 'تحقق من لوحة المستشار بالنقر على Advisor في شريط التنقل العلوي. إنها لوحة Kanban تساعدك على تنظيم مهامك حسب الحالة. المهام مرمزة بالألوان حسب الأهمية: أحمر (عالي)، أصفر (متوسط)، أزرق (منخفض).',
    },
  },
];

export default function XoviNowPage() {
  const locale = useLocale();
  const isRTL = locale === 'ar';
  const [expandedFaq, setExpandedFaq] = useState<number | null>(null);
  const [activeFeature, setActiveFeature] = useState('keywords');
  const heroRef = useRef<HTMLDivElement>(null);

  useEffect(() => {
    const ctx = gsap.context(() => {
      gsap.from('.hero-content > *', {
        y: 50,
        opacity: 0,
        duration: 0.8,
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
    }, heroRef);

    return () => ctx.revert();
  }, []);

  const currentFeature = productFeatures.find((f) => f.id === activeFeature);

  // JSON-LD Structured Data
  const baseUrl = process.env.NEXT_PUBLIC_SITE_URL || 'https://progineous.com';
  
  const serviceSchema = {
    '@context': 'https://schema.org',
    '@type': 'SoftwareApplication',
    name: 'XOVI NOW',
    description: isRTL
      ? 'أدوات SEO احترافية لتحليل المواقع وتتبع الترتيب وبحث الكلمات المفتاحية'
      : 'Professional SEO tools for website analysis, rank tracking, and keyword research',
    applicationCategory: 'BusinessApplication',
    operatingSystem: 'Web',
    offers: {
      '@type': 'AggregateOffer',
      lowPrice: '19',
      highPrice: '79',
      priceCurrency: 'USD',
      offerCount: xoviPlans.length,
    },
  };

  const breadcrumbSchema = {
    '@context': 'https://schema.org',
    '@type': 'BreadcrumbList',
    itemListElement: [
      { '@type': 'ListItem', position: 1, name: isRTL ? 'الرئيسية' : 'Home', item: `${baseUrl}/${locale}` },
      { '@type': 'ListItem', position: 2, name: isRTL ? 'السوق' : 'Market', item: `${baseUrl}/${locale}/market` },
      { '@type': 'ListItem', position: 3, name: 'XOVI NOW', item: `${baseUrl}/${locale}/market/xovi-now` },
    ],
  };

  return (
    <div ref={heroRef} className={cn('min-h-screen bg-gray-50', isRTL && 'rtl')}>
      {/* JSON-LD Structured Data */}
      <script type="application/ld+json" dangerouslySetInnerHTML={{ __html: JSON.stringify(serviceSchema) }} />
      <script type="application/ld+json" dangerouslySetInnerHTML={{ __html: JSON.stringify(breadcrumbSchema) }} />

      {/* Hero Section */}
      <section className="relative bg-gradient-to-br from-[#2D3748] via-[#1A202C] to-[#171923] text-white overflow-hidden">
        <div className="absolute inset-0 opacity-20">
          <div
            className="absolute inset-0"
            style={{
              backgroundImage: `url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E")`,
            }}
          />
        </div>

        <div className="container mx-auto px-4 pt-16 pb-32 md:pt-20 md:pb-40 relative z-10">
          <div className="hero-content max-w-6xl mx-auto">
            <div className="flex flex-col lg:flex-row items-center gap-12">
              <div className="flex-1 text-center lg:text-left">
                <img
                  src="https://app.progineous.com/assets/img/marketconnect/xovinow/logo-inverse.png"
                  alt="XOVI NOW"
                  className="h-10 md:h-12 mx-auto lg:mx-0 mb-6"
                />
                <h1 className="text-3xl md:text-4xl lg:text-5xl xl:text-6xl font-bold mb-6">
                  {isRTL ? 'كن مرئياً على الإنترنت مع' : 'Be Found Online With'}
                  <span className="text-[#00D4AA] block mt-2">XOVI NOW</span>
                </h1>
                <p className="text-lg md:text-xl text-white/80 mb-8 max-w-xl">
                  {isRTL
                    ? 'نتائج قابلة للقياس في متناول يدك. دع XOVI NOW يساعد الناس في العثور على ما يجعل شركتك رائعة من خلال عمليات البحث عبر الإنترنت.'
                    : "Measurable Results at Your Fingertips. Let XOVI NOW ensure that people are finding out what makes YOUR company great from their searches online."}
                </p>
                <a
                  href="#pricing"
                  className="inline-flex items-center gap-2 bg-[#00D4AA] text-black px-8 py-4 rounded-xl font-semibold text-lg hover:bg-[#00B894] transition-all duration-300 hover:scale-105 shadow-lg"
                >
                  {isRTL ? 'ابدأ الآن' : 'Get Started'}
                  <ArrowRight className={cn('w-5 h-5', isRTL && 'rotate-180')} />
                </a>
              </div>
              <div className="flex-1">
                <img
                  src="https://app.progineous.com/assets/img/marketconnect/xovinow/screenshots/dashboard.png"
                  alt="XOVI NOW Dashboard"
                  className="w-full max-w-lg mx-auto rounded-xl shadow-2xl"
                />
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

      {/* Product Tour Section */}
      <section className="features-section py-20 bg-gray-50">
        <div className="container mx-auto px-4">
          <div className="text-center mb-16">
            <h2 className="text-3xl md:text-4xl font-bold text-gray-800 mb-4">
              {isRTL ? 'جولة المنتج' : 'Product Tour'}
            </h2>
            <p className="text-lg text-gray-600 max-w-2xl mx-auto">
              {isRTL
                ? 'اكتشف أدوات XOVI NOW القوية لتحسين ظهورك في محركات البحث'
                : 'Discover XOVI NOW\'s powerful tools to improve your search engine visibility'}
            </p>
          </div>

          <div className="max-w-6xl mx-auto">
            {/* Feature Cards Grid */}
            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
              {productFeatures.map((feature) => {
                const Icon = feature.icon;
                const isActive = activeFeature === feature.id;
                return (
                  <button
                    key={feature.id}
                    onClick={() => setActiveFeature(isActive ? '' : feature.id)}
                    className={cn(
                      'feature-card text-left p-6 rounded-2xl transition-all duration-300 border-2',
                      isActive
                        ? 'bg-[#00D4AA] border-[#00D4AA] shadow-xl scale-[1.02]'
                        : 'bg-white border-gray-200 hover:border-[#00D4AA] hover:shadow-lg'
                    )}
                  >
                    <div className={cn(
                      'w-12 h-12 rounded-xl flex items-center justify-center mb-4',
                      isActive ? 'bg-black/10' : 'bg-[#00D4AA]/10'
                    )}>
                      <Icon className={cn('w-6 h-6', isActive ? 'text-black' : 'text-[#00D4AA]')} />
                    </div>
                    <h3 className={cn(
                      'text-lg font-bold mb-2',
                      isActive ? 'text-black' : 'text-gray-800'
                    )}>
                      {isRTL ? feature.name.ar : feature.name.en}
                    </h3>
                    <p className={cn(
                      'text-sm mb-4',
                      isActive ? 'text-black/80' : 'text-gray-600'
                    )}>
                      {isRTL ? feature.title.ar : feature.title.en}
                    </p>
                    
                    {/* Expanded Content */}
                    <div className={cn(
                      'overflow-hidden transition-all duration-300',
                      isActive ? 'max-h-96 opacity-100 mt-4' : 'max-h-0 opacity-0'
                    )}>
                      <div className={cn('border-t pt-4', isActive ? 'border-black/20' : 'border-gray-200')}>
                        <ul className="space-y-2">
                          {feature.features.slice(0, 4).map((feat, index) => (
                            <li key={index} className="flex items-start gap-2">
                              <Check className={cn('w-4 h-4 mt-0.5 flex-shrink-0', isActive ? 'text-black' : 'text-[#00D4AA]')} />
                              <span className={cn('text-sm', isActive ? 'text-black/90' : 'text-gray-700')}>
                                {isRTL ? feat.ar : feat.en}
                              </span>
                            </li>
                          ))}
                        </ul>
                      </div>
                    </div>
                    
                    <div className={cn(
                      'flex items-center gap-1 text-sm font-medium mt-2',
                      isActive ? 'text-black' : 'text-[#00D4AA]'
                    )}>
                      {isActive ? (isRTL ? 'إغلاق' : 'Close') : (isRTL ? 'اعرف المزيد' : 'Learn more')}
                      <ArrowRight className={cn('w-4 h-4 transition-transform', isActive && 'rotate-90', isRTL && !isActive && 'rotate-180')} />
                    </div>
                  </button>
                );
              })}
            </div>
          </div>
        </div>
      </section>

      {/* Target Audiences */}
      <section className="py-20 bg-white">
        <div className="container mx-auto px-4">
          <div className="max-w-5xl mx-auto">
            <div className="grid md:grid-cols-2 gap-8">
              {audiences.map((audience) => {
                const Icon = audience.icon;
                return (
                  <div
                    key={audience.id}
                    className="bg-gray-50 rounded-2xl p-8 border border-gray-200"
                  >
                    <div className="w-14 h-14 bg-[#00D4AA]/10 rounded-xl flex items-center justify-center mb-6">
                      <Icon className="w-7 h-7 text-[#00D4AA]" />
                    </div>
                    <h3 className="text-xl font-bold text-gray-800 mb-4">
                      {isRTL ? audience.title.ar : audience.title.en}
                    </h3>
                    <p className="text-gray-600">
                      {isRTL ? audience.description.ar : audience.description.en}
                    </p>
                  </div>
                );
              })}
            </div>
          </div>
        </div>
      </section>

      {/* Pricing Section */}
      <section id="pricing" className="pricing-section py-20 bg-gray-100">
        <div className="container mx-auto px-4">
          <div className="text-center mb-12">
            <h2 className="text-3xl md:text-4xl font-bold text-gray-800 mb-4">
              {isRTL ? 'خيارات تسعير مرنة' : 'Flexible Pricing Options'}
            </h2>
            <p className="text-lg text-gray-600">
              {isRTL ? 'مع ضمان استرداد الأموال لمدة 30 يوماً' : 'With 30 Day Money Back Guarantee'}
            </p>
          </div>

          <div className="max-w-4xl mx-auto">
            {/* Pricing Cards */}
            <div className="grid md:grid-cols-2 gap-8">
              {xoviPlans.map((plan) => (
                <div
                  key={plan.id}
                  className={cn(
                    'pricing-card bg-white rounded-2xl shadow-xl overflow-hidden',
                    plan.popular && 'ring-2 ring-[#00D4AA]'
                  )}
                >
                  {plan.popular && (
                    <div className="bg-[#00D4AA] text-black text-center py-2 font-semibold text-sm">
                      {isRTL ? 'الأكثر شعبية' : 'Most Popular'}
                    </div>
                  )}
                  <div className="p-8">
                    <div className="flex items-center gap-3 mb-4">
                      <img
                        src="https://app.progineous.com/assets/img/marketconnect/xovinow/logo.png"
                        alt="XOVI NOW"
                        className="h-8"
                      />
                    </div>
                    <h3 className="text-xl font-bold text-gray-800 mb-2">
                      {isRTL ? plan.nameAr : plan.name}
                    </h3>
                    <div className="text-4xl font-bold text-gray-800 mb-6">
                      ${plan.price}
                      <span className="text-lg font-normal text-gray-500">
                        {isRTL ? plan.period.ar : plan.period.en}
                      </span>
                    </div>

                    <div className="space-y-3 mb-8">
                      {featureRows.slice(0, 6).map((row) => {
                        const value = plan.features[row.key as keyof typeof plan.features];
                        return (
                          <div key={row.key} className="flex items-center justify-between text-sm">
                            <span className="text-gray-600">
                              {isRTL ? row.label.ar : row.label.en}
                            </span>
                            <span className="font-semibold text-gray-800">
                              {row.isBoolean ? (
                                value ? <Check className="w-5 h-5 text-[#00D4AA]" /> : '—'
                              ) : (
                                typeof value === 'object' && value !== null
                                  ? (isRTL ? (value as { ar: string }).ar : (value as { en: string }).en)
                                  : String(value)
                              )}
                            </span>
                          </div>
                        );
                      })}
                    </div>

                    <a
                      href={plan.cartLink}
                      className={cn(
                        'block w-full text-center py-4 rounded-xl font-semibold transition-all duration-300 hover:scale-105',
                        plan.popular
                          ? 'bg-[#00D4AA] text-black hover:bg-[#00B894]'
                          : 'bg-gray-800 text-white hover:bg-gray-700'
                      )}
                    >
                      {isRTL ? 'اطلب الآن' : 'Order Now'}
                    </a>
                  </div>
                </div>
              ))}
            </div>

            {/* Full Comparison Table */}
            <div className="mt-12 bg-white rounded-2xl shadow-xl overflow-hidden">
              <div className="p-6 border-b border-gray-200">
                <h3 className="text-xl font-bold text-gray-800">
                  {isRTL ? 'مقارنة كاملة للميزات' : 'Full Feature Comparison'}
                </h3>
              </div>
              <div className="overflow-x-auto">
                <table className="w-full">
                  <thead className="bg-gray-50">
                    <tr>
                      <th className="p-4 text-left font-semibold text-gray-700">
                        {isRTL ? 'الميزة' : 'Feature'}
                      </th>
                      {xoviPlans.map((plan) => (
                        <th key={plan.id} className="p-4 text-center font-semibold text-gray-700">
                          {plan.name.split(' ').pop()}
                        </th>
                      ))}
                    </tr>
                  </thead>
                  <tbody>
                    {featureRows.map((row, index) => (
                      <tr key={row.key} className={index % 2 === 0 ? 'bg-white' : 'bg-gray-50/50'}>
                        <td className="p-4 text-gray-700">
                          {isRTL ? row.label.ar : row.label.en}
                        </td>
                        {xoviPlans.map((plan) => {
                          const value = plan.features[row.key as keyof typeof plan.features];
                          return (
                            <td key={plan.id} className="p-4 text-center">
                              {row.isBoolean ? (
                                value ? (
                                  <Check className="w-5 h-5 text-[#00D4AA] mx-auto" />
                                ) : (
                                  <span className="text-gray-300">—</span>
                                )
                              ) : (
                                <span className="text-gray-800 font-medium">
                                  {typeof value === 'object' && value !== null
                                    ? (isRTL ? (value as { ar: string }).ar : (value as { en: string }).en)
                                    : String(value)}
                                </span>
                              )}
                            </td>
                          );
                        })}
                      </tr>
                    ))}
                  </tbody>
                </table>
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
      <section className="py-20 bg-gradient-to-r from-[#2D3748] to-[#1A202C]">
        <div className="container mx-auto px-4 text-center">
          <h2 className="text-3xl md:text-4xl font-bold text-white mb-6">
            {isRTL ? 'ابدأ في تحسين ترتيبك اليوم' : 'Start Improving Your Rankings Today'}
          </h2>
          <p className="text-xl text-white/80 mb-8 max-w-2xl mx-auto">
            {isRTL
              ? 'احصل على أدوات SEO احترافية لتحسين ظهور موقعك في محركات البحث'
              : 'Get professional SEO tools to improve your website\'s search engine visibility'}
          </p>
          <a
            href="#pricing"
            className="inline-flex items-center gap-2 bg-[#00D4AA] text-black px-8 py-4 rounded-xl font-semibold text-lg hover:bg-[#00B894] transition-all duration-300 hover:scale-105 shadow-lg"
          >
            {isRTL ? 'اختر خطتك' : 'Choose Your Plan'}
            <ArrowRight className={cn('w-5 h-5', isRTL && 'rotate-180')} />
          </a>
        </div>
      </section>
    </div>
  );
}
