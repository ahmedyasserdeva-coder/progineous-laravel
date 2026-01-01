'use client';

import { useState } from 'react';
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
  Mail,
  Calendar,
  FileText,
  Cloud,
  Smartphone,
  Lock,
  Sparkles,
  Monitor,
  X
} from 'lucide-react';
import { cn } from '@/lib/utils';

export default function EmailHostingPage() {
  const locale = useLocale();
  const [billingPeriod, setBillingPeriod] = useState<'monthly' | 'yearly'>('monthly');
  const [openFaq, setOpenFaq] = useState<number | null>(null);
  const [hoveredPlan, setHoveredPlan] = useState<number>(1);

  const plans = [
    {
      name: 'OX App Suite',
      tagline: locale === 'ar' ? 'للأساسيات' : 'Essential',
      monthlyPrice: 1.99,
      yearlyPrice: 1.69,
      mailboxSize: '10 GB',
      cloudStorage: null,
      color: 'from-teal-500 to-emerald-600',
      bgColor: 'bg-teal-50',
      borderColor: 'border-teal-200',
      accentColor: 'text-teal-600',
      iconBg: 'bg-teal-100',
      features: [
        locale === 'ar' ? 'بريد email@your-domain.com' : 'email@your-domain.com',
        locale === 'ar' ? 'صندوق بريد 10 جيجا' : '10GB Mailbox Size',
        locale === 'ar' ? 'بريد ويب كامل المميزات' : 'Full-Featured Webmail',
        locale === 'ar' ? 'دعم الموبايل و Desktop' : 'Mobile & Desktop Access (IMAP)',
        locale === 'ar' ? 'تقويم و جهات اتصال مشتركة' : 'Shared Calendars, Contacts, Tasks',
        'CardDAV & CalDAV',
        locale === 'ar' ? 'أداة الترحيل الذاتي' : 'Self-Service Migration Tool',
      ],
      popular: false,
      baseLink: 'https://app.progineous.com/store/professional-email/ox-app-suite'
    },
    {
      name: 'OX App Suite + Productivity',
      tagline: locale === 'ar' ? 'الأكثر مبيعاً' : 'Most Popular',
      monthlyPrice: 2.99,
      yearlyPrice: 2.54,
      mailboxSize: '25 GB',
      cloudStorage: '25 GB',
      color: 'from-emerald-500 to-green-600',
      bgColor: 'bg-emerald-50',
      borderColor: 'border-emerald-300',
      accentColor: 'text-emerald-600',
      iconBg: 'bg-emerald-100',
      features: [
        locale === 'ar' ? 'بريد email@your-domain.com' : 'email@your-domain.com',
        locale === 'ar' ? 'صندوق بريد 25 جيجا' : '25GB Mailbox Size',
        locale === 'ar' ? 'تخزين سحابي 25 جيجا' : '25GB Cloud File Storage',
        locale === 'ar' ? 'مجموعة Office كاملة' : 'Online Office Suite',
        locale === 'ar' ? 'إنشاء/تحرير Word' : 'Create / Edit Word Docs',
        locale === 'ar' ? 'إنشاء/تحرير Excel' : 'Create / Edit Spreadsheets',
        locale === 'ar' ? 'إنشاء/تحرير PowerPoint' : 'Create / Edit PowerPoint',
        locale === 'ar' ? 'كل مميزات الباقة الأساسية' : 'All Essential Features',
      ],
      popular: true,
      baseLink: 'https://app.progineous.com/store/professional-email/ox-app-suite-productivity'
    }
  ];

  const getPlanLink = (baseLink: string, planIndex: number) => {
    // WHMCS MarketConnect uses specific billing cycle format
    const billingCycle = billingPeriod === 'yearly' ? 'annually' : 'monthly';
    // Try different parameter formats for WHMCS
    return `${baseLink}?billingcycle=${billingCycle}&currency=1`;
  };

  const features = [
    {
      icon: Cloud,
      title: locale === 'ar' ? 'تخزين سحابي' : 'Cloud File Storage',
      description: locale === 'ar' 
        ? 'خزّن وشارك مستنداتك المهمة بأمان في السحابة. مع مساحة تصل إلى 25 جيجا.'
        : 'Store and share your important documents safely in the cloud. With up to 25GB storage.'
    },
    {
      icon: Calendar,
      title: locale === 'ar' ? 'تقويم وجهات اتصال' : 'Calendaring & Contacts',
      description: locale === 'ar'
        ? 'تواصل كالمؤسسات مع التقويم المشترك، ومعالج الجدولة، ودعم iCal!'
        : 'Communicate like an enterprise with shared calendaring, scheduling wizard, iCal support!'
    },
    {
      icon: Mail,
      title: locale === 'ar' ? 'مميزات بريد متعددة' : 'Lots of Email Features',
      description: locale === 'ar'
        ? 'كل مميزات البريد المفضلة: التحويلات، الأسماء المستعارة، الردود التلقائية، الفلاتر وأكثر!'
        : 'Forwarders, Aliases, Auto-Responders, Filters, Signatures, Notifications and more!'
    },
    {
      icon: FileText,
      title: locale === 'ar' ? 'تطبيقات الإنتاجية' : 'Add Productivity Apps!',
      description: locale === 'ar'
        ? 'أنشئ وحرر وشارك مستندات Microsoft Office مثل Word و Excel و PowerPoint.'
        : 'Create, edit and share Microsoft Office docs like Word, Excel and PowerPoint.'
    },
    {
      icon: Globe,
      title: locale === 'ar' ? 'أضف تطبيقاتك' : 'Bring your Apps',
      description: locale === 'ar'
        ? 'أضف خدمات البريد المفضلة بسهولة مثل Gmail و Dropbox و Zoom وأكثر!'
        : 'Easily add your favorite email services and/or apps like Gmail, Dropbox, Zoom and more!'
    },
    {
      icon: Lock,
      title: locale === 'ar' ? 'الخصوصية مهمة' : 'Privacy Matters',
      description: locale === 'ar'
        ? 'لن نقرأ أو نفحص أو نشارك أي من معلوماتك الشخصية أو البريدية مع أي طرف ثالث. أبداً.'
        : 'We will never read, scan or share any of your personal or email information with any 3rd parties. Ever.'
    }
  ];

  const faqs = [
    {
      question: locale === 'ar' ? 'ما التطبيقات المتضمنة في OX App Suite؟' : 'What apps are included in OX App Suite?',
      answer: locale === 'ar' 
        ? 'جميع باقات OX App Suite تتضمن الوصول إلى Webmail والتقويم والمهام ودفتر العناوين. باقة Productivity تضيف OX Drive و OX Documents (نصوص وجداول بيانات وعروض تقديمية).'
        : 'All OX App Suite plans include access to Webmail, Calendar, Tasks and Address Book. The Productivity package adds OX Drive and OX Documents (Text, Spreadsheets and Presentations).'
    },
    {
      question: locale === 'ar' ? 'هل يمكنني إضافة حسابات بريد خارجية؟' : 'Can I add outside email accounts to OX App Suite?',
      answer: locale === 'ar'
        ? 'نعم، OX App Suite يدعم ربط جميع حسابات البريد IMAP الخارجية بما في ذلك Gmail و Yahoo و Outlook.com.'
        : 'Yes, OX App Suite supports connecting all external IMAP email accounts including Gmail, Yahoo and Outlook.com.'
    },
    {
      question: locale === 'ar' ? 'هل يمكنني ترحيل بريدي الحالي؟' : 'Can I migrate my existing email account?',
      answer: locale === 'ar'
        ? 'نعم، نقدم أداة ترحيل ذاتية سهلة الاستخدام. يمكنك الترحيل من Apple iCloud و Gmail و Outlook.com و Yahoo Mail وغيرها.'
        : 'Yes, we offer a self-service migration tool. Migrate from Apple iCloud, Gmail, Outlook.com, Yahoo Mail and more.'
    },
    {
      question: locale === 'ar' ? 'هل يمكنني مزامنة التقويم وجهات الاتصال مع هاتفي؟' : 'Can I sync calendar and contacts with my mobile?',
      answer: locale === 'ar'
        ? 'نعم، OX App Suite يدعم CalDAV و CardDAV بالكامل. ولمستخدمي Android، المزامنة سهلة عبر تطبيق Android Sync المخصص.'
        : 'Yes, OX App Suite fully supports CalDAV and CardDAV. And for Android users, syncing is easy via our dedicated Android Sync App.'
    },
    {
      question: locale === 'ar' ? 'هل يحمي OX App Suite من السبام والفيروسات؟' : 'Does OX App Suite protect against Spam and Viruses?',
      answer: locale === 'ar'
        ? 'نعم! يستخدم OX App Suite تقنية خاصة وشراكات مع بائعين معروفين في صناعة مكافحة السبام للحفاظ على صندوق بريدك نظيفاً وآمناً.'
        : 'Yes! OX App Suite uses proprietary technology and partnerships with well-established vendors in the Anti-Spam industry.'
    },
    {
      question: locale === 'ar' ? 'ما هو OX Drive؟' : 'What is OX Drive (Productivity)?',
      answer: locale === 'ar'
        ? 'OX Drive هو حل تخزين سحابي لتخزين مستنداتك وصورك ووسائطك في السحابة. يمكنك مزامنة ملفاتك مع جميع أجهزتك.'
        : 'OX Drive is an online storage solution to store your documents, photos and media in the cloud. Synchronize your files with all your devices.'
    },
  ];

  const comparisonFeatures = [
    { name: '99.9% Uptime SLA', basic: true, productivity: true },
    { name: locale === 'ar' ? 'حماية متقدمة من الفيروسات والسبام' : 'Premium Anti-Virus & Anti-Spam', basic: true, productivity: true },
    { name: 'email@your-domain.com', basic: true, productivity: true },
    { name: locale === 'ar' ? 'حجم صندوق البريد' : 'Mailbox Size', basic: '10GB', productivity: '25GB' },
    { name: locale === 'ar' ? 'بريد ويب كامل المميزات' : 'Full-Featured Webmail', basic: true, productivity: true },
    { name: locale === 'ar' ? 'دعم الموبايل و Desktop (IMAP)' : 'Mobile & Desktop Access (IMAP)', basic: true, productivity: true },
    { name: locale === 'ar' ? 'تقويم وجهات اتصال ومهام مشتركة' : 'Shared Calendars, Contacts, Tasks', basic: true, productivity: true },
    { name: 'CardDAV & CalDAV', basic: true, productivity: true },
    { name: locale === 'ar' ? 'صفحة بوابة متكاملة' : 'Integrated Portal Page', basic: true, productivity: true },
    { name: locale === 'ar' ? 'أداة الترحيل الذاتي' : 'Self-Service Migration Tool', basic: true, productivity: true },
    { name: locale === 'ar' ? 'تخزين سحابي' : 'Cloud File Storage', basic: false, productivity: '25GB' },
    { name: locale === 'ar' ? 'مجموعة Office أونلاين' : 'Online Office Suite', basic: false, productivity: true },
    { name: locale === 'ar' ? 'إنشاء/تحرير Word' : 'Create / Edit Word Docs', basic: false, productivity: true },
    { name: locale === 'ar' ? 'إنشاء/تحرير جداول البيانات' : 'Create / Edit Spreadsheets', basic: false, productivity: true },
    { name: locale === 'ar' ? 'إنشاء/تحرير PowerPoint' : 'Create / Edit PowerPoint', basic: false, productivity: true },
  ];

  // JSON-LD Structured Data for SEO
  const structuredData = {
    '@context': 'https://schema.org',
    '@type': 'Product',
    name: locale === 'ar' ? 'استضافة بريد إلكتروني OX App Suite' : 'OX App Suite Email Hosting',
    description: locale === 'ar' 
      ? 'بريد إلكتروني احترافي وتطبيقات إنتاجية مع صناديق بريد ضخمة وتخزين سحابي'
      : 'Professional email and productivity apps with huge mailboxes and cloud storage',
    image: 'https://progineous.com/og-email-hosting.png',
    url: `https://progineous.com/${locale}/hosting/email`,
    brand: {
      '@type': 'Brand',
      name: 'Pro Gineous'
    },
    offers: {
      '@type': 'AggregateOffer',
      lowPrice: '1.69',
      highPrice: '2.99',
      priceCurrency: 'USD',
      offerCount: '2',
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
      ratingValue: '4.8',
      reviewCount: '1523',
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
        name: locale === 'ar' ? 'استضافة البريد' : 'Email Hosting',
        item: `https://progineous.com/${locale}/hosting/email`
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
        <div className="absolute -top-40 -right-40 w-150 h-150 rounded-full bg-linear-to-br from-emerald-100 to-teal-100 blur-3xl opacity-60" />
        <div className="absolute top-1/3 -left-40 w-125 h-125 rounded-full bg-linear-to-br from-green-100/50 to-emerald-50 blur-3xl opacity-50" />
        <div className="absolute bottom-0 right-1/4 w-100 h-100 rounded-full bg-linear-to-br from-teal-50 to-cyan-50 blur-3xl opacity-40" />
        
        <div className="absolute inset-0 opacity-[0.02] bg-[linear-gradient(rgba(0,0,0,0.1)_1px,transparent_1px),linear-gradient(90deg,rgba(0,0,0,0.1)_1px,transparent_1px)] bg-size-[60px_60px]" />
      </div>

      {/* Hero Section */}
      <section className="relative pt-32 pb-20 lg:pt-40 lg:pb-32">
        <div className="container mx-auto px-4">
          <div className="grid lg:grid-cols-2 gap-12 items-center">
            <div className="relative z-10">
              {/* Badge */}
              <div className="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-emerald-500/10 border border-emerald-500/20 mb-8">
                <Mail className="h-4 w-4 text-emerald-600" />
                <span className="text-sm text-emerald-600 font-medium">
                  OX App Suite
                </span>
              </div>

              {/* Main Title */}
              <h1 className="text-4xl md:text-5xl lg:text-6xl font-black leading-[1.1] mb-6">
                <span className="block text-gray-900">
                  {locale === 'ar' ? 'بريد إلكتروني قوي' : 'Powerful Email &'}
                </span>
                <span className="block bg-clip-text text-transparent bg-linear-to-r from-emerald-500 via-green-500 to-teal-500">
                  {locale === 'ar' ? 'وتطبيقات إنتاجية' : 'Productivity Apps'}
                </span>
              </h1>

              <p className="text-xl text-gray-600 max-w-xl mb-6 leading-relaxed">
                {locale === 'ar' 
                  ? 'OX App Suite هو بريد إلكتروني قوي وتطبيقات إنتاجية مصممة لأي حجم من الأعمال (والميزانية).'
                  : 'OX App Suite is powerful Email and Productivity Apps built for any-size business (and budget).'}
              </p>

              {/* Key Points */}
              <div className="grid grid-cols-2 gap-4 mb-10">
                <div className="flex items-center gap-2 text-gray-600">
                  <Check className="h-5 w-5 text-green-500" />
                  <span>{locale === 'ar' ? 'بريد احترافي @نطاقك' : 'Professional email@your-domain'}</span>
                </div>
                <div className="flex items-center gap-2 text-gray-600">
                  <Check className="h-5 w-5 text-green-500" />
                  <span>{locale === 'ar' ? 'آمن وموثوق 99.9%' : 'Secure & 99.9% Uptime'}</span>
                </div>
                <div className="flex items-center gap-2 text-gray-600">
                  <Check className="h-5 w-5 text-green-500" />
                  <span>{locale === 'ar' ? 'ويب، موبايل، Desktop' : 'Webmail, Mobile, Desktop'}</span>
                </div>
                <div className="flex items-center gap-2 text-gray-600">
                  <Check className="h-5 w-5 text-green-500" />
                  <span>{locale === 'ar' ? 'صناديق بريد ضخمة' : 'Huge 10GB & 25GB mailboxes'}</span>
                </div>
              </div>

              {/* CTA Buttons */}
              <div className="flex flex-wrap gap-4">
                <a 
                  href="#plans" 
                  className="group relative inline-flex items-center gap-3 px-8 py-4 rounded-2xl bg-linear-to-r from-emerald-500 to-green-600 font-bold text-white overflow-hidden transition-all hover:scale-105 hover:shadow-2xl hover:shadow-emerald-500/30"
                >
                  <span className="relative z-10">{locale === 'ar' ? 'شاهد الأسعار' : 'View Plans & Pricing'}</span>
                  <ArrowRight className={cn("relative z-10 h-5 w-5 transition-transform group-hover:translate-x-1", locale === 'ar' && "rotate-180 group-hover:-translate-x-1")} />
                </a>
                <Link 
                  href="/contact"
                  className="group inline-flex items-center gap-3 px-8 py-4 rounded-2xl bg-white border-2 border-gray-200 font-bold text-gray-700 hover:border-emerald-500/30 hover:bg-emerald-50 transition-all"
                >
                  <Headphones className="h-5 w-5" />
                  {locale === 'ar' ? 'تواصل معنا' : 'Contact Us'}
                </Link>
              </div>
            </div>

            {/* Email Preview */}
            <div className="relative">
              <div className="absolute inset-0 bg-linear-to-r from-emerald-500/20 to-teal-200/30 rounded-3xl blur-2xl" />
              
              <div className="relative bg-white border border-gray-200 rounded-3xl p-6 shadow-2xl shadow-gray-200/50">
                {/* Window controls */}
                <div className="flex items-center gap-2 mb-6">
                  <div className="w-3 h-3 rounded-full bg-red-400" />
                  <div className="w-3 h-3 rounded-full bg-yellow-400" />
                  <div className="w-3 h-3 rounded-full bg-green-400" />
                  <div className="flex-1 mx-4">
                    <div className="bg-gray-100 rounded-lg px-4 py-1.5 text-xs text-gray-500 text-center">
                      mail.yourdomain.com
                    </div>
                  </div>
                </div>

                {/* Email Interface Preview */}
                <div className="space-y-3">
                  {/* Inbox Header */}
                  <div className="flex items-center justify-between p-3 bg-emerald-500/10 rounded-xl">
                    <div className="flex items-center gap-3">
                      <Mail className="h-5 w-5 text-emerald-600" />
                      <span className="font-bold text-gray-900">{locale === 'ar' ? 'صندوق الوارد' : 'Inbox'}</span>
                    </div>
                    <span className="text-sm text-emerald-600 font-semibold bg-emerald-500/10 px-2 py-1 rounded-full">24 {locale === 'ar' ? 'جديد' : 'new'}</span>
                  </div>

                  {/* Email Items */}
                  {[
                    { from: 'Team Pro Gineous', subject: locale === 'ar' ? 'مرحباً بك في OX App Suite!' : 'Welcome to OX App Suite!', time: '2m', unread: true },
                    { from: 'Client Support', subject: locale === 'ar' ? 'تحديث المشروع' : 'Project Update', time: '1h', unread: true },
                    { from: 'Newsletter', subject: locale === 'ar' ? 'نصائح الإنتاجية' : 'Productivity Tips', time: '3h', unread: false },
                  ].map((email, i) => (
                    <div key={i} className={cn(
                      "p-3 rounded-xl border transition-all hover:bg-gray-50",
                      email.unread ? "bg-white border-emerald-500/20" : "bg-gray-50 border-gray-100"
                    )}>
                      <div className="flex items-center justify-between mb-1">
                        <span className={cn("font-medium", email.unread ? "text-gray-900" : "text-gray-500")}>{email.from}</span>
                        <span className="text-xs text-gray-400">{email.time}</span>
                      </div>
                      <p className={cn("text-sm truncate", email.unread ? "text-gray-700" : "text-gray-400")}>{email.subject}</p>
                    </div>
                  ))}
                </div>

                {/* Quick Actions */}
                <div className="flex gap-2 mt-4">
                  {[
                    { icon: Calendar, label: locale === 'ar' ? 'التقويم' : 'Calendar' },
                    { icon: Users, label: locale === 'ar' ? 'جهات الاتصال' : 'Contacts' },
                    { icon: FileText, label: locale === 'ar' ? 'المهام' : 'Tasks' },
                    { icon: Cloud, label: locale === 'ar' ? 'الملفات' : 'Drive' },
                  ].map((action, i) => (
                    <div key={i} className="flex-1 p-3 rounded-xl bg-gray-50 border border-gray-100 text-center hover:bg-emerald-50 hover:border-emerald-500/20 transition-all cursor-pointer">
                      <action.icon className="h-5 w-5 mx-auto mb-1 text-emerald-600" />
                      <span className="text-xs text-gray-600">{action.label}</span>
                    </div>
                  ))}
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

      {/* Expect More Section */}
      <section className="relative py-24 bg-linear-to-br from-emerald-500 via-green-600 to-teal-600 overflow-hidden">
        <div className="absolute inset-0">
          <div className="absolute top-0 left-0 w-96 h-96 bg-white/5 rounded-full blur-3xl -translate-x-1/2 -translate-y-1/2" />
          <div className="absolute bottom-0 right-0 w-125 h-125 bg-green-400/10 rounded-full blur-3xl translate-x-1/3 translate-y-1/3" />
        </div>

        <div className="container mx-auto px-4 relative z-10">
          <div className="grid lg:grid-cols-2 gap-12 items-center">
            {/* Expect More from Email */}
            <div className="text-white">
              <h2 className="text-3xl md:text-5xl font-bold mb-6">
                {locale === 'ar' ? 'توقع المزيد من البريد' : 'Expect More from Email'}
              </h2>
              <div className="space-y-4">
                <div className="flex items-start gap-4 p-4 rounded-2xl bg-white/10 backdrop-blur-sm border border-white/20">
                  <Mail className="h-6 w-6 text-white shrink-0 mt-1" />
                  <div>
                    <h3 className="font-bold mb-1">{locale === 'ar' ? 'بريد احترافي' : 'Professional email@your-domain.com'}</h3>
                    <p className="text-white/70 text-sm">{locale === 'ar' ? 'عنوان بريد إلكتروني باسم نطاقك الخاص' : 'Email address with your own domain name'}</p>
                  </div>
                </div>
                <div className="flex items-start gap-4 p-4 rounded-2xl bg-white/10 backdrop-blur-sm border border-white/20">
                  <Shield className="h-6 w-6 text-white shrink-0 mt-1" />
                  <div>
                    <h3 className="font-bold mb-1">{locale === 'ar' ? 'آمن وموثوق' : 'Secure and reliable; with 99.9% Uptime'}</h3>
                    <p className="text-white/70 text-sm">{locale === 'ar' ? 'ضمان وقت تشغيل 99.9%' : 'SLA guaranteed uptime'}</p>
                  </div>
                </div>
                <div className="flex items-start gap-4 p-4 rounded-2xl bg-white/10 backdrop-blur-sm border border-white/20">
                  <Smartphone className="h-6 w-6 text-white shrink-0 mt-1" />
                  <div>
                    <h3 className="font-bold mb-1">{locale === 'ar' ? 'استخدم من أي مكان' : 'Use Webmail, Mobile or Desktop Apps'}</h3>
                    <p className="text-white/70 text-sm">{locale === 'ar' ? 'مزامنة عبر جميع أجهزتك' : 'Sync across all your devices'}</p>
                  </div>
                </div>
                <div className="flex items-start gap-4 p-4 rounded-2xl bg-white/10 backdrop-blur-sm border border-white/20">
                  <HardDrive className="h-6 w-6 text-white shrink-0 mt-1" />
                  <div>
                    <h3 className="font-bold mb-1">{locale === 'ar' ? 'صناديق بريد ضخمة' : 'Huge 10GB & 25GB mailboxes'}</h3>
                    <p className="text-white/70 text-sm">{locale === 'ar' ? 'مساحة كافية لسنوات قادمة' : 'Plenty of room for years to come'}</p>
                  </div>
                </div>
              </div>
            </div>

            {/* Say Goodbye to Spam */}
            <div className="text-white">
              <h2 className="text-3xl md:text-5xl font-bold mb-6">
                {locale === 'ar' ? 'قل وداعاً للسبام' : 'Say Goodbye to Spam'}
              </h2>
              <div className="bg-white/10 backdrop-blur-sm border border-white/20 rounded-3xl p-8">
                <div className="w-20 h-20 mx-auto mb-6 rounded-2xl bg-white/20 flex items-center justify-center">
                  <Shield className="h-10 w-10 text-white" />
                </div>
                <p className="text-lg text-center text-white/90 leading-relaxed">
                  {locale === 'ar' 
                    ? 'باستخدام الذكاء الاصطناعي وبرنامج الدفاع التنبؤي للبريد الإلكتروني، يعمل OX App Suite على حماية صندوق بريدك من السبام والفيروسات والبرامج الضارة وهجمات التصيد.'
                    : 'Using AI and predictive email defense software, OX App Suite fights to keep your inbox safe from spam, viruses, malware and phishing attacks.'}
                </p>
              </div>
            </div>
          </div>
        </div>
      </section>

      {/* Work Anywhere Section */}
      <section className="relative py-24 bg-white">
        <div className="container mx-auto px-4">
          <div className="text-center mb-16">
            <div className="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-emerald-500/10 border border-emerald-500/20 mb-6">
              <Smartphone className="h-4 w-4 text-emerald-600" />
              <span className="text-sm text-emerald-600 font-medium">
                {locale === 'ar' ? 'اعمل من أي مكان' : 'Work Anywhere'}
              </span>
            </div>
            <h2 className="text-3xl md:text-5xl font-bold mb-4 text-gray-900">
              {locale === 'ar' ? 'مزامنة عبر جميع أجهزتك' : 'Sync Across All Devices'}
            </h2>
            <p className="text-gray-500 text-lg max-w-2xl mx-auto">
              {locale === 'ar' 
                ? 'OX App Suite يتزامن عبر جميع أجهزتك. الوصول من الموبايل و Desktop ليس مشكلة حيث يعمل بسلاسة عبر جميع التطبيقات.'
                : 'OX App Suite syncs across all your devices. Mobile and Desktop access are no problem as it works seamlessly across all native clients.'}
            </p>
          </div>

          {/* Features Grid */}
          <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-6 max-w-6xl mx-auto">
            {features.map((feature, index) => (
              <div 
                key={index}
                className="bg-white border-2 border-gray-200 rounded-3xl p-6 hover:border-emerald-500/30 hover:shadow-xl transition-all group"
              >
                <div className="w-14 h-14 rounded-2xl bg-emerald-500/10 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                  <feature.icon className="h-7 w-7 text-emerald-600" />
                </div>
                <h3 className="font-bold text-gray-900 text-lg mb-2">{feature.title}</h3>
                <p className="text-gray-500 text-sm leading-relaxed">{feature.description}</p>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* Pricing Section */}
      <section id="plans" className="relative py-24 bg-linear-to-b from-gray-50 via-white to-gray-50 overflow-hidden">
        <div className="absolute inset-0">
          <div className="absolute inset-0 bg-[linear-gradient(rgba(16,185,129,0.03)_1px,transparent_1px),linear-gradient(90deg,rgba(16,185,129,0.03)_1px,transparent_1px)] bg-size-[60px_60px]" />
        </div>

        <div className="container mx-auto px-4 relative z-10">
          <div className="text-center mb-12">
            <h2 className="text-3xl md:text-5xl font-bold mb-4 text-gray-900">
              {locale === 'ar' ? 'الأسعار والباقات' : 'Pricing & Plans'}
            </h2>
            <p className="text-gray-500 text-lg mb-8">
              {locale === 'ar' ? 'اختر الباقة المناسبة لعملك' : 'Choose the right plan for your business'}
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

          {/* Pricing Cards */}
          <div className="max-w-4xl mx-auto grid md:grid-cols-2 gap-8">
            {plans.map((plan, index) => (
              <div
                key={plan.name}
                className={cn(
                  "relative bg-white rounded-4xl border-2 overflow-hidden transition-all duration-300",
                  plan.popular 
                    ? "border-emerald-500 shadow-2xl shadow-emerald-500/20 scale-105" 
                    : "border-gray-200 hover:border-gray-300 hover:shadow-xl"
                )}
              >
                {/* Popular Badge */}
                {plan.popular && (
                  <div className="absolute top-0 right-0 bg-linear-to-l from-emerald-500 to-teal-600 text-white text-sm font-bold px-6 py-2 rounded-bl-2xl">
                    <div className="flex items-center gap-2">
                      <Star className="h-4 w-4 fill-current" />
                      {locale === 'ar' ? 'الأكثر مبيعاً' : 'Most Popular'}
                    </div>
                  </div>
                )}

                <div className="p-8">
                  {/* Plan Header */}
                  <div className="mb-6">
                    <div className={cn(
                      "inline-flex items-center gap-2 px-3 py-1 rounded-full text-sm font-bold mb-4 border",
                      index === 0 ? "bg-teal-50 border-teal-200 text-teal-700" : "bg-emerald-500/10 border-emerald-500/20 text-emerald-600"
                    )}>
                      <Sparkles className="h-4 w-4" />
                      {plan.tagline}
                    </div>
                    <h3 className="text-2xl font-black text-gray-900">{plan.name}</h3>
                  </div>

                  {/* Price */}
                  <div className="mb-8">
                    <div className="flex items-baseline gap-1">
                      <span className="text-5xl font-black text-gray-900">
                        ${billingPeriod === 'yearly' ? plan.yearlyPrice : plan.monthlyPrice}
                      </span>
                      <span className="text-gray-500">USD/{locale === 'ar' ? 'شهر/مستخدم' : 'mo/user'}</span>
                    </div>
                    {billingPeriod === 'yearly' && (
                      <div className="mt-2">
                        <span className="text-gray-400 line-through">${plan.monthlyPrice}/mo</span>
                        <span className="ml-2 px-2 py-0.5 rounded-full bg-green-100 text-green-600 text-xs font-bold">
                          {locale === 'ar' ? 'وفر 15%' : 'Save 15%'}
                        </span>
                      </div>
                    )}
                  </div>

                  {/* Key Info */}
                  <div className="grid grid-cols-2 gap-4 mb-8">
                    <div className="bg-gray-50 rounded-xl p-4 text-center">
                      <Mail className="h-6 w-6 mx-auto mb-2 text-emerald-600" />
                      <div className="text-lg font-bold text-gray-900">{plan.mailboxSize}</div>
                      <div className="text-xs text-gray-500">{locale === 'ar' ? 'صندوق البريد' : 'Mailbox'}</div>
                    </div>
                    <div className="bg-gray-50 rounded-xl p-4 text-center">
                      <Cloud className="h-6 w-6 mx-auto mb-2 text-emerald-600" />
                      <div className="text-lg font-bold text-gray-900">{plan.cloudStorage || '—'}</div>
                      <div className="text-xs text-gray-500">{locale === 'ar' ? 'تخزين سحابي' : 'Cloud Storage'}</div>
                    </div>
                  </div>

                  {/* Features */}
                  <div className="space-y-3 mb-8">
                    {plan.features.map((feature, i) => (
                      <div key={i} className="flex items-center gap-3">
                        <div className={cn(
                          "w-6 h-6 rounded-full flex items-center justify-center shrink-0",
                          index === 0 ? "bg-teal-100" : "bg-emerald-500/10"
                        )}>
                          <Check className={cn("h-4 w-4", index === 0 ? "text-teal-600" : "text-emerald-600")} />
                        </div>
                        <span className="text-sm text-gray-600">{feature}</span>
                      </div>
                    ))}
                  </div>

                  {/* CTA */}
                  <a
                    href={getPlanLink(plan.baseLink, index)}
                    target="_blank"
                    rel="noopener noreferrer"
                    className={cn(
                      "w-full inline-flex items-center justify-center gap-3 px-8 py-4 rounded-2xl font-bold transition-all duration-300 group",
                      plan.popular 
                        ? "bg-linear-to-r from-emerald-500 to-teal-600 text-white hover:shadow-xl hover:shadow-emerald-500/30 hover:scale-[1.02]"
                        : "bg-gray-100 text-gray-700 hover:bg-gray-200"
                    )}
                  >
                    {locale === 'ar' ? 'اشتري الآن' : 'Buy Now'}
                    <ArrowRight className={cn("h-5 w-5 group-hover:translate-x-1 transition-transform", locale === 'ar' && "rotate-180")} />
                  </a>
                </div>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* Comparison Table */}
      <section className="relative py-24 bg-white">
        <div className="container mx-auto px-4">
          <div className="text-center mb-12">
            <h2 className="text-3xl md:text-4xl font-bold mb-4 text-gray-900">
              {locale === 'ar' ? 'مقارنة الباقات' : 'Compare Plans'}
            </h2>
          </div>

          <div className="max-w-4xl mx-auto overflow-x-auto">
            <table className="w-full">
              <thead>
                <tr>
                  <th className="text-start p-4 text-gray-500 font-medium">{locale === 'ar' ? 'المميزات' : 'Features'}</th>
                  <th className="p-4 text-center">
                    <div className="font-bold text-gray-900">OX App Suite</div>
                    <div className="text-emerald-600 font-bold">${billingPeriod === 'yearly' ? '1.69' : '1.99'}/mo</div>
                  </th>
                  <th className="p-4 text-center bg-emerald-500/5 rounded-t-2xl">
                    <div className="font-bold text-emerald-600">+ Productivity</div>
                    <div className="text-emerald-600 font-bold">${billingPeriod === 'yearly' ? '2.54' : '2.99'}/mo</div>
                  </th>
                </tr>
              </thead>
              <tbody>
                {comparisonFeatures.map((feature, index) => (
                  <tr key={index} className={index % 2 === 0 ? 'bg-gray-50' : ''}>
                    <td className="p-4 text-gray-700 font-medium">{feature.name}</td>
                    <td className="p-4 text-center">
                      {typeof feature.basic === 'boolean' ? (
                        feature.basic ? (
                          <Check className="h-5 w-5 text-green-500 mx-auto" />
                        ) : (
                          <X className="h-5 w-5 text-gray-300 mx-auto" />
                        )
                      ) : (
                        <span className="font-bold text-gray-900">{feature.basic}</span>
                      )}
                    </td>
                    <td className={cn("p-4 text-center", index % 2 === 0 ? "bg-emerald-500/5" : "bg-emerald-500/10")}>
                      {typeof feature.productivity === 'boolean' ? (
                        feature.productivity ? (
                          <Check className="h-5 w-5 text-green-500 mx-auto" />
                        ) : (
                          <X className="h-5 w-5 text-gray-300 mx-auto" />
                        )
                      ) : (
                        <span className="font-bold text-emerald-600">{feature.productivity}</span>
                      )}
                    </td>
                  </tr>
                ))}
              </tbody>
            </table>
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
                      ? "bg-emerald-500/5 border-emerald-500/30" 
                      : "bg-white border-gray-200 hover:border-gray-300"
                  )}
                >
                  <button
                    onClick={() => setOpenFaq(openFaq === index ? null : index)}
                    className="w-full flex items-center justify-between p-6 text-start"
                  >
                    <span className="font-bold text-gray-900">{faq.question}</span>
                    <div className={cn(
                      "w-10 h-10 rounded-full flex items-center justify-center transition-all shrink-0 ml-4",
                      openFaq === index ? "bg-emerald-500 rotate-180" : "bg-gray-100"
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
            <div className="absolute inset-0 bg-linear-to-r from-emerald-500 to-teal-600" />
            <div className="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,var(--tw-gradient-stops))] from-white/20 via-transparent to-transparent" />
            
            <div className="relative px-8 py-16 md:px-16 md:py-24 text-center">
              <div className="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/20 backdrop-blur-sm mb-6">
                <Mail className="h-4 w-4 text-white" />
                <span className="text-sm text-white font-medium">OX App Suite</span>
              </div>
              
              <h2 className="text-4xl md:text-5xl lg:text-6xl font-black text-white mb-6">
                {locale === 'ar' ? 'ابدأ اليوم!' : 'Get Started Today!'}
              </h2>
              <p className="text-xl text-white/90 mb-10 max-w-2xl mx-auto">
                {locale === 'ar'
                  ? 'بريد إلكتروني احترافي وتطبيقات إنتاجية بأسعار تبدأ من $1.99 فقط'
                  : 'Professional email and productivity apps starting at just $1.99/mo'}
              </p>
              
              <div className="flex flex-wrap justify-center gap-4">
                <a 
                  href="#plans" 
                  className="group inline-flex items-center gap-3 px-10 py-5 rounded-2xl bg-white font-bold text-emerald-600 hover:bg-gray-50 transition-all hover:scale-105 shadow-xl"
                >
                  {locale === 'ar' ? 'اختر باقتك الآن' : 'Choose Your Plan Now'}
                  <ArrowRight className={cn("h-5 w-5 group-hover:translate-x-1 transition-transform", locale === 'ar' && "rotate-180 group-hover:-translate-x-1")} />
                </a>
              </div>
              
              <div className="mt-12 flex flex-wrap justify-center items-center gap-8 opacity-80">
                {['99.9% Uptime', 'Anti-Spam Protection', 'Sync All Devices'].map((badge, i) => (
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

