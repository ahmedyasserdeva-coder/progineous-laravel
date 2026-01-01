'use client';

import { useState } from 'react';
import { useTranslations, useLocale } from 'next-intl';
import { Link, usePathname, useRouter } from '@/i18n/routing';
import { localeNames, type Locale } from '@/i18n/config';
import { cn } from '@/lib/utils';
import { useTLDPricing } from '@/hooks/useTLDPricing';
import {
  Menu,
  X,
  Globe,
  ChevronDown,
  Server,
  Globe2,
  Headphones,
  LogIn,
  UserPlus,
  Cloud,
  HardDrive,
  Database,
  Mail,
  Sparkles,
  ArrowRight,
  Monitor,
  Search,
  RefreshCw,
  Shield,
  CheckCircle,
  ShoppingBag,
  Lock,
  Inbox,
  BarChart3,
  Palette,
  ShieldCheck,
  FolderArchive,
  TrendingUp,
  Wifi,
  Share2,
  ArrowRightLeft,
  ServerCog,
  MailPlus,
  Globe as GlobeTransfer
} from 'lucide-react';

export function Navbar() {
  const t = useTranslations('nav');
  const locale = useLocale() as Locale;
  const pathname = usePathname();
  const router = useRouter();
  const [isOpen, setIsOpen] = useState(false);
  const [langOpen, setLangOpen] = useState(false);
  const [hostingOpen, setHostingOpen] = useState(false);
  const [domainsOpen, setDomainsOpen] = useState(false);
  const [marketOpen, setMarketOpen] = useState(false);
  const [migrateOpen, setMigrateOpen] = useState(false);
  
  // Mobile accordion states
  const [mobileDomainsOpen, setMobileDomainsOpen] = useState(false);
  const [mobileHostingOpen, setMobileHostingOpen] = useState(false);
  const [mobileMarketOpen, setMobileMarketOpen] = useState(false);
  const [mobileMigrateOpen, setMobileMigrateOpen] = useState(false);
  
  // Fetch TLD prices from WHMCS API
  const { prices: tldPrices, loading: tldLoading } = useTLDPricing();

  const navItems = [
    { href: '/', label: t('home'), icon: null },
    { href: '/domains', label: t('domains'), icon: Globe2 }
  ];

  const migrateItems = [
    { 
      href: '/migrate/hosting', 
      label: locale === 'ar' ? 'نقل الاستضافة' : 'Migrate Hosting', 
      icon: ServerCog,
      description: locale === 'ar' ? 'انقل موقعك إلينا مجاناً' : 'Move your website to us for free'
    },
    { 
      href: '/migrate/email', 
      label: locale === 'ar' ? 'نقل البريد الإلكتروني' : 'Migrate Email', 
      icon: MailPlus,
      description: locale === 'ar' ? 'انقل بريدك بدون فقدان البيانات' : 'Transfer your emails without data loss'
    },
    { 
      href: '/domains/transfer', 
      label: locale === 'ar' ? 'نقل الدومين' : 'Transfer Domain', 
      icon: GlobeTransfer,
      description: locale === 'ar' ? 'انقل نطاقك إلينا بسهولة' : 'Transfer your domain to us easily'
    },
  ];

  const hostingItems = [
    { href: '/hosting/shared', label: locale === 'ar' ? 'استضافة مشتركة' : 'Shared Hosting', icon: Server },
    { href: '/hosting/cloud', label: locale === 'ar' ? 'استضافة سحابية' : 'Cloud Hosting', icon: Cloud },
    { href: '/hosting/vps', label: locale === 'ar' ? 'سيرفرات VPS' : 'VPS Hosting', icon: HardDrive },
    { href: '/hosting/dedicated', label: locale === 'ar' ? 'سيرفرات مخصصة' : 'Dedicated Hosting', icon: Database },
    { href: '/hosting/email', label: locale === 'ar' ? 'استضافة البريد' : 'Email Hosting', icon: Mail },
  ];

  const switchLocale = (newLocale: Locale) => {
    router.replace(pathname, { locale: newLocale });
    setLangOpen(false);
  };

  // Close all mega menus when clicking a link
  const closeAllMenus = () => {
    setHostingOpen(false);
    setDomainsOpen(false);
    setMarketOpen(false);
    setMigrateOpen(false);
  };

  return (
    <nav 
      className={cn(
        "sticky top-0 z-50 border-b border-gray-200",
        isOpen 
          ? "bg-white" 
          : "bg-white/80 backdrop-blur-md"
      )}
      onMouseLeave={() => { setHostingOpen(false); setDomainsOpen(false); setMarketOpen(false); setMigrateOpen(false); }}
    >
      <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div className="flex h-16 items-center justify-between">
          {/* Logo */}
          <Link href="/" className="flex items-center gap-2">
            <img src="/pro Gineous_logo.svg" alt="Pro Gineous" className="h-10 w-auto" />
          </Link>

          {/* Desktop Navigation */}
          <div className="hidden items-center gap-1 lg:flex">
            {/* Home Link */}
            <Link
              href="/"
              onMouseEnter={() => { setHostingOpen(false); setDomainsOpen(false); setMarketOpen(false); setMigrateOpen(false); }}
              className={cn(
                'flex items-center gap-2 rounded-lg px-4 py-2 text-sm font-medium transition-colors',
                pathname === '/'
                  ? 'bg-blue-50 text-blue-600'
                  : 'text-gray-600 hover:bg-gray-100'
              )}
            >
              {t('home')}
            </Link>

            {/* Domains Mega Menu Trigger */}
            <button
              onMouseEnter={() => { setDomainsOpen(true); setHostingOpen(false); setMarketOpen(false); setMigrateOpen(false); }}
              className={cn(
                'flex items-center gap-2 rounded-lg px-4 py-2 text-sm font-medium transition-colors',
                pathname.startsWith('/domains') || domainsOpen
                  ? 'bg-blue-50 text-blue-600'
                  : 'text-gray-600 hover:bg-gray-100'
              )}
            >
              <Globe2 className="h-4 w-4" />
              {t('domains')}
              <ChevronDown className={cn('h-3 w-3 transition-transform duration-200', domainsOpen && 'rotate-180')} />
            </button>

            {/* Domains Mega Menu */}
            {domainsOpen && (
              <div 
                className="absolute inset-x-0 top-full z-[60] pt-0"
                onMouseEnter={() => setDomainsOpen(true)}
                onMouseLeave={() => setDomainsOpen(false)}
              >
                <div className="h-2" />
                <div className="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
                  <div className="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-2xl">
                    <div className="grid grid-cols-12 gap-0">
                      {/* Left Section - Domain Services */}
                      <div className="col-span-7 p-6">
                        <h3 className="text-xs font-bold uppercase tracking-wider text-gray-400 mb-4">
                          {locale === 'ar' ? 'خدمات الدومين' : 'Domain Services'}
                        </h3>
                        <div className="space-y-1">
                          <Link
                            href="/domains"
                            onClick={closeAllMenus}
                            className="group flex items-start gap-4 rounded-xl p-3 transition-colors hover:bg-gray-50"
                          >
                            <div className="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-blue-100 text-[#1d71b8] group-hover:bg-[#1d71b8] group-hover:text-white transition-colors">
                              <Search className="h-5 w-5" />
                            </div>
                            <div>
                              <div className="font-semibold text-gray-900">
                                {locale === 'ar' ? 'تسجيل دومين جديد' : 'Register New Domain'}
                              </div>
                              <p className="mt-0.5 text-xs text-gray-500">
                                {locale === 'ar' ? 'ابحث وسجل دومينك المثالي' : 'Search & register your perfect domain'}
                              </p>
                              <span className="mt-1 inline-block text-xs font-semibold text-[#1d71b8]">
                                {locale === 'ar' ? 'يبدأ من $1.99/سنة' : 'From $1.99/yr'}
                              </span>
                            </div>
                          </Link>

                          <Link
                            href="/domains/transfer"
                            onClick={closeAllMenus}
                            className="group flex items-start gap-4 rounded-xl p-3 transition-colors hover:bg-gray-50"
                          >
                            <div className="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-green-100 text-green-600 group-hover:bg-green-600 group-hover:text-white transition-colors">
                              <RefreshCw className="h-5 w-5" />
                            </div>
                            <div>
                              <div className="font-semibold text-gray-900">
                                {locale === 'ar' ? 'نقل دومين' : 'Transfer Domain'}
                              </div>
                              <p className="mt-0.5 text-xs text-gray-500">
                                {locale === 'ar' ? 'انقل دومينك إلينا بسهولة' : 'Easily transfer your domain to us'}
                              </p>
                              <span className="mt-1 inline-block text-xs font-semibold text-green-600">
                                {locale === 'ar' ? 'نقل مجاني + سنة إضافية' : 'Free transfer + 1 year extension'}
                              </span>
                            </div>
                          </Link>
                        </div>
                      </div>

                      {/* Right Section - Featured */}
                      <div className="col-span-5 bg-gradient-to-br from-[#1d71b8] to-[#0f4c75] p-6 text-white">
                        <div className="flex h-full flex-col">
                          <span className="inline-flex w-fit items-center gap-1.5 rounded-full bg-white/20 px-3 py-1 text-xs font-semibold backdrop-blur-sm">
                            <Globe2 className="h-3 w-3" />
                            {locale === 'ar' ? 'دومينات مميزة' : 'Popular TLDs'}
                          </span>
                          <div className="mt-4 space-y-2">
                            {tldPrices.map((price) => (
                              <div key={price.tld} className="flex items-center justify-between text-sm">
                                <span>{price.tld}</span>
                                <span className="font-bold">{price.register}/yr</span>
                              </div>
                            ))}
                            {tldLoading && (
                              <div className="text-xs text-white/60">
                                {locale === 'ar' ? 'جاري تحميل الأسعار...' : 'Loading prices...'}
                              </div>
                            )}
                          </div>
                          <Link
                            href="/domains"
                            onClick={closeAllMenus}
                            className="mt-auto inline-flex items-center justify-center gap-2 rounded-lg bg-white px-4 py-2.5 text-sm font-semibold text-[#1d71b8] transition-all hover:bg-white/90"
                          >
                            {locale === 'ar' ? 'ابحث الآن' : 'Search Now'}
                            <ArrowRight className="h-4 w-4 rtl:rotate-180" />
                          </Link>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            )}

            {/* Hosting Mega Menu Trigger */}
            <button
              onMouseEnter={() => { setHostingOpen(true); setDomainsOpen(false); setMarketOpen(false); setMigrateOpen(false); }}
              className={cn(
                'flex items-center gap-2 rounded-lg px-4 py-2 text-sm font-medium transition-colors',
                pathname.startsWith('/hosting') || hostingOpen
                  ? 'bg-blue-50 text-blue-600'
                  : 'text-gray-600 hover:bg-gray-100'
              )}
            >
              <Server className="h-4 w-4" />
              {t('hosting')}
              <ChevronDown className={cn('h-3 w-3 transition-transform duration-200', hostingOpen && 'rotate-180')} />
            </button>
              
              {/* Mega Menu */}
              {hostingOpen && (
                <div 
                  className="absolute inset-x-0 top-full z-[60] pt-0"
                  onMouseEnter={() => setHostingOpen(true)}
                  onMouseLeave={() => setHostingOpen(false)}
                >
                  {/* Invisible bridge to prevent menu from closing */}
                  <div className="h-2" />
                  <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div className="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-2xl">
                      <div className="grid grid-cols-12 gap-0">
                        {/* Left Section - Hosting Types */}
                        <div className="col-span-8 grid grid-cols-2 gap-0 p-6">
                          {/* Web Hosting */}
                          <div className="space-y-4 pe-6">
                            <h3 className="text-xs font-bold uppercase tracking-wider text-gray-400">
                              {locale === 'ar' ? 'استضافة الويب' : 'Web Hosting'}
                            </h3>
                            <div className="space-y-1">
                              <Link
                                href="/hosting/shared"
                                onClick={closeAllMenus}
                                className="group flex items-start gap-4 rounded-xl p-3 transition-colors hover:bg-gray-50"
                              >
                                <div className="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-blue-100 text-[#1d71b8] group-hover:bg-[#1d71b8] group-hover:text-white transition-colors">
                                  <Server className="h-5 w-5" />
                                </div>
                                <div>
                                  <div className="font-semibold text-gray-900">
                                    {locale === 'ar' ? 'استضافة مشتركة' : 'Shared Hosting'}
                                  </div>
                                  <p className="mt-0.5 text-xs text-gray-500">
                                    {locale === 'ar' ? 'مثالية للمواقع الصغيرة والمدونات' : 'Perfect for small websites & blogs'}
                                  </p>
                                  <span className="mt-1 inline-block text-xs font-semibold text-[#1d71b8]">
                                    {locale === 'ar' ? 'يبدأ من $2/شهر' : 'From $2/mo'}
                                  </span>
                                </div>
                              </Link>

                              <Link
                                href="/hosting/cloud"
                                onClick={closeAllMenus}
                                className="group flex items-start gap-4 rounded-xl p-3 transition-colors hover:bg-gray-50"
                              >
                                <div className="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-purple-100 text-purple-600 group-hover:bg-purple-600 group-hover:text-white transition-colors">
                                  <Cloud className="h-5 w-5" />
                                </div>
                                <div>
                                  <div className="font-semibold text-gray-900">
                                    {locale === 'ar' ? 'استضافة سحابية' : 'Cloud Hosting'}
                                  </div>
                                  <p className="mt-0.5 text-xs text-gray-500">
                                    {locale === 'ar' ? 'قابلية توسع وأداء عالي' : 'Scalable & high performance'}
                                  </p>
                                  <span className="mt-1 inline-block text-xs font-semibold text-purple-600">
                                    {locale === 'ar' ? 'يبدأ من $6/شهر' : 'From $6/mo'}
                                  </span>
                                </div>
                              </Link>

                              <Link
                                href="/hosting/reseller"
                                onClick={closeAllMenus}
                                className="group flex items-start gap-4 rounded-xl p-3 transition-colors hover:bg-gray-50"
                              >
                                <div className="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-cyan-100 text-cyan-600 group-hover:bg-cyan-600 group-hover:text-white transition-colors">
                                  <Globe2 className="h-5 w-5" />
                                </div>
                                <div>
                                  <div className="font-semibold text-gray-900">
                                    {locale === 'ar' ? 'استضافة الموزعين' : 'Reseller Hosting'}
                                  </div>
                                  <p className="mt-0.5 text-xs text-gray-500">
                                    {locale === 'ar' ? 'ابدأ عملك في الاستضافة' : 'Start your hosting business'}
                                  </p>
                                  <span className="mt-1 inline-block text-xs font-semibold text-cyan-600">
                                    {locale === 'ar' ? 'يبدأ من $20/شهر' : 'From $20/mo'}
                                  </span>
                                </div>
                              </Link>

                              <Link
                                href="/hosting/windows-reseller"
                                onClick={closeAllMenus}
                                className="group flex items-start gap-4 rounded-xl p-3 transition-colors hover:bg-gray-50"
                              >
                                <div className="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-blue-100 text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                                  <Monitor className="h-5 w-5" />
                                </div>
                                <div>
                                  <div className="font-semibold text-gray-900">
                                    {locale === 'ar' ? 'موزعين ويندوز' : 'Windows Reseller'}
                                  </div>
                                  <p className="mt-0.5 text-xs text-gray-500">
                                    {locale === 'ar' ? 'استضافة موزعين على ويندوز' : 'Windows reseller hosting'}
                                  </p>
                                  <span className="mt-1 inline-block text-xs font-semibold text-blue-600">
                                    {locale === 'ar' ? 'يبدأ من $40/شهر' : 'From $40/mo'}
                                  </span>
                                </div>
                              </Link>
                            </div>
                          </div>

                          {/* Servers */}
                          <div className="space-y-4 border-s border-gray-100 ps-6">
                            <h3 className="text-xs font-bold uppercase tracking-wider text-gray-400">
                              {locale === 'ar' ? 'السيرفرات' : 'Servers'}
                            </h3>
                            <div className="space-y-1">
                              <Link
                                href="/hosting/vps"
                                onClick={closeAllMenus}
                                className="group flex items-start gap-4 rounded-xl p-3 transition-colors hover:bg-gray-50"
                              >
                                <div className="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-orange-100 text-orange-600 group-hover:bg-orange-600 group-hover:text-white transition-colors">
                                  <HardDrive className="h-5 w-5" />
                                </div>
                                <div>
                                  <div className="font-semibold text-gray-900">
                                    {locale === 'ar' ? 'سيرفرات VPS' : 'VPS Hosting'}
                                  </div>
                                  <p className="mt-0.5 text-xs text-gray-500">
                                    {locale === 'ar' ? 'تحكم كامل وموارد مخصصة' : 'Full control & dedicated resources'}
                                  </p>
                                  <span className="mt-1 inline-block text-xs font-semibold text-orange-600">
                                    {locale === 'ar' ? 'يبدأ من $15/شهر' : 'From $15/mo'}
                                  </span>
                                </div>
                              </Link>

                              <Link
                                href="/hosting/dedicated"
                                onClick={closeAllMenus}
                                className="group flex items-start gap-4 rounded-xl p-3 transition-colors hover:bg-gray-50"
                              >
                                <div className="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-red-100 text-red-600 group-hover:bg-red-600 group-hover:text-white transition-colors">
                                  <Database className="h-5 w-5" />
                                </div>
                                <div>
                                  <div className="font-semibold text-gray-900">
                                    {locale === 'ar' ? 'سيرفرات مخصصة' : 'Dedicated Servers'}
                                  </div>
                                  <p className="mt-0.5 text-xs text-gray-500">
                                    {locale === 'ar' ? 'أقصى قوة وأمان' : 'Maximum power & security'}
                                  </p>
                                  <span className="mt-1 inline-block text-xs font-semibold text-red-600">
                                    {locale === 'ar' ? 'يبدأ من $140/شهر' : 'From $140/mo'}
                                  </span>
                                </div>
                              </Link>

                              <Link
                                href="/hosting/email"
                                onClick={closeAllMenus}
                                className="group flex items-start gap-4 rounded-xl p-3 transition-colors hover:bg-gray-50"
                              >
                                <div className="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-green-100 text-green-600 group-hover:bg-green-600 group-hover:text-white transition-colors">
                                  <Mail className="h-5 w-5" />
                                </div>
                                <div>
                                  <div className="font-semibold text-gray-900">
                                    {locale === 'ar' ? 'استضافة البريد' : 'Email Hosting'}
                                  </div>
                                  <p className="mt-0.5 text-xs text-gray-500">
                                    {locale === 'ar' ? 'بريد احترافي لعملك' : 'Professional email for business'}
                                  </p>
                                  <span className="mt-1 inline-block text-xs font-semibold text-green-600">
                                    {locale === 'ar' ? 'يبدأ من $1.99/شهر' : 'From $1.99/mo'}
                                  </span>
                                </div>
                              </Link>
                            </div>
                          </div>
                        </div>

                        {/* Right Section - Featured */}
                        <div className="col-span-4 bg-gradient-to-br from-[#1d71b8] to-[#0f4c75] p-6 text-white">
                          <div className="flex h-full flex-col">
                            <span className="inline-flex w-fit items-center gap-1.5 rounded-full bg-white/20 px-3 py-1 text-xs font-semibold backdrop-blur-sm">
                              <Sparkles className="h-3 w-3" />
                              {locale === 'ar' ? 'عرض خاص' : 'Special Offer'}
                            </span>
                            <h4 className="mt-4 text-xl font-bold">
                              {locale === 'ar' ? 'استضافة سحابية بأداء عالي!' : 'High-Performance Cloud Hosting!'}
                            </h4>
                            <p className="mt-2 text-sm text-white/80">
                              {locale === 'ar' 
                                ? 'احصل على استضافة سريعة وآمنة مع دومين مجاني وشهادة SSL.'
                                : 'Get fast & secure hosting with free domain and SSL certificate.'}
                            </p>
                            <div className="mt-4 flex items-baseline gap-2">
                              <span className="text-3xl font-bold">$6</span>
                              <span className="text-sm text-white/70">/{locale === 'ar' ? 'شهر' : 'mo'}</span>
                            </div>
                            <Link
                              href="/hosting/cloud"
                              onClick={closeAllMenus}
                              className="mt-auto inline-flex items-center justify-center gap-2 rounded-lg bg-white px-4 py-2.5 text-sm font-semibold text-[#1d71b8] transition-all hover:bg-white/90"
                            >
                              {locale === 'ar' ? 'ابدأ الآن' : 'Get Started'}
                              <ArrowRight className="h-4 w-4 rtl:rotate-180" />
                            </Link>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              )}

            {/* Market Mega Menu Trigger */}
            <button
              onMouseEnter={() => { setMarketOpen(true); setHostingOpen(false); setDomainsOpen(false); setMigrateOpen(false); }}
              className={cn(
                'flex items-center gap-2 rounded-lg px-4 py-2 text-sm font-medium transition-colors',
                pathname.startsWith('/market') || marketOpen
                  ? 'bg-blue-50 text-blue-600'
                  : 'text-gray-600 hover:bg-gray-100'
              )}
            >
              <ShoppingBag className="h-4 w-4" />
              {locale === 'ar' ? 'المتجر' : 'Market'}
              <ChevronDown className={cn('h-3 w-3 transition-transform duration-200', marketOpen && 'rotate-180')} />
            </button>

            {/* Market Mega Menu */}
            {marketOpen && (
              <div 
                className="absolute inset-x-0 top-full z-[60] pt-0"
                onMouseEnter={() => setMarketOpen(true)}
                onMouseLeave={() => setMarketOpen(false)}
              >
                <div className="h-2" />
                <div className="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
                  <div className="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-2xl">
                    <div className="grid grid-cols-12 gap-0">
                      {/* Left Section - Market Services */}
                      <div className="col-span-8 grid grid-cols-2 gap-0 p-6">
                        {/* Security & SSL */}
                        <div className="space-y-4 pe-6">
                          <h3 className="text-xs font-bold uppercase tracking-wider text-gray-400">
                            {locale === 'ar' ? 'الأمان والحماية' : 'Security & Protection'}
                          </h3>
                          <div className="space-y-1">
                            <Link
                              href="/market/ssl"
                              onClick={closeAllMenus}
                              className="group flex items-start gap-4 rounded-xl p-3 transition-colors hover:bg-gray-50"
                            >
                              <div className="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-green-100 text-green-600 group-hover:bg-green-600 group-hover:text-white transition-colors">
                                <Lock className="h-5 w-5" />
                              </div>
                              <div>
                                <div className="font-semibold text-gray-900">
                                  {locale === 'ar' ? 'شهادات SSL' : 'SSL Certificates'}
                                </div>
                                <p className="mt-0.5 text-xs text-gray-500">
                                  {locale === 'ar' ? 'تأمين موقعك بشهادة SSL' : 'Secure your website with SSL'}
                                </p>
                              </div>
                            </Link>

                            <Link
                              href="/market/website-security"
                              onClick={closeAllMenus}
                              className="group flex items-start gap-4 rounded-xl p-3 transition-colors hover:bg-gray-50"
                            >
                              <div className="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-red-100 text-red-600 group-hover:bg-red-600 group-hover:text-white transition-colors">
                                <ShieldCheck className="h-5 w-5" />
                              </div>
                              <div>
                                <div className="font-semibold text-gray-900">
                                  {locale === 'ar' ? 'حماية الموقع' : 'Website Security'}
                                </div>
                                <p className="mt-0.5 text-xs text-gray-500">
                                  {locale === 'ar' ? 'حماية متقدمة ضد الهجمات' : 'Advanced protection against attacks'}
                                </p>
                              </div>
                            </Link>

                            <Link
                              href="/market/website-backup"
                              onClick={closeAllMenus}
                              className="group flex items-start gap-4 rounded-xl p-3 transition-colors hover:bg-gray-50"
                            >
                              <div className="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-blue-100 text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                                <FolderArchive className="h-5 w-5" />
                              </div>
                              <div>
                                <div className="font-semibold text-gray-900">
                                  {locale === 'ar' ? 'نسخ احتياطي' : 'Website Backup'}
                                </div>
                                <p className="mt-0.5 text-xs text-gray-500">
                                  {locale === 'ar' ? 'نسخ احتياطي تلقائي لموقعك' : 'Automatic backup for your site'}
                                </p>
                              </div>
                            </Link>

                            <Link
                              href="/market/vpn"
                              onClick={closeAllMenus}
                              className="group flex items-start gap-4 rounded-xl p-3 transition-colors hover:bg-gray-50"
                            >
                              <div className="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-purple-100 text-purple-600 group-hover:bg-purple-600 group-hover:text-white transition-colors">
                                <Wifi className="h-5 w-5" />
                              </div>
                              <div>
                                <div className="font-semibold text-gray-900">VPN</div>
                                <p className="mt-0.5 text-xs text-gray-500">
                                  {locale === 'ar' ? 'اتصال آمن ومشفر' : 'Secure encrypted connection'}
                                </p>
                              </div>
                            </Link>
                          </div>
                        </div>

                        {/* Tools & Services */}
                        <div className="space-y-4 ps-6 border-s border-gray-100">
                          <h3 className="text-xs font-bold uppercase tracking-wider text-gray-400">
                            {locale === 'ar' ? 'أدوات وخدمات' : 'Tools & Services'}
                          </h3>
                          <div className="space-y-1">
                            <Link
                              href="/market/email-services"
                              onClick={closeAllMenus}
                              className="group flex items-start gap-4 rounded-xl p-3 transition-colors hover:bg-gray-50"
                            >
                              <div className="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-amber-100 text-amber-600 group-hover:bg-amber-600 group-hover:text-white transition-colors">
                                <Inbox className="h-5 w-5" />
                              </div>
                              <div>
                                <div className="font-semibold text-gray-900">
                                  {locale === 'ar' ? 'خدمات البريد' : 'E-mail Services'}
                                </div>
                                <p className="mt-0.5 text-xs text-gray-500">
                                  {locale === 'ar' ? 'بريد احترافي لعملك' : 'Professional email for business'}
                                </p>
                              </div>
                            </Link>

                            <Link
                              href="/market/website-builder"
                              onClick={closeAllMenus}
                              className="group flex items-start gap-4 rounded-xl p-3 transition-colors hover:bg-gray-50"
                            >
                              <div className="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-pink-100 text-pink-600 group-hover:bg-pink-600 group-hover:text-white transition-colors">
                                <Palette className="h-5 w-5" />
                              </div>
                              <div>
                                <div className="font-semibold text-gray-900">
                                  {locale === 'ar' ? 'منشئ المواقع' : 'Website Builder'}
                                </div>
                                <p className="mt-0.5 text-xs text-gray-500">
                                  {locale === 'ar' ? 'أنشئ موقعك بدون برمجة' : 'Build your site without coding'}
                                </p>
                              </div>
                            </Link>

                            <Link
                              href="/market/seo-tools"
                              onClick={closeAllMenus}
                              className="group flex items-start gap-4 rounded-xl p-3 transition-colors hover:bg-gray-50"
                            >
                              <div className="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-teal-100 text-teal-600 group-hover:bg-teal-600 group-hover:text-white transition-colors">
                                <TrendingUp className="h-5 w-5" />
                              </div>
                              <div>
                                <div className="font-semibold text-gray-900">
                                  {locale === 'ar' ? 'أدوات SEO' : 'SEO Tools'}
                                </div>
                                <p className="mt-0.5 text-xs text-gray-500">
                                  {locale === 'ar' ? 'تحسين ظهور موقعك' : 'Improve your site visibility'}
                                </p>
                              </div>
                            </Link>

                            <Link
                              href="/market/socialbee"
                              onClick={closeAllMenus}
                              className="group flex items-start gap-4 rounded-xl p-3 transition-colors hover:bg-gray-50"
                            >
                              <div className="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-orange-100 text-orange-600 group-hover:bg-orange-600 group-hover:text-white transition-colors">
                                <Share2 className="h-5 w-5" />
                              </div>
                              <div>
                                <div className="font-semibold text-gray-900">SocialBee</div>
                                <p className="mt-0.5 text-xs text-gray-500">
                                  {locale === 'ar' ? 'إدارة وسائل التواصل' : 'Social media management'}
                                </p>
                              </div>
                            </Link>
                          </div>
                        </div>
                      </div>

                      {/* Right Section - Featured */}
                      <div className="col-span-4 bg-gradient-to-br from-[#1d71b8] to-[#0f4c75] p-6 text-white">
                        <div className="flex h-full flex-col">
                          <span className="inline-flex w-fit items-center gap-1.5 rounded-full bg-white/20 px-3 py-1 text-xs font-semibold backdrop-blur-sm">
                            <BarChart3 className="h-3 w-3" />
                            XOVI NOW
                          </span>
                          <h4 className="mt-4 text-xl font-bold">
                            {locale === 'ar' ? 'أدوات تحليل SEO متقدمة!' : 'Advanced SEO Analysis Tools!'}
                          </h4>
                          <p className="mt-2 text-sm text-white/80">
                            {locale === 'ar' 
                              ? 'حلل منافسيك وحسّن ترتيب موقعك في محركات البحث.'
                              : 'Analyze competitors and improve your search engine rankings.'}
                          </p>
                          <div className="mt-4 flex items-baseline gap-2">
                            <span className="text-3xl font-bold">$19</span>
                            <span className="text-sm text-white/70">/{locale === 'ar' ? 'شهر' : 'mo'}</span>
                          </div>
                          <Link
                            href="/market/xovi-now"
                            onClick={closeAllMenus}
                            className="mt-auto inline-flex items-center justify-center gap-2 rounded-lg bg-white px-4 py-2.5 text-sm font-semibold text-[#1d71b8] transition-all hover:bg-white/90"
                          >
                            {locale === 'ar' ? 'جرّب الآن' : 'Try Now'}
                            <ArrowRight className="h-4 w-4 rtl:rotate-180" />
                          </Link>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            )}

            {/* Migrate Dropdown */}
            <div className="relative">
              <button
                onMouseEnter={() => { setMigrateOpen(true); setHostingOpen(false); setDomainsOpen(false); setMarketOpen(false); }}
                className={cn(
                  'flex items-center gap-2 rounded-lg px-4 py-2 text-sm font-medium transition-colors',
                  migrateOpen
                    ? 'bg-blue-50 text-blue-600'
                    : 'text-gray-600 hover:bg-gray-100'
                )}
              >
                <ArrowRightLeft className="h-4 w-4" />
                {locale === 'ar' ? 'نقل' : 'Migrate'}
                <ChevronDown className={cn('h-3 w-3 transition-transform', migrateOpen && 'rotate-180')} />
              </button>
              
              {migrateOpen && (
                <div 
                  className="absolute end-0 top-full z-[60] pt-2"
                  onMouseLeave={() => setMigrateOpen(false)}
                >
                  <div className="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-xl max-w-[calc(100vw-2rem)]">
                    <div className="grid grid-cols-1 lg:grid-cols-[250px_280px] w-full lg:w-[530px]">
                      {/* Migrate Options */}
                      <div className="p-4 border-b lg:border-b-0 lg:border-e border-gray-200">
                        <h3 className="px-3 mb-3 text-xs font-semibold uppercase tracking-wider text-gray-500">
                          {locale === 'ar' ? 'خيارات النقل' : 'Migration Options'}
                        </h3>
                        <div className="space-y-1">
                          {migrateItems.map((item) => {
                            const Icon = item.icon;
                            return (
                              <Link
                                key={item.href}
                                href={item.href}
                                onClick={closeAllMenus}
                                className={cn(
                                  'flex items-start gap-3 rounded-xl p-3 transition-all hover:bg-gray-50 group',
                                  pathname === item.href && 'bg-blue-50'
                                )}
                              >
                                <div className="flex h-10 w-10 items-center justify-center rounded-lg bg-[#1d71b8]/10 text-[#1d71b8] transition-colors group-hover:bg-[#1d71b8] group-hover:text-white">
                                  <Icon className="h-5 w-5" />
                                </div>
                                <div>
                                  <span className="font-medium text-gray-900">
                                    {item.label}
                                  </span>
                                  <p className="text-xs text-gray-500 mt-0.5">
                                    {item.description}
                                  </p>
                                </div>
                              </Link>
                            );
                          })}
                        </div>
                      </div>
                      
                      {/* Promo Section */}
                      <div className="bg-gradient-to-br from-[#1d71b8] to-[#0f4c75] p-6 text-white">
                        <div className="flex h-full flex-col">
                          <span className="inline-flex w-fit items-center gap-1.5 rounded-full bg-white/20 px-3 py-1 text-xs font-semibold backdrop-blur-sm">
                            <Sparkles className="h-3 w-3" />
                            {locale === 'ar' ? 'نقل مجاني' : 'FREE Migration'}
                          </span>
                          <h4 className="mt-4 text-xl font-bold">
                            {locale === 'ar' ? 'انقل موقعك مجاناً!' : 'Migrate For Free!'}
                          </h4>
                          <p className="mt-2 text-sm text-white/80">
                            {locale === 'ar' 
                              ? 'فريقنا المتخصص سينقل موقعك وبريدك الإلكتروني بدون أي تكلفة إضافية.'
                              : 'Our expert team will migrate your website and emails at no extra cost.'}
                          </p>
                          <ul className="mt-4 space-y-2 text-sm">
                            <li className="flex items-center gap-2">
                              <CheckCircle className="h-4 w-4 text-green-300" />
                              {locale === 'ar' ? 'نقل بدون توقف' : 'Zero Downtime'}
                            </li>
                            <li className="flex items-center gap-2">
                              <CheckCircle className="h-4 w-4 text-green-300" />
                              {locale === 'ar' ? 'دعم فني 24/7' : '24/7 Support'}
                            </li>
                            <li className="flex items-center gap-2">
                              <CheckCircle className="h-4 w-4 text-green-300" />
                              {locale === 'ar' ? 'ضمان استعادة الأموال' : 'Money Back Guarantee'}
                            </li>
                          </ul>
                          <Link
                            href="/migrate/hosting"
                            onClick={closeAllMenus}
                            className="mt-auto inline-flex items-center justify-center gap-2 rounded-lg bg-white px-4 py-2.5 text-sm font-semibold text-[#1d71b8] transition-all hover:bg-white/90"
                          >
                            {locale === 'ar' ? 'ابدأ النقل' : 'Start Migration'}
                            <ArrowRight className="h-4 w-4 rtl:rotate-180" />
                          </Link>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              )}
            </div>
          </div>

          {/* Right Side */}
          <div className="hidden items-center gap-3 lg:flex" onMouseEnter={() => { setHostingOpen(false); setDomainsOpen(false); setMarketOpen(false); setMigrateOpen(false); }}>
            {/* Language Switcher */}
            <div className="relative">
              <button
                onClick={() => setLangOpen(!langOpen)}
                className="flex items-center gap-2 rounded-lg px-3 py-2 text-sm font-medium text-gray-600 transition-colors hover:bg-gray-100"
              >
                <Globe className="h-4 w-4" />
                {localeNames[locale]}
                <ChevronDown className="h-3 w-3" />
              </button>
              {langOpen && (
                <div className="absolute end-0 top-full mt-1 w-36 overflow-hidden rounded-lg border border-gray-200 bg-white shadow-lg">
                  {Object.entries(localeNames).map(([code, name]) => (
                    <button
                      key={code}
                      onClick={() => switchLocale(code as Locale)}
                      className={cn(
                        'flex w-full items-center px-4 py-2 text-sm transition-colors',
                        locale === code
                          ? 'bg-blue-50 text-blue-600'
                          : 'text-gray-700 hover:bg-gray-100'
                      )}
                    >
                      {name}
                    </button>
                  ))}
                </div>
              )}
            </div>

            {/* Auth Buttons */}
            <Link
              href="/login"
              className="flex items-center gap-2 rounded-lg bg-[#1d71b8] px-4 py-2 text-sm font-medium text-white transition-all hover:bg-[#1a6299]"
            >
              <LogIn className="h-4 w-4" />
              {t('login')}
            </Link>
          </div>

          {/* Mobile Menu Button */}
          <button
            onClick={() => setIsOpen(!isOpen)}
            className="rounded-lg p-2 text-gray-600 hover:bg-gray-100 lg:hidden"
            aria-label="Toggle menu"
          >
            {isOpen ? <X className="h-6 w-6" /> : <Menu className="h-6 w-6" />}
          </button>
        </div>

        {/* Mobile Menu */}
        {isOpen && (
          <div className="lg:hidden border-t border-gray-200 bg-white rounded-b-2xl shadow-lg overflow-hidden max-w-full">
            {/* Scrollable Menu Content */}
            <div className="max-h-[70vh] overflow-y-auto py-4">
              <div className="space-y-1 px-4">
                {/* Home */}
                <Link
                  href="/"
                  onClick={() => setIsOpen(false)}
                  className={cn(
                    'flex items-center gap-3 rounded-lg px-4 py-3 text-sm font-medium transition-colors',
                    pathname === '/'
                      ? 'bg-[#1d71b8] text-white'
                      : 'text-gray-700 hover:bg-gray-100'
                  )}
                >
                  <Sparkles className="h-5 w-5" />
                  {t('home')}
                </Link>

                {/* Domains Section - Accordion */}
                <div className="border-b border-gray-100">
                  <button
                    onClick={() => setMobileDomainsOpen(!mobileDomainsOpen)}
                    className="flex items-center justify-between w-full px-4 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50"
                  >
                    <span className="flex items-center gap-3">
                      <Globe2 className="h-5 w-5 text-green-600" />
                      {t('domains')}
                    </span>
                    <ChevronDown className={cn('h-4 w-4 transition-transform', mobileDomainsOpen && 'rotate-180')} />
                  </button>
                  {mobileDomainsOpen && (
                    <div className="pb-2 ps-8">
                      <Link
                        href="/domains"
                        onClick={() => setIsOpen(false)}
                        className={cn(
                          'flex items-center gap-3 rounded-lg px-4 py-2.5 text-sm font-medium transition-colors',
                          pathname === '/domains'
                            ? 'bg-[#1d71b8] text-white'
                            : 'text-gray-600 hover:bg-gray-100'
                        )}
                      >
                        <Search className="h-4 w-4" />
                        {locale === 'ar' ? 'تسجيل دومين جديد' : 'Register New Domain'}
                      </Link>
                      <Link
                        href="/domains/transfer"
                        onClick={() => setIsOpen(false)}
                        className={cn(
                          'flex items-center gap-3 rounded-lg px-4 py-2.5 text-sm font-medium transition-colors',
                          pathname === '/domains/transfer'
                            ? 'bg-[#1d71b8] text-white'
                            : 'text-gray-600 hover:bg-gray-100'
                        )}
                      >
                        <RefreshCw className="h-4 w-4" />
                        {locale === 'ar' ? 'نقل دومين' : 'Transfer Domain'}
                      </Link>
                    </div>
                  )}
                </div>

                {/* Hosting Section - Accordion */}
                <div className="border-b border-gray-100">
                  <button
                    onClick={() => setMobileHostingOpen(!mobileHostingOpen)}
                    className="flex items-center justify-between w-full px-4 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50"
                  >
                    <span className="flex items-center gap-3">
                      <Server className="h-5 w-5 text-purple-600" />
                      {t('hosting')}
                    </span>
                    <ChevronDown className={cn('h-4 w-4 transition-transform', mobileHostingOpen && 'rotate-180')} />
                  </button>
                  {mobileHostingOpen && (
                    <div className="pb-2 ps-8">
                      {hostingItems.map((item) => (
                        <Link
                          key={item.href}
                          href={item.href}
                          onClick={() => setIsOpen(false)}
                          className={cn(
                            'flex items-center gap-3 rounded-lg px-4 py-2.5 text-sm font-medium transition-colors',
                            pathname === item.href
                              ? 'bg-[#1d71b8] text-white'
                              : 'text-gray-600 hover:bg-gray-100'
                          )}
                        >
                          <item.icon className="h-4 w-4" />
                          {item.label}
                        </Link>
                      ))}
                    </div>
                  )}
                </div>

                {/* Market Section - Accordion */}
                <div className="border-b border-gray-100">
                  <button
                    onClick={() => setMobileMarketOpen(!mobileMarketOpen)}
                    className="flex items-center justify-between w-full px-4 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50"
                  >
                    <span className="flex items-center gap-3">
                      <ShoppingBag className="h-5 w-5 text-orange-600" />
                      {locale === 'ar' ? 'المتجر' : 'Market'}
                    </span>
                    <ChevronDown className={cn('h-4 w-4 transition-transform', mobileMarketOpen && 'rotate-180')} />
                  </button>
                  {mobileMarketOpen && (
                    <div className="pb-2 ps-8">
                      <Link href="/market/ssl" onClick={() => setIsOpen(false)} className={cn('flex items-center gap-3 rounded-lg px-4 py-2.5 text-sm font-medium transition-colors', pathname === '/market/ssl' ? 'bg-[#1d71b8] text-white' : 'text-gray-600 hover:bg-gray-100')}>
                        <Lock className="h-4 w-4" />
                        {locale === 'ar' ? 'شهادات SSL' : 'SSL Certificates'}
                      </Link>
                      <Link href="/market/website-security" onClick={() => setIsOpen(false)} className={cn('flex items-center gap-3 rounded-lg px-4 py-2.5 text-sm font-medium transition-colors', pathname === '/market/website-security' ? 'bg-[#1d71b8] text-white' : 'text-gray-600 hover:bg-gray-100')}>
                        <ShieldCheck className="h-4 w-4" />
                        {locale === 'ar' ? 'حماية الموقع' : 'Website Security'}
                      </Link>
                      <Link href="/market/website-backup" onClick={() => setIsOpen(false)} className={cn('flex items-center gap-3 rounded-lg px-4 py-2.5 text-sm font-medium transition-colors', pathname === '/market/website-backup' ? 'bg-[#1d71b8] text-white' : 'text-gray-600 hover:bg-gray-100')}>
                        <FolderArchive className="h-4 w-4" />
                        {locale === 'ar' ? 'نسخ احتياطي' : 'Website Backup'}
                      </Link>
                      <Link href="/market/vpn" onClick={() => setIsOpen(false)} className={cn('flex items-center gap-3 rounded-lg px-4 py-2.5 text-sm font-medium transition-colors', pathname === '/market/vpn' ? 'bg-[#1d71b8] text-white' : 'text-gray-600 hover:bg-gray-100')}>
                        <Wifi className="h-4 w-4" />
                        VPN
                      </Link>
                      <Link href="/market/email-services" onClick={() => setIsOpen(false)} className={cn('flex items-center gap-3 rounded-lg px-4 py-2.5 text-sm font-medium transition-colors', pathname === '/market/email-services' ? 'bg-[#1d71b8] text-white' : 'text-gray-600 hover:bg-gray-100')}>
                        <Inbox className="h-4 w-4" />
                        {locale === 'ar' ? 'خدمات البريد' : 'E-mail Services'}
                      </Link>
                      <Link href="/market/website-builder" onClick={() => setIsOpen(false)} className={cn('flex items-center gap-3 rounded-lg px-4 py-2.5 text-sm font-medium transition-colors', pathname === '/market/website-builder' ? 'bg-[#1d71b8] text-white' : 'text-gray-600 hover:bg-gray-100')}>
                        <Palette className="h-4 w-4" />
                        {locale === 'ar' ? 'منشئ المواقع' : 'Website Builder'}
                      </Link>
                      <Link href="/market/seo-tools" onClick={() => setIsOpen(false)} className={cn('flex items-center gap-3 rounded-lg px-4 py-2.5 text-sm font-medium transition-colors', pathname === '/market/seo-tools' ? 'bg-[#1d71b8] text-white' : 'text-gray-600 hover:bg-gray-100')}>
                        <TrendingUp className="h-4 w-4" />
                        {locale === 'ar' ? 'أدوات SEO' : 'SEO Tools'}
                      </Link>
                      <Link href="/market/socialbee" onClick={() => setIsOpen(false)} className={cn('flex items-center gap-3 rounded-lg px-4 py-2.5 text-sm font-medium transition-colors', pathname === '/market/socialbee' ? 'bg-[#1d71b8] text-white' : 'text-gray-600 hover:bg-gray-100')}>
                        <Share2 className="h-4 w-4" />
                        SocialBee
                      </Link>
                      <Link href="/market/xovi-now" onClick={() => setIsOpen(false)} className={cn('flex items-center gap-3 rounded-lg px-4 py-2.5 text-sm font-medium transition-colors', pathname === '/market/xovi-now' ? 'bg-[#1d71b8] text-white' : 'text-gray-600 hover:bg-gray-100')}>
                        <BarChart3 className="h-4 w-4" />
                        XOVI NOW
                      </Link>
                    </div>
                  )}
                </div>

                {/* Migrate Section - Accordion */}
                <div className="border-b border-gray-100">
                  <button
                    onClick={() => setMobileMigrateOpen(!mobileMigrateOpen)}
                    className="flex items-center justify-between w-full px-4 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50"
                  >
                    <span className="flex items-center gap-3">
                      <ArrowRightLeft className="h-5 w-5 text-teal-600" />
                      {locale === 'ar' ? 'نقل' : 'Migrate'}
                    </span>
                    <ChevronDown className={cn('h-4 w-4 transition-transform', mobileMigrateOpen && 'rotate-180')} />
                  </button>
                  {mobileMigrateOpen && (
                    <div className="pb-2 ps-8">
                      {migrateItems.map((item) => (
                        <Link
                          key={item.href}
                          href={item.href}
                          onClick={() => setIsOpen(false)}
                          className={cn(
                            'flex items-center gap-3 rounded-lg px-4 py-2.5 text-sm font-medium transition-colors',
                            pathname === item.href
                              ? 'bg-[#1d71b8] text-white'
                              : 'text-gray-600 hover:bg-gray-100'
                          )}
                        >
                          <item.icon className="h-4 w-4" />
                          {item.label}
                        </Link>
                      ))}
                    </div>
                  )}
                </div>
              </div>
            </div>

            {/* Menu Footer */}
            <div className="border-t border-gray-200 p-4 bg-gray-50">
              {/* Language Switcher */}
              <div className="flex gap-2 mb-3">
                {Object.entries(localeNames).map(([code, name]) => (
                  <button
                    key={code}
                    onClick={() => switchLocale(code as Locale)}
                    className={cn(
                      'flex-1 rounded-lg px-4 py-2.5 text-sm font-medium transition-colors',
                      locale === code
                        ? 'bg-[#1d71b8] text-white'
                        : 'bg-white text-gray-600 border border-gray-200'
                    )}
                  >
                    <span className="flex items-center justify-center gap-2">
                      <Globe className="h-4 w-4" />
                      {name}
                    </span>
                  </button>
                ))}
              </div>
              {/* Login Button */}
              <Link
                href="/login"
                onClick={() => setIsOpen(false)}
                className="flex w-full items-center justify-center gap-2 rounded-lg bg-[#1d71b8] px-4 py-3 text-sm font-medium text-white hover:bg-[#1a6299] transition-colors"
              >
                <LogIn className="h-4 w-4" />
                {t('login')}
              </Link>
            </div>
          </div>
        )}
      </div>
    </nav>
  );
}
