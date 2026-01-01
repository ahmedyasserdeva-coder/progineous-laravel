'use client';

import { Link } from '@/i18n/routing';
import { useLocale } from 'next-intl';
import { cn } from '@/lib/utils';
import { ExternalLink } from 'lucide-react';

interface SEOLinkProps {
  href: string;
  children: React.ReactNode;
  className?: string;
  /**
   * Whether this is an external link
   * External links get nofollow, noopener, noreferrer by default
   */
  external?: boolean;
  /**
   * Override the rel attribute
   */
  rel?: string;
  /**
   * Add visual indicator for external links
   */
  showExternalIcon?: boolean;
  /**
   * Title attribute for additional context
   */
  title?: string;
  /**
   * Make the link prefetch on hover (internal only)
   */
  prefetch?: boolean;
  /**
   * Aria label for accessibility
   */
  ariaLabel?: string;
}

/**
 * SEOLink Component
 * 
 * SEO-optimized link component following Google's guidelines:
 * - Proper anchor text (children should be descriptive)
 * - External links get appropriate rel attributes
 * - Internal links use Next.js Link for prefetching
 * 
 * @see https://developers.google.com/search/docs/crawling-indexing/links-crawlable
 */
export function SEOLink({
  href,
  children,
  className,
  external = false,
  rel,
  showExternalIcon = true,
  title,
  prefetch = true,
  ariaLabel,
}: SEOLinkProps) {
  const locale = useLocale();

  // Determine if link is external
  const isExternal = external || href.startsWith('http') || href.startsWith('//');

  // Build rel attribute for external links
  const externalRel = rel || 'nofollow noopener noreferrer';

  if (isExternal) {
    return (
      <a
        href={href}
        className={cn('inline-flex items-center gap-1', className)}
        rel={externalRel}
        target="_blank"
        title={title}
        aria-label={ariaLabel}
      >
        {children}
        {showExternalIcon && (
          <ExternalLink className="w-3 h-3 opacity-60" aria-hidden="true" />
        )}
      </a>
    );
  }

  return (
    <Link
      href={href}
      className={className}
      title={title}
      prefetch={prefetch}
      aria-label={ariaLabel}
    >
      {children}
    </Link>
  );
}

/**
 * Related Links Component
 * For adding contextual internal links to improve SEO
 */
interface RelatedLink {
  href: string;
  title: string;
  description?: string;
}

interface RelatedLinksProps {
  title?: string;
  links: RelatedLink[];
  className?: string;
}

export function RelatedLinks({ title, links, className }: RelatedLinksProps) {
  const locale = useLocale();
  const isRTL = locale === 'ar';

  const defaultTitle = isRTL ? 'روابط ذات صلة' : 'Related Links';

  return (
    <nav
      aria-label={title || defaultTitle}
      className={cn('mt-8 p-6 bg-gray-50 rounded-xl', className)}
    >
      <h3 className="text-lg font-semibold mb-4">{title || defaultTitle}</h3>
      <ul className="space-y-3">
        {links.map((link, index) => (
          <li key={index}>
            <Link
              href={link.href}
              className="group flex flex-col hover:text-blue-600 transition-colors"
            >
              <span className="font-medium group-hover:underline">
                {link.title}
              </span>
              {link.description && (
                <span className="text-sm text-gray-500">
                  {link.description}
                </span>
              )}
            </Link>
          </li>
        ))}
      </ul>
    </nav>
  );
}

/**
 * Internal Linking Strategy for Pro Gineous
 * Based on Google's SEO recommendations
 */
export const internalLinkingMap = {
  // From shared hosting page
  sharedHosting: [
    { href: '/hosting/cloud', title: { en: 'Upgrade to Cloud Hosting', ar: 'ترقية للاستضافة السحابية' } },
    { href: '/hosting/vps', title: { en: 'Need more power? Try VPS', ar: 'تحتاج قوة أكبر؟ جرب VPS' } },
    { href: '/domains', title: { en: 'Register a Domain', ar: 'سجل نطاقك' } },
    { href: '/market/ssl', title: { en: 'SSL Certificates', ar: 'شهادات SSL' } },
    { href: '/compare', title: { en: 'Compare with Competitors', ar: 'قارن مع المنافسين' } },
  ],
  
  // From cloud hosting page
  cloudHosting: [
    { href: '/hosting/shared', title: { en: 'Starting out? Try Shared', ar: 'بداية؟ جرب المشتركة' } },
    { href: '/hosting/vps', title: { en: 'VPS Hosting', ar: 'استضافة VPS' } },
    { href: '/hosting/dedicated', title: { en: 'Dedicated Servers', ar: 'سيرفرات مخصصة' } },
    { href: '/market/website-security', title: { en: 'Website Security', ar: 'أمان المواقع' } },
  ],
  
  // From domains page
  domains: [
    { href: '/hosting/shared', title: { en: 'Web Hosting', ar: 'استضافة مواقع' } },
    { href: '/market/ssl', title: { en: 'SSL Certificates', ar: 'شهادات SSL' } },
    { href: '/market/email-services', title: { en: 'Email Services', ar: 'خدمات البريد' } },
    { href: '/domains/transfer', title: { en: 'Transfer Domain', ar: 'نقل النطاق' } },
  ],
  
  // From comparison pages
  compare: [
    { href: '/hosting/shared', title: { en: 'View Shared Hosting Plans', ar: 'عرض خطط الاستضافة المشتركة' } },
    { href: '/hosting/cloud', title: { en: 'View Cloud Hosting', ar: 'عرض الاستضافة السحابية' } },
    { href: '/about', title: { en: 'About Pro Gineous', ar: 'من نحن' } },
    { href: '/contact', title: { en: 'Contact Us', ar: 'اتصل بنا' } },
  ],
  
  // From about page
  about: [
    { href: '/hosting/shared', title: { en: 'Our Hosting Services', ar: 'خدمات الاستضافة' } },
    { href: '/contact', title: { en: 'Get in Touch', ar: 'تواصل معنا' } },
    { href: '/affiliate', title: { en: 'Join Affiliate Program', ar: 'انضم لبرنامج الشراكة' } },
    { href: '/compare', title: { en: 'Why Choose Us', ar: 'لماذا نحن' } },
  ],
};

/**
 * Get related links based on current page
 */
export function getRelatedLinks(
  pageKey: keyof typeof internalLinkingMap,
  locale: 'en' | 'ar'
): RelatedLink[] {
  const links = internalLinkingMap[pageKey];
  if (!links) return [];
  
  return links.map(link => ({
    href: link.href,
    title: link.title[locale],
  }));
}
