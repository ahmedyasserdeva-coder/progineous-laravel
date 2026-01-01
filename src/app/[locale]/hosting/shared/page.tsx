'use client';

import { useState, useEffect, useRef } from 'react';
import { useTranslations, useLocale } from 'next-intl';
import { Link } from '@/i18n/routing';
import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import { 
  Check, 
  Server, 
  Shield, 
  Zap, 
  Clock, 
  Globe, 
  Database,
  HardDrive,
  Mail,
  Lock,
  RefreshCw,
  Headphones,
  ArrowRight,
  Star,
  ChevronDown,
  ChevronUp,
  Sparkles,
  Cpu,
  Gauge,
  Users,
  Minus
} from 'lucide-react';
import { cn } from '@/lib/utils';

// Register GSAP plugins
if (typeof window !== 'undefined') {
  gsap.registerPlugin(ScrollTrigger);
}

export default function SharedHostingPage() {
  const locale = useLocale();
  const [billingPeriod, setBillingPeriod] = useState<'monthly' | 'yearly'>('yearly');
  const [openFaq, setOpenFaq] = useState<number | null>(0);
  const [expandedPlans, setExpandedPlans] = useState<string[]>([]);
  const [expandedSections, setExpandedSections] = useState<string[]>(['storage', 'performance']);
  
  const plansRef = useRef<HTMLDivElement>(null);
  const planCardsRef = useRef<(HTMLDivElement | null)[]>([]);
  const priceRefs = useRef<(HTMLSpanElement | null)[]>([]);
  const tableRef = useRef<HTMLDivElement>(null);
  const allPlansRef = useRef<HTMLDivElement>(null);
  const featuresRef = useRef<HTMLDivElement>(null);
  const featureCardsRef = useRef<(HTMLDivElement | null)[]>([]);
  
  const toggleSection = (section: string) => {
    setExpandedSections(prev => 
      prev.includes(section) 
        ? prev.filter(s => s !== section)
        : [...prev, section]
    );
  };

  // GSAP Animation for All Plans Include section - Marquee ticker
  useEffect(() => {
    if (!allPlansRef.current) return;
    
    const ctx = gsap.context(() => {
      // Animate section title on scroll
      const titleEl = allPlansRef.current?.querySelector('.all-plans-title');
      if (titleEl) {
        gsap.fromTo(
          titleEl,
          { opacity: 0, y: 30 },
          {
            opacity: 1,
            y: 0,
            duration: 0.8,
            ease: 'power3.out',
            scrollTrigger: {
              trigger: allPlansRef.current,
              start: 'top 80%',
              toggleActions: 'play none none none',
            },
          }
        );
      }
      
      // Marquee animation for row 1 & row 2
      const row1Container = allPlansRef.current?.querySelector('.marquee-row-1-container');
      const row2Container = allPlansRef.current?.querySelector('.marquee-row-2-container');
      const row1 = allPlansRef.current?.querySelector('.marquee-row-1');
      const row2 = allPlansRef.current?.querySelector('.marquee-row-2');
      const isRTL = locale === 'ar';
      
      // Rotation animation for both rows - same direction, swinging slowly
      if (row1Container && row2Container) {
        gsap.to([row1Container, row2Container], {
          rotation: 2,
          duration: 8,
          ease: 'sine.inOut',
          yoyo: true,
          repeat: -1,
        });
      }
      
      if (row1) {
        gsap.to(row1, {
          x: isRTL ? '25%' : '-25%',
          duration: 30,
          ease: 'none',
          repeat: -1,
        });
      }
      
      // Row 2 moves in opposite direction
      if (row2) {
        gsap.to(row2, {
          x: isRTL ? '-25%' : '25%',
          duration: 35,
          ease: 'none',
          repeat: -1,
        });
      }
    }, allPlansRef);
    
    return () => ctx.revert();
  }, [locale]);

  // GSAP Animation for Features Section
  useEffect(() => {
    if (!featuresRef.current) return;
    
    const ctx = gsap.context(() => {
      const cards = featureCardsRef.current.filter(Boolean);
      
      // Animate cards on scroll
      cards.forEach((card, index) => {
        gsap.fromTo(card,
          { 
            opacity: 0, 
            y: 60,
            rotateY: -15,
          },
          {
            opacity: 1,
            y: 0,
            rotateY: 0,
            duration: 0.8,
            delay: index * 0.1,
            ease: 'power3.out',
            scrollTrigger: {
              trigger: card,
              start: 'top 85%',
              toggleActions: 'play none none none',
            },
          }
        );
      });
      
      // Floating animation for icons
      const icons = featuresRef.current?.querySelectorAll('.feature-icon');
      icons?.forEach((icon, index) => {
        gsap.to(icon, {
          y: -8,
          duration: 2 + index * 0.2,
          ease: 'sine.inOut',
          yoyo: true,
          repeat: -1,
        });
      });
    }, featuresRef);
    
    return () => ctx.revert();
  }, []);

  // GSAP Animation for price change
  useEffect(() => {
    const prices = priceRefs.current.filter(Boolean);
    
    gsap.fromTo(prices, 
      { 
        scale: 0.5, 
        opacity: 0,
        y: 20,
      },
      { 
        scale: 1, 
        opacity: 1,
        y: 0,
        duration: 0.4, 
        ease: 'back.out(1.7)',
        stagger: 0.1,
      }
    );
  }, [billingPeriod]);

  // GSAP Animation for plans
  useEffect(() => {
    if (!plansRef.current) return;

    const cards = planCardsRef.current.filter(Boolean);
    
    // Initial state
    gsap.set(cards, {
      opacity: 0,
      y: 60,
      scale: 0.9,
    });

    // Animate cards on scroll
    gsap.to(cards, {
      opacity: 1,
      y: 0,
      scale: 1,
      duration: 0.8,
      stagger: 0.15,
      ease: 'power3.out',
      scrollTrigger: {
        trigger: plansRef.current,
        start: 'top 80%',
        toggleActions: 'play none none reverse',
      },
    });

    // Hover animations
    cards.forEach((card) => {
      if (!card) return;
      
      const hoverTl = gsap.timeline({ paused: true });
      hoverTl.to(card, {
        y: -10,
        boxShadow: '0 25px 50px -12px rgba(29, 113, 184, 0.25)',
        duration: 0.3,
        ease: 'power2.out',
      });

      card.addEventListener('mouseenter', () => hoverTl.play());
      card.addEventListener('mouseleave', () => hoverTl.reverse());
    });

    return () => {
      ScrollTrigger.getAll().forEach(trigger => trigger.kill());
    };
  }, []);

  const plans = [
    {
      name: locale === 'ar' ? 'ستارت أب' : 'Startup',
      description: locale === 'ar' ? 'مثالية للمواقع الشخصية والمدونات' : 'Perfect for personal websites & blogs',
      monthlyPrice: 10.00,
      yearlyPrice: 2.00,
      renewsAt: locale === 'ar' ? 'يجدد بـ $120/سنة (لا يشمل الدومين)' : 'Renews at $120/yr (domain not included)',
      coupon: 'newgen80',
      discount: 80,
      features: [
        { text: locale === 'ar' ? '🎁 دومين .com مجاني للسنة الأولى' : '🎁 Free .com Domain 1st year', included: true, highlight: true },
        { text: locale === 'ar' ? 'لوحة تحكم cPanel' : 'cPanel Control Panel', included: true },
        { text: locale === 'ar' ? '150 موقع' : '150 Websites', included: true },
        { text: locale === 'ar' ? '1.5 جيجا RAM DDR4' : '1.5 GB RAM DDR4', included: true },
        { text: locale === 'ar' ? '1.5 نواة معالج الجيل السابع' : '1.5 Core Gen 7', included: true },
        { text: locale === 'ar' ? '70 جيجا SSD' : '70 GB SSD', included: true },
        { text: locale === 'ar' ? 'تثبيت ووردبريس بنقرة واحدة' : 'One-click WordPress installs', included: true },
        { text: locale === 'ar' ? 'نطاق ترددي غير محدود' : 'Unlimited Bandwidth', included: true },
        { text: locale === 'ar' ? 'شهادات SSL مجانية غير محدودة' : 'Unlimited Free SSL certificate', included: true },
        { text: locale === 'ar' ? 'أداء حتى 2x' : 'Performance (Up to 2x)', included: true },
        { text: locale === 'ar' ? 'WooCommerce قياسي' : 'Standard WooCommerce', included: true },
        { text: locale === 'ar' ? 'نقل موقع مجاني تلقائي' : 'Free Automatic Website Migration', included: true },
        { text: locale === 'ar' ? 'قوالب جاهزة مجانية' : 'Free Pre-built Templates', included: true },
        { text: locale === 'ar' ? 'سيرفر LiteSpeed' : 'LiteSpeed', included: true },
        { text: locale === 'ar' ? 'تحديثات ووردبريس ذكية تلقائية' : 'Smart WordPress Auto Updates', included: true },
        { text: locale === 'ar' ? 'فاحص ثغرات ووردبريس' : 'WordPress Vulnerabilities Scanner', included: true },
        { text: locale === 'ar' ? 'فاحص توافق ووردبريس' : 'WordPress Compatibility Checker', included: true },
        { text: locale === 'ar' ? 'ووردبريس متعدد المواقع' : 'WordPress Multisite', included: true },
        { text: locale === 'ar' ? 'WP-CLI و SSH' : 'WP-CLI and SSH', included: true },
        { text: locale === 'ar' ? 'أداة تجربة ووردبريس' : 'WordPress Staging Tool', included: true },
        { text: locale === 'ar' ? 'Object Cache لووردبريس' : 'Object Cache for WordPress', included: true },
        { text: locale === 'ar' ? 'منشئ مواقع بالسحب والإفلات' : 'Drag&Drop Website Builder', included: true },
        { text: locale === 'ar' ? 'حماية DDoS متقدمة' : 'Enhanced DDoS Protection', included: true },
        { text: locale === 'ar' ? 'جدار حماية تطبيقات الويب' : 'Web Application Firewall', included: true },
        { text: locale === 'ar' ? 'فاحص البرمجيات الخبيثة' : 'Malware Scanner', included: true },
        { text: locale === 'ar' ? 'مدير الوصول الآمن' : 'Secure Access Manager', included: true },
        { text: locale === 'ar' ? 'حماية خصوصية WHOIS مجانية' : 'Free Domain WHOIS Privacy Protection', included: true },
        { text: locale === 'ar' ? 'ضمان استرداد المال 30 يوم' : '30-Day Money-Back Guarantee', included: true },
        { text: locale === 'ar' ? '50,000 زيارة شهرياً' : '50,000 visits monthly', included: true },
        { text: locale === 'ar' ? 'مراكز بيانات عالمية' : 'Global Data Centers', included: true },
        { text: locale === 'ar' ? '150 صندوق بريد' : '150 Domain Based Mailboxes', included: true },
        { text: locale === 'ar' ? 'ضمان وقت تشغيل 99.9%' : '99.9% Uptime Guarantee', included: true },
        { text: locale === 'ar' ? 'دعم فني 24/7' : '24/7 Customer Support', included: true },
      ],
      popular: false,
      color: 'blue',
      pid: 73,
      link: 'https://app.progineous.com/cart.php?a=add&pid=73'
    },
    {
      name: locale === 'ar' ? 'إسنشيال' : 'Essential',
      description: locale === 'ar' ? 'الأفضل للأعمال الصغيرة والمتوسطة' : 'Best for small & medium businesses',
      monthlyPrice: 13.00,
      yearlyPrice: 3.25,
      renewsAt: locale === 'ar' ? 'يجدد بـ $156/سنة (لا يشمل الدومين)' : 'Renews at $156/yr (domain not included)',
      coupon: 'newgen75',
      discount: 75,
      features: [
        { text: locale === 'ar' ? '🎁 دومين .com مجاني للسنة الأولى' : '🎁 Free .com Domain 1st year', included: true, highlight: true },
        { text: locale === 'ar' ? 'لوحة تحكم cPanel' : 'cPanel Control Panel', included: true },
        { text: locale === 'ar' ? 'تخزين سحابي' : 'Cloud Storage', included: true },
        { text: locale === 'ar' ? '200 موقع' : '200 Websites', included: true },
        { text: locale === 'ar' ? '2 جيجا RAM DDR4' : '2 GB RAM DDR4', included: true },
        { text: locale === 'ar' ? '1.5 نواة معالج الجيل السابع' : '1.5 Core Gen 7', included: true },
        { text: locale === 'ar' ? '150 جيجا SSD' : '150 GB SSD', included: true },
        { text: locale === 'ar' ? 'تثبيت ووردبريس بنقرة واحدة' : 'One-click WordPress installs', included: true },
        { text: locale === 'ar' ? 'نطاق ترددي غير محدود' : 'Unlimited Bandwidth', included: true },
        { text: locale === 'ar' ? 'شهادات SSL مجانية غير محدودة' : 'Unlimited Free SSL certificate', included: true },
        { text: locale === 'ar' ? 'أداء حتى 5x' : 'Performance (Up to 5x)', included: true },
        { text: locale === 'ar' ? 'نسخ احتياطي تلقائي' : 'AutoBackup', included: true },
        { text: locale === 'ar' ? 'CDN مجاني' : 'Free CDN', included: true },
        { text: locale === 'ar' ? 'WooCommerce قياسي' : 'Standard WooCommerce', included: true },
        { text: locale === 'ar' ? 'نقل موقع مجاني تلقائي' : 'Free Automatic Website Migration', included: true },
        { text: locale === 'ar' ? 'قوالب جاهزة مجانية' : 'Free Pre-built Templates', included: true },
        { text: locale === 'ar' ? 'سيرفر LiteSpeed' : 'LiteSpeed', included: true },
        { text: locale === 'ar' ? 'تحديثات ووردبريس ذكية تلقائية' : 'Smart WordPress Auto Updates', included: true },
        { text: locale === 'ar' ? 'فاحص ثغرات ووردبريس' : 'WordPress Vulnerabilities Scanner', included: true },
        { text: locale === 'ar' ? 'فاحص توافق ووردبريس' : 'WordPress Compatibility Checker', included: true },
        { text: locale === 'ar' ? 'ووردبريس متعدد المواقع' : 'WordPress Multisite', included: true },
        { text: locale === 'ar' ? 'WP-CLI و SSH' : 'WP-CLI and SSH', included: true },
        { text: locale === 'ar' ? 'أداة تجربة ووردبريس' : 'WordPress Staging Tool', included: true },
        { text: locale === 'ar' ? 'Object Cache لووردبريس' : 'Object Cache for WordPress', included: true },
        { text: locale === 'ar' ? 'منشئ مواقع بالسحب والإفلات' : 'Drag&Drop Website Builder', included: true },
        { text: locale === 'ar' ? 'حماية DDoS متقدمة' : 'Enhanced DDoS Protection', included: true },
        { text: locale === 'ar' ? 'جدار حماية تطبيقات الويب' : 'Web Application Firewall', included: true },
        { text: locale === 'ar' ? 'فاحص البرمجيات الخبيثة' : 'Malware Scanner', included: true },
        { text: locale === 'ar' ? 'مدير الوصول الآمن' : 'Secure Access Manager', included: true },
        { text: locale === 'ar' ? 'حماية خصوصية WHOIS مجانية' : 'Free Domain WHOIS Privacy Protection', included: true },
        { text: locale === 'ar' ? 'ضمان استرداد المال 30 يوم' : '30-Day Money-Back Guarantee', included: true },
        { text: locale === 'ar' ? '150,000 زيارة شهرياً' : '150,000 visits monthly', included: true },
        { text: locale === 'ar' ? 'مراكز بيانات عالمية' : 'Global Data Centers', included: true },
        { text: locale === 'ar' ? '200 صندوق بريد' : '200 Domain Based Mailboxes', included: true },
        { text: locale === 'ar' ? 'ضمان وقت تشغيل 99.9%' : '99.9% Uptime Guarantee', included: true },
        { text: locale === 'ar' ? 'دعم فني 24/7' : '24/7 Customer Support', included: true },
      ],
      popular: true,
      color: 'blue',
      pid: 74,
      link: 'https://app.progineous.com/cart.php?a=add&pid=74'
    },
    {
      name: locale === 'ar' ? 'ألتيميت' : 'Ultimate',
      description: locale === 'ar' ? 'للمشاريع الكبيرة والمتاجر الإلكترونية' : 'For large projects & e-commerce',
      monthlyPrice: 19.00,
      yearlyPrice: 6.60,
      renewsAt: locale === 'ar' ? 'يجدد بـ $228/سنة (لا يشمل الدومين)' : 'Renews at $228/yr (domain not included)',
      coupon: 'newgen65',
      discount: 65,
      features: [
        { text: locale === 'ar' ? '🎁 دومين .com مجاني للسنة الأولى' : '🎁 Free .com Domain 1st year', included: true, highlight: true },
        { text: locale === 'ar' ? 'لوحة تحكم cPanel' : 'cPanel Control Panel', included: true },
        { text: locale === 'ar' ? 'تخزين سحابي' : 'Cloud Storage', included: true },
        { text: locale === 'ar' ? '350 موقع' : '350 Websites', included: true },
        { text: locale === 'ar' ? '3 جيجا RAM DDR4' : '3 GB RAM DDR4', included: true },
        { text: locale === 'ar' ? '2 نواة معالج الجيل السابع' : '2 Core Gen 7', included: true },
        { text: locale === 'ar' ? '250 جيجا SSD' : '250 GB SSD', included: true },
        { text: locale === 'ar' ? 'تثبيت ووردبريس بنقرة واحدة' : 'One-click WordPress installs', included: true },
        { text: locale === 'ar' ? 'نطاق ترددي غير محدود' : 'Unlimited Bandwidth', included: true },
        { text: locale === 'ar' ? 'شهادات SSL مجانية غير محدودة' : 'Unlimited Free SSL certificate', included: true },
        { text: locale === 'ar' ? 'نسخ احتياطي تلقائي' : 'AutoBackup', included: true },
        { text: locale === 'ar' ? 'أداء حتى 10x' : 'Performance (Up to 10x)', included: true },
        { text: locale === 'ar' ? 'عنوان IP مخصص' : 'Dedicated IP Address', included: true },
        { text: locale === 'ar' ? 'CDN مجاني' : 'Free CDN', included: true },
        { text: locale === 'ar' ? 'WooCommerce قياسي' : 'Standard WooCommerce', included: true },
        { text: locale === 'ar' ? 'نقل موقع مجاني تلقائي' : 'Free Automatic Website Migration', included: true },
        { text: locale === 'ar' ? 'قوالب جاهزة مجانية' : 'Free Pre-built Templates', included: true },
        { text: locale === 'ar' ? 'سيرفر LiteSpeed' : 'LiteSpeed', included: true },
        { text: locale === 'ar' ? 'تحديثات ووردبريس ذكية تلقائية' : 'Smart WordPress Auto Updates', included: true },
        { text: locale === 'ar' ? 'فاحص ثغرات ووردبريس' : 'WordPress Vulnerabilities Scanner', included: true },
        { text: locale === 'ar' ? 'فاحص توافق ووردبريس' : 'WordPress Compatibility Checker', included: true },
        { text: locale === 'ar' ? 'ووردبريس متعدد المواقع' : 'WordPress Multisite', included: true },
        { text: locale === 'ar' ? 'WP-CLI و SSH' : 'WP-CLI and SSH', included: true },
        { text: locale === 'ar' ? 'أداة تجربة ووردبريس' : 'WordPress Staging Tool', included: true },
        { text: locale === 'ar' ? 'Object Cache لووردبريس' : 'Object Cache for WordPress', included: true },
        { text: locale === 'ar' ? 'أدوات ووردبريس بالذكاء الاصطناعي' : 'WordPress AI Tools', included: true },
        { text: locale === 'ar' ? 'منشئ مواقع بالسحب والإفلات' : 'Drag&Drop Website Builder', included: true },
        { text: locale === 'ar' ? 'حماية DDoS متقدمة' : 'Enhanced DDoS Protection', included: true },
        { text: locale === 'ar' ? 'جدار حماية تطبيقات الويب' : 'Web Application Firewall', included: true },
        { text: locale === 'ar' ? 'فاحص البرمجيات الخبيثة' : 'Malware Scanner', included: true },
        { text: locale === 'ar' ? 'مدير الوصول الآمن' : 'Secure Access Manager', included: true },
        { text: locale === 'ar' ? 'حماية خصوصية WHOIS مجانية' : 'Free Domain WHOIS Privacy Protection', included: true },
        { text: locale === 'ar' ? 'ضمان استرداد المال 30 يوم' : '30-Day Money-Back Guarantee', included: true },
        { text: locale === 'ar' ? '250,000 زيارة شهرياً' : '250,000 visits monthly', included: true },
        { text: locale === 'ar' ? 'مراكز بيانات عالمية' : 'Global Data Centers', included: true },
        { text: locale === 'ar' ? '350 صندوق بريد' : '350 Domain Based Mailboxes', included: true },
        { text: locale === 'ar' ? 'ضمان وقت تشغيل 99.9%' : '99.9% Uptime Guarantee', included: true },
        { text: locale === 'ar' ? 'دعم فني 24/7' : '24/7 Customer Support', included: true },
        { text: locale === 'ar' ? 'دعم أولوية' : 'Priority Support', included: true },
      ],
      popular: false,
      color: 'blue',
      pid: 75,
      link: 'https://app.progineous.com/cart.php?a=add&pid=75'
    }
  ];

  const features = [
    {
      icon: Zap,
      title: locale === 'ar' ? 'سرعة فائقة' : 'Lightning Fast',
      description: locale === 'ar' 
        ? 'سيرفرات LiteSpeed مع تخزين NVMe SSD لأداء استثنائي'
        : 'LiteSpeed servers with NVMe SSD storage for exceptional performance',
      color: 'bg-yellow-100 text-yellow-600'
    },
    {
      icon: Shield,
      title: locale === 'ar' ? 'حماية متقدمة' : 'Advanced Security',
      description: locale === 'ar'
        ? 'حماية DDoS، جدار حماية، وفحص البرمجيات الخبيثة'
        : 'DDoS protection, firewall, and malware scanning',
      color: 'bg-green-100 text-green-600'
    },
    {
      icon: RefreshCw,
      title: locale === 'ar' ? 'نسخ احتياطي تلقائي' : 'Auto Backups',
      description: locale === 'ar'
        ? 'نسخ احتياطي يومي مع استعادة بنقرة واحدة'
        : 'Daily backups with one-click restore',
      color: 'bg-blue-100 text-blue-600'
    },
    {
      icon: Headphones,
      title: locale === 'ar' ? 'دعم 24/7' : '24/7 Support',
      description: locale === 'ar'
        ? 'فريق دعم متخصص متاح على مدار الساعة'
        : 'Expert support team available around the clock',
      color: 'bg-purple-100 text-purple-600'
    },
    {
      icon: Globe,
      title: locale === 'ar' ? 'شهادة SSL مجانية' : 'Free SSL Certificate',
      description: locale === 'ar'
        ? 'تشفير HTTPS لحماية بيانات زوارك'
        : 'HTTPS encryption to protect your visitors data',
      color: 'bg-cyan-100 text-cyan-600'
    },
    {
      icon: Gauge,
      title: locale === 'ar' ? 'لوحة تحكم سهلة' : 'Easy Control Panel',
      description: locale === 'ar'
        ? 'cPanel سهل الاستخدام لإدارة موقعك'
        : 'User-friendly cPanel to manage your site',
      color: 'bg-orange-100 text-orange-600'
    }
  ];

  const faqs = [
    {
      question: locale === 'ar' ? 'ما هي الاستضافة المشتركة؟' : 'What is Shared Hosting?',
      answer: locale === 'ar'
        ? 'الاستضافة المشتركة هي نوع من استضافة الويب حيث يتشارك عدة مواقع في موارد سيرفر واحد. هذا يجعلها خياراً اقتصادياً ومثالياً للمواقع الصغيرة والمتوسطة.'
        : 'Shared hosting is a type of web hosting where multiple websites share resources on a single server. This makes it an economical choice ideal for small to medium websites.'
    },
    {
      question: locale === 'ar' ? 'هل يمكنني ترقية خطتي لاحقاً؟' : 'Can I upgrade my plan later?',
      answer: locale === 'ar'
        ? 'نعم! يمكنك الترقية إلى خطة أعلى في أي وقت بدون أي توقف لموقعك. سيتم احتساب الفرق في السعر فقط.'
        : 'Yes! You can upgrade to a higher plan at any time without any downtime for your site. Only the price difference will be charged.'
    },
    {
      question: locale === 'ar' ? 'هل تقدمون ضمان استرداد الأموال؟' : 'Do you offer a money-back guarantee?',
      answer: locale === 'ar'
        ? 'نعم، نقدم ضمان استرداد الأموال لمدة 30 يوماً. إذا لم تكن راضياً عن خدماتنا، يمكنك استرداد أموالك بالكامل.'
        : 'Yes, we offer a 30-day money-back guarantee. If you are not satisfied with our services, you can get a full refund.'
    },
    {
      question: locale === 'ar' ? 'هل الدومين مجاني حقاً؟' : 'Is the domain really free?',
      answer: locale === 'ar'
        ? 'نعم! عند الاشتراك في خطة سنوية أو أكثر، تحصل على دومين مجاني للسنة الأولى (على خطط Business و Professional).'
        : 'Yes! When you subscribe to an annual plan or longer, you get a free domain for the first year (on Business and Professional plans).'
    },
    {
      question: locale === 'ar' ? 'كيف أنقل موقعي من استضافة أخرى؟' : 'How do I migrate my site from another host?',
      answer: locale === 'ar'
        ? 'نقدم خدمة نقل مجانية! فريقنا سينقل موقعك بالكامل بدون أي توقف أو فقدان للبيانات.'
        : 'We offer free migration! Our team will transfer your entire site with no downtime or data loss.'
    }
  ];

  const stats = [
    { value: '99.9%', label: locale === 'ar' ? 'وقت التشغيل' : 'Uptime' },
    { value: '50K+', label: locale === 'ar' ? 'عميل سعيد' : 'Happy Clients' },
    { value: '24/7', label: locale === 'ar' ? 'دعم فني' : 'Support' },
    { value: '30', label: locale === 'ar' ? 'يوم ضمان' : 'Day Guarantee' },
  ];

  // JSON-LD Structured Data for SEO
  const structuredData = {
    '@context': 'https://schema.org',
    '@type': 'Product',
    name: locale === 'ar' ? 'استضافة مشتركة من برو جينيوس' : 'Shared Hosting by Pro Gineous',
    description: locale === 'ar'
      ? 'استضافة مشتركة سريعة وآمنة مع LiteSpeed، SSL مجاني، cPanel، ودعم 24/7'
      : 'Fast and secure shared hosting with LiteSpeed, free SSL, cPanel, and 24/7 support',
    brand: {
      '@type': 'Brand',
      name: 'Pro Gineous'
    },
    offers: {
      '@type': 'AggregateOffer',
      lowPrice: '2',
      highPrice: '19',
      priceCurrency: 'USD',
      offerCount: '3',
      offers: plans.map(plan => ({
        '@type': 'Offer',
        name: plan.name,
        description: plan.description,
        price: plan.yearlyPrice,
        priceCurrency: 'USD',
        priceValidUntil: '2026-12-31',
        availability: 'https://schema.org/InStock',
        url: plan.link
      }))
    },
    aggregateRating: {
      '@type': 'AggregateRating',
      ratingValue: '4.8',
      reviewCount: '2547',
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
        name: locale === 'ar' ? 'استضافة مشتركة' : 'Shared Hosting',
        item: `https://progineous.com/${locale}/hosting/shared`
      }
    ]
  };

  return (
    <div className="min-h-screen bg-white">
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

      {/* Hero Section */}
      <section className="relative overflow-hidden bg-linear-to-br from-[#0f2d3d] via-[#1a4a5e] to-[#1d71b8] py-20 lg:py-28">
        {/* Background Pattern */}
        <div className="absolute inset-0 opacity-10">
          <div className="absolute inset-0 hero-dots-pattern"></div>
        </div>

        <div className="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="text-center">
            {/* Badge */}
            <div className="mb-6 inline-flex items-center gap-2 rounded-full bg-white/10 px-4 py-2 backdrop-blur-sm">
              <Sparkles className="h-4 w-4 text-yellow-400" />
              <span className="text-sm font-medium text-white">
                {locale === 'ar' ? 'وفّر حتى 75% - عرض محدود!' : 'Save up to 75% - Limited Offer!'}
              </span>
            </div>

            {/* Title */}
            <h1 className="text-3xl font-extrabold text-white sm:text-4xl md:text-5xl lg:text-6xl">
              {locale === 'ar' ? 'استضافة مشتركة' : 'Shared Hosting'}
              <span className="mt-2 block text-[#60a5fa]">
                {locale === 'ar' ? 'سريعة وآمنة وموثوقة' : 'Fast, Secure & Reliable'}
              </span>
            </h1>

            {/* Subtitle */}
            <p className="mx-auto mt-6 max-w-2xl text-lg text-white/80">
              {locale === 'ar'
                ? 'ابدأ موقعك بأقل من $2/شهر مع سيرفرات LiteSpeed فائقة السرعة، شهادة SSL مجانية، ودعم فني على مدار الساعة.'
                : 'Start your website for less than $2/mo with ultra-fast LiteSpeed servers, free SSL certificate, and 24/7 support.'}
            </p>

            {/* Stats */}
            <div className="mt-10 flex flex-wrap items-center justify-center gap-8 lg:gap-16">
              {stats.map((stat, index) => (
                <div key={index} className="text-center">
                  <div className="text-3xl font-bold text-white lg:text-4xl">{stat.value}</div>
                  <div className="mt-1 text-sm text-white/60">{stat.label}</div>
                </div>
              ))}
            </div>

            {/* CTA */}
            <div className="mt-10 flex flex-col items-center justify-center gap-4 sm:flex-row">
              <a
                href="#pricing"
                className="inline-flex items-center gap-2 rounded-full bg-white px-8 py-4 text-base font-semibold text-[#1d71b8] shadow-lg transition-all hover:bg-white/90 hover:shadow-xl"
              >
                {locale === 'ar' ? 'اختر خطتك' : 'Choose Your Plan'}
                <ArrowRight className="h-5 w-5 rtl:rotate-180" />
              </a>
            </div>
          </div>
        </div>

        {/* Wave Divider */}
        <div className="absolute bottom-0 left-0 right-0">
          <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg" className="w-full">
            <path d="M0 120L60 110C120 100 240 80 360 70C480 60 600 60 720 65C840 70 960 80 1080 85C1200 90 1320 90 1380 90L1440 90V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0Z" fill="white"/>
          </svg>
        </div>
      </section>

      {/* All Plans Include Section */}
      <section ref={allPlansRef} className="py-16 lg:py-20 bg-white overflow-hidden">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="text-center mb-12 all-plans-title">
            <h2 className="text-2xl font-bold text-gray-900 sm:text-3xl lg:text-4xl">
              {locale === 'ar' ? 'جميع الخطط تشمل' : 'All Plans Include'}
            </h2>
            <p className="mx-auto mt-4 max-w-2xl text-gray-600">
              {locale === 'ar'
                ? 'ميزات أساسية متوفرة في جميع خطط الاستضافة المشتركة'
                : 'Essential features included in all shared hosting plans'}
            </p>
          </div>
        </div>

        {/* Marquee Row 1 */}
        <div className="relative mb-4 overflow-hidden marquee-row-1-container marquee-rotate">
          <div className="marquee-row-1 flex gap-4 marquee-width">
            {[...Array(4)].map((_, repeatIndex) => (
              <div key={repeatIndex} className="flex gap-4 shrink-0">
                {[
                  { icon: Globe, text: locale === 'ar' ? 'دومين .com مجاني' : 'Free .com Domain' },
                  { icon: Server, text: locale === 'ar' ? 'لوحة تحكم cPanel' : 'cPanel Control Panel' },
                  { icon: Zap, text: locale === 'ar' ? 'تثبيت ووردبريس بنقرة' : 'One-click WordPress' },
                  { icon: Database, text: locale === 'ar' ? 'Rails, Python, Perl' : 'Rails, Python, Perl' },
                  { icon: Globe, text: locale === 'ar' ? 'نطاق ترددي غير محدود' : 'Unlimited Bandwidth' },
                  { icon: Lock, text: locale === 'ar' ? 'شهادات SSL مجانية' : 'Free SSL' },
                  { icon: RefreshCw, text: locale === 'ar' ? 'ضمان 30 يوم' : '30-Day Guarantee' },
                  { icon: Shield, text: locale === 'ar' ? 'حماية DDoS' : 'DDoS Protection' },
                ].map((feature, index) => (
                  <div
                    key={`${repeatIndex}-${index}`}
                    className="flex items-center gap-3 px-5 py-3 rounded-full bg-gray-50 border border-gray-100 hover:bg-[#1d71b8]/5 hover:border-[#1d71b8]/20 transition-colors group whitespace-nowrap"
                  >
                    <div className="w-8 h-8 rounded-full bg-[#1d71b8]/10 flex items-center justify-center group-hover:bg-[#1d71b8]/20 transition-colors shrink-0">
                      <feature.icon className="h-4 w-4 text-[#1d71b8]" />
                    </div>
                    <span className="text-sm font-medium text-gray-700">{feature.text}</span>
                  </div>
                ))}
              </div>
            ))}
          </div>
        </div>

        {/* Marquee Row 2 - Moves opposite direction */}
        <div className="relative overflow-hidden flex justify-end marquee-row-2-container marquee-rotate">
          <div className="marquee-row-2 flex gap-4 marquee-width">
            {[...Array(4)].map((_, repeatIndex) => (
              <div key={repeatIndex} className="flex gap-4 shrink-0">
                {[
                  { icon: Zap, text: locale === 'ar' ? 'سيرفر LiteSpeed' : 'LiteSpeed Server' },
                  { icon: HardDrive, text: locale === 'ar' ? 'قوالب مجانية' : 'Free Templates' },
                  { icon: RefreshCw, text: locale === 'ar' ? 'نقل موقع مجاني' : 'Free Migration' },
                  { icon: Database, text: locale === 'ar' ? 'نسخ احتياطي تلقائي' : 'Auto Backup' },
                  { icon: Globe, text: locale === 'ar' ? 'دعم IPv4' : 'IPv4 Support' },
                  { icon: HardDrive, text: locale === 'ar' ? 'تخزين سحابي' : 'Cloud Storage' },
                  { icon: Mail, text: locale === 'ar' ? 'خدمة البريد' : 'E-mail Service' },
                ].map((feature, index) => (
                  <div
                    key={`${repeatIndex}-${index}`}
                    className="flex items-center gap-3 px-5 py-3 rounded-full bg-gray-50 border border-gray-100 hover:bg-[#1d71b8]/5 hover:border-[#1d71b8]/20 transition-colors group whitespace-nowrap"
                  >
                    <div className="w-8 h-8 rounded-full bg-[#1d71b8]/10 flex items-center justify-center group-hover:bg-[#1d71b8]/20 transition-colors shrink-0">
                      <feature.icon className="h-4 w-4 text-[#1d71b8]" />
                    </div>
                    <span className="text-sm font-medium text-gray-700">{feature.text}</span>
                  </div>
                ))}
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* Pricing Section */}
      <section id="pricing" className="bg-gray-50 py-16 lg:py-24">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="text-center">
            <h2 className="text-2xl font-bold text-gray-900 sm:text-3xl lg:text-4xl">
              {locale === 'ar' ? 'خطط الأسعار' : 'Pricing Plans'}
            </h2>
            <p className="mx-auto mt-4 max-w-2xl text-gray-600">
              {locale === 'ar'
                ? 'اختر الخطة المناسبة لاحتياجاتك'
                : 'Choose the plan that fits your needs'}
            </p>

            {/* Billing Toggle */}
            <div className="mt-8 flex items-center justify-center gap-4">
              <span className={cn('text-sm font-medium', billingPeriod === 'monthly' ? 'text-gray-900' : 'text-gray-500')}>
                {locale === 'ar' ? 'شهري' : 'Monthly'}
              </span>
              <button
                onClick={() => setBillingPeriod(billingPeriod === 'monthly' ? 'yearly' : 'monthly')}
                className={cn(
                  'relative h-7 w-14 rounded-full transition-colors',
                  billingPeriod === 'yearly' ? 'bg-[#1d71b8]' : 'bg-gray-300'
                )}
                aria-label={locale === 'ar' ? 'تبديل فترة الفوترة' : 'Toggle billing period'}
                title={locale === 'ar' ? 'تبديل فترة الفوترة' : 'Toggle billing period'}
              >
                <span
                  className={cn(
                    'absolute top-0.5 h-6 w-6 rounded-full bg-white shadow-sm transition-all',
                    billingPeriod === 'yearly' 
                      ? (locale === 'ar' ? 'left-0.5' : 'right-0.5') 
                      : (locale === 'ar' ? 'right-0.5' : 'left-0.5')
                  )}
                />
              </button>
              <span className={cn('text-sm font-medium', billingPeriod === 'yearly' ? 'text-gray-900' : 'text-gray-500')}>
                {locale === 'ar' ? 'سنوي' : 'Yearly'}
              </span>
              {billingPeriod === 'yearly' && (
                <span className="rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">
                  {locale === 'ar' ? 'وفّر حتى 80% السنة الأولى' : 'Save up to 80% 1st year'}
                </span>
              )}
            </div>
          </div>

          {/* Plans */}
          <div ref={plansRef} className="mt-12 grid gap-8 lg:grid-cols-3 items-start">
            {plans.map((plan, index) => (
              <div
                key={index}
                ref={(el) => { planCardsRef.current[index] = el; }}
                className={cn(
                  'relative rounded-2xl bg-white p-8 shadow-sm',
                  plan.popular && 'ring-2 ring-[#1d71b8] scale-105'
                )}
              >
                {plan.popular && (
                  <div className="absolute -top-4 left-1/2 -translate-x-1/2">
                    <span className="inline-flex items-center gap-1.5 rounded-full bg-[#1d71b8] px-4 py-1.5 text-sm font-semibold text-white">
                      <Star className="h-4 w-4 fill-current" />
                      {locale === 'ar' ? 'الأكثر شعبية' : 'Most Popular'}
                    </span>
                  </div>
                )}

                <div className="text-center">
                  <h3 className="text-xl font-bold text-gray-900">{plan.name}</h3>
                  <p className="mt-2 text-sm text-gray-500">{plan.description}</p>

                  <div className="mt-6">
                    <span 
                      ref={(el) => { priceRefs.current[index] = el; }}
                      className="text-5xl font-extrabold text-gray-900 inline-block"
                    >
                      ${billingPeriod === 'yearly' ? plan.yearlyPrice : plan.monthlyPrice}
                    </span>
                    <span className="text-gray-500">/{locale === 'ar' ? 'شهر' : 'mo'}</span>
                  </div>

                  {billingPeriod === 'yearly' && (
                    <p className="mt-2 text-sm text-gray-500">
                      {locale === 'ar' ? 'يُدفع سنوياً' : 'Billed annually'} (${(plan.yearlyPrice * 12).toFixed(2)}/{locale === 'ar' ? 'سنة' : 'yr'})
                    </p>
                  )}
                  <p className="mt-1 text-xs text-gray-400">{plan.renewsAt}</p>

                  {/* Coupon Code */}
                  {billingPeriod === 'yearly' && plan.coupon && (
                    <div className="mt-4 p-3 rounded-xl bg-linear-to-r from-green-50 to-emerald-50 border border-green-200">
                      <div className="flex items-center justify-center gap-2">
                        <span className="text-xs font-medium text-green-700">
                          {locale === 'ar' ? `خصم ${plan.discount}%` : `${plan.discount}% OFF`}
                        </span>
                        <span className="px-3 py-1 rounded-lg bg-green-100 text-green-800 font-mono font-bold text-sm tracking-wider">
                          {plan.coupon}
                        </span>
                      </div>
                      <p className="text-xs text-green-600 mt-1">
                        {locale === 'ar' ? 'استخدم الكوبون عند الدفع' : 'Use at checkout'}
                      </p>
                    </div>
                  )}
                </div>

                <ul className="mt-6 space-y-3">
                  {plan.features
                    .filter(feature => !(billingPeriod === 'monthly' && feature.highlight))
                    .slice(0, expandedPlans.includes(plan.link) ? plan.features.length : 6)
                    .map((feature, featureIndex) => (
                    <li key={featureIndex} className={cn(
                      "flex items-center gap-3",
                      feature.highlight && billingPeriod === 'yearly' && "bg-linear-to-r from-amber-50 to-yellow-50 -mx-3 px-3 py-2 rounded-lg border border-amber-200"
                    )}>
                      <div className={cn(
                        'flex h-5 w-5 items-center justify-center rounded-full',
                        feature.highlight ? 'bg-amber-100 text-amber-600' : feature.included ? 'bg-green-100 text-green-600' : 'bg-gray-100 text-gray-400'
                      )}>
                        {!feature.highlight && <Check className="h-3 w-3" />}
                      </div>
                      <span className={cn(
                        'text-sm',
                        feature.highlight ? 'font-semibold text-amber-700' : feature.included ? 'text-gray-700' : 'text-gray-400'
                      )}>
                        {feature.text}
                      </span>
                    </li>
                  ))}
                </ul>

                {plan.features.length > 6 && (
                  <button
                    type="button"
                    onClick={() => setExpandedPlans(prev => 
                      prev.includes(plan.link) ? prev.filter(i => i !== plan.link) : [...prev, plan.link]
                    )}
                    className="mt-3 flex w-full items-center justify-center gap-1 text-sm font-medium text-[#1d71b8] hover:text-[#155a94] transition-colors"
                  >
                    {expandedPlans.includes(plan.link) ? (
                      <>{locale === 'ar' ? 'عرض أقل' : 'View Less'} <ChevronDown className="h-4 w-4 rotate-180" /></>
                    ) : (
                      <>{locale === 'ar' ? 'عرض المزيد' : 'View More'} <ChevronDown className="h-4 w-4" /></>
                    )}
                  </button>
                )}

                <a
                  href={`${plan.link}&billingcycle=${billingPeriod === 'yearly' ? 'annually' : 'monthly'}${billingPeriod === 'yearly' && plan.coupon ? `&promocode=${plan.coupon}` : ''}`}
                  target="_blank"
                  rel="noopener noreferrer"
                  className={cn(
                    'mt-8 block w-full rounded-xl py-3 text-center font-semibold transition-all',
                    plan.popular
                      ? 'bg-[#1d71b8] text-white hover:bg-[#155a94]'
                      : 'bg-gray-100 text-gray-900 hover:bg-gray-200'
                  )}
                >
                  {locale === 'ar' ? 'اشترِ الآن' : 'Purchase Plan'}
                </a>
              </div>
            ))}
          </div>

          {/* Money Back Guarantee */}
          <div className="mt-12 text-center">
            <div className="inline-flex items-center gap-2 rounded-full bg-green-50 px-4 py-2 text-green-700">
              <Shield className="h-5 w-5" />
              <span className="text-sm font-medium">
                {locale === 'ar' ? 'ضمان استرداد الأموال لمدة 30 يوماً' : '30-Day Money-Back Guarantee'}
              </span>
            </div>
          </div>
        </div>
      </section>

      {/* Features Section */}
      <section ref={featuresRef} className="py-16 lg:py-24 bg-linear-to-b from-white to-gray-50 overflow-hidden">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="text-center mb-16">
            <span className="inline-flex items-center gap-2 rounded-full bg-[#1d71b8]/10 px-4 py-2 text-sm font-semibold text-[#1d71b8] mb-4">
              <Zap className="h-4 w-4" />
              {locale === 'ar' ? 'مميزات حصرية' : 'Exclusive Features'}
            </span>
            <h2 className="text-2xl font-bold text-gray-900 sm:text-3xl lg:text-4xl">
              {locale === 'ar' ? 'لماذا تختار استضافتنا المشتركة؟' : 'Why Choose Our Shared Hosting?'}
            </h2>
            <p className="mx-auto mt-4 max-w-2xl text-gray-600">
              {locale === 'ar'
                ? 'نقدم لك أفضل تجربة استضافة مع ميزات متقدمة بأسعار تنافسية'
                : 'We offer you the best hosting experience with advanced features at competitive prices'}
            </p>
          </div>

          {/* Bento Grid Layout */}
          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-4 lg:gap-6">
            {/* Large Feature - Speed */}
            <div 
              ref={(el) => { featureCardsRef.current[0] = el; }}
              className="lg:col-span-7 group relative rounded-3xl bg-linear-to-br from-[#1d71b8] to-[#0f4c75] p-8 lg:p-10 text-white overflow-hidden min-h-70"
            >
              <div className="relative z-10">
                <div className="feature-icon inline-flex h-14 w-14 items-center justify-center rounded-2xl bg-white/20 backdrop-blur-sm mb-6">
                  <Zap className="h-7 w-7" />
                </div>
                <h3 className="text-2xl lg:text-3xl font-bold mb-3">
                  {locale === 'ar' ? 'سرعة فائقة' : 'Lightning Fast'}
                </h3>
                <p className="text-white/80 text-lg max-w-md">
                  {locale === 'ar' 
                    ? 'سيرفرات LiteSpeed مع تخزين NVMe SSD لأداء استثنائي'
                    : 'LiteSpeed servers with NVMe SSD storage for exceptional performance'}
                </p>
                <div className="mt-6 flex items-center gap-6">
                  <div>
                    <div className="text-3xl font-bold">99.9%</div>
                    <div className="text-white/60 text-sm">{locale === 'ar' ? 'وقت التشغيل' : 'Uptime'}</div>
                  </div>
                  <div>
                    <div className="text-3xl font-bold">&lt;100ms</div>
                    <div className="text-white/60 text-sm">{locale === 'ar' ? 'زمن الاستجابة' : 'Response'}</div>
                  </div>
                </div>
              </div>
              {/* Decorative elements */}
              <div className="absolute top-0 ltr:right-0 rtl:left-0 w-64 h-64 bg-white/10 rounded-full blur-3xl -translate-y-1/2 ltr:translate-x-1/2 rtl:-translate-x-1/2" />
              <div className="absolute bottom-0 ltr:left-0 rtl:right-0 w-32 h-32 bg-white/5 rounded-full blur-2xl translate-y-1/2 ltr:-translate-x-1/2 rtl:translate-x-1/2" />
              <Zap className="absolute bottom-4 ltr:right-4 rtl:left-4 h-32 w-32 text-white/5" />
            </div>

            {/* Security */}
            <div 
              ref={(el) => { featureCardsRef.current[1] = el; }}
              className="lg:col-span-5 group relative rounded-3xl bg-green-50 p-8 overflow-hidden min-h-70 hover:shadow-xl transition-shadow"
            >
              <div className="feature-icon inline-flex h-12 w-12 items-center justify-center rounded-xl bg-green-100 text-green-600 mb-4">
                <Shield className="h-6 w-6" />
              </div>
              <h3 className="text-xl font-bold text-gray-900 mb-2">
                {locale === 'ar' ? 'حماية متقدمة' : 'Advanced Security'}
              </h3>
              <p className="text-gray-600">
                {locale === 'ar'
                  ? 'حماية DDoS، جدار حماية، وفحص البرمجيات الخبيثة'
                  : 'DDoS protection, firewall, and malware scanning'}
              </p>
              <div className="mt-6 flex flex-wrap gap-2">
                {['DDoS', 'Firewall', 'SSL', 'Malware Scan'].map((tag) => (
                  <span key={tag} className="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-medium">
                    {tag}
                  </span>
                ))}
              </div>
              <Shield className="absolute bottom-4 ltr:right-4 rtl:left-4 h-24 w-24 text-green-100" />
            </div>

            {/* Backup */}
            <div 
              ref={(el) => { featureCardsRef.current[2] = el; }}
              className="lg:col-span-4 group relative rounded-3xl bg-blue-50 p-8 overflow-hidden hover:shadow-xl transition-shadow"
            >
              <div className="feature-icon inline-flex h-12 w-12 items-center justify-center rounded-xl bg-blue-100 text-blue-600 mb-4">
                <RefreshCw className="h-6 w-6" />
              </div>
              <h3 className="text-xl font-bold text-gray-900 mb-2">
                {locale === 'ar' ? 'نسخ احتياطي' : 'Auto Backups'}
              </h3>
              <p className="text-gray-600 text-sm">
                {locale === 'ar'
                  ? 'نسخ احتياطي يومي مع استعادة بنقرة واحدة'
                  : 'Daily backups with one-click restore'}
              </p>
              <RefreshCw className="absolute bottom-4 ltr:right-4 rtl:left-4 h-20 w-20 text-blue-100" />
            </div>

            {/* Support */}
            <div 
              ref={(el) => { featureCardsRef.current[3] = el; }}
              className="lg:col-span-4 group relative rounded-3xl bg-cyan-50 p-8 overflow-hidden hover:shadow-xl transition-shadow"
            >
              <div className="relative z-10">
                <div className="feature-icon inline-flex h-12 w-12 items-center justify-center rounded-xl bg-cyan-100 text-cyan-600 mb-4">
                  <Headphones className="h-6 w-6" />
                </div>
                <h3 className="text-xl font-bold text-gray-900 mb-2">
                  {locale === 'ar' ? 'دعم 24/7' : '24/7 Support'}
                </h3>
                <p className="text-gray-600 text-sm">
                  {locale === 'ar'
                    ? 'فريق دعم متخصص متاح على مدار الساعة'
                    : 'Expert support team available around the clock'}
                </p>
              </div>
              <Headphones className="absolute -bottom-2 ltr:-right-2 rtl:-left-2 h-24 w-24 text-cyan-100/50" />
            </div>

            {/* SSL & cPanel */}
            <div 
              ref={(el) => { featureCardsRef.current[4] = el; }}
              className="lg:col-span-4 group relative rounded-3xl bg-linear-to-br from-amber-50 to-orange-50 p-8 overflow-hidden hover:shadow-xl transition-shadow"
            >
              <div className="flex gap-4 mb-4">
                <div className="feature-icon inline-flex h-12 w-12 items-center justify-center rounded-xl bg-amber-100 text-amber-600">
                  <Globe className="h-6 w-6" />
                </div>
                <div className="feature-icon inline-flex h-12 w-12 items-center justify-center rounded-xl bg-orange-100 text-orange-600">
                  <Gauge className="h-6 w-6" />
                </div>
              </div>
              <h3 className="text-xl font-bold text-gray-900 mb-2">
                {locale === 'ar' ? 'SSL + cPanel' : 'Free SSL + cPanel'}
              </h3>
              <p className="text-gray-600 text-sm">
                {locale === 'ar'
                  ? 'شهادة SSL مجانية مع لوحة تحكم cPanel سهلة'
                  : 'Free SSL certificate with easy-to-use cPanel'}
              </p>
            </div>
          </div>

          {/* Bottom Stats */}
          <div className="mt-16 flex flex-wrap justify-center gap-8 lg:gap-16">
            {[
              { value: '50K+', label: locale === 'ar' ? 'عميل سعيد' : 'Happy Clients' },
              { value: '99.9%', label: locale === 'ar' ? 'وقت التشغيل' : 'Uptime' },
              { value: '24/7', label: locale === 'ar' ? 'دعم فني' : 'Support' },
              { value: '30', label: locale === 'ar' ? 'يوم ضمان' : 'Day Guarantee' },
            ].map((stat, index) => (
              <div key={index} className="text-center">
                <div className="text-3xl lg:text-4xl font-bold text-[#1d71b8]">{stat.value}</div>
                <div className="text-gray-600 mt-1">{stat.label}</div>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* Easy Control Panel Section */}
      <section className="py-16 lg:py-24 bg-linear-to-br from-[#0f2d3d] via-[#1a4a5e] to-[#1d71b8] overflow-hidden relative">
        {/* Background decorations */}
        <div className="absolute inset-0 overflow-hidden">
          <div className="absolute top-0 left-1/4 w-96 h-96 bg-white/5 rounded-full blur-3xl" />
          <div className="absolute bottom-0 right-1/4 w-64 h-64 bg-[#1d71b8]/20 rounded-full blur-3xl" />
        </div>
        
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 relative z-10">
          <div className="grid lg:grid-cols-2 gap-12 lg:gap-16 items-center">
            {/* Left Content */}
            <div>
              <span className="inline-flex items-center gap-2 rounded-full bg-white/10 backdrop-blur-sm px-4 py-2 text-sm font-semibold text-white/90 mb-6">
                <Gauge className="h-4 w-4" />
                {locale === 'ar' ? 'لوحة تحكم سهلة' : 'Easy Control Panel'}
              </span>
              <h2 className="text-3xl font-bold text-white sm:text-4xl lg:text-5xl leading-tight">
                {locale === 'ar' ? (
                  <>
                    <span className="text-[#60a5fa]">Pro Gineous</span> استضافة ويب
                    <br />
                    بلوحة تحكم سهلة
                  </>
                ) : (
                  <>
                    <span className="text-[#60a5fa]">Pro Gineous</span> Web Hosting
                    <br />
                    Easy Control Panel
                  </>
                )}
              </h2>
              <p className="mt-6 text-lg text-white/70 max-w-lg">
                {locale === 'ar'
                  ? 'تثبيت التطبيقات أصبح سهلاً مع cPanel! أكثر من 100 تطبيق من أفضل التطبيقات، بما في ذلك WordPress، جاهزة للتثبيت بنقرة واحدة.'
                  : 'Installing apps is easy with cPanel! Over 100 of the very best applications, including WordPress, all ready to install with just a click of the mouse or the tap of the finger.'}
              </p>

              {/* Features List */}
              <div className="mt-10 space-y-6">
                {[
                  {
                    icon: Zap,
                    title: locale === 'ar' ? 'تثبيت بنقرة واحدة' : 'One-Click Install',
                    description: locale === 'ar' 
                      ? 'أكثر من 100 تطبيق جاهز للتثبيت فوراً'
                      : 'Over 100 apps ready to install instantly',
                    color: 'bg-yellow-500/20 text-yellow-400'
                  },
                  {
                    icon: Mail,
                    title: locale === 'ar' ? 'إدارة بريد سهلة' : 'Simple Email Management',
                    description: locale === 'ar'
                      ? 'إدارة بريدك الإلكتروني بسهولة من نفس اللوحة'
                      : 'Manage your email effortlessly within the same intuitive panel',
                    color: 'bg-blue-500/20 text-blue-400'
                  },
                  {
                    icon: Server,
                    title: locale === 'ar' ? 'إدارة موقع كاملة' : 'Complete Website Management',
                    description: locale === 'ar'
                      ? 'من الإعداد إلى الصيانة المستمرة، نحن نغطيك'
                      : 'From setup to ongoing maintenance, we\'ve got you covered',
                    color: 'bg-green-500/20 text-green-400'
                  }
                ].map((feature, index) => (
                  <div key={index} className="flex gap-4 group">
                    <div className={cn('shrink-0 w-12 h-12 rounded-xl flex items-center justify-center transition-transform group-hover:scale-110', feature.color)}>
                      <feature.icon className="h-6 w-6" />
                    </div>
                    <div>
                      <h3 className="text-lg font-semibold text-white">{feature.title}</h3>
                      <p className="text-white/60 mt-1">{feature.description}</p>
                    </div>
                  </div>
                ))}
              </div>

              {/* CTA Button */}
              <div className="mt-10">
                <a
                  href="#pricing"
                  className="inline-flex items-center gap-2 rounded-full bg-white px-8 py-4 text-base font-semibold text-[#1d71b8] shadow-lg transition-all hover:bg-white/90 hover:shadow-xl hover:scale-105"
                >
                  {locale === 'ar' ? 'ابدأ الآن' : 'Get Started Now'}
                  <ArrowRight className="h-5 w-5 rtl:rotate-180" />
                </a>
              </div>
            </div>

            {/* Right - cPanel Mockup */}
            <div className="relative">
              <div className="relative bg-white rounded-2xl shadow-2xl overflow-hidden">
                {/* Browser Header */}
                <div className="bg-gray-100 px-4 py-3 flex items-center gap-2 border-b">
                  <div className="flex gap-1.5">
                    <div className="w-3 h-3 rounded-full bg-red-400" />
                    <div className="w-3 h-3 rounded-full bg-yellow-400" />
                    <div className="w-3 h-3 rounded-full bg-green-400" />
                  </div>
                  <div className="flex-1 mx-4">
                    <div className="bg-white rounded-md px-3 py-1.5 text-sm text-gray-500 flex items-center gap-2">
                      <Lock className="h-3.5 w-3.5 text-green-500" />
                      cpanel.progineous.com
                    </div>
                  </div>
                </div>
                
                {/* cPanel Content */}
                <div className="p-6 bg-gray-50">
                  <div className="flex items-center gap-3 mb-6">
                    <div className="w-10 h-10 rounded-lg bg-[#1d71b8] flex items-center justify-center">
                      <Gauge className="h-5 w-5 text-white" />
                    </div>
                    <div>
                      <div className="font-semibold text-gray-900">cPanel</div>
                      <div className="text-xs text-gray-500">Control Panel</div>
                    </div>
                  </div>
                  
                  {/* App Icons Grid */}
                  <div className="grid grid-cols-4 gap-3">
                    {[
                      { name: 'WordPress', color: 'bg-blue-500', icon: '📝' },
                      { name: 'Files', color: 'bg-yellow-500', icon: '📁' },
                      { name: 'Email', color: 'bg-red-500', icon: '✉️' },
                      { name: 'Database', color: 'bg-green-500', icon: '🗄️' },
                      { name: 'SSL', color: 'bg-emerald-500', icon: '🔒' },
                      { name: 'Domains', color: 'bg-indigo-500', icon: '🌐' },
                      { name: 'Backup', color: 'bg-orange-500', icon: '💾' },
                      { name: 'Stats', color: 'bg-pink-500', icon: '📊' },
                    ].map((app, index) => (
                      <div key={index} className="flex flex-col items-center p-3 rounded-xl bg-white shadow-sm hover:shadow-md transition-shadow cursor-pointer group">
                        <div className={cn('w-10 h-10 rounded-lg flex items-center justify-center text-xl group-hover:scale-110 transition-transform', app.color)}>
                          {app.icon}
                        </div>
                        <span className="text-xs text-gray-600 mt-2 text-center">{app.name}</span>
                      </div>
                    ))}
                  </div>
                  
                  {/* Quick Stats */}
                  <div className="mt-6 grid grid-cols-3 gap-3">
                    <div className="bg-white rounded-xl p-3 shadow-sm">
                      <div className="text-xs text-gray-500">{locale === 'ar' ? 'التخزين' : 'Storage'}</div>
                      <div className="text-lg font-bold text-gray-900">45%</div>
                      <div className="h-1.5 bg-gray-100 rounded-full mt-2">
                        <div className="h-full w-[45%] bg-[#1d71b8] rounded-full" />
                      </div>
                    </div>
                    <div className="bg-white rounded-xl p-3 shadow-sm">
                      <div className="text-xs text-gray-500">{locale === 'ar' ? 'الباندويث' : 'Bandwidth'}</div>
                      <div className="text-lg font-bold text-gray-900">28%</div>
                      <div className="h-1.5 bg-gray-100 rounded-full mt-2">
                        <div className="h-full w-[28%] bg-green-500 rounded-full" />
                      </div>
                    </div>
                    <div className="bg-white rounded-xl p-3 shadow-sm">
                      <div className="text-xs text-gray-500">{locale === 'ar' ? 'البريد' : 'Emails'}</div>
                      <div className="text-lg font-bold text-gray-900">12</div>
                      <div className="text-xs text-green-500 mt-1">Active</div>
                    </div>
                  </div>
                </div>
              </div>
              
              {/* Floating Elements */}
              <div className="absolute -top-4 -right-4 bg-green-500 text-white px-4 py-2 rounded-full text-sm font-semibold shadow-lg animate-bounce">
                100+ Apps
              </div>
              <div className="absolute -bottom-4 -left-4 bg-white text-gray-900 px-4 py-2 rounded-full text-sm font-semibold shadow-lg flex items-center gap-2">
                <Check className="h-4 w-4 text-green-500" />
                {locale === 'ar' ? 'مجاني مع الاستضافة' : 'Free with Hosting'}
              </div>
            </div>
          </div>
        </div>
      </section>

      {/* Comparison Table Section */}
      <section className="py-16 lg:py-24 bg-linear-to-b from-gray-50 to-white overflow-hidden">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="text-center mb-16">
            <span className="inline-block px-4 py-1.5 rounded-full bg-[#1d71b8]/10 text-[#1d71b8] text-sm font-semibold mb-4">
              {locale === 'ar' ? 'قارن واختر' : 'Compare & Choose'}
            </span>
            <h2 className="text-3xl font-bold text-gray-900 sm:text-4xl lg:text-5xl">
              {locale === 'ar' ? 'مقارنة الخطط' : 'Compare Plans'}
            </h2>
            <p className="mx-auto mt-4 max-w-2xl text-lg text-gray-600">
              {locale === 'ar'
                ? 'اختر الخطة المناسبة لاحتياجاتك'
                : 'Choose the right plan for your needs'}
            </p>
          </div>

          <div className="relative" ref={tableRef}>
            {/* Decorative elements */}
            <div className="absolute -top-10 -left-10 w-40 h-40 bg-[#1d71b8]/5 rounded-full blur-3xl"></div>
            <div className="absolute -bottom-10 -right-10 w-40 h-40 bg-[#1d71b8]/5 rounded-full blur-3xl"></div>
            
            {/* Desktop Table */}
            <div className="hidden lg:block relative rounded-3xl bg-white shadow-xl shadow-gray-200/50 border border-gray-100">
              {/* Sticky Header */}
              <div className="sticky top-16 z-20 bg-white/95 backdrop-blur-sm rounded-t-3xl border-b border-gray-100">
                <table className="w-full table-fixed">
                  <thead>
                    <tr>
                      <th className="w-[35%] py-5 px-6 text-start text-base font-semibold text-gray-500">
                        {locale === 'ar' ? 'الميزات' : 'Features'}
                      </th>
                      <th className="w-[21.67%] py-5 px-4 text-center">
                        <div className="text-lg font-bold text-gray-900">Startup</div>
                        <div className="text-xl font-extrabold text-[#1d71b8]">
                          ${billingPeriod === 'yearly' ? '2' : '10'}
                          <span className="text-sm font-normal text-gray-500">/mo</span>
                        </div>
                      </th>
                      <th className="w-[21.67%] py-5 px-4 text-center relative">
                        <div className="absolute inset-0 bg-linear-to-b from-[#1d71b8]/10 to-[#1d71b8]/5"></div>
                        <div className="relative">
                          <span className="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-[#1d71b8] text-white text-xs font-semibold mb-1">
                            <Star className="h-3 w-3 fill-current" />
                            {locale === 'ar' ? 'الأكثر شعبية' : 'Popular'}
                          </span>
                          <div className="text-lg font-bold text-gray-900">Essential</div>
                          <div className="text-xl font-extrabold text-[#1d71b8]">
                            ${billingPeriod === 'yearly' ? '3.25' : '13'}
                            <span className="text-sm font-normal text-gray-500">/mo</span>
                          </div>
                        </div>
                      </th>
                      <th className="w-[21.67%] py-5 px-4 text-center">
                        <div className="text-lg font-bold text-gray-900">Ultimate</div>
                        <div className="text-xl font-extrabold text-[#0f4c75]">
                          ${billingPeriod === 'yearly' ? '6.60' : '19'}
                          <span className="text-sm font-normal text-gray-500">/mo</span>
                        </div>
                      </th>
                    </tr>
                  </thead>
                </table>
              </div>
              
              <table className="w-full table-fixed">
                <colgroup>
                  <col className="w-[35%]" />
                  <col className="w-[21.67%]" />
                  <col className="w-[21.67%]" />
                  <col className="w-[21.67%]" />
                </colgroup>
                <thead className="sr-only">
                  <tr>
                    <th>{locale === 'ar' ? 'الميزات' : 'Features'}</th>
                    <th>Startup</th>
                    <th>Essential</th>
                    <th>Ultimate</th>
                  </tr>
                </thead>
                <tbody>
                  {/* Storage & Resources - Collapsible */}
                  <tr>
                    <td colSpan={4} className="p-0">
                      <button 
                        onClick={() => toggleSection('storage')}
                        className="w-full py-4 px-6 bg-linear-to-r from-gray-100 to-transparent flex items-center justify-between hover:from-gray-200 transition-colors"
                      >
                        <div className="flex items-center gap-2">
                          <Database className="h-4 w-4 text-[#1d71b8]" />
                          <span className="text-sm font-bold text-gray-800">{locale === 'ar' ? 'الموارد والتخزين' : 'Storage & Resources'}</span>
                        </div>
                        <ChevronDown className={cn("h-4 w-4 text-gray-500 transition-transform", expandedSections.includes('storage') && "rotate-180")} />
                      </button>
                    </td>
                  </tr>
                  {expandedSections.includes('storage') && (
                    <>
                  <tr className="group hover:bg-gray-50/50 transition-colors">
                    <td className="py-4 px-6 text-sm text-gray-600">{locale === 'ar' ? 'عدد المواقع' : 'Websites'}</td>
                    <td className="py-4 px-4 text-center"><span className="inline-flex items-center justify-center min-w-15 px-3 py-1 rounded-full bg-gray-100 text-sm font-semibold text-gray-700">150</span></td>
                    <td className="py-4 px-4 text-center bg-[#1d71b8]/5"><span className="inline-flex items-center justify-center min-w-15 px-3 py-1 rounded-full bg-[#1d71b8]/20 text-sm font-semibold text-[#1d71b8]">200</span></td>
                    <td className="py-4 px-4 text-center"><span className="inline-flex items-center justify-center min-w-15 px-3 py-1 rounded-full bg-[#0f4c75]/20 text-sm font-semibold text-[#0f4c75]">350</span></td>
                  </tr>
                  <tr className="group hover:bg-gray-50/50 transition-colors">
                    <td className="py-4 px-6 text-sm text-gray-600">{locale === 'ar' ? 'مساحة التخزين SSD' : 'SSD Storage'}</td>
                    <td className="py-4 px-4 text-center"><span className="inline-flex items-center justify-center min-w-15 px-3 py-1 rounded-full bg-gray-100 text-sm font-semibold text-gray-700">70 GB</span></td>
                    <td className="py-4 px-4 text-center bg-[#1d71b8]/5"><span className="inline-flex items-center justify-center min-w-15 px-3 py-1 rounded-full bg-[#1d71b8]/20 text-sm font-semibold text-[#1d71b8]">150 GB</span></td>
                    <td className="py-4 px-4 text-center"><span className="inline-flex items-center justify-center min-w-15 px-3 py-1 rounded-full bg-[#0f4c75]/20 text-sm font-semibold text-[#0f4c75]">250 GB</span></td>
                  </tr>
                  <tr className="group hover:bg-gray-50/50 transition-colors">
                    <td className="py-4 px-6 text-sm text-gray-600">{locale === 'ar' ? 'الذاكرة RAM' : 'RAM'}</td>
                    <td className="py-4 px-4 text-center"><span className="inline-flex items-center justify-center min-w-15 px-3 py-1 rounded-full bg-gray-100 text-sm font-semibold text-gray-700">1.5 GB</span></td>
                    <td className="py-4 px-4 text-center bg-[#1d71b8]/5"><span className="inline-flex items-center justify-center min-w-15 px-3 py-1 rounded-full bg-[#1d71b8]/20 text-sm font-semibold text-[#1d71b8]">2 GB</span></td>
                    <td className="py-4 px-4 text-center"><span className="inline-flex items-center justify-center min-w-15 px-3 py-1 rounded-full bg-[#0f4c75]/20 text-sm font-semibold text-[#0f4c75]">3 GB</span></td>
                  </tr>
                  <tr className="group hover:bg-gray-50/50 transition-colors">
                    <td className="py-4 px-6 text-sm text-gray-600">{locale === 'ar' ? 'نواة المعالج' : 'CPU Cores'}</td>
                    <td className="py-4 px-4 text-center"><span className="inline-flex items-center justify-center min-w-15 px-3 py-1 rounded-full bg-gray-100 text-sm font-semibold text-gray-700">1.5</span></td>
                    <td className="py-4 px-4 text-center bg-[#1d71b8]/5"><span className="inline-flex items-center justify-center min-w-15 px-3 py-1 rounded-full bg-[#1d71b8]/20 text-sm font-semibold text-[#1d71b8]">1.5</span></td>
                    <td className="py-4 px-4 text-center"><span className="inline-flex items-center justify-center min-w-15 px-3 py-1 rounded-full bg-[#0f4c75]/20 text-sm font-semibold text-[#0f4c75]">2</span></td>
                  </tr>
                  <tr className="group hover:bg-gray-50/50 transition-colors">
                    <td className="py-4 px-6 text-sm text-gray-600">{locale === 'ar' ? 'النطاق الترددي' : 'Bandwidth'}</td>
                    <td className="py-4 px-4 text-center"><span className="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-green-100 text-sm font-semibold text-green-700">∞</span></td>
                    <td className="py-4 px-4 text-center bg-[#1d71b8]/5"><span className="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-green-100 text-sm font-semibold text-green-700">∞</span></td>
                    <td className="py-4 px-4 text-center"><span className="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-green-100 text-sm font-semibold text-green-700">∞</span></td>
                  </tr>
                    </>
                  )}

                  {/* Performance - Collapsible */}
                  <tr>
                    <td colSpan={4} className="p-0">
                      <button 
                        onClick={() => toggleSection('performance')}
                        className="w-full py-4 px-6 bg-linear-to-r from-gray-100 to-transparent flex items-center justify-between hover:from-gray-200 transition-colors"
                      >
                        <div className="flex items-center gap-2">
                          <Gauge className="h-4 w-4 text-[#1d71b8]" />
                          <span className="text-sm font-bold text-gray-800">{locale === 'ar' ? 'الأداء' : 'Performance'}</span>
                        </div>
                        <ChevronDown className={cn("h-4 w-4 text-gray-500 transition-transform", expandedSections.includes('performance') && "rotate-180")} />
                      </button>
                    </td>
                  </tr>
                  {expandedSections.includes('performance') && (
                    <>
                  <tr className="group hover:bg-gray-50/50 transition-colors">
                    <td className="py-4 px-6 text-sm text-gray-600">{locale === 'ar' ? 'مستوى الأداء' : 'Performance Level'}</td>
                    <td className="py-4 px-4 text-center"><span className="inline-flex items-center justify-center px-3 py-1 rounded-full bg-yellow-100 text-sm font-bold text-yellow-700">⚡ 2x</span></td>
                    <td className="py-4 px-4 text-center bg-[#1d71b8]/5"><span className="inline-flex items-center justify-center px-3 py-1 rounded-full bg-orange-100 text-sm font-bold text-orange-700">⚡⚡ 5x</span></td>
                    <td className="py-4 px-4 text-center"><span className="inline-flex items-center justify-center px-3 py-1 rounded-full bg-red-100 text-sm font-bold text-red-700">🚀 10x</span></td>
                  </tr>
                  <tr className="group hover:bg-gray-50/50 transition-colors">
                    <td className="py-4 px-6 text-sm text-gray-600">{locale === 'ar' ? 'الزيارات الشهرية' : 'Monthly Visits'}</td>
                    <td className="py-4 px-4 text-center"><span className="text-sm font-semibold text-gray-700">50K</span></td>
                    <td className="py-4 px-4 text-center bg-[#1d71b8]/5"><span className="text-sm font-semibold text-[#1d71b8]">150K</span></td>
                    <td className="py-4 px-4 text-center"><span className="text-sm font-semibold text-[#0f4c75]">250K</span></td>
                  </tr>
                  <tr className="group hover:bg-gray-50/50 transition-colors">
                    <td className="py-4 px-6 text-sm text-gray-600">LiteSpeed Server</td>
                    <td className="py-4 px-4 text-center"><div className="inline-flex items-center justify-center w-7 h-7 rounded-full bg-green-100"><Check className="h-4 w-4 text-green-600" /></div></td>
                    <td className="py-4 px-4 text-center bg-[#1d71b8]/5"><div className="inline-flex items-center justify-center w-7 h-7 rounded-full bg-green-100"><Check className="h-4 w-4 text-green-600" /></div></td>
                    <td className="py-4 px-4 text-center"><div className="inline-flex items-center justify-center w-7 h-7 rounded-full bg-green-100"><Check className="h-4 w-4 text-green-600" /></div></td>
                  </tr>
                    </>
                  )}

                  {/* Email & Domains - Collapsible */}
                  <tr>
                    <td colSpan={4} className="p-0">
                      <button 
                        onClick={() => toggleSection('email')}
                        className="w-full py-4 px-6 bg-linear-to-r from-gray-100 to-transparent flex items-center justify-between hover:from-gray-200 transition-colors"
                      >
                        <div className="flex items-center gap-2">
                          <Mail className="h-4 w-4 text-[#1d71b8]" />
                          <span className="text-sm font-bold text-gray-800">{locale === 'ar' ? 'البريد والدومين' : 'Email & Domains'}</span>
                        </div>
                        <ChevronDown className={cn("h-4 w-4 text-gray-500 transition-transform", expandedSections.includes('email') && "rotate-180")} />
                      </button>
                    </td>
                  </tr>
                  {expandedSections.includes('email') && (
                    <>
                  <tr className="group hover:bg-gray-50/50 transition-colors">
                    <td className="py-4 px-6 text-sm text-gray-600">{locale === 'ar' ? 'صناديق البريد' : 'Email Mailboxes'}</td>
                    <td className="py-4 px-4 text-center"><span className="text-sm font-semibold text-gray-700">150</span></td>
                    <td className="py-4 px-4 text-center bg-[#1d71b8]/5"><span className="text-sm font-semibold text-[#1d71b8]">200</span></td>
                    <td className="py-4 px-4 text-center"><span className="text-sm font-semibold text-[#0f4c75]">350</span></td>
                  </tr>
                  {billingPeriod === 'yearly' && (
                  <tr className="group hover:bg-gray-50/50 transition-colors bg-linear-to-r from-amber-50/50 to-yellow-50/50">
                    <td className="py-4 px-6 text-sm text-gray-600">
                      <div className="flex items-center gap-2 font-semibold text-amber-700">
                        🎁 {locale === 'ar' ? 'دومين مجاني (السنة الأولى)' : 'Free Domain (1st year)'}
                      </div>
                    </td>
                    <td className="py-4 px-4 text-center"><div className="inline-flex items-center justify-center w-7 h-7 rounded-full bg-green-100"><Check className="h-4 w-4 text-green-600" /></div></td>
                    <td className="py-4 px-4 text-center bg-[#1d71b8]/5"><div className="inline-flex items-center justify-center w-7 h-7 rounded-full bg-green-100"><Check className="h-4 w-4 text-green-600" /></div></td>
                    <td className="py-4 px-4 text-center"><div className="inline-flex items-center justify-center w-7 h-7 rounded-full bg-green-100"><Check className="h-4 w-4 text-green-600" /></div></td>
                  </tr>
                  )}
                  <tr className="group hover:bg-gray-50/50 transition-colors">
                    <td className="py-4 px-6 text-sm text-gray-600">{locale === 'ar' ? 'شهادات SSL' : 'SSL Certificates'}</td>
                    <td className="py-4 px-4 text-center"><span className="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-green-100 text-sm font-semibold text-green-700">∞</span></td>
                    <td className="py-4 px-4 text-center bg-[#1d71b8]/5"><span className="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-green-100 text-sm font-semibold text-green-700">∞</span></td>
                    <td className="py-4 px-4 text-center"><span className="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-green-100 text-sm font-semibold text-green-700">∞</span></td>
                  </tr>
                    </>
                  )}

                  {/* Features - Collapsible */}
                  <tr>
                    <td colSpan={4} className="p-0">
                      <button 
                        onClick={() => toggleSection('features')}
                        className="w-full py-4 px-6 bg-linear-to-r from-gray-100 to-transparent flex items-center justify-between hover:from-gray-200 transition-colors"
                      >
                        <div className="flex items-center gap-2">
                          <Sparkles className="h-4 w-4 text-[#1d71b8]" />
                          <span className="text-sm font-bold text-gray-800">{locale === 'ar' ? 'الميزات الإضافية' : 'Additional Features'}</span>
                        </div>
                        <ChevronDown className={cn("h-4 w-4 text-gray-500 transition-transform", expandedSections.includes('features') && "rotate-180")} />
                      </button>
                    </td>
                  </tr>
                  {expandedSections.includes('features') && (
                    <>
                  <tr className="group hover:bg-gray-50/50 transition-colors">
                    <td className="py-4 px-6 text-sm text-gray-600">{locale === 'ar' ? 'النسخ الاحتياطي التلقائي' : 'Auto Backup'}</td>
                    <td className="py-4 px-4 text-center"><div className="inline-flex items-center justify-center w-7 h-7 rounded-full bg-gray-100"><Minus className="h-4 w-4 text-gray-400" /></div></td>
                    <td className="py-4 px-4 text-center bg-[#1d71b8]/5"><div className="inline-flex items-center justify-center w-7 h-7 rounded-full bg-green-100"><Check className="h-4 w-4 text-green-600" /></div></td>
                    <td className="py-4 px-4 text-center"><div className="inline-flex items-center justify-center w-7 h-7 rounded-full bg-green-100"><Check className="h-4 w-4 text-green-600" /></div></td>
                  </tr>
                  <tr className="group hover:bg-gray-50/50 transition-colors">
                    <td className="py-4 px-6 text-sm text-gray-600">{locale === 'ar' ? 'CDN مجاني' : 'Free CDN'}</td>
                    <td className="py-4 px-4 text-center"><div className="inline-flex items-center justify-center w-7 h-7 rounded-full bg-gray-100"><Minus className="h-4 w-4 text-gray-400" /></div></td>
                    <td className="py-4 px-4 text-center bg-[#1d71b8]/5"><div className="inline-flex items-center justify-center w-7 h-7 rounded-full bg-green-100"><Check className="h-4 w-4 text-green-600" /></div></td>
                    <td className="py-4 px-4 text-center"><div className="inline-flex items-center justify-center w-7 h-7 rounded-full bg-green-100"><Check className="h-4 w-4 text-green-600" /></div></td>
                  </tr>
                  <tr className="group hover:bg-gray-50/50 transition-colors">
                    <td className="py-4 px-6 text-sm text-gray-600">{locale === 'ar' ? 'التخزين السحابي' : 'Cloud Storage'}</td>
                    <td className="py-4 px-4 text-center"><div className="inline-flex items-center justify-center w-7 h-7 rounded-full bg-gray-100"><Minus className="h-4 w-4 text-gray-400" /></div></td>
                    <td className="py-4 px-4 text-center bg-[#1d71b8]/5"><div className="inline-flex items-center justify-center w-7 h-7 rounded-full bg-green-100"><Check className="h-4 w-4 text-green-600" /></div></td>
                    <td className="py-4 px-4 text-center"><div className="inline-flex items-center justify-center w-7 h-7 rounded-full bg-green-100"><Check className="h-4 w-4 text-green-600" /></div></td>
                  </tr>
                  <tr className="group hover:bg-gray-50/50 transition-colors">
                    <td className="py-4 px-6 text-sm text-gray-600">{locale === 'ar' ? 'عنوان IP مخصص' : 'Dedicated IP'}</td>
                    <td className="py-4 px-4 text-center"><div className="inline-flex items-center justify-center w-7 h-7 rounded-full bg-gray-100"><Minus className="h-4 w-4 text-gray-400" /></div></td>
                    <td className="py-4 px-4 text-center bg-[#1d71b8]/5"><div className="inline-flex items-center justify-center w-7 h-7 rounded-full bg-gray-100"><Minus className="h-4 w-4 text-gray-400" /></div></td>
                    <td className="py-4 px-4 text-center"><div className="inline-flex items-center justify-center w-7 h-7 rounded-full bg-green-100"><Check className="h-4 w-4 text-green-600" /></div></td>
                  </tr>
                  <tr className="group hover:bg-gray-50/50 transition-colors">
                    <td className="py-4 px-6 text-sm text-gray-600">{locale === 'ar' ? 'أدوات WordPress AI' : 'WordPress AI Tools'}</td>
                    <td className="py-4 px-4 text-center"><div className="inline-flex items-center justify-center w-7 h-7 rounded-full bg-gray-100"><Minus className="h-4 w-4 text-gray-400" /></div></td>
                    <td className="py-4 px-4 text-center bg-[#1d71b8]/5"><div className="inline-flex items-center justify-center w-7 h-7 rounded-full bg-gray-100"><Minus className="h-4 w-4 text-gray-400" /></div></td>
                    <td className="py-4 px-4 text-center"><div className="inline-flex items-center justify-center w-7 h-7 rounded-full bg-green-100"><Check className="h-4 w-4 text-green-600" /></div></td>
                  </tr>
                  <tr className="group hover:bg-gray-50/50 transition-colors">
                    <td className="py-4 px-6 text-sm text-gray-600">{locale === 'ar' ? 'دعم أولوية' : 'Priority Support'}</td>
                    <td className="py-4 px-4 text-center"><div className="inline-flex items-center justify-center w-7 h-7 rounded-full bg-gray-100"><Minus className="h-4 w-4 text-gray-400" /></div></td>
                    <td className="py-4 px-4 text-center bg-[#1d71b8]/5"><div className="inline-flex items-center justify-center w-7 h-7 rounded-full bg-gray-100"><Minus className="h-4 w-4 text-gray-400" /></div></td>
                    <td className="py-4 px-4 text-center"><div className="inline-flex items-center justify-center w-7 h-7 rounded-full bg-green-100"><Check className="h-4 w-4 text-green-600" /></div></td>
                  </tr>
                    </>
                  )}

                  {/* Security - Collapsible */}
                  <tr>
                    <td colSpan={4} className="p-0">
                      <button 
                        onClick={() => toggleSection('security')}
                        className="w-full py-4 px-6 bg-linear-to-r from-gray-100 to-transparent flex items-center justify-between hover:from-gray-200 transition-colors"
                      >
                        <div className="flex items-center gap-2">
                          <Shield className="h-4 w-4 text-[#1d71b8]" />
                          <span className="text-sm font-bold text-gray-800">{locale === 'ar' ? 'الأمان' : 'Security'}</span>
                        </div>
                        <ChevronDown className={cn("h-4 w-4 text-gray-500 transition-transform", expandedSections.includes('security') && "rotate-180")} />
                      </button>
                    </td>
                  </tr>
                  {expandedSections.includes('security') && (
                    <>
                  <tr className="group hover:bg-gray-50/50 transition-colors">
                    <td className="py-4 px-6 text-sm text-gray-600">{locale === 'ar' ? 'حماية DDoS' : 'DDoS Protection'}</td>
                    <td className="py-4 px-4 text-center"><div className="inline-flex items-center justify-center w-7 h-7 rounded-full bg-green-100"><Check className="h-4 w-4 text-green-600" /></div></td>
                    <td className="py-4 px-4 text-center bg-[#1d71b8]/5"><div className="inline-flex items-center justify-center w-7 h-7 rounded-full bg-green-100"><Check className="h-4 w-4 text-green-600" /></div></td>
                    <td className="py-4 px-4 text-center"><div className="inline-flex items-center justify-center w-7 h-7 rounded-full bg-green-100"><Check className="h-4 w-4 text-green-600" /></div></td>
                  </tr>
                  <tr className="group hover:bg-gray-50/50 transition-colors">
                    <td className="py-4 px-6 text-sm text-gray-600">{locale === 'ar' ? 'جدار الحماية WAF' : 'Web Application Firewall'}</td>
                    <td className="py-4 px-4 text-center"><div className="inline-flex items-center justify-center w-7 h-7 rounded-full bg-green-100"><Check className="h-4 w-4 text-green-600" /></div></td>
                    <td className="py-4 px-4 text-center bg-[#1d71b8]/5"><div className="inline-flex items-center justify-center w-7 h-7 rounded-full bg-green-100"><Check className="h-4 w-4 text-green-600" /></div></td>
                    <td className="py-4 px-4 text-center"><div className="inline-flex items-center justify-center w-7 h-7 rounded-full bg-green-100"><Check className="h-4 w-4 text-green-600" /></div></td>
                  </tr>
                  <tr className="group hover:bg-gray-50/50 transition-colors">
                    <td className="py-4 px-6 text-sm text-gray-600">{locale === 'ar' ? 'فاحص البرمجيات الخبيثة' : 'Malware Scanner'}</td>
                    <td className="py-4 px-4 text-center"><div className="inline-flex items-center justify-center w-7 h-7 rounded-full bg-green-100"><Check className="h-4 w-4 text-green-600" /></div></td>
                    <td className="py-4 px-4 text-center bg-[#1d71b8]/5"><div className="inline-flex items-center justify-center w-7 h-7 rounded-full bg-green-100"><Check className="h-4 w-4 text-green-600" /></div></td>
                    <td className="py-4 px-4 text-center"><div className="inline-flex items-center justify-center w-7 h-7 rounded-full bg-green-100"><Check className="h-4 w-4 text-green-600" /></div></td>
                  </tr>
                    </>
                  )}
                </tbody>
                <tfoot>
                  <tr>
                    <td className="py-6 px-6 bg-gray-50/50 rounded-bl-3xl"></td>
                    <td className="py-6 px-4 text-center bg-gray-50/50">
                      <a
                        href={`https://app.progineous.com/cart.php?a=add&pid=73&billingcycle=${billingPeriod === 'yearly' ? 'annually' : 'monthly'}${billingPeriod === 'yearly' ? '&promocode=newgen80&addpromo=true' : ''}`}
                        target="_blank"
                        rel="noopener noreferrer"
                        className="inline-flex items-center justify-center gap-2 w-full rounded-xl bg-gray-900 px-4 py-2.5 text-sm font-semibold text-white hover:bg-gray-800 transition-all hover:scale-105"
                      >
                        {locale === 'ar' ? 'اختر' : 'Get'}
                        <ArrowRight className="h-4 w-4" />
                      </a>
                    </td>
                    <td className="py-6 px-4 text-center relative">
                      <div className="absolute inset-0 bg-linear-to-b from-[#1d71b8]/5 to-[#1d71b8]/10"></div>
                      <a
                        href={`https://app.progineous.com/cart.php?a=add&pid=74&billingcycle=${billingPeriod === 'yearly' ? 'annually' : 'monthly'}${billingPeriod === 'yearly' ? '&promocode=newgen75&addpromo=true' : ''}`}
                        target="_blank"
                        rel="noopener noreferrer"
                        className="relative inline-flex items-center justify-center gap-2 w-full rounded-xl bg-linear-to-r from-[#1d71b8] to-[#0f4c75] px-4 py-2.5 text-sm font-semibold text-white hover:shadow-xl hover:shadow-[#1d71b8]/30 transition-all hover:scale-105"
                      >
                        {locale === 'ar' ? 'اختر' : 'Get'}
                        <ArrowRight className="h-4 w-4" />
                      </a>
                    </td>
                    <td className="py-6 px-4 text-center bg-gray-50/50 rounded-br-3xl">
                      <a
                        href={`https://app.progineous.com/cart.php?a=add&pid=75&billingcycle=${billingPeriod === 'yearly' ? 'annually' : 'monthly'}${billingPeriod === 'yearly' ? '&promocode=newgen65&addpromo=true' : ''}`}
                        target="_blank"
                        rel="noopener noreferrer"
                        className="inline-flex items-center justify-center gap-2 w-full rounded-xl bg-linear-to-r from-[#0f4c75] to-[#0a3a5c] px-4 py-2.5 text-sm font-semibold text-white hover:shadow-xl hover:shadow-[#0f4c75]/30 transition-all hover:scale-105"
                      >
                        {locale === 'ar' ? 'اختر' : 'Get'}
                        <ArrowRight className="h-4 w-4" />
                      </a>
                    </td>
                  </tr>
                </tfoot>
              </table>
            </div>

            {/* Mobile Cards View */}
            <div className="lg:hidden space-y-6">
              {/* Plan Selector - Sticky */}
              <div className="sticky top-16 z-20 bg-white/95 backdrop-blur-sm rounded-2xl shadow-lg border border-gray-100 p-4">
                <div className="grid grid-cols-3 gap-2">
                  {[
                    { name: 'Startup', monthlyPrice: '$10', yearlyPrice: '$2', color: 'gray' },
                    { name: 'Essential', monthlyPrice: '$13', yearlyPrice: '$3.25', color: 'blue', popular: true },
                    { name: 'Ultimate', monthlyPrice: '$19', yearlyPrice: '$6.60', color: 'blue' }
                  ].map((plan) => (
                    <button
                      key={plan.name}
                      className={cn(
                        "py-3 px-2 rounded-xl text-center transition-all",
                        plan.popular 
                          ? "bg-[#1d71b8] text-white shadow-lg shadow-[#1d71b8]/30" 
                          : "bg-gray-100 text-gray-700 hover:bg-gray-200"
                      )}
                    >
                      <div className="text-sm font-bold">{plan.name}</div>
                      <div className={cn("text-xs font-semibold", plan.popular ? "text-white/80" : "text-gray-500")}>
                        {billingPeriod === 'yearly' ? plan.yearlyPrice : plan.monthlyPrice}/mo
                      </div>
                    </button>
                  ))}
                </div>
              </div>

              {/* Mobile Comparison Cards */}
              <div className="space-y-4">
                {/* Storage Section */}
                <div className="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                  <button 
                    onClick={() => toggleSection('storage')}
                    className="w-full py-4 px-5 bg-linear-to-r from-gray-50 to-white flex items-center justify-between"
                  >
                    <div className="flex items-center gap-2">
                      <Database className="h-5 w-5 text-[#1d71b8]" />
                      <span className="font-bold text-gray-800">{locale === 'ar' ? 'الموارد والتخزين' : 'Storage & Resources'}</span>
                    </div>
                    <ChevronDown className={cn("h-5 w-5 text-gray-500 transition-transform", expandedSections.includes('storage') && "rotate-180")} />
                  </button>
                  {expandedSections.includes('storage') && (
                    <div className="p-4 space-y-3 border-t border-gray-100">
                      {[
                        { label: locale === 'ar' ? 'عدد المواقع' : 'Websites', values: ['150', '200', '350'] },
                        { label: locale === 'ar' ? 'مساحة التخزين' : 'SSD Storage', values: ['70 GB', '150 GB', '250 GB'] },
                        { label: locale === 'ar' ? 'الذاكرة' : 'RAM', values: ['1.5 GB', '2 GB', '3 GB'] },
                        { label: locale === 'ar' ? 'نواة المعالج' : 'CPU', values: ['1.5', '1.5', '2'] },
                        { label: locale === 'ar' ? 'النطاق الترددي' : 'Bandwidth', values: ['∞', '∞', '∞'] },
                      ].map((row) => (
                        <div key={row.label} className="flex items-center justify-between py-2 border-b border-gray-50 last:border-0">
                          <span className="text-sm text-gray-600">{row.label}</span>
                          <div className="flex gap-2">
                            {row.values.map((val, i) => (
                              <span key={i} className={cn(
                                "text-xs font-semibold px-2 py-1 rounded-full min-w-12 text-center",
                                i === 0 && "bg-gray-100 text-gray-700",
                                i === 1 && "bg-[#1d71b8]/20 text-[#1d71b8]",
                                i === 2 && "bg-[#0f4c75]/20 text-[#0f4c75]"
                              )}>{val}</span>
                            ))}
                          </div>
                        </div>
                      ))}
                    </div>
                  )}
                </div>

                {/* Performance Section */}
                <div className="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                  <button 
                    onClick={() => toggleSection('performance')}
                    className="w-full py-4 px-5 bg-linear-to-r from-gray-50 to-white flex items-center justify-between"
                  >
                    <div className="flex items-center gap-2">
                      <Gauge className="h-5 w-5 text-[#1d71b8]" />
                      <span className="font-bold text-gray-800">{locale === 'ar' ? 'الأداء' : 'Performance'}</span>
                    </div>
                    <ChevronDown className={cn("h-5 w-5 text-gray-500 transition-transform", expandedSections.includes('performance') && "rotate-180")} />
                  </button>
                  {expandedSections.includes('performance') && (
                    <div className="p-4 space-y-3 border-t border-gray-100">
                      {[
                        { label: locale === 'ar' ? 'مستوى الأداء' : 'Performance', values: ['⚡ 2x', '⚡⚡ 5x', '🚀 10x'] },
                        { label: locale === 'ar' ? 'الزيارات الشهرية' : 'Monthly Visits', values: ['50K', '150K', '250K'] },
                        { label: 'LiteSpeed', values: ['✓', '✓', '✓'] },
                      ].map((row) => (
                        <div key={row.label} className="flex items-center justify-between py-2 border-b border-gray-50 last:border-0">
                          <span className="text-sm text-gray-600">{row.label}</span>
                          <div className="flex gap-2">
                            {row.values.map((val, i) => (
                              <span key={i} className={cn(
                                "text-xs font-semibold px-2 py-1 rounded-full min-w-12 text-center",
                                i === 0 && "bg-gray-100 text-gray-700",
                                i === 1 && "bg-[#1d71b8]/20 text-[#1d71b8]",
                                i === 2 && "bg-[#0f4c75]/20 text-[#0f4c75]"
                              )}>{val}</span>
                            ))}
                          </div>
                        </div>
                      ))}
                    </div>
                  )}
                </div>

                {/* Email Section */}
                <div className="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                  <button 
                    onClick={() => toggleSection('email')}
                    className="w-full py-4 px-5 bg-linear-to-r from-gray-50 to-white flex items-center justify-between"
                  >
                    <div className="flex items-center gap-2">
                      <Mail className="h-5 w-5 text-[#1d71b8]" />
                      <span className="font-bold text-gray-800">{locale === 'ar' ? 'البريد والدومين' : 'Email & Domains'}</span>
                    </div>
                    <ChevronDown className={cn("h-5 w-5 text-gray-500 transition-transform", expandedSections.includes('email') && "rotate-180")} />
                  </button>
                  {expandedSections.includes('email') && (
                    <div className="p-4 space-y-3 border-t border-gray-100">
                      {[
                        { label: locale === 'ar' ? 'صناديق البريد' : 'Mailboxes', values: ['150', '200', '350'] },
                        ...(billingPeriod === 'yearly' ? [{ label: locale === 'ar' ? '🎁 دومين مجاني' : '🎁 Free Domain', values: ['✓', '✓', '✓'], highlight: true }] : []),
                        { label: 'SSL', values: ['∞', '∞', '∞'] },
                      ].map((row) => (
                        <div key={row.label} className="flex items-center justify-between py-2 border-b border-gray-50 last:border-0">
                          <span className="text-sm text-gray-600">{row.label}</span>
                          <div className="flex gap-2">
                            {row.values.map((val, i) => (
                              <span key={i} className={cn(
                                "text-xs font-semibold px-2 py-1 rounded-full min-w-12 text-center",
                                i === 0 && "bg-gray-100 text-gray-700",
                                i === 1 && "bg-[#1d71b8]/20 text-[#1d71b8]",
                                i === 2 && "bg-[#0f4c75]/20 text-[#0f4c75]"
                              )}>{val}</span>
                            ))}
                          </div>
                        </div>
                      ))}
                    </div>
                  )}
                </div>

                {/* Features Section */}
                <div className="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                  <button 
                    onClick={() => toggleSection('features')}
                    className="w-full py-4 px-5 bg-linear-to-r from-gray-50 to-white flex items-center justify-between"
                  >
                    <div className="flex items-center gap-2">
                      <Sparkles className="h-5 w-5 text-[#1d71b8]" />
                      <span className="font-bold text-gray-800">{locale === 'ar' ? 'الميزات الإضافية' : 'Features'}</span>
                    </div>
                    <ChevronDown className={cn("h-5 w-5 text-gray-500 transition-transform", expandedSections.includes('features') && "rotate-180")} />
                  </button>
                  {expandedSections.includes('features') && (
                    <div className="p-4 space-y-3 border-t border-gray-100">
                      {[
                        { label: locale === 'ar' ? 'نسخ احتياطي' : 'Auto Backup', values: ['—', '✓', '✓'] },
                        { label: 'CDN', values: ['—', '✓', '✓'] },
                        { label: locale === 'ar' ? 'تخزين سحابي' : 'Cloud', values: ['—', '✓', '✓'] },
                        { label: locale === 'ar' ? 'IP مخصص' : 'Dedicated IP', values: ['—', '—', '✓'] },
                        { label: 'WordPress AI', values: ['—', '—', '✓'] },
                        { label: locale === 'ar' ? 'دعم أولوية' : 'Priority', values: ['—', '—', '✓'] },
                      ].map((row) => (
                        <div key={row.label} className="flex items-center justify-between py-2 border-b border-gray-50 last:border-0">
                          <span className="text-sm text-gray-600">{row.label}</span>
                          <div className="flex gap-2">
                            {row.values.map((val, i) => (
                              <span key={i} className={cn(
                                "text-xs font-semibold px-2 py-1 rounded-full min-w-12 text-center",
                                val === '—' ? "bg-gray-50 text-gray-400" : "",
                                val !== '—' && i === 0 && "bg-gray-100 text-gray-700",
                                val !== '—' && i === 1 && "bg-[#1d71b8]/20 text-[#1d71b8]",
                                val !== '—' && i === 2 && "bg-[#0f4c75]/20 text-[#0f4c75]"
                              )}>{val}</span>
                            ))}
                          </div>
                        </div>
                      ))}
                    </div>
                  )}
                </div>

                {/* Security Section */}
                <div className="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                  <button 
                    onClick={() => toggleSection('security')}
                    className="w-full py-4 px-5 bg-linear-to-r from-gray-50 to-white flex items-center justify-between"
                  >
                    <div className="flex items-center gap-2">
                      <Shield className="h-5 w-5 text-[#1d71b8]" />
                      <span className="font-bold text-gray-800">{locale === 'ar' ? 'الأمان' : 'Security'}</span>
                    </div>
                    <ChevronDown className={cn("h-5 w-5 text-gray-500 transition-transform", expandedSections.includes('security') && "rotate-180")} />
                  </button>
                  {expandedSections.includes('security') && (
                    <div className="p-4 space-y-3 border-t border-gray-100">
                      {[
                        { label: 'DDoS Protection', values: ['✓', '✓', '✓'] },
                        { label: 'WAF', values: ['✓', '✓', '✓'] },
                        { label: locale === 'ar' ? 'فاحص البرمجيات' : 'Malware Scan', values: ['✓', '✓', '✓'] },
                      ].map((row) => (
                        <div key={row.label} className="flex items-center justify-between py-2 border-b border-gray-50 last:border-0">
                          <span className="text-sm text-gray-600">{row.label}</span>
                          <div className="flex gap-2">
                            {row.values.map((val, i) => (
                              <span key={i} className={cn(
                                "text-xs font-semibold px-2 py-1 rounded-full min-w-12 text-center",
                                i === 0 && "bg-green-100 text-green-700",
                                i === 1 && "bg-green-100 text-green-700",
                                i === 2 && "bg-green-100 text-green-700"
                              )}>{val}</span>
                            ))}
                          </div>
                        </div>
                      ))}
                    </div>
                  )}
                </div>

                {/* Mobile CTA Buttons */}
                <div className="grid grid-cols-3 gap-3 pt-4">
                  <a
                    href={`https://app.progineous.com/cart.php?a=add&pid=73&billingcycle=${billingPeriod === 'yearly' ? 'annually' : 'monthly'}${billingPeriod === 'yearly' ? '&promocode=newgen80&addpromo=true' : ''}`}
                    target="_blank"
                    rel="noopener noreferrer"
                    className="py-3 px-2 text-center rounded-xl bg-gray-900 text-white text-sm font-semibold hover:bg-gray-800 transition-all"
                  >
                    Startup
                  </a>
                  <a
                    href={`https://app.progineous.com/cart.php?a=add&pid=74&billingcycle=${billingPeriod === 'yearly' ? 'annually' : 'monthly'}${billingPeriod === 'yearly' ? '&promocode=newgen75&addpromo=true' : ''}`}
                    target="_blank"
                    rel="noopener noreferrer"
                    className="py-3 px-2 text-center rounded-xl bg-linear-to-r from-[#1d71b8] to-[#0f4c75] text-white text-sm font-semibold shadow-lg shadow-[#1d71b8]/30 transition-all"
                  >
                    Essential
                  </a>
                  <a
                    href={`https://app.progineous.com/cart.php?a=add&pid=75&billingcycle=${billingPeriod === 'yearly' ? 'annually' : 'monthly'}${billingPeriod === 'yearly' ? '&promocode=newgen65&addpromo=true' : ''}`}
                    target="_blank"
                    rel="noopener noreferrer"
                    className="py-3 px-2 text-center rounded-xl bg-linear-to-r from-[#0f4c75] to-[#0a3a5c] text-white text-sm font-semibold transition-all"
                  >
                    Ultimate
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      {/* FAQ Section */}
      <section className="py-16 lg:py-24 bg-linear-to-b from-gray-50 to-white relative overflow-hidden">
        {/* Background decorations */}
        <div className="absolute inset-0 overflow-hidden pointer-events-none">
          <div className="absolute top-20 ltr:left-10 rtl:right-10 w-72 h-72 bg-[#1d71b8]/5 rounded-full blur-3xl" />
          <div className="absolute bottom-20 ltr:right-10 rtl:left-10 w-96 h-96 bg-cyan-500/5 rounded-full blur-3xl" />
        </div>

        <div className="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 relative z-10">
          {/* Header */}
          <div className="text-center mb-12">
            <span className="inline-flex items-center gap-2 rounded-full bg-[#1d71b8]/10 px-4 py-2 text-sm font-semibold text-[#1d71b8] mb-4">
              <Headphones className="h-4 w-4" />
              {locale === 'ar' ? 'مركز المساعدة' : 'Help Center'}
            </span>
            <h2 className="text-3xl font-bold text-gray-900 sm:text-4xl lg:text-5xl">
              {locale === 'ar' ? 'الأسئلة الشائعة' : 'Frequently Asked Questions'}
            </h2>
            <p className="mx-auto mt-4 max-w-2xl text-gray-600 text-lg">
              {locale === 'ar'
                ? 'إجابات على أكثر الأسئلة شيوعاً حول استضافتنا المشتركة'
                : 'Answers to the most common questions about our shared hosting'}
            </p>
          </div>

          {/* FAQ Items */}
          <div className="space-y-4">
            {faqs.map((faq, index) => (
              <div
                key={index}
                className={cn(
                  "group rounded-2xl border-2 transition-all duration-300",
                  openFaq === index 
                    ? "border-[#1d71b8] bg-white shadow-lg shadow-[#1d71b8]/10" 
                    : "border-gray-200 bg-white hover:border-gray-300 hover:shadow-md"
                )}
              >
                <button
                  onClick={() => setOpenFaq(openFaq === index ? null : index)}
                  className="flex w-full items-center justify-between px-6 py-5 text-start gap-4"
                >
                  <div className="flex items-center gap-4">
                    <div className={cn(
                      "shrink-0 w-10 h-10 rounded-xl flex items-center justify-center text-sm font-bold transition-colors",
                      openFaq === index 
                        ? "bg-[#1d71b8] text-white" 
                        : "bg-gray-100 text-gray-500 group-hover:bg-[#1d71b8]/10 group-hover:text-[#1d71b8]"
                    )}>
                      {String(index + 1).padStart(2, '0')}
                    </div>
                    <span className={cn(
                      "font-semibold text-lg transition-colors",
                      openFaq === index ? "text-[#1d71b8]" : "text-gray-900"
                    )}>
                      {faq.question}
                    </span>
                  </div>
                  <div className={cn(
                    "shrink-0 w-10 h-10 rounded-full flex items-center justify-center transition-all",
                    openFaq === index 
                      ? "bg-[#1d71b8] text-white rotate-180" 
                      : "bg-gray-100 text-gray-500 group-hover:bg-[#1d71b8]/10 group-hover:text-[#1d71b8]"
                  )}>
                    <ChevronDown className="h-5 w-5" />
                  </div>
                </button>
                <div className={cn(
                  "overflow-hidden transition-all duration-300",
                  openFaq === index ? "max-h-96" : "max-h-0"
                )}>
                  <div className="px-6 pb-6 ltr:pl-20 rtl:pr-20">
                    <div className="p-4 rounded-xl bg-linear-to-br from-gray-50 to-white border border-gray-100">
                      <p className="text-gray-600 leading-relaxed">{faq.answer}</p>
                    </div>
                  </div>
                </div>
              </div>
            ))}
          </div>

          {/* Bottom CTA */}
          <div className="mt-12 text-center">
            <p className="text-gray-600 mb-4">
              {locale === 'ar' ? 'لم تجد إجابة لسؤالك؟' : "Didn't find your answer?"}
            </p>
            <a
              href="/contact"
              className="inline-flex items-center gap-2 rounded-full bg-[#1d71b8] px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-[#1d71b8]/25 transition-all hover:bg-[#0f4c75] hover:shadow-xl hover:scale-105"
            >
              <Headphones className="h-4 w-4" />
              {locale === 'ar' ? 'تواصل مع الدعم' : 'Contact Support'}
              <ArrowRight className="h-4 w-4 rtl:rotate-180" />
            </a>
          </div>
        </div>
      </section>

      {/* CTA Section */}
      <section className="py-16 lg:py-24">
        <div className="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
          <div className="rounded-3xl bg-linear-to-br from-[#1d71b8] to-[#0f4c75] px-8 py-16 lg:py-20 text-center">
            {/* Main heading */}
            <h2 className="text-3xl font-bold text-white sm:text-4xl lg:text-5xl">
              {locale === 'ar' ? 'جاهز لبدء موقعك؟' : 'Ready to Start Your Website?'}
            </h2>

            <p className="mx-auto mt-4 max-w-xl text-lg text-white/70">
              {locale === 'ar'
                ? 'انضم إلى أكثر من 50,000 عميل سعيد اليوم'
                : 'Join over 50,000 happy customers today'}
            </p>

            {/* CTA Buttons */}
            <div className="mt-10 flex flex-col items-center justify-center gap-4 sm:flex-row">
              <a
                href="#pricing"
                className="inline-flex items-center gap-2 rounded-full bg-white px-8 py-4 text-base font-semibold text-[#1d71b8] transition-all hover:bg-white/90 hover:scale-105"
              >
                {locale === 'ar' ? 'ابدأ الآن بـ $1.99/شهر' : 'Start Now for $1.99/mo'}
                <ArrowRight className="h-5 w-5 rtl:rotate-180" />
              </a>
              <Link
                href="/contact"
                className="inline-flex items-center gap-2 rounded-full border border-white/30 px-8 py-4 text-base font-semibold text-white transition-all hover:bg-white/10"
              >
                {locale === 'ar' ? 'تحدث مع المبيعات' : 'Talk to Sales'}
              </Link>
            </div>
          </div>
        </div>
      </section>
    </div>
  );
}

