'use client';

import { useState, useEffect, useRef } from 'react';
import { useTranslations, useLocale } from 'next-intl';
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
  TrendingUp,
  Clock,
  Headphones,
  ChevronDown,
  ChevronUp,
  Zap,
  Server,
  Mail,
  ExternalLink,
  X,
  CheckCircle,
  ShoppingCart,
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
  sale?: boolean;
}

interface DomainSearchResult {
  domain: string;
  available: boolean;
  status?: string;
  price?: string;
}

// Popular TLDs
const POPULAR_TLDS = ['com', 'net', 'org', 'sa', 'info', 'biz', 'co', 'io', 'ai', 'dev'];

export default function DomainsPage() {
  const locale = useLocale();
  const isRTL = locale === 'ar';
  
  const [searchQuery, setSearchQuery] = useState('');
  const [modalSearchQuery, setModalSearchQuery] = useState('');
  const [isSearching, setIsSearching] = useState(false);
  const [searchResults, setSearchResults] = useState<DomainSearchResult[]>([]);
  const [showResults, setShowResults] = useState(false);
  const [searchedDomain, setSearchedDomain] = useState('');
  const [tldPrices, setTldPrices] = useState<TLDPrice[]>([]);
  const [loadingPrices, setLoadingPrices] = useState(true);
  const [openFaq, setOpenFaq] = useState<number | null>(0);
  const [visibleTldsCount, setVisibleTldsCount] = useState(12);
  const [tldSearchQuery, setTldSearchQuery] = useState('');
  
  const heroRef = useRef<HTMLDivElement>(null);
  const pricingRef = useRef<HTMLDivElement>(null);
  const featuresRef = useRef<HTMLDivElement>(null);
  const modalRef = useRef<HTMLDivElement>(null);
  
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
          
          // Extract prices for TLDs
          for (const [tldKey, tldData] of Object.entries(data.pricing) as [string, any][]) {
            // Skip non-standard TLDs (IDN domains)
            if (tldKey.startsWith('xn--') || /[^\x00-\x7F]/.test(tldKey)) continue;
            
            const registerPrice = tldData.register?.['1'] || null;
            const transferPrice = tldData.transfer?.['1'] || null;
            const renewPrice = tldData.renew?.['1'] || null;
            
            if (registerPrice && parseFloat(registerPrice) > 0) {
              formattedPrices.push({
                tld: `.${tldKey}`,
                register: `$${parseFloat(registerPrice).toFixed(2)}`,
                transfer: transferPrice ? `$${parseFloat(transferPrice).toFixed(2)}` : 'N/A',
                renew: renewPrice ? `$${parseFloat(renewPrice).toFixed(2)}` : 'N/A',
                popular: POPULAR_TLDS.includes(tldKey),
                sale: tldData.group === 'sale' || parseFloat(registerPrice) < 5,
              });
            }
          }
          
          // Sort: popular first, then by price
          formattedPrices.sort((a, b) => {
            if (a.popular && !b.popular) return -1;
            if (!a.popular && b.popular) return 1;
            const priceA = parseFloat(a.register.replace('$', ''));
            const priceB = parseFloat(b.register.replace('$', ''));
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
          { tld: '.sa', register: '$45.99', transfer: '$45.99', renew: '$45.99', popular: true },
          { tld: '.io', register: '$39.99', transfer: '$39.99', renew: '$39.99', popular: true },
          { tld: '.ai', register: '$79.99', transfer: '$79.99', renew: '$79.99', popular: true },
          { tld: '.co', register: '$29.99', transfer: '$29.99', renew: '$29.99', popular: true },
          { tld: '.dev', register: '$14.99', transfer: '$14.99', renew: '$14.99', popular: true },
          { tld: '.biz', register: '$1.80', transfer: '$20.22', renew: '$20.22', popular: true, sale: true },
          { tld: '.info', register: '$2.99', transfer: '$19.99', renew: '$19.99', sale: true },
          { tld: '.online', register: '$3.99', transfer: '$35.99', renew: '$35.99', sale: true },
          { tld: '.store', register: '$4.99', transfer: '$45.99', renew: '$45.99', sale: true },
          { tld: '.xyz', register: '$1.99', transfer: '$12.99', renew: '$12.99', sale: true },
          { tld: '.site', register: '$2.99', transfer: '$29.99', renew: '$29.99', sale: true },
          { tld: '.tech', register: '$5.99', transfer: '$45.99', renew: '$45.99', sale: true },
          { tld: '.app', register: '$14.99', transfer: '$14.99', renew: '$14.99' },
          { tld: '.me', register: '$9.99', transfer: '$19.99', renew: '$19.99' },
          { tld: '.us', register: '$8.99', transfer: '$8.99', renew: '$8.99' },
          { tld: '.uk', register: '$7.99', transfer: '$7.99', renew: '$7.99' },
          { tld: '.de', register: '$8.99', transfer: '$8.99', renew: '$8.99' },
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
      // Hero animation
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

  // Domain search handler - checks multiple TLDs via API
  const handleSearch = async (queryOverride?: string) => {
    const query = queryOverride || searchQuery;
    if (!query.trim()) return;
    
    setIsSearching(true);
    setShowResults(true);
    setSearchResults([]);
    setModalSearchQuery(query);
    setSearchQuery(query);
    
    try {
      // Get base domain name (without extension)
      let baseDomain = query.trim().toLowerCase();
      // Remove protocol and www
      baseDomain = baseDomain.replace(/^(https?:\/\/)?(www\.)?/, '');
      if (baseDomain.includes('.')) {
        baseDomain = baseDomain.split('.')[0];
      }
      setSearchedDomain(baseDomain);
      
      // Extensions to check
      const extensions = ['.com', '.net', '.org', '.io', '.co', '.online', '.info', '.biz', '.store', '.tech'];
      
      // Check all extensions in parallel via API
      const results = await Promise.all(
        extensions.map(async (ext) => {
          try {
            const domain = `${baseDomain}${ext}`;
            const response = await fetch(`/api/whmcs/domains/check?domain=${encodeURIComponent(domain)}`);
            const data = await response.json();
            
            // Get price from TLDs list or from API response
            const tldPrice = tldPrices.find(t => t.tld === ext)?.register;
            
            return {
              domain,
              available: data.available || data.status === 'available',
              status: data.status,
              price: data.price || tldPrice || '$9.99'
            };
          } catch {
            return {
              domain: `${baseDomain}${ext}`,
              available: false,
              status: 'error',
              price: '$9.99'
            };
          }
        })
      );
      
      setSearchResults(results);
    } catch (error) {
      console.error('Search error:', error);
      setSearchResults([]);
    } finally {
      setIsSearching(false);
    }
  };

  const handleKeyPress = (e: React.KeyboardEvent) => {
    if (e.key === 'Enter') {
      handleSearch();
    }
  };

  // FAQ data
  const faqs = [
    {
      question: isRTL ? 'ما هو اسم النطاق؟' : 'What is a domain name?',
      answer: isRTL 
        ? 'اسم النطاق هو عنوان موقعك على الإنترنت. إنه ما يكتبه الأشخاص في متصفحهم للوصول إلى موقعك، مثل example.com'
        : 'A domain name is your website\'s address on the internet. It\'s what people type in their browser to reach your site, like example.com',
    },
    {
      question: isRTL ? 'كيف أختار اسم نطاق جيد؟' : 'How do I choose a good domain name?',
      answer: isRTL
        ? 'اختر اسماً قصيراً وسهل التذكر والكتابة. تجنب الأرقام والشرطات. حاول استخدام كلمات مفتاحية ذات صلة بعملك.'
        : 'Choose a name that is short, easy to remember, and easy to type. Avoid numbers and hyphens. Try to use keywords relevant to your business.',
    },
    {
      question: isRTL ? 'كم يستغرق تفعيل النطاق؟' : 'How long does domain activation take?',
      answer: isRTL
        ? 'يتم تفعيل معظم النطاقات فوراً بعد إتمام عملية الشراء. قد يستغرق انتشار DNS حتى 24-48 ساعة.'
        : 'Most domains are activated instantly after purchase. DNS propagation may take up to 24-48 hours.',
    },
    {
      question: isRTL ? 'هل يمكنني نقل نطاقي الحالي إليكم؟' : 'Can I transfer my existing domain to you?',
      answer: isRTL
        ? 'نعم! يمكنك نقل نطاقك الحالي إلينا بسهولة. ستحتاج إلى رمز التفويض (EPP code) من مسجلك الحالي.'
        : 'Yes! You can easily transfer your existing domain to us. You\'ll need the authorization code (EPP code) from your current registrar.',
    },
    {
      question: isRTL ? 'ما هي حماية خصوصية النطاق؟' : 'What is domain privacy protection?',
      answer: isRTL
        ? 'حماية خصوصية النطاق تخفي معلوماتك الشخصية من قاعدة بيانات WHOIS العامة، مما يحميك من البريد المزعج والاحتيال.'
        : 'Domain privacy protection hides your personal information from the public WHOIS database, protecting you from spam and fraud.',
    },
  ];

  // Features data
  const features = [
    {
      icon: Shield,
      title: isRTL ? 'حماية WHOIS مجانية' : 'Free WHOIS Protection',
      description: isRTL 
        ? 'احمِ معلوماتك الشخصية من قاعدة بيانات WHOIS العامة'
        : 'Protect your personal information from the public WHOIS database',
    },
    {
      icon: Lock,
      title: isRTL ? 'قفل النقل' : 'Transfer Lock',
      description: isRTL
        ? 'امنع النقل غير المصرح به لنطاقك'
        : 'Prevent unauthorized transfers of your domain',
    },
    {
      icon: RefreshCw,
      title: isRTL ? 'تجديد تلقائي' : 'Auto-Renewal',
      description: isRTL
        ? 'لا تفقد نطاقك أبداً مع التجديد التلقائي'
        : 'Never lose your domain with automatic renewal',
    },
    {
      icon: Mail,
      title: isRTL ? 'إعادة توجيه البريد' : 'Email Forwarding',
      description: isRTL
        ? 'أنشئ عناوين بريد احترافية لنطاقك'
        : 'Create professional email addresses for your domain',
    },
    {
      icon: Server,
      title: isRTL ? 'إدارة DNS' : 'DNS Management',
      description: isRTL
        ? 'تحكم كامل في سجلات DNS الخاصة بنطاقك'
        : 'Full control over your domain\'s DNS records',
    },
    {
      icon: Headphones,
      title: isRTL ? 'دعم 24/7' : '24/7 Support',
      description: isRTL
        ? 'فريق دعم متخصص متاح على مدار الساعة'
        : 'Expert support team available around the clock',
    },
  ];

  const displayedTlds = tldPrices.slice(0, visibleTldsCount);
  
  // Filter TLDs based on search query
  const filteredTlds = tldSearchQuery.trim() 
    ? tldPrices.filter(tld => 
        tld.tld.toLowerCase().includes(tldSearchQuery.toLowerCase().replace('.', ''))
      )
    : displayedTlds;
  
  // Check if there are more TLDs to show
  const hasMoreTlds = visibleTldsCount < tldPrices.length;

  // Hero features list
  const heroFeatures = [
    { text: isRTL ? 'احصل على نطاق .com مجاني مع خطط الاستضافة السنوية' : 'Get a free .com domain for a year with annual shared hosting plans.' },
    { text: isRTL ? 'حافظ على خصوصية معلوماتك الشخصية على النطاقات المؤهلة' : 'Keep your personal info private on eligible domains.' },
    { text: isRTL ? 'تحكم في إعدادات DNS بدون تكلفة إضافية' : 'Control your DNS settings with zero added cost.' },
    { text: isRTL ? 'دعم فني متاح 24/7' : '24/7 support.' },
    { text: isRTL ? 'انضم لأكثر من 700,000 عميل يثقون بنا' : 'Join the 700,000+ who rely on Progineous.' },
  ];

  // JSON-LD Structured Data for SEO
  const structuredData = {
    '@context': 'https://schema.org',
    '@type': 'WebPage',
    name: isRTL ? 'تسجيل النطاقات - Pro Gineous' : 'Domain Registration - Pro Gineous',
    description: isRTL
      ? 'سجّل نطاقك بأفضل الأسعار. أكثر من 500 امتداد متاح مع حماية WHOIS مجانية ودعم 24/7'
      : 'Register your domain at the best prices. 500+ extensions available with free WHOIS protection and 24/7 support',
    url: `https://progineous.com/${locale}/domains`,
    mainEntity: {
      '@type': 'Service',
      name: isRTL ? 'خدمة تسجيل النطاقات' : 'Domain Registration Service',
      provider: {
        '@type': 'Organization',
        name: 'Pro Gineous',
        url: 'https://progineous.com',
        logo: 'https://progineous.com/logo.png',
        contactPoint: {
          '@type': 'ContactPoint',
          contactType: 'customer service',
          availableLanguage: ['English', 'Arabic'],
          telephone: '+201070798859'
        }
      },
      serviceType: 'Domain Registration',
      areaServed: 'Worldwide',
      hasOfferCatalog: {
        '@type': 'OfferCatalog',
        name: isRTL ? 'أسعار النطاقات' : 'Domain Pricing',
        itemListElement: tldPrices.slice(0, 10).map((tld, index) => ({
          '@type': 'Offer',
          itemOffered: {
            '@type': 'Product',
            name: `${tld.tld} Domain`,
            description: `Register a ${tld.tld} domain`
          },
          price: tld.register.replace('$', ''),
          priceCurrency: 'USD',
          priceValidUntil: new Date(new Date().setFullYear(new Date().getFullYear() + 1)).toISOString().split('T')[0],
          availability: 'https://schema.org/InStock',
          position: index + 1
        }))
      }
    }
  };

  // FAQ Structured Data
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

  // Breadcrumb Structured Data
  const breadcrumbData = {
    '@context': 'https://schema.org',
    '@type': 'BreadcrumbList',
    itemListElement: [
      {
        '@type': 'ListItem',
        position: 1,
        name: isRTL ? 'الرئيسية' : 'Home',
        item: `https://progineous.com/${locale}`
      },
      {
        '@type': 'ListItem',
        position: 2,
        name: isRTL ? 'النطاقات' : 'Domains',
        item: `https://progineous.com/${locale}/domains`
      }
    ]
  };

  return (
    <div className={cn("min-h-screen bg-gray-50", isRTL && "rtl")}>
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
        dangerouslySetInnerHTML={{ __html: JSON.stringify(breadcrumbData) }}
      />
      
      {/* Hero Section - Hosting.com Style */}
      <section 
        ref={heroRef}
        className="relative min-h-[700px] lg:min-h-[800px] xl:min-h-[850px] 2xl:min-h-[900px] overflow-hidden"
      >
        {/* Background - Gradient */}
        <div className="absolute inset-0 bg-linear-to-br from-[#0a1628] via-[#0f3460] to-[#1d71b8]" />
        
        {/* Right side lighter gradient overlay */}
        <div className="absolute inset-0 bg-linear-to-r from-transparent via-transparent to-[#1d71b8]/30" />
        
        {/* Subtle pattern */}
        <div className="absolute inset-0 opacity-5 bg-[radial-gradient(circle_at_1px_1px,white_1px,transparent_0)] bg-size-[40px_40px]" />
        
        <div className="container mx-auto px-4 sm:px-6 lg:px-8 xl:px-12 2xl:px-16 relative z-10 max-w-7xl xl:max-w-350 2xl:max-w-400">
          <div className="grid lg:grid-cols-2 gap-8 lg:gap-12 xl:gap-16 2xl:gap-24 items-center min-h-[700px] lg:min-h-[800px] xl:min-h-[850px] 2xl:min-h-[900px] pt-24 pb-16 lg:pt-32 lg:pb-24 xl:pt-36 xl:pb-28">
            
            {/* Left Content */}
            <div className={cn("max-w-xl xl:max-w-2xl 2xl:max-w-3xl", isRTL && "lg:order-2")}>
              {/* Main Headline */}
              <h1 className="hero-animate text-4xl sm:text-5xl lg:text-6xl xl:text-7xl 2xl:text-8xl font-bold text-white leading-[1.15] mb-6 xl:mb-8">
                {isRTL ? (
                  <>
                    <span className="block">اعثر على نطاقك.</span>
                    <span className="block">اجعله ملكك.</span>
                  </>
                ) : (
                  <>
                    <span className="block">Find your domain.</span>
                    <span className="block">Make it yours.</span>
                  </>
                )}
              </h1>
              
              {/* Subtitle */}
              <p className="hero-animate text-lg xl:text-xl 2xl:text-2xl text-white/70 mb-8 xl:mb-10 leading-relaxed">
                {isRTL 
                  ? 'سواء كنت تبدأ من الصفر أو تتوسع، النطاق المناسب يساعد الناس في العثور عليك، الوثوق بك، وتذكرك.'
                  : "Whether you're starting fresh or scaling up, the right domain helps people find you, trust you, and remember you."}
              </p>
              
              {/* Search Box */}
              <div className="hero-animate mb-6 xl:mb-8">
                <div className="flex items-center bg-white rounded-xl xl:rounded-2xl overflow-hidden shadow-xl">
                  <input
                    type="text"
                    value={searchQuery}
                    onChange={(e) => setSearchQuery(e.target.value)}
                    onKeyPress={handleKeyPress}
                    placeholder={isRTL ? 'اكتب نطاقك المثالي هنا' : 'Type your ideal domain here'}
                    className="flex-1 px-5 py-4 xl:px-6 xl:py-5 2xl:py-6 text-gray-900 text-base xl:text-lg placeholder:text-gray-400 focus:outline-none"
                    dir="ltr"
                  />
                  <button
                    onClick={() => handleSearch()}
                    disabled={isSearching || !searchQuery.trim()}
                    className="px-6 py-4 xl:px-8 xl:py-5 2xl:py-6 bg-[#1d71b8] hover:bg-[#155a94] text-white font-semibold xl:text-lg transition-all disabled:opacity-50 disabled:cursor-not-allowed flex items-center gap-2 m-1.5 xl:m-2 rounded-lg xl:rounded-xl"
                  >
                    {isSearching ? (
                      <RefreshCw className="w-5 h-5 xl:w-6 xl:h-6 animate-spin" />
                    ) : (
                      <span>{isRTL ? 'بحث' : 'Search'}</span>
                    )}
                  </button>
                </div>
              </div>
              
              {/* TLD Badges */}
              <div className="hero-animate flex flex-wrap gap-3 xl:gap-4 mb-10 xl:mb-12">
                {/* .com badge */}
                <div className="flex items-center gap-2 xl:gap-3 bg-[#1d71b8] rounded-lg xl:rounded-xl px-4 py-2.5 xl:px-5 xl:py-3">
                  <span className="text-white font-bold xl:text-lg">.com</span>
                  <div className="text-white text-sm xl:text-base">
                    <div className="font-semibold">{isRTL ? 'مجاني / السنة الأولى' : 'Free / 1st year'}</div>
                    <div className="text-white/70 text-xs xl:text-sm">{isRTL ? 'مع شراء سنتين' : '2-year purchase required'}</div>
                  </div>
                </div>
                
                {/* .net badge */}
                <div className="flex items-center gap-2 xl:gap-3 bg-[#0f3460] rounded-lg xl:rounded-xl px-4 py-2.5 xl:px-5 xl:py-3">
                  <span className="text-white font-bold xl:text-lg">.net</span>
                  <div className="text-white text-sm xl:text-base">
                    <div className="font-semibold">{isRTL ? 'مجاني / السنة الأولى' : 'Free / 1st year'}</div>
                    <div className="text-white/70 text-xs xl:text-sm">{isRTL ? 'مع شراء سنتين' : '2-year purchase required'}</div>
                  </div>
                </div>
                
                {/* .org badge */}
                <div className="flex items-center gap-2 xl:gap-3 bg-white/10 backdrop-blur rounded-lg xl:rounded-xl px-4 py-2.5 xl:px-5 xl:py-3">
                  <span className="text-[#60a5fa] font-bold xl:text-lg">.org</span>
                  <div className="text-white text-sm xl:text-base">
                    <div className="font-semibold">$9.99</div>
                    <div className="text-white/70 text-xs xl:text-sm">{isRTL ? 'للسنة الأولى' : 'for the 1st year'}</div>
                  </div>
                </div>
              </div>
              
              {/* Features List */}
              <div className="hero-animate space-y-3 xl:space-y-4">
                {heroFeatures.map((feature, index) => (
                  <div key={index} className="flex items-start gap-3">
                    <div className="shrink-0 w-5 h-5 xl:w-6 xl:h-6 rounded-full bg-[#1d71b8]/20 flex items-center justify-center mt-0.5">
                      <Check className="w-3 h-3 xl:w-4 xl:h-4 text-[#60a5fa]" />
                    </div>
                    <span className="text-white/80 text-sm xl:text-base 2xl:text-lg">{feature.text}</span>
                  </div>
                ))}
              </div>
            </div>
            
            {/* Right Side - Floating Cards */}
            <div className={cn("relative hidden lg:flex items-center justify-center", isRTL && "lg:order-1")}>
              <div className="relative w-full max-w-md xl:max-w-lg 2xl:max-w-xl">
                {/* Main Domain Card - Top */}
                <div className="hero-animate relative z-20 bg-linear-to-br from-[#1d71b8] to-[#0f3460] rounded-2xl xl:rounded-3xl p-6 xl:p-8 2xl:p-10 shadow-2xl mb-4 xl:mb-6">
                  <div className="inline-flex items-center gap-2 px-3 py-1 xl:px-4 xl:py-1.5 bg-emerald-500 rounded-full text-xs xl:text-sm text-white font-medium mb-4 xl:mb-5">
                    <span className="w-2 h-2 xl:w-2.5 xl:h-2.5 bg-white rounded-full animate-pulse"></span>
                    {isRTL ? 'متاح' : 'Available'}
                  </div>
                  <h3 className="text-3xl xl:text-4xl 2xl:text-5xl font-bold text-white mb-2 xl:mb-3">yourbrand.ai</h3>
                  <p className="text-white/70 text-sm xl:text-base 2xl:text-lg mb-4 xl:mb-5">{isRTL ? 'نطاقات .ai رائجة — تم شراء آخر واحد منذ 4 دقائق' : '.ai domains are hot — last bought 4m ago.'}</p>
                  <button className="flex items-center gap-2 text-white hover:text-white/80 transition-colors text-sm xl:text-base font-medium">
                    <span>+ {isRTL ? 'اجعله ملكك' : 'Make it yours'}</span>
                  </button>
                </div>
                
                {/* Bottom Row - Image + Stats Card */}
                <div className="flex gap-4 xl:gap-5 2xl:gap-6">
                  {/* Person Image Card - Portrait Style */}
                  <div className="hero-animate relative z-10 flex-1 rounded-2xl xl:rounded-3xl overflow-hidden shadow-2xl [animation-delay:0.2s]">
                    <img 
                      src="https://images.unsplash.com/photo-1573497019940-1c28c88b4f3e?w=350&h=450&fit=crop&crop=top" 
                      alt="Professional" 
                      className="w-full h-80 xl:h-96 2xl:h-105 object-cover object-top"
                    />
                    
                    {/* Small Protection Card - Overlay on image */}
                    <div className="absolute bottom-4 right-4 xl:bottom-5 xl:right-5 bg-white rounded-xl xl:rounded-2xl p-3 xl:p-4 shadow-xl max-w-40 xl:max-w-45">
                      <div className="flex items-center gap-2 text-gray-400 text-xs xl:text-sm mb-1">
                        <Shield className="w-3.5 h-3.5 xl:w-4 xl:h-4" />
                        <span>{isRTL ? 'نوصي' : 'We recommend'}</span>
                      </div>
                      <h4 className="text-gray-900 font-bold text-sm xl:text-base mb-1">{isRTL ? 'حماية النطاق' : 'Domain protection'}</h4>
                      <a href="#" className="text-[#1d71b8] text-xs xl:text-sm font-medium hover:underline">{isRTL ? 'اكتشف المزيد' : 'Find out more'} →</a>
                    </div>
                  </div>
                  
                  {/* Stats/Features Card - Vertical */}
                  <div className="hero-animate w-36 xl:w-40 2xl:w-44 bg-linear-to-b from-[#0f3460] to-[#1d71b8]/80 rounded-2xl xl:rounded-3xl p-4 xl:p-5 2xl:p-6 shadow-2xl flex flex-col justify-between [animation-delay:0.3s]">
                    {/* Stat 1 */}
                    <div className="text-center pb-4 xl:pb-5 border-b border-white/10">
                      <div className="text-2xl xl:text-3xl 2xl:text-4xl font-bold text-white">500+</div>
                      <div className="text-white/60 text-xs xl:text-sm">{isRTL ? 'امتداد' : 'TLDs'}</div>
                    </div>
                    
                    {/* Stat 2 */}
                    <div className="text-center py-4 xl:py-5 border-b border-white/10">
                      <div className="text-2xl xl:text-3xl 2xl:text-4xl font-bold text-emerald-400">99.9%</div>
                      <div className="text-white/60 text-xs xl:text-sm">{isRTL ? 'وقت التشغيل' : 'Uptime'}</div>
                    </div>
                    
                    {/* Stat 3 */}
                    <div className="text-center py-4 xl:py-5 border-b border-white/10">
                      <div className="text-2xl xl:text-3xl 2xl:text-4xl font-bold text-white">24/7</div>
                      <div className="text-white/60 text-xs xl:text-sm">{isRTL ? 'دعم' : 'Support'}</div>
                    </div>
                    
                    {/* Stat 4 */}
                    <div className="text-center pt-4 xl:pt-5">
                      <div className="text-2xl xl:text-3xl 2xl:text-4xl font-bold text-amber-400">$1.80</div>
                      <div className="text-white/60 text-xs xl:text-sm">{isRTL ? 'أقل سعر' : 'From'}</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        
        {/* Domain Search Results - Full Screen Slide Up Modal */}
        {showResults && (
          <div 
            ref={modalRef}
            className="fixed inset-x-0 bottom-0 top-18 z-50 bg-white transform transition-transform duration-300 ease-out overflow-hidden rounded-t-3xl shadow-2xl"
          >
            {/* Drag Handle */}
            <div className="flex justify-center py-3 cursor-grab active:cursor-grabbing select-none">
              <div className="w-12 h-1.5 bg-gray-300 rounded-full hover:bg-gray-400 transition-colors" />
            </div>

            {/* Close Button */}
            <button 
              onClick={() => setShowResults(false)}
              className="absolute top-3 right-4 p-2 rounded-full hover:bg-gray-100 transition-colors z-10"
              title={isRTL ? 'إغلاق' : 'Close'}
            >
              <X className="h-6 w-6 text-gray-500" />
            </button>

            {/* Title */}
            <div className="text-center pb-4 border-b border-gray-100">
              <h2 className="text-xl font-bold text-gray-900">
                {isRTL ? 'بحث عن اسم النطاق' : 'Domain Name Search'}
              </h2>
            </div>

            {/* Search Input in Modal */}
            <div className="px-4 py-4 border-b border-gray-100">
              <div className="mx-auto max-w-xl relative">
                <Search className="absolute left-4 top-1/2 -translate-y-1/2 h-5 w-5 text-gray-400" />
                <input
                  type="text"
                  value={modalSearchQuery}
                  onChange={(e) => setModalSearchQuery(e.target.value)}
                  onKeyPress={(e) => {
                    if (e.key === 'Enter' && modalSearchQuery.trim()) {
                      handleSearch(modalSearchQuery);
                    }
                  }}
                  placeholder={searchedDomain || (isRTL ? 'ابحث عن نطاق...' : 'Search for a domain...')}
                  className="w-full rounded-full border border-gray-200 bg-gray-50 py-3 pl-12 pr-24 text-base focus:border-[#1d71b8] focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#1d71b8]/20"
                  dir="ltr"
                />
                <button 
                  onClick={() => {
                    if (modalSearchQuery.trim()) {
                      handleSearch(modalSearchQuery);
                    }
                  }}
                  className="absolute right-2 top-1/2 -translate-y-1/2 rounded-full bg-gray-900 px-6 py-2 text-sm font-semibold text-white hover:bg-gray-800 transition-colors"
                >
                  {isRTL ? 'بحث' : 'Search'}
                </button>
              </div>
            </div>

            {/* Results List */}
            <div className="overflow-y-auto h-[calc(100vh-250px)]">
              <div className="mx-auto max-w-2xl px-4 py-4">
                {/* Modern Search Loader */}
                <div className={`flex flex-col items-center justify-center py-16 ${isSearching ? '' : 'hidden'}`}>
                  {/* Animated Search Icon with Ripple Effect */}
                  <div className="relative">
                    {/* Ripple circles */}
                    <div className="absolute inset-0 flex items-center justify-center">
                      <div className="absolute h-24 w-24 animate-ping rounded-full bg-[#1d71b8]/20 [animation-duration:1.5s]" />
                      <div className="absolute h-32 w-32 animate-ping rounded-full bg-[#1d71b8]/10 [animation-duration:2s] [animation-delay:0.5s]" />
                    </div>
                    
                    {/* Main loader circle */}
                    <div className="relative flex h-20 w-20 items-center justify-center">
                      {/* Spinning gradient ring */}
                      <div className="absolute inset-0 animate-spin rounded-full border-4 border-transparent border-t-[#1d71b8] border-r-[#1d71b8]/50 [animation-duration:1s]" />
                      
                      {/* Inner pulsing circle */}
                      <div className="absolute inset-2 animate-pulse rounded-full bg-linear-to-br from-[#1d71b8]/20 to-[#1d71b8]/5" />
                      
                      {/* Search icon */}
                      <Search className="h-8 w-8 text-[#1d71b8] animate-pulse" />
                    </div>
                  </div>
                  
                  {/* Animated text */}
                  <div className="mt-6 flex flex-col items-center gap-2">
                    <p className="text-lg font-medium text-gray-700">
                      {isRTL ? 'جاري البحث عن نطاقك...' : 'Searching for your domain...'}
                    </p>
                    <div className="flex gap-1">
                      <span className="h-2 w-2 animate-bounce rounded-full bg-[#1d71b8]" />
                      <span className="h-2 w-2 animate-bounce rounded-full bg-[#1d71b8] [animation-delay:150ms]" />
                      <span className="h-2 w-2 animate-bounce rounded-full bg-[#1d71b8] [animation-delay:300ms]" />
                    </div>
                  </div>
                </div>
                
                {!isSearching && (
                  <div className="flex flex-col divide-y divide-gray-100">
                    {searchResults.map((result) => (
                      <div 
                        key={result.domain}
                        className="flex items-center justify-between py-4 hover:bg-gray-50 px-2 -mx-2 rounded-lg transition-colors"
                      >
                        {/* Left Side - Domain Info */}
                        <div className="flex items-center gap-3">
                          <CheckCircle className={`h-5 w-5 ${result.available ? 'text-green-500' : 'text-gray-300'}`} />
                          <div>
                            <div className="flex items-center gap-2">
                              <span className={`text-xs font-semibold uppercase tracking-wide ${result.available ? 'text-green-600' : 'text-gray-400'}`}>
                                {result.available 
                                  ? (isRTL ? 'متاح' : 'AVAILABLE')
                                  : (isRTL ? 'محجوز' : 'TAKEN')
                                }
                              </span>
                            </div>
                            <p className="text-base font-semibold text-gray-900" dir="ltr">
                              {result.domain.split('.')[0]}.<span className="font-bold">{result.domain.split('.').slice(1).join('.')}</span>
                            </p>
                          </div>
                        </div>

                        {/* Right Side - Price & Action */}
                        {result.available && (
                          <div className="flex items-center gap-3">
                            <span className="text-lg font-bold text-gray-900">
                              {result.price}<span className="text-sm font-normal text-gray-500">/{isRTL ? 'سنة' : 'yr'}</span>
                            </span>
                            <a 
                              href={`https://app.progineous.com/cart.php?a=add&domain=register&domains[]=${result.domain}`}
                              target="_blank"
                              rel="noopener noreferrer"
                              className="flex items-center justify-center h-10 w-10 rounded-lg border-2 border-gray-200 bg-white text-gray-600 hover:border-[#1d71b8] hover:text-[#1d71b8] transition-all"
                              title={isRTL ? `إضافة ${result.domain} للسلة` : `Add ${result.domain} to cart`}
                              aria-label={isRTL ? `إضافة ${result.domain} للسلة` : `Add ${result.domain} to cart`}
                            >
                              <ShoppingCart className="h-5 w-5" />
                            </a>
                          </div>
                        )}
                      </div>
                    ))}

                    {/* No Results */}
                    {searchResults.length === 0 && !isSearching && (
                      <div className="text-center py-12">
                        <Search className="h-12 w-12 text-gray-300 mx-auto mb-4" />
                        <p className="text-gray-500">
                          {isRTL ? 'ابدأ البحث للعثور على نطاقك المثالي' : 'Start searching to find your perfect domain'}
                        </p>
                      </div>
                    )}
                  </div>
                )}
              </div>
            </div>
          </div>
        )}
        
        {/* Curved Bottom */}
        <div className="absolute bottom-0 left-0 right-0">
          <svg viewBox="0 0 1440 100" fill="none" xmlns="http://www.w3.org/2000/svg" className="w-full block -mb-px" preserveAspectRatio="none">
            <path d="M0 100C240 100 240 40 480 40C720 40 720 100 960 100C1200 100 1200 40 1440 40V100H0Z" fill="white"/>
          </svg>
        </div>
      </section>

      {/* TLD Pricing Section */}
      <section ref={pricingRef} className="py-20 bg-white -mt-px">
        <div className="container mx-auto px-4">
          <div className="text-center mb-12">
            <h2 className="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
              {isRTL ? 'أسعار النطاقات' : 'Domain Pricing'}
            </h2>
            <p className="text-gray-600 max-w-2xl mx-auto">
              {isRTL 
                ? 'أسعار تنافسية لجميع امتدادات النطاقات الشائعة'
                : 'Competitive prices for all popular domain extensions'}
            </p>
          </div>

          {/* Search Box */}
          <div className="max-w-md mx-auto mb-8">
            <div className="relative">
              <Search className="absolute left-4 top-1/2 -translate-y-1/2 h-5 w-5 text-gray-400" />
              <input
                type="text"
                value={tldSearchQuery}
                onChange={(e) => setTldSearchQuery(e.target.value)}
                placeholder={isRTL ? 'ابحث عن امتداد... (مثال: .com)' : 'Search for extension... (e.g., .com)'}
                className="w-full rounded-xl border border-gray-200 bg-gray-50 py-3 pl-12 pr-4 text-base focus:border-[#1d71b8] focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#1d71b8]/20 transition-all"
                dir="ltr"
              />
              {tldSearchQuery && (
                <button 
                  onClick={() => setTldSearchQuery('')}
                  className="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600"
                  title={isRTL ? 'مسح البحث' : 'Clear search'}
                  aria-label={isRTL ? 'مسح البحث' : 'Clear search'}
                >
                  <X className="h-5 w-5" />
                </button>
              )}
            </div>
            {tldSearchQuery && (
              <p className="text-sm text-gray-500 mt-2 text-center">
                {isRTL 
                  ? `عرض ${filteredTlds.length} نتيجة`
                  : `Showing ${filteredTlds.length} result${filteredTlds.length !== 1 ? 's' : ''}`}
              </p>
            )}
          </div>
          
          {loadingPrices ? (
            <div className="flex justify-center">
              <RefreshCw className="w-8 h-8 text-[#1d71b8] animate-spin" />
            </div>
          ) : (
            <>
              {/* Desktop Table */}
              <div className="hidden md:block rounded-2xl border border-gray-200 shadow-sm">
                <div className="max-h-150 overflow-y-auto">
                  <table className="w-full">
                    <thead className="sticky top-0 z-10">
                      <tr className="bg-linear-to-r from-[#1d71b8] to-[#155a94]">
                        <th className="px-6 py-4 text-left text-sm font-semibold text-white">
                          {isRTL ? 'الامتداد' : 'Extension'}
                        </th>
                        <th className="px-6 py-4 text-center text-sm font-semibold text-white">
                          {isRTL ? 'تسجيل' : 'Register'}
                        </th>
                        <th className="px-6 py-4 text-center text-sm font-semibold text-white">
                          {isRTL ? 'نقل' : 'Transfer'}
                        </th>
                        <th className="px-6 py-4 text-center text-sm font-semibold text-white">
                          {isRTL ? 'تجديد' : 'Renew'}
                        </th>
                        <th className="px-6 py-4 text-center text-sm font-semibold text-white">
                          {isRTL ? 'إجراء' : 'Action'}
                        </th>
                      </tr>
                    </thead>
                    <tbody className="divide-y divide-gray-100 bg-white">
                      {filteredTlds.map((tld, index) => (
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
                              {tld.sale && (
                                <span className="px-2 py-0.5 bg-green-100 text-green-700 text-xs font-bold rounded-full">
                                  {isRTL ? 'عرض' : 'SALE'}
                                </span>
                              )}
                              {tld.popular && !tld.sale && (
                                <span className="px-2 py-0.5 bg-[#1d71b8]/10 text-[#1d71b8] text-xs font-bold rounded-full">
                                  {isRTL ? 'شائع' : 'POPULAR'}
                                </span>
                              )}
                            </div>
                          </td>
                          <td className="px-6 py-4 text-center">
                            <span className={cn(
                              "font-semibold",
                              tld.sale ? "text-green-600" : "text-gray-900"
                            )}>
                              {tld.register}
                            </span>
                            <span className="text-gray-400 text-sm">/{isRTL ? 'سنة' : 'yr'}</span>
                          </td>
                          <td className="px-6 py-4 text-center text-gray-600">
                            {tld.transfer}
                          </td>
                          <td className="px-6 py-4 text-center text-gray-600">
                            {tld.renew}
                          </td>
                          <td className="px-6 py-4 text-center">
                            <button
                              onClick={() => {
                                setSearchQuery(tld.tld);
                                window.scrollTo({ top: 0, behavior: 'smooth' });
                                // Focus on search input after scroll
                                setTimeout(() => {
                                  const searchInput = document.querySelector('input[placeholder*="domain"], input[placeholder*="نطاق"]') as HTMLInputElement;
                                  if (searchInput) {
                                    searchInput.focus();
                                  }
                                }, 500);
                              }}
                              className="inline-flex items-center gap-1.5 px-4 py-2 bg-[#1d71b8] hover:bg-[#155a94] text-white text-sm font-semibold rounded-lg transition-colors"
                            >
                              {isRTL ? 'سجّل' : 'Register'}
                              <ArrowRight className={cn("w-4 h-4", isRTL && "rotate-180")} />
                            </button>
                          </td>
                        </tr>
                      ))}
                    </tbody>
                  </table>
                </div>
              </div>

              {/* Mobile Cards */}
              <div className="md:hidden space-y-3 max-h-150 overflow-y-auto pr-1">
                {filteredTlds.map((tld) => (
                  <div
                    key={tld.tld}
                    className={cn(
                      "p-4 bg-white border rounded-xl shadow-sm",
                      tld.sale ? "border-green-300" : "border-gray-200"
                    )}
                  >
                    {/* Header */}
                    <div className="flex items-center justify-between mb-3">
                      <div className="flex items-center gap-2">
                        <span className="text-xl font-bold text-gray-900">{tld.tld}</span>
                        {tld.sale && (
                          <span className="px-2 py-0.5 bg-green-100 text-green-700 text-xs font-bold rounded-full">
                            {isRTL ? 'عرض' : 'SALE'}
                          </span>
                        )}
                        {tld.popular && !tld.sale && (
                          <span className="px-2 py-0.5 bg-[#1d71b8]/10 text-[#1d71b8] text-xs font-bold rounded-full">
                            {isRTL ? 'شائع' : 'POPULAR'}
                          </span>
                        )}
                      </div>
                      <span className={cn(
                        "text-lg font-bold",
                        tld.sale ? "text-green-600" : "text-[#1d71b8]"
                      )}>
                        {tld.register}
                        <span className="text-sm font-normal text-gray-400">/{isRTL ? 'سنة' : 'yr'}</span>
                      </span>
                    </div>
                    
                    {/* Prices Grid */}
                    <div className="grid grid-cols-2 gap-2 mb-3 text-sm">
                      <div className="flex justify-between p-2 bg-gray-50 rounded-lg">
                        <span className="text-gray-500">{isRTL ? 'نقل' : 'Transfer'}</span>
                        <span className="font-medium text-gray-700">{tld.transfer}</span>
                      </div>
                      <div className="flex justify-between p-2 bg-gray-50 rounded-lg">
                        <span className="text-gray-500">{isRTL ? 'تجديد' : 'Renew'}</span>
                        <span className="font-medium text-gray-700">{tld.renew}</span>
                      </div>
                    </div>
                    
                    {/* Action Button */}
                    <button
                      onClick={() => {
                        setSearchQuery(tld.tld);
                        window.scrollTo({ top: 0, behavior: 'smooth' });
                        setTimeout(() => {
                          const searchInput = document.querySelector('input[placeholder*="domain"], input[placeholder*="نطاق"]') as HTMLInputElement;
                          if (searchInput) {
                            searchInput.focus();
                          }
                        }, 500);
                      }}
                      className="w-full flex items-center justify-center gap-2 py-2.5 bg-[#1d71b8] hover:bg-[#155a94] text-white text-sm font-semibold rounded-lg transition-colors"
                    >
                      {isRTL ? 'سجّل الآن' : 'Register Now'}
                      <ArrowRight className={cn("w-4 h-4", isRTL && "rotate-180")} />
                    </button>
                  </div>
                ))}
              </div>

              {/* No Results */}
              {filteredTlds.length === 0 && tldSearchQuery && (
                <div className="text-center py-12">
                  <Search className="h-12 w-12 text-gray-300 mx-auto mb-4" />
                  <p className="text-gray-500">
                    {isRTL 
                      ? `لم يتم العثور على امتداد "${tldSearchQuery}"`
                      : `No extension found for "${tldSearchQuery}"`}
                  </p>
                  <button
                    onClick={() => setTldSearchQuery('')}
                    className="mt-4 text-[#1d71b8] hover:underline font-medium"
                  >
                    {isRTL ? 'عرض جميع الامتدادات' : 'Show all extensions'}
                  </button>
                </div>
              )}
              
              {hasMoreTlds && !tldSearchQuery && (
                <div className="text-center mt-8">
                  <button
                    onClick={() => setVisibleTldsCount(prev => prev + 10)}
                    className="px-6 py-3 bg-gray-100 hover:bg-gray-200 border border-gray-200 rounded-xl text-gray-700 font-semibold transition-colors inline-flex items-center gap-2"
                  >
                    {isRTL 
                      ? `عرض المزيد (${tldPrices.length - visibleTldsCount} متبقي)`
                      : `Show More (${tldPrices.length - visibleTldsCount} remaining)`}
                    <ChevronDown className="w-5 h-5" />
                  </button>
                </div>
              )}
            </>
          )}
        </div>
      </section>

      {/* Features Section */}
      <section ref={featuresRef} className="py-20 bg-gray-50">
        <div className="container mx-auto px-4">
          <div className="text-center mb-12">
            <h2 className="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
              {isRTL ? 'مميزات تسجيل النطاقات' : 'Domain Registration Features'}
            </h2>
            <p className="text-gray-600 max-w-2xl mx-auto">
              {isRTL
                ? 'كل ما تحتاجه لإدارة نطاقاتك بكفاءة'
                : 'Everything you need to manage your domains efficiently'}
            </p>
          </div>
          
          <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            {features.map((feature, index) => (
              <div
                key={index}
                className="p-6 bg-white border border-gray-200 rounded-2xl hover:border-[#1d71b8]/30 hover:shadow-lg transition-all group shadow-sm"
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

      {/* Transfer Section */}
      <section className="py-20 bg-linear-to-r from-[#1d71b8]/5 to-[#1d71b8]/10">
        <div className="container mx-auto px-4">
          <div className="max-w-4xl mx-auto text-center">
            <div className="inline-flex items-center gap-2 px-4 py-2 bg-[#1d71b8]/10 border border-[#1d71b8]/20 rounded-full mb-6">
              <RefreshCw className="w-4 h-4 text-[#1d71b8]" />
              <span className="text-sm text-[#1d71b8]">
                {isRTL ? 'نقل سهل وسريع' : 'Easy & Fast Transfer'}
              </span>
            </div>
            
            <h2 className="text-3xl md:text-4xl font-bold text-gray-900 mb-6">
              {isRTL ? 'انقل نطاقك إلينا' : 'Transfer Your Domain to Us'}
            </h2>
            
            <p className="text-xl text-gray-600 mb-8 max-w-2xl mx-auto">
              {isRTL
                ? 'انقل نطاقك الحالي واحصل على سنة إضافية مجاناً مع كل عملية نقل'
                : 'Transfer your existing domain and get an extra year free with every transfer'}
            </p>
            
            <div className="flex flex-wrap justify-center gap-4">
              <Link
                href="/domains/transfer"
                className="px-8 py-4 bg-[#1d71b8] hover:bg-[#1a65a3] text-white font-semibold rounded-xl transition-all inline-flex items-center gap-2 shadow-lg"
              >
                {isRTL ? 'ابدأ النقل' : 'Start Transfer'}
                <ArrowRight className={cn("w-5 h-5", isRTL && "rotate-180")} />
              </Link>
              <Link
                href="/contact"
                className="px-8 py-4 bg-white hover:bg-gray-100 border border-gray-200 text-gray-700 font-semibold rounded-xl transition-colors shadow-sm"
              >
                {isRTL ? 'تعرف على المزيد' : 'Learn More'}
              </Link>
            </div>
          </div>
        </div>
      </section>

      {/* FAQ Section */}
      <section className="py-20 bg-white">
        <div className="container mx-auto px-4">
          <div className="text-center mb-12">
            <h2 className="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
              {isRTL ? 'الأسئلة الشائعة' : 'Frequently Asked Questions'}
            </h2>
            <p className="text-gray-600 max-w-2xl mx-auto">
              {isRTL
                ? 'إجابات على أكثر الأسئلة شيوعاً حول تسجيل النطاقات'
                : 'Answers to the most common questions about domain registration'}
            </p>
          </div>
          
          <div className="max-w-3xl mx-auto space-y-4">
            {faqs.map((faq, index) => (
              <div
                key={index}
                className="bg-gray-50 border border-gray-200 rounded-xl overflow-hidden"
              >
                <button
                  onClick={() => setOpenFaq(openFaq === index ? null : index)}
                  className="w-full flex items-center justify-between p-6 text-left"
                >
                  <span className="text-gray-900 font-semibold">{faq.question}</span>
                  {openFaq === index ? (
                    <ChevronUp className="w-5 h-5 text-[#1d71b8] shrink-0" />
                  ) : (
                    <ChevronDown className="w-5 h-5 text-gray-500 shrink-0" />
                  )}
                </button>
                {openFaq === index && (
                  <div className="px-6 pb-6">
                    <p className="text-gray-600">{faq.answer}</p>
                  </div>
                )}
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* CTA Section */}
      <section className="py-20 bg-linear-to-b from-gray-100 to-gray-50">
        <div className="container mx-auto px-4">
          <div className="max-w-4xl mx-auto text-center">
            <h2 className="text-3xl md:text-4xl font-bold text-gray-900 mb-6">
              {isRTL ? 'ابدأ رحلتك الرقمية اليوم' : 'Start Your Digital Journey Today'}
            </h2>
            <p className="text-xl text-gray-600 mb-8">
              {isRTL
                ? 'سجّل نطاقك واحصل على استضافة مجانية للشهر الأول'
                : 'Register your domain and get free hosting for the first month'}
            </p>
            <div className="flex flex-wrap justify-center gap-4">
              <a
                href="https://app.progineous.com/cart.php?a=add&domain=register"
                target="_blank"
                rel="noopener noreferrer"
                className="px-8 py-4 bg-[#1d71b8] hover:bg-[#1a65a3] text-white font-semibold rounded-xl transition-all inline-flex items-center gap-2 shadow-lg"
              >
                {isRTL ? 'سجّل نطاقك الآن' : 'Register Your Domain'}
                <ArrowRight className={cn("w-5 h-5", isRTL && "rotate-180")} />
              </a>
              <Link
                href="/hosting/shared"
                className="px-8 py-4 bg-white hover:bg-gray-100 border border-gray-200 text-gray-700 font-semibold rounded-xl transition-colors shadow-sm"
              >
                {isRTL ? 'تصفح خطط الاستضافة' : 'Browse Hosting Plans'}
              </Link>
            </div>
          </div>
        </div>
      </section>
    </div>
  );
}
