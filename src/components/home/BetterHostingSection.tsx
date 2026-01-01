'use client';

import { useLocale } from 'next-intl';
import { 
  Rocket,
  HeadphonesIcon,
  ShieldCheck,
  Zap,
  Settings,
  Globe
} from 'lucide-react';

export function BetterHostingSection() {
  const locale = useLocale();

  const mainFeature = {
    icon: Rocket,
    title: locale === 'ar' ? 'أداء فائق السرعة' : 'Blazing Fast Performance',
    description: locale === 'ar' 
      ? 'منصتنا مُحسّنة للسرعة مع تقنية LiteSpeed للتخزين المؤقت وإدارة ذكية للموارد، مما يضمن تشغيل موقعك بسلاسة وكفاءة.'
      : 'Our platform is tuned for speed with LiteSpeed caching and smart resource management, ensuring your site runs smoothly.',
    tags: locale === 'ar' 
      ? ['LiteSpeed', 'NVMe SSD', 'تخزين مؤقت ذكي'] 
      : ['LiteSpeed', 'NVMe SSD', 'Smart Caching']
  };

  const smallFeatures = [
    {
      icon: ShieldCheck,
      title: locale === 'ar' ? 'أمان متقدم' : 'Advanced Security',
      description: locale === 'ar' ? 'Imunify360 + CloudLinux' : 'Imunify360 + CloudLinux',
      iconBg: 'bg-blue-50',
      iconColor: 'text-[#1d71b8]'
    },
    {
      icon: Zap,
      title: locale === 'ar' ? 'سرعة فائقة' : 'Blazing Fast',
      description: locale === 'ar' ? 'LiteSpeed + NVMe SSD' : 'LiteSpeed + NVMe SSD',
      iconBg: 'bg-amber-50',
      iconColor: 'text-amber-500'
    },
    {
      icon: Settings,
      title: locale === 'ar' ? 'WHM/cPanel' : 'WHM/cPanel',
      description: locale === 'ar' ? 'لوحة تحكم قوية' : 'Powerful panel',
      iconBg: 'bg-blue-50',
      iconColor: 'text-[#1d71b8]'
    },
    {
      icon: HeadphonesIcon,
      title: locale === 'ar' ? 'دعم 24/7' : '24/7 Support',
      description: locale === 'ar' ? 'فريق متخصص' : 'Expert team',
      iconBg: 'bg-red-50',
      iconColor: 'text-red-500'
    }
  ];

  const bottomFeature = {
    icon: Globe,
    title: locale === 'ar' ? 'Cloudflare CDN' : 'Cloudflare CDN',
    description: locale === 'ar' ? 'شبكة عالمية لتسريع مواقعك' : 'Global network to speed up your websites'
  };

  return (
    <section className="bg-gray-50 py-16 lg:py-24">
      <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        
        {/* Section Header */}
        <div className="text-center max-w-3xl mx-auto mb-12 lg:mb-16">
          <h2 className="text-3xl lg:text-4xl font-bold text-gray-900">
            {locale === 'ar' ? 'كل ما تحتاجه' : 'Everything You Need'}
          </h2>
        </div>

        {/* Main Grid Layout */}
        <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
          
          {/* Left Column - Main Feature Card */}
          <div className="row-span-2">
            <div className="h-full p-8 lg:p-10 rounded-2xl bg-gradient-to-br from-[#1d71b8] to-blue-600 text-white">
              {/* Icon */}
              <div className="inline-flex h-14 w-14 items-center justify-center rounded-xl bg-white/20 backdrop-blur-sm">
                <mainFeature.icon className="h-7 w-7 text-white" />
              </div>
              
              {/* Content */}
              <h3 className="mt-8 text-2xl lg:text-3xl font-bold">
                {mainFeature.title}
              </h3>
              <p className="mt-4 text-blue-100 leading-relaxed text-lg">
                {mainFeature.description}
              </p>
              
              {/* Tags */}
              <div className="mt-8 flex flex-wrap gap-3">
                {mainFeature.tags.map((tag, index) => (
                  <span 
                    key={index}
                    className="px-4 py-2 rounded-full bg-white/20 backdrop-blur-sm text-sm font-medium"
                  >
                    {tag}
                  </span>
                ))}
              </div>
            </div>
          </div>

          {/* Right Column - Small Features Grid */}
          <div className="grid grid-cols-2 gap-4">
            {smallFeatures.map((feature, index) => (
              <div 
                key={index} 
                className="p-5 rounded-2xl bg-white border border-gray-100"
              >
                {/* Icon */}
                <div className={`inline-flex h-12 w-12 items-center justify-center rounded-xl ${feature.iconBg}`}>
                  <feature.icon className={`h-6 w-6 ${feature.iconColor}`} />
                </div>
                
                {/* Content */}
                <h3 className="mt-4 text-base font-bold text-gray-900">
                  {feature.title}
                </h3>
                <p className="mt-1 text-sm text-gray-500">
                  {feature.description}
                </p>
              </div>
            ))}
          </div>

        </div>

        {/* Bottom Feature Card */}
        <div className="mt-6">
          <div className="lg:w-1/2 p-5 rounded-2xl bg-white border border-gray-100 flex items-center gap-4">
            {/* Icon */}
            <div className="flex-shrink-0 inline-flex h-12 w-12 items-center justify-center rounded-xl bg-teal-50">
              <bottomFeature.icon className="h-6 w-6 text-teal-600" />
            </div>
            
            {/* Content */}
            <div>
              <h3 className="text-base font-bold text-gray-900">
                {bottomFeature.title}
              </h3>
              <p className="text-sm text-gray-500">
                {bottomFeature.description}
              </p>
            </div>
          </div>
        </div>

      </div>
    </section>
  );
}
