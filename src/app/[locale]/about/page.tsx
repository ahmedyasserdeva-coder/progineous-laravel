'use client';

import { useState, useEffect } from 'react';
import { useLocale } from 'next-intl';
import Link from 'next/link';
import { 
  ArrowLeft, 
  ChevronRight, 
  Menu, 
  X, 
  Building2, 
  Target, 
  Eye, 
  Users, 
  Award, 
  Globe, 
  Shield, 
  Zap, 
  HeartHandshake, 
  Server, 
  Clock, 
  MapPin, 
  Mail, 
  Phone,
  CheckCircle2,
  Sparkles,
  Palette,
  Download
} from 'lucide-react';
import { cn } from '@/lib/utils';
import { RTLText } from '@/components/ui/RTLText';

export default function AboutPage() {
  const locale = useLocale();
  const isRTL = locale === 'ar';
  const [activeSection, setActiveSection] = useState('intro');
  const [mobileMenuOpen, setMobileMenuOpen] = useState(false);

  const sections = [
    {
      id: 'intro',
      title: { en: 'Who We Are', ar: 'من نحن' },
      icon: Building2,
      content: {
        en: `Pro Gineous is a leading web hosting and digital services provider based in Egypt, dedicated to empowering businesses and individuals with reliable, high-performance hosting solutions.

Founded with a vision to make professional web hosting accessible to everyone, we have grown to serve thousands of clients across the Middle East and beyond. Our commitment to excellence, innovation, and customer satisfaction has made us a trusted partner for businesses of all sizes.

We pride ourselves on offering enterprise-grade infrastructure at competitive prices, backed by our team of experienced professionals who are passionate about technology and customer success.

Company Information:
• Commercial Register: 90088
• Tax Registration: 755-552-334
• Headquarters: Beni Suef, Egypt`,
        ar: `برو جينيوس هي شركة رائدة في مجال استضافة المواقع والخدمات الرقمية مقرها مصر، مكرسة لتمكين الشركات والأفراد من خلال حلول استضافة موثوقة وعالية الأداء.

تأسست برؤية لجعل استضافة المواقع الاحترافية في متناول الجميع، ونمت لخدمة آلاف العملاء في الشرق الأوسط وخارجه. التزامنا بالتميز والابتكار ورضا العملاء جعلنا شريكًا موثوقًا للشركات من جميع الأحجام.

نفخر بتقديم بنية تحتية بمستوى المؤسسات بأسعار تنافسية، مدعومة بفريقنا من المحترفين ذوي الخبرة المتحمسين للتكنولوجيا ونجاح العملاء.

معلومات الشركة:
• السجل التجاري: 90088
• رقم التسجيل الضريبي: 755-552-334
• المقر الرئيسي: بني سويف، مصر`
      }
    },
    {
      id: 'founder',
      title: { en: 'Our Founder', ar: 'المؤسس' },
      icon: Users,
      content: {
        en: `Ahmed Yasser - Founder & CEO

Ahmed Yasser founded Pro Gineous with a clear vision: to democratize access to professional web hosting services in the Middle East and make technology accessible to businesses of all sizes.

The Journey:
Ahmed's journey in technology began at a young age, driven by a passion for understanding how the digital world works. After years of experience in the technology and hosting industry, he identified a significant gap in the market - the lack of reliable, affordable, and locally-supported hosting services in the region.

In 2020, armed with technical expertise and an entrepreneurial spirit, Ahmed launched Pro Gineous from Beni Suef, Egypt. What started as a small operation has grown into a trusted hosting provider serving thousands of clients.

Vision & Aspirations:
Ahmed envisions Pro Gineous as more than just a hosting company. His goals include:

• Building the most customer-centric hosting company in the MENA region
• Empowering local businesses to compete globally through technology
• Creating employment opportunities and nurturing tech talent in Egypt
• Establishing Pro Gineous as a regional leader in cloud infrastructure
• Pioneering sustainable and environmentally responsible hosting practices

Leadership Philosophy:
"Technology should be an enabler, not a barrier. Our role is to remove the technical complexities so our clients can focus on what they do best - growing their businesses."

Under Ahmed's leadership, Pro Gineous continues to expand its services, invest in infrastructure, and maintain the high standards of customer service that have become the company's hallmark.`,
        ar: `أحمد ياسر - المؤسس والرئيس التنفيذي

أسس أحمد ياسر برو جينيوس برؤية واضحة: إضفاء الطابع الديمقراطي على الوصول إلى خدمات استضافة المواقع الاحترافية في الشرق الأوسط وجعل التكنولوجيا في متناول الشركات من جميع الأحجام.

الرحلة:
بدأت رحلة أحمد في التكنولوجيا في سن مبكرة، مدفوعة بشغف لفهم كيفية عمل العالم الرقمي. بعد سنوات من الخبرة في صناعة التكنولوجيا والاستضافة، حدد فجوة كبيرة في السوق - نقص خدمات الاستضافة الموثوقة وبأسعار معقولة والمدعومة محليًا في المنطقة.

في عام 2020، مسلحًا بالخبرة التقنية وروح ريادة الأعمال، أطلق أحمد برو جينيوس من بني سويف، مصر. ما بدأ كعملية صغيرة نما ليصبح مزود استضافة موثوقًا يخدم آلاف العملاء.

الرؤية والتطلعات:
يتصور أحمد برو جينيوس على أنها أكثر من مجرد شركة استضافة. تشمل أهدافه:

• بناء شركة الاستضافة الأكثر تركيزًا على العملاء في منطقة الشرق الأوسط وشمال أفريقيا
• تمكين الشركات المحلية من المنافسة عالميًا من خلال التكنولوجيا
• خلق فرص عمل ورعاية المواهب التقنية في مصر
• ترسيخ برو جينيوس كقائد إقليمي في البنية التحتية السحابية
• الريادة في ممارسات الاستضافة المستدامة والمسؤولة بيئيًا

فلسفة القيادة:
"يجب أن تكون التكنولوجيا عامل تمكين، وليست عائقًا. دورنا هو إزالة التعقيدات التقنية حتى يتمكن عملاؤنا من التركيز على ما يجيدونه - تنمية أعمالهم."

تحت قيادة أحمد، تواصل برو جينيوس توسيع خدماتها والاستثمار في البنية التحتية والحفاظ على معايير خدمة العملاء العالية التي أصبحت السمة المميزة للشركة.`
      }
    },
    {
      id: 'mission',
      title: { en: 'Our Mission', ar: 'مهمتنا' },
      icon: Target,
      content: {
        en: `Our mission is to provide world-class web hosting services that enable our clients to succeed online. We believe that every business, regardless of size, deserves access to reliable, fast, and secure hosting infrastructure.

We are committed to:

• Delivering exceptional uptime and performance
• Providing responsive, knowledgeable customer support
• Offering transparent pricing with no hidden fees
• Continuously innovating and improving our services
• Building long-term relationships based on trust and reliability

Every decision we make is guided by our commitment to helping our customers achieve their digital goals.`,
        ar: `مهمتنا هي تقديم خدمات استضافة مواقع عالمية المستوى تمكّن عملاءنا من النجاح على الإنترنت. نؤمن بأن كل شركة، بغض النظر عن حجمها، تستحق الوصول إلى بنية تحتية للاستضافة موثوقة وسريعة وآمنة.

نحن ملتزمون بـ:

• تقديم وقت تشغيل وأداء استثنائي
• توفير دعم عملاء سريع الاستجابة وذو معرفة
• تقديم أسعار شفافة بدون رسوم خفية
• الابتكار المستمر وتحسين خدماتنا
• بناء علاقات طويلة الأمد مبنية على الثقة والموثوقية

كل قرار نتخذه يسترشد بالتزامنا بمساعدة عملائنا على تحقيق أهدافهم الرقمية.`
      }
    },
    {
      id: 'vision',
      title: { en: 'Our Vision', ar: 'رؤيتنا' },
      icon: Eye,
      content: {
        en: `Our vision is to become the most trusted and innovative web hosting provider in the Middle East and North Africa region.

We envision a future where:

• Every business has access to enterprise-level hosting infrastructure
• Technical barriers to online success are eliminated
• Digital transformation is accessible to organizations of all sizes
• Our clients can focus on their core business while we handle their hosting needs

We are working towards building a digital ecosystem that fosters growth, innovation, and success for our clients and partners.

By 2030, we aim to:
• Serve 100,000+ active clients
• Expand our data center presence across the region
• Lead in sustainable and green hosting practices
• Pioneer new hosting technologies and solutions`,
        ar: `رؤيتنا هي أن نصبح مزود استضافة المواقع الأكثر موثوقية وابتكارًا في منطقة الشرق الأوسط وشمال أفريقيا.

نتصور مستقبلًا حيث:

• تتمتع كل شركة بالوصول إلى بنية تحتية للاستضافة بمستوى المؤسسات
• يتم القضاء على الحواجز التقنية أمام النجاح على الإنترنت
• يكون التحول الرقمي في متناول المنظمات من جميع الأحجام
• يمكن لعملائنا التركيز على أعمالهم الأساسية بينما نتولى احتياجات استضافتهم

نحن نعمل على بناء نظام بيئي رقمي يعزز النمو والابتكار والنجاح لعملائنا وشركائنا.

بحلول عام 2030، نهدف إلى:
• خدمة أكثر من 100,000 عميل نشط
• توسيع تواجد مراكز البيانات لدينا في المنطقة
• الريادة في ممارسات الاستضافة المستدامة والخضراء
• ابتكار تقنيات وحلول استضافة جديدة`
      }
    },
    {
      id: 'values',
      title: { en: 'Our Values', ar: 'قيمنا' },
      icon: HeartHandshake,
      content: {
        en: `Our core values guide everything we do at Pro Gineous:

Customer First
Our customers are at the heart of everything we do. We listen, understand, and deliver solutions that meet their unique needs.

Reliability & Trust
We build trust through consistent performance, transparent communication, and keeping our promises.

Innovation
We continuously explore new technologies and approaches to deliver better solutions for our clients.

Excellence
We strive for excellence in every aspect of our service, from technical performance to customer support.

Integrity
We conduct business with honesty, transparency, and ethical standards that earn our customers' trust.

Growth Mindset
We believe in continuous learning and improvement, both as a company and as individuals.

Community
We are committed to giving back to the communities we serve and supporting the growth of the digital ecosystem in our region.`,
        ar: `قيمنا الأساسية توجه كل ما نقوم به في برو جينيوس:

العميل أولاً
عملاؤنا في قلب كل ما نفعله. نستمع ونفهم ونقدم حلولًا تلبي احتياجاتهم الفريدة.

الموثوقية والثقة
نبني الثقة من خلال الأداء المتسق والتواصل الشفاف والوفاء بوعودنا.

الابتكار
نستكشف باستمرار التقنيات والأساليب الجديدة لتقديم حلول أفضل لعملائنا.

التميز
نسعى للتميز في كل جانب من جوانب خدمتنا، من الأداء التقني إلى دعم العملاء.

النزاهة
نمارس الأعمال بصدق وشفافية ومعايير أخلاقية تكسب ثقة عملائنا.

عقلية النمو
نؤمن بالتعلم والتحسين المستمر، كشركة وكأفراد.

المجتمع
نحن ملتزمون برد الجميل للمجتمعات التي نخدمها ودعم نمو النظام البيئي الرقمي في منطقتنا.`
      }
    },
    {
      id: 'services',
      title: { en: 'Our Services', ar: 'خدماتنا' },
      icon: Server,
      content: {
        en: `We offer a comprehensive range of hosting and digital services:

Shared Web Hosting
Affordable, reliable hosting perfect for personal websites and small businesses. Plans include Startup, Essential, and Ultimate tiers.

VPS Hosting
Scalable virtual private servers with dedicated resources. Choose from VPS 100, VPS 101, VPS 102, and VPS 103 plans.

Reseller Hosting
Start your own hosting business with our white-label reseller solutions. Available in Go Reseller, Prof Reseller, and Premium Reseller packages.

Cloud Hosting
High-availability cloud infrastructure for mission-critical applications.

Dedicated Servers
Full server resources for demanding workloads and enterprise applications.

Email Hosting
Professional email solutions with your own domain.

Domain Registration
Register and manage domain names across hundreds of extensions.

SSL Certificates
Secure your website with trusted SSL certificates.

Website Security
Protect your online presence with our security solutions.`,
        ar: `نقدم مجموعة شاملة من خدمات الاستضافة والخدمات الرقمية:

استضافة الويب المشتركة
استضافة بأسعار معقولة وموثوقة مثالية للمواقع الشخصية والشركات الصغيرة. تشمل الخطط Startup و Essential و Ultimate.

استضافة VPS
خوادم افتراضية خاصة قابلة للتوسع مع موارد مخصصة. اختر من خطط VPS 100 و VPS 101 و VPS 102 و VPS 103.

استضافة الموزعين
ابدأ عملك الخاص في الاستضافة مع حلول الموزعين ذات العلامة البيضاء. متوفرة في باقات Go Reseller و Prof Reseller و Premium Reseller.

الاستضافة السحابية
بنية تحتية سحابية عالية التوفر للتطبيقات الحرجة.

الخوادم المخصصة
موارد خادم كاملة لأعباء العمل المتطلبة وتطبيقات المؤسسات.

استضافة البريد الإلكتروني
حلول بريد إلكتروني احترافية بنطاقك الخاص.

تسجيل النطاقات
سجل وأدر أسماء النطاقات عبر مئات الامتدادات.

شهادات SSL
أمّن موقعك بشهادات SSL موثوقة.

أمان المواقع
احمِ تواجدك على الإنترنت بحلولنا الأمنية.`
      }
    },
    {
      id: 'why-us',
      title: { en: 'Why Choose Us', ar: 'لماذا تختارنا' },
      icon: Award,
      content: {
        en: `There are many reasons why thousands of clients trust Pro Gineous for their hosting needs:

99.9% Uptime Guarantee
We guarantee industry-leading uptime for all our hosting services, ensuring your website is always available.

24/7 Expert Support
Our knowledgeable support team is available around the clock to help you with any issues or questions.

High-Performance Infrastructure
We use the latest hardware and technologies to deliver lightning-fast performance for your websites and applications.

Free Website Migration
Moving from another host? We'll migrate your website for free with zero downtime.

Daily Backups
Your data is automatically backed up daily, giving you peace of mind and easy recovery options.

Money-Back Guarantee
Not satisfied? We offer a 30-day money-back guarantee on most hosting plans.

Local Support in Arabic
Get support in your language from a team that understands your market.

Competitive Pricing
Enterprise-grade hosting at prices that fit your budget, with no hidden fees.

Easy-to-Use Control Panel
Manage your hosting with our intuitive cPanel interface - no technical expertise required.`,
        ar: `هناك العديد من الأسباب التي تجعل آلاف العملاء يثقون في برو جينيوس لاحتياجات استضافتهم:

ضمان وقت تشغيل 99.9%
نضمن وقت تشغيل رائد في الصناعة لجميع خدمات الاستضافة لدينا، مما يضمن توفر موقعك دائمًا.

دعم خبراء على مدار الساعة
فريق الدعم المتخصص لدينا متاح على مدار الساعة لمساعدتك في أي مشاكل أو أسئلة.

بنية تحتية عالية الأداء
نستخدم أحدث الأجهزة والتقنيات لتقديم أداء فائق السرعة لمواقعك وتطبيقاتك.

نقل موقع مجاني
تنتقل من مضيف آخر؟ سننقل موقعك مجانًا بدون توقف.

نسخ احتياطية يومية
يتم نسخ بياناتك احتياطيًا تلقائيًا يوميًا، مما يمنحك راحة البال وخيارات استرداد سهلة.

ضمان استرداد الأموال
غير راضٍ؟ نقدم ضمان استرداد الأموال لمدة 30 يومًا على معظم خطط الاستضافة.

دعم محلي بالعربية
احصل على الدعم بلغتك من فريق يفهم سوقك.

أسعار تنافسية
استضافة بمستوى المؤسسات بأسعار تناسب ميزانيتك، بدون رسوم خفية.

لوحة تحكم سهلة الاستخدام
أدر استضافتك مع واجهة cPanel البديهية - لا حاجة لخبرة تقنية.`
      }
    },
    {
      id: 'infrastructure',
      title: { en: 'Our Infrastructure', ar: 'بنيتنا التحتية' },
      icon: Globe,
      content: {
        en: `We've invested heavily in building a world-class infrastructure to deliver the best hosting experience:

Data Centers
Our servers are housed in Tier-3+ data centers with:
• Redundant power supplies and generators
• Advanced cooling systems
• 24/7 physical security and surveillance
• Multiple network carriers for redundancy

Hardware
We use enterprise-grade hardware including:
• Latest generation Intel/AMD processors
• NVMe SSD storage for maximum speed
• ECC RAM for data integrity
• Redundant RAID configurations

Network
Our network infrastructure features:
• Multiple 10Gbps+ uplinks
• DDoS protection
• Global CDN integration
• Low-latency routing

Security
Multi-layered security including:
• Hardware firewalls
• Intrusion detection systems
• Regular security audits
• Automated malware scanning

Monitoring
24/7 infrastructure monitoring with:
• Real-time performance metrics
• Automated alerting
• Proactive issue resolution
• 99.9% uptime SLA`,
        ar: `لقد استثمرنا بكثافة في بناء بنية تحتية عالمية المستوى لتقديم أفضل تجربة استضافة:

مراكز البيانات
خوادمنا موجودة في مراكز بيانات من المستوى 3+ مع:
• مصادر طاقة ومولدات احتياطية
• أنظمة تبريد متقدمة
• أمن مادي ومراقبة على مدار الساعة
• ناقلات شبكة متعددة للتكرار

الأجهزة
نستخدم أجهزة بمستوى المؤسسات تشمل:
• معالجات Intel/AMD من أحدث جيل
• تخزين NVMe SSD لأقصى سرعة
• ذاكرة ECC RAM لسلامة البيانات
• تكوينات RAID متكررة

الشبكة
تتميز بنية شبكتنا التحتية بـ:
• روابط متعددة بسرعة 10+ جيجابت
• حماية DDoS
• تكامل CDN عالمي
• توجيه منخفض التأخير

الأمان
أمان متعدد الطبقات يشمل:
• جدران حماية الأجهزة
• أنظمة كشف التسلل
• تدقيقات أمنية منتظمة
• فحص برامج ضارة آلي

المراقبة
مراقبة البنية التحتية على مدار الساعة مع:
• مقاييس أداء في الوقت الفعلي
• تنبيهات آلية
• حل المشاكل الاستباقي
• اتفاقية مستوى خدمة بوقت تشغيل 99.9%`
      }
    },
    {
      id: 'brand-identity',
      title: { en: 'Brand Identity', ar: 'هوية الشركة' },
      icon: Palette,
      content: {
        en: `Our brand identity represents our commitment to professionalism, innovation, and trust. Below are our official logos and brand assets approved for use.

Usage Guidelines:
• Always use the official logo files provided below
• Maintain adequate clear space around the logo
• Do not alter, rotate, or distort the logo
• Use appropriate logo versions for different backgrounds
• Contact us for partnership or media inquiries regarding logo usage

Primary Brand Color: #1d71b8
Secondary Colors: #0d4a7a, #1557a0

For press inquiries or brand asset requests, please contact: marketing@progineous.com`,
        ar: `تمثل هوية علامتنا التجارية التزامنا بالاحترافية والابتكار والثقة. فيما يلي شعاراتنا الرسمية وأصول العلامة التجارية المعتمدة للاستخدام.

إرشادات الاستخدام:
• استخدم دائمًا ملفات الشعار الرسمية المتوفرة أدناه
• حافظ على مساحة خالية كافية حول الشعار
• لا تقم بتغيير أو تدوير أو تشويه الشعار
• استخدم إصدارات الشعار المناسبة للخلفيات المختلفة
• تواصل معنا للشراكات أو استفسارات وسائل الإعلام بخصوص استخدام الشعار

اللون الأساسي للعلامة: #1d71b8
الألوان الثانوية: #0d4a7a، #1557a0

للاستفسارات الصحفية أو طلبات أصول العلامة التجارية، يرجى التواصل: marketing@progineous.com`
      }
    },
    {
      id: 'contact',
      title: { en: 'Contact Us', ar: 'اتصل بنا' },
      icon: Mail,
      content: {
        en: `We'd love to hear from you! Get in touch with our team:

Headquarters:
Pro Gineous
9 Mustafa Kamel Street
Balwalidain Ihsanah Tower
Beni Suef, Egypt

Email Contacts:
• General Inquiries: info@progineous.com
• Sales: sales@progineous.com
• Support: support@progineous.com
• Billing: billing@progineous.com
• Abuse Reports: abuse@progineous.com

Online:
• Website: www.progineous.com
• Client Area: app.progineous.com
• Support Portal: app.progineous.com/submitticket.php

Business Hours:
Sunday - Thursday: 9:00 AM - 6:00 PM (Egypt Time)
Friday - Saturday: Closed
(24/7 Emergency Support Available)

Company Details:
• Commercial Register: 90088
• Tax Registration Number: 755-552-334

We typically respond to inquiries within 24 hours during business days.`,
        ar: `نود أن نسمع منك! تواصل مع فريقنا:

المقر الرئيسي:
برو جينيوس
9 شارع مصطفى كامل
برج بالوالدين إحسانًا
بني سويف، مصر

البريد الإلكتروني:
• الاستفسارات العامة: info@progineous.com
• المبيعات: sales@progineous.com
• الدعم: support@progineous.com
• الفوترة: billing@progineous.com
• تقارير الإساءة: abuse@progineous.com

عبر الإنترنت:
• الموقع: www.progineous.com
• منطقة العملاء: app.progineous.com
• بوابة الدعم: app.progineous.com/submitticket.php

ساعات العمل:
الأحد - الخميس: 9:00 صباحًا - 6:00 مساءً (توقيت مصر)
الجمعة - السبت: مغلق
(دعم الطوارئ متاح على مدار الساعة)

تفاصيل الشركة:
• السجل التجاري: 90088
• رقم التسجيل الضريبي: 755-552-334

نستجيب عادة للاستفسارات خلال 24 ساعة في أيام العمل.`
      }
    }
  ];

  // Stats data
  const stats = [
    { value: '10,000+', label: { en: 'Active Clients', ar: 'عميل نشط' } },
    { value: '99.9%', label: { en: 'Uptime', ar: 'وقت التشغيل' } },
    { value: '24/7', label: { en: 'Support', ar: 'الدعم' } },
    { value: '50,000+', label: { en: 'Domains Hosted', ar: 'نطاق مستضاف' } }
  ];

  useEffect(() => {
    const handleScroll = () => {
      const sectionElements = sections.map(section => ({
        id: section.id,
        element: document.getElementById(section.id)
      }));

      const scrollPosition = window.scrollY + 150;

      for (let i = sectionElements.length - 1; i >= 0; i--) {
        const section = sectionElements[i];
        if (section.element && section.element.offsetTop <= scrollPosition) {
          setActiveSection(section.id);
          break;
        }
      }
    };

    window.addEventListener('scroll', handleScroll);
    handleScroll();

    return () => window.removeEventListener('scroll', handleScroll);
  }, []);

  const scrollToSection = (sectionId: string) => {
    const element = document.getElementById(sectionId);
    if (element) {
      const offsetTop = element.offsetTop - 100;
      window.scrollTo({
        top: offsetTop,
        behavior: 'smooth'
      });
      setMobileMenuOpen(false);
    }
  };

  const relatedLinks = [
    { title: { en: 'Terms of Service', ar: 'شروط الخدمة' }, href: `/${locale}/terms` },
    { title: { en: 'Privacy Policy', ar: 'سياسة الخصوصية' }, href: `/${locale}/privacy` },
    { title: { en: 'Acceptable Use Policy', ar: 'سياسة الاستخدام المقبول' }, href: `/${locale}/aup` },
    { title: { en: 'DMCA Policy', ar: 'سياسة DMCA' }, href: `/${locale}/dmca` },
    { title: { en: 'Refund & Billing', ar: 'الاسترداد والفوترة' }, href: `/${locale}/refund` },
    { title: { en: 'Affiliate Program', ar: 'برنامج الأفلييت' }, href: `/${locale}/affiliate` },
    { title: { en: 'Refer a Friend', ar: 'إحالة صديق' }, href: `/${locale}/refer-friend` }
  ];

  // JSON-LD Structured Data
  const baseUrl = process.env.NEXT_PUBLIC_SITE_URL || 'https://progineous.com';

  const organizationSchema = {
    '@context': 'https://schema.org',
    '@type': 'Organization',
    name: 'Pro Gineous',
    alternateName: isRTL ? 'بروجينيوس' : 'Pro Gineous',
    url: baseUrl,
    logo: `${baseUrl}/images/logos/progineous-logo.png`,
    foundingDate: '2020',
    founder: {
      '@type': 'Person',
      name: isRTL ? 'أحمد ياسر' : 'Ahmed Yasser',
      jobTitle: isRTL ? 'المؤسس والرئيس التنفيذي' : 'Founder & CEO',
    },
    address: {
      '@type': 'PostalAddress',
      streetAddress: isRTL ? '9 شارع مصطفى كامل، برج بالوالدين إحسانًا' : '9 Mustafa Kamel Street, Balwalidain Ihsanah Tower',
      addressLocality: isRTL ? 'بني سويف' : 'Beni Suef',
      addressCountry: 'EG',
    },
    contactPoint: [
      {
        '@type': 'ContactPoint',
        telephone: '+20-1000000000',
        contactType: 'customer service',
        availableLanguage: ['Arabic', 'English'],
      },
      {
        '@type': 'ContactPoint',
        email: 'support@progineous.com',
        contactType: 'technical support',
      },
      {
        '@type': 'ContactPoint',
        email: 'sales@progineous.com',
        contactType: 'sales',
      },
    ],
    sameAs: [
      'https://facebook.com/progineous',
      'https://twitter.com/progineous',
      'https://linkedin.com/company/progineous',
    ],
    description: isRTL
      ? 'شركة استضافة مواقع رائدة في مصر والشرق الأوسط تقدم حلول استضافة موثوقة وعالية الأداء'
      : 'A leading web hosting company in Egypt and the Middle East providing reliable, high-performance hosting solutions',
  };

  const aboutPageSchema = {
    '@context': 'https://schema.org',
    '@type': 'AboutPage',
    name: isRTL ? 'من نحن - بروجينيوس' : 'About Us - Pro Gineous',
    description: isRTL
      ? 'تعرف على بروجينيوس - شريكك الموثوق في استضافة المواقع والخدمات الرقمية'
      : 'Learn about Pro Gineous - Your trusted partner in web hosting and digital services',
    url: `${baseUrl}/${locale}/about`,
    mainEntity: {
      '@type': 'Organization',
      name: 'Pro Gineous',
    },
  };

  const breadcrumbSchema = {
    '@context': 'https://schema.org',
    '@type': 'BreadcrumbList',
    itemListElement: [
      { '@type': 'ListItem', position: 1, name: isRTL ? 'الرئيسية' : 'Home', item: `${baseUrl}/${locale}` },
      { '@type': 'ListItem', position: 2, name: isRTL ? 'من نحن' : 'About Us', item: `${baseUrl}/${locale}/about` },
    ],
  };

  const localBusinessSchema = {
    '@context': 'https://schema.org',
    '@type': 'LocalBusiness',
    '@id': `${baseUrl}/#organization`,
    name: 'Pro Gineous',
    image: `${baseUrl}/images/logos/progineous-logo.png`,
    priceRange: '$$',
    address: {
      '@type': 'PostalAddress',
      streetAddress: '9 Mustafa Kamel Street, Balwalidain Ihsanah Tower',
      addressLocality: 'Beni Suef',
      addressCountry: 'EG',
    },
    openingHours: 'Su-Th 09:00-18:00',
    aggregateRating: {
      '@type': 'AggregateRating',
      ratingValue: '4.8',
      reviewCount: '1500',
    },
  };

  return (
    <div className={`min-h-screen bg-gray-50 ${isRTL ? 'rtl' : 'ltr'}`}>
      {/* JSON-LD Structured Data */}
      <script type="application/ld+json" dangerouslySetInnerHTML={{ __html: JSON.stringify(organizationSchema) }} />
      <script type="application/ld+json" dangerouslySetInnerHTML={{ __html: JSON.stringify(aboutPageSchema) }} />
      <script type="application/ld+json" dangerouslySetInnerHTML={{ __html: JSON.stringify(breadcrumbSchema) }} />
      <script type="application/ld+json" dangerouslySetInnerHTML={{ __html: JSON.stringify(localBusinessSchema) }} />

      {/* Header */}
      <div className="relative bg-linear-to-br from-[#1d71b8] via-[#1557a0] to-[#0d4a7a] text-white overflow-hidden">
        {/* Background Pattern */}
        <div className="absolute inset-0 opacity-10">
          <div className="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg_width=%2760%27_height=%2760%27_viewBox=%270_0_60_60%27_xmlns=%27http://www.w3.org/2000/svg%27%3E%3Cg_fill=%27none%27_fill-rule=%27evenodd%27%3E%3Cg_fill=%27%23ffffff%27_fill-opacity=%270.4%27%3E%3Cpath_d=%27M36_34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6_34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6_4V0H4v4H0v2h4v4h2V6h4V4H6z%27/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')]" />
        </div>
        
        {/* Floating Elements */}
        <div className="absolute top-20 left-10 w-20 h-20 bg-white/5 rounded-full blur-xl" />
        <div className="absolute bottom-10 right-20 w-32 h-32 bg-white/5 rounded-full blur-2xl" />
        
        <div className="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-28">
          <div className="text-center">
            {/* Badge */}
            <div className="inline-flex items-center gap-2 px-4 py-2 bg-white/10 backdrop-blur-sm rounded-full mb-6">
              <span className="text-sm font-medium">
                {isRTL ? 'منذ 2020' : 'Since 2020'}
              </span>
            </div>
            
            {/* Title */}
            <h1 className="text-4xl lg:text-6xl font-bold mb-6">
              {isRTL ? 'من نحن' : 'About Us'}
            </h1>
            
            {/* Subtitle */}
            <p className="text-xl text-blue-100 max-w-3xl mx-auto mb-10">
              {isRTL
                ? 'شريكك الموثوق في استضافة المواقع والخدمات الرقمية - نبني النجاح الرقمي معًا'
                : 'Your trusted partner in web hosting and digital services - Building digital success together'}
            </p>

            {/* Stats */}
            <div className="grid grid-cols-2 md:grid-cols-4 gap-6 max-w-4xl mx-auto">
              {stats.map((stat, index) => (
                <div key={index} className="bg-white/10 backdrop-blur-sm rounded-xl p-4">
                  <div className="text-3xl lg:text-4xl font-bold mb-1">{stat.value}</div>
                  <div className="text-sm text-blue-100">{stat.label[locale as 'en' | 'ar']}</div>
                </div>
              ))}
            </div>
          </div>
        </div>
        
        {/* Wave */}
        <div className="absolute bottom-0 left-0 right-0">
          <svg viewBox="0 0 1440 60" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0 60L1440 60L1440 0C1440 0 1140 60 720 60C300 60 0 0 0 0L0 60Z" fill="#F9FAFB" />
          </svg>
        </div>
      </div>

      {/* Mobile Menu Button */}
      <div className="lg:hidden sticky top-0 z-20 bg-white border-b border-gray-200 px-4 py-3">
        <button
          onClick={() => setMobileMenuOpen(!mobileMenuOpen)}
          className="flex items-center gap-2 text-gray-600"
        >
          {mobileMenuOpen ? <X className="w-5 h-5" /> : <Menu className="w-5 h-5" />}
          <span className="font-medium">{isRTL ? 'المحتويات' : 'Contents'}</span>
        </button>
      </div>

      {/* Mobile Navigation */}
      {mobileMenuOpen && (
        <div className="lg:hidden fixed inset-0 top-14.25 bg-white z-10 overflow-y-auto">
          <nav className="p-4">
            {sections.map((section, index) => {
              const Icon = section.icon;
              return (
                <button
                  key={section.id}
                  onClick={() => scrollToSection(section.id)}
                  className={cn(
                    'w-full flex items-center gap-3 px-4 py-3 rounded-lg text-sm mb-1',
                    activeSection === section.id
                      ? 'bg-[#1d71b8] text-white'
                      : 'text-gray-600 hover:bg-gray-100'
                  )}
                >
                  <Icon className="w-5 h-5" />
                  <span className="font-medium">{section.title[locale as 'en' | 'ar']}</span>
                </button>
              );
            })}
          </nav>
        </div>
      )}

      {/* Main Content */}
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div className="flex flex-col lg:flex-row gap-8">
          {/* Sidebar */}
          <div className="hidden lg:block lg:w-72 shrink-0">
            <div className="sticky top-8">
              <nav className="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                <h3 className="font-semibold text-gray-900 mb-4 px-3">
                  {isRTL ? 'المحتويات' : 'Contents'}
                </h3>
                <ul className="space-y-1">
                  {sections.map((section) => {
                    const Icon = section.icon;
                    return (
                      <li key={section.id}>
                        <button
                          onClick={() => scrollToSection(section.id)}
                          className={cn(
                            'w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all',
                            activeSection === section.id
                              ? 'bg-[#1d71b8] text-white shadow-md'
                              : 'text-gray-600 hover:bg-gray-100'
                          )}
                        >
                          <Icon className={cn(
                            'w-4 h-4',
                            activeSection === section.id ? 'text-white' : 'text-gray-400'
                          )} />
                          <span className="truncate font-medium">
                            {section.title[locale as 'en' | 'ar']}
                          </span>
                        </button>
                      </li>
                    );
                  })}
                </ul>
              </nav>

              {/* Related Links */}
              <div className="mt-6 bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                <h3 className="font-semibold text-gray-900 mb-4 px-3">
                  {isRTL ? 'روابط مفيدة' : 'Useful Links'}
                </h3>
                <ul className="space-y-2">
                  {relatedLinks.map((link, index) => (
                    <li key={index}>
                      <Link
                        href={link.href}
                        className="flex items-center gap-2 px-3 py-2 text-sm text-gray-600 hover:text-[#1d71b8] hover:bg-blue-50 rounded-lg transition-colors"
                      >
                        <ChevronRight className={cn('w-4 h-4', isRTL && 'rotate-180')} />
                        {link.title[locale as 'en' | 'ar']}
                      </Link>
                    </li>
                  ))}
                </ul>
              </div>

              {/* CTA Card */}
              <div className="mt-6 bg-linear-to-br from-[#1d71b8] to-[#0d4a7a] rounded-xl p-6 text-white">
                <h3 className="font-bold mb-2">
                  {isRTL ? 'هل أنت مستعد للبدء؟' : 'Ready to Get Started?'}
                </h3>
                <p className="text-sm text-blue-100 mb-4">
                  {isRTL
                    ? 'انضم إلى آلاف العملاء الذين يثقون في برو جينيوس'
                    : 'Join thousands of clients who trust Pro Gineous'}
                </p>
                <Link
                  href={`/${locale}/hosting/shared`}
                  className="inline-flex items-center gap-2 bg-white text-[#1d71b8] px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-50 transition-colors"
                >
                  {isRTL ? 'تصفح الخطط' : 'View Plans'}
                  <ChevronRight className={cn('w-4 h-4', isRTL && 'rotate-180')} />
                </Link>
              </div>
            </div>
          </div>

          {/* Content */}
          <div className="flex-1 min-w-0">
            <div className="space-y-8">
              {sections.map((section) => {
                const Icon = section.icon;
                return (
                  <section
                    key={section.id}
                    id={section.id}
                    className="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden scroll-mt-24"
                  >
                    <div className="p-6 lg:p-8">
                      <div className="flex items-start gap-4 mb-6">
                        <div className="flex items-center justify-center w-12 h-12 bg-linear-to-br from-[#1d71b8] to-[#0d4a7a] text-white rounded-xl shadow-lg shrink-0">
                          <Icon className="w-6 h-6" />
                        </div>
                        <div>
                          <h2 className="text-2xl lg:text-3xl font-bold text-gray-900">
                            {section.title[locale as 'en' | 'ar']}
                          </h2>
                        </div>
                      </div>
                      <div className="prose prose-gray max-w-none">
                        {(section.content[locale as 'en' | 'ar']).split('\n\n').map((paragraph, pIndex) => (
                          <p key={pIndex} className="text-gray-600 leading-relaxed whitespace-pre-line mb-4">
                            {isRTL ? <RTLText>{paragraph}</RTLText> : paragraph}
                          </p>
                        ))}
                      </div>
                      
                      {/* Brand Identity Logos Gallery */}
                      {section.id === 'brand-identity' && (
                        <div className="mt-8">
                          {/* Primary Logo */}
                          <div className="mb-8">
                            <h3 className="text-lg font-semibold text-gray-900 mb-4">
                              {isRTL ? 'الشعار الرئيسي' : 'Primary Logo'}
                            </h3>
                            <div className="grid md:grid-cols-2 gap-4">
                              <div className="bg-white border-2 border-gray-200 rounded-xl p-8 flex flex-col items-center justify-center">
                                <img 
                                  src="/images/progineous-id/pro Gineous_logo.svg" 
                                  alt="Pro Gineous Primary Logo" 
                                  className="h-16 w-auto mb-4"
                                />
                                <span className="text-sm text-gray-500 mb-3">
                                  {isRTL ? 'الشعار الكامل - خلفية فاتحة' : 'Full Logo - Light Background'}
                                </span>
                                <a 
                                  href="/images/progineous-id/pro Gineous_logo.svg" 
                                  download
                                  className="inline-flex items-center gap-2 text-sm text-[#1d71b8] hover:text-[#155a94] font-medium"
                                >
                                  <Download className="w-4 h-4" />
                                  {isRTL ? 'تحميل SVG' : 'Download SVG'}
                                </a>
                              </div>
                              <div className="bg-[#1d71b8] rounded-xl p-8 flex flex-col items-center justify-center">
                                <img 
                                  src="/images/progineous-id/pro Gineous_white logo.svg" 
                                  alt="Pro Gineous White Logo" 
                                  className="h-16 w-auto mb-4"
                                />
                                <span className="text-sm text-white/70 mb-3">
                                  {isRTL ? 'الشعار الأبيض - خلفية داكنة' : 'White Logo - Dark Background'}
                                </span>
                                <a 
                                  href="/images/progineous-id/pro Gineous_white logo.svg" 
                                  download
                                  className="inline-flex items-center gap-2 text-sm text-white hover:text-white/80 font-medium"
                                >
                                  <Download className="w-4 h-4" />
                                  {isRTL ? 'تحميل SVG' : 'Download SVG'}
                                </a>
                              </div>
                            </div>
                          </div>

                          {/* Favicon */}
                          <div className="mb-8">
                            <h3 className="text-lg font-semibold text-gray-900 mb-4">
                              {isRTL ? 'الأيقونة المفضلة (Favicon)' : 'Favicon'}
                            </h3>
                            <div className="bg-gray-50 border border-gray-200 rounded-xl p-8 flex flex-col items-center justify-center max-w-xs">
                              <img 
                                src="/images/progineous-id/pro Gineous_favico.svg" 
                                alt="Pro Gineous Favicon" 
                                className="h-16 w-16 mb-4"
                              />
                              <span className="text-sm text-gray-500 mb-3">
                                {isRTL ? 'أيقونة الموقع' : 'Website Icon'}
                              </span>
                              <a 
                                href="/images/progineous-id/pro Gineous_favico.svg" 
                                download
                                className="inline-flex items-center gap-2 text-sm text-[#1d71b8] hover:text-[#155a94] font-medium"
                              >
                                <Download className="w-4 h-4" />
                                {isRTL ? 'تحميل SVG' : 'Download SVG'}
                              </a>
                            </div>
                          </div>

                          {/* Logo Variations */}
                          <div className="mb-8">
                            <h3 className="text-lg font-semibold text-gray-900 mb-4">
                              {isRTL ? 'تنويعات الشعار' : 'Logo Variations'}
                            </h3>
                            <div className="grid md:grid-cols-2 gap-4">
                              {/* White Logo with Blue Icon */}
                              <div className="bg-[#0d4a7a] rounded-xl p-6 flex flex-col items-center justify-center">
                                <img 
                                  src="/images/progineous-id/pro Gineous_white logo_blue icon.svg" 
                                  alt="White Logo Blue Icon" 
                                  className="h-12 w-auto mb-3"
                                />
                                <span className="text-sm text-white/70 mb-2 text-center">
                                  {isRTL ? 'شعار أبيض مع أيقونة زرقاء' : 'White Logo - Blue Icon'}
                                </span>
                                <a 
                                  href="/images/progineous-id/pro Gineous_white logo_blue icon.svg" 
                                  download
                                  className="inline-flex items-center gap-1 text-xs text-white hover:text-white/80 font-medium"
                                >
                                  <Download className="w-3 h-3" />
                                  {isRTL ? 'تحميل' : 'Download'}
                                </a>
                              </div>

                              {/* White Logo with Blue Logo */}
                              <div className="bg-[#0d4a7a] rounded-xl p-6 flex flex-col items-center justify-center">
                                <img 
                                  src="/images/progineous-id/pro Gineous_white logo_blue logo.svg" 
                                  alt="White Logo Blue Logo" 
                                  className="h-12 w-auto mb-3"
                                />
                                <span className="text-sm text-white/70 mb-2 text-center">
                                  {isRTL ? 'شعار أبيض مع نص أزرق' : 'White Logo - Blue Text'}
                                </span>
                                <a 
                                  href="/images/progineous-id/pro Gineous_white logo_blue logo.svg" 
                                  download
                                  className="inline-flex items-center gap-1 text-xs text-white hover:text-white/80 font-medium"
                                >
                                  <Download className="w-3 h-3" />
                                  {isRTL ? 'تحميل' : 'Download'}
                                </a>
                              </div>

                              {/* White Logo with White Icon */}
                              <div className="bg-linear-to-br from-[#1d71b8] to-[#0d4a7a] rounded-xl p-6 flex flex-col items-center justify-center">
                                <img 
                                  src="/images/progineous-id/pro Gineous_white logo_white icon.svg" 
                                  alt="White Logo White Icon" 
                                  className="h-12 w-auto mb-3"
                                />
                                <span className="text-sm text-white/70 mb-2 text-center">
                                  {isRTL ? 'شعار أبيض مع أيقونة بيضاء' : 'White Logo - White Icon'}
                                </span>
                                <a 
                                  href="/images/progineous-id/pro Gineous_white logo_white icon.svg" 
                                  download
                                  className="inline-flex items-center gap-1 text-xs text-white hover:text-white/80 font-medium"
                                >
                                  <Download className="w-3 h-3" />
                                  {isRTL ? 'تحميل' : 'Download'}
                                </a>
                              </div>

                              {/* White Logo with White Logo */}
                              <div className="bg-linear-to-br from-[#1d71b8] to-[#0d4a7a] rounded-xl p-6 flex flex-col items-center justify-center">
                                <img 
                                  src="/images/progineous-id/pro Gineous_white logo_white logo.svg" 
                                  alt="White Logo White Logo" 
                                  className="h-12 w-auto mb-3"
                                />
                                <span className="text-sm text-white/70 mb-2 text-center">
                                  {isRTL ? 'شعار أبيض بالكامل' : 'Full White Logo'}
                                </span>
                                <a 
                                  href="/images/progineous-id/pro Gineous_white logo_white logo.svg" 
                                  download
                                  className="inline-flex items-center gap-1 text-xs text-white hover:text-white/80 font-medium"
                                >
                                  <Download className="w-3 h-3" />
                                  {isRTL ? 'تحميل' : 'Download'}
                                </a>
                              </div>
                            </div>
                          </div>

                          {/* Alternate White Logo */}
                          <div>
                            <h3 className="text-lg font-semibold text-gray-900 mb-4">
                              {isRTL ? 'الشعار البديل' : 'Alternate Logo'}
                            </h3>
                            <div className="bg-gray-900 rounded-xl p-8 flex flex-col items-center justify-center max-w-md">
                              <img 
                                src="/images/progineous-id/pro Gineous_white logo-09.svg" 
                                alt="Pro Gineous Alternate Logo" 
                                className="h-14 w-auto mb-4"
                              />
                              <span className="text-sm text-gray-400 mb-3">
                                {isRTL ? 'الشعار البديل - خلفيات داكنة' : 'Alternate Logo - Dark Backgrounds'}
                              </span>
                              <a 
                                href="/images/progineous-id/pro Gineous_white logo-09.svg" 
                                download
                                className="inline-flex items-center gap-2 text-sm text-white hover:text-gray-300 font-medium"
                              >
                                <Download className="w-4 h-4" />
                                {isRTL ? 'تحميل SVG' : 'Download SVG'}
                              </a>
                            </div>
                          </div>

                          {/* Brand Colors */}
                          <div className="mt-8">
                            <h3 className="text-lg font-semibold text-gray-900 mb-4">
                              {isRTL ? 'ألوان العلامة التجارية' : 'Brand Colors'}
                            </h3>
                            <div className="grid grid-cols-3 gap-4">
                              <div className="text-center">
                                <div className="w-full h-20 bg-[#1d71b8] rounded-lg mb-2 shadow-md"></div>
                                <span className="text-sm font-medium text-gray-900">{isRTL ? 'أساسي' : 'Primary'}</span>
                                <p className="text-xs text-gray-500">#1d71b8</p>
                              </div>
                              <div className="text-center">
                                <div className="w-full h-20 bg-[#0d4a7a] rounded-lg mb-2 shadow-md"></div>
                                <span className="text-sm font-medium text-gray-900">{isRTL ? 'ثانوي' : 'Secondary'}</span>
                                <p className="text-xs text-gray-500">#0d4a7a</p>
                              </div>
                              <div className="text-center">
                                <div className="w-full h-20 bg-[#1557a0] rounded-lg mb-2 shadow-md"></div>
                                <span className="text-sm font-medium text-gray-900">{isRTL ? 'متوسط' : 'Accent'}</span>
                                <p className="text-xs text-gray-500">#1557a0</p>
                              </div>
                            </div>
                          </div>
                        </div>
                      )}
                    </div>
                  </section>
                );
              })}
            </div>

            {/* Bottom CTA */}
            <div className="mt-12 bg-linear-to-br from-[#0a1628] to-[#1d3a5c] rounded-2xl p-8 text-white">
              <div className="flex flex-col md:flex-row items-center justify-between gap-6">
                <div>
                  <h3 className="text-2xl font-bold mb-2">
                    {isRTL ? 'هل لديك أسئلة؟' : 'Have Questions?'}
                  </h3>
                  <p className="text-white/70">
                    {isRTL 
                      ? 'فريقنا جاهز لمساعدتك. تواصل معنا اليوم!'
                      : 'Our team is ready to help. Get in touch today!'
                    }
                  </p>
                </div>
                <div className="flex flex-col sm:flex-row gap-3">
                  <a 
                    href="mailto:info@progineous.com"
                    className="inline-flex items-center justify-center gap-2 bg-white text-[#1d71b8] px-6 py-3 rounded-lg font-medium hover:bg-gray-100 transition-colors"
                  >
                    <Mail className="w-5 h-5" />
                    {isRTL ? 'راسلنا' : 'Email Us'}
                  </a>
                  <a 
                    href="https://app.progineous.com/submitticket.php"
                    target="_blank"
                    rel="noopener noreferrer"
                    className="inline-flex items-center justify-center gap-2 bg-white/10 text-white border border-white/20 px-6 py-3 rounded-lg font-medium hover:bg-white/20 transition-colors"
                  >
                    <HeartHandshake className="w-5 h-5" />
                    {isRTL ? 'تذكرة دعم' : 'Support Ticket'}
                  </a>
                </div>
              </div>
            </div>

            {/* Last Updated */}
            <div className="mt-6 text-center text-sm text-gray-500">
              {isRTL ? 'آخر تحديث: 1 يناير 2025' : 'Last Updated: January 1, 2025'}
            </div>
          </div>
        </div>
      </div>
    </div>
  );
}
