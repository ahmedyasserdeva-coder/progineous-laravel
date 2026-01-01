'use client';

import { useState, useEffect, useRef } from 'react';
import { useLocale } from 'next-intl';
import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import {
  Check,
  X,
  ChevronDown,
  ChevronUp,
  ArrowRight,
  Calendar,
  MessageSquare,
  Users,
  BarChart3,
  Sparkles,
  FolderOpen,
  Clock,
  RefreshCw,
  Inbox,
  UserPlus,
} from 'lucide-react';
import { cn } from '@/lib/utils';

// Register GSAP plugins
if (typeof window !== 'undefined') {
  gsap.registerPlugin(ScrollTrigger);
}

// SocialBee Plans
const socialBeePlans = [
  {
    id: 'bootstrap',
    name: 'Bootstrap',
    nameAr: 'بوتستراب',
    price: 29,
    period: { en: '/mo', ar: '/شهر' },
    popular: false,
    features: {
      socialAccounts: 5,
      aiContent: true,
      categories: 10,
      postsPerCategory: 100,
      rssFeeds: 10,
      postDrafts: true,
      scheduling: true,
      universalPosting: true,
      bestTime: true,
      resharing: true,
      curation: true,
      analytics: true,
      brandedReports: false,
      historicalData: { en: 'Up to 3 Months', ar: 'حتى 3 أشهر' },
    },
    cartLink: 'https://app.progineous.com/cart.php?a=add&pid=292',
  },
  {
    id: 'accelerate',
    name: 'Accelerate',
    nameAr: 'أكسيليريت',
    price: 49,
    period: { en: '/mo', ar: '/شهر' },
    popular: false,
    features: {
      socialAccounts: 10,
      aiContent: true,
      categories: 50,
      postsPerCategory: 5000,
      rssFeeds: 30,
      postDrafts: true,
      scheduling: true,
      universalPosting: true,
      bestTime: true,
      resharing: true,
      curation: true,
      analytics: true,
      brandedReports: false,
      historicalData: { en: 'Up to 2 Years', ar: 'حتى سنتين' },
    },
    cartLink: 'https://app.progineous.com/cart.php?a=add&pid=293',
  },
  {
    id: 'pro',
    name: 'Pro',
    nameAr: 'برو',
    price: 99,
    period: { en: '/mo', ar: '/شهر' },
    popular: true,
    features: {
      socialAccounts: 25,
      aiContent: true,
      categories: { en: 'Unlimited', ar: 'غير محدود' },
      postsPerCategory: 5000,
      rssFeeds: { en: 'Unlimited', ar: 'غير محدود' },
      postDrafts: true,
      scheduling: true,
      universalPosting: true,
      bestTime: true,
      resharing: true,
      curation: true,
      analytics: true,
      brandedReports: true,
      historicalData: { en: 'Up to 2 Years', ar: 'حتى سنتين' },
    },
    cartLink: 'https://app.progineous.com/cart.php?a=add&pid=294',
  },
  {
    id: 'pro50',
    name: 'Pro50',
    nameAr: 'برو50',
    price: 179,
    period: { en: '/mo', ar: '/شهر' },
    popular: false,
    features: {
      socialAccounts: 50,
      aiContent: true,
      categories: { en: 'Unlimited', ar: 'غير محدود' },
      postsPerCategory: 5000,
      rssFeeds: { en: 'Unlimited', ar: 'غير محدود' },
      postDrafts: true,
      scheduling: true,
      universalPosting: true,
      bestTime: true,
      resharing: true,
      curation: true,
      analytics: true,
      brandedReports: true,
      historicalData: { en: 'Up to 2 Years', ar: 'حتى سنتين' },
    },
    cartLink: 'https://app.progineous.com/cart.php?a=add&pid=295',
  },
  {
    id: 'pro100',
    name: 'Pro100',
    nameAr: 'برو100',
    price: 329,
    period: { en: '/mo', ar: '/شهر' },
    popular: false,
    features: {
      socialAccounts: 100,
      aiContent: true,
      categories: { en: 'Unlimited', ar: 'غير محدود' },
      postsPerCategory: 5000,
      rssFeeds: { en: 'Unlimited', ar: 'غير محدود' },
      postDrafts: true,
      scheduling: true,
      universalPosting: true,
      bestTime: true,
      resharing: true,
      curation: true,
      analytics: true,
      brandedReports: true,
      historicalData: { en: 'Up to 2 Years', ar: 'حتى سنتين' },
    },
    cartLink: 'https://app.progineous.com/cart.php?a=add&pid=296',
  },
  {
    id: 'pro150',
    name: 'Pro150',
    nameAr: 'برو150',
    price: 449,
    period: { en: '/mo', ar: '/شهر' },
    popular: false,
    features: {
      socialAccounts: 150,
      aiContent: true,
      categories: { en: 'Unlimited', ar: 'غير محدود' },
      postsPerCategory: 5000,
      rssFeeds: { en: 'Unlimited', ar: 'غير محدود' },
      postDrafts: true,
      scheduling: true,
      universalPosting: true,
      bestTime: true,
      resharing: true,
      curation: true,
      analytics: true,
      brandedReports: true,
      historicalData: { en: 'Up to 2 Years', ar: 'حتى سنتين' },
    },
    cartLink: 'https://app.progineous.com/cart.php?a=add&pid=297',
  },
];

// Feature rows for comparison
const featureRows = [
  { key: 'socialAccounts', label: { en: 'Social Media Accounts', ar: 'حسابات التواصل الاجتماعي' }, isBoolean: false },
  { key: 'aiContent', label: { en: 'AI Content Creation', ar: 'إنشاء المحتوى بالذكاء الاصطناعي' }, isBoolean: true },
  { key: 'categories', label: { en: 'Content Categories (Folders)', ar: 'فئات المحتوى (المجلدات)' }, isBoolean: false },
  { key: 'postsPerCategory', label: { en: 'Posts per Category', ar: 'المنشورات لكل فئة' }, isBoolean: false },
  { key: 'rssFeeds', label: { en: 'Import RSS Feeds', ar: 'استيراد خلاصات RSS' }, isBoolean: false },
  { key: 'postDrafts', label: { en: 'Post Drafts', ar: 'مسودات المنشورات' }, isBoolean: true },
  { key: 'scheduling', label: { en: 'Content Scheduling and Publishing', ar: 'جدولة ونشر المحتوى' }, isBoolean: true },
  { key: 'universalPosting', label: { en: 'Universal Posting', ar: 'النشر الشامل' }, isBoolean: true },
  { key: 'bestTime', label: { en: 'Best Posting Time Suggestions', ar: 'اقتراحات أفضل وقت للنشر' }, isBoolean: true },
  { key: 'resharing', label: { en: 'Content Resharing', ar: 'إعادة مشاركة المحتوى' }, isBoolean: true },
  { key: 'curation', label: { en: 'Content Curation', ar: 'تنسيق المحتوى' }, isBoolean: true },
  { key: 'analytics', label: { en: 'Social Media Analytics', ar: 'تحليلات التواصل الاجتماعي' }, isBoolean: true },
  { key: 'brandedReports', label: { en: 'Export Branded Reports', ar: 'تصدير التقارير المُعلَّمة' }, isBoolean: true },
  { key: 'historicalData', label: { en: 'Historical Data Access', ar: 'الوصول للبيانات التاريخية' }, isBoolean: false },
];

// Features tabs
const featureTabs = [
  {
    id: 'create',
    name: { en: 'Create', ar: 'إنشاء' },
    icon: Sparkles,
    features: [
      { en: 'SocialBee integrates with Canva, Unsplash, and GIPHY, so you can easily create and curate visuals for your posts.', ar: 'يتكامل SocialBee مع Canva و Unsplash و GIPHY، لإنشاء وتنسيق صور منشوراتك بسهولة.' },
      { en: 'Generate captions and images in seconds with AI, and get access to over 1,000 premade prompts to save time.', ar: 'أنشئ تعليقات وصور في ثوانٍ بالذكاء الاصطناعي، واحصل على أكثر من 1000 قالب جاهز لتوفير الوقت.' },
      { en: 'Tailor posts automatically with AI or manually for each platform to make sure your content works best wherever it\'s shared.', ar: 'خصص المنشورات تلقائياً بالذكاء الاصطناعي أو يدوياً لكل منصة لضمان أفضل أداء للمحتوى.' },
      { en: 'Let Copilot, SocialBee\'s AI assistant, create a personalized content plan for you in minutes.', ar: 'دع Copilot، مساعد SocialBee الذكي، ينشئ خطة محتوى مخصصة لك في دقائق.' },
      { en: 'Organize posts in folders by topic, keeping your content plan diverse and well-structured.', ar: 'نظم منشوراتك في مجلدات حسب الموضوع للحفاظ على تنوع وهيكلة خطة المحتوى.' },
      { en: 'Experiment with different post types like images, videos, carousels, stories, and Reels.', ar: 'جرب أنواع منشورات مختلفة كالصور والفيديوهات والـ carousels والـ Stories والـ Reels.' },
    ],
    image: 'https://app.progineous.com/assets/img/marketconnect/socialbee/visuals.png',
  },
  {
    id: 'schedule',
    name: { en: 'Schedule', ar: 'جدولة' },
    icon: Calendar,
    features: [
      { en: 'Manage all your content from a single weekly calendar view.', ar: 'أدر كل محتواك من عرض تقويم أسبوعي واحد.' },
      { en: 'Schedule posts based on your audience\'s behavior using best-time suggestions.', ar: 'جدول منشوراتك بناءً على سلوك جمهورك باستخدام اقتراحات أفضل الأوقات.' },
      { en: 'Set posting times for each social account and let SocialBee handle the rest.', ar: 'حدد أوقات النشر لكل حساب ودع SocialBee يتولى الباقي.' },
      { en: 'Reuse your best content to boost reach and engagement.', ar: 'أعد استخدام أفضل محتواك لزيادة الوصول والتفاعل.' },
    ],
    image: 'https://app.progineous.com/assets/img/marketconnect/socialbee/schedule.png',
  },
  {
    id: 'engage',
    name: { en: 'Engage', ar: 'تفاعل' },
    icon: MessageSquare,
    features: [
      { en: 'Manage comments, mentions, and messages from a single inbox for all your accounts.', ar: 'أدر التعليقات والإشارات والرسائل من صندوق وارد واحد لجميع حساباتك.' },
      { en: 'Get real-time notifications for interactions.', ar: 'احصل على إشعارات فورية للتفاعلات.' },
      { en: 'Use quick responses to reply faster.', ar: 'استخدم الردود السريعة للرد بشكل أسرع.' },
      { en: 'Tag and filter messages for better organization.', ar: 'وسّم وفلتر الرسائل لتنظيم أفضل.' },
    ],
    image: 'https://app.progineous.com/assets/img/marketconnect/socialbee/inbox.png',
  },
  {
    id: 'collaborate',
    name: { en: 'Collaborate', ar: 'تعاون' },
    icon: Users,
    features: [
      { en: 'Set up approval workflows to maintain content quality.', ar: 'أنشئ سير عمل للموافقات للحفاظ على جودة المحتوى.' },
      { en: 'Assign roles and manage access for team members.', ar: 'عيّن الأدوار وأدر صلاحيات أعضاء الفريق.' },
      { en: 'Avoid duplicates with easy-to-see drafts.', ar: 'تجنب التكرار مع مسودات سهلة العرض.' },
      { en: 'Manage multiple clients with separate workspaces.', ar: 'أدر عملاء متعددين بمساحات عمل منفصلة.' },
    ],
    image: 'https://app.progineous.com/assets/img/marketconnect/socialbee/approve.png',
  },
  {
    id: 'analyze',
    name: { en: 'Analyze', ar: 'تحليل' },
    icon: BarChart3,
    features: [
      { en: 'Track performance metrics for all your accounts.', ar: 'تتبع مقاييس الأداء لجميع حساباتك.' },
      { en: 'Compare your performance with competitors.', ar: 'قارن أداءك مع المنافسين.' },
      { en: 'Filter data by date range and platform.', ar: 'فلتر البيانات حسب الفترة والمنصة.' },
      { en: 'Export branded reports for clients.', ar: 'صدّر تقارير مُعلَّمة للعملاء.' },
    ],
    image: 'https://app.progineous.com/assets/img/marketconnect/socialbee/statistics.png',
  },
];

// FAQs
const faqs = [
  {
    question: { en: 'Which social media platforms can I manage with SocialBee?', ar: 'ما هي منصات التواصل الاجتماعي التي يمكنني إدارتها مع SocialBee؟' },
    answer: {
      en: 'You can manage and schedule content for popular platforms like Facebook, Instagram, Threads, X™ (formerly Twitter™), LinkedIn, Pinterest, Google Business Profile™, TikTok, YouTube™, and Bluesky.',
      ar: 'يمكنك إدارة وجدولة المحتوى لمنصات شهيرة مثل Facebook و Instagram و Threads و X™ (تويتر سابقاً) و LinkedIn و Pinterest و Google Business Profile™ و TikTok و YouTube™ و Bluesky.',
    },
  },
  {
    question: { en: 'Why should I choose SocialBee over other tools?', ar: 'لماذا يجب أن أختار SocialBee على الأدوات الأخرى؟' },
    answer: {
      en: 'SocialBee is an all-in-one social media management tool that handles everything from content creation, scheduling, and sharing to analytics, social inbox, and team collaboration. We offer support through calls, chat, or email, monthly live demos, detailed documentation, short tutorials, and many other resources.',
      ar: 'SocialBee هو أداة شاملة لإدارة التواصل الاجتماعي تتولى كل شيء من إنشاء المحتوى والجدولة والمشاركة إلى التحليلات وصندوق الوارد والتعاون الجماعي. نقدم الدعم عبر المكالمات والدردشة والبريد الإلكتروني، وعروض توضيحية شهرية، ووثائق مفصلة، ودروس قصيرة، والعديد من الموارد الأخرى.',
    },
  },
  {
    question: { en: 'What support options are available for SocialBee users?', ar: 'ما خيارات الدعم المتاحة لمستخدمي SocialBee؟' },
    answer: {
      en: 'Users can get help from SocialBee through chat, email, calls and a rich knowledge base full of helpful resources.',
      ar: 'يمكن للمستخدمين الحصول على المساعدة من SocialBee عبر الدردشة والبريد الإلكتروني والمكالمات وقاعدة معرفة غنية بالموارد المفيدة.',
    },
  },
  {
    question: { en: 'Are SocialBee\'s agency plans different from the regular Pro plan?', ar: 'هل خطط وكالات SocialBee مختلفة عن خطة Pro العادية؟' },
    answer: {
      en: 'The agency plans (Pro50, Pro100, and Pro150) have the same features as the Pro plan. The main differences are the number of social media profiles that you can connect, the number of workspaces, and the users you can add to a workspace.',
      ar: 'خطط الوكالات (Pro50 و Pro100 و Pro150) لها نفس ميزات خطة Pro. الاختلافات الرئيسية هي عدد حسابات التواصل الاجتماعي التي يمكنك ربطها، وعدد مساحات العمل، والمستخدمين الذين يمكنك إضافتهم لمساحة العمل.',
    },
  },
  {
    question: { en: 'Where are SocialBee\'s servers located?', ar: 'أين تقع خوادم SocialBee؟' },
    answer: {
      en: 'SocialBee\'s servers are located in Ireland, Europe.',
      ar: 'تقع خوادم SocialBee في أيرلندا، أوروبا.',
    },
  },
];

export default function SocialBeePage() {
  const locale = useLocale();
  const isRTL = locale === 'ar';
  const [expandedFaq, setExpandedFaq] = useState<number | null>(null);
  const [activeTab, setActiveTab] = useState('create');
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

      gsap.from('.feature-tab', {
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
        stagger: 0.1,
        ease: 'power3.out',
      });
    }, heroRef);

    return () => ctx.revert();
  }, []);

  const activeFeature = featureTabs.find((tab) => tab.id === activeTab);

  // JSON-LD Structured Data
  const baseUrl = process.env.NEXT_PUBLIC_SITE_URL || 'https://progineous.com';
  
  const serviceSchema = {
    '@context': 'https://schema.org',
    '@type': 'SoftwareApplication',
    name: 'SocialBee',
    description: isRTL
      ? 'أداة إدارة وجدولة منشورات السوشيال ميديا مع الذكاء الاصطناعي'
      : 'Social media management and scheduling tool with AI capabilities',
    applicationCategory: 'BusinessApplication',
    operatingSystem: 'Web',
    offers: {
      '@type': 'AggregateOffer',
      lowPrice: '29',
      highPrice: '329',
      priceCurrency: 'USD',
      offerCount: socialBeePlans.length,
    },
  };

  const breadcrumbSchema = {
    '@context': 'https://schema.org',
    '@type': 'BreadcrumbList',
    itemListElement: [
      { '@type': 'ListItem', position: 1, name: isRTL ? 'الرئيسية' : 'Home', item: `${baseUrl}/${locale}` },
      { '@type': 'ListItem', position: 2, name: isRTL ? 'السوق' : 'Market', item: `${baseUrl}/${locale}/market` },
      { '@type': 'ListItem', position: 3, name: 'SocialBee', item: `${baseUrl}/${locale}/market/socialbee` },
    ],
  };

  return (
    <div ref={heroRef} className={cn('min-h-screen bg-gray-50', isRTL && 'rtl')}>
      {/* JSON-LD Structured Data */}
      <script type="application/ld+json" dangerouslySetInnerHTML={{ __html: JSON.stringify(serviceSchema) }} />
      <script type="application/ld+json" dangerouslySetInnerHTML={{ __html: JSON.stringify(breadcrumbSchema) }} />

      {/* Hero Section */}
      <section className="relative bg-gradient-to-br from-[#F5B800] via-[#E5A800] to-[#D49B00] text-black overflow-hidden">
        <div className="absolute inset-0 opacity-10">
          <div
            className="absolute inset-0"
            style={{
              backgroundImage: `url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.4'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E")`,
            }}
          />
        </div>

        <div className="container mx-auto px-4 pt-16 pb-32 md:pt-20 md:pb-40 lg:pt-24 lg:pb-48 relative z-10">
          <div className="hero-content max-w-5xl lg:max-w-6xl xl:max-w-7xl mx-auto">
            <div className="flex flex-col md:flex-row items-center gap-12 lg:gap-16 xl:gap-20">
              <div className="flex-1 text-center md:text-left">
                <img
                  src="/images/socialbeewp.png"
                  alt="SocialBee"
                  className="h-12 md:h-16 lg:h-20 mx-auto md:mx-0 mb-6"
                />
                <h1 className="text-3xl md:text-4xl lg:text-5xl xl:text-6xl font-bold mb-6">
                  {isRTL
                    ? 'SocialBee، أسهل طريقة لإدارة جميع حسابات التواصل الاجتماعي'
                    : 'SocialBee, the easiest way to manage all of your social media accounts'}
                </h1>
                <p className="text-lg md:text-xl lg:text-2xl text-black/80 mb-8">
                  {isRTL
                    ? 'أنشئ، جدول، انشر، حلل، تفاعل، وتعاون دون إضاعة ثانية من وقتك.'
                    : 'Create, schedule, publish, analyze, engage, and collaborate without wasting a second of your time.'}
                </p>
                <a
                  href="#pricing"
                  className="inline-flex items-center gap-2 bg-black text-white px-8 py-4 lg:px-10 lg:py-5 rounded-xl font-semibold text-lg lg:text-xl hover:bg-gray-900 transition-all duration-300 hover:scale-105 shadow-lg"
                >
                  {isRTL ? 'عرض الأسعار والباقات' : 'View Pricing and Packages'}
                  <ArrowRight className={cn('w-5 h-5 lg:w-6 lg:h-6', isRTL && 'rotate-180')} />
                </a>
              </div>
              <div className="flex-1">
                <img
                  src="https://app.progineous.com/assets/img/marketconnect/socialbee/planner.png"
                  alt="SocialBee Planner"
                  className="w-full max-w-lg lg:max-w-xl xl:max-w-2xl mx-auto"
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

      {/* Handle All Tasks Section */}
      <section className="py-20 bg-gray-50">
        <div className="container mx-auto px-4">
          <div className="max-w-4xl mx-auto text-center mb-12">
            <h2 className="text-3xl md:text-4xl font-bold text-gray-800 mb-6">
              {isRTL
                ? 'أدر جميع مهام التواصل الاجتماعي من مكان واحد.'
                : 'Handle all of your social media tasks from one place.'}
            </h2>
            <p className="text-lg text-gray-600">
              {isRTL
                ? 'إذا كنت تدير حساباتك على التواصل الاجتماعي يدوياً، فأنت على الأرجح تقضي ساعات في التنقل بين منصات وعلامات تبويب متعددة. SocialBee يجعل الأمر أسهل من خلال السماح لك بإنشاء وجدولة المنشورات مسبقاً.'
                : "If you're manually managing your social media accounts, you're probably spending hours juggling multiple platforms and tabs. SocialBee makes it easier by letting you create and schedule posts in advance."}
            </p>
          </div>

          <div className="max-w-6xl mx-auto">
            <img
              src="https://app.progineous.com/assets/img/marketconnect/socialbee/SocialBeeFeatures.png"
              alt="SocialBee Features"
              className="w-full"
            />
          </div>
        </div>
      </section>

      {/* Features Tabs Section */}
      <section className="features-section py-20 bg-gray-100">
        <div className="container mx-auto px-4">
          <div className="max-w-6xl mx-auto">
            {/* Section Title */}
            <h2 className="text-3xl md:text-4xl font-bold text-center text-gray-800 mb-12">
              {isRTL ? 'ميزات SocialBee' : 'SocialBee Features'}
            </h2>

            {/* Tabs */}
            <div className="bg-white rounded-2xl shadow-lg p-2 mb-12">
              <div className="flex flex-wrap justify-center gap-2">
                {featureTabs.map((tab) => {
                  const Icon = tab.icon;
                  return (
                    <button
                      key={tab.id}
                      onClick={() => setActiveTab(tab.id)}
                      className={cn(
                        'feature-tab flex items-center gap-2 px-5 py-3 rounded-xl font-semibold transition-all duration-300',
                        activeTab === tab.id
                          ? 'bg-[#F5B800] text-black shadow-md'
                          : 'bg-transparent text-gray-600 hover:bg-gray-100 hover:text-gray-900'
                      )}
                    >
                      <Icon className={cn('w-5 h-5', activeTab === tab.id ? 'text-black' : 'text-gray-500')} />
                      {isRTL ? tab.name.ar : tab.name.en}
                    </button>
                  );
                })}
              </div>
            </div>

            {/* Active Tab Content */}
            {activeFeature && (
              <div className="bg-white rounded-2xl shadow-lg p-8 md:p-12">
                <div className="flex flex-col md:flex-row items-center gap-12">
                  <div className="flex-1">
                    <h3 className="text-2xl font-bold text-gray-800 mb-6">
                      {isRTL ? activeFeature.name.ar : activeFeature.name.en}
                    </h3>
                    <ul className="space-y-4">
                      {activeFeature.features.map((feature, index) => (
                        <li key={index} className="flex items-start gap-3">
                          <div className="w-6 h-6 bg-[#F5B800] rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                            <Check className="w-4 h-4 text-black" />
                          </div>
                          <span className="text-gray-700">
                            {isRTL ? feature.ar : feature.en}
                          </span>
                        </li>
                      ))}
                    </ul>
                  </div>
                  <div className="flex-1 flex items-center justify-center">
                    <img
                      src={activeFeature.image}
                      alt={isRTL ? activeFeature.name.ar : activeFeature.name.en}
                      className="w-48 h-48 md:w-64 md:h-64 object-contain"
                    />
                  </div>
                </div>
              </div>
            )}
          </div>
        </div>
      </section>

      {/* Pricing Section */}
      <section id="pricing" className="pricing-section py-20 bg-gray-50">
        <div className="container mx-auto px-4">
          <div className="text-center mb-12">
            <h2 className="text-3xl md:text-4xl font-bold text-gray-800 mb-4">
              {isRTL ? 'جرب SocialBee وابدأ النمو على التواصل الاجتماعي.' : 'Try SocialBee and start growing on social media.'}
            </h2>
          </div>

          <div className="max-w-7xl mx-auto overflow-x-auto">
            <div className="min-w-[900px]">
              {/* Comparison Table */}
              <div className="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-200">
                {/* Table Header */}
                <div className="grid grid-cols-7 bg-gray-50 border-b border-gray-200">
                  <div className="p-4 font-semibold text-gray-700">
                    {isRTL ? 'الميزات' : 'Features'}
                  </div>
                  {socialBeePlans.map((plan) => (
                    <div
                      key={plan.id}
                      className={cn(
                        'pricing-card p-4 text-center',
                        plan.popular && 'bg-[#F5B800] text-black'
                      )}
                    >
                      <h3 className="text-lg font-bold mb-1">
                        {isRTL ? plan.nameAr : plan.name}
                      </h3>
                      <div className="text-2xl font-bold">
                        ${plan.price}
                        <span className="text-sm font-normal">
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
                      'grid grid-cols-7 border-b border-gray-100',
                      index % 2 === 0 ? 'bg-white' : 'bg-gray-50/50'
                    )}
                  >
                    <div className="p-3 text-sm font-medium text-gray-700 flex items-center">
                      {isRTL ? row.label.ar : row.label.en}
                    </div>
                    {socialBeePlans.map((plan) => {
                      const value = plan.features[row.key as keyof typeof plan.features];
                      return (
                        <div
                          key={plan.id}
                          className={cn(
                            'p-3 text-center flex items-center justify-center text-sm',
                            plan.popular && 'bg-[#F5B800]/10'
                          )}
                        >
                          {row.isBoolean ? (
                            value ? (
                              <Check className="w-5 h-5 text-green-500" />
                            ) : (
                              <X className="w-5 h-5 text-red-400" />
                            )
                          ) : (
                            <span className={cn(plan.popular ? 'text-[#D49B00] font-semibold' : 'text-gray-600')}>
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
                <div className="grid grid-cols-7 bg-gray-50">
                  <div className="p-4"></div>
                  {socialBeePlans.map((plan) => (
                    <div key={plan.id} className={cn('p-4 text-center', plan.popular && 'bg-[#F5B800]/10')}>
                      <a
                        href={plan.cartLink}
                        className={cn(
                          'inline-flex items-center justify-center gap-1 px-4 py-2 rounded-lg font-semibold text-sm transition-all duration-300 hover:scale-105',
                          plan.popular
                            ? 'bg-[#F5B800] text-black hover:bg-[#E5A800] shadow-lg'
                            : 'bg-black text-white hover:bg-gray-800'
                        )}
                      >
                        {isRTL ? 'ابدأ الآن' : 'Get Started'}
                        <ArrowRight className={cn('w-4 h-4', isRTL && 'rotate-180')} />
                      </a>
                    </div>
                  ))}
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
            <h2 className="text-3xl md:text-4xl font-bold text-center text-gray-800 mb-4">
              {isRTL ? 'الأسئلة الشائعة' : 'Frequently Asked Questions'}
            </h2>
            <p className="text-center text-gray-600 mb-12">
              {isRTL ? 'هل لديك المزيد من الأسئلة؟' : 'Do you have more questions?'}
            </p>

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
      <section className="py-20 bg-gradient-to-r from-[#F5B800] to-[#FFD000]">
        <div className="container mx-auto px-4 text-center">
          <h2 className="text-3xl md:text-4xl font-bold text-black mb-6">
            {isRTL ? 'ابدأ في تنمية حضورك على التواصل الاجتماعي اليوم' : 'Start Growing Your Social Media Presence Today'}
          </h2>
          <p className="text-xl text-black/80 mb-8 max-w-2xl mx-auto">
            {isRTL
              ? 'وفّر الوقت وزد التفاعل مع أداة إدارة التواصل الاجتماعي الشاملة'
              : 'Save time and boost engagement with the all-in-one social media management tool'}
          </p>
          <a
            href="#pricing"
            className="inline-flex items-center gap-2 bg-black text-white px-8 py-4 rounded-xl font-semibold text-lg hover:bg-gray-900 transition-all duration-300 hover:scale-105 shadow-lg"
          >
            {isRTL ? 'اختر خطتك' : 'Choose Your Plan'}
            <ArrowRight className={cn('w-5 h-5', isRTL && 'rotate-180')} />
          </a>
        </div>
      </section>
    </div>
  );
}
