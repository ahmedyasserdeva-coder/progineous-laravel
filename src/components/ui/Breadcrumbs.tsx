'use client';

import { useLocale } from 'next-intl';
import { Link } from '@/i18n/routing';
import { ChevronRight, ChevronLeft, Home } from 'lucide-react';
import { cn } from '@/lib/utils';

interface BreadcrumbItem {
  label: string;
  href?: string;
}

interface BreadcrumbsProps {
  items: BreadcrumbItem[];
  className?: string;
}

/**
 * Breadcrumbs Component - SEO Optimized
 * Follows Google's structured data guidelines for BreadcrumbList
 * @see https://developers.google.com/search/docs/appearance/structured-data/breadcrumb
 */
export function Breadcrumbs({ items, className }: BreadcrumbsProps) {
  const locale = useLocale();
  const isRTL = locale === 'ar';
  const ChevronIcon = isRTL ? ChevronLeft : ChevronRight;

  const homeLabel = isRTL ? 'الرئيسية' : 'Home';

  // Generate JSON-LD structured data
  const structuredData = {
    '@context': 'https://schema.org',
    '@type': 'BreadcrumbList',
    itemListElement: [
      {
        '@type': 'ListItem',
        position: 1,
        name: homeLabel,
        item: `https://progineous.com/${locale}`,
      },
      ...items.map((item, index) => ({
        '@type': 'ListItem',
        position: index + 2,
        name: item.label,
        ...(item.href && { item: `https://progineous.com/${locale}${item.href}` }),
      })),
    ],
  };

  return (
    <>
      {/* JSON-LD for SEO */}
      <script
        type="application/ld+json"
        dangerouslySetInnerHTML={{ __html: JSON.stringify(structuredData) }}
      />
      
      {/* Visual Breadcrumbs */}
      <nav
        aria-label={isRTL ? 'مسار التنقل' : 'Breadcrumb'}
        className={cn(
          'flex items-center gap-2 text-sm text-gray-500',
          className
        )}
      >
        <ol
          className={cn(
            'flex items-center gap-1 flex-wrap',
            isRTL && 'flex-row-reverse'
          )}
          itemScope
          itemType="https://schema.org/BreadcrumbList"
        >
          {/* Home */}
          <li
            className="flex items-center gap-1"
            itemProp="itemListElement"
            itemScope
            itemType="https://schema.org/ListItem"
          >
            <Link
              href="/"
              className="flex items-center gap-1 text-gray-500 hover:text-blue-600 transition-colors"
              itemProp="item"
            >
              <Home className="w-4 h-4" />
              <span itemProp="name" className="sr-only md:not-sr-only">
                {homeLabel}
              </span>
            </Link>
            <meta itemProp="position" content="1" />
          </li>

          {/* Items */}
          {items.map((item, index) => (
            <li
              key={index}
              className="flex items-center gap-1"
              itemProp="itemListElement"
              itemScope
              itemType="https://schema.org/ListItem"
            >
              <ChevronIcon className="w-4 h-4 text-gray-400" />
              {item.href ? (
                <Link
                  href={item.href}
                  className="text-gray-500 hover:text-blue-600 transition-colors"
                  itemProp="item"
                >
                  <span itemProp="name">{item.label}</span>
                </Link>
              ) : (
                <span
                  className="text-gray-900 font-medium"
                  itemProp="name"
                  aria-current="page"
                >
                  {item.label}
                </span>
              )}
              <meta itemProp="position" content={String(index + 2)} />
            </li>
          ))}
        </ol>
      </nav>
    </>
  );
}

/**
 * Utility function to generate breadcrumb items from pathname
 */
export function generateBreadcrumbsFromPath(
  pathname: string,
  locale: string,
  customLabels?: Record<string, string>
): BreadcrumbItem[] {
  const segments = pathname.split('/').filter(Boolean);
  
  // Remove locale from segments if present
  if (segments[0] === locale) {
    segments.shift();
  }

  const defaultLabels: Record<string, { en: string; ar: string }> = {
    hosting: { en: 'Hosting', ar: 'الاستضافة' },
    shared: { en: 'Shared Hosting', ar: 'استضافة مشتركة' },
    cloud: { en: 'Cloud Hosting', ar: 'استضافة سحابية' },
    vps: { en: 'VPS Hosting', ar: 'سيرفرات VPS' },
    dedicated: { en: 'Dedicated Servers', ar: 'سيرفرات مخصصة' },
    email: { en: 'Email Hosting', ar: 'استضافة بريد' },
    reseller: { en: 'Reseller Hosting', ar: 'استضافة موزعين' },
    'windows-reseller': { en: 'Windows Reseller', ar: 'موزعين ويندوز' },
    domains: { en: 'Domains', ar: 'النطاقات' },
    transfer: { en: 'Transfer', ar: 'نقل النطاق' },
    market: { en: 'Market', ar: 'السوق' },
    ssl: { en: 'SSL Certificates', ar: 'شهادات SSL' },
    vpn: { en: 'VPN', ar: 'VPN' },
    'website-backup': { en: 'Website Backup', ar: 'نسخ احتياطي' },
    'website-builder': { en: 'Website Builder', ar: 'منشئ المواقع' },
    'website-security': { en: 'Website Security', ar: 'أمان المواقع' },
    'email-services': { en: 'Email Services', ar: 'خدمات البريد' },
    'seo-tools': { en: 'SEO Tools', ar: 'أدوات السيو' },
    compare: { en: 'Compare', ar: 'المقارنة' },
    about: { en: 'About Us', ar: 'من نحن' },
    contact: { en: 'Contact', ar: 'اتصل بنا' },
    affiliate: { en: 'Affiliate', ar: 'برنامج الشراكة' },
    'refer-friend': { en: 'Refer a Friend', ar: 'إحالة صديق' },
    migrate: { en: 'Migrate', ar: 'النقل' },
    terms: { en: 'Terms of Service', ar: 'شروط الخدمة' },
    privacy: { en: 'Privacy Policy', ar: 'سياسة الخصوصية' },
    aup: { en: 'Acceptable Use', ar: 'سياسة الاستخدام' },
    dmca: { en: 'DMCA', ar: 'DMCA' },
    refund: { en: 'Refund Policy', ar: 'سياسة الاسترداد' },
    status: { en: 'System Status', ar: 'حالة النظام' },
    login: { en: 'Login', ar: 'تسجيل الدخول' },
  };

  const isArabic = locale === 'ar';
  let currentPath = '';

  return segments.map((segment, index) => {
    currentPath += `/${segment}`;
    const isLast = index === segments.length - 1;
    
    // Get label from custom labels or default labels
    let label = customLabels?.[segment];
    if (!label) {
      const defaultLabel = defaultLabels[segment];
      label = defaultLabel 
        ? (isArabic ? defaultLabel.ar : defaultLabel.en)
        : segment.charAt(0).toUpperCase() + segment.slice(1).replace(/-/g, ' ');
    }

    return {
      label,
      href: isLast ? undefined : currentPath,
    };
  });
}
