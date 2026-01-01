'use client';

import { useState, useEffect } from 'react';
import { useLocale } from 'next-intl';
import { Link } from '@/i18n/routing';
import { 
  Check, 
  Shield, 
  Zap, 
  Globe, 
  HardDrive,
  Headphones,
  ArrowRight,
  Star,
  ChevronDown,
  Users,
  Palette,
  Settings,
  Rocket,
  TrendingUp,
  Sparkles,
  Package,
  Monitor,
  Wifi,
  Database
} from 'lucide-react';
import { cn } from '@/lib/utils';

export default function ResellerHostingPage() {
  const locale = useLocale();
  const [billingPeriod, setBillingPeriod] = useState<'monthly' | 'yearly'>('monthly');
  const [openFaq, setOpenFaq] = useState<number | null>(null);
  const [activeStep, setActiveStep] = useState(0);
  const [hoveredPlan, setHoveredPlan] = useState<number>(1);

  useEffect(() => {
    const interval = setInterval(() => {
      setActiveStep((prev) => (prev + 1) % 4);
    }, 3000);
    return () => clearInterval(interval);
  }, []);

  const plans = [
    {
      name: 'Go Reseller',
      tagline: locale === 'ar' ? 'للمبتدئين' : 'Starter',
      monthlyPrice: 20.00,
      yearlyPrice: 17.00,
      accounts: 20,
      storage: '20 GB',
      storageType: 'NVMe SSD',
      color: 'from-sky-500 to-blue-600',
      bgColor: 'bg-sky-50',
      borderColor: 'border-sky-200',
      shadowColor: 'shadow-sky-500/20',
      accentColor: 'text-sky-600',
      iconBg: 'bg-sky-100',
      features: [
        'LiteSpeed Webserver',
        locale === 'ar' ? '20 حساب cPanel' : '20 cPanel Accounts',
        'Cloudflare CDN',
        locale === 'ar' ? 'علامة بيضاء كاملة' : 'Fully Whitelabel',
        'CloudLinux OS',
        'Imunify360',
        locale === 'ar' ? 'شهادات SSL تلقائية' : 'Auto SSL',
      ],
      popular: false,
      baseLink: 'https://app.progineous.com/store/reseller-hosting/re-103'
    },
    {
      name: 'Prof Reseller',
      tagline: locale === 'ar' ? 'الأكثر مبيعاً' : 'Most Popular',
      monthlyPrice: 50.00,
      yearlyPrice: 42.00,
      accounts: 50,
      storage: '650 GB',
      storageType: 'NVMe SSD',
      color: 'from-[#1d71b8] to-blue-600',
      bgColor: 'bg-[#1d71b8]/5',
      borderColor: 'border-[#1d71b8]/30',
      shadowColor: 'shadow-[#1d71b8]/30',
      accentColor: 'text-[#1d71b8]',
      iconBg: 'bg-[#1d71b8]/10',
      features: [
        'LiteSpeed Webserver',
        locale === 'ar' ? '50 حساب cPanel' : '50 cPanel Accounts',
        'Cloudflare CDN',
        locale === 'ar' ? 'علامة بيضاء كاملة' : 'Fully Whitelabel',
        'CloudLinux OS',
        'Imunify360',
        locale === 'ar' ? 'شهادات SSL تلقائية' : 'Auto SSL',
        locale === 'ar' ? 'نسخ احتياطية خارجية' : 'Offsite Backups',
      ],
      popular: true,
      baseLink: 'https://app.progineous.com/store/reseller-hosting/re-102'
    },
    {
      name: 'Premium Reseller',
      tagline: locale === 'ar' ? 'للمحترفين' : 'Professional',
      monthlyPrice: 160.00,
      yearlyPrice: 136.00,
      accounts: 100,
      storage: '3 TB',
      storageType: 'NVMe SSD',
      color: 'from-amber-500 to-orange-600',
      bgColor: 'bg-amber-50',
      borderColor: 'border-amber-200',
      shadowColor: 'shadow-amber-500/20',
      accentColor: 'text-amber-600',
      iconBg: 'bg-amber-100',
      features: [
        'LiteSpeed Webserver',
        locale === 'ar' ? '100 حساب cPanel' : '100 cPanel Accounts',
        'Cloudflare CDN',
        locale === 'ar' ? 'علامة بيضاء كاملة' : 'Fully Whitelabel',
        'CloudLinux OS',
        'Imunify360',
        locale === 'ar' ? 'شهادات SSL تلقائية' : 'Auto SSL',
        locale === 'ar' ? '4 جيجا رام لكل حساب' : '4GB RAM per Account',
        locale === 'ar' ? 'أولوية الدعم' : 'Priority Support',
      ],
      popular: false,
      baseLink: 'https://app.progineous.com/store/reseller-hosting/re-101'
    }
  ];

  const getPlanLink = (baseLink: string) => {
    const billingCycle = billingPeriod === 'yearly' ? 'annually' : 'monthly';
    return `${baseLink}?billingcycle=${billingCycle}`;
  };

  const steps = [
    {
      icon: Package,
      title: locale === 'ar' ? 'اختر باقتك' : 'Choose Your Plan',
      description: locale === 'ar' ? 'اختر الباقة المناسبة' : 'Select the plan for your needs'
    },
    {
      icon: Palette,
      title: locale === 'ar' ? 'أضف علامتك' : 'Add Your Brand',
      description: locale === 'ar' ? 'خصص الألوان والشعار' : 'Customize colors and logo'
    },
    {
      icon: Users,
      title: locale === 'ar' ? 'أنشئ الحسابات' : 'Create Accounts',
      description: locale === 'ar' ? 'أنشئ حسابات عملائك' : 'Create your client accounts'
    },
    {
      icon: TrendingUp,
      title: locale === 'ar' ? 'احصد الأرباح' : 'Harvest Profits',
      description: locale === 'ar' ? 'حدد أسعارك واربح' : 'Set prices and profit'
    }
  ];

  const faqs = [
    {
      question: locale === 'ar' ? 'ما هي استضافة الموزعين؟' : 'What is Reseller Hosting?',
      answer: locale === 'ar' 
        ? 'استضافة الموزعين تتيح لك شراء موارد استضافة بالجملة وإعادة بيعها لعملائك تحت علامتك التجارية الخاصة.'
        : 'Reseller hosting allows you to purchase hosting resources in bulk and resell them to your clients under your own brand.'
    },
    {
      question: locale === 'ar' ? 'هل يمكنني استخدام علامتي التجارية؟' : 'Can I use my own branding?',
      answer: locale === 'ar'
        ? 'نعم! نقدم خدمة علامة بيضاء كاملة. يمكنك استخدام خوادم أسماء مخصصة وشعارك الخاص.'
        : 'Yes! We offer fully whitelabel service. You can use custom nameservers and your own logo.'
    },
    {
      question: locale === 'ar' ? 'ما هي لوحة التحكم المستخدمة؟' : 'What control panel is used?',
      answer: locale === 'ar'
        ? 'نستخدم WHM/cPanel وهي الأكثر شهرة في العالم.'
        : 'We use WHM/cPanel, the world\'s most popular hosting control panel.'
    },
    {
      question: locale === 'ar' ? 'هل يمكنني ترقية الباقة؟' : 'Can I upgrade my plan?',
      answer: locale === 'ar'
        ? 'بالتأكيد! يمكنك الترقية في أي وقت بسهولة من لوحة التحكم.'
        : 'Absolutely! You can easily upgrade at any time from your control panel.'
    },
  ];

  const stats = [
    { value: '500+', label: locale === 'ar' ? 'موزع نشط' : 'Active Resellers', icon: Users },
    { value: '15K+', label: locale === 'ar' ? 'موقع مستضاف' : 'Hosted Websites', icon: Globe },
    { value: '99.99%', label: locale === 'ar' ? 'وقت التشغيل' : 'Uptime', icon: Wifi },
    { value: '24/7', label: locale === 'ar' ? 'دعم فني' : 'Support', icon: Headphones },
  ];

  const technologies = [
    { name: 'LiteSpeed', icon: Zap },
    { name: 'CloudLinux', icon: Shield },
    { name: 'WHM/cPanel', icon: Settings },
    { name: 'Cloudflare', icon: Globe },
  ];

  // JSON-LD Structured Data for SEO
  const structuredData = {
    '@context': 'https://schema.org',
    '@type': 'Product',
    name: locale === 'ar' ? 'استضافة الموزعين' : 'Reseller Hosting',
    description: locale === 'ar' 
      ? 'ابدأ عملك الخاص في الاستضافة مع WHM/cPanel وعلامة بيضاء كاملة'
      : 'Start your own hosting business with WHM/cPanel and full whitelabel',
    image: 'https://progineous.com/og-reseller-hosting.png',
    url: `https://progineous.com/${locale}/hosting/reseller`,
    brand: {
      '@type': 'Brand',
      name: 'Pro Gineous'
    },
    offers: {
      '@type': 'AggregateOffer',
      lowPrice: '17',
      highPrice: '160',
      priceCurrency: 'USD',
      offerCount: '3',
      offers: plans.map(plan => ({
        '@type': 'Offer',
        name: plan.name,
        description: plan.tagline,
        price: plan.yearlyPrice,
        priceCurrency: 'USD',
        priceValidUntil: '2026-12-31',
        availability: 'https://schema.org/InStock',
        url: plan.baseLink
      }))
    },
    aggregateRating: {
      '@type': 'AggregateRating',
      ratingValue: '4.9',
      reviewCount: '876',
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
        name: locale === 'ar' ? 'استضافة الموزعين' : 'Reseller Hosting',
        item: `https://progineous.com/${locale}/hosting/reseller`
      }
    ]
  };

  return (
    <main className="min-h-screen bg-linear-to-b from-slate-50 via-white to-slate-50 text-gray-900 overflow-hidden">
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

      {/* Decorative Background */}
      <div className="fixed inset-0 pointer-events-none overflow-hidden">
        {/* Top gradient blob */}
        <div className="absolute -top-40 -right-40 w-150 h-150 rounded-full bg-linear-to-br from-sky-100 to-[#1d71b8]/10 blur-3xl opacity-60" />
        <div className="absolute top-1/3 -left-40 w-125 h-125 rounded-full bg-linear-to-br from-[#1d71b8]/5 to-blue-50 blur-3xl opacity-50" />
        <div className="absolute bottom-0 right-1/4 w-100 h-100 rounded-full bg-linear-to-br from-amber-50 to-orange-50 blur-3xl opacity-40" />
        
        {/* Grid pattern */}
        <div className="absolute inset-0 opacity-[0.02] bg-[linear-gradient(rgba(0,0,0,0.1)_1px,transparent_1px),linear-gradient(90deg,rgba(0,0,0,0.1)_1px,transparent_1px)] bg-size-[60px_60px]" />
      </div>

      {/* Hero Section */}
      <section className="relative pt-32 pb-20 lg:pt-40 lg:pb-32">
        <div className="container mx-auto px-4">
          <div className="grid lg:grid-cols-5 gap-12 items-center">
            <div className="lg:col-span-3 relative z-10">
              {/* Badge */}
              <div className="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-[#1d71b8]/5 border border-[#1d71b8]/20 mb-8">
                <Sparkles className="h-4 w-4 text-[#1d71b8]" />
                <span className="text-sm text-[#1d71b8] font-medium">
                  {locale === 'ar' ? 'ابدأ عملك الخاص في الاستضافة' : 'Start Your Own Hosting Business'}
                </span>
              </div>

              {/* Main Title */}
              <h1 className="text-5xl md:text-6xl lg:text-7xl font-black leading-[1.1] mb-6">
                <span className="block text-gray-900">
                  {locale === 'ar' ? 'استضافة' : 'Reseller'}
                </span>
                <span className="block bg-clip-text text-transparent bg-linear-to-r from-[#1d71b8] via-blue-500 to-sky-500">
                  {locale === 'ar' ? 'الموزعين' : 'Hosting'}
                </span>
              </h1>

              <p className="text-xl text-gray-600 max-w-xl mb-10 leading-relaxed">
                {locale === 'ar' 
                  ? 'حوّل شغفك إلى عمل مربح. اشترِ بالجملة، بِع بالتجزئة، واحتفظ بكل الأرباح.'
                  : 'Turn your passion into a profitable business. Buy wholesale, sell retail, keep all profits.'}
              </p>

              {/* CTA Buttons */}
              <div className="flex flex-wrap gap-4 mb-12">
                <a 
                  href="#plans" 
                  className="group relative inline-flex items-center gap-3 px-8 py-4 rounded-2xl bg-linear-to-r from-[#1d71b8] to-blue-600 font-bold text-white overflow-hidden transition-all hover:scale-105 hover:shadow-2xl hover:shadow-[#1d71b8]/30"
                >
                  <span className="relative z-10">{locale === 'ar' ? 'شاهد الباقات' : 'View Plans'}</span>
                  <ArrowRight className={cn("relative z-10 h-5 w-5 transition-transform group-hover:translate-x-1", locale === 'ar' && "rotate-180 group-hover:-translate-x-1")} />
                </a>
                <Link 
                  href="/contact"
                  className="group inline-flex items-center gap-3 px-8 py-4 rounded-2xl bg-white border-2 border-gray-200 font-bold text-gray-700 hover:border-[#1d71b8]/30 hover:bg-[#1d71b8]/5 transition-all"
                >
                  <Monitor className="h-5 w-5" />
                  {locale === 'ar' ? 'تواصل معنا' : 'Contact Us'}
                </Link>
              </div>

              {/* Technologies */}
              <div className="flex flex-wrap items-center gap-6">
                <span className="text-sm text-gray-500">{locale === 'ar' ? 'مدعوم بـ:' : 'Powered by:'}</span>
                <div className="flex flex-wrap gap-3">
                  {technologies.map((tech, i) => (
                    <div key={i} className="flex items-center gap-2 px-3 py-1.5 rounded-lg bg-white border border-gray-200 shadow-sm">
                      <tech.icon className="h-4 w-4 text-[#1d71b8]" />
                      <span className="text-sm text-gray-600">{tech.name}</span>
                    </div>
                  ))}
                </div>
              </div>
            </div>

            {/* Dashboard Preview */}
            <div className="lg:col-span-2 relative">
              <div className="absolute inset-0 bg-linear-to-r from-[#1d71b8]/20 to-sky-200/30 rounded-3xl blur-2xl" />
              
              <div className="relative bg-white border border-gray-200 rounded-3xl p-6 shadow-2xl shadow-gray-200/50">
                {/* Window controls */}
                <div className="flex items-center gap-2 mb-6">
                  <div className="w-3 h-3 rounded-full bg-red-400" />
                  <div className="w-3 h-3 rounded-full bg-yellow-400" />
                  <div className="w-3 h-3 rounded-full bg-green-400" />
                  <div className="flex-1 mx-4">
                    <div className="bg-gray-100 rounded-lg px-4 py-1.5 text-xs text-gray-500 text-center">
                      whm.yourdomain.com
                    </div>
                  </div>
                </div>

                {/* Stats grid */}
                <div className="grid grid-cols-2 gap-4 mb-6">
                  {stats.map((stat, i) => (
                    <div key={i} className="bg-gray-50 rounded-2xl p-4 hover:bg-[#1d71b8]/5 transition-colors border border-gray-100">
                      <stat.icon className="h-5 w-5 text-[#1d71b8] mb-2" />
                      <div className="text-2xl font-bold text-gray-900">{stat.value}</div>
                      <div className="text-xs text-gray-500">{stat.label}</div>
                    </div>
                  ))}
                </div>

                {/* Chart */}
                <div className="bg-gray-50 rounded-2xl p-4 border border-gray-100">
                  <div className="flex justify-between items-center mb-4">
                    <span className="text-sm font-medium text-gray-600">{locale === 'ar' ? 'نمو العملاء' : 'Client Growth'}</span>
                    <span className="text-xs text-[#1d71b8] font-semibold bg-[#1d71b8]/10 px-2 py-1 rounded-full">+24%</span>
                  </div>
                  <div className="flex items-end gap-2 h-20">
                    {[40, 55, 45, 65, 50, 75, 60, 85, 70, 90, 80, 95].map((height, i) => (
                      <div 
                        key={i}
                        className={cn(
                          "flex-1 bg-linear-to-t from-[#1d71b8] to-blue-400 rounded-t-sm hover:from-[#0f4c75] hover:to-blue-500 transition-all",
                          height === 40 && "bar-h-40",
                          height === 45 && "bar-h-45",
                          height === 50 && "bar-h-50",
                          height === 55 && "bar-h-55",
                          height === 60 && "bar-h-60",
                          height === 65 && "bar-h-65",
                          height === 70 && "bar-h-70",
                          height === 75 && "bar-h-75",
                          height === 80 && "bar-h-80",
                          height === 85 && "bar-h-85",
                          height === 90 && "bar-h-90",
                          height === 95 && "bar-h-95"
                        )}
                      />
                    ))}
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        {/* Scroll indicator */}
        <div className="absolute bottom-8 left-1/2 -translate-x-1/2 flex flex-col items-center gap-2 text-gray-400 animate-bounce">
          <span className="text-xs">{locale === 'ar' ? 'اسحب للأسفل' : 'Scroll down'}</span>
          <ChevronDown className="h-5 w-5" />
        </div>
      </section>

      {/* How It Works */}
      <section className="relative py-24 bg-linear-to-br from-[#1d71b8] via-blue-600 to-[#0f4c75] overflow-hidden">
        {/* Background decorations */}
        <div className="absolute inset-0">
          <div className="absolute top-0 left-0 w-96 h-96 bg-white/5 rounded-full blur-3xl -translate-x-1/2 -translate-y-1/2" />
          <div className="absolute bottom-0 right-0 w-125 h-125 bg-blue-400/10 rounded-full blur-3xl translate-x-1/3 translate-y-1/3" />
          <div className="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-200 h-200 border border-white/5 rounded-full" />
          <div className="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-150 h-150 border border-white/5 rounded-full" />
        </div>

        <div className="container mx-auto px-4 relative z-10">
          <div className="text-center mb-16">
            <div className="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 backdrop-blur-sm border border-white/20 mb-6">
              <Rocket className="h-4 w-4 text-white" />
              <span className="text-sm text-white font-medium">
                {locale === 'ar' ? 'ابدأ في دقائق' : 'Get Started in Minutes'}
              </span>
            </div>
            <h2 className="text-3xl md:text-5xl font-bold mb-4 text-white">
              {locale === 'ar' ? 'كيف تبدأ؟' : 'How It Works?'}
            </h2>
            <p className="text-blue-100 text-lg max-w-2xl mx-auto">
              {locale === 'ar' ? '4 خطوات بسيطة لبدء عملك في استضافة المواقع' : '4 simple steps to start your web hosting business'}
            </p>
          </div>

          {/* Desktop Layout - Zigzag Cards */}
          <div className="hidden lg:block max-w-6xl mx-auto">
            <div className="relative">
              {/* Connecting Line */}
              <div className="absolute top-1/2 left-8 right-8 h-1 bg-white/20 -translate-y-1/2 rounded-full" />
              
              <div className="grid grid-cols-4 gap-6">
                {steps.map((step, index) => (
                  <div 
                    key={index}
                    onClick={() => setActiveStep(index)}
                    className={cn(
                      "relative cursor-pointer group",
                      index % 2 === 0 ? "pt-0 pb-24" : "pt-24 pb-0"
                    )}
                  >
                    {/* Vertical connector */}
                    <div className={cn(
                      "absolute left-1/2 w-0.5 bg-white/30 -translate-x-1/2",
                      index % 2 === 0 ? "top-[calc(100%-6rem)] h-24" : "top-0 h-24"
                    )} />
                    
                    {/* Dot on the line - positioned at the junction */}
                    <div className={cn(
                      "absolute left-1/2 -translate-x-1/2 w-5 h-5 rounded-full border-4 transition-all z-20",
                      index % 2 === 0 ? "bottom-24 -mb-2.5" : "top-24 -mt-2.5",
                      activeStep === index 
                        ? "bg-white border-[#1d71b8] scale-125" 
                        : "bg-[#1d71b8] border-white/50"
                    )} />
                    
                    {/* Card */}
                    <div className={cn(
                      "relative bg-white/10 backdrop-blur-md rounded-3xl p-6 border transition-all duration-500",
                      activeStep === index 
                        ? "bg-white text-gray-900 border-white shadow-2xl shadow-black/20 scale-105" 
                        : "border-white/20 hover:bg-white/20 hover:border-white/40"
                    )}>
                      {/* Step Number - inside the card */}
                      <div className={cn(
                        "w-12 h-12 mx-auto mb-4 rounded-full flex items-center justify-center font-black text-xl transition-all",
                        activeStep === index 
                          ? "bg-[#1d71b8] text-white" 
                          : "bg-white/20 text-white"
                      )}>
                        {index + 1}
                      </div>
                      
                      {/* Icon */}
                      <div className={cn(
                        "w-16 h-16 mx-auto mb-4 rounded-2xl flex items-center justify-center transition-all",
                        activeStep === index 
                          ? "bg-[#1d71b8]/10" 
                          : "bg-white/10"
                      )}>
                        <step.icon className={cn(
                          "h-8 w-8 transition-colors",
                          activeStep === index ? "text-[#1d71b8]" : "text-white"
                        )} />
                      </div>
                      
                      {/* Content */}
                      <h3 className={cn(
                        "font-bold text-lg mb-2 text-center transition-colors",
                        activeStep === index ? "text-gray-900" : "text-white"
                      )}>
                        {step.title}
                      </h3>
                      <p className={cn(
                        "text-sm text-center transition-colors",
                        activeStep === index ? "text-gray-600" : "text-white/70"
                      )}>
                        {step.description}
                      </p>
                    </div>
                  </div>
                ))}
              </div>
            </div>
          </div>

          {/* Tablet Layout */}
          <div className="hidden md:grid lg:hidden grid-cols-2 gap-6 max-w-3xl mx-auto">
            {steps.map((step, index) => (
              <div 
                key={index}
                onClick={() => setActiveStep(index)}
                className={cn(
                  "relative cursor-pointer group p-6 rounded-3xl border transition-all duration-300",
                  activeStep === index 
                    ? "bg-white text-gray-900 border-white shadow-2xl" 
                    : "bg-white/10 backdrop-blur-sm border-white/20 hover:bg-white/20"
                )}
              >
                <div className="flex items-start gap-4">
                  <div className={cn(
                    "w-14 h-14 rounded-2xl flex items-center justify-center shrink-0 transition-all",
                    activeStep === index 
                      ? "bg-[#1d71b8]" 
                      : "bg-white/20"
                  )}>
                    <step.icon className={cn(
                      "h-7 w-7",
                      activeStep === index ? "text-white" : "text-white"
                    )} />
                  </div>
                  <div className="flex-1">
                    <div className={cn(
                      "text-xs font-bold mb-1 transition-colors",
                      activeStep === index ? "text-[#1d71b8]" : "text-white/60"
                    )}>
                      {locale === 'ar' ? `الخطوة ${index + 1}` : `Step ${index + 1}`}
                    </div>
                    <h3 className={cn(
                      "font-bold text-lg mb-1 transition-colors",
                      activeStep === index ? "text-gray-900" : "text-white"
                    )}>
                      {step.title}
                    </h3>
                    <p className={cn(
                      "text-sm transition-colors",
                      activeStep === index ? "text-gray-600" : "text-white/70"
                    )}>
                      {step.description}
                    </p>
                  </div>
                </div>
              </div>
            ))}
          </div>

          {/* Mobile Layout */}
          <div className="md:hidden space-y-4">
            {steps.map((step, index) => (
              <div 
                key={index}
                onClick={() => setActiveStep(index)}
                className={cn(
                  "relative cursor-pointer p-5 rounded-2xl border transition-all duration-300",
                  activeStep === index 
                    ? "bg-white text-gray-900 border-white shadow-xl" 
                    : "bg-white/10 backdrop-blur-sm border-white/20"
                )}
              >
                <div className="flex items-center gap-4">
                  {/* Number Circle */}
                  <div className={cn(
                    "w-12 h-12 rounded-xl flex items-center justify-center font-black text-lg shrink-0 transition-all",
                    activeStep === index 
                      ? "bg-[#1d71b8] text-white" 
                      : "bg-white/20 text-white"
                  )}>
                    {index + 1}
                  </div>
                  
                  <div className="flex-1">
                    <h3 className={cn(
                      "font-bold mb-0.5 transition-colors",
                      activeStep === index ? "text-gray-900" : "text-white"
                    )}>
                      {step.title}
                    </h3>
                    <p className={cn(
                      "text-sm transition-colors",
                      activeStep === index ? "text-gray-600" : "text-white/70"
                    )}>
                      {step.description}
                    </p>
                  </div>
                  
                  {/* Icon */}
                  <step.icon className={cn(
                    "h-6 w-6 shrink-0 transition-colors",
                    activeStep === index ? "text-[#1d71b8]" : "text-white/50"
                  )} />
                </div>
              </div>
            ))}
          </div>

          {/* Progress indicator */}
          <div className="flex justify-center gap-2 mt-12">
            {steps.map((_, index) => (
              <button
                key={index}
                onClick={() => setActiveStep(index)}
                aria-label={`Step ${index + 1}`}
                title={`Step ${index + 1}`}
                className={cn(
                  "h-2 rounded-full transition-all duration-300",
                  activeStep === index 
                    ? "w-8 bg-white" 
                    : "w-2 bg-white/30 hover:bg-white/50"
                )}
              />
            ))}
          </div>
        </div>
      </section>

      {/* Plans Section - Interactive Showcase */}
      <section id="plans" className="relative py-24 bg-linear-to-b from-gray-50 via-white to-gray-50 overflow-hidden">
        {/* Background */}
        <div className="absolute inset-0">
          <div className="absolute inset-0 bg-[linear-gradient(rgba(29,113,184,0.03)_1px,transparent_1px),linear-gradient(90deg,rgba(29,113,184,0.03)_1px,transparent_1px)] bg-size-[60px_60px]" />
          <div className="absolute top-0 left-1/4 w-125 h-125 bg-[#1d71b8]/5 rounded-full blur-[150px]" />
          <div className="absolute bottom-0 right-1/4 w-100 h-100 bg-blue-500/5 rounded-full blur-[100px]" />
        </div>

        <div className="container mx-auto px-4 relative z-10">
          <div className="text-center mb-12">
            <h2 className="text-3xl md:text-5xl font-bold mb-4 text-gray-900">
              {locale === 'ar' ? 'اختر باقتك' : 'Choose Your Plan'}
            </h2>
            <p className="text-gray-500 text-lg mb-8">
              {locale === 'ar' ? 'باقات مرنة تنمو مع عملك' : 'Flexible plans that grow with your business'}
            </p>

            {/* Billing Toggle */}
            <div className="inline-flex items-center p-1 rounded-full bg-gray-100 border border-gray-200">
              <button
                onClick={() => setBillingPeriod('monthly')}
                className={cn(
                  "px-6 py-2.5 rounded-full text-sm font-bold transition-all",
                  billingPeriod === 'monthly' 
                    ? "bg-white text-gray-900 shadow-md" 
                    : "text-gray-500 hover:text-gray-700"
                )}
              >
                {locale === 'ar' ? 'شهري' : 'Monthly'}
              </button>
              <button
                onClick={() => setBillingPeriod('yearly')}
                className={cn(
                  "px-6 py-2.5 rounded-full text-sm font-bold transition-all flex items-center gap-2",
                  billingPeriod === 'yearly' 
                    ? "bg-white text-gray-900 shadow-md" 
                    : "text-gray-500 hover:text-gray-700"
                )}
              >
                {locale === 'ar' ? 'سنوي' : 'Yearly'}
                <span className="text-xs px-2 py-0.5 rounded-full bg-green-500 text-white">-15%</span>
              </button>
            </div>
          </div>

          {/* Plan Selector Tabs */}
          <div className="max-w-4xl mx-auto mb-8">
            <div className="flex justify-center">
              <div className="inline-flex bg-white rounded-2xl p-2 border border-gray-200 shadow-lg">
                {plans.map((plan, index) => (
                  <button
                    key={plan.name}
                    onClick={() => setHoveredPlan(index)}
                    className={cn(
                      "relative px-8 py-4 rounded-xl font-bold transition-all duration-300",
                      hoveredPlan === index 
                        ? "bg-linear-to-r from-[#1d71b8] to-blue-600 text-white shadow-lg shadow-[#1d71b8]/30" 
                        : "text-gray-500 hover:text-gray-700 hover:bg-gray-50"
                    )}
                  >
                    {plan.popular && hoveredPlan !== index && (
                      <span className="absolute -top-2 -right-2 w-3 h-3 bg-[#1d71b8] rounded-full animate-pulse" />
                    )}
                    <div className="text-lg">{plan.name.split(' ')[0]}</div>
                    <div className="text-xs opacity-70 mt-1">
                      ${billingPeriod === 'yearly' ? plan.yearlyPrice : plan.monthlyPrice}/{locale === 'ar' ? 'شهر' : 'mo'}
                    </div>
                  </button>
                ))}
              </div>
            </div>
          </div>

          {/* Selected Plan Display */}
          <div className="max-w-5xl mx-auto">
            {plans.map((plan, index) => (
              <div
                key={plan.name}
                className={cn(
                  "transition-all duration-500",
                  hoveredPlan === index ? "block" : "hidden"
                )}
              >
                {/* Main Card */}
                <div className="relative bg-white rounded-4xl border border-gray-200 shadow-2xl shadow-gray-200/50 overflow-hidden">
                  {/* Popular Badge */}
                  {plan.popular && (
                    <div className="absolute top-0 right-0 bg-linear-to-l from-[#1d71b8] to-blue-600 text-white text-sm font-bold px-6 py-2 rounded-bl-2xl">
                      <div className="flex items-center gap-2">
                        <Star className="h-4 w-4 fill-current" />
                        {locale === 'ar' ? 'الأكثر مبيعاً' : 'Most Popular'}
                      </div>
                    </div>
                  )}

                  <div className="grid lg:grid-cols-2 gap-0">
                    {/* Left Side - Visual */}
                    <div className={cn(
                      "relative p-8 lg:p-12 bg-linear-to-br",
                      index === 0 ? "from-sky-50 to-blue-100" :
                      index === 1 ? "from-[#1d71b8]/5 to-blue-100" :
                      "from-amber-50 to-orange-100"
                    )}>
                      {/* Animated Circles */}
                      <div className="absolute inset-0 overflow-hidden">
                        <div className={cn(
                          "absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-64 h-64 rounded-full border opacity-30 animate-ping-slow",
                          index === 0 ? "border-sky-300" : index === 1 ? "border-[#1d71b8]/50" : "border-amber-300"
                        )} />
                        <div className={cn(
                          "absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-48 h-48 rounded-full border opacity-40 animate-ping-slow-delayed",
                          index === 0 ? "border-sky-300" : index === 1 ? "border-[#1d71b8]/50" : "border-amber-300"
                        )} />
                      </div>

                      <div className="relative z-10">
                        {/* Plan Name & Tagline */}
                        <div className={cn(
                          "inline-flex items-center gap-2 px-4 py-2 rounded-full text-sm font-bold mb-6 border",
                          index === 0 ? "bg-sky-100 border-sky-200 text-sky-700" :
                          index === 1 ? "bg-[#1d71b8]/10 border-[#1d71b8]/20 text-[#1d71b8]" :
                          "bg-amber-100 border-amber-200 text-amber-700"
                        )}>
                          <Sparkles className="h-4 w-4" />
                          {plan.tagline}
                        </div>

                        <h3 className="text-4xl lg:text-5xl font-black text-gray-900 mb-6">{plan.name}</h3>

                        {/* Price Display */}
                        <div className="mb-8">
                          <div className="flex items-baseline gap-2">
                            <span className="text-6xl lg:text-7xl font-black text-gray-900">
                              ${billingPeriod === 'yearly' ? plan.yearlyPrice : plan.monthlyPrice}
                            </span>
                            <span className="text-gray-500 text-xl">/{locale === 'ar' ? 'شهر' : 'mo'}</span>
                          </div>
                          {billingPeriod === 'yearly' && (
                            <div className="mt-2 flex items-center gap-3">
                              <span className="text-gray-400 line-through">${plan.monthlyPrice}/mo</span>
                              <span className="px-3 py-1 rounded-full bg-green-100 text-green-600 text-sm font-bold">
                                {locale === 'ar' ? 'وفر' : 'Save'} ${((plan.monthlyPrice - plan.yearlyPrice) * 12).toFixed(0)}/{locale === 'ar' ? 'سنة' : 'yr'}
                              </span>
                            </div>
                          )}
                        </div>

                        {/* Key Stats - Visual Bars */}
                        <div className="space-y-4">
                          {/* Accounts Bar */}
                          <div>
                            <div className="flex justify-between text-sm mb-2">
                              <span className="text-gray-500">{locale === 'ar' ? 'حسابات cPanel' : 'cPanel Accounts'}</span>
                              <span className="text-gray-900 font-bold">{plan.accounts}</span>
                            </div>
                            <div className="h-3 bg-gray-200 rounded-full overflow-hidden">
                              <div 
                                className={cn(
                                  "h-full rounded-full transition-all duration-1000",
                                  index === 0 ? "bg-linear-to-r from-sky-500 to-blue-500 progress-width-33" :
                                  index === 1 ? "bg-linear-to-r from-[#1d71b8] to-blue-500 progress-width-66" :
                                  "bg-linear-to-r from-amber-500 to-orange-500 progress-width-100"
                                )}
                              />
                            </div>
                          </div>

                          {/* Storage Bar */}
                          <div>
                            <div className="flex justify-between text-sm mb-2">
                              <span className="text-gray-500">{locale === 'ar' ? 'مساحة التخزين' : 'Storage Space'}</span>
                              <span className="text-gray-900 font-bold">{plan.storage}</span>
                            </div>
                            <div className="h-3 bg-gray-200 rounded-full overflow-hidden">
                              <div 
                                className={cn(
                                  "h-full rounded-full transition-all duration-1000",
                                  index === 0 ? "bg-linear-to-r from-sky-500 to-blue-500 progress-width-33" :
                                  index === 1 ? "bg-linear-to-r from-[#1d71b8] to-blue-500 progress-width-66" :
                                  "bg-linear-to-r from-amber-500 to-orange-500 progress-width-100"
                                )}
                              />
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    {/* Right Side - Features & CTA */}
                    <div className="p-8 lg:p-12 flex flex-col bg-white">
                      <h4 className="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
                        <Check className="h-5 w-5 text-green-500" />
                        {locale === 'ar' ? 'المميزات المتضمنة' : 'Included Features'}
                      </h4>

                      {/* Features Grid */}
                      <div className="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-8 flex-1">
                        {plan.features.map((feature, i) => (
                          <div 
                            key={i} 
                            className="flex items-center gap-3 bg-gray-50 rounded-xl px-4 py-3 border border-gray-100"
                          >
                            <div className={cn(
                              "w-8 h-8 rounded-lg flex items-center justify-center shrink-0",
                              index === 0 ? "bg-sky-100" :
                              index === 1 ? "bg-[#1d71b8]/10" :
                              "bg-amber-100"
                            )}>
                              <Check className={cn(
                                "h-4 w-4",
                                index === 0 ? "text-sky-600" :
                                index === 1 ? "text-[#1d71b8]" :
                                "text-amber-600"
                              )} />
                            </div>
                            <span className="text-sm text-gray-600">{feature}</span>
                          </div>
                        ))}
                      </div>

                      {/* CTA Section */}
                      <div className="space-y-4">
                        <a
                          href={getPlanLink(plan.baseLink)}
                          target="_blank"
                          rel="noopener noreferrer"
                          className={cn(
                            "w-full inline-flex items-center justify-center gap-3 px-8 py-5 rounded-2xl font-bold text-lg transition-all duration-300 group",
                            index === 0 ? "bg-linear-to-r from-sky-500 to-blue-600 hover:shadow-xl hover:shadow-sky-500/30" :
                            index === 1 ? "bg-linear-to-r from-[#1d71b8] to-blue-600 hover:shadow-xl hover:shadow-[#1d71b8]/30" :
                            "bg-linear-to-r from-amber-500 to-orange-600 hover:shadow-xl hover:shadow-amber-500/30",
                            "text-white hover:scale-[1.02]"
                          )}
                        >
                          {locale === 'ar' ? 'ابدأ الآن' : 'Get Started Now'}
                          <ArrowRight className={cn("h-5 w-5 group-hover:translate-x-1 transition-transform", locale === 'ar' && "rotate-180")} />
                        </a>

                        <div className="flex items-center justify-center gap-4 text-sm text-gray-400">
                          <div className="flex items-center gap-1">
                            <Shield className="h-4 w-4" />
                            {locale === 'ar' ? 'ضمان استرداد 30 يوم' : '30-day money back'}
                          </div>
                          <div className="w-1 h-1 rounded-full bg-gray-300" />
                          <div className="flex items-center gap-1">
                            <Zap className="h-4 w-4" />
                            {locale === 'ar' ? 'تفعيل فوري' : 'Instant setup'}
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                {/* Quick Comparison Row */}
                <div className="mt-6 grid grid-cols-3 gap-4">
                  {plans.map((p, i) => (
                    <button
                      key={p.name}
                      onClick={() => setHoveredPlan(i)}
                      className={cn(
                        "p-4 rounded-xl border transition-all duration-300 text-center",
                        i === index 
                          ? "bg-[#1d71b8]/5 border-[#1d71b8]/30 scale-105 shadow-lg" 
                          : "bg-white border-gray-200 hover:bg-gray-50 hover:border-gray-300"
                      )}
                    >
                      <div className={cn(
                        "text-xl font-bold mb-1",
                        i === index ? "text-[#1d71b8]" : "text-gray-500"
                      )}>
                        {p.accounts} {locale === 'ar' ? 'حساب' : 'Acc'}
                      </div>
                      <div className={cn(
                        "text-sm",
                        i === index ? "text-gray-700" : "text-gray-400"
                      )}>
                        {p.storage}
                      </div>
                      <div className={cn(
                        "text-lg font-bold mt-2",
                        i === index ? "text-gray-900" : "text-gray-500"
                      )}>
                        ${billingPeriod === 'yearly' ? p.yearlyPrice : p.monthlyPrice}
                      </div>
                    </button>
                  ))}
                </div>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* Comparison Table Section */}
      <section className="relative py-24 bg-white">
        <div className="container mx-auto px-4">
          <div className="text-center mb-16">
            <div className="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-[#1d71b8]/10 border border-[#1d71b8]/20 mb-6">
              <Settings className="h-4 w-4 text-[#1d71b8]" />
              <span className="text-sm text-[#1d71b8] font-medium">
                {locale === 'ar' ? 'مقارنة تفصيلية' : 'Detailed Comparison'}
              </span>
            </div>
            <h2 className="text-3xl md:text-5xl font-bold mb-4 text-gray-900">
              {locale === 'ar' ? 'قارن بين الباقات' : 'Compare Plans'}
            </h2>
            <p className="text-gray-500 text-lg max-w-2xl mx-auto">
              {locale === 'ar' 
                ? 'اختر الباقة المناسبة لحجم عملك واحتياجاتك'
                : 'Choose the right plan for your business size and needs'}
            </p>
          </div>

          {/* Comparison Table */}
          <div className="max-w-5xl mx-auto overflow-x-auto">
            <div className="min-w-175">
              {/* Table Header */}
              <div className="grid grid-cols-4 gap-4 mb-4">
                <div className="p-4">
                  <span className="text-gray-500 font-medium">{locale === 'ar' ? 'المواصفات' : 'Features'}</span>
                </div>
                {plans.map((plan, index) => (
                  <div 
                    key={plan.name}
                    className={cn(
                      "p-4 rounded-2xl text-center",
                      plan.popular ? "bg-[#1d71b8] text-white" : "bg-gray-100"
                    )}
                  >
                    <div className={cn(
                      "font-bold text-lg",
                      plan.popular ? "text-white" : "text-gray-900"
                    )}>
                      {plan.name.split(' ')[0]}
                    </div>
                    <div className={cn(
                      "text-2xl font-black mt-1",
                      plan.popular ? "text-white" : "text-gray-900"
                    )}>
                      ${billingPeriod === 'yearly' ? plan.yearlyPrice : plan.monthlyPrice}
                      <span className={cn(
                        "text-sm font-normal",
                        plan.popular ? "text-white/70" : "text-gray-500"
                      )}>/{locale === 'ar' ? 'شهر' : 'mo'}</span>
                    </div>
                    {plan.popular && (
                      <div className="mt-2 inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-white/20 text-xs">
                        <Star className="h-3 w-3 fill-current" />
                        {locale === 'ar' ? 'الأكثر طلباً' : 'Popular'}
                      </div>
                    )}
                  </div>
                ))}
              </div>

              {/* Comparison Rows */}
              <div className="space-y-2">
                {/* cPanel Accounts */}
                <div className="grid grid-cols-4 gap-4 items-center py-4 border-b border-gray-100">
                  <div className="flex items-center gap-3">
                    <div className="w-10 h-10 rounded-xl bg-blue-100 flex items-center justify-center">
                      <Users className="h-5 w-5 text-blue-600" />
                    </div>
                    <span className="font-medium text-gray-700">{locale === 'ar' ? 'حسابات cPanel' : 'cPanel Accounts'}</span>
                  </div>
                  <div className="text-center font-bold text-gray-900">20</div>
                  <div className="text-center font-bold text-[#1d71b8] text-lg">50</div>
                  <div className="text-center font-bold text-gray-900">100</div>
                </div>

                {/* Storage */}
                <div className="grid grid-cols-4 gap-4 items-center py-4 border-b border-gray-100 bg-gray-50/50 rounded-xl">
                  <div className="flex items-center gap-3 px-4">
                    <div className="w-10 h-10 rounded-xl bg-green-100 flex items-center justify-center">
                      <HardDrive className="h-5 w-5 text-green-600" />
                    </div>
                    <span className="font-medium text-gray-700">{locale === 'ar' ? 'مساحة التخزين' : 'Storage Space'}</span>
                  </div>
                  <div className="text-center font-bold text-gray-900">20 GB</div>
                  <div className="text-center font-bold text-[#1d71b8] text-lg">650 GB</div>
                  <div className="text-center font-bold text-gray-900">3 TB</div>
                </div>

                {/* Storage Type */}
                <div className="grid grid-cols-4 gap-4 items-center py-4 border-b border-gray-100">
                  <div className="flex items-center gap-3">
                    <div className="w-10 h-10 rounded-xl bg-purple-100 flex items-center justify-center">
                      <Database className="h-5 w-5 text-purple-600" />
                    </div>
                    <span className="font-medium text-gray-700">{locale === 'ar' ? 'نوع التخزين' : 'Storage Type'}</span>
                  </div>
                  <div className="text-center">
                    <span className="px-3 py-1 rounded-full bg-purple-100 text-purple-700 text-sm font-medium">NVMe SSD</span>
                  </div>
                  <div className="text-center">
                    <span className="px-3 py-1 rounded-full bg-[#1d71b8]/10 text-[#1d71b8] text-sm font-medium">NVMe SSD</span>
                  </div>
                  <div className="text-center">
                    <span className="px-3 py-1 rounded-full bg-purple-100 text-purple-700 text-sm font-medium">NVMe SSD</span>
                  </div>
                </div>

                {/* Bandwidth */}
                <div className="grid grid-cols-4 gap-4 items-center py-4 border-b border-gray-100 bg-gray-50/50 rounded-xl">
                  <div className="flex items-center gap-3 px-4">
                    <div className="w-10 h-10 rounded-xl bg-cyan-100 flex items-center justify-center">
                      <Wifi className="h-5 w-5 text-cyan-600" />
                    </div>
                    <span className="font-medium text-gray-700">{locale === 'ar' ? 'الباندويث' : 'Bandwidth'}</span>
                  </div>
                  <div className="text-center font-bold text-gray-900">{locale === 'ar' ? 'غير محدود' : 'Unlimited'}</div>
                  <div className="text-center font-bold text-[#1d71b8] text-lg">{locale === 'ar' ? 'غير محدود' : 'Unlimited'}</div>
                  <div className="text-center font-bold text-gray-900">{locale === 'ar' ? 'غير محدود' : 'Unlimited'}</div>
                </div>

                {/* LiteSpeed */}
                <div className="grid grid-cols-4 gap-4 items-center py-4 border-b border-gray-100">
                  <div className="flex items-center gap-3">
                    <div className="w-10 h-10 rounded-xl bg-orange-100 flex items-center justify-center">
                      <Zap className="h-5 w-5 text-orange-600" />
                    </div>
                    <span className="font-medium text-gray-700">LiteSpeed Web Server</span>
                  </div>
                  <div className="text-center"><Check className="h-6 w-6 text-green-500 mx-auto" /></div>
                  <div className="text-center"><Check className="h-6 w-6 text-green-500 mx-auto" /></div>
                  <div className="text-center"><Check className="h-6 w-6 text-green-500 mx-auto" /></div>
                </div>

                {/* Whitelabel */}
                <div className="grid grid-cols-4 gap-4 items-center py-4 border-b border-gray-100 bg-gray-50/50 rounded-xl">
                  <div className="flex items-center gap-3 px-4">
                    <div className="w-10 h-10 rounded-xl bg-pink-100 flex items-center justify-center">
                      <Palette className="h-5 w-5 text-pink-600" />
                    </div>
                    <span className="font-medium text-gray-700">{locale === 'ar' ? 'علامة بيضاء كاملة' : 'Full Whitelabel'}</span>
                  </div>
                  <div className="text-center"><Check className="h-6 w-6 text-green-500 mx-auto" /></div>
                  <div className="text-center"><Check className="h-6 w-6 text-green-500 mx-auto" /></div>
                  <div className="text-center"><Check className="h-6 w-6 text-green-500 mx-auto" /></div>
                </div>

                {/* CloudLinux */}
                <div className="grid grid-cols-4 gap-4 items-center py-4 border-b border-gray-100">
                  <div className="flex items-center gap-3">
                    <div className="w-10 h-10 rounded-xl bg-blue-100 flex items-center justify-center">
                      <Monitor className="h-5 w-5 text-blue-600" />
                    </div>
                    <span className="font-medium text-gray-700">CloudLinux OS</span>
                  </div>
                  <div className="text-center"><Check className="h-6 w-6 text-green-500 mx-auto" /></div>
                  <div className="text-center"><Check className="h-6 w-6 text-green-500 mx-auto" /></div>
                  <div className="text-center"><Check className="h-6 w-6 text-green-500 mx-auto" /></div>
                </div>

                {/* Imunify360 */}
                <div className="grid grid-cols-4 gap-4 items-center py-4 border-b border-gray-100 bg-gray-50/50 rounded-xl">
                  <div className="flex items-center gap-3 px-4">
                    <div className="w-10 h-10 rounded-xl bg-red-100 flex items-center justify-center">
                      <Shield className="h-5 w-5 text-red-600" />
                    </div>
                    <span className="font-medium text-gray-700">Imunify360</span>
                  </div>
                  <div className="text-center"><Check className="h-6 w-6 text-green-500 mx-auto" /></div>
                  <div className="text-center"><Check className="h-6 w-6 text-green-500 mx-auto" /></div>
                  <div className="text-center"><Check className="h-6 w-6 text-green-500 mx-auto" /></div>
                </div>

                {/* Auto SSL */}
                <div className="grid grid-cols-4 gap-4 items-center py-4 border-b border-gray-100">
                  <div className="flex items-center gap-3">
                    <div className="w-10 h-10 rounded-xl bg-green-100 flex items-center justify-center">
                      <Globe className="h-5 w-5 text-green-600" />
                    </div>
                    <span className="font-medium text-gray-700">{locale === 'ar' ? 'شهادات SSL تلقائية' : 'Auto SSL'}</span>
                  </div>
                  <div className="text-center"><Check className="h-6 w-6 text-green-500 mx-auto" /></div>
                  <div className="text-center"><Check className="h-6 w-6 text-green-500 mx-auto" /></div>
                  <div className="text-center"><Check className="h-6 w-6 text-green-500 mx-auto" /></div>
                </div>

                {/* Cloudflare CDN */}
                <div className="grid grid-cols-4 gap-4 items-center py-4 border-b border-gray-100 bg-gray-50/50 rounded-xl">
                  <div className="flex items-center gap-3 px-4">
                    <div className="w-10 h-10 rounded-xl bg-amber-100 flex items-center justify-center">
                      <Globe className="h-5 w-5 text-amber-600" />
                    </div>
                    <span className="font-medium text-gray-700">Cloudflare CDN</span>
                  </div>
                  <div className="text-center"><Check className="h-6 w-6 text-green-500 mx-auto" /></div>
                  <div className="text-center"><Check className="h-6 w-6 text-green-500 mx-auto" /></div>
                  <div className="text-center"><Check className="h-6 w-6 text-green-500 mx-auto" /></div>
                </div>

                {/* Offsite Backups */}
                <div className="grid grid-cols-4 gap-4 items-center py-4 border-b border-gray-100">
                  <div className="flex items-center gap-3">
                    <div className="w-10 h-10 rounded-xl bg-indigo-100 flex items-center justify-center">
                      <Database className="h-5 w-5 text-indigo-600" />
                    </div>
                    <span className="font-medium text-gray-700">{locale === 'ar' ? 'نسخ احتياطية خارجية' : 'Offsite Backups'}</span>
                  </div>
                  <div className="text-center text-gray-300">—</div>
                  <div className="text-center"><Check className="h-6 w-6 text-green-500 mx-auto" /></div>
                  <div className="text-center"><Check className="h-6 w-6 text-green-500 mx-auto" /></div>
                </div>

                {/* RAM per Account */}
                <div className="grid grid-cols-4 gap-4 items-center py-4 border-b border-gray-100 bg-gray-50/50 rounded-xl">
                  <div className="flex items-center gap-3 px-4">
                    <div className="w-10 h-10 rounded-xl bg-violet-100 flex items-center justify-center">
                      <Sparkles className="h-5 w-5 text-violet-600" />
                    </div>
                    <span className="font-medium text-gray-700">{locale === 'ar' ? 'رام لكل حساب' : 'RAM per Account'}</span>
                  </div>
                  <div className="text-center font-medium text-gray-600">1 GB</div>
                  <div className="text-center font-bold text-[#1d71b8]">2 GB</div>
                  <div className="text-center font-bold text-amber-600">4 GB</div>
                </div>

                {/* Priority Support */}
                <div className="grid grid-cols-4 gap-4 items-center py-4 border-b border-gray-100">
                  <div className="flex items-center gap-3">
                    <div className="w-10 h-10 rounded-xl bg-emerald-100 flex items-center justify-center">
                      <Headphones className="h-5 w-5 text-emerald-600" />
                    </div>
                    <span className="font-medium text-gray-700">{locale === 'ar' ? 'دعم أولوية' : 'Priority Support'}</span>
                  </div>
                  <div className="text-center text-gray-300">—</div>
                  <div className="text-center text-gray-300">—</div>
                  <div className="text-center"><Check className="h-6 w-6 text-green-500 mx-auto" /></div>
                </div>
              </div>

              {/* CTA Buttons Row */}
              <div className="grid grid-cols-4 gap-4 mt-8">
                <div></div>
                {plans.map((plan, index) => (
                  <a
                    key={plan.name}
                    href={getPlanLink(plan.baseLink)}
                    target="_blank"
                    rel="noopener noreferrer"
                    className={cn(
                      "py-4 rounded-xl font-bold text-center transition-all duration-300",
                      plan.popular 
                        ? "bg-linear-to-r from-[#1d71b8] to-blue-600 text-white hover:shadow-lg hover:shadow-[#1d71b8]/30 hover:scale-105"
                        : "bg-gray-100 text-gray-700 hover:bg-gray-200"
                    )}
                  >
                    {locale === 'ar' ? 'اختر الباقة' : 'Choose Plan'}
                  </a>
                ))}
              </div>
            </div>
          </div>
        </div>
      </section>

      {/* Features Section */}
      <section className="relative py-24 bg-white">
        <div className="container mx-auto px-4">
          <div className="text-center mb-16">
            <h2 className="text-3xl md:text-5xl font-bold mb-4 text-gray-900">
              {locale === 'ar' ? 'كل ما تحتاجه للنجاح' : 'Everything You Need'}
            </h2>
          </div>

          <div className="grid md:grid-cols-3 lg:grid-cols-4 gap-4 max-w-6xl mx-auto">
            {/* Large Feature Card */}
            <div className="md:col-span-2 lg:col-span-2 row-span-2 relative group overflow-hidden rounded-3xl bg-linear-to-br from-[#1d71b8] to-blue-600 p-8 text-white">
              <div className="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2" />
              <div className="relative h-full flex flex-col">
                <div className="w-20 h-20 rounded-2xl bg-white/20 backdrop-blur-sm flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                  <Palette className="h-10 w-10 text-white" />
                </div>
                <h3 className="text-2xl md:text-3xl font-bold mb-4">
                  {locale === 'ar' ? 'علامة بيضاء 100%' : '100% Whitelabel'}
                </h3>
                <p className="text-white/80 text-lg leading-relaxed flex-1">
                  {locale === 'ar' 
                    ? 'عملاؤك لن يعرفوا أبداً أنك موزع. استخدم خوادم الأسماء الخاصة بك، شعارك، وألوان علامتك التجارية.'
                    : 'Your clients will never know you\'re a reseller. Use your own nameservers, logo, and brand colors.'}
                </p>
                <div className="flex flex-wrap gap-2 mt-6">
                  {['Custom Nameservers', 'Your Logo', 'Brand Colors'].map((tag, i) => (
                    <span key={i} className="px-3 py-1 rounded-full bg-white/20 text-xs text-white">
                      {tag}
                    </span>
                  ))}
                </div>
              </div>
            </div>

            {/* Small Feature Cards */}
            <div className="bg-white border-2 border-gray-200 rounded-3xl p-6 hover:border-[#1d71b8]/30 hover:shadow-lg transition-all group">
              <div className="w-14 h-14 rounded-2xl bg-[#1d71b8]/10 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                <Shield className="h-7 w-7 text-[#1d71b8]" />
              </div>
              <h3 className="font-bold text-gray-900 text-lg mb-2">{locale === 'ar' ? 'حماية متقدمة' : 'Advanced Security'}</h3>
              <p className="text-sm text-gray-500">Imunify360 + CloudLinux</p>
            </div>

            <div className="bg-white border-2 border-gray-200 rounded-3xl p-6 hover:border-amber-300 hover:shadow-lg transition-all group">
              <div className="w-14 h-14 rounded-2xl bg-amber-100 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                <Zap className="h-7 w-7 text-amber-600" />
              </div>
              <h3 className="font-bold text-gray-900 text-lg mb-2">{locale === 'ar' ? 'سرعة فائقة' : 'Blazing Fast'}</h3>
              <p className="text-sm text-gray-500">LiteSpeed + NVMe SSD</p>
            </div>

            <div className="bg-white border-2 border-gray-200 rounded-3xl p-6 hover:border-sky-300 hover:shadow-lg transition-all group">
              <div className="w-14 h-14 rounded-2xl bg-sky-100 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                <Settings className="h-7 w-7 text-sky-600" />
              </div>
              <h3 className="font-bold text-gray-900 text-lg mb-2">WHM/cPanel</h3>
              <p className="text-sm text-gray-500">{locale === 'ar' ? 'لوحة تحكم قوية' : 'Powerful panel'}</p>
            </div>

            <div className="bg-white border-2 border-gray-200 rounded-3xl p-6 hover:border-rose-300 hover:shadow-lg transition-all group">
              <div className="w-14 h-14 rounded-2xl bg-rose-100 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                <Headphones className="h-7 w-7 text-rose-600" />
              </div>
              <h3 className="font-bold text-gray-900 text-lg mb-2">{locale === 'ar' ? 'دعم 24/7' : '24/7 Support'}</h3>
              <p className="text-sm text-gray-500">{locale === 'ar' ? 'فريق متخصص' : 'Expert team'}</p>
            </div>

            {/* Wide Feature */}
            <div className="md:col-span-2 bg-linear-to-r from-[#1d71b8]/5 to-blue-50 border-2 border-[#1d71b8]/20 rounded-3xl p-6 hover:shadow-lg transition-all group">
              <div className="flex items-center gap-6">
                <div className="w-16 h-16 rounded-2xl bg-linear-to-br from-[#1d71b8] to-blue-500 flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
                  <Globe className="h-8 w-8 text-white" />
                </div>
                <div>
                  <h3 className="font-bold text-gray-900 text-xl mb-1">Cloudflare CDN</h3>
                  <p className="text-gray-600">{locale === 'ar' ? 'شبكة عالمية لتسريع مواقع عملائك' : 'Global network to speed up your websites'}</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      {/* FAQ Section */}
      <section className="relative py-24 bg-gray-50">
        <div className="container mx-auto px-4">
          <div className="max-w-3xl mx-auto">
            <div className="text-center mb-12">
              <h2 className="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                {locale === 'ar' ? 'أسئلة شائعة' : 'Frequently Asked Questions'}
              </h2>
            </div>

            <div className="space-y-4">
              {faqs.map((faq, index) => (
                <div 
                  key={index}
                  className={cn(
                    "rounded-2xl overflow-hidden transition-all border-2",
                    openFaq === index 
                      ? "bg-[#1d71b8]/5 border-[#1d71b8]/30" 
                      : "bg-white border-gray-200 hover:border-gray-300"
                  )}
                >
                  <button
                    onClick={() => setOpenFaq(openFaq === index ? null : index)}
                    className="w-full flex items-center justify-between p-6 text-start"
                  >
                    <span className="font-bold text-gray-900 text-lg">{faq.question}</span>
                    <div className={cn(
                      "w-10 h-10 rounded-full flex items-center justify-center transition-all",
                      openFaq === index ? "bg-[#1d71b8] rotate-180" : "bg-gray-100"
                    )}>
                      <ChevronDown className={cn(
                        "h-5 w-5 transition-colors",
                        openFaq === index ? "text-white" : "text-gray-500"
                      )} />
                    </div>
                  </button>
                  <div className={cn(
                    "overflow-hidden transition-all duration-300",
                    openFaq === index ? "max-h-96" : "max-h-0"
                  )}>
                    <div className="px-6 pb-6">
                      <p className="text-gray-600 leading-relaxed">{faq.answer}</p>
                    </div>
                  </div>
                </div>
              ))}
            </div>
          </div>
        </div>
      </section>

      {/* Final CTA */}
      <section className="relative py-24 bg-white">
        <div className="container mx-auto px-4">
          <div className="relative max-w-5xl mx-auto overflow-hidden rounded-[3rem]">
            {/* Background */}
            <div className="absolute inset-0 bg-linear-to-r from-[#1d71b8] to-blue-600" />
            <div className="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,var(--tw-gradient-stops))] from-white/20 via-transparent to-transparent" />
            
            {/* Content */}
            <div className="relative px-8 py-16 md:px-16 md:py-24 text-center">
              <div className="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/20 backdrop-blur-sm mb-6">
                <Rocket className="h-4 w-4 text-white" />
                <span className="text-sm text-white font-medium">
                  {locale === 'ar' ? 'عرض محدود' : 'Limited Offer'}
                </span>
              </div>
              
              <h2 className="text-4xl md:text-5xl lg:text-6xl font-black text-white mb-6">
                {locale === 'ar' ? 'مستعد لبدء عملك؟' : 'Ready to Start?'}
              </h2>
              <p className="text-xl text-white/90 mb-10 max-w-2xl mx-auto">
                {locale === 'ar'
                  ? 'انضم إلى مئات الموزعين الناجحين واحصل على خصم 15% على الاشتراك السنوي'
                  : 'Join hundreds of successful resellers and get 15% off on annual subscription'}
              </p>
              
              <div className="flex flex-wrap justify-center gap-4">
                <a 
                  href="#plans" 
                  className="group inline-flex items-center gap-3 px-10 py-5 rounded-2xl bg-white font-bold text-[#1d71b8] hover:bg-gray-50 transition-all hover:scale-105 shadow-xl"
                >
                  {locale === 'ar' ? 'اختر باقتك الآن' : 'Choose Your Plan Now'}
                  <ArrowRight className={cn("h-5 w-5 group-hover:translate-x-1 transition-transform", locale === 'ar' && "rotate-180 group-hover:-translate-x-1")} />
                </a>
              </div>
              
              {/* Trust badges */}
              <div className="mt-12 flex flex-wrap justify-center items-center gap-8 opacity-80">
                {['99.99% Uptime', '24/7 Support', 'Money Back'].map((badge, i) => (
                  <div key={i} className="flex items-center gap-2 text-white text-sm">
                    <Check className="h-4 w-4" />
                    {badge}
                  </div>
                ))}
              </div>
            </div>
          </div>
        </div>
      </section>
    </main>
  );
}
