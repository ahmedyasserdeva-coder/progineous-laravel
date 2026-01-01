'use client';

import { useState, useEffect, useRef } from 'react';
import { useLocale } from 'next-intl';
import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import {
  Mail,
  Shield,
  Clock,
  Headphones,
  Zap,
  RefreshCw,
  CheckCircle,
  Server,
  Lock,
  Users,
  Star,
  ChevronDown,
  ChevronUp,
  Inbox,
  Send,
  FolderOpen,
  Calendar,
  UserCheck,
  ArrowRight,
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
      en: 'Fill out the migration form with your current email provider details.',
      ar: 'املأ نموذج النقل بتفاصيل مزود البريد الحالي.',
    },
    icon: Mail,
  },
  {
    step: 2,
    title: { en: 'Verify Access', ar: 'التحقق من الوصول' },
    description: {
      en: 'Our team will verify access to your email accounts securely.',
      ar: 'سيتحقق فريقنا من الوصول إلى حسابات بريدك بشكل آمن.',
    },
    icon: UserCheck,
  },
  {
    step: 3,
    title: { en: 'Sync & Transfer', ar: 'المزامنة والنقل' },
    description: {
      en: 'We sync and transfer all emails, contacts, and calendars seamlessly.',
      ar: 'نقوم بمزامنة ونقل جميع الرسائل وجهات الاتصال والتقويمات بسلاسة.',
    },
    icon: RefreshCw,
  },
  {
    step: 4,
    title: { en: 'Verification & Go Live', ar: 'التحقق والتفعيل' },
    description: {
      en: 'Verify all data is transferred correctly, then switch to new email.',
      ar: 'التحقق من نقل جميع البيانات بشكل صحيح، ثم التبديل للبريد الجديد.',
    },
    icon: CheckCircle,
  },
];

// Features
const features = [
  {
    title: { en: 'Zero Data Loss', ar: 'بدون فقدان بيانات' },
    description: {
      en: 'All your emails, attachments, and folders are transferred completely.',
      ar: 'يتم نقل جميع رسائلك ومرفقاتك ومجلداتك بالكامل.',
    },
    icon: Shield,
  },
  {
    title: { en: 'Free Migration', ar: 'نقل مجاني' },
    description: {
      en: 'Email migration is completely free when you subscribe to our hosting.',
      ar: 'نقل البريد مجاني بالكامل عند اشتراكك في استضافتنا.',
    },
    icon: RefreshCw,
  },
  {
    title: { en: 'Expert Support', ar: 'دعم متخصص' },
    description: {
      en: 'Our email specialists handle the entire migration process for you.',
      ar: 'متخصصو البريد لدينا يتولون عملية النقل بالكامل.',
    },
    icon: Users,
  },
  {
    title: { en: 'Encrypted Transfer', ar: 'نقل مشفر' },
    description: {
      en: 'All data is encrypted during transfer for maximum security.',
      ar: 'جميع البيانات مشفرة أثناء النقل لأقصى درجات الأمان.',
    },
    icon: Lock,
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
      en: 'Most email migrations are completed within 24-48 hours.',
      ar: 'معظم عمليات نقل البريد تكتمل خلال 24-48 ساعة.',
    },
    icon: Zap,
  },
];

// What We Migrate
const whatWeMigrate = [
  { icon: Inbox, en: 'All Email Messages', ar: 'جميع رسائل البريد' },
  { icon: FolderOpen, en: 'Folders & Labels', ar: 'المجلدات والتصنيفات' },
  { icon: Calendar, en: 'Calendars & Events', ar: 'التقويمات والأحداث' },
  { icon: Users, en: 'Contacts & Address Books', ar: 'جهات الاتصال ودفاتر العناوين' },
  { icon: Send, en: 'Sent & Draft Emails', ar: 'الرسائل المرسلة والمسودات' },
  { icon: Shield, en: 'Email Rules & Filters', ar: 'قواعد وفلاتر البريد' },
];

// FAQs
const faqs = [
  {
    question: { en: 'How long does email migration take?', ar: 'كم تستغرق عملية نقل البريد؟' },
    answer: {
      en: 'Most email migrations are completed within 24-48 hours. Larger mailboxes with thousands of emails may take longer, but we\'ll keep you informed throughout the process.',
      ar: 'معظم عمليات نقل البريد تكتمل خلال 24-48 ساعة. صناديق البريد الكبيرة التي تحتوي على آلاف الرسائل قد تستغرق وقتاً أطول، لكننا سنبقيك على اطلاع طوال العملية.',
    },
  },
  {
    question: { en: 'Will I lose any emails during migration?', ar: 'هل سأفقد أي رسائل أثناء النقل؟' },
    answer: {
      en: 'No! We use advanced synchronization technology that ensures 100% of your emails, folders, contacts, and calendars are transferred without any data loss.',
      ar: 'لا! نستخدم تقنية مزامنة متقدمة تضمن نقل 100% من رسائلك ومجلداتك وجهات اتصالك وتقويماتك بدون أي فقدان للبيانات.',
    },
  },
  {
    question: { en: 'Can I still receive emails during migration?', ar: 'هل يمكنني استقبال رسائل أثناء النقل؟' },
    answer: {
      en: 'Yes! Your current email will continue to work normally during the migration. We only switch DNS after everything is verified and working on the new server.',
      ar: 'نعم! بريدك الحالي سيستمر في العمل بشكل طبيعي أثناء النقل. نقوم بتغيير DNS فقط بعد التحقق من كل شيء وتأكيد عمله على السيرفر الجديد.',
    },
  },
  {
    question: { en: 'What email providers can you migrate from?', ar: 'من أي مزودي بريد يمكنكم النقل؟' },
    answer: {
      en: 'We can migrate from any IMAP/POP3 compatible email provider including Gmail, Outlook, Yahoo, GoDaddy, cPanel email, Zoho, and many more.',
      ar: 'يمكننا النقل من أي مزود بريد متوافق مع IMAP/POP3 بما في ذلك Gmail، Outlook، Yahoo، GoDaddy، بريد cPanel، Zoho، والكثير غيرها.',
    },
  },
  {
    question: { en: 'Is my data secure during migration?', ar: 'هل بياناتي آمنة أثناء النقل؟' },
    answer: {
      en: 'Absolutely! All data transfers are encrypted using TLS/SSL protocols. We never store your passwords and delete all access credentials immediately after migration.',
      ar: 'بالتأكيد! جميع عمليات نقل البيانات مشفرة باستخدام بروتوكولات TLS/SSL. لا نخزن كلمات مرورك أبداً ونحذف جميع بيانات الوصول فور اكتمال النقل.',
    },
  },
];

// Testimonials
const testimonials = [
  {
    name: { en: 'Sara Ahmed', ar: 'سارة أحمد' },
    role: { en: 'Business Owner', ar: 'صاحبة عمل' },
    content: {
      en: 'Migrated 5 email accounts with years of history. Not a single email was lost. Incredible service!',
      ar: 'قمت بنقل 5 حسابات بريد بسنوات من التاريخ. لم تضع رسالة واحدة. خدمة مذهلة!',
    },
    rating: 5,
  },
  {
    name: { en: 'Omar Hassan', ar: 'عمر حسن' },
    role: { en: 'IT Manager', ar: 'مدير تقنية المعلومات' },
    content: {
      en: 'The team handled our company\'s 50+ mailboxes migration flawlessly. Very professional!',
      ar: 'الفريق تعامل مع نقل أكثر من 50 صندوق بريد لشركتنا بشكل مثالي. احترافية عالية!',
    },
    rating: 5,
  },
  {
    name: { en: 'Layla Mahmoud', ar: 'ليلى محمود' },
    role: { en: 'Freelancer', ar: 'مستقلة' },
    content: {
      en: 'I was worried about losing important client emails. They migrated everything perfectly with all folders intact.',
      ar: 'كنت قلقة من فقدان رسائل العملاء المهمة. نقلوا كل شيء بشكل مثالي مع الحفاظ على جميع المجلدات.',
    },
    rating: 5,
  },
];

export default function MigrateEmailPage() {
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
      type: 'email',
      fullName: formData.get('fullName'),
      email: formData.get('email'),
      countryCode: formData.get('countryCode'),
      phone: formData.get('phone'),
      supportPin,
      currentEmail: formData.get('currentEmail'),
      emailProvider: formData.get('emailProvider'),
      emailCount: formData.get('emailCount'),
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
    name: isRTL ? 'خدمة نقل البريد الإلكتروني المجانية' : 'Free Email Migration Service',
    description: isRTL
      ? 'خدمة نقل بريد إلكتروني احترافية مجانية بدون فقدان بيانات مع فريق متخصص'
      : 'Professional free email migration service with zero data loss by specialized team',
    provider: {
      '@type': 'Organization',
      name: 'Pro Gineous',
      url: baseUrl,
    },
    serviceType: 'Email Migration',
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
    name: isRTL ? 'كيفية نقل بريدك الإلكتروني إلى بروجينيوس' : 'How to Migrate Your Email to Pro Gineous',
    description: isRTL ? 'خطوات نقل بريدك بسهولة وأمان' : 'Steps to migrate your email easily and securely',
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
      { '@type': 'ListItem', position: 3, name: isRTL ? 'نقل البريد' : 'Email Migration', item: `${baseUrl}/${locale}/migrate/email` },
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
          <div className="absolute top-20 left-10 w-72 h-72 bg-white rounded-full blur-3xl" />
          <div className="absolute bottom-20 right-10 w-96 h-96 bg-[#00D4AA] rounded-full blur-3xl" />
        </div>
        <div className="absolute inset-0 bg-[radial-gradient(circle_at_1px_1px,rgba(255,255,255,0.15)_1px,transparent_0)] bg-size-[40px_40px]" />

        <div className="container mx-auto px-4 py-20 md:py-28 relative z-10">
          <div className="hero-content max-w-4xl mx-auto text-center">
            <div className="inline-flex items-center gap-2 bg-white/10 backdrop-blur-sm px-4 py-2 rounded-full mb-6">
              <Mail className="w-5 h-5 text-[#00D4AA]" />
              <span className="text-sm font-medium">{isRTL ? 'نقل البريد الإلكتروني' : 'Email Migration'}</span>
            </div>
            
            <h1 className="text-4xl md:text-5xl lg:text-6xl font-bold mb-6">
              {isRTL ? 'انقل بريدك الإلكتروني' : 'Migrate Your Email'}
              <span className="block text-[#00D4AA]">{isRTL ? 'بسهولة وأمان' : 'Safely & Seamlessly'}</span>
            </h1>
            
            <p className="text-xl text-white/80 mb-8 max-w-2xl mx-auto">
              {isRTL
                ? 'نقل احترافي لجميع رسائلك وجهات اتصالك وتقويماتك بدون فقدان أي بيانات'
                : 'Professional migration of all your emails, contacts, and calendars with zero data loss'}
            </p>

            <div className="flex flex-col sm:flex-row gap-4 justify-center">
              <a
                href="#request-form"
                className="inline-flex items-center justify-center gap-2 bg-[#00D4AA] text-black px-8 py-4 rounded-xl font-semibold text-lg hover:bg-[#00E4BA] transition-all duration-300 hover:scale-105"
              >
                {isRTL ? 'ابدأ النقل المجاني' : 'Start Free Migration'}
                <ArrowRight className={cn('w-5 h-5', isRTL && 'rotate-180')} />
              </a>
              <a
                href="#how-it-works"
                className="inline-flex items-center justify-center gap-2 bg-white/10 backdrop-blur-sm text-white px-8 py-4 rounded-xl font-semibold text-lg hover:bg-white/20 transition-all duration-300"
              >
                {isRTL ? 'كيف يعمل؟' : 'How It Works'}
              </a>
            </div>

            {/* Stats */}
            <div className="grid grid-cols-3 gap-8 mt-16 max-w-2xl mx-auto">
              {[
                { value: '50K+', label: { en: 'Emails Migrated', ar: 'بريد تم نقله' } },
                { value: '100%', label: { en: 'Data Preserved', ar: 'بيانات محفوظة' } },
                { value: '24h', label: { en: 'Average Time', ar: 'متوسط الوقت' } },
              ].map((stat, index) => (
                <div key={index} className="text-center">
                  <div className="text-3xl md:text-4xl font-bold text-[#00D4AA]">{stat.value}</div>
                  <div className="text-white/70 text-sm mt-1">{isRTL ? stat.label.ar : stat.label.en}</div>
                </div>
              ))}
            </div>
          </div>
        </div>
      </section>

      {/* How It Works */}
      <section id="how-it-works" className="steps-section py-20 bg-white">
        <div className="container mx-auto px-4">
          <div className="text-center mb-16">
            <span className="inline-block px-4 py-2 bg-[#1d71b8]/10 text-[#1d71b8] rounded-full text-sm font-semibold mb-4">
              {isRTL ? 'خطوات بسيطة' : 'Simple Steps'}
            </span>
            <h2 className="text-3xl md:text-4xl font-bold text-gray-800 mb-4">
              {isRTL ? 'كيف تتم عملية النقل؟' : 'How Email Migration Works'}
            </h2>
            <p className="text-lg text-gray-600 max-w-2xl mx-auto">
              {isRTL
                ? 'أربع خطوات بسيطة لنقل بريدك الإلكتروني بالكامل'
                : 'Four simple steps to migrate your entire email'}
            </p>
          </div>

          <div className="max-w-5xl mx-auto">
            <div className="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
              {migrationSteps.map((step, index) => {
                const Icon = step.icon;
                return (
                  <div
                    key={index}
                    className="step-card relative bg-white rounded-2xl p-6 border-2 border-gray-100 hover:border-[#1d71b8] transition-all duration-300 hover:shadow-xl group"
                  >
                    <div className="absolute -top-4 start-6 w-8 h-8 bg-[#1d71b8] rounded-full flex items-center justify-center text-white font-bold text-sm">
                      {step.step}
                    </div>
                    <div className="w-14 h-14 bg-[#1d71b8]/10 rounded-2xl flex items-center justify-center mb-4 mt-2 group-hover:bg-[#1d71b8] transition-colors">
                      <Icon className="w-7 h-7 text-[#1d71b8] group-hover:text-white transition-colors" />
                    </div>
                    <h3 className="text-lg font-bold text-gray-800 mb-2">
                      {isRTL ? step.title.ar : step.title.en}
                    </h3>
                    <p className="text-gray-600 text-sm">
                      {isRTL ? step.description.ar : step.description.en}
                    </p>
                  </div>
                );
              })}
            </div>
          </div>
        </div>
      </section>

      {/* What We Migrate */}
      <section className="py-20 bg-gray-50">
        <div className="container mx-auto px-4">
          <div className="text-center mb-12">
            <h2 className="text-3xl md:text-4xl font-bold text-gray-800 mb-4">
              {isRTL ? 'ماذا ننقل؟' : 'What We Migrate'}
            </h2>
            <p className="text-lg text-gray-600">
              {isRTL ? 'ننقل كل شيء من بريدك القديم' : 'We migrate everything from your old email'}
            </p>
          </div>

          <div className="max-w-4xl mx-auto grid grid-cols-2 md:grid-cols-3 gap-4">
            {whatWeMigrate.map((item, index) => {
              const Icon = item.icon;
              return (
                <div
                  key={index}
                  className="flex items-center gap-3 bg-white p-4 rounded-xl border border-gray-200 hover:border-[#1d71b8] hover:shadow-md transition-all"
                >
                  <div className="w-10 h-10 bg-[#00D4AA]/10 rounded-lg flex items-center justify-center shrink-0">
                    <Icon className="w-5 h-5 text-[#00D4AA]" />
                  </div>
                  <span className="font-medium text-gray-700">{isRTL ? item.ar : item.en}</span>
                </div>
              );
            })}
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
              {isRTL ? 'لماذا تختارنا لنقل بريدك؟' : 'Why Choose Us for Email Migration?'}
            </h2>
          </div>

          <div className="max-w-6xl mx-auto">
            {/* Main Feature */}
            <div className="relative bg-linear-to-br from-[#1d71b8] to-[#0f4c75] rounded-3xl p-8 md:p-12 mb-8 text-white overflow-hidden">
              <div className="absolute top-0 end-0 w-64 h-64 bg-white/5 rounded-full -translate-y-1/2 translate-x-1/2" />
              
              <div className="relative z-10 grid md:grid-cols-2 gap-8 items-center">
                <div>
                  <div className="inline-flex items-center gap-2 bg-[#00D4AA] text-black px-4 py-2 rounded-full text-sm font-bold mb-6">
                    <Mail className="w-4 h-4" />
                    {isRTL ? 'نقل مجاني 100%' : '100% FREE'}
                  </div>
                  <h3 className="text-2xl md:text-3xl font-bold mb-4">
                    {isRTL ? 'نقل بريد مجاني بالكامل' : 'Completely Free Email Migration'}
                  </h3>
                  <p className="text-white/80 text-lg mb-6">
                    {isRTL
                      ? 'نتولى نقل جميع رسائلك وجهات اتصالك وتقويماتك بدون أي تكلفة عند اشتراكك في خدماتنا.'
                      : 'We handle migrating all your emails, contacts, and calendars at no cost when you subscribe to our services.'}
                  </p>
                  <div className="flex flex-wrap gap-4">
                    <div className="flex items-center gap-2">
                      <CheckCircle className="w-5 h-5 text-[#00D4AA]" />
                      <span>{isRTL ? 'بدون فقدان بيانات' : 'No Data Loss'}</span>
                    </div>
                    <div className="flex items-center gap-2">
                      <CheckCircle className="w-5 h-5 text-[#00D4AA]" />
                      <span>{isRTL ? 'نقل مشفر' : 'Encrypted Transfer'}</span>
                    </div>
                  </div>
                </div>
                <div className="flex justify-center">
                  <div className="relative">
                    <div className="w-48 h-48 md:w-56 md:h-56 bg-white/10 rounded-full flex items-center justify-center backdrop-blur-sm">
                      <div className="w-36 h-36 md:w-44 md:h-44 bg-white/10 rounded-full flex items-center justify-center">
                        <Mail className="w-20 h-20 text-[#00D4AA]" />
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
                  </div>
                );
              })}
            </div>
          </div>
        </div>
      </section>

      {/* Testimonials */}
      <section className="py-20 bg-gray-50">
        <div className="container mx-auto px-4">
          <div className="text-center mb-12">
            <h2 className="text-3xl md:text-4xl font-bold text-gray-800 mb-4">
              {isRTL ? 'ماذا يقول عملاؤنا' : 'What Our Clients Say'}
            </h2>
          </div>

          <div className="max-w-5xl mx-auto grid md:grid-cols-3 gap-6">
            {testimonials.map((testimonial, index) => (
              <div key={index} className="bg-white rounded-2xl p-6 shadow-lg">
                <div className="flex gap-1 mb-4">
                  {[...Array(testimonial.rating)].map((_, i) => (
                    <Star key={i} className="w-5 h-5 fill-yellow-400 text-yellow-400" />
                  ))}
                </div>
                <p className="text-gray-600 mb-4">
                  "{isRTL ? testimonial.content.ar : testimonial.content.en}"
                </p>
                <div>
                  <div className="font-semibold text-gray-800">
                    {isRTL ? testimonial.name.ar : testimonial.name.en}
                  </div>
                  <div className="text-sm text-gray-500">
                    {isRTL ? testimonial.role.ar : testimonial.role.en}
                  </div>
                </div>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* Request Form Section */}
      <section id="request-form" className="py-20 bg-white">
        <div className="container mx-auto px-4">
          <div className="max-w-3xl mx-auto">
            <div className="text-center mb-12">
              <h2 className="text-3xl md:text-4xl font-bold text-gray-800 mb-4">
                {isRTL ? 'طلب نقل البريد المجاني' : 'Request Free Email Migration'}
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

            <form ref={formRef} onSubmit={handleSubmit} className="bg-gray-50 rounded-2xl shadow-xl p-8">
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
                    placeholder="example@email.com"
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
                    ? '⚠️ يجب أن يكون لديك حساب نشط ومشترك في إحدى خطط الاستضافة لدينا لإتمام عملية نقل البريد المجاني.' 
                    : '⚠️ You must have an active account with an active hosting plan to complete the free email migration.'}
                </p>
              </div>

              <div className="mb-6">
                <label className="block text-sm font-medium text-gray-700 mb-2">
                  {isRTL ? 'البريد الإلكتروني الحالي (للنقل)' : 'Current Email (to migrate)'} <span className="text-red-500">*</span>
                </label>
                <input
                  type="email"
                  name="currentEmail"
                  required
                  className="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#1d71b8] focus:border-transparent outline-none transition-all"
                  placeholder="your-email@current-provider.com"
                />
              </div>

              <div className="grid md:grid-cols-2 gap-6 mb-6">
                <div>
                  <label htmlFor="emailProvider" className="block text-sm font-medium text-gray-700 mb-2">
                    {isRTL ? 'مزود البريد الحالي' : 'Current Email Provider'} <span className="text-red-500">*</span>
                  </label>
                  <select 
                    id="emailProvider"
                    name="emailProvider"
                    required
                    title={isRTL ? 'مزود البريد الحالي' : 'Current Email Provider'}
                    className="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#1d71b8] focus:border-transparent outline-none transition-all"
                  >
                    <option value="">{isRTL ? 'اختر مزود البريد...' : 'Select email provider...'}</option>
                    <option value="Gmail">Gmail (Google Workspace)</option>
                    <option value="Outlook">Outlook / Microsoft 365</option>
                    <option value="Yahoo">Yahoo Mail</option>
                    <option value="GoDaddy">GoDaddy Email</option>
                    <option value="cPanel">cPanel Email</option>
                    <option value="Zoho">Zoho Mail</option>
                    <option value="Hostinger">Hostinger Email</option>
                    <option value="Namecheap">Namecheap Email</option>
                    <option value="iCloud">iCloud Mail</option>
                    <option value="ProtonMail">ProtonMail</option>
                    <option value="Other">{isRTL ? 'أخرى (حدد في الملاحظات)' : 'Other (specify in notes)'}</option>
                  </select>
                </div>
                <div>
                  <label htmlFor="emailCount" className="block text-sm font-medium text-gray-700 mb-2">
                    {isRTL ? 'عدد حسابات البريد' : 'Number of Email Accounts'} <span className="text-red-500">*</span>
                  </label>
                  <select 
                    id="emailCount"
                    name="emailCount"
                    required
                    title={isRTL ? 'عدد حسابات البريد' : 'Number of Email Accounts'}
                    className="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#1d71b8] focus:border-transparent outline-none transition-all"
                  >
                    <option value="">{isRTL ? 'اختر...' : 'Select...'}</option>
                    <option value="1">1 {isRTL ? 'حساب' : 'account'}</option>
                    <option value="2-5">2-5 {isRTL ? 'حسابات' : 'accounts'}</option>
                    <option value="6-10">6-10 {isRTL ? 'حسابات' : 'accounts'}</option>
                    <option value="11-25">11-25 {isRTL ? 'حساب' : 'accounts'}</option>
                    <option value="26-50">26-50 {isRTL ? 'حساب' : 'accounts'}</option>
                    <option value="50+">50+ {isRTL ? 'حساب' : 'accounts'}</option>
                  </select>
                </div>
              </div>

              <div className="mb-6">
                <label className="block text-sm font-medium text-gray-700 mb-2">
                  {isRTL ? 'ملاحظات إضافية' : 'Additional Notes'}
                </label>
                <textarea
                  name="notes"
                  rows={4}
                  className="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#1d71b8] focus:border-transparent outline-none transition-all resize-none"
                  placeholder={isRTL ? 'أي معلومات إضافية عن حسابات بريدك...' : 'Any additional information about your email accounts...'}
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
                  isRTL ? 'إرسال طلب نقل البريد' : 'Submit Email Migration Request'
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
      <section className="py-20 bg-gray-50">
        <div className="container mx-auto px-4">
          <div className="max-w-3xl mx-auto">
            <h2 className="text-3xl md:text-4xl font-bold text-center text-gray-800 mb-12">
              {isRTL ? 'الأسئلة الشائعة' : 'Frequently Asked Questions'}
            </h2>

            <div className="space-y-4">
              {faqs.map((faq, index) => (
                <div
                  key={index}
                  className="bg-white rounded-xl border border-gray-200 overflow-hidden"
                >
                  <button
                    onClick={() => setExpandedFaq(expandedFaq === index ? null : index)}
                    className="w-full flex items-center justify-between p-6 text-start hover:bg-gray-50 transition-colors"
                  >
                    <span className="font-semibold text-gray-800">
                      {isRTL ? faq.question.ar : faq.question.en}
                    </span>
                    {expandedFaq === index ? (
                      <ChevronUp className="w-5 h-5 text-[#1d71b8] shrink-0" />
                    ) : (
                      <ChevronDown className="w-5 h-5 text-gray-400 shrink-0" />
                    )}
                  </button>
                  {expandedFaq === index && (
                    <div className="px-6 pb-6 text-gray-600">
                      {isRTL ? faq.answer.ar : faq.answer.en}
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
            {isRTL ? 'جاهز لنقل بريدك الإلكتروني؟' : 'Ready to Migrate Your Email?'}
          </h2>
          <p className="text-xl text-white/80 mb-8 max-w-2xl mx-auto">
            {isRTL
              ? 'ابدأ الآن واحصل على نقل مجاني لجميع حسابات بريدك الإلكتروني'
              : 'Start now and get a free migration for all your email accounts'}
          </p>
          <a
            href="#request-form"
            className="inline-flex items-center gap-2 bg-[#00D4AA] text-black px-8 py-4 rounded-xl font-semibold text-lg hover:bg-[#00E4BA] transition-all duration-300 hover:scale-105"
          >
            {isRTL ? 'طلب نقل مجاني' : 'Request Free Migration'}
            <ArrowRight className={cn('w-5 h-5', isRTL && 'rotate-180')} />
          </a>
        </div>
      </section>
    </div>
  );
}
