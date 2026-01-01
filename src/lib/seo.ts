/**
 * SEO Utilities and Best Practices for Pro Gineous
 * Based on Google's Official SEO Guidelines (January 2026)
 * 
 * @see https://developers.google.com/search/docs/fundamentals/seo-starter-guide
 * @see https://developers.google.com/search/docs/appearance/ranking-systems-guide
 */

/**
 * Meta Description Generator
 * Google recommends: unique, accurate, and compelling descriptions
 * Optimal length: 150-160 characters
 */
export function generateMetaDescription(options: {
  product?: string;
  benefit?: string;
  price?: string;
  cta?: string;
  locale: 'en' | 'ar';
}): string {
  const { product, benefit, price, cta, locale } = options;
  const isArabic = locale === 'ar';

  if (isArabic) {
    let description = '';
    if (product) description += product;
    if (benefit) description += ` - ${benefit}`;
    if (price) description += `. بدءاً من ${price}`;
    if (cta) description += `. ${cta}`;
    return description.slice(0, 160);
  }

  let description = '';
  if (product) description += product;
  if (benefit) description += ` - ${benefit}`;
  if (price) description += `. Starting from ${price}`;
  if (cta) description += `. ${cta}`;
  return description.slice(0, 160);
}

/**
 * Title Tag Generator
 * Google recommends: unique, descriptive titles
 * Optimal length: 50-60 characters
 * Format: Primary Keyword - Secondary Keyword | Brand
 */
export function generateTitle(options: {
  primary: string;
  secondary?: string;
  brand?: string;
  locale: 'en' | 'ar';
}): string {
  const { primary, secondary, brand = 'Pro Gineous', locale } = options;
  
  let title = primary;
  if (secondary) {
    title += locale === 'ar' ? ` - ${secondary}` : ` - ${secondary}`;
  }
  title += ` | ${brand}`;
  
  // Truncate if too long
  if (title.length > 60) {
    title = `${primary} | ${brand}`;
  }
  
  return title;
}

/**
 * Canonical URL Generator
 */
export function generateCanonicalUrl(
  path: string,
  locale: 'en' | 'ar',
  baseUrl: string = 'https://progineous.com'
): string {
  // Remove trailing slash
  const cleanPath = path.replace(/\/$/, '');
  return `${baseUrl}/${locale}${cleanPath}`;
}

/**
 * Alternate Languages Generator for hreflang
 */
export function generateAlternateLanguages(
  path: string,
  baseUrl: string = 'https://progineous.com'
): Record<string, string> {
  const cleanPath = path.replace(/\/$/, '');
  
  return {
    'en': `${baseUrl}/en${cleanPath}`,
    'ar': `${baseUrl}/ar${cleanPath}`,
    'en-US': `${baseUrl}/en${cleanPath}`,
    'en-GB': `${baseUrl}/en${cleanPath}`,
    'ar-EG': `${baseUrl}/ar${cleanPath}`,
    'ar-SA': `${baseUrl}/ar${cleanPath}`,
    'ar-AE': `${baseUrl}/ar${cleanPath}`,
    'x-default': `${baseUrl}/en${cleanPath}`,
  };
}

/**
 * JSON-LD Schema Generators
 */

// Organization Schema
export function generateOrganizationSchema(locale: 'en' | 'ar') {
  const isArabic = locale === 'ar';
  
  return {
    '@context': 'https://schema.org',
    '@type': 'Organization',
    '@id': 'https://progineous.com/#organization',
    name: 'Pro Gineous',
    alternateName: isArabic ? 'برو جينيوس' : 'Pro Gineous',
    url: 'https://progineous.com',
    logo: {
      '@type': 'ImageObject',
      url: 'https://progineous.com/images/logos/pro Gineous_white logo.svg',
      width: 200,
      height: 60,
    },
    description: isArabic
      ? 'شركة استضافة مواقع احترافية تقدم خدمات الاستضافة السحابية وVPS والسيرفرات المخصصة'
      : 'Professional web hosting company offering cloud hosting, VPS, and dedicated servers',
    email: 'support@progineous.com',
    telephone: '+201070798859',
    foundingDate: '2020',
    sameAs: [
      'https://twitter.com/progineous',
      'https://facebook.com/progineous',
      'https://linkedin.com/company/progineous',
      'https://instagram.com/progineous',
    ],
  };
}

// Product Schema for Hosting Plans
export function generateProductSchema(options: {
  name: string;
  description: string;
  price: string;
  currency?: string;
  category?: string;
  locale: 'en' | 'ar';
  url: string;
  rating?: { value: string; count: string };
}) {
  const {
    name,
    description,
    price,
    currency = 'USD',
    category = 'Web Hosting',
    locale,
    url,
    rating,
  } = options;

  const schema: Record<string, unknown> = {
    '@context': 'https://schema.org',
    '@type': 'Product',
    name,
    description,
    brand: {
      '@type': 'Brand',
      name: 'Pro Gineous',
    },
    category,
    url: `https://progineous.com/${locale}${url}`,
    offers: {
      '@type': 'Offer',
      price,
      priceCurrency: currency,
      availability: 'https://schema.org/InStock',
      priceValidUntil: '2026-12-31',
      seller: {
        '@type': 'Organization',
        name: 'Pro Gineous',
      },
    },
  };

  if (rating) {
    schema.aggregateRating = {
      '@type': 'AggregateRating',
      ratingValue: rating.value,
      reviewCount: rating.count,
      bestRating: '5',
      worstRating: '1',
    };
  }

  return schema;
}

// FAQ Schema
export function generateFAQSchema(
  faqs: Array<{ question: string; answer: string }>
) {
  return {
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
}

// Breadcrumb Schema
export function generateBreadcrumbSchema(
  items: Array<{ name: string; url?: string }>,
  locale: 'en' | 'ar',
  baseUrl: string = 'https://progineous.com'
) {
  const isArabic = locale === 'ar';
  const homeLabel = isArabic ? 'الرئيسية' : 'Home';

  return {
    '@context': 'https://schema.org',
    '@type': 'BreadcrumbList',
    itemListElement: [
      {
        '@type': 'ListItem',
        position: 1,
        name: homeLabel,
        item: `${baseUrl}/${locale}`,
      },
      ...items.map((item, index) => ({
        '@type': 'ListItem',
        position: index + 2,
        name: item.name,
        ...(item.url && { item: `${baseUrl}/${locale}${item.url}` }),
      })),
    ],
  };
}

// Service Schema
export function generateServiceSchema(options: {
  name: string;
  description: string;
  locale: 'en' | 'ar';
  url: string;
  offers?: Array<{ name: string; price: string }>;
}) {
  const { name, description, locale, url, offers } = options;

  const schema: Record<string, unknown> = {
    '@context': 'https://schema.org',
    '@type': 'Service',
    name,
    description,
    provider: {
      '@type': 'Organization',
      name: 'Pro Gineous',
      url: 'https://progineous.com',
    },
    areaServed: 'Worldwide',
    url: `https://progineous.com/${locale}${url}`,
  };

  if (offers) {
    schema.hasOfferCatalog = {
      '@type': 'OfferCatalog',
      name,
      itemListElement: offers.map((offer) => ({
        '@type': 'Offer',
        itemOffered: {
          '@type': 'Service',
          name: offer.name,
        },
        priceCurrency: 'USD',
        price: offer.price,
      })),
    };
  }

  return schema;
}

/**
 * SEO Checklist for Pro Gineous Pages
 * 
 * ✅ Technical SEO:
 * - [ ] Unique title tag (50-60 chars)
 * - [ ] Meta description (150-160 chars)
 * - [ ] Canonical URL
 * - [ ] hreflang tags for ar/en
 * - [ ] Mobile responsive
 * - [ ] HTTPS
 * - [ ] Fast loading (Core Web Vitals)
 * 
 * ✅ Content SEO:
 * - [ ] H1 tag with primary keyword
 * - [ ] Structured headings (H2, H3)
 * - [ ] Internal links to related pages
 * - [ ] External links with nofollow when needed
 * - [ ] Alt text for all images
 * - [ ] Unique, helpful content
 * 
 * ✅ Structured Data:
 * - [ ] Organization schema
 * - [ ] Product/Service schema
 * - [ ] FAQ schema
 * - [ ] Breadcrumb schema
 * - [ ] LocalBusiness schema
 * 
 * ✅ User Experience:
 * - [ ] Easy navigation
 * - [ ] Clear CTAs
 * - [ ] No intrusive interstitials
 * - [ ] Accessible design
 */

/**
 * Google's Ranking Systems (2026)
 * 
 * Key Systems to Optimize For:
 * 
 * 1. BERT - Natural language understanding
 *    → Write naturally, focus on user intent
 * 
 * 2. RankBrain - Query understanding
 *    → Cover related topics comprehensively
 * 
 * 3. Neural Matching - Concept matching
 *    → Use synonyms and related terms
 * 
 * 4. Passage Ranking - Section relevance
 *    → Structure content with clear sections
 * 
 * 5. PageRank - Link analysis
 *    → Build quality backlinks
 * 
 * 6. Reviews System - Review quality
 *    → Showcase authentic customer reviews
 * 
 * 7. Helpful Content - Content quality
 *    → Create people-first, expert content
 */

/**
 * Things NOT to Focus On (Per Google):
 * 
 * ❌ Meta keywords - Google doesn't use them
 * ❌ Keyword stuffing - Against spam policies
 * ❌ Exact content length - No magic number
 * ❌ Keywords in domain - Minimal impact
 * ❌ Number of headings - No ideal count
 * ❌ E-E-A-T as ranking factor - It's not direct
 */
