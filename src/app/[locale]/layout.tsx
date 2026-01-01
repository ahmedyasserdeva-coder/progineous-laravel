import type { Metadata } from 'next';
import { NextIntlClientProvider } from 'next-intl';
import { getMessages, setRequestLocale } from 'next-intl/server';
import { notFound } from 'next/navigation';
import Script from 'next/script';
import { routing } from '@/i18n/routing';
import { localeDirection, type Locale } from '@/i18n/config';
import { Navbar } from '@/components/layout/Navbar';
import { Footer } from '@/components/layout/Footer';
import { NewYearCelebration } from '@/components/ui/NewYearCelebration';
import { Snowfall } from '@/components/ui/Snowfall';
import { PageLoader } from '@/components/ui/PageLoader';
import { LanguageSuggestion } from '@/components/ui/LanguageSuggestion';
import '@/app/globals.css';

export function generateStaticParams() {
  return routing.locales.map((locale) => ({ locale }));
}

type Props = {
  children: React.ReactNode;
  params: Promise<{ locale: string }>;
};

export async function generateMetadata({ params }: Props): Promise<Metadata> {
  const { locale } = await params;
  const messages = await getMessages();
  const t = messages.metadata as Record<string, string>;

  const keywordsAr = [
    // === كلمات مفتاحية عامة 2026 ===
    'استضافة مواقع',
    'استضافة سحابية',
    'سيرفرات VPS',
    'سيرفرات مخصصة',
    'تسجيل دومين',
    'حجز نطاق',
    'استضافة ووردبريس',
    'استضافة رخيصة',
    'أفضل استضافة',
    'استضافة عربية',
    'شهادة SSL مجانية',
    'استضافة LiteSpeed',
    'استضافة cPanel',
    'نقل موقع مجاني',
    'دعم فني 24 ساعة',
    'استضافة آمنة',
    'سيرفرات سريعة',
    'استضافة NVMe SSD',
    'حماية DDoS',
    'باندويث غير محدود',
    'استضافة متاجر الكترونية',
    // كلمات جديدة 2026
    'استضافة AI',
    'استضافة ذكية',
    'استضافة سريعة 2026',
    'أفضل استضافة 2026',
    'استضافة مع ذكاء اصطناعي',
    'استضافة HTTP/3',
    'استضافة بالجنيه',
    'استضافة بالريال',
    'استضافة بالدرهم',
    'كلاود هوستنج',
    'ويب هوستنج',
    'برو جينيوس',
    
    // === مصر - Egypt ===
    'استضافة مواقع مصر',
    'استضافة مصرية',
    'افضل استضافة في مصر',
    'شركة استضافة مصرية',
    'استضافة مواقع القاهرة',
    'استضافة الاسكندرية',
    'ارخص استضافة في مصر',
    'استضافة بالجنيه المصري',
    'هوستينج مصر',
    'سيرفر مصري',
    'دومين مصري',
    'نطاق .eg',
    'شركات استضافة مصر',
    'استضافة مصر 2026',
    
    // === السعودية - Saudi Arabia ===
    'استضافة مواقع السعودية',
    'استضافة سعودية',
    'افضل استضافة في السعودية',
    'شركة استضافة سعودية',
    'استضافة مواقع الرياض',
    'استضافة جدة',
    'استضافة الدمام',
    'استضافة مكة',
    'استضافة المدينة',
    'هوستينج السعودية',
    'سيرفر سعودي',
    'دومين سعودي',
    'نطاق .sa',
    'استضافة بالريال السعودي',
    'شركات استضافة السعودية',
    'استضافة السعودية 2026',
    
    // === الإمارات - UAE ===
    'استضافة مواقع الامارات',
    'استضافة اماراتية',
    'افضل استضافة في الامارات',
    'شركة استضافة اماراتية',
    'استضافة مواقع دبي',
    'استضافة ابوظبي',
    'استضافة الشارقة',
    'هوستينج الامارات',
    'سيرفر اماراتي',
    'دومين اماراتي',
    'نطاق .ae',
    'استضافة بالدرهم الاماراتي',
    'شركات استضافة الامارات',
    'استضافة دبي 2026',
    
    // === الأردن - Jordan ===
    'استضافة مواقع الاردن',
    'استضافة اردنية',
    'افضل استضافة في الاردن',
    'شركة استضافة اردنية',
    'استضافة مواقع عمان',
    'هوستينج الاردن',
    'سيرفر اردني',
    'دومين اردني',
    'نطاق .jo',
    'استضافة بالدينار الاردني',
    'شركات استضافة الاردن',
    
    // === الكويت - Kuwait ===
    'استضافة مواقع الكويت',
    'استضافة كويتية',
    'افضل استضافة في الكويت',
    'شركة استضافة كويتية',
    'هوستينج الكويت',
    'سيرفر كويتي',
    'دومين كويتي',
    'نطاق .kw',
    
    // === قطر - Qatar ===
    'استضافة مواقع قطر',
    'استضافة قطرية',
    'افضل استضافة في قطر',
    'استضافة الدوحة',
    'هوستينج قطر',
    'سيرفر قطري',
    'نطاق .qa',
    
    // === البحرين - Bahrain ===
    'استضافة مواقع البحرين',
    'استضافة بحرينية',
    'افضل استضافة في البحرين',
    'استضافة المنامة',
    'هوستينج البحرين',
    'نطاق .bh',
    
    // === عمان - Oman ===
    'استضافة مواقع عمان',
    'استضافة عمانية',
    'افضل استضافة في عمان',
    'استضافة مسقط',
    'هوستينج عمان',
    'نطاق .om',
    
    // === لبنان - Lebanon ===
    'استضافة مواقع لبنان',
    'استضافة لبنانية',
    'افضل استضافة في لبنان',
    'استضافة بيروت',
    'هوستينج لبنان',
    'نطاق .lb',
    
    // === العراق - Iraq ===
    'استضافة مواقع العراق',
    'استضافة عراقية',
    'افضل استضافة في العراق',
    'استضافة بغداد',
    'هوستينج العراق',
    'نطاق .iq',
    
    // === المغرب - Morocco ===
    'استضافة مواقع المغرب',
    'استضافة مغربية',
    'افضل استضافة في المغرب',
    'هوستينج المغرب',
    'نطاق .ma',
    
    // === الجزائر - Algeria ===
    'استضافة مواقع الجزائر',
    'استضافة جزائرية',
    'هوستينج الجزائر',
    'نطاق .dz',
    
    // === تونس - Tunisia ===
    'استضافة مواقع تونس',
    'استضافة تونسية',
    'هوستينج تونس',
    'نطاق .tn',
    
    // === ليبيا - Libya ===
    'استضافة مواقع ليبيا',
    'استضافة ليبية',
    'هوستينج ليبيا',
    
    // === السودان - Sudan ===
    'استضافة مواقع السودان',
    'استضافة سودانية',
    'هوستينج السودان',
    
    // === فلسطين - Palestine ===
    'استضافة مواقع فلسطين',
    'استضافة فلسطينية',
    'هوستينج فلسطين',
    
    // === اليمن - Yemen ===
    'استضافة مواقع اليمن',
    'استضافة يمنية',
    'هوستينج اليمن',
    
    // === الأسواق الغربية (Western Markets) ===
    // === أمريكا - USA ===
    'استضافة مواقع امريكا',
    'استضافة امريكية',
    'افضل استضافة في امريكا',
    'استضافة نيويورك',
    'استضافة كاليفورنيا',
    'استضافة تكساس',
    'هوستينج امريكي',
    'سيرفرات امريكية',
    'استضافة بالدولار',
    
    // === كندا - Canada ===
    'استضافة مواقع كندا',
    'استضافة كندية',
    'افضل استضافة في كندا',
    'استضافة تورنتو',
    'استضافة فانكوفر',
    'هوستينج كندي',
    'سيرفرات كندية',
    
    // === بريطانيا - UK ===
    'استضافة مواقع بريطانيا',
    'استضافة بريطانية',
    'افضل استضافة في بريطانيا',
    'استضافة لندن',
    'هوستينج انجليزي',
    'سيرفرات بريطانية',
    'استضافة المملكة المتحدة',
    
    // === ألمانيا - Germany ===
    'استضافة مواقع المانيا',
    'استضافة المانية',
    'افضل استضافة في المانيا',
    'استضافة فرانكفورت',
    'استضافة برلين',
    'هوستينج الماني',
    'سيرفرات المانية',
    
    // === فرنسا - France ===
    'استضافة مواقع فرنسا',
    'استضافة فرنسية',
    'افضل استضافة في فرنسا',
    'استضافة باريس',
    'هوستينج فرنسي',
    'سيرفرات فرنسية'
  ];

  const keywordsEn = [
    // === General Keywords 2026 ===
    'web hosting',
    'cloud hosting',
    'VPS servers',
    'dedicated servers',
    'domain registration',
    'WordPress hosting',
    'cheap hosting',
    'best hosting',
    'reliable hosting',
    'fast hosting',
    'free SSL certificate',
    'LiteSpeed hosting',
    'cPanel hosting',
    'free website migration',
    '24/7 support',
    'secure hosting',
    'NVMe SSD hosting',
    'DDoS protection',
    'unlimited bandwidth',
    'ecommerce hosting',
    'business hosting',
    'affordable hosting',
    'managed hosting',
    'reseller hosting',
    'email hosting',
    'Pro Gineous',
    'Middle East hosting',
    'MENA hosting',
    'Arab hosting',
    // New 2026 Keywords
    'AI hosting',
    'smart hosting',
    'best hosting 2026',
    'fastest web hosting 2026',
    'HTTP/3 hosting',
    'green hosting',
    'eco-friendly hosting',
    'carbon neutral hosting',
    
    // === Egypt ===
    'web hosting Egypt',
    'hosting in Egypt',
    'best hosting Egypt',
    'Egypt web hosting company',
    'Cairo hosting',
    'Alexandria hosting',
    'cheap hosting Egypt',
    'Egyptian hosting provider',
    '.eg domain',
    'hosting Egypt 2026',
    
    // === Saudi Arabia ===
    'web hosting Saudi Arabia',
    'hosting in Saudi Arabia',
    'best hosting Saudi Arabia',
    'Saudi web hosting company',
    'Riyadh hosting',
    'Jeddah hosting',
    'Dammam hosting',
    'Mecca hosting',
    'Medina hosting',
    'Saudi hosting provider',
    '.sa domain',
    'hosting KSA',
    'hosting Saudi 2026',
    
    // === UAE ===
    'web hosting UAE',
    'hosting in UAE',
    'best hosting UAE',
    'UAE web hosting company',
    'Dubai hosting',
    'Abu Dhabi hosting',
    'Sharjah hosting',
    'Emirates hosting provider',
    '.ae domain',
    'hosting Dubai 2026',
    
    // === Jordan ===
    'web hosting Jordan',
    'hosting in Jordan',
    'best hosting Jordan',
    'Amman hosting',
    'Jordan hosting provider',
    '.jo domain',
    
    // === Kuwait ===
    'web hosting Kuwait',
    'hosting in Kuwait',
    'best hosting Kuwait',
    'Kuwait City hosting',
    '.kw domain',
    
    // === Qatar ===
    'web hosting Qatar',
    'hosting in Qatar',
    'best hosting Qatar',
    'Doha hosting',
    '.qa domain',
    
    // === Bahrain ===
    'web hosting Bahrain',
    'hosting in Bahrain',
    'best hosting Bahrain',
    'Manama hosting',
    '.bh domain',
    
    // === Oman ===
    'web hosting Oman',
    'hosting in Oman',
    'best hosting Oman',
    'Muscat hosting',
    '.om domain',
    
    // === Lebanon ===
    'web hosting Lebanon',
    'hosting in Lebanon',
    'best hosting Lebanon',
    'Beirut hosting',
    '.lb domain',
    
    // === Iraq ===
    'web hosting Iraq',
    'hosting in Iraq',
    'best hosting Iraq',
    'Baghdad hosting',
    '.iq domain',
    
    // === Morocco ===
    'web hosting Morocco',
    'hosting in Morocco',
    '.ma domain',
    
    // === Algeria ===
    'web hosting Algeria',
    'hosting in Algeria',
    '.dz domain',
    
    // === Tunisia ===
    'web hosting Tunisia',
    'hosting in Tunisia',
    '.tn domain',
    
    // === Western Markets ===
    // === USA ===
    'web hosting USA',
    'hosting in USA',
    'best hosting USA',
    'US web hosting',
    'American hosting',
    'hosting United States',
    'New York hosting',
    'California hosting',
    'Texas hosting',
    'Los Angeles hosting',
    'Chicago hosting',
    'Houston hosting',
    'Phoenix hosting',
    'Seattle hosting',
    'Denver hosting',
    'Miami hosting',
    'US VPS hosting',
    'USA cloud hosting',
    'America server',
    'best hosting 2026 USA',
    'cheap hosting USA',
    'affordable hosting USA',
    '.us domain',
    '.com domain registration',
    
    // === Canada ===
    'web hosting Canada',
    'hosting in Canada',
    'best hosting Canada',
    'Canadian hosting',
    'Toronto hosting',
    'Vancouver hosting',
    'Montreal hosting',
    'Calgary hosting',
    'Ottawa hosting',
    'Canada VPS hosting',
    'Canada cloud hosting',
    'Canadian server',
    '.ca domain',
    'best hosting 2026 Canada',
    
    // === United Kingdom ===
    'web hosting UK',
    'hosting in UK',
    'best hosting UK',
    'UK web hosting',
    'British hosting',
    'London hosting',
    'Manchester hosting',
    'Birmingham hosting',
    'Edinburgh hosting',
    'Glasgow hosting',
    'UK VPS hosting',
    'UK cloud hosting',
    'British server',
    '.uk domain',
    '.co.uk domain',
    'best hosting 2026 UK',
    'cheap hosting UK',
    
    // === Germany ===
    'web hosting Germany',
    'hosting in Germany',
    'best hosting Germany',
    'German hosting',
    'Deutschland hosting',
    'Frankfurt hosting',
    'Berlin hosting',
    'Munich hosting',
    'Hamburg hosting',
    'Cologne hosting',
    'German VPS hosting',
    'Germany cloud hosting',
    'German server',
    '.de domain',
    'best hosting 2026 Germany',
    'GDPR compliant hosting',
    'European hosting',
    
    // === France ===
    'web hosting France',
    'hosting in France',
    'best hosting France',
    'French hosting',
    'France hébergement',
    'Paris hosting',
    'Lyon hosting',
    'Marseille hosting',
    'France VPS hosting',
    'France cloud hosting',
    'French server',
    '.fr domain',
    'best hosting 2026 France',
    
    // === General International ===
    'international web hosting',
    'global hosting provider',
    'worldwide hosting',
    'multi-location hosting',
    'global data centers',
    'international VPS',
    'global cloud hosting'
  ];

  return {
    title: {
      default: t.title,
      template: `%s | Pro Gineous`
    },
    description: t.description,
    icons: {
      icon: [
        { url: '/icon', sizes: '48x48', type: 'image/png' },
        { url: '/icon-192.png', sizes: '192x192', type: 'image/png' },
        { url: '/icon-512.png', sizes: '512x512', type: 'image/png' },
      ],
      shortcut: '/favicon.ico',
      apple: [
        { url: '/apple-icon', sizes: '180x180', type: 'image/png' },
      ],
      other: [
        {
          rel: 'mask-icon',
          url: '/icon.svg',
          color: '#1d71b8',
        },
      ],
    },
    keywords: locale === 'ar' ? keywordsAr : keywordsEn,
    authors: [{ name: 'Pro Gineous', url: 'https://progineous.com' }],
    creator: 'Pro Gineous',
    publisher: 'Pro Gineous',
    metadataBase: new URL('https://progineous.com'),
    openGraph: {
      type: 'website',
      locale: locale === 'ar' ? 'ar_SA' : 'en_US',
      url: locale === 'ar' ? 'https://progineous.com/ar' : 'https://progineous.com/en',
      title: t.title,
      description: t.description,
      siteName: 'Pro Gineous',
      images: [
        {
          url: `/api/og?title=${encodeURIComponent(t.title)}&description=${encodeURIComponent(t.description)}&locale=${locale}&page=home`,
          width: 1200,
          height: 630,
          alt: locale === 'ar' ? 'برو جينيوس - استضافة مواقع احترافية' : 'Pro Gineous - Professional Web Hosting'
        }
      ]
    },
    twitter: {
      card: 'summary_large_image',
      title: t.title,
      description: t.description,
      images: [`/api/og?title=${encodeURIComponent(t.title)}&description=${encodeURIComponent(t.description)}&locale=${locale}&page=home`],
      creator: '@progineous'
    },
    robots: {
      index: true,
      follow: true,
      googleBot: {
        index: true,
        follow: true,
        'max-video-preview': -1,
        'max-image-preview': 'large',
        'max-snippet': -1,
      },
    },
    alternates: {
      canonical: locale === 'ar' ? 'https://progineous.com/ar' : 'https://progineous.com/en',
      languages: {
        'ar-SA': 'https://progineous.com/ar',
        'en-US': 'https://progineous.com/en',
      }
    },
    verification: {
      google: 'googled64dfaff27eab96a',
    },
    category: 'technology',
  };
}

export default async function LocaleLayout({ children, params }: Props) {
  const { locale } = await params;

  if (!routing.locales.includes(locale as Locale)) {
    notFound();
  }

  setRequestLocale(locale);
  const messages = await getMessages();
  const dir = localeDirection[locale as Locale];

  // JSON-LD Organization Schema
  const organizationSchema = {
    '@context': 'https://schema.org',
    '@type': 'Organization',
    '@id': 'https://progineous.com/#organization',
    name: 'Pro Gineous',
    alternateName: 'برو جينيوس',
    url: 'https://progineous.com',
    logo: {
      '@type': 'ImageObject',
      url: 'https://progineous.com/images/logos/pro Gineous_white logo.svg',
      width: 200,
      height: 60,
    },
    image: 'https://progineous.com/og-image.svg',
    description: locale === 'ar' 
      ? 'شركة استضافة مواقع احترافية تقدم خدمات استضافة سحابية، VPS، سيرفرات مخصصة، وتسجيل نطاقات'
      : 'Professional web hosting company offering cloud hosting, VPS, dedicated servers, and domain registration',
    email: 'support@progineous.com',
    telephone: '+201070798859',
    address: {
      '@type': 'PostalAddress',
      addressCountry: 'EG',
      addressLocality: locale === 'ar' ? 'القاهرة' : 'Cairo',
      addressRegion: locale === 'ar' ? 'مصر' : 'Egypt',
    },
    areaServed: [
      // Middle East & North Africa (Primary Markets)
      { '@type': 'Country', name: 'Egypt' },
      { '@type': 'Country', name: 'Saudi Arabia' },
      { '@type': 'Country', name: 'United Arab Emirates' },
      { '@type': 'Country', name: 'Kuwait' },
      { '@type': 'Country', name: 'Qatar' },
      { '@type': 'Country', name: 'Bahrain' },
      { '@type': 'Country', name: 'Oman' },
      { '@type': 'Country', name: 'Jordan' },
      { '@type': 'Country', name: 'Lebanon' },
      { '@type': 'Country', name: 'Iraq' },
      { '@type': 'Country', name: 'Libya' },
      { '@type': 'Country', name: 'Sudan' },
      { '@type': 'Country', name: 'Morocco' },
      { '@type': 'Country', name: 'Algeria' },
      { '@type': 'Country', name: 'Tunisia' },
      { '@type': 'Country', name: 'Yemen' },
      { '@type': 'Country', name: 'Palestine' },
      { '@type': 'Country', name: 'Syria' },
      // North America
      { '@type': 'Country', name: 'United States' },
      { '@type': 'Country', name: 'Canada' },
      { '@type': 'Country', name: 'Mexico' },
      // Europe
      { '@type': 'Country', name: 'United Kingdom' },
      { '@type': 'Country', name: 'Germany' },
      { '@type': 'Country', name: 'France' },
      { '@type': 'Country', name: 'Italy' },
      { '@type': 'Country', name: 'Spain' },
      { '@type': 'Country', name: 'Netherlands' },
      { '@type': 'Country', name: 'Belgium' },
      { '@type': 'Country', name: 'Switzerland' },
      { '@type': 'Country', name: 'Austria' },
      { '@type': 'Country', name: 'Sweden' },
      { '@type': 'Country', name: 'Norway' },
      { '@type': 'Country', name: 'Denmark' },
      { '@type': 'Country', name: 'Finland' },
      { '@type': 'Country', name: 'Ireland' },
      { '@type': 'Country', name: 'Poland' },
      { '@type': 'Country', name: 'Portugal' },
      { '@type': 'Country', name: 'Greece' },
      { '@type': 'Country', name: 'Czech Republic' },
      { '@type': 'Country', name: 'Romania' },
      { '@type': 'Country', name: 'Hungary' },
      { '@type': 'Country', name: 'Turkey' },
      // Australia & New Zealand
      { '@type': 'Country', name: 'Australia' },
      { '@type': 'Country', name: 'New Zealand' },
    ],
    sameAs: [
      'https://twitter.com/progineous',
      'https://facebook.com/progineous',
      'https://linkedin.com/company/progineous',
      'https://instagram.com/progineous',
    ],
    contactPoint: [
      {
        '@type': 'ContactPoint',
        telephone: '+201070798859',
        contactType: 'customer service',
        availableLanguage: ['English', 'Arabic', 'French', 'German', 'Spanish'],
        areaServed: ['EG', 'SA', 'AE', 'KW', 'QA', 'BH', 'OM', 'JO', 'LB', 'IQ', 'LY', 'SD', 'MA', 'DZ', 'TN', 'YE', 'PS', 'SY', 'US', 'CA', 'MX', 'GB', 'DE', 'FR', 'IT', 'ES', 'NL', 'BE', 'CH', 'AT', 'SE', 'NO', 'DK', 'FI', 'IE', 'PL', 'PT', 'GR', 'CZ', 'RO', 'HU', 'TR', 'AU', 'NZ'],
      },
      {
        '@type': 'ContactPoint',
        telephone: '+201070798859',
        contactType: 'technical support',
        availableLanguage: ['English', 'Arabic', 'French', 'German', 'Spanish'],
        areaServed: ['EG', 'SA', 'AE', 'KW', 'QA', 'BH', 'OM', 'JO', 'LB', 'IQ', 'LY', 'SD', 'MA', 'DZ', 'TN', 'YE', 'PS', 'SY', 'US', 'CA', 'MX', 'GB', 'DE', 'FR', 'IT', 'ES', 'NL', 'BE', 'CH', 'AT', 'SE', 'NO', 'DK', 'FI', 'IE', 'PL', 'PT', 'GR', 'CZ', 'RO', 'HU', 'TR', 'AU', 'NZ'],
      },
      {
        '@type': 'ContactPoint',
        telephone: '+201070798859',
        contactType: 'sales',
        availableLanguage: ['English', 'Arabic', 'French', 'German', 'Spanish'],
        areaServed: ['EG', 'SA', 'AE', 'KW', 'QA', 'BH', 'OM', 'JO', 'LB', 'IQ', 'LY', 'SD', 'MA', 'DZ', 'TN', 'YE', 'PS', 'SY', 'US', 'CA', 'MX', 'GB', 'DE', 'FR', 'IT', 'ES', 'NL', 'BE', 'CH', 'AT', 'SE', 'NO', 'DK', 'FI', 'IE', 'PL', 'PT', 'GR', 'CZ', 'RO', 'HU', 'TR', 'AU', 'NZ'],
      },
    ],
    foundingDate: '2020',
    numberOfEmployees: {
      '@type': 'QuantitativeValue',
      minValue: 10,
      maxValue: 50,
    },
    slogan: locale === 'ar' ? 'استضافة احترافية لنجاح أعمالك' : 'Professional Hosting for Your Business Success',
    aggregateRating: {
      '@type': 'AggregateRating',
      ratingValue: '4.9',
      reviewCount: '2847',
      bestRating: '5',
      worstRating: '1',
    },
    hasOfferCatalog: {
      '@type': 'OfferCatalog',
      name: locale === 'ar' ? 'خدمات الاستضافة' : 'Hosting Services',
      itemListElement: [
        {
          '@type': 'Offer',
          itemOffered: {
            '@type': 'Service',
            name: locale === 'ar' ? 'استضافة مشتركة' : 'Shared Hosting',
          },
        },
        {
          '@type': 'Offer',
          itemOffered: {
            '@type': 'Service',
            name: locale === 'ar' ? 'استضافة سحابية' : 'Cloud Hosting',
          },
        },
        {
          '@type': 'Offer',
          itemOffered: {
            '@type': 'Service',
            name: locale === 'ar' ? 'سيرفرات VPS' : 'VPS Servers',
          },
        },
        {
          '@type': 'Offer',
          itemOffered: {
            '@type': 'Service',
            name: locale === 'ar' ? 'تسجيل نطاقات' : 'Domain Registration',
          },
        },
      ],
    },
  };

  // JSON-LD WebSite Schema with SearchAction
  const websiteSchema = {
    '@context': 'https://schema.org',
    '@type': 'WebSite',
    '@id': 'https://progineous.com/#website',
    url: 'https://progineous.com',
    name: 'Pro Gineous',
    alternateName: 'برو جينيوس',
    description: locale === 'ar'
      ? 'أفضل شركة استضافة مواقع في مصر والعالم العربي'
      : 'Best Web Hosting Company in Egypt and Arab World',
    publisher: {
      '@id': 'https://progineous.com/#organization',
    },
    inLanguage: [
      { '@type': 'Language', name: 'English', alternateName: 'en' },
      { '@type': 'Language', name: 'Arabic', alternateName: 'ar' },
    ],
    potentialAction: {
      '@type': 'SearchAction',
      target: {
        '@type': 'EntryPoint',
        urlTemplate: 'https://progineous.com/en/search?q={search_term_string}',
      },
      'query-input': 'required name=search_term_string',
    },
  };

  // JSON-LD LocalBusiness Schema for Arab World
  const localBusinessSchema = {
    '@context': 'https://schema.org',
    '@type': 'LocalBusiness',
    '@id': 'https://progineous.com/#localbusiness',
    name: locale === 'ar' ? 'برو جينيوس - استضافة مواقع' : 'Pro Gineous - Web Hosting',
    alternateName: ['برو جينيوس', 'Pro Gineous', 'برو جينيوس مصر', 'برو جينيوس السعودية', 'برو جينيوس الامارات'],
    description: locale === 'ar'
      ? 'أفضل شركة استضافة مواقع في مصر والسعودية والإمارات والأردن والعالم العربي - استضافة سحابية، VPS، سيرفرات مخصصة، تسجيل دومينات'
      : 'Best web hosting company in Egypt, Saudi Arabia, UAE, Jordan and Arab World - Cloud hosting, VPS, dedicated servers, domain registration',
    url: 'https://progineous.com',
    telephone: '+201070798859',
    email: 'support@progineous.com',
    image: 'https://progineous.com/images/logos/pro Gineous_white logo.svg',
    priceRange: '$$',
    address: {
      '@type': 'PostalAddress',
      streetAddress: locale === 'ar' ? 'القاهرة' : 'Cairo',
      addressLocality: locale === 'ar' ? 'القاهرة' : 'Cairo',
      addressRegion: locale === 'ar' ? 'القاهرة' : 'Cairo Governorate',
      postalCode: '11511',
      addressCountry: 'EG',
    },
    geo: {
      '@type': 'GeoCoordinates',
      latitude: 30.0444,
      longitude: 31.2357,
    },
    openingHoursSpecification: {
      '@type': 'OpeningHoursSpecification',
      dayOfWeek: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
      opens: '00:00',
      closes: '23:59',
    },
    aggregateRating: {
      '@type': 'AggregateRating',
      ratingValue: '4.9',
      reviewCount: '4523',
      bestRating: '5',
      worstRating: '1',
    },
    areaServed: [
      // === Egypt ===
      { '@type': 'Country', name: 'Egypt', '@id': 'https://www.wikidata.org/wiki/Q79' },
      { '@type': 'City', name: 'Cairo', '@id': 'https://www.wikidata.org/wiki/Q85' },
      { '@type': 'City', name: 'Alexandria', '@id': 'https://www.wikidata.org/wiki/Q87' },
      { '@type': 'City', name: 'Giza' },
      { '@type': 'City', name: 'Shubra El Kheima' },
      { '@type': 'City', name: 'Port Said' },
      { '@type': 'City', name: 'Suez' },
      { '@type': 'City', name: 'Luxor' },
      { '@type': 'City', name: 'Mansoura' },
      { '@type': 'City', name: 'Tanta' },
      { '@type': 'City', name: 'Hurghada' },
      { '@type': 'City', name: 'Sharm El Sheikh' },
      // === Saudi Arabia ===
      { '@type': 'Country', name: 'Saudi Arabia', '@id': 'https://www.wikidata.org/wiki/Q851' },
      { '@type': 'City', name: 'Riyadh', '@id': 'https://www.wikidata.org/wiki/Q3692' },
      { '@type': 'City', name: 'Jeddah', '@id': 'https://www.wikidata.org/wiki/Q5765' },
      { '@type': 'City', name: 'Mecca', '@id': 'https://www.wikidata.org/wiki/Q5806' },
      { '@type': 'City', name: 'Medina', '@id': 'https://www.wikidata.org/wiki/Q35484' },
      { '@type': 'City', name: 'Dammam' },
      { '@type': 'City', name: 'Khobar' },
      { '@type': 'City', name: 'Dhahran' },
      { '@type': 'City', name: 'Taif' },
      { '@type': 'City', name: 'Tabuk' },
      { '@type': 'City', name: 'Abha' },
      // === UAE ===
      { '@type': 'Country', name: 'United Arab Emirates', '@id': 'https://www.wikidata.org/wiki/Q878' },
      { '@type': 'City', name: 'Dubai', '@id': 'https://www.wikidata.org/wiki/Q612' },
      { '@type': 'City', name: 'Abu Dhabi', '@id': 'https://www.wikidata.org/wiki/Q613' },
      { '@type': 'City', name: 'Sharjah' },
      { '@type': 'City', name: 'Ajman' },
      { '@type': 'City', name: 'Ras Al Khaimah' },
      { '@type': 'City', name: 'Fujairah' },
      // === Jordan ===
      { '@type': 'Country', name: 'Jordan', '@id': 'https://www.wikidata.org/wiki/Q810' },
      { '@type': 'City', name: 'Amman', '@id': 'https://www.wikidata.org/wiki/Q3805' },
      { '@type': 'City', name: 'Zarqa' },
      { '@type': 'City', name: 'Irbid' },
      { '@type': 'City', name: 'Aqaba' },
      // === Kuwait ===
      { '@type': 'Country', name: 'Kuwait', '@id': 'https://www.wikidata.org/wiki/Q817' },
      { '@type': 'City', name: 'Kuwait City' },
      // === Qatar ===
      { '@type': 'Country', name: 'Qatar', '@id': 'https://www.wikidata.org/wiki/Q846' },
      { '@type': 'City', name: 'Doha', '@id': 'https://www.wikidata.org/wiki/Q3861' },
      // === Bahrain ===
      { '@type': 'Country', name: 'Bahrain', '@id': 'https://www.wikidata.org/wiki/Q398' },
      { '@type': 'City', name: 'Manama' },
      // === Oman ===
      { '@type': 'Country', name: 'Oman', '@id': 'https://www.wikidata.org/wiki/Q842' },
      { '@type': 'City', name: 'Muscat' },
      // === Lebanon ===
      { '@type': 'Country', name: 'Lebanon', '@id': 'https://www.wikidata.org/wiki/Q822' },
      { '@type': 'City', name: 'Beirut', '@id': 'https://www.wikidata.org/wiki/Q3820' },
      // === Iraq ===
      { '@type': 'Country', name: 'Iraq', '@id': 'https://www.wikidata.org/wiki/Q796' },
      { '@type': 'City', name: 'Baghdad', '@id': 'https://www.wikidata.org/wiki/Q1530' },
      { '@type': 'City', name: 'Basra' },
      { '@type': 'City', name: 'Erbil' },
      // === Morocco ===
      { '@type': 'Country', name: 'Morocco', '@id': 'https://www.wikidata.org/wiki/Q1028' },
      { '@type': 'City', name: 'Casablanca' },
      { '@type': 'City', name: 'Rabat' },
      { '@type': 'City', name: 'Marrakech' },
      // === Algeria ===
      { '@type': 'Country', name: 'Algeria', '@id': 'https://www.wikidata.org/wiki/Q262' },
      { '@type': 'City', name: 'Algiers' },
      // === Tunisia ===
      { '@type': 'Country', name: 'Tunisia', '@id': 'https://www.wikidata.org/wiki/Q948' },
      { '@type': 'City', name: 'Tunis' },
      // === Libya ===
      { '@type': 'Country', name: 'Libya' },
      { '@type': 'City', name: 'Tripoli' },
      // === Sudan ===
      { '@type': 'Country', name: 'Sudan' },
      { '@type': 'City', name: 'Khartoum' },
      // === Palestine ===
      { '@type': 'Country', name: 'Palestine' },
      // === Yemen ===
      { '@type': 'Country', name: 'Yemen' },
      { '@type': 'City', name: 'Sanaa' },
      // === Syria ===
      { '@type': 'Country', name: 'Syria' },
      { '@type': 'City', name: 'Damascus' },
      // === USA ===
      { '@type': 'Country', name: 'United States', '@id': 'https://www.wikidata.org/wiki/Q30' },
      { '@type': 'City', name: 'New York', '@id': 'https://www.wikidata.org/wiki/Q60' },
      { '@type': 'City', name: 'Los Angeles', '@id': 'https://www.wikidata.org/wiki/Q65' },
      { '@type': 'City', name: 'Chicago', '@id': 'https://www.wikidata.org/wiki/Q1297' },
      { '@type': 'City', name: 'Houston', '@id': 'https://www.wikidata.org/wiki/Q16555' },
      { '@type': 'City', name: 'Phoenix' },
      { '@type': 'City', name: 'Dallas' },
      { '@type': 'City', name: 'San Francisco' },
      { '@type': 'City', name: 'Seattle' },
      { '@type': 'City', name: 'Miami' },
      { '@type': 'City', name: 'Denver' },
      // === Canada ===
      { '@type': 'Country', name: 'Canada', '@id': 'https://www.wikidata.org/wiki/Q16' },
      { '@type': 'City', name: 'Toronto', '@id': 'https://www.wikidata.org/wiki/Q172' },
      { '@type': 'City', name: 'Vancouver', '@id': 'https://www.wikidata.org/wiki/Q24639' },
      { '@type': 'City', name: 'Montreal', '@id': 'https://www.wikidata.org/wiki/Q340' },
      { '@type': 'City', name: 'Calgary' },
      { '@type': 'City', name: 'Ottawa' },
      // === United Kingdom ===
      { '@type': 'Country', name: 'United Kingdom', '@id': 'https://www.wikidata.org/wiki/Q145' },
      { '@type': 'City', name: 'London', '@id': 'https://www.wikidata.org/wiki/Q84' },
      { '@type': 'City', name: 'Manchester', '@id': 'https://www.wikidata.org/wiki/Q18125' },
      { '@type': 'City', name: 'Birmingham', '@id': 'https://www.wikidata.org/wiki/Q2256' },
      { '@type': 'City', name: 'Glasgow' },
      { '@type': 'City', name: 'Edinburgh' },
      { '@type': 'City', name: 'Liverpool' },
      // === Germany ===
      { '@type': 'Country', name: 'Germany', '@id': 'https://www.wikidata.org/wiki/Q183' },
      { '@type': 'City', name: 'Berlin', '@id': 'https://www.wikidata.org/wiki/Q64' },
      { '@type': 'City', name: 'Frankfurt', '@id': 'https://www.wikidata.org/wiki/Q1794' },
      { '@type': 'City', name: 'Munich', '@id': 'https://www.wikidata.org/wiki/Q1726' },
      { '@type': 'City', name: 'Hamburg', '@id': 'https://www.wikidata.org/wiki/Q1055' },
      { '@type': 'City', name: 'Cologne' },
      { '@type': 'City', name: 'Düsseldorf' },
      // === France ===
      { '@type': 'Country', name: 'France', '@id': 'https://www.wikidata.org/wiki/Q142' },
      { '@type': 'City', name: 'Paris', '@id': 'https://www.wikidata.org/wiki/Q90' },
      { '@type': 'City', name: 'Lyon', '@id': 'https://www.wikidata.org/wiki/Q456' },
      { '@type': 'City', name: 'Marseille', '@id': 'https://www.wikidata.org/wiki/Q23482' },
      { '@type': 'City', name: 'Nice' },
      { '@type': 'City', name: 'Toulouse' },
    ],
    serviceType: [
      locale === 'ar' ? 'استضافة مواقع' : 'Web Hosting',
      locale === 'ar' ? 'استضافة سحابية' : 'Cloud Hosting',
      locale === 'ar' ? 'سيرفرات VPS' : 'VPS Servers',
      locale === 'ar' ? 'سيرفرات مخصصة' : 'Dedicated Servers',
      locale === 'ar' ? 'تسجيل دومينات' : 'Domain Registration',
      locale === 'ar' ? 'شهادات SSL' : 'SSL Certificates',
      locale === 'ar' ? 'استضافة بريد إلكتروني' : 'Email Hosting',
    ],
    paymentAccepted: [
      'Cash', 'Credit Card', 'Debit Card', 'Bank Transfer',
      // Egypt
      'Vodafone Cash', 'Fawry', 'InstaPay', 'Meeza',
      // Saudi Arabia
      'SADAD', 'Mada', 'STC Pay', 'Apple Pay',
      // UAE
      'Apple Pay UAE', 'Samsung Pay',
      // General
      'PayPal', 'Stripe'
    ],
    currenciesAccepted: ['EGP', 'SAR', 'AED', 'JOD', 'KWD', 'QAR', 'BHD', 'OMR', 'LBP', 'IQD', 'MAD', 'DZD', 'TND', 'USD', 'EUR'],
    sameAs: [
      'https://twitter.com/progineous',
      'https://facebook.com/progineous',
      'https://linkedin.com/company/progineous',
      'https://instagram.com/progineous',
    ],
  };

  return (
    <html lang={locale} dir={dir} suppressHydrationWarning className="light" style={{ colorScheme: 'light' }} data-scroll-behavior="smooth">
      <head>
        {/* Google Analytics (gtag.js) */}
        <Script
          src="https://www.googletagmanager.com/gtag/js?id=G-9317JZKCEX"
          strategy="afterInteractive"
        />
        <Script id="google-analytics" strategy="afterInteractive">
          {`
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', 'G-9317JZKCEX');
          `}
        </Script>

        {/* Microsoft Clarity - Heatmaps & Session Recordings */}
        <Script id="microsoft-clarity" strategy="afterInteractive">
          {`
            (function(c,l,a,r,i,t,y){
              c[a]=c[a]||function(){(c[a].q=c[a].q||[]).push(arguments)};
              t=l.createElement(r);t.async=1;t.src="https://www.clarity.ms/tag/"+i;
              y=l.getElementsByTagName(r)[0];y.parentNode.insertBefore(t,y);
            })(window, document, "clarity", "script", "n7pu56qjo1");
          `}
        </Script>
        
        {/* Preconnect for performance */}
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossOrigin="anonymous" />
        <link rel="dns-prefetch" href="https://fonts.googleapis.com" />
        <link rel="dns-prefetch" href="https://fonts.gstatic.com" />
        <link rel="dns-prefetch" href="https://www.google-analytics.com" />
        <link rel="dns-prefetch" href="https://www.googletagmanager.com" />
        <link rel="dns-prefetch" href="https://www.clarity.ms" />
        <link rel="dns-prefetch" href="https://widget.intercom.io" />
        
        {/* Resource Hints for Core Web Vitals */}
        <link rel="preload" href="/images/logos/pro Gineous_white logo.svg" as="image" type="image/svg+xml" />
        
        {/* Fonts with display swap for better LCP */}
        <link
          href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600;700;800&display=swap"
          rel="stylesheet"
        />
        
        {/* PWA & Mobile */}
        <link rel="manifest" href="/manifest.json" />
        <meta name="theme-color" content="#1d71b8" />
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <meta name="apple-mobile-web-app-status-bar-style" content="default" />
        <meta name="apple-mobile-web-app-title" content="Pro Gineous" />
        <meta name="mobile-web-app-capable" content="yes" />
        <meta name="application-name" content="Pro Gineous" />
        <meta name="msapplication-TileColor" content="#1d71b8" />
        <meta name="msapplication-config" content="/browserconfig.xml" />
        
        {/* OpenSearch */}
        <link rel="search" type="application/opensearchdescription+xml" title="Pro Gineous" href="/opensearch.xml" />
        
        {/* Geo Tags for Local SEO - Global Coverage */}
        <meta name="geo.region" content="EG, SA, AE, JO, KW, QA, BH, OM, LB, IQ, MA, DZ, TN, LY, SD, PS, YE, SY, US, CA, GB, DE, FR" />
        <meta name="geo.placename" content="Cairo, Riyadh, Dubai, Amman, Kuwait City, Doha, Manama, Muscat, Beirut, Baghdad, New York, Los Angeles, Toronto, London, Berlin, Paris" />
        <meta name="geo.position" content="30.0444;31.2357" />
        <meta name="ICBM" content="30.0444, 31.2357" />
        <meta name="distribution" content="global" />
        <meta name="target" content="Egypt, Cairo, Alexandria, Giza, Saudi Arabia, Riyadh, Jeddah, Dammam, Mecca, Medina, UAE, Dubai, Abu Dhabi, Sharjah, Jordan, Amman, Kuwait, Qatar, Doha, Bahrain, Manama, Oman, Muscat, Lebanon, Beirut, Iraq, Baghdad, Morocco, Casablanca, Algeria, Algiers, Tunisia, Tunis, Libya, Tripoli, Sudan, Khartoum, Palestine, Yemen, Syria, Damascus, USA, United States, New York, Los Angeles, Chicago, Houston, San Francisco, Seattle, Miami, Denver, Canada, Toronto, Vancouver, Montreal, Calgary, UK, United Kingdom, London, Manchester, Birmingham, Germany, Berlin, Frankfurt, Munich, Hamburg, France, Paris, Lyon, Marseille" />
        <meta name="audience" content="Egypt, Saudi Arabia, UAE, Jordan, Kuwait, Qatar, Bahrain, Oman, Lebanon, Iraq, Morocco, Algeria, Tunisia, Libya, Sudan, Palestine, Yemen, Syria, Middle East, North Africa, Arab World, GCC, USA, Canada, UK, Germany, France, Europe, North America, Worldwide" />
        <meta name="coverage" content="Middle East, North Africa, Arab World, GCC, USA, Canada, United Kingdom, Germany, France, Europe, North America, Worldwide" />
        <meta name="geo.country" content="EG, SA, AE, JO, KW, QA, BH, OM, LB, IQ, MA, DZ, TN, US, CA, GB, DE, FR" />
        <meta name="language" content="Arabic, English, German, French" />
        <meta name="revisit-after" content="1 day" />
        <meta name="rating" content="general" />
        <meta name="DC.language" content="ar-EG, ar-SA, ar-AE, ar-JO, ar-KW, ar-QA, ar-BH, ar-OM, ar-LB, ar-IQ, en-US, en-CA, en-GB, de-DE, fr-FR" />
        <meta name="DC.coverage" content="Egypt, Saudi Arabia, UAE, Jordan, Kuwait, Qatar, Bahrain, Oman, Lebanon, Iraq, Morocco, Algeria, Tunisia, Arab World, USA, Canada, UK, Germany, France, Europe, North America, Worldwide" />
        
        {/* Additional SEO Meta */}
        <meta name="format-detection" content="telephone=no" />
        <meta name="skype_toolbar" content="skype_toolbar_parser_compatible" />
        <meta httpEquiv="x-ua-compatible" content="IE=edge" />
        
        {/* JSON-LD Structured Data */}
        <script
          type="application/ld+json"
          dangerouslySetInnerHTML={{ __html: JSON.stringify(organizationSchema) }}
        />
        <script
          type="application/ld+json"
          dangerouslySetInnerHTML={{ __html: JSON.stringify(websiteSchema) }}
        />
        <script
          type="application/ld+json"
          dangerouslySetInnerHTML={{ __html: JSON.stringify(localBusinessSchema) }}
        />
      </head>
      <body className={`${dir === 'rtl' ? 'font-cairo' : 'font-inter'} antialiased`}>
        {/* TikTok Pixel Code */}
        <Script id="tiktok-pixel" strategy="afterInteractive">
          {`
            !function (w, d, t) {
              w.TiktokAnalyticsObject=t;var ttq=w[t]=w[t]||[];ttq.methods=["page","track","identify","instances","debug","on","off","once","ready","alias","group","enableCookie","disableCookie","holdConsent","revokeConsent","grantConsent"],ttq.setAndDefer=function(t,e){t[e]=function(){t.push([e].concat(Array.prototype.slice.call(arguments,0)))}};for(var i=0;i<ttq.methods.length;i++)ttq.setAndDefer(ttq,ttq.methods[i]);ttq.instance=function(t){for(
              var e=ttq._i[t]||[],n=0;n<ttq.methods.length;n++)ttq.setAndDefer(e,ttq.methods[n]);return e},ttq.load=function(e,n){var r="https://analytics.tiktok.com/i18n/pixel/events.js",o=n&&n.partner;ttq._i=ttq._i||{},ttq._i[e]=[],ttq._i[e]._u=r,ttq._t=ttq._t||{},ttq._t[e]=+new Date,ttq._o=ttq._o||{},ttq._o[e]=n||{};n=document.createElement("script")
              ;n.type="text/javascript",n.async=!0,n.src=r+"?sdkid="+e+"&lib="+t;e=document.getElementsByTagName("script")[0];e.parentNode.insertBefore(n,e)};
              ttq.load('D5A6Q4BC77UD75S4MT70');
              ttq.page();
            }(window, document, 'ttq');
          `}
        </Script>
        
        {/* Intercom Chat Widget */}
        <Script id="intercom-widget" strategy="afterInteractive">
          {`
            window.intercomSettings = {
              api_base: "https://api-iam.intercom.io",
              app_id: "i848b5ou",
            };
            (function(){var w=window;var ic=w.Intercom;if(typeof ic==="function"){ic('reattach_activator');ic('update',w.intercomSettings);}else{var d=document;var i=function(){i.c(arguments);};i.q=[];i.c=function(args){i.q.push(args);};w.Intercom=i;var l=function(){var s=d.createElement('script');s.type='text/javascript';s.async=true;s.src='https://widget.intercom.io/widget/i848b5ou';var x=d.getElementsByTagName('script')[0];x.parentNode.insertBefore(s,x);};if(document.readyState==='complete'){l();}else if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})();
          `}
        </Script>

        <NextIntlClientProvider messages={messages}>
          <PageLoader />
          <Snowfall />
          <NewYearCelebration />
          <LanguageSuggestion />
          <Navbar />
          <div className="flex min-h-screen flex-col w-full">
            <main className="flex-1">{children}</main>
            <Footer />
          </div>
        </NextIntlClientProvider>
      </body>
    </html>
  );
}
