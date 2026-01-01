'use client';

import { useState } from 'react';
import { useTranslations } from 'next-intl';
import { Link } from '@/i18n/routing';
import { useParams } from 'next/navigation';
import Image from 'next/image';
import { 
  Mail, 
  MapPin, 
  Clock,
  Globe,
  Server,
  Shield,
  ChevronRight,
  ExternalLink,
  Heart,
  Loader2,
  CheckCircle,
  AlertCircle
} from 'lucide-react';

export function Footer() {
  const t = useTranslations('footer');
  const nav = useTranslations('nav');
  const params = useParams();
  const locale = (params?.locale as string) || 'en';
  const isRTL = locale === 'ar';

  // Newsletter state
  const [newsletterEmail, setNewsletterEmail] = useState('');
  const [newsletterLoading, setNewsletterLoading] = useState(false);
  const [newsletterSuccess, setNewsletterSuccess] = useState(false);
  const [newsletterError, setNewsletterError] = useState('');

  const handleNewsletterSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    setNewsletterLoading(true);
    setNewsletterError('');
    setNewsletterSuccess(false);

    try {
      const response = await fetch('/api/newsletter', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({ email: newsletterEmail, locale }),
      });

      const data = await response.json();

      if (response.ok && data.success) {
        setNewsletterSuccess(true);
        setNewsletterEmail('');
        // Reset success message after 5 seconds
        setTimeout(() => setNewsletterSuccess(false), 5000);
      } else {
        setNewsletterError(data.error || (isRTL ? 'حدث خطأ. حاول مرة أخرى.' : 'An error occurred. Please try again.'));
      }
    } catch {
      setNewsletterError(isRTL ? 'حدث خطأ. حاول مرة أخرى.' : 'An error occurred. Please try again.');
    } finally {
      setNewsletterLoading(false);
    }
  };

  const currentYear = new Date().getFullYear();

  const content = {
    en: {
      tagline: 'Professional hosting solutions since 2020. We provide reliable, fast, and secure web hosting services for businesses of all sizes.',
      sections: {
        hosting: 'Hosting',
        domains: 'Domains',
        market: 'Market',
        migrate: 'Migrate',
        company: 'Company',
        legal: 'Legal',
        support: 'Support',
        contact: 'Contact Us'
      },
      hosting: [
        { name: 'Shared Hosting', href: '/hosting/shared' },
        { name: 'Cloud Hosting', href: '/hosting/cloud' },
        { name: 'VPS Hosting', href: '/hosting/vps' },
        { name: 'Dedicated Servers', href: '/hosting/dedicated' },
        { name: 'Email Hosting', href: '/hosting/email' },
        { name: 'Reseller Hosting', href: '/hosting/reseller' },
        { name: 'Windows Reseller', href: '/hosting/windows-reseller' },
      ],
      domains: [
        { name: 'Register Domain', href: '/domains' },
        { name: 'Transfer Domain', href: '/domains/transfer' },
      ],
      market: [
        { name: 'SSL Certificates', href: '/market/ssl' },
        { name: 'Website Security', href: '/market/website-security' },
        { name: 'Website Backup', href: '/market/website-backup' },
        { name: 'VPN', href: '/market/vpn' },
        { name: 'Email Services', href: '/market/email-services' },
        { name: 'Website Builder', href: '/market/website-builder' },
        { name: 'SEO Tools', href: '/market/seo-tools' },
        { name: 'SocialBee', href: '/market/socialbee' },
        { name: 'XOVI NOW', href: '/market/xovi-now' },
      ],
      migrate: [
        { name: 'Migrate Hosting', href: '/migrate/hosting' },
        { name: 'Migrate Email', href: '/migrate/email' },
        { name: 'Transfer Domain', href: '/domains/transfer' },
      ],
      company: [
        { name: 'About Us', href: '/about' },
        { name: 'Contact Us', href: '/contact' },
        { name: 'Affiliate Program', href: '/affiliate' },
        { name: 'Refer a Friend', href: '/refer-friend' },
        { name: 'Compare Hosting', href: '/compare' },
      ],
      legal: [
        { name: 'Terms of Service', href: '/terms' },
        { name: 'Privacy Policy', href: '/privacy' },
        { name: 'Acceptable Use Policy', href: '/aup' },
        { name: 'DMCA Policy', href: '/dmca' },
        { name: 'Refund Policy', href: '/refund' },
      ],
      support: [
        { name: 'Help Center', href: 'https://app.progineous.com/knowledgebase', external: true },
        { name: 'Open Ticket', href: 'https://app.progineous.com/submitticket.php', external: true },
        { name: 'Server Status', href: '/status' },
        { name: 'Client Area', href: '/login' },
      ],
      contactInfo: {
        email: 'support@progineous.com',
        whatsapp: '+20 107 079 8859',
        address: '9 Mustafa Kamel St, Beni Suef, Egypt',
        hours: 'Sun - Thu: 9AM - 6PM'
      },
      newsletter: {
        title: 'Stay Updated',
        description: 'Subscribe to our newsletter for updates and exclusive offers.',
        placeholder: 'Enter your email',
        button: 'Subscribe'
      },
      payment: 'We Accept',
      followUs: 'Follow Us',
      copyright: `© ${currentYear} Pro Gineous. All rights reserved.`,
      madeWith: 'Made with',
      inEgypt: 'in Egypt',
      commercialRegister: 'Commercial Register: ',
      commercialRegisterNumber: '90088',
      taxNumber: 'Tax Number: ',
      taxNumberValue: '755-552-334'
    },
    ar: {
      tagline: 'حلول استضافة احترافية منذ 2020. نقدم خدمات استضافة ويب موثوقة وسريعة وآمنة للشركات من جميع الأحجام.',
      sections: {
        hosting: 'الاستضافة',
        domains: 'الدومينات',
        market: 'المتجر',
        migrate: 'النقل',
        company: 'الشركة',
        legal: 'قانوني',
        support: 'الدعم',
        contact: 'اتصل بنا'
      },
      hosting: [
        { name: 'استضافة مشتركة', href: '/hosting/shared' },
        { name: 'استضافة سحابية', href: '/hosting/cloud' },
        { name: 'سيرفرات VPS', href: '/hosting/vps' },
        { name: 'سيرفرات مخصصة', href: '/hosting/dedicated' },
        { name: 'استضافة البريد', href: '/hosting/email' },
        { name: 'استضافة الموزعين', href: '/hosting/reseller' },
        { name: 'موزعين ويندوز', href: '/hosting/windows-reseller' },
      ],
      domains: [
        { name: 'تسجيل دومين', href: '/domains' },
        { name: 'نقل دومين', href: '/domains/transfer' },
      ],
      market: [
        { name: 'شهادات SSL', href: '/market/ssl' },
        { name: 'حماية الموقع', href: '/market/website-security' },
        { name: 'نسخ احتياطي', href: '/market/website-backup' },
        { name: 'VPN', href: '/market/vpn' },
        { name: 'خدمات البريد', href: '/market/email-services' },
        { name: 'منشئ المواقع', href: '/market/website-builder' },
        { name: 'أدوات SEO', href: '/market/seo-tools' },
        { name: 'SocialBee', href: '/market/socialbee' },
        { name: 'XOVI NOW', href: '/market/xovi-now' },
      ],
      migrate: [
        { name: 'نقل الاستضافة', href: '/migrate/hosting' },
        { name: 'نقل البريد', href: '/migrate/email' },
        { name: 'نقل الدومين', href: '/domains/transfer' },
      ],
      company: [
        { name: 'من نحن', href: '/about' },
        { name: 'اتصل بنا', href: '/contact' },
        { name: 'برنامج الأفلييت', href: '/affiliate' },
        { name: 'دعوة صديق', href: '/refer-friend' },
        { name: 'مقارنة الاستضافات', href: '/compare' },
      ],
      legal: [
        { name: 'شروط الخدمة', href: '/terms' },
        { name: 'سياسة الخصوصية', href: '/privacy' },
        { name: 'سياسة الاستخدام المقبول', href: '/aup' },
        { name: 'سياسة DMCA', href: '/dmca' },
        { name: 'سياسة الاسترداد', href: '/refund' },
      ],
      support: [
        { name: 'مركز المساعدة', href: 'https://app.progineous.com/knowledgebase', external: true },
        { name: 'فتح تذكرة', href: 'https://app.progineous.com/submitticket.php', external: true },
        { name: 'حالة الخوادم', href: 'https://status.progineous.com', external: true },
        { name: 'منطقة العملاء', href: '/login' },
      ],
      contactInfo: {
        email: 'support@progineous.com',
        whatsapp: '+20 107 079 8859',
        address: '9 شارع مصطفى كامل، بني سويف، مصر',
        hours: 'الأحد - الخميس: 9ص - 6م'
      },
      newsletter: {
        title: 'ابق على اطلاع',
        description: 'اشترك في نشرتنا الإخبارية للحصول على التحديثات والعروض الحصرية.',
        placeholder: 'أدخل بريدك الإلكتروني',
        button: 'اشترك'
      },
      payment: 'نقبل الدفع عبر',
      followUs: 'تابعنا',
      copyright: `© ${currentYear} برو جينيوس. جميع الحقوق محفوظة.`,
      madeWith: 'صنع بـ',
      inEgypt: 'في مصر',
      commercialRegister: 'السجل التجاري: ',
      commercialRegisterNumber: '90088',
      taxNumber: 'الرقم الضريبي: ',
      taxNumberValue: '755-552-334'
    }
  };

  const c = content[locale as keyof typeof content] || content.en;

  const socialLinks = [
    { 
      name: 'Facebook', 
      href: 'https://facebook.com/progineous',
      icon: (
        <svg className="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
          <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
        </svg>
      )
    },
    { 
      name: 'Twitter', 
      href: 'https://twitter.com/progineous',
      icon: (
        <svg className="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
          <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
        </svg>
      )
    },
    { 
      name: 'LinkedIn', 
      href: 'https://linkedin.com/company/progineous',
      icon: (
        <svg className="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
          <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
        </svg>
      )
    },
    { 
      name: 'Instagram', 
      href: 'https://instagram.com/progineous',
      icon: (
        <svg className="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
          <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
        </svg>
      )
    },
    { 
      name: 'WhatsApp', 
      href: 'https://wa.me/201070798859',
      icon: (
        <svg className="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
          <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
        </svg>
      )
    },
  ];

  return (
    <footer className={`bg-gray-900 text-gray-300 overflow-hidden ${isRTL ? 'rtl' : 'ltr'}`} dir={isRTL ? 'rtl' : 'ltr'}>
      {/* Main Footer */}
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-12 lg:pt-16 pb-8">
        {/* Top Section - Logo & Newsletter */}
        <div className="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 pb-8 lg:pb-12 border-b border-gray-800">
          {/* Brand */}
          <div className="space-y-4 lg:space-y-6 text-center lg:text-start">
            <Link href="/" className="inline-flex items-center gap-3 justify-center lg:justify-start">
              <img src="/images/logos/pro Gineous_white logo.svg" alt="Pro Gineous" className="h-10 lg:h-12" />
            </Link>
            <p className="text-gray-400 max-w-md leading-relaxed mx-auto lg:mx-0 text-sm lg:text-base">
              {c.tagline}
            </p>
            {/* Social Links */}
            <div className="flex items-center gap-3 justify-center lg:justify-start">
              {socialLinks.map((social) => (
                <a
                  key={social.name}
                  href={social.href}
                  target="_blank"
                  rel="noopener noreferrer"
                  className="w-10 h-10 bg-gray-800 hover:bg-[#1d71b8] rounded-lg flex items-center justify-center transition-all duration-300 group"
                  aria-label={social.name}
                >
                  <span className="text-gray-400 group-hover:text-white transition-colors">
                    {social.icon}
                  </span>
                </a>
              ))}
            </div>
          </div>

          {/* Newsletter */}
          <div className="lg:justify-self-end w-full lg:max-w-md text-center lg:text-start">
            <h3 className="text-white font-semibold text-base lg:text-lg mb-2">{c.newsletter.title}</h3>
            <p className="text-gray-400 text-xs lg:text-sm mb-4">{c.newsletter.description}</p>
            
            {/* Success Message */}
            {newsletterSuccess && (
              <div className="mb-4 p-3 bg-green-500/10 border border-green-500/30 rounded-lg flex items-center gap-2">
                <CheckCircle className="w-5 h-5 text-green-500 shrink-0" />
                <p className="text-green-400 text-sm">
                  {isRTL ? 'تم الاشتراك بنجاح! تحقق من بريدك الإلكتروني.' : 'Successfully subscribed! Check your email.'}
                </p>
              </div>
            )}
            
            {/* Error Message */}
            {newsletterError && (
              <div className="mb-4 p-3 bg-red-500/10 border border-red-500/30 rounded-lg flex items-center gap-2">
                <AlertCircle className="w-5 h-5 text-red-500 shrink-0" />
                <p className="text-red-400 text-sm">{newsletterError}</p>
              </div>
            )}
            
            <form onSubmit={handleNewsletterSubmit} className="flex flex-col sm:flex-row gap-2">
              <input
                type="email"
                value={newsletterEmail}
                onChange={(e) => setNewsletterEmail(e.target.value)}
                placeholder={c.newsletter.placeholder}
                required
                disabled={newsletterLoading}
                className="w-full sm:flex-1 min-w-0 px-4 py-2.5 lg:py-3 bg-gray-800 border border-gray-700 rounded-lg focus:ring-2 focus:ring-[#1d71b8] focus:border-transparent outline-none text-white placeholder-gray-500 text-sm lg:text-base disabled:opacity-50"
              />
              <button
                type="submit"
                disabled={newsletterLoading}
                className="px-6 py-2.5 lg:py-3 bg-[#1d71b8] hover:bg-[#0d4a7a] text-white font-medium rounded-lg transition-colors whitespace-nowrap text-sm lg:text-base shrink-0 disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2"
              >
                {newsletterLoading ? (
                  <>
                    <Loader2 className="w-4 h-4 animate-spin" />
                    {isRTL ? 'جاري...' : 'Loading...'}
                  </>
                ) : (
                  c.newsletter.button
                )}
              </button>
            </form>
          </div>
        </div>

        {/* Links Grid */}
        <div className="py-8 lg:py-12 border-b border-gray-800">
          {/* Row 1: Services */}
          <div className="grid grid-cols-2 md:grid-cols-4 xl:grid-cols-4 gap-6 lg:gap-8 mb-8 lg:mb-10">
            {/* Hosting */}
            <div>
              <h4 className="text-white font-semibold mb-4">{c.sections.hosting}</h4>
              <ul className="space-y-3">
                {c.hosting.map((item) => (
                  <li key={item.href}>
                    <Link
                      href={item.href}
                      className="text-gray-400 hover:text-[#1d71b8] transition-colors flex items-center gap-2 text-sm"
                    >
                      <ChevronRight className="w-3 h-3" />
                      {item.name}
                    </Link>
                  </li>
                ))}
              </ul>
            </div>

            {/* Domains */}
            <div>
              <h4 className="text-white font-semibold mb-4">{c.sections.domains}</h4>
              <ul className="space-y-3">
                {c.domains.map((item) => (
                  <li key={item.href}>
                    <Link
                      href={item.href}
                      className="text-gray-400 hover:text-[#1d71b8] transition-colors flex items-center gap-2 text-sm"
                    >
                      <ChevronRight className="w-3 h-3" />
                      {item.name}
                    </Link>
                  </li>
                ))}
              </ul>
            </div>

            {/* Market */}
            <div>
              <h4 className="text-white font-semibold mb-4">{c.sections.market}</h4>
              <ul className="space-y-3">
                {c.market.map((item) => (
                  <li key={item.href}>
                    <Link
                      href={item.href}
                      className="text-gray-400 hover:text-[#1d71b8] transition-colors flex items-center gap-2 text-sm"
                    >
                      <ChevronRight className="w-3 h-3" />
                      {item.name}
                    </Link>
                  </li>
                ))}
              </ul>
            </div>

            {/* Migrate */}
            <div>
              <h4 className="text-white font-semibold mb-4">{c.sections.migrate}</h4>
              <ul className="space-y-3">
                {c.migrate.map((item) => (
                  <li key={item.href}>
                    <Link
                      href={item.href}
                      className="text-gray-400 hover:text-[#1d71b8] transition-colors flex items-center gap-2 text-sm"
                    >
                      <ChevronRight className="w-3 h-3" />
                      {item.name}
                    </Link>
                  </li>
                ))}
              </ul>
            </div>
          </div>

          {/* Row 2: Company Info */}
          <div className="grid grid-cols-2 md:grid-cols-4 xl:grid-cols-4 gap-6 lg:gap-8">
            {/* Company */}
            <div>
              <h4 className="text-white font-semibold mb-4">{c.sections.company}</h4>
              <ul className="space-y-3">
                {c.company.map((item) => (
                  <li key={item.href}>
                    <Link
                      href={item.href}
                      className="text-gray-400 hover:text-[#1d71b8] transition-colors flex items-center gap-2 text-sm"
                    >
                      <ChevronRight className="w-3 h-3" />
                      {item.name}
                    </Link>
                  </li>
                ))}
              </ul>
            </div>

            {/* Legal */}
            <div>
              <h4 className="text-white font-semibold mb-4">{c.sections.legal}</h4>
              <ul className="space-y-3">
                {c.legal.map((item) => (
                  <li key={item.href}>
                    <Link
                      href={item.href}
                      className="text-gray-400 hover:text-[#1d71b8] transition-colors flex items-center gap-2 text-sm"
                    >
                      <ChevronRight className="w-3 h-3" />
                      {item.name}
                    </Link>
                  </li>
                ))}
              </ul>
            </div>

            {/* Support */}
            <div>
              <h4 className="text-white font-semibold mb-4">{c.sections.support}</h4>
              <ul className="space-y-3">
                {c.support.map((item) => (
                  <li key={item.href}>
                    {item.external ? (
                      <a
                        href={item.href}
                        target="_blank"
                        rel="noopener noreferrer"
                        className="text-gray-400 hover:text-[#1d71b8] transition-colors flex items-center gap-2 text-sm"
                      >
                        <ExternalLink className="w-3 h-3" />
                        {item.name}
                      </a>
                    ) : (
                      <Link
                        href={item.href}
                        className="text-gray-400 hover:text-[#1d71b8] transition-colors flex items-center gap-2 text-sm"
                      >
                        <ChevronRight className="w-3 h-3" />
                        {item.name}
                      </Link>
                    )}
                  </li>
                ))}
              </ul>
            </div>

            {/* Contact */}
            <div className="min-w-0">
              <h4 className="text-white font-semibold mb-4">{c.sections.contact}</h4>
              <ul className="space-y-4">
                <li>
                  <a href={`mailto:${c.contactInfo.email}`} className="flex items-start gap-3 text-gray-400 hover:text-[#1d71b8] transition-colors">
                    <Mail className="w-4 h-4 mt-0.5 shrink-0" />
                    <span className="text-sm break-all">{c.contactInfo.email}</span>
                  </a>
                </li>
                <li>
                  <a href="https://wa.me/201070798859" target="_blank" rel="noopener noreferrer" className="flex items-start gap-3 text-gray-400 hover:text-green-500 transition-colors">
                    <svg className="w-4 h-4 mt-0.5 shrink-0" fill="currentColor" viewBox="0 0 24 24">
                      <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                    </svg>
                    <span dir="ltr" className="text-sm">{c.contactInfo.whatsapp}</span>
                  </a>
                </li>
                <li className="flex items-start gap-3 text-gray-400">
                  <MapPin className="w-4 h-4 mt-0.5 shrink-0" />
                  <span className="text-sm">{c.contactInfo.address}</span>
                </li>
                <li className="flex items-start gap-3 text-gray-400">
                  <Clock className="w-4 h-4 mt-0.5 shrink-0" />
                  <span className="text-sm">{c.contactInfo.hours}</span>
                </li>
              </ul>
            </div>
          </div>
        </div>

        {/* Payment Methods & Legal Info */}
        <div className="py-6 lg:py-8 border-b border-gray-800">
          <div className="flex flex-col gap-4 lg:gap-6">
            {/* Payment Methods */}
            <div className="flex flex-col items-center gap-3 lg:gap-4">
              <span className="text-gray-500 text-xs lg:text-sm">{c.payment}:</span>
              <div className="grid grid-cols-3 sm:grid-cols-6 items-center justify-center gap-2 lg:gap-3 w-full max-w-lg">
                <Image src="/images/payments/images.png" alt="Visa" width={100} height={60} quality={100} className="h-6 lg:h-8 w-auto object-contain bg-white rounded px-1.5 lg:px-2 py-0.5 lg:py-1 mx-auto" />
                <Image src="/images/payments/images (1).png" alt="Mastercard" width={100} height={60} quality={100} className="h-6 lg:h-8 w-auto object-contain bg-white rounded px-1.5 lg:px-2 py-0.5 lg:py-1 mx-auto" />
                <Image src="/images/payments/PayPal.svg.png" alt="PayPal" width={120} height={60} quality={100} className="h-6 lg:h-8 w-auto object-contain bg-white rounded px-1.5 lg:px-2 py-0.5 lg:py-1 mx-auto" />
                <Image src="/images/payments/fawry.png" alt="Fawry" width={120} height={60} quality={100} className="h-6 lg:h-8 w-auto object-contain bg-white rounded px-1.5 lg:px-2 py-0.5 lg:py-1 mx-auto" />
                <Image src="/images/payments/basata.png" alt="Basata" width={120} height={60} quality={100} className="h-6 lg:h-8 w-auto object-contain bg-white rounded px-1.5 lg:px-2 py-0.5 lg:py-1 mx-auto" />
                <Image src="/images/payments/pay5.png" alt="Payment Method" width={120} height={60} quality={100} className="h-6 lg:h-8 w-auto object-contain bg-white rounded px-1.5 lg:px-2 py-0.5 lg:py-1 mx-auto" />
              </div>
            </div>

            {/* Company Info */}
            <div className="flex flex-col sm:flex-row flex-wrap items-center justify-center gap-2 lg:gap-4 text-[10px] lg:text-xs text-gray-500 text-center">
              <span>{c.commercialRegister}<span dir="ltr">{c.commercialRegisterNumber}</span></span>
              <span className="hidden sm:inline">|</span>
              <span>{c.taxNumber}<span dir="ltr">{c.taxNumberValue}</span></span>
            </div>
          </div>
        </div>

        {/* Bottom Bar */}
        <div className="pt-6 lg:pt-8">
          <div className="flex flex-col md:flex-row justify-between items-center gap-3 lg:gap-4">
            <p className="text-gray-500 text-xs lg:text-sm text-center md:text-start">
              {c.copyright}
            </p>
            <p className="text-gray-500 text-xs lg:text-sm flex items-center gap-1">
              {c.madeWith} <Heart className="w-3 h-3 lg:w-4 lg:h-4 text-red-500 fill-red-500" /> {c.inEgypt}
            </p>
          </div>
        </div>
      </div>
    </footer>
  );
}
