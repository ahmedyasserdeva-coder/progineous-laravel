'use client';

import { useState, useEffect, useRef } from 'react';
import { useLocale } from 'next-intl';
import { Link } from '@/i18n/routing';
import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import {
  Search,
  Globe,
  Shield,
  Lock,
  RefreshCw,
  ArrowRight,
  Check,
  Sparkles,
  Clock,
  Headphones,
  ChevronDown,
  ChevronUp,
  Zap,
  Server,
  Key,
  FileCheck,
  AlertCircle,
  CheckCircle,
  X,
} from 'lucide-react';
import { cn } from '@/lib/utils';

// Register GSAP plugins
if (typeof window !== 'undefined') {
  gsap.registerPlugin(ScrollTrigger);
}

interface TLDPrice {
  tld: string;
  register: string;
  transfer: string;
  renew: string;
  popular?: boolean;
}

interface TransferCheckResult {
  domain: string;
  transferable: boolean;
  status: string;
  price?: string;
  message?: string;
}

export default function DomainTransferPage() {
  const locale = useLocale();
  const isRTL = locale === 'ar';
  
  const [searchQuery, setSearchQuery] = useState('');
  const [isSearching, setIsSearching] = useState(false);
  const [transferResult, setTransferResult] = useState<TransferCheckResult | null>(null);
  const [showResults, setShowResults] = useState(false);
  const [tldPrices, setTldPrices] = useState<TLDPrice[]>([]);
  const [loadingPrices, setLoadingPrices] = useState(true);
  const [openFaq, setOpenFaq] = useState<number | null>(0);
  const [authCode, setAuthCode] = useState('');
  const [codeCopied, setCodeCopied] = useState(false);
  const [tldSearchQuery, setTldSearchQuery] = useState('');
  const [visibleTldsCount, setVisibleTldsCount] = useState(12);
  
  const heroRef = useRef<HTMLDivElement>(null);
  const stepsRef = useRef<HTMLDivElement>(null);
  const pricingRef = useRef<HTMLDivElement>(null);

  // Fetch TLD pricing from WHMCS API
  useEffect(() => {
    async function fetchPricing() {
      try {
        const response = await fetch('/api/whmcs/domains/pricing');
        
        if (!response.ok) {
          throw new Error('Failed to fetch pricing');
        }

        const data = await response.json();
        
        if (data.pricing) {
          const formattedPrices: TLDPrice[] = [];
          
          for (const [tldKey, tldData] of Object.entries(data.pricing) as [string, any][]) {
            if (tldKey.startsWith('xn--') || /[^\x00-\x7F]/.test(tldKey)) continue;
            
            const transferPrice = tldData.transfer?.['1'] || null;
            const renewPrice = tldData.renew?.['1'] || null;
            const registerPrice = tldData.register?.['1'] || null;
            
            if (transferPrice && parseFloat(transferPrice) > 0) {
              formattedPrices.push({
                tld: `.${tldKey}`,
                register: registerPrice ? `$${parseFloat(registerPrice).toFixed(2)}` : 'N/A',
                transfer: `$${parseFloat(transferPrice).toFixed(2)}`,
                renew: renewPrice ? `$${parseFloat(renewPrice).toFixed(2)}` : 'N/A',
                popular: ['com', 'net', 'org', 'io', 'co'].includes(tldKey),
              });
            }
          }
          
          // Sort: popular first, then by transfer price
          formattedPrices.sort((a, b) => {
            if (a.popular && !b.popular) return -1;
            if (!a.popular && b.popular) return 1;
            const priceA = parseFloat(a.transfer.replace('$', ''));
            const priceB = parseFloat(b.transfer.replace('$', ''));
            return priceA - priceB;
          });
          
          setTldPrices(formattedPrices);
        }
      } catch {
        // Set fallback prices when API is unavailable
        setTldPrices([
          { tld: '.com', register: '$13.06', transfer: '$13.06', renew: '$13.06', popular: true },
          { tld: '.net', register: '$15.02', transfer: '$15.02', renew: '$15.02', popular: true },
          { tld: '.org', register: '$12.64', transfer: '$12.64', renew: '$12.64', popular: true },
          { tld: '.io', register: '$39.99', transfer: '$39.99', renew: '$39.99', popular: true },
          { tld: '.co', register: '$29.99', transfer: '$29.99', renew: '$29.99', popular: true },
          { tld: '.ai', register: '$79.99', transfer: '$79.99', renew: '$79.99' },
          { tld: '.dev', register: '$14.99', transfer: '$14.99', renew: '$14.99' },
          { tld: '.app', register: '$14.99', transfer: '$14.99', renew: '$14.99' },
        ]);
      } finally {
        setLoadingPrices(false);
      }
    }

    fetchPricing();
  }, []);

  // GSAP Animations
  useEffect(() => {
    const ctx = gsap.context(() => {
      if (heroRef.current) {
        gsap.fromTo(
          heroRef.current.querySelectorAll('.hero-animate'),
          { opacity: 0, y: 30 },
          { opacity: 1, y: 0, duration: 0.8, stagger: 0.15, ease: 'power3.out' }
        );
      }
    });

    return () => ctx.revert();
  }, []);

  // Transfer check handler
  const handleTransferCheck = async () => {
    if (!searchQuery.trim()) return;
    
    setIsSearching(true);
    setShowResults(true);
    setTransferResult(null);
    
    try {
      let domain = searchQuery.trim().toLowerCase();
      domain = domain.replace(/^(https?:\/\/)?(www\.)?/, '');
      
      // Check if domain has extension
      if (!domain.includes('.')) {
        domain = `${domain}.com`;
      }
      
      // Call API to check domain status (availability check)
      const response = await fetch(`/api/whmcs/domains/check?domain=${encodeURIComponent(domain)}`);
      const data = await response.json();
      
      // Get transfer price
      const ext = `.${domain.split('.').slice(1).join('.')}`;
      const tldPrice = tldPrices.find(t => t.tld === ext)?.transfer;
      
      if (data.available) {
        // Domain is available - not registered anywhere, so can't be transferred
        setTransferResult({
          domain,
          transferable: false,
          status: 'not_registered',
          message: isRTL 
            ? 'هذا النطاق غير مسجل. هل تريد تسجيله؟'
            : 'This domain is not registered. Would you like to register it?',
        });
      } else {
        // Domain is registered somewhere - check if it's registered with us
        // Try to check if domain exists in our WHMCS
        try {
          const ourDomainsResponse = await fetch(`/api/whmcs/domains/lookup?domain=${encodeURIComponent(domain)}`);
          const ourDomainsData = await ourDomainsResponse.json();
          
          if (ourDomainsData.exists) {
            // Domain is already registered with us
            setTransferResult({
              domain,
              transferable: false,
              status: 'already_with_us',
              message: isRTL
                ? 'هذا النطاق مسجل لدينا بالفعل! لا حاجة للنقل.'
                : 'This domain is already registered with us! No transfer needed.',
            });
          } else {
            // Domain is registered elsewhere - can be transferred
            setTransferResult({
              domain,
              transferable: true,
              status: 'transferable',
              price: tldPrice || '$13.06',
              message: isRTL
                ? 'هذا النطاق مسجل ويمكن نقله إلينا!'
                : 'This domain is registered and can be transferred to us!',
            });
          }
        } catch {
          // If lookup fails, assume domain can be transferred
          setTransferResult({
            domain,
            transferable: true,
            status: 'transferable',
            price: tldPrice || '$13.06',
            message: isRTL
              ? 'هذا النطاق مسجل ويمكن نقله إلينا!'
              : 'This domain is registered and can be transferred to us!',
          });
        }
      }
    } catch (error) {
      console.error('Transfer check error:', error);
      setTransferResult({
        domain: searchQuery,
        transferable: false,
        status: 'error',
        message: isRTL
          ? 'حدث خطأ أثناء التحقق. يرجى المحاولة مرة أخرى.'
          : 'An error occurred while checking. Please try again.',
      });
    } finally {
      setIsSearching(false);
    }
  };

  const handleKeyPress = (e: React.KeyboardEvent) => {
    if (e.key === 'Enter') {
      handleTransferCheck();
    }
  };

  // Transfer steps
  const transferSteps = [
    {
      icon: Key,
      title: isRTL ? 'احصل على رمز النقل' : 'Get Authorization Code',
      description: isRTL
        ? 'اطلب رمز EPP/Auth من مزود الخدمة الحالي'
        : 'Request EPP/Auth code from your current registrar',
    },
    {
      icon: Lock,
      title: isRTL ? 'فك قفل النطاق' : 'Unlock Your Domain',
      description: isRTL
        ? 'تأكد من فك قفل النقل لدى المسجل الحالي'
        : 'Make sure transfer lock is disabled at current registrar',
    },
    {
      icon: FileCheck,
      title: isRTL ? 'أدخل رمز التفويض' : 'Enter Auth Code',
      description: isRTL
        ? 'أدخل رمز التفويض عند إتمام عملية النقل'
        : 'Enter the authorization code during checkout',
    },
    {
      icon: CheckCircle,
      title: isRTL ? 'وافق على النقل' : 'Approve Transfer',
      description: isRTL
        ? 'وافق على طلب النقل عبر البريد الإلكتروني'
        : 'Approve the transfer request via email',
    },
  ];

  // Features
  const features = [
    {
      icon: Clock,
      title: isRTL ? 'نقل سريع' : 'Fast Transfer',
      description: isRTL
        ? 'عملية نقل سريعة تتم خلال 5-7 أيام'
        : 'Quick transfer process completed in 5-7 days',
    },
    {
      icon: RefreshCw,
      title: isRTL ? 'سنة إضافية مجانية' : 'Free Year Extension',
      description: isRTL
        ? 'احصل على سنة إضافية مجانية عند النقل'
        : 'Get a free year added to your domain',
    },
    {
      icon: Shield,
      title: isRTL ? 'حماية WHOIS مجانية' : 'Free WHOIS Privacy',
      description: isRTL
        ? 'حماية خصوصية بياناتك مجاناً مدى الحياة'
        : 'Free lifetime WHOIS privacy protection',
    },
    {
      icon: Headphones,
      title: isRTL ? 'دعم 24/7' : '24/7 Support',
      description: isRTL
        ? 'فريق دعم متخصص لمساعدتك في أي وقت'
        : 'Expert support team available around the clock',
    },
    {
      icon: Zap,
      title: isRTL ? 'بدون توقف' : 'Zero Downtime',
      description: isRTL
        ? 'لا انقطاع في خدمة موقعك أثناء النقل'
        : 'No interruption to your website during transfer',
    },
    {
      icon: Server,
      title: isRTL ? 'إدارة DNS مجانية' : 'Free DNS Management',
      description: isRTL
        ? 'تحكم كامل في سجلات DNS مجاناً'
        : 'Full DNS control at no extra cost',
    },
  ];

  // FAQ
  const faqs = [
    {
      question: isRTL ? 'كم يستغرق نقل النطاق؟' : 'How long does a domain transfer take?',
      answer: isRTL
        ? 'عادة ما يستغرق نقل النطاق من 5 إلى 7 أيام عمل. يمكن تسريع العملية بالموافقة السريعة على طلب النقل عبر البريد الإلكتروني.'
        : 'Domain transfers typically take 5-7 business days. You can speed up the process by quickly approving the transfer request via email.',
    },
    {
      question: isRTL ? 'ما هو رمز التفويض (EPP/Auth Code)؟' : 'What is an EPP/Authorization Code?',
      answer: isRTL
        ? 'رمز التفويض هو كود سري يثبت ملكيتك للنطاق. يمكنك الحصول عليه من مزود الخدمة الحالي من خلال لوحة التحكم أو بالتواصل مع الدعم الفني.'
        : 'An authorization code is a secret code that proves your domain ownership. You can get it from your current registrar through their control panel or by contacting their support.',
    },
    {
      question: isRTL ? 'هل سيتوقف موقعي أثناء النقل؟' : 'Will my website go down during transfer?',
      answer: isRTL
        ? 'لا، لن يتأثر موقعك أثناء عملية النقل. ستستمر جميع الخدمات في العمل بشكل طبيعي طالما أن إعدادات DNS لم تتغير.'
        : 'No, your website will not be affected during the transfer. All services will continue to work normally as long as DNS settings remain unchanged.',
    },
    {
      question: isRTL ? 'هل أحصل على سنة إضافية عند النقل؟' : 'Do I get an extra year when transferring?',
      answer: isRTL
        ? 'نعم! عند نقل نطاقك إلينا، ستحصل على سنة إضافية تضاف إلى تاريخ انتهاء صلاحية نطاقك الحالي.'
        : 'Yes! When you transfer your domain to us, you get an extra year added to your current domain expiration date.',
    },
    {
      question: isRTL ? 'ماذا لو كان نطاقي مقفلاً؟' : 'What if my domain is locked?',
      answer: isRTL
        ? 'يجب فك قفل النطاق قبل بدء عملية النقل. يمكنك فك القفل من لوحة تحكم المسجل الحالي أو بالتواصل مع دعمهم الفني.'
        : 'You need to unlock your domain before initiating the transfer. You can unlock it from your current registrar\'s control panel or by contacting their support.',
    },
  ];

  // JSON-LD Structured Data
  const baseUrl = process.env.NEXT_PUBLIC_SITE_URL || 'https://progineous.com';
  
  const webPageSchema = {
    '@context': 'https://schema.org',
    '@type': 'WebPage',
    name: isRTL ? 'نقل النطاق - بروجينيوس' : 'Domain Transfer - Pro Gineous',
    description: isRTL
      ? 'انقل نطاقك إلى بروجينيوس واحصل على سنة إضافية مجاناً مع حماية WHOIS ودعم 24/7'
      : 'Transfer your domain to Pro Gineous and get a FREE year extension with WHOIS privacy and 24/7 support',
    url: `${baseUrl}/${locale}/domains/transfer`,
    inLanguage: isRTL ? 'ar' : 'en',
    isPartOf: {
      '@type': 'WebSite',
      name: 'Pro Gineous',
      url: baseUrl,
    },
  };

  const serviceSchema = {
    '@context': 'https://schema.org',
    '@type': 'Service',
    name: isRTL ? 'خدمة نقل النطاقات' : 'Domain Transfer Service',
    description: isRTL
      ? 'خدمة نقل نطاقات احترافية مع سنة مجانية إضافية وحماية WHOIS ودعم فني متخصص'
      : 'Professional domain transfer service with free year extension, WHOIS privacy, and expert support',
    provider: {
      '@type': 'Organization',
      name: 'Pro Gineous',
      url: baseUrl,
    },
    serviceType: 'Domain Transfer',
    areaServed: 'Worldwide',
    offers: {
      '@type': 'Offer',
      description: isRTL ? 'نقل نطاق مع سنة مجانية' : 'Domain transfer with free year',
      priceCurrency: 'USD',
      availability: 'https://schema.org/InStock',
    },
    hasOfferCatalog: {
      '@type': 'OfferCatalog',
      name: isRTL ? 'أسعار نقل النطاقات' : 'Domain Transfer Pricing',
      itemListElement: tldPrices.slice(0, 5).map((tld, index) => ({
        '@type': 'Offer',
        itemOffered: {
          '@type': 'Service',
          name: `${tld.tld} ${isRTL ? 'نقل' : 'Transfer'}`,
        },
        price: tld.transfer.replace('$', ''),
        priceCurrency: 'USD',
        position: index + 1,
      })),
    },
  };

  const faqSchema = {
    '@context': 'https://schema.org',
    '@type': 'FAQPage',
    mainEntity: faqs.map((faq) => ({
      '@type': 'Question',
      name: faq.question,
      acceptedAnswer: {
        '@type': 'Answer',
        text: faq.answer,
      },
    })),
  };

  const breadcrumbSchema = {
    '@context': 'https://schema.org',
    '@type': 'BreadcrumbList',
    itemListElement: [
      {
        '@type': 'ListItem',
        position: 1,
        name: isRTL ? 'الرئيسية' : 'Home',
        item: `${baseUrl}/${locale}`,
      },
      {
        '@type': 'ListItem',
        position: 2,
        name: isRTL ? 'النطاقات' : 'Domains',
        item: `${baseUrl}/${locale}/domains`,
      },
      {
        '@type': 'ListItem',
        position: 3,
        name: isRTL ? 'نقل النطاق' : 'Transfer',
        item: `${baseUrl}/${locale}/domains/transfer`,
      },
    ],
  };

  const howToSchema = {
    '@context': 'https://schema.org',
    '@type': 'HowTo',
    name: isRTL ? 'كيفية نقل نطاقك إلى بروجينيوس' : 'How to Transfer Your Domain to Pro Gineous',
    description: isRTL
      ? 'دليل خطوة بخطوة لنقل نطاقك بسهولة'
      : 'Step-by-step guide to transfer your domain easily',
    totalTime: 'P7D',
    estimatedCost: {
      '@type': 'MonetaryAmount',
      currency: 'USD',
      value: '13.06',
    },
    step: transferSteps.map((step, index) => ({
      '@type': 'HowToStep',
      position: index + 1,
      name: step.title,
      text: step.description,
    })),
  };

  return (
    <div className={cn("min-h-screen bg-gray-50", isRTL && "rtl")}>
      {/* JSON-LD Structured Data */}
      <script
        type="application/ld+json"
        dangerouslySetInnerHTML={{ __html: JSON.stringify(webPageSchema) }}
      />
      <script
        type="application/ld+json"
        dangerouslySetInnerHTML={{ __html: JSON.stringify(serviceSchema) }}
      />
      <script
        type="application/ld+json"
        dangerouslySetInnerHTML={{ __html: JSON.stringify(faqSchema) }}
      />
      <script
        type="application/ld+json"
        dangerouslySetInnerHTML={{ __html: JSON.stringify(breadcrumbSchema) }}
      />
      <script
        type="application/ld+json"
        dangerouslySetInnerHTML={{ __html: JSON.stringify(howToSchema) }}
      />

      {/* Hero Section */}
      <section 
        ref={heroRef}
        className="relative min-h-[500px] lg:min-h-[550px] overflow-hidden"
      >
        {/* Background */}
        <div className="absolute inset-0 bg-linear-to-br from-[#0a1628] via-[#0f3460] to-[#1d71b8]" />
        
        {/* Pattern Overlay */}
        <div className="absolute inset-0 opacity-10">
          <div className="absolute inset-0 bg-[radial-gradient(circle_at_2px_2px,white_1px,transparent_0)] bg-size-[40px_40px]"></div>
        </div>
        
        {/* Content */}
        <div className="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10 max-w-6xl">
          <div className="flex flex-col items-center justify-center min-h-[500px] lg:min-h-[550px] py-20 text-center">
            
            {/* Badge */}
            <div className="hero-animate mb-6">
              <span className="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 backdrop-blur-sm text-white text-sm font-medium">
                <Sparkles className="w-4 h-4 text-amber-400" />
                {isRTL ? 'سنة إضافية مجانية عند النقل' : 'Free Year Extension on Transfer'}
              </span>
            </div>
            
            {/* Title */}
            <h1 className="hero-animate text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-4">
              {isRTL ? 'انقل نطاقك إلينا' : 'Transfer Your Domain to Us'}
            </h1>
            
            {/* Subtitle */}
            <p className="hero-animate text-lg text-white/70 max-w-2xl mb-8">
              {isRTL
                ? 'استمتع بخدمات أفضل وأسعار تنافسية. انقل نطاقك بسهولة واحصل على سنة إضافية مجاناً!'
                : 'Enjoy better services and competitive prices. Transfer your domain easily and get a free year extension!'}
            </p>
            
            {/* Search Box */}
            <div className="hero-animate w-full max-w-2xl">
              <div className="bg-white rounded-xl shadow-2xl p-2 flex flex-col sm:flex-row gap-2">
                <div className="flex-1 relative">
                  <Globe className="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" />
                  <input
                    type="text"
                    value={searchQuery}
                    onChange={(e) => setSearchQuery(e.target.value)}
                    onKeyPress={handleKeyPress}
                    placeholder={isRTL ? 'أدخل اسم النطاق الذي تريد نقله...' : 'Enter domain name to transfer...'}
                    className="w-full pl-12 pr-4 py-4 text-gray-900 placeholder:text-gray-400 focus:outline-none rounded-lg"
                    dir="ltr"
                  />
                </div>
                <button
                  onClick={handleTransferCheck}
                  disabled={isSearching || !searchQuery.trim()}
                  className="px-8 py-4 bg-[#1d71b8] hover:bg-[#155a94] text-white font-semibold rounded-lg transition-all disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2"
                >
                  {isSearching ? (
                    <RefreshCw className="w-5 h-5 animate-spin" />
                  ) : (
                    <>
                      <Search className="w-5 h-5" />
                      <span>{isRTL ? 'تحقق' : 'Check'}</span>
                    </>
                  )}
                </button>
              </div>
            </div>
            
            {/* Quick Info */}
            <div className="hero-animate mt-8 flex flex-wrap items-center justify-center gap-6 text-white/60 text-sm">
              <div className="flex items-center gap-2">
                <Check className="w-4 h-4 text-green-400" />
                <span>{isRTL ? 'نقل سريع خلال 5-7 أيام' : 'Fast 5-7 day transfer'}</span>
              </div>
              <div className="flex items-center gap-2">
                <Check className="w-4 h-4 text-green-400" />
                <span>{isRTL ? 'سنة إضافية مجانية' : 'Free year extension'}</span>
              </div>
              <div className="flex items-center gap-2">
                <Check className="w-4 h-4 text-green-400" />
                <span>{isRTL ? 'حماية WHOIS مجانية' : 'Free WHOIS privacy'}</span>
              </div>
            </div>
          </div>
        </div>
        
        {/* Wave */}
        <div className="absolute -bottom-1 left-0 right-0">
          <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg" className="w-full block h-20" preserveAspectRatio="none">
            <path d="M0 120L60 110C120 100 240 80 360 70C480 60 600 60 720 65C840 70 960 80 1080 85C1200 90 1320 90 1380 90L1440 90V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0Z" fill="white"/>
          </svg>
        </div>
      </section>

      {/* Transfer Result Modal */}
      {showResults && (
        <div className="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm">
          <div className="bg-white rounded-2xl shadow-2xl max-w-lg w-full overflow-hidden">
            {/* Header */}
            <div className="flex items-center justify-between p-4 border-b border-gray-100">
              <h3 className="text-lg font-bold text-gray-900">
                {isRTL ? 'نتيجة التحقق' : 'Transfer Check Result'}
              </h3>
              <button 
                onClick={() => setShowResults(false)}
                className="p-2 hover:bg-gray-100 rounded-lg transition-colors"
                aria-label={isRTL ? 'إغلاق' : 'Close'}
              >
                <X className="w-5 h-5 text-gray-500" />
              </button>
            </div>
            
            {/* Content */}
            <div className="p-6">
              {isSearching ? (
                <div className="flex flex-col items-center justify-center py-8">
                  <div className="relative">
                    <div className="absolute inset-0 flex items-center justify-center">
                      <div className="absolute h-16 w-16 animate-ping rounded-full bg-[#1d71b8]/20" />
                    </div>
                    <div className="relative flex h-16 w-16 items-center justify-center">
                      <div className="absolute inset-0 animate-spin rounded-full border-4 border-transparent border-t-[#1d71b8]" />
                      <Search className="h-6 w-6 text-[#1d71b8]" />
                    </div>
                  </div>
                  <p className="mt-4 text-gray-600">
                    {isRTL ? 'جاري التحقق من النطاق...' : 'Checking domain status...'}
                  </p>
                </div>
              ) : transferResult && (
                <div className="text-center">
                  {/* Status Icon */}
                  <div className={cn(
                    "w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4",
                    transferResult.transferable ? "bg-green-100" : 
                    transferResult.status === 'already_with_us' ? "bg-blue-100" :
                    transferResult.status === 'not_registered' ? "bg-amber-100" : "bg-red-100"
                  )}>
                    {transferResult.transferable ? (
                      <CheckCircle className="w-8 h-8 text-green-600" />
                    ) : transferResult.status === 'already_with_us' ? (
                      <Shield className="w-8 h-8 text-blue-600" />
                    ) : transferResult.status === 'not_registered' ? (
                      <AlertCircle className="w-8 h-8 text-amber-600" />
                    ) : (
                      <X className="w-8 h-8 text-red-600" />
                    )}
                  </div>
                  
                  {/* Domain Name */}
                  <p className="text-2xl font-bold text-gray-900 mb-2" dir="ltr">
                    {transferResult.domain}
                  </p>
                  
                  {/* Message */}
                  <p className={cn(
                    "text-sm mb-4",
                    transferResult.transferable ? "text-green-600" : 
                    transferResult.status === 'already_with_us' ? "text-blue-600" :
                    "text-amber-600"
                  )}>
                    {transferResult.message}
                  </p>
                  
                  {/* Already with us - special message */}
                  {transferResult.status === 'already_with_us' && (
                    <div className="bg-blue-50 border border-blue-200 rounded-xl p-4 mb-4">
                      <p className="text-sm text-blue-700">
                        {isRTL 
                          ? '🎉 نطاقك مسجل لدينا بالفعل! يمكنك إدارته من لوحة التحكم.'
                          : '🎉 Your domain is already registered with us! You can manage it from your dashboard.'}
                      </p>
                      <a
                        href="https://app.progineous.com/clientarea.php?action=domains"
                        target="_blank"
                        rel="noopener noreferrer"
                        className="inline-flex items-center gap-2 mt-3 text-sm font-medium text-blue-600 hover:text-blue-700"
                      >
                        {isRTL ? 'إدارة نطاقاتك' : 'Manage Your Domains'}
                        <ArrowRight className={cn("w-4 h-4", isRTL && "rotate-180")} />
                      </a>
                    </div>
                  )}
                  
                  {/* Price */}
                  {transferResult.transferable && transferResult.price && (
                    <div className="bg-gray-50 rounded-xl p-4 mb-4">
                      <p className="text-sm text-gray-500 mb-1">
                        {isRTL ? 'سعر النقل' : 'Transfer Price'}
                      </p>
                      <p className="text-3xl font-bold text-[#1d71b8]">
                        {transferResult.price}
                        <span className="text-base font-normal text-gray-500">/{isRTL ? 'سنة' : 'yr'}</span>
                      </p>
                      <p className="text-xs text-green-600 mt-1">
                        {isRTL ? '+ سنة إضافية مجانية!' : '+ Free year extension!'}
                      </p>
                    </div>
                  )}
                  
                  {/* Auth Code Input */}
                  {transferResult.transferable && (
                    <div className="mb-4">
                      <label className="block text-sm font-medium text-gray-700 mb-2 text-start">
                        {isRTL ? 'رمز التفويض (EPP Code)' : 'Authorization Code (EPP Code)'}
                      </label>
                      <div className="flex gap-2">
                        <input
                          type="text"
                          value={authCode}
                          onChange={(e) => {
                            setAuthCode(e.target.value);
                            setCodeCopied(false);
                          }}
                          placeholder={isRTL ? 'أدخل رمز التفويض...' : 'Enter authorization code...'}
                          className="flex-1 px-4 py-3 border border-gray-200 rounded-lg focus:border-[#1d71b8] focus:outline-none focus:ring-2 focus:ring-[#1d71b8]/20"
                          dir="ltr"
                        />
                        {authCode && (
                          <button
                            type="button"
                            onClick={async () => {
                              try {
                                await navigator.clipboard.writeText(authCode);
                                setCodeCopied(true);
                                setTimeout(() => setCodeCopied(false), 3000);
                              } catch (err) {
                                // Fallback for older browsers
                                const textArea = document.createElement('textarea');
                                textArea.value = authCode;
                                textArea.style.position = 'fixed';
                                textArea.style.left = '-9999px';
                                document.body.appendChild(textArea);
                                textArea.select();
                                document.execCommand('copy');
                                document.body.removeChild(textArea);
                                setCodeCopied(true);
                                setTimeout(() => setCodeCopied(false), 3000);
                              }
                            }}
                            className={cn(
                              "px-4 py-3 rounded-lg font-medium transition-all flex items-center gap-2",
                              codeCopied 
                                ? "bg-green-500 text-white" 
                                : "bg-gray-100 hover:bg-gray-200 text-gray-700"
                            )}
                          >
                            {codeCopied ? (
                              <>
                                <Check className="w-4 h-4" />
                                {isRTL ? 'تم' : 'Copied'}
                              </>
                            ) : (
                              isRTL ? 'نسخ' : 'Copy'
                            )}
                          </button>
                        )}
                      </div>
                      {authCode && (
                        <div className={cn(
                          "mt-2 p-3 rounded-lg border",
                          codeCopied 
                            ? "bg-green-50 border-green-200" 
                            : "bg-amber-50 border-amber-200"
                        )}>
                          <p className={cn(
                            "text-xs",
                            codeCopied ? "text-green-700" : "text-amber-700"
                          )}>
                            {codeCopied 
                              ? (isRTL 
                                  ? '✅ تم نسخ الكود بنجاح! الصقه في حقل "Authorization Code" في الصفحة التالية.'
                                  : '✅ Code copied successfully! Paste it in the "Authorization Code" field on the next page.')
                              : (isRTL 
                                  ? '⚠️ انقر على "نسخ" ثم الصق الكود في الصفحة التالية.'
                                  : '⚠️ Click "Copy" then paste the code on the next page.')}
                          </p>
                        </div>
                      )}
                    </div>
                  )}
                  
                  {/* Actions */}
                  <div className="flex gap-3">
                    {transferResult.transferable ? (
                      <a
                        href={`https://app.progineous.com/cart.php?a=add&domain=transfer&sld=${transferResult.domain.split('.')[0]}&tld=.${transferResult.domain.split('.').slice(1).join('.')}`}
                        target="_blank"
                        rel="noopener noreferrer"
                        onClick={async (e) => {
                          if (authCode) {
                            try {
                              await navigator.clipboard.writeText(authCode);
                            } catch {
                              // Fallback
                              const textArea = document.createElement('textarea');
                              textArea.value = authCode;
                              textArea.style.position = 'fixed';
                              textArea.style.left = '-9999px';
                              document.body.appendChild(textArea);
                              textArea.select();
                              document.execCommand('copy');
                              document.body.removeChild(textArea);
                            }
                          }
                        }}
                        className="flex-1 py-3 bg-[#1d71b8] hover:bg-[#155a94] text-white font-semibold rounded-lg transition-colors flex items-center justify-center gap-2"
                      >
                        {isRTL ? 'انقل الآن' : 'Transfer Now'}
                        <ArrowRight className={cn("w-4 h-4", isRTL && "rotate-180")} />
                      </a>
                    ) : transferResult.status === 'not_registered' ? (
                      <Link
                        href={`/domains?search=${transferResult.domain}`}
                        className="flex-1 py-3 bg-[#1d71b8] hover:bg-[#155a94] text-white font-semibold rounded-lg transition-colors flex items-center justify-center gap-2"
                      >
                        {isRTL ? 'سجّل النطاق' : 'Register Domain'}
                        <ArrowRight className={cn("w-4 h-4", isRTL && "rotate-180")} />
                      </Link>
                    ) : null}
                    <button
                      onClick={() => setShowResults(false)}
                      className="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-lg transition-colors"
                    >
                      {isRTL ? 'إغلاق' : 'Close'}
                    </button>
                  </div>
                </div>
              )}
            </div>
          </div>
        </div>
      )}

      {/* Transfer Steps Section */}
      <section ref={stepsRef} className="py-20 bg-white">
        <div className="container mx-auto px-4 max-w-6xl">
          <div className="text-center mb-12">
            <h2 className="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
              {isRTL ? 'خطوات نقل النطاق' : 'How to Transfer Your Domain'}
            </h2>
            <p className="text-gray-600 max-w-2xl mx-auto">
              {isRTL
                ? 'اتبع هذه الخطوات البسيطة لنقل نطاقك إلينا'
                : 'Follow these simple steps to transfer your domain to us'}
            </p>
          </div>
          
          <div className="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
            {transferSteps.map((step, index) => (
              <div
                key={index}
                className="relative p-6 bg-white border border-gray-200 rounded-2xl hover:border-[#1d71b8]/30 hover:shadow-lg transition-all group"
              >
                {/* Step Number */}
                <div className="absolute -top-3 -right-3 w-8 h-8 bg-[#1d71b8] text-white rounded-full flex items-center justify-center text-sm font-bold">
                  {index + 1}
                </div>
                
                <div className="w-14 h-14 bg-[#1d71b8]/10 rounded-xl flex items-center justify-center mb-4 group-hover:bg-[#1d71b8]/20 transition-colors">
                  <step.icon className="w-7 h-7 text-[#1d71b8]" />
                </div>
                <h3 className="text-lg font-semibold text-gray-900 mb-2">{step.title}</h3>
                <p className="text-gray-600 text-sm">{step.description}</p>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* Transfer Pricing Section */}
      <section ref={pricingRef} className="py-20 bg-gray-50">
        <div className="container mx-auto px-4 max-w-6xl">
          <div className="text-center mb-8">
            <h2 className="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
              {isRTL ? 'أسعار النقل' : 'Transfer Pricing'}
            </h2>
            <p className="text-gray-600 max-w-2xl mx-auto">
              {isRTL
                ? 'أسعار تنافسية لنقل النطاقات مع سنة إضافية مجانية'
                : 'Competitive transfer prices with a free year extension'}
            </p>
          </div>
          
          {/* Search Box */}
          <div className="max-w-md mx-auto mb-8">
            <div className="relative">
              <Search className="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" />
              <input
                type="text"
                value={tldSearchQuery}
                onChange={(e) => {
                  setTldSearchQuery(e.target.value);
                  setVisibleTldsCount(12);
                }}
                placeholder={isRTL ? 'ابحث عن امتداد... (مثال: .com)' : 'Search extension... (e.g. .com)'}
                className="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl focus:border-[#1d71b8] focus:outline-none focus:ring-2 focus:ring-[#1d71b8]/20 bg-white"
              />
            </div>
          </div>
          
          {loadingPrices ? (
            <div className="flex justify-center">
              <RefreshCw className="w-8 h-8 text-[#1d71b8] animate-spin" />
            </div>
          ) : (() => {
            const filteredTlds = tldPrices.filter(tld =>
              tld.tld.toLowerCase().includes(tldSearchQuery.toLowerCase())
            );
            const displayedTlds = filteredTlds.slice(0, visibleTldsCount);
            const hasMore = filteredTlds.length > visibleTldsCount;
            
            return (
              <>
                <div className="overflow-hidden rounded-2xl border border-gray-200 shadow-sm bg-white">
                  <div className="max-h-[600px] overflow-y-auto">
                    <table className="w-full">
                      <thead className="sticky top-0 z-10">
                        <tr className="bg-linear-to-r from-[#1d71b8] to-[#155a94]">
                          <th className="px-6 py-4 text-left text-sm font-semibold text-white">
                            {isRTL ? 'الامتداد' : 'Extension'}
                          </th>
                          <th className="px-6 py-4 text-center text-sm font-semibold text-white">
                            {isRTL ? 'سعر النقل' : 'Transfer Price'}
                          </th>
                          <th className="px-6 py-4 text-center text-sm font-semibold text-white">
                            {isRTL ? 'التجديد' : 'Renewal'}
                          </th>
                        </tr>
                      </thead>
                      <tbody className="divide-y divide-gray-100">
                        {displayedTlds.map((tld, index) => (
                          <tr 
                            key={tld.tld}
                            className={cn(
                              "hover:bg-[#1d71b8]/5 transition-colors",
                              index % 2 === 0 ? "bg-white" : "bg-gray-50/50"
                            )}
                          >
                            <td className="px-6 py-4">
                              <div className="flex items-center gap-3">
                                <span className="text-lg font-bold text-gray-900">{tld.tld}</span>
                                {tld.popular && (
                                  <span className="px-2 py-0.5 bg-[#1d71b8]/10 text-[#1d71b8] text-xs font-bold rounded-full">
                                    {isRTL ? 'شائع' : 'POPULAR'}
                                  </span>
                                )}
                              </div>
                            </td>
                            <td className="px-6 py-4 text-center">
                              <span className="font-semibold text-green-600">{tld.transfer}</span>
                              <span className="text-gray-400 text-sm">/{isRTL ? 'سنة' : 'yr'}</span>
                            </td>
                            <td className="px-6 py-4 text-center text-gray-600">
                              {tld.renew}
                            </td>
                          </tr>
                        ))}
                      </tbody>
                    </table>
                  </div>
                </div>
                
                {/* Show More / Results Info */}
                <div className="mt-6 text-center">
                  {hasMore ? (
                    <button
                      onClick={() => setVisibleTldsCount(prev => prev + 12)}
                      className="px-8 py-3 bg-[#1d71b8] hover:bg-[#155a94] text-white font-semibold rounded-xl transition-colors inline-flex items-center gap-2"
                    >
                      {isRTL ? 'عرض المزيد' : 'Show More'}
                      <ChevronDown className="w-4 h-4" />
                    </button>
                  ) : null}
                  <p className="mt-4 text-sm text-gray-500">
                    {isRTL 
                      ? `عرض ${displayedTlds.length} من ${filteredTlds.length} امتداد`
                      : `Showing ${displayedTlds.length} of ${filteredTlds.length} extensions`}
                  </p>
                </div>
              </>
            );
          })()}
        </div>
      </section>

      {/* Features Section */}
      <section className="py-20 bg-white">
        <div className="container mx-auto px-4 max-w-6xl">
          <div className="text-center mb-12">
            <h2 className="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
              {isRTL ? 'لماذا تنقل إلينا؟' : 'Why Transfer to Us?'}
            </h2>
            <p className="text-gray-600 max-w-2xl mx-auto">
              {isRTL
                ? 'استمتع بمميزات حصرية عند نقل نطاقك إلينا'
                : 'Enjoy exclusive benefits when you transfer your domain to us'}
            </p>
          </div>
          
          <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            {features.map((feature, index) => (
              <div
                key={index}
                className="p-6 bg-white border border-gray-200 rounded-2xl hover:border-[#1d71b8]/30 hover:shadow-lg transition-all group"
              >
                <div className="w-14 h-14 bg-[#1d71b8]/10 rounded-xl flex items-center justify-center mb-4 group-hover:bg-[#1d71b8]/20 transition-colors">
                  <feature.icon className="w-7 h-7 text-[#1d71b8]" />
                </div>
                <h3 className="text-xl font-semibold text-gray-900 mb-2">{feature.title}</h3>
                <p className="text-gray-600">{feature.description}</p>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* FAQ Section */}
      <section className="py-20 bg-gray-50">
        <div className="container mx-auto px-4 max-w-4xl">
          <div className="text-center mb-12">
            <h2 className="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
              {isRTL ? 'الأسئلة الشائعة' : 'Frequently Asked Questions'}
            </h2>
            <p className="text-gray-600">
              {isRTL
                ? 'إجابات على أكثر الأسئلة شيوعاً حول نقل النطاقات'
                : 'Answers to common questions about domain transfers'}
            </p>
          </div>
          
          <div className="space-y-4">
            {faqs.map((faq, index) => (
              <div
                key={index}
                className="bg-white border border-gray-200 rounded-xl overflow-hidden"
              >
                <button
                  onClick={() => setOpenFaq(openFaq === index ? null : index)}
                  className="w-full flex items-center justify-between p-5 text-start hover:bg-gray-50 transition-colors"
                >
                  <span className="font-semibold text-gray-900">{faq.question}</span>
                  {openFaq === index ? (
                    <ChevronUp className="w-5 h-5 text-[#1d71b8] shrink-0" />
                  ) : (
                    <ChevronDown className="w-5 h-5 text-gray-500 shrink-0" />
                  )}
                </button>
                {openFaq === index && (
                  <div className="px-5 pb-5">
                    <p className="text-gray-600">{faq.answer}</p>
                  </div>
                )}
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* CTA Section */}
      <section className="py-20 bg-linear-to-r from-[#1d71b8] to-[#155a94]">
        <div className="container mx-auto px-4 max-w-4xl text-center">
          <h2 className="text-3xl md:text-4xl font-bold text-white mb-4">
            {isRTL ? 'جاهز لنقل نطاقك؟' : 'Ready to Transfer Your Domain?'}
          </h2>
          <p className="text-white/80 mb-8 max-w-2xl mx-auto">
            {isRTL
              ? 'انقل نطاقك الآن واحصل على سنة إضافية مجاناً مع خدمات متميزة'
              : 'Transfer your domain now and get a free year extension with premium services'}
          </p>
          <div className="flex flex-col sm:flex-row gap-4 justify-center">
            <button
              onClick={() => window.scrollTo({ top: 0, behavior: 'smooth' })}
              className="px-8 py-4 bg-white text-[#1d71b8] font-semibold rounded-xl hover:bg-gray-100 transition-colors flex items-center justify-center gap-2"
            >
              {isRTL ? 'ابدأ النقل الآن' : 'Start Transfer Now'}
              <ArrowRight className={cn("w-5 h-5", isRTL && "rotate-180")} />
            </button>
            <Link
              href="/contact"
              className="px-8 py-4 bg-transparent border-2 border-white text-white font-semibold rounded-xl hover:bg-white/10 transition-colors"
            >
              {isRTL ? 'تحدث مع الدعم' : 'Talk to Support'}
            </Link>
          </div>
        </div>
      </section>
    </div>
  );
}
