'use client';

import { useLocale } from 'next-intl';
import { Link } from '@/i18n/routing';
import { 
  Server, 
  Cloud, 
  HardDrive, 
  Database,
  Globe2,
  ArrowRightLeft,
  ArrowRight
} from 'lucide-react';

export function FeaturesSection() {
  const locale = useLocale();

  const hostingPlans = [
    {
      icon: Server,
      title: locale === 'ar' ? 'استضافة مشتركة' : 'Shared Hosting',
      description: locale === 'ar' ? 'مثالية للمواقع الصغيرة والمدونات' : 'Perfect for small websites & blogs',
      price: '2',
      period: locale === 'ar' ? '/شهر' : '/month',
      href: '/hosting/shared',
      bgColor: 'bg-gradient-to-br from-blue-50 to-blue-100',
      iconBg: 'bg-[#1d71b8]',
      features: locale === 'ar' 
        ? ['مساحة SSD غير محدودة', 'شهادة SSL مجانية', 'نطاق ترددي غير محدود']
        : ['Unlimited SSD Storage', 'Free SSL Certificate', 'Unlimited Bandwidth']
    },
    {
      icon: Cloud,
      title: locale === 'ar' ? 'استضافة سحابية' : 'Cloud Hosting',
      description: locale === 'ar' ? 'قابلية توسع وأداء فائق' : 'Scalable & high performance',
      price: '4',
      period: locale === 'ar' ? '/شهر' : '/month',
      href: '/hosting/cloud',
      bgColor: 'bg-gradient-to-br from-purple-50 to-purple-100',
      iconBg: 'bg-purple-600',
      features: locale === 'ar' 
        ? ['موارد مخصصة', 'تحجيم تلقائي', 'نسخ احتياطي يومي']
        : ['Dedicated Resources', 'Auto Scaling', 'Daily Backups']
    },
    {
      icon: Globe2,
      title: locale === 'ar' ? 'استضافة الموزعين' : 'Reseller Hosting',
      description: locale === 'ar' ? 'ابدأ عملك في الاستضافة' : 'Start your hosting business',
      price: '20',
      period: locale === 'ar' ? '/شهر' : '/month',
      href: '/hosting/reseller',
      bgColor: 'bg-gradient-to-br from-cyan-50 to-cyan-100',
      iconBg: 'bg-cyan-600',
      features: locale === 'ar' 
        ? ['WHM/cPanel مجاني', 'علامة تجارية خاصة', 'حسابات غير محدودة']
        : ['Free WHM/cPanel', 'White Label Branding', 'Unlimited Accounts']
    },
    {
      icon: HardDrive,
      title: locale === 'ar' ? 'سيرفرات VPS' : 'VPS Hosting',
      description: locale === 'ar' ? 'تحكم كامل وأداء مضمون' : 'Full control & guaranteed performance',
      price: '14.99',
      period: locale === 'ar' ? '/شهر' : '/month',
      href: '/hosting/vps',
      bgColor: 'bg-gradient-to-br from-emerald-50 to-emerald-100',
      iconBg: 'bg-emerald-600',
      features: locale === 'ar' 
        ? ['صلاحيات Root كاملة', 'اختيار نظام التشغيل', 'IP مخصص']
        : ['Full Root Access', 'Choice of OS', 'Dedicated IP']
    },
    {
      icon: Database,
      title: locale === 'ar' ? 'سيرفرات مخصصة' : 'Dedicated Servers',
      description: locale === 'ar' ? 'قوة وأداء بدون حدود' : 'Unlimited power & performance',
      price: '140',
      period: locale === 'ar' ? '/شهر' : '/month',
      href: '/hosting/dedicated',
      bgColor: 'bg-gradient-to-br from-amber-50 to-amber-100',
      iconBg: 'bg-amber-600',
      features: locale === 'ar' 
        ? ['سيرفر كامل لك', 'أداء فائق السرعة', 'دعم فني متخصص']
        : ['Entire Server for You', 'Ultra-fast Performance', 'Expert Support']
    },
    {
      icon: ArrowRightLeft,
      title: locale === 'ar' ? 'انقل موقعك الآن' : 'Migrate Now',
      description: locale === 'ar' ? 'نقل مجاني بدون توقف' : 'Free migration with zero downtime',
      price: locale === 'ar' ? 'مجاناً' : 'FREE',
      period: '',
      href: '/migrate/hosting',
      bgColor: 'bg-gradient-to-br from-rose-50 to-rose-100',
      iconBg: 'bg-rose-600',
      features: locale === 'ar' 
        ? ['نقل بدون توقف', 'فريق متخصص', 'ضمان استعادة الأموال']
        : ['Zero Downtime', 'Expert Team', 'Money Back Guarantee'],
      isMigrate: true
    }
  ];

  return (
    <section id="hosting-plans" className="bg-white py-16 lg:py-20 overflow-hidden scroll-mt-20">
      <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        
        {/* Section Header */}
        <div className="text-center mb-12">
          <h2 className="text-2xl lg:text-3xl font-bold text-gray-900">
            {locale === 'ar' ? 'اختر خطة الاستضافة المناسبة لك' : 'Choose the Right Hosting Plan'}
          </h2>
          <p className="mt-3 text-gray-600 max-w-2xl mx-auto">
            {locale === 'ar' 
              ? 'نوفر لك حلول استضافة متنوعة تناسب جميع احتياجاتك، من المواقع الصغيرة إلى المشاريع الكبيرة'
              : 'We offer diverse hosting solutions for all your needs, from small websites to large projects'}
          </p>
        </div>

        {/* Hosting Plans Grid */}
        <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 lg:gap-6">
          {hostingPlans.map((plan, index) => (
            <Link
              key={index}
              href={plan.href}
              className={`group relative rounded-2xl ${plan.bgColor} p-6 transition-all duration-300 hover:shadow-xl hover:-translate-y-1 border border-gray-100`}
            >
              {/* Icon */}
              <div className={`inline-flex h-12 w-12 items-center justify-center rounded-xl ${plan.iconBg} shadow-lg`}>
                <plan.icon className="h-6 w-6 text-white" />
              </div>
              
              {/* Title & Description */}
              <h3 className="mt-4 text-lg font-bold text-gray-900">
                {plan.title}
              </h3>
              <p className="mt-1 text-sm text-gray-600">
                {plan.description}
              </p>
              
              {/* Price */}
              <div className="mt-4">
                <span className="text-xs text-gray-500">
                  {locale === 'ar' ? 'يبدأ من' : 'Starting at'}
                </span>
                <div className="flex items-baseline gap-0.5">
                  <span className="text-3xl font-bold text-gray-900">
                    ${plan.price}
                  </span>
                  <span className="text-sm text-gray-500">
                    {plan.period}
                  </span>
                </div>
              </div>

              {/* Features */}
              <ul className="mt-4 space-y-2">
                {plan.features.map((feature, idx) => (
                  <li key={idx} className="flex items-center gap-2 text-xs text-gray-600">
                    <span className="h-1 w-1 rounded-full bg-[#1d71b8]"></span>
                    {feature}
                  </li>
                ))}
              </ul>
              
              {/* Learn More Link */}
              <div className="mt-4 flex items-center gap-1 text-[#1d71b8] font-medium text-sm group-hover:gap-2 transition-all">
                {locale === 'ar' ? 'اعرف المزيد' : 'Learn more'}
                <ArrowRight className="h-4 w-4 rtl:rotate-180" />
              </div>
            </Link>
          ))}
        </div>

      </div>
    </section>
  );
}
