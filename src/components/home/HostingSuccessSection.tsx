'use client';

import { useLocale } from 'next-intl';
import { Link } from '@/i18n/routing';
import { 
  Zap,
  Shield,
  Headphones,
  Clock,
  Server,
  Globe2,
  ArrowRight,
  CheckCircle
} from 'lucide-react';

export function HostingSuccessSection() {
  const locale = useLocale();

  const features = [
    {
      icon: Zap,
      title: locale === 'ar' ? 'سرعة فائقة' : 'Blazing Fast Speed',
      description: locale === 'ar' 
        ? 'سيرفرات NVMe SSD عالية الأداء مع أحدث التقنيات لضمان سرعة تحميل فائقة لموقعك'
        : 'High-performance NVMe SSD servers with cutting-edge technology for lightning-fast loading'
    },
    {
      icon: Shield,
      title: locale === 'ar' ? 'حماية متقدمة' : 'Advanced Security',
      description: locale === 'ar' 
        ? 'حماية DDoS متقدمة، جدار حماية ذكي، وفحص البرمجيات الخبيثة على مدار الساعة'
        : 'Advanced DDoS protection, smart firewall, and 24/7 malware scanning'
    },
    {
      icon: Clock,
      title: locale === 'ar' ? 'وقت تشغيل 99.9%' : '99.9% Uptime',
      description: locale === 'ar' 
        ? 'ضمان وقت تشغيل بنسبة 99.9% مع مراقبة مستمرة للسيرفرات'
        : '99.9% uptime guarantee with continuous server monitoring'
    },
    {
      icon: Headphones,
      title: locale === 'ar' ? 'دعم فني 24/7' : '24/7 Expert Support',
      description: locale === 'ar' 
        ? 'فريق دعم فني متخصص متاح على مدار الساعة لمساعدتك في أي وقت'
        : 'Expert support team available around the clock to help you anytime'
    },
    {
      icon: Server,
      title: locale === 'ar' ? 'نسخ احتياطي يومي' : 'Daily Backups',
      description: locale === 'ar' 
        ? 'نسخ احتياطي تلقائي يومي لجميع ملفاتك وقواعد البيانات مع استعادة سهلة'
        : 'Automatic daily backups for all your files and databases with easy restoration'
    },
    {
      icon: Globe2,
      title: locale === 'ar' ? 'شهادة SSL مجانية' : 'Free SSL Certificate',
      description: locale === 'ar' 
        ? 'شهادة SSL مجانية لجميع المواقع لحماية بيانات زوارك وتحسين SEO'
        : 'Free SSL certificate for all websites to secure visitor data and boost SEO'
    }
  ];

  const stats = [
    { value: '50K+', label: locale === 'ar' ? 'موقع مستضاف' : 'Websites Hosted' },
    { value: '99.9%', label: locale === 'ar' ? 'وقت التشغيل' : 'Uptime' },
    { value: '24/7', label: locale === 'ar' ? 'دعم فني' : 'Support' },
    { value: '15+', label: locale === 'ar' ? 'مركز بيانات' : 'Data Centers' }
  ];

  return (
    <section className="bg-gray-50 py-16 lg:py-24">
      <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        
        {/* Section Header */}
        <div className="text-center max-w-3xl mx-auto mb-12 lg:mb-16">
          <h2 className="text-3xl lg:text-4xl font-bold text-gray-900">
            {locale === 'ar' ? 'استضافة مواقع مصممة للنجاح' : 'Website hosting built for success'}
          </h2>
          <p className="mt-4 text-lg text-gray-600">
            {locale === 'ar' 
              ? 'خدمات الاستضافة المتميزة التي تحتاجها لبناء موقع سريع وناجح. ابدأ مع استضافة الويب في دقائق معدودة.'
              : 'The premium hosting services you need to build a fast and successful website. Get started with web hosting in just minutes.'}
          </p>
        </div>

        {/* Stats Row */}
        <div className="grid grid-cols-2 md:grid-cols-4 gap-6 mb-16">
          {stats.map((stat, index) => (
            <div key={index} className="text-center p-6 rounded-2xl bg-white shadow-sm border border-gray-100">
              <div className="text-3xl lg:text-4xl font-bold text-[#1d71b8]">{stat.value}</div>
              <div className="mt-1 text-sm text-gray-600">{stat.label}</div>
            </div>
          ))}
        </div>

        {/* Features Grid */}
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
          {features.map((feature, index) => (
            <div key={index} className="flex items-start gap-4 p-6 rounded-2xl bg-white shadow-sm border border-gray-100 transition-all hover:shadow-md">
              <div className="flex h-12 w-12 items-center justify-center rounded-xl bg-[#1d71b8]/10 text-[#1d71b8] flex-shrink-0">
                <feature.icon className="h-6 w-6" />
              </div>
              <div>
                <h3 className="font-semibold text-gray-900">
                  {feature.title}
                </h3>
                <p className="mt-2 text-sm text-gray-600">
                  {feature.description}
                </p>
              </div>
            </div>
          ))}
        </div>

        {/* CTA */}
        <div className="mt-12 text-center">
          <Link
            href="/hosting/shared"
            className="inline-flex items-center gap-2 px-8 py-4 bg-[#1d71b8] hover:bg-[#155a94] text-white font-semibold rounded-xl transition-colors shadow-lg shadow-[#1d71b8]/25"
          >
            {locale === 'ar' ? 'ابدأ الآن' : 'Get Started Now'}
            <ArrowRight className="h-5 w-5 rtl:rotate-180" />
          </Link>
        </div>

      </div>
    </section>
  );
}
