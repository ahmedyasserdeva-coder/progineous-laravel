import { MetadataRoute } from 'next';

const baseUrl = process.env.NEXT_PUBLIC_SITE_URL || 'https://progineous.com';

// All website pages with SEO metadata - Optimized for Egypt market
// Updated January 2026 with Google's latest SEO guidelines
const pages = [
  // Main pages - High priority
  { path: '', priority: 1.0, changeFreq: 'daily' as const },
  { path: '/about', priority: 0.85, changeFreq: 'monthly' as const },
  { path: '/contact', priority: 0.9, changeFreq: 'monthly' as const }, // Higher for local business
  { path: '/login', priority: 0.4, changeFreq: 'yearly' as const },
  { path: '/status', priority: 0.75, changeFreq: 'hourly' as const }, // System status page
  
  // Domains - Very High Priority (money pages)
  { path: '/domains', priority: 0.98, changeFreq: 'daily' as const },
  { path: '/domains/transfer', priority: 0.90, changeFreq: 'weekly' as const },
  
  // Hosting - Highest Priority (main products)
  { path: '/hosting/shared', priority: 1.0, changeFreq: 'daily' as const }, // Most searched in Egypt
  { path: '/hosting/cloud', priority: 0.98, changeFreq: 'daily' as const },
  { path: '/hosting/vps', priority: 0.97, changeFreq: 'daily' as const },
  { path: '/hosting/dedicated', priority: 0.95, changeFreq: 'weekly' as const },
  { path: '/hosting/email', priority: 0.90, changeFreq: 'weekly' as const },
  { path: '/hosting/reseller', priority: 0.92, changeFreq: 'weekly' as const },
  { path: '/hosting/windows-reseller', priority: 0.88, changeFreq: 'weekly' as const },
  
  // Market - Medium-High Priority
  { path: '/market/ssl', priority: 0.90, changeFreq: 'weekly' as const },
  { path: '/market/vpn', priority: 0.82, changeFreq: 'weekly' as const },
  { path: '/market/website-backup', priority: 0.85, changeFreq: 'weekly' as const },
  { path: '/market/website-builder', priority: 0.88, changeFreq: 'weekly' as const },
  { path: '/market/website-security', priority: 0.88, changeFreq: 'weekly' as const },
  { path: '/market/email-services', priority: 0.85, changeFreq: 'weekly' as const },
  { path: '/market/seo-tools', priority: 0.80, changeFreq: 'weekly' as const },
  { path: '/market/socialbee', priority: 0.78, changeFreq: 'weekly' as const },
  { path: '/market/xovi-now', priority: 0.78, changeFreq: 'weekly' as const },
  
  // Migration Services
  { path: '/migrate/hosting', priority: 0.85, changeFreq: 'monthly' as const },
  { path: '/migrate/email', priority: 0.82, changeFreq: 'monthly' as const },
  
  // Affiliate Programs
  { path: '/affiliate', priority: 0.80, changeFreq: 'monthly' as const },
  { path: '/refer-friend', priority: 0.78, changeFreq: 'monthly' as const },
  
  // Comparison Pages - High Priority for SEO (targeting competitor keywords)
  { path: '/compare', priority: 0.92, changeFreq: 'weekly' as const },
  { path: '/compare/hostinger', priority: 0.95, changeFreq: 'weekly' as const },
  { path: '/compare/godaddy', priority: 0.95, changeFreq: 'weekly' as const },
  { path: '/compare/namecheap', priority: 0.94, changeFreq: 'weekly' as const },
  { path: '/compare/hostgator', priority: 0.93, changeFreq: 'weekly' as const },
  { path: '/compare/bluehost', priority: 0.93, changeFreq: 'weekly' as const },
  { path: '/compare/siteground', priority: 0.93, changeFreq: 'weekly' as const },
  
  // Legal Pages - Low Priority but important for trust signals
  { path: '/terms', priority: 0.4, changeFreq: 'yearly' as const },
  { path: '/privacy', priority: 0.4, changeFreq: 'yearly' as const },
  { path: '/aup', priority: 0.35, changeFreq: 'yearly' as const },
  { path: '/dmca', priority: 0.35, changeFreq: 'yearly' as const },
  { path: '/refund', priority: 0.45, changeFreq: 'yearly' as const },
];

const locales = ['en', 'ar'];

export default function sitemap(): MetadataRoute.Sitemap {
  const sitemapEntries: MetadataRoute.Sitemap = [];

  // Generate entries for each page in each locale
  // Arabic first for Arab World focus
  for (const page of pages) {
    for (const locale of ['ar', 'en']) { // Arabic first for Arab World
      const url = `${baseUrl}/${locale}${page.path}`;
      
      // Create alternates for language versions (hreflang)
      // Comprehensive Global coverage - Arab World + Western Markets
      const alternates: { languages: Record<string, string> } = {
        languages: {
          // Arabic variants for each Arab country
          'ar': `${baseUrl}/ar${page.path}`,
          'ar-EG': `${baseUrl}/ar${page.path}`, // Egypt
          'ar-SA': `${baseUrl}/ar${page.path}`, // Saudi Arabia
          'ar-AE': `${baseUrl}/ar${page.path}`, // UAE
          'ar-JO': `${baseUrl}/ar${page.path}`, // Jordan
          'ar-KW': `${baseUrl}/ar${page.path}`, // Kuwait
          'ar-QA': `${baseUrl}/ar${page.path}`, // Qatar
          'ar-BH': `${baseUrl}/ar${page.path}`, // Bahrain
          'ar-OM': `${baseUrl}/ar${page.path}`, // Oman
          'ar-LB': `${baseUrl}/ar${page.path}`, // Lebanon
          'ar-IQ': `${baseUrl}/ar${page.path}`, // Iraq
          'ar-MA': `${baseUrl}/ar${page.path}`, // Morocco
          'ar-DZ': `${baseUrl}/ar${page.path}`, // Algeria
          'ar-TN': `${baseUrl}/ar${page.path}`, // Tunisia
          'ar-LY': `${baseUrl}/ar${page.path}`, // Libya
          'ar-SD': `${baseUrl}/ar${page.path}`, // Sudan
          'ar-PS': `${baseUrl}/ar${page.path}`, // Palestine
          'ar-YE': `${baseUrl}/ar${page.path}`, // Yemen
          'ar-SY': `${baseUrl}/ar${page.path}`, // Syria
          // English variants - Arab Countries
          'en': `${baseUrl}/en${page.path}`,
          'en-EG': `${baseUrl}/en${page.path}`, // Egypt
          'en-SA': `${baseUrl}/en${page.path}`, // Saudi Arabia
          'en-AE': `${baseUrl}/en${page.path}`, // UAE
          // English variants - USA
          'en-US': `${baseUrl}/en${page.path}`, // United States
          // English variants - Canada
          'en-CA': `${baseUrl}/en${page.path}`, // Canada
          // English variants - UK
          'en-GB': `${baseUrl}/en${page.path}`, // United Kingdom
          // English variants - Ireland
          'en-IE': `${baseUrl}/en${page.path}`, // Ireland
          // English variants - Australia & NZ
          'en-AU': `${baseUrl}/en${page.path}`, // Australia
          'en-NZ': `${baseUrl}/en${page.path}`, // New Zealand
          // German variants
          'de': `${baseUrl}/en${page.path}`, // German (use English for now)
          'de-DE': `${baseUrl}/en${page.path}`, // Germany
          'de-AT': `${baseUrl}/en${page.path}`, // Austria
          'de-CH': `${baseUrl}/en${page.path}`, // Switzerland (German)
          // French variants
          'fr': `${baseUrl}/en${page.path}`, // French (use English for now)
          'fr-FR': `${baseUrl}/en${page.path}`, // France
          'fr-CA': `${baseUrl}/en${page.path}`, // Canada (French)
          'fr-BE': `${baseUrl}/en${page.path}`, // Belgium (French)
          'fr-CH': `${baseUrl}/en${page.path}`, // Switzerland (French)
          // Spanish variants (for broader reach)
          'es': `${baseUrl}/en${page.path}`, // Spanish (use English for now)
          'es-ES': `${baseUrl}/en${page.path}`, // Spain
          'es-MX': `${baseUrl}/en${page.path}`, // Mexico
          // Italian variant
          'it': `${baseUrl}/en${page.path}`, // Italian (use English for now)
          'it-IT': `${baseUrl}/en${page.path}`, // Italy
          // Dutch variant
          'nl': `${baseUrl}/en${page.path}`, // Dutch (use English for now)
          'nl-NL': `${baseUrl}/en${page.path}`, // Netherlands
          'nl-BE': `${baseUrl}/en${page.path}`, // Belgium (Dutch)
          // Portuguese variants
          'pt': `${baseUrl}/en${page.path}`, // Portuguese (use English for now)
          'pt-PT': `${baseUrl}/en${page.path}`, // Portugal
          'pt-BR': `${baseUrl}/en${page.path}`, // Brazil
          // Turkish variant
          'tr': `${baseUrl}/en${page.path}`, // Turkish (use English for now)
          'tr-TR': `${baseUrl}/en${page.path}`, // Turkey
          // Default to Arabic for Arab World focus
          'x-default': `${baseUrl}/ar${page.path}`,
        }
      };

      sitemapEntries.push({
        url,
        lastModified: new Date(),
        changeFrequency: page.changeFreq,
        priority: page.priority,
        alternates,
      });
    }
  }

  return sitemapEntries;
}
