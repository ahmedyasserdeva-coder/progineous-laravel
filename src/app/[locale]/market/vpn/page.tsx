'use client';

import { useState, useEffect, useRef } from 'react';
import { useLocale } from 'next-intl';
import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import {
  Shield,
  ShieldCheck,
  Globe,
  EyeOff,
  Monitor,
  Smartphone,
  Laptop,
  Router,
  Check,
  X,
  ChevronDown,
  ChevronUp,
  ArrowRight,
  Tv,
  Home,
  Coffee,
} from 'lucide-react';
import { cn } from '@/lib/utils';

// Register GSAP plugins
if (typeof window !== 'undefined') {
  gsap.registerPlugin(ScrollTrigger);
}

// Plan Interface
interface VPNPlan {
  id: string;
  name: string;
  nameAr: string;
  price: number;
  period: string;
  periodAr: string;
  savings?: string;
  savingsAr?: string;
  cartLink: string;
  popular?: boolean;
}

// VPN Plans Data
const vpnPlans: VPNPlan[] = [
  {
    id: 'monthly',
    name: 'Monthly',
    nameAr: 'شهري',
    price: 8.99,
    period: '/mo',
    periodAr: '/شهر',
    cartLink: 'https://app.progineous.com/store/nordvpn/standard',
  },
  {
    id: 'annually',
    name: 'Annually',
    nameAr: 'سنوي',
    price: 4.99,
    period: '/mo',
    periodAr: '/شهر',
    savings: 'Save 40%!',
    savingsAr: 'وفر 40%!',
    cartLink: 'https://app.progineous.com/store/nordvpn/standard',
    popular: true,
  },
];

// VPN Benefits
const vpnBenefits = [
  {
    image: 'https://app.progineous.com/assets/img/marketconnect/nordvpn/icon-video.png',
    title: { en: 'Browse, stream, and download', ar: 'تصفح وشاهد وحمّل' },
    description: {
      en: 'Browse, stream, and download content with a secure and private connection',
      ar: 'تصفح وشاهد وحمّل المحتوى باتصال آمن وخاص',
    },
  },
  {
    image: 'https://app.progineous.com/assets/img/marketconnect/nordvpn/icon-global.png',
    title: { en: 'Watch from abroad', ar: 'شاهد من الخارج' },
    description: {
      en: 'Watch home shows and sports from abroad',
      ar: 'شاهد العروض والرياضة المحلية من الخارج',
    },
  },
  {
    image: 'https://app.progineous.com/assets/img/marketconnect/nordvpn/icon-hacker.png',
    title: { en: 'Shield against hackers', ar: 'احمِ نفسك من المخترقين' },
    description: {
      en: 'Shield against hackers on unsecured networks (like public Wi-Fi®)',
      ar: 'احمِ نفسك من المخترقين على الشبكات غير الآمنة (مثل Wi-Fi العام)',
    },
  },
  {
    image: 'https://app.progineous.com/assets/img/marketconnect/nordvpn/icon-property.png',
    title: { en: 'Hide your IP', ar: 'أخفِ عنوان IP' },
    description: {
      en: 'Reduce online tracking by hiding your IP address',
      ar: 'قلل التتبع عبر الإنترنت بإخفاء عنوان IP الخاص بك',
    },
  },
];

// Why Choose NordVPN - Comparison
const vpnComparison = {
  headers: ['NordVPN', 'ExpressVPN', 'Private VPN', 'ProtonVPN', 'PureVPN'],
  features: [
    {
      name: { en: 'Connection Speed*', ar: 'سرعة الاتصال*' },
      values: ['6730+ Mbps', '2200+ Mbps', '3320+ Mbps', '1600+ Mbps', '2320+ Mbps'],
    },
    {
      name: { en: 'WireGuard® for top speeds', ar: 'WireGuard® لأعلى السرعات' },
      values: [true, false, true, true, false],
    },
    {
      name: { en: 'VPN Servers', ar: 'خوادم VPN' },
      values: ['5500+', '3000+', '200+', '1600+', '6500+'],
    },
    {
      name: { en: 'Verified no-logs policy', ar: 'سياسة عدم الاحتفاظ بالسجلات' },
      values: [true, true, true, true, true],
    },
    {
      name: { en: 'Live chat support', ar: 'دعم الدردشة المباشرة' },
      values: [true, true, true, true, true],
    },
  ],
};

// More than VPN features
const moreThanVPN = [
  {
    image: 'https://app.progineous.com/assets/img/marketconnect/nordvpn/img-protection.png',
    title: { en: 'Threat Protection', ar: 'حماية من التهديدات' },
    description: {
      en: 'Threat Protection blocks intrusive ads and web trackers, and automatically scans URLs and blocks malicious ones.',
      ar: 'حماية التهديدات تحظر الإعلانات المزعجة ومتتبعات الويب، وتفحص عناوين URL تلقائياً وتحظر الضارة منها.',
    },
  },
  {
    image: 'https://app.progineous.com/assets/img/marketconnect/nordvpn/img-malware.png',
    title: { en: 'Malware Scanner', ar: 'فاحص البرامج الضارة' },
    description: {
      en: 'Whenever you download a file, Threat Protection inspects it for malware.',
      ar: 'كلما حمّلت ملفاً، تفحصه حماية التهديدات بحثاً عن البرامج الضارة.',
    },
  },
  {
    image: 'https://app.progineous.com/assets/img/marketconnect/nordvpn/img-safe.png',
    title: { en: 'Block Trackers', ar: 'حظر المتتبعين' },
    description: {
      en: 'Threat Protection protects not only your devices but also you. The ability to block trackers helps you avoid online spies and stalkers.',
      ar: 'حماية التهديدات تحمي ليس فقط أجهزتك بل أنت أيضاً. القدرة على حظر المتتبعين تساعدك على تجنب الجواسيس والمتطفلين.',
    },
  },
];

// Security Features
const securityFeatures = [
  {
    image: 'https://app.progineous.com/assets/img/marketconnect/nordvpn/icon-check.png',
    title: { en: 'Secure, high-speed VPN', ar: 'VPN آمن وعالي السرعة' },
    description: {
      en: 'Encrypt your internet connection, reclaim digital privacy, and access your favorite content with the fastest VPN on the market. Choose from VPN servers in 59 countries, and protect up to 6 devices at once.',
      ar: 'شفّر اتصالك بالإنترنت، واستعد خصوصيتك الرقمية، واصل إلى محتواك المفضل مع أسرع VPN في السوق. اختر من خوادم VPN في 59 دولة، واحمِ حتى 6 أجهزة في وقت واحد.',
    },
  },
  {
    image: 'https://app.progineous.com/assets/img/marketconnect/nordvpn/icon-bug.png',
    title: { en: 'Malware protection', ar: 'حماية من البرامج الضارة' },
    description: {
      en: "Get warnings about unsafe sites and automatically scan all downloaded files and attachments for malware. If they're not safe to open, they're automatically deleted to prevent any damage to your device.",
      ar: 'احصل على تحذيرات حول المواقع غير الآمنة وافحص تلقائياً جميع الملفات والمرفقات المحملة بحثاً عن البرامج الضارة. إذا لم تكن آمنة للفتح، يتم حذفها تلقائياً لمنع أي ضرر لجهازك.',
    },
  },
  {
    image: 'https://app.progineous.com/assets/img/marketconnect/nordvpn/icon-shield.png',
    title: { en: 'Tracker and ad blocker', ar: 'حاظر المتتبعين والإعلانات' },
    description: {
      en: 'Block annoying ads, pop-ups, and banners, and stop third-party websites from tracking your online activity. Enjoy a safer, smoother, and faster browsing experience on all sites, and on every device.',
      ar: 'احظر الإعلانات المزعجة والنوافذ المنبثقة واللافتات، وأوقف مواقع الطرف الثالث من تتبع نشاطك عبر الإنترنت. استمتع بتجربة تصفح أكثر أماناً وسلاسة وسرعة على جميع المواقع وكل الأجهزة.',
    },
  },
];

// Use Cases
const useCases = [
  {
    icon: Coffee,
    title: { en: 'Wi-Fi in Public Places', ar: 'Wi-Fi في الأماكن العامة' },
    description: {
      en: 'Public Wi-Fi networks in Hotels, Airports, & Coffee Shops are the perfect targets for hackers due to often low security measures.',
      ar: 'شبكات Wi-Fi العامة في الفنادق والمطارات والمقاهي هي أهداف مثالية للمخترقين بسبب إجراءات الأمان المنخفضة غالباً.',
    },
  },
  {
    icon: EyeOff,
    title: { en: 'Shield browsing from third parties', ar: 'احمِ تصفحك من الأطراف الثالثة' },
    description: {
      en: 'Prevent third parties such as Internet Service Providers from seeing and tracking your day-to-day online activity.',
      ar: 'امنع الأطراف الثالثة مثل مزودي خدمة الإنترنت من رؤية وتتبع نشاطك اليومي عبر الإنترنت.',
    },
  },
  {
    icon: Globe,
    title: { en: 'Access social media anywhere', ar: 'الوصول لوسائل التواصل في أي مكان' },
    description: {
      en: 'Avoid regional and political restrictions on platforms like Facebook, Twitter, WhatsApp and more.',
      ar: 'تجنب القيود الإقليمية والسياسية على منصات مثل فيسبوك وتويتر وواتساب وغيرها.',
    },
  },
  {
    icon: Tv,
    title: { en: 'Enjoy online entertainment', ar: 'استمتع بالترفيه عبر الإنترنت' },
    description: {
      en: 'Even though online platforms can be accessed from anywhere, certain broadcasts, shows or sporting events are often restricted.',
      ar: 'رغم إمكانية الوصول للمنصات من أي مكان، إلا أن بعض البث والعروض والأحداث الرياضية غالباً ما تكون مقيدة.',
    },
  },
  {
    icon: Shield,
    title: { en: 'Protect from malicious ads', ar: 'احمِ من الإعلانات الضارة' },
    description: {
      en: 'Online ads usually make your browsing experience worse. They clutter websites, slow speeds, and might be sources of malware.',
      ar: 'الإعلانات عبر الإنترنت عادة تجعل تجربة تصفحك أسوأ. تزدحم المواقع وتبطئ السرعات وقد تكون مصادر للبرامج الضارة.',
    },
  },
  {
    icon: Home,
    title: { en: 'Secure smart home gadgets', ar: 'أمّن أجهزة المنزل الذكي' },
    description: {
      en: 'Smart home technologies and in particular unsecure IoT devices can create vulnerabilities for home networks.',
      ar: 'تقنيات المنزل الذكي وخاصة أجهزة IoT غير الآمنة يمكن أن تخلق ثغرات لشبكات المنزل.',
    },
  },
];

// FAQ Data
const faqs = [
  {
    question: { en: 'What is a VPN?', ar: 'ما هو VPN؟' },
    answer: {
      en: "A virtual private network routes your internet traffic through a secure tunnel, changing your virtual location in the process. But NordVPN is more than just a VPN — we also offer powerful anti-malware tools.",
      ar: 'الشبكة الافتراضية الخاصة توجه حركة الإنترنت الخاصة بك عبر نفق آمن، وتغير موقعك الافتراضي في العملية. لكن NordVPN أكثر من مجرد VPN - نقدم أيضاً أدوات قوية لمكافحة البرامج الضارة.',
    },
  },
  {
    question: { en: 'What is Auto-Kill Switch?', ar: 'ما هو مفتاح الإيقاف التلقائي؟' },
    answer: {
      en: 'Kill Switch is a security feature that automatically blocks your device from accessing the internet if your VPN connection drops, ensuring your data stays protected at all times.',
      ar: 'مفتاح الإيقاف هو ميزة أمان تحظر تلقائياً وصول جهازك إلى الإنترنت إذا انقطع اتصال VPN، مما يضمن حماية بياناتك في جميع الأوقات.',
    },
  },
  {
    question: { en: "What is NordVPN's Threat Protection?", ar: 'ما هي حماية التهديدات من NordVPN؟' },
    answer: {
      en: 'Threat Protection is a feature that blocks malicious websites, ads, and trackers, and scans downloaded files for malware to keep you safe online.',
      ar: 'حماية التهديدات هي ميزة تحظر المواقع الضارة والإعلانات والمتتبعين، وتفحص الملفات المحملة بحثاً عن البرامج الضارة للحفاظ على سلامتك عبر الإنترنت.',
    },
  },
  {
    question: { en: 'What is DNS Leak Protection?', ar: 'ما هي حماية تسرب DNS؟' },
    answer: {
      en: 'DNS Leak Protection ensures that your DNS queries are routed through the VPN tunnel, preventing your ISP or other third parties from seeing the websites you visit.',
      ar: 'حماية تسرب DNS تضمن توجيه استفسارات DNS الخاصة بك عبر نفق VPN، مما يمنع مزود الإنترنت أو الأطراف الثالثة من رؤية المواقع التي تزورها.',
    },
  },
  {
    question: { en: 'What is Double VPN?', ar: 'ما هو VPN المزدوج؟' },
    answer: {
      en: 'Double VPN routes your traffic through two VPN servers instead of one, adding an extra layer of encryption for enhanced privacy and security.',
      ar: 'VPN المزدوج يوجه حركتك عبر خادمين VPN بدلاً من واحد، مضيفاً طبقة تشفير إضافية لتعزيز الخصوصية والأمان.',
    },
  },
];

export default function VPNPage() {
  const locale = useLocale();
  const isRTL = locale === 'ar';
  const [expandedFaq, setExpandedFaq] = useState<number | null>(null);
  const [selectedPlan, setSelectedPlan] = useState<string>('annually');
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
    name: 'NordVPN',
    description: isRTL
      ? 'خدمة VPN آمنة وسريعة لحماية الخصوصية على الإنترنت'
      : 'Secure and fast VPN service for online privacy protection',
    applicationCategory: 'SecurityApplication',
    operatingSystem: 'Windows, macOS, iOS, Android, Linux',
    offers: {
      '@type': 'AggregateOffer',
      lowPrice: '4.99',
      highPrice: '8.99',
      priceCurrency: 'USD',
      offerCount: vpnPlans.length,
    },
  };

  const breadcrumbSchema = {
    '@context': 'https://schema.org',
    '@type': 'BreadcrumbList',
    itemListElement: [
      { '@type': 'ListItem', position: 1, name: isRTL ? 'الرئيسية' : 'Home', item: `${baseUrl}/${locale}` },
      { '@type': 'ListItem', position: 2, name: isRTL ? 'السوق' : 'Market', item: `${baseUrl}/${locale}/market` },
      { '@type': 'ListItem', position: 3, name: 'VPN', item: `${baseUrl}/${locale}/market/vpn` },
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
    <main className={cn("min-h-screen bg-white", isRTL && "rtl")}>
      {/* JSON-LD Structured Data */}
      <script type="application/ld+json" dangerouslySetInnerHTML={{ __html: JSON.stringify(serviceSchema) }} />
      <script type="application/ld+json" dangerouslySetInnerHTML={{ __html: JSON.stringify(breadcrumbSchema) }} />
      <script type="application/ld+json" dangerouslySetInnerHTML={{ __html: JSON.stringify(faqSchema) }} />

      {/* Hero Section */}
      <section className="relative bg-gradient-to-br from-[#0a1628] via-[#1a2744] to-[#0d1f3c] text-white overflow-hidden min-h-[80vh] flex items-center">
        {/* Background Pattern */}
        <div className="absolute inset-0 opacity-20">
          <div className="absolute inset-0" style={{
            backgroundImage: `radial-gradient(circle at 25% 25%, rgba(59, 130, 246, 0.3) 0%, transparent 50%),
                              radial-gradient(circle at 75% 75%, rgba(147, 51, 234, 0.2) 0%, transparent 50%)`,
          }} />
        </div>

        {/* Floating Shield */}
        <div className="absolute top-20 right-10 opacity-10">
          <Shield className="w-64 h-64" />
        </div>

        <div className="container mx-auto px-4 py-20 relative z-10">
          <div ref={heroRef} className="max-w-4xl mx-auto text-center">
            {/* Logo */}
            <div className="mb-8 flex items-center justify-center">
              <img 
                src="https://app.progineous.com/assets/img/marketconnect/nordvpn/header-logo.png" 
                alt="NordVPN" 
                className="h-16 object-contain"
              />
            </div>

            <h1 className="text-4xl md:text-6xl font-bold mb-4">
              {isRTL ? 'الأمن السيبراني.' : 'Cybersecurity.'}
              <br />
              <span className="text-blue-400">
                {isRTL ? 'مصمم للاستخدام اليومي' : 'Built for everyday'}
              </span>
            </h1>
            
            <p className="text-xl md:text-2xl text-gray-300 mb-8">
              {isRTL
                ? 'أمّن اتصالك وأخفِ عنوان IP الخاص بك. احظر البرامج الضارة والمتتبعين والإعلانات.'
                : 'Secure your connection and hide your IP. Block malware, trackers, and ads.'}
            </p>

            {/* Available on */}
            <div className="flex items-center justify-center gap-2 mb-6 text-gray-400">
              <span>{isRTL ? 'متوفر على' : 'Available on'}</span>
              <div className="flex items-center gap-3">
                <Monitor className="w-5 h-5" />
                <Laptop className="w-5 h-5" />
                <Smartphone className="w-5 h-5" />
                <Router className="w-5 h-5" />
              </div>
            </div>

            {/* Money-back guarantee */}
            <div className="inline-flex items-center gap-2 bg-white/10 backdrop-blur-sm px-4 py-2 rounded-full text-sm mb-8">
              <ShieldCheck className="w-4 h-4 text-green-400" />
              {isRTL ? 'ضمان استرداد الأموال لمدة 15 يوماً' : '15-DAY MONEY-BACK GUARANTEE'}
            </div>

            <div>
              <a
                href="#plans"
                className="inline-flex items-center gap-2 px-8 py-4 bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl font-semibold hover:from-blue-600 hover:to-blue-700 transition-all shadow-lg shadow-blue-500/30"
              >
                {isRTL ? 'احصل على NordVPN' : 'Get NordVPN'}
                <ArrowRight className={cn("w-5 h-5", isRTL && "rotate-180")} />
              </a>
            </div>
          </div>
        </div>
      </section>

      {/* VPN Benefits */}
      <section className="py-20 bg-gray-50">
        <div className="container mx-auto px-4">
          <h2 className="text-3xl md:text-4xl font-bold text-center text-gray-900 mb-4">
            {isRTL ? 'مع VPN، يمكنك:' : 'With a VPN, you can:'}
          </h2>

          <div className="grid md:grid-cols-2 lg:grid-cols-4 gap-8 max-w-6xl mx-auto mt-12">
            {vpnBenefits.map((benefit, index) => (
              <div
                key={index}
                className="bg-white rounded-2xl p-6 shadow-sm hover:shadow-lg transition-shadow text-center"
              >
                <div className="w-16 h-16 flex items-center justify-center mx-auto mb-4">
                  <img src={benefit.image} alt="" className="w-12 h-12 object-contain" />
                </div>
                <p className="text-gray-700">
                  {isRTL ? benefit.description.ar : benefit.description.en}
                </p>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* Why Choose NordVPN - Comparison Table */}
      <section className="py-20 bg-white">
        <div className="container mx-auto px-4">
          <h2 className="text-3xl md:text-4xl font-bold text-center text-gray-900 mb-12">
            {isRTL ? 'لماذا تختار NordVPN؟' : 'Why choose NordVPN?'}
          </h2>

          <div className="overflow-x-auto">
            <table className="w-full max-w-5xl mx-auto">
              <thead>
                <tr className="border-b-2">
                  <th className="p-4 text-left"></th>
                  {vpnComparison.headers.map((header, idx) => (
                    <th key={idx} className={cn(
                      "p-4 text-center font-semibold",
                      idx === 0 ? "text-blue-600" : "text-gray-500"
                    )}>
                      {header}
                    </th>
                  ))}
                </tr>
              </thead>
              <tbody>
                {vpnComparison.features.map((feature, idx) => (
                  <tr key={idx} className="border-b">
                    <td className="p-4 font-medium text-gray-700">
                      {isRTL ? feature.name.ar : feature.name.en}
                    </td>
                    {feature.values.map((value, vIdx) => (
                      <td key={vIdx} className="p-4 text-center">
                        {typeof value === 'boolean' ? (
                          value ? (
                            <Check className="w-5 h-5 text-green-500 mx-auto" />
                          ) : (
                            <X className="w-5 h-5 text-red-400 mx-auto" />
                          )
                        ) : (
                          <span className={cn(
                            "font-medium",
                            vIdx === 0 ? "text-blue-600" : "text-gray-600"
                          )}>{value}</span>
                        )}
                      </td>
                    ))}
                  </tr>
                ))}
              </tbody>
            </table>
          </div>

          <p className="text-center text-sm text-gray-500 mt-6">
            {isRTL 
              ? '*الأداء العام للشبكة وفقاً لبحث AV-Test. تاريخ المقارنة: 17 فبراير 2021.'
              : '*Overall network performance according to research by AV-Test. Date of comparison: February 17, 2021.'}
          </p>
        </div>
      </section>

      {/* More than VPN */}
      <section className="py-20 bg-gradient-to-br from-[#0a1628] to-[#1a2744] text-white">
        <div className="container mx-auto px-4">
          <div className="text-center mb-12">
            <h2 className="text-3xl md:text-4xl font-bold mb-4">
              {isRTL ? 'أكثر من مجرد VPN' : 'More than just a VPN'}
            </h2>
            <p className="text-gray-300 max-w-2xl mx-auto">
              {isRTL
                ? 'ميزة حماية التهديدات من NordVPN هي نقلة نوعية تقدم المزيد من فوائد الأمان وحماية أفضل بنقرة إضافية واحدة.'
                : "NordVPN's Threat Protection feature is a game changer that offers even more security benefits and better protection with a single extra click."}
            </p>
          </div>

          {/* World Map Image */}
          <div className="max-w-4xl mx-auto mb-12">
            <img 
              src="https://app.progineous.com/assets/img/marketconnect/nordvpn/img-world.png" 
              alt="NordVPN Global Coverage" 
              className="w-full h-auto"
            />
          </div>

          <div className="grid md:grid-cols-3 gap-8 max-w-5xl mx-auto">
            {moreThanVPN.map((feature, index) => (
              <div
                key={index}
                className="bg-white/10 backdrop-blur-sm rounded-2xl p-6"
              >
                <div className="w-16 h-16 flex items-center justify-center mb-4">
                  <img src={feature.image} alt="" className="w-full h-full object-contain" />
                </div>
                <h3 className="text-lg font-semibold mb-2">
                  {isRTL ? feature.title.ar : feature.title.en}
                </h3>
                <p className="text-gray-300 text-sm">
                  {isRTL ? feature.description.ar : feature.description.en}
                </p>
              </div>
            ))}
          </div>

          {/* Stats */}
          <div className="mt-16 grid grid-cols-2 md:grid-cols-4 gap-8 max-w-4xl mx-auto text-center">
            <div>
              <div className="text-4xl font-bold text-blue-400 mb-2">5500+</div>
              <div className="text-gray-400">{isRTL ? 'خوادم VPN' : 'VPN Servers'}</div>
            </div>
            <div>
              <div className="text-4xl font-bold text-blue-400 mb-2">59</div>
              <div className="text-gray-400">{isRTL ? 'دولة' : 'Countries'}</div>
            </div>
            <div>
              <div className="flex items-center justify-center mb-2">
                <img src="https://app.progineous.com/assets/img/marketconnect/nordvpn/icon-speed.png" alt="" className="w-10 h-10 object-contain" />
              </div>
              <div className="text-gray-400">{isRTL ? 'سرعات فائقة' : 'Blazing speeds'}</div>
            </div>
            <div>
              <div className="flex items-center justify-center mb-2">
                <img src="https://app.progineous.com/assets/img/marketconnect/nordvpn/icon-infinity.png" alt="" className="w-10 h-10 object-contain" />
              </div>
              <div className="text-gray-400">{isRTL ? 'باندويث غير محدود' : 'Unlimited bandwidth'}</div>
            </div>
          </div>
        </div>
      </section>

      {/* Security Features */}
      <section className="py-20 bg-gray-50">
        <div className="container mx-auto px-4">
          <h2 className="text-3xl md:text-4xl font-bold text-center text-gray-900 mb-4">
            {isRTL ? 'حافظ على أمان بياناتك' : 'Keep your data safe'}
          </h2>

          <div className="grid md:grid-cols-3 gap-8 max-w-5xl mx-auto mt-12">
            {securityFeatures.map((feature, index) => (
              <div
                key={index}
                className="bg-white rounded-2xl p-6 shadow-sm"
              >
                <div className="w-12 h-12 flex items-center justify-center mb-4">
                  <img src={feature.image} alt="" className="w-full h-full object-contain" />
                </div>
                <h3 className="text-lg font-semibold text-gray-900 mb-2">
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

      {/* Use Cases */}
      <section className="py-20 bg-white">
        <div className="container mx-auto px-4">
          <div className="text-center mb-12">
            <h2 className="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
              {isRTL ? 'حالات الاستخدام' : 'Use Cases'}
            </h2>
            <p className="text-gray-600 max-w-2xl mx-auto">
              {isRTL
                ? 'حتى لو لم يكن لديك ما تخفيه، ربما لا تحب فكرة أن تتم مراقبتك وتتبعك. السبب الرئيسي وراء اختيار مستخدمي الإنترنت لخدمات VPN هو الخصوصية والأمان العام.'
                : "Even if you have nothing to hide, you probably don't like the idea of being watched and tracked. The main reason why internet users choose VPN services is online privacy and general security."}
            </p>
          </div>

          <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-6 max-w-5xl mx-auto">
            {useCases.map((useCase, index) => (
              <div
                key={index}
                className="bg-gray-50 rounded-xl p-6 hover:shadow-md transition-shadow"
              >
                <div className="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mb-4">
                  <useCase.icon className="w-5 h-5 text-blue-600" />
                </div>
                <h3 className="text-lg font-semibold text-gray-900 mb-2">
                  {isRTL ? useCase.title.ar : useCase.title.en}
                </h3>
                <p className="text-gray-600 text-sm">
                  {isRTL ? useCase.description.ar : useCase.description.en}
                </p>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* Pricing Section */}
      <section id="plans" className="py-20 bg-gradient-to-br from-[#0a1628] to-[#1a2744] text-white">
        <div className="container mx-auto px-4">
          <h2 className="text-3xl md:text-4xl font-bold text-center mb-12">
            {isRTL ? 'اختر طريقة الدفع:' : 'Choose how you pay:'}
          </h2>

          <div className="flex flex-col md:flex-row gap-6 justify-center items-stretch max-w-3xl mx-auto">
            {vpnPlans.map((plan) => (
              <div
                key={plan.id}
                className={cn(
                  "relative flex-1 rounded-2xl p-8 text-center transition-transform hover:scale-105",
                  plan.popular 
                    ? "bg-gradient-to-br from-blue-600 to-blue-700 shadow-xl shadow-blue-500/30" 
                    : "bg-white/10 backdrop-blur-sm"
                )}
              >
                {plan.savings && (
                  <div className="absolute -top-3 left-1/2 -translate-x-1/2 bg-green-500 text-white px-4 py-1 rounded-full text-sm font-semibold">
                    {isRTL ? plan.savingsAr : plan.savings}
                  </div>
                )}

                <h3 className="text-xl font-semibold mb-4">
                  {isRTL ? plan.nameAr : plan.name}
                </h3>

                <div className="flex items-baseline justify-center gap-1 mb-6">
                  <span className="text-4xl font-bold">${plan.price}</span>
                  <span className="text-gray-300">USD{isRTL ? plan.periodAr : plan.period}</span>
                </div>

                <a
                  href={plan.cartLink}
                  target="_blank"
                  rel="noopener noreferrer"
                  className={cn(
                    "inline-flex items-center justify-center gap-2 w-full py-3 rounded-xl font-semibold transition-all",
                    plan.popular
                      ? "bg-white text-blue-600 hover:bg-blue-50"
                      : "bg-blue-600 text-white hover:bg-blue-700"
                  )}
                >
                  {isRTL ? 'ابدأ الآن' : 'Get Started'}
                  <ArrowRight className={cn("w-4 h-4", isRTL && "rotate-180")} />
                </a>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* FAQ Section */}
      <section className="py-20 bg-gray-50">
        <div className="container mx-auto px-4">
          <h2 className="text-3xl md:text-4xl font-bold text-center text-gray-900 mb-12">
            {isRTL ? 'الأسئلة الشائعة' : 'FAQ'}
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

      {/* CTA Section */}
      <section className="py-20 bg-gradient-to-r from-blue-600 to-blue-700">
        <div className="container mx-auto px-4 text-center">
          <h2 className="text-3xl md:text-4xl font-bold text-white mb-6">
            {isRTL ? 'زد أمانك على الإنترنت مع VPN' : 'Increase your online security with a VPN'}
          </h2>
          <p className="text-blue-100 text-lg mb-8 max-w-2xl mx-auto">
            {isRTL
              ? 'إذا كنت تريد الحماية من المخترقين والمراقبة عبر الإنترنت، يمكنك جعل اتصالك أكثر أماناً مع شبكة افتراضية خاصة (VPN) من NordVPN.'
              : 'If you want protection from hackers and online monitoring, you can make your connection more secure with a virtual private network (VPN) from NordVPN.'}
          </p>
          <a
            href="#plans"
            className="inline-flex items-center gap-2 px-8 py-4 bg-white text-blue-600 rounded-xl font-semibold hover:bg-blue-50 transition-all"
          >
            {isRTL ? 'احصل على NordVPN الآن' : 'Get NordVPN Now'}
            <ArrowRight className={cn("w-5 h-5", isRTL && "rotate-180")} />
          </a>
        </div>
      </section>
    </main>
  );
}
