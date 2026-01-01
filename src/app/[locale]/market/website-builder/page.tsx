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
  Layers,
  ShoppingCart,
  FileText,
  Layout,
  Image,
  Pencil,
  Video,
  Search,
  Users,
} from 'lucide-react';
import { cn } from '@/lib/utils';

// Register GSAP plugins
if (typeof window !== 'undefined') {
  gsap.registerPlugin(ScrollTrigger);
}

// Weebly Plans
const weeblyPlans = [
  {
    id: 'free',
    name: 'Free',
    nameAr: 'مجاني',
    subtitle: { en: 'Try Weebly', ar: 'جرب Weebly' },
    description: {
      en: 'Everything you need to create a website',
      ar: 'كل ما تحتاجه لإنشاء موقع',
    },
    price: 0,
    period: { en: '/mo', ar: '/شهر' },
    popular: false,
    siteFeatures: [
      { en: 'Drag & Drop Builder', ar: 'منشئ السحب والإفلات' },
      { en: 'Unlimited Pages', ar: 'صفحات غير محدودة' },
      { en: 'Contact Forms', ar: 'نماذج الاتصال' },
      { en: 'Basic SEO', ar: 'SEO أساسي' },
    ],
    ecommerceFeatures: [],
    cartLink: 'https://app.progineous.com/store/website-builder/free',
    buttonText: { en: 'Get Started Now', ar: 'ابدأ الآن' },
  },
  {
    id: 'starter',
    name: 'Starter',
    nameAr: 'المبتدئ',
    subtitle: { en: 'Ideal for Personal Use', ar: 'مثالي للاستخدام الشخصي' },
    description: {
      en: 'Perfect for personal websites and portfolios',
      ar: 'مثالي للمواقع الشخصية والمحافظ',
    },
    price: 8.99,
    period: { en: '/mo', ar: '/شهر' },
    popular: false,
    siteFeatures: [
      { en: 'Drag & Drop Builder', ar: 'منشئ السحب والإفلات' },
      { en: 'Unlimited Pages', ar: 'صفحات غير محدودة' },
      { en: 'No Weebly Ads', ar: 'بدون إعلانات Weebly' },
    ],
    ecommerceFeatures: [
      { en: '3% Weebly Transaction Fees', ar: 'رسوم معاملات 3%' },
      { en: 'Up to 10 Products', ar: 'حتى 10 منتجات' },
      { en: 'Checkout on Weebly.com', ar: 'الدفع على Weebly.com' },
    ],
    cartLink: 'https://app.progineous.com/store/website-builder/starter-1',
    buttonText: { en: 'Signup', ar: 'تسجيل' },
  },
  {
    id: 'pro',
    name: 'Pro',
    nameAr: 'احترافي',
    subtitle: { en: 'Ideal for Groups + Organizations', ar: 'مثالي للمجموعات والمنظمات' },
    description: {
      en: 'Advanced features for growing businesses',
      ar: 'ميزات متقدمة للأعمال النامية',
    },
    price: 13.99,
    period: { en: '/mo', ar: '/شهر' },
    popular: true,
    siteFeatures: [
      { en: 'Drag & Drop Builder', ar: 'منشئ السحب والإفلات' },
      { en: 'Unlimited Pages', ar: 'صفحات غير محدودة' },
      { en: 'No Weebly Ads', ar: 'بدون إعلانات Weebly' },
      { en: 'Site Search', ar: 'بحث الموقع' },
      { en: 'Password Protection', ar: 'حماية بكلمة مرور' },
      { en: 'Video Backgrounds', ar: 'خلفيات فيديو' },
      { en: 'HD Video & Audio', ar: 'فيديو وصوت HD' },
      { en: 'Up to 100 Members', ar: 'حتى 100 عضو' },
    ],
    ecommerceFeatures: [
      { en: '3% Weebly Transaction Fees', ar: 'رسوم معاملات 3%' },
      { en: 'Up to 25 Products', ar: 'حتى 25 منتج' },
      { en: 'Checkout on Weebly.com', ar: 'الدفع على Weebly.com' },
    ],
    cartLink: 'https://app.progineous.com/store/website-builder/pro',
    buttonText: { en: 'Signup', ar: 'تسجيل' },
  },
  {
    id: 'business',
    name: 'Business',
    nameAr: 'الأعمال',
    subtitle: { en: 'Ideal for Businesses + Stores', ar: 'مثالي للأعمال والمتاجر' },
    description: {
      en: 'Complete eCommerce solution for small businesses',
      ar: 'حل تجارة إلكترونية كامل للأعمال الصغيرة',
    },
    price: 29.99,
    period: { en: '/mo', ar: '/شهر' },
    popular: false,
    siteFeatures: [
      { en: 'Drag & Drop Builder', ar: 'منشئ السحب والإفلات' },
      { en: 'Unlimited Pages', ar: 'صفحات غير محدودة' },
      { en: 'No Weebly Ads', ar: 'بدون إعلانات Weebly' },
      { en: 'Site Search', ar: 'بحث الموقع' },
      { en: 'Password Protection', ar: 'حماية بكلمة مرور' },
      { en: 'Video Backgrounds', ar: 'خلفيات فيديو' },
      { en: 'HD Video & Audio', ar: 'فيديو وصوت HD' },
      { en: 'Up to 100 Members', ar: 'حتى 100 عضو' },
      { en: 'Membership Registration', ar: 'تسجيل العضوية' },
    ],
    ecommerceFeatures: [
      { en: '0% Weebly Transaction Fees', ar: 'رسوم معاملات 0%' },
      { en: 'Unlimited Products', ar: 'منتجات غير محدودة' },
      { en: 'Checkout on Weebly.com', ar: 'الدفع على Weebly.com' },
      { en: 'Inventory Management', ar: 'إدارة المخزون' },
      { en: 'Coupons', ar: 'كوبونات' },
      { en: 'Tax Calculator', ar: 'حاسبة الضرائب' },
    ],
    cartLink: 'https://app.progineous.com/store/website-builder/business',
    buttonText: { en: 'Signup', ar: 'تسجيل' },
  },
];

// Features
const features = [
  {
    icon: 'https://app.progineous.com/assets/img/marketconnect/weebly/icons/builder.png',
    title: { en: 'Builder', ar: 'المنشئ' },
    description: {
      en: 'Create the perfect website with powerful drag and drop tools',
      ar: 'أنشئ الموقع المثالي بأدوات السحب والإفلات القوية',
    },
  },
  {
    icon: 'https://app.progineous.com/assets/img/marketconnect/weebly/icons/ecommerce.png',
    title: { en: 'E-Commerce', ar: 'التجارة الإلكترونية' },
    description: {
      en: 'Complete e-commerce solution to grow your business online',
      ar: 'حل تجارة إلكترونية كامل لتنمية أعمالك عبر الإنترنت',
    },
  },
  {
    icon: 'https://app.progineous.com/assets/img/marketconnect/weebly/icons/forms.png',
    title: { en: 'Forms', ar: 'النماذج' },
    description: {
      en: 'Create custom contact forms, RSVP lists and surveys',
      ar: 'أنشئ نماذج اتصال مخصصة وقوائم RSVP واستطلاعات',
    },
  },
  {
    icon: 'https://app.progineous.com/assets/img/marketconnect/weebly/icons/templates.png',
    title: { en: 'Templates', ar: 'القوالب' },
    description: {
      en: 'Professionally designed website templates with full customisation',
      ar: 'قوالب مواقع مصممة باحترافية مع تخصيص كامل',
    },
  },
  {
    icon: 'https://app.progineous.com/assets/img/marketconnect/weebly/icons/gallery.png',
    title: { en: 'Photos', ar: 'الصور' },
    description: {
      en: 'Create galleries, slideshows and custom backgrounds',
      ar: 'أنشئ معارض صور وعروض شرائح وخلفيات مخصصة',
    },
  },
  {
    icon: 'https://app.progineous.com/assets/img/marketconnect/weebly/icons/blogging.png',
    title: { en: 'Blogging', ar: 'التدوين' },
    description: {
      en: 'Make an amazing blog in minutes',
      ar: 'أنشئ مدونة رائعة في دقائق',
    },
  },
  {
    icon: 'https://app.progineous.com/assets/img/marketconnect/weebly/icons/video.png',
    title: { en: 'Video', ar: 'الفيديو' },
    description: {
      en: 'Embed video from popular services or host your own',
      ar: 'تضمين فيديو من خدمات شائعة أو استضافة فيديوهاتك',
    },
  },
  {
    icon: 'https://app.progineous.com/assets/img/marketconnect/weebly/icons/seo.png',
    title: { en: 'SEO', ar: 'تحسين محركات البحث' },
    description: {
      en: 'Powerful SEO tools to help search engines find you',
      ar: 'أدوات SEO قوية لمساعدة محركات البحث في العثور عليك',
    },
  },
];

// FAQ Data
const faqs = [
  {
    question: { en: 'Can I create a blog?', ar: 'هل يمكنني إنشاء مدونة؟' },
    answer: {
      en: 'Yes the website builder allows you to include blog functionality.',
      ar: 'نعم، منشئ المواقع يتيح لك تضمين وظائف المدونة.',
    },
  },
  {
    question: { en: 'Will my site be mobile friendly?', ar: 'هل سيكون موقعي متوافقاً مع الجوال؟' },
    answer: {
      en: 'Yes all websites created with the Weebly site builder are optimised for mobile.',
      ar: 'نعم، جميع المواقع المنشأة بـ Weebly محسنة للجوال.',
    },
  },
  {
    question: { en: 'Can I add photos to my website?', ar: 'هل يمكنني إضافة صور لموقعي؟' },
    answer: {
      en: 'Yes, you can add photos to your site, but HD Video and Audio are only available on Pro & Business plans.',
      ar: 'نعم، يمكنك إضافة صور لموقعك، لكن الفيديو والصوت HD متاحان فقط في خطط Pro و Business.',
    },
  },
  {
    question: { en: 'Can I sell products through my site?', ar: 'هل يمكنني بيع منتجات عبر موقعي؟' },
    answer: {
      en: 'Yes eCommerce functionality is included with all plans but the number of products you can offer varies.',
      ar: 'نعم، وظائف التجارة الإلكترونية مضمنة في جميع الخطط لكن عدد المنتجات يختلف.',
    },
  },
  {
    question: { en: 'Can I add forms to my site?', ar: 'هل يمكنني إضافة نماذج لموقعي؟' },
    answer: {
      en: 'Yes the Weebly site builder makes it easy to create contact forms, RSVP lists, surveys and more.',
      ar: 'نعم، منشئ Weebly يسهل إنشاء نماذج الاتصال وقوائم RSVP والاستطلاعات وأكثر.',
    },
  },
  {
    question: { en: 'How do I get my site into search engines?', ar: 'كيف أجعل موقعي يظهر في محركات البحث؟' },
    answer: {
      en: 'All Weebly powered websites include powerful SEO tools to help maximise your search engine ranking.',
      ar: 'جميع مواقع Weebly تتضمن أدوات SEO قوية لتعظيم ترتيبك في محركات البحث.',
    },
  },
  {
    question: { en: 'Are there multiple styles to choose from?', ar: 'هل توجد أنماط متعددة للاختيار منها؟' },
    answer: {
      en: 'Yes there are multiple pre-made templates for you to choose from.',
      ar: 'نعم، توجد قوالب جاهزة متعددة للاختيار منها.',
    },
  },
  {
    question: { en: 'Can I upgrade?', ar: 'هل يمكنني الترقية؟' },
    answer: {
      en: 'Yes you can upgrade at any time. Simply login to your account and choose the upgrade option.',
      ar: 'نعم، يمكنك الترقية في أي وقت. سجل الدخول لحسابك واختر خيار الترقية.',
    },
  },
];

export default function WebsiteBuilderPage() {
  const locale = useLocale();
  const isRTL = locale === 'ar';
  const [expandedFaq, setExpandedFaq] = useState<number | null>(null);
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

  // JSON-LD Structured Data
  const baseUrl = process.env.NEXT_PUBLIC_SITE_URL || 'https://progineous.com';
  
  const serviceSchema = {
    '@context': 'https://schema.org',
    '@type': 'SoftwareApplication',
    name: 'Weebly Website Builder',
    description: isRTL
      ? 'منشئ مواقع سحب وإفلات لإنشاء مواقع احترافية بدون برمجة'
      : 'Drag and drop website builder for creating professional websites without coding',
    applicationCategory: 'DesignApplication',
    operatingSystem: 'Web',
    offers: {
      '@type': 'AggregateOffer',
      lowPrice: '0',
      highPrice: '29.99',
      priceCurrency: 'USD',
      offerCount: weeblyPlans.length,
    },
  };

  const breadcrumbSchema = {
    '@context': 'https://schema.org',
    '@type': 'BreadcrumbList',
    itemListElement: [
      { '@type': 'ListItem', position: 1, name: isRTL ? 'الرئيسية' : 'Home', item: `${baseUrl}/${locale}` },
      { '@type': 'ListItem', position: 2, name: isRTL ? 'السوق' : 'Market', item: `${baseUrl}/${locale}/market` },
      { '@type': 'ListItem', position: 3, name: isRTL ? 'منشئ المواقع' : 'Website Builder', item: `${baseUrl}/${locale}/market/website-builder` },
    ],
  };

  return (
    <main className={cn("min-h-screen bg-white", isRTL && "rtl")}>
      {/* JSON-LD Structured Data */}
      <script type="application/ld+json" dangerouslySetInnerHTML={{ __html: JSON.stringify(serviceSchema) }} />
      <script type="application/ld+json" dangerouslySetInnerHTML={{ __html: JSON.stringify(breadcrumbSchema) }} />

      {/* Hero Section */}
      <section className="relative bg-gradient-to-br from-[#4a90d9] via-[#5a9ee0] to-[#3a80c9] text-white overflow-hidden min-h-[70vh] flex items-center">
        {/* Background Pattern */}
        <div className="absolute inset-0 opacity-10">
          <div className="absolute inset-0" style={{
            backgroundImage: `radial-gradient(circle at 20% 30%, rgba(255, 255, 255, 0.3) 0%, transparent 50%),
                              radial-gradient(circle at 80% 70%, rgba(255, 255, 255, 0.2) 0%, transparent 50%)`,
          }} />
        </div>

        <div className="container mx-auto px-4 py-20 relative z-10">
          <div ref={heroRef} className="max-w-5xl mx-auto">
            <div className="grid md:grid-cols-2 gap-12 items-center">
              <div className="text-center md:text-left">
                {/* Weebly Logo */}
                <div className="mb-6">
                  <img 
                    src="https://app.progineous.com/assets/img/marketconnect/weebly/logo.png" 
                    alt="Weebly" 
                    className="h-10 object-contain mx-auto md:mx-0"
                  />
                </div>

                <h1 className="text-4xl md:text-5xl font-bold mb-4">
                  {isRTL ? 'بناء موقع لم يكن أسهل من ذلك' : 'Building a Website Has Never Been Easier'}
                </h1>
                
                <h2 className="text-xl md:text-2xl text-white/90 mb-6">
                  {isRTL ? 'أنشئ الموقع المثالي بأدوات السحب والإفلات القوية' : 'Create the perfect site with powerful drag and drop tools'}
                </h2>

                <p className="text-white/80 mb-8">
                  {isRTL
                    ? 'منشئ مواقع Weebly بالسحب والإفلات يجعل من السهل إنشاء موقع قوي واحترافي بدون أي مهارات تقنية. أكثر من 40 مليون رائد أعمال وشركة صغيرة استخدموا Weebly لبناء وجودهم على الإنترنت.'
                    : "Weebly's drag and drop website builder makes it easy to create a powerful, professional website without any technical skills. Over 40 million entrepreneurs and small businesses have already used Weebly to build their online presence with a website, blog or store."}
                </p>

                <a
                  href="#plans"
                  className="inline-flex items-center gap-2 px-8 py-4 bg-white text-blue-600 rounded-xl font-semibold hover:bg-blue-50 transition-all shadow-lg"
                >
                  {isRTL ? 'ابدأ الآن' : 'Get Started'}
                  <ArrowRight className={cn("w-5 h-5", isRTL && "rotate-180")} />
                </a>
              </div>

              <div className="hidden md:block">
                <img 
                  src="https://app.progineous.com/assets/img/marketconnect/weebly/dragdropeditor.png" 
                  alt="Weebly Drag & Drop Editor" 
                  className="w-full h-auto rounded-xl shadow-2xl"
                />
              </div>
            </div>
          </div>
        </div>
      </section>

      {/* Features Section */}
      <section className="py-20 bg-gray-50">
        <div className="container mx-auto px-4">
          <div className="text-center mb-12">
            <h2 className="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
              {isRTL ? 'منشئ السحب والإفلات' : 'Drag & Drop Builder'}
            </h2>
            <p className="text-gray-600 max-w-3xl mx-auto">
              {isRTL
                ? 'منشئ السحب والإفلات السهل يتيح لك إنشاء موقع احترافي بدون أي مهارات تقنية. اختر عناصر مختلفة لإضافة صور وخرائط وفيديوهات بسحبها وإفلاتها في مكانها مباشرة من متصفحك.'
                : 'The easy drag & drop builder allows you to create a professional website with no technical skills required. Choose different elements to add photos, maps or videos by just dragging and dropping them into place, right from your web browser.'}
            </p>
          </div>

          <div className="grid md:grid-cols-2 lg:grid-cols-4 gap-6 max-w-6xl mx-auto">
            {features.map((feature, index) => (
              <div
                key={index}
                className="bg-white rounded-xl p-6 shadow-sm hover:shadow-lg transition-shadow text-center"
              >
                <div className="w-16 h-16 mx-auto mb-4">
                  <img 
                    src={feature.icon} 
                    alt="" 
                    className="w-full h-full object-contain"
                  />
                </div>
                <h3 className="font-semibold text-gray-900 mb-2">
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

      {/* Pricing Section */}
      <section id="plans" className="py-20 bg-white">
        <div className="container mx-auto px-4">
          <div className="text-center mb-12">
            <h2 className="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
              {isRTL ? 'اختر خطتك' : 'Choose Your Plan'}
            </h2>
            <p className="text-gray-600 max-w-2xl mx-auto">
              {isRTL
                ? 'خطط لجميع الاحتياجات من المواقع الشخصية إلى المتاجر الإلكترونية'
                : 'Plans for every need from personal websites to eCommerce stores'}
            </p>
          </div>

          <div className="grid md:grid-cols-2 lg:grid-cols-4 gap-6 max-w-7xl mx-auto">
            {weeblyPlans.map((plan) => (
              <div
                key={plan.id}
                className={cn(
                  "bg-white rounded-2xl overflow-hidden transition-all",
                  plan.popular
                    ? "ring-2 ring-blue-500 shadow-xl scale-105"
                    : "border border-gray-200 shadow-sm hover:shadow-lg"
                )}
              >
                {plan.popular && (
                  <div className="bg-blue-500 text-white text-center py-2 text-sm font-semibold">
                    {isRTL ? 'الأكثر شعبية' : 'Most Popular'}
                  </div>
                )}

                <div className="p-6">
                  {plan.price === 0 ? (
                    <div className="text-center mb-4">
                      <span className="text-3xl font-bold text-green-600">FREE!</span>
                    </div>
                  ) : (
                    <div className="text-center mb-4">
                      <span className="text-4xl font-bold text-gray-900">${plan.price}</span>
                      <span className="text-gray-500 text-sm"> USD{isRTL ? plan.period.ar : plan.period.en}</span>
                    </div>
                  )}

                  <h3 className="text-xl font-bold text-center text-gray-900 mb-1">
                    {isRTL ? plan.nameAr : plan.name}
                  </h3>
                  <p className="text-blue-600 text-center text-sm mb-6">
                    {isRTL ? plan.subtitle.ar : plan.subtitle.en}
                  </p>

                  {/* Site Features */}
                  <div className="mb-4">
                    <h4 className="font-semibold text-gray-700 text-sm mb-2">
                      {isRTL ? 'مميزات الموقع' : 'Site Features'}
                    </h4>
                    <ul className="space-y-2">
                      {plan.siteFeatures.map((feature, idx) => (
                        <li key={idx} className="flex items-center gap-2 text-sm text-gray-600">
                          <Check className="w-4 h-4 text-green-500 flex-shrink-0" />
                          {isRTL ? feature.ar : feature.en}
                        </li>
                      ))}
                    </ul>
                  </div>

                  {/* eCommerce Features */}
                  {plan.ecommerceFeatures.length > 0 && (
                    <div className="mb-6">
                      <h4 className="font-semibold text-gray-700 text-sm mb-2">
                        {isRTL ? 'مميزات التجارة الإلكترونية' : 'eCommerce Features'}
                      </h4>
                      <ul className="space-y-2">
                        {plan.ecommerceFeatures.map((feature, idx) => (
                          <li key={idx} className="flex items-center gap-2 text-sm text-gray-600">
                            <Check className="w-4 h-4 text-blue-500 flex-shrink-0" />
                            {isRTL ? feature.ar : feature.en}
                          </li>
                        ))}
                      </ul>
                    </div>
                  )}

                  <a
                    href={plan.cartLink}
                    target="_blank"
                    rel="noopener noreferrer"
                    className={cn(
                      "w-full inline-flex items-center justify-center gap-2 py-3 rounded-xl font-semibold transition-all",
                      plan.popular
                        ? "bg-blue-600 text-white hover:bg-blue-700"
                        : plan.price === 0
                          ? "bg-green-600 text-white hover:bg-green-700"
                          : "bg-gray-100 text-gray-800 hover:bg-gray-200"
                    )}
                  >
                    {isRTL ? plan.buttonText.ar : plan.buttonText.en}
                  </a>
                </div>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* FAQ Section */}
      <section className="py-20 bg-gray-50">
        <div className="container mx-auto px-4">
          <h2 className="text-3xl md:text-4xl font-bold text-center text-gray-900 mb-12">
            {isRTL ? 'الأسئلة الشائعة' : 'Frequently Asked Questions'}
          </h2>

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

      {/* Trust Section */}
      <section className="py-16 bg-white">
        <div className="container mx-auto px-4 text-center">
          <img 
            src="https://app.progineous.com/assets/img/marketconnect/weebly/logo.png" 
            alt="Weebly" 
            className="h-12 mx-auto mb-6"
          />
          <p className="text-xl text-gray-600">
            {isRTL ? 'موثوق به من قبل أكثر من 40,000,000 شخص حول العالم' : 'Trusted by over 40,000,000 people worldwide'}
          </p>
        </div>
      </section>

      {/* CTA Section */}
      <section className="py-16 bg-gradient-to-r from-blue-600 to-blue-700">
        <div className="container mx-auto px-4 text-center">
          <h2 className="text-3xl font-bold text-white mb-4">
            {isRTL ? 'ابدأ بناء موقعك اليوم' : 'Start Building Your Website Today'}
          </h2>
          <p className="text-blue-100 mb-8 max-w-2xl mx-auto">
            {isRTL
              ? 'انضم لملايين المستخدمين الذين يبنون مواقعهم باستخدام Weebly'
              : 'Join millions of users building their websites with Weebly'}
          </p>
          <a
            href="https://app.progineous.com/store/website-builder/free"
            target="_blank"
            rel="noopener noreferrer"
            className="inline-flex items-center gap-2 px-8 py-4 bg-white text-blue-600 rounded-xl font-semibold hover:bg-blue-50 transition-all"
          >
            {isRTL ? 'ابدأ مجاناً' : 'Start for Free'}
            <ArrowRight className={cn("w-5 h-5", isRTL && "rotate-180")} />
          </a>
        </div>
      </section>
    </main>
  );
}
