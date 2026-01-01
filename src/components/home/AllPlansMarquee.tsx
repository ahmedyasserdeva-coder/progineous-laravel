'use client';

import { useEffect, useRef } from 'react';
import { useLocale } from 'next-intl';
import { gsap } from 'gsap';
import { 
  Globe, 
  Server, 
  Zap, 
  Database, 
  Lock, 
  RefreshCw, 
  Shield, 
  HardDrive, 
  Mail 
} from 'lucide-react';

export function AllPlansMarquee() {
  const locale = useLocale();
  const sectionRef = useRef<HTMLDivElement>(null);

  useEffect(() => {
    if (!sectionRef.current) return;
    
    const ctx = gsap.context(() => {
      const row1Container = sectionRef.current?.querySelector('.marquee-row-1-container');
      const row2Container = sectionRef.current?.querySelector('.marquee-row-2-container');
      const row1 = sectionRef.current?.querySelector('.marquee-row-1');
      const row2 = sectionRef.current?.querySelector('.marquee-row-2');
      const isRTL = locale === 'ar';
      
      // Rotation animation for both rows - same direction, swinging slowly
      if (row1Container && row2Container) {
        gsap.to([row1Container, row2Container], {
          rotation: 2,
          duration: 8,
          ease: 'sine.inOut',
          yoyo: true,
          repeat: -1,
        });
      }
      
      if (row1) {
        gsap.to(row1, {
          x: isRTL ? '25%' : '-25%',
          duration: 30,
          ease: 'none',
          repeat: -1,
        });
      }
      
      // Row 2 moves in opposite direction
      if (row2) {
        gsap.to(row2, {
          x: isRTL ? '-25%' : '25%',
          duration: 35,
          ease: 'none',
          repeat: -1,
        });
      }
    }, sectionRef);
    
    return () => ctx.revert();
  }, [locale]);

  const row1Features = [
    { icon: Globe, text: locale === 'ar' ? 'دومين .com مجاني' : 'Free .com Domain' },
    { icon: Server, text: locale === 'ar' ? 'لوحة تحكم cPanel' : 'cPanel Control Panel' },
    { icon: Zap, text: locale === 'ar' ? 'تثبيت ووردبريس بنقرة' : 'One-click WordPress' },
    { icon: Database, text: locale === 'ar' ? 'Rails, Python, Perl' : 'Rails, Python, Perl' },
    { icon: Globe, text: locale === 'ar' ? 'نطاق ترددي غير محدود' : 'Unlimited Bandwidth' },
    { icon: Lock, text: locale === 'ar' ? 'شهادات SSL مجانية' : 'Free SSL' },
    { icon: RefreshCw, text: locale === 'ar' ? 'ضمان 30 يوم' : '30-Day Guarantee' },
    { icon: Shield, text: locale === 'ar' ? 'حماية DDoS' : 'DDoS Protection' },
  ];

  const row2Features = [
    { icon: Zap, text: locale === 'ar' ? 'سيرفر LiteSpeed' : 'LiteSpeed Server' },
    { icon: HardDrive, text: locale === 'ar' ? 'قوالب مجانية' : 'Free Templates' },
    { icon: RefreshCw, text: locale === 'ar' ? 'نقل موقع مجاني' : 'Free Migration' },
    { icon: Database, text: locale === 'ar' ? 'نسخ احتياطي تلقائي' : 'Auto Backup' },
    { icon: Globe, text: locale === 'ar' ? 'دعم IPv4' : 'IPv4 Support' },
    { icon: HardDrive, text: locale === 'ar' ? 'تخزين سحابي' : 'Cloud Storage' },
    { icon: Mail, text: locale === 'ar' ? 'خدمة البريد' : 'E-mail Service' },
  ];

  return (
    <section ref={sectionRef} className="py-12 lg:py-16 bg-white overflow-hidden">
      <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div className="text-center mb-10">
          <h2 className="text-2xl font-bold text-gray-900 sm:text-3xl">
            {locale === 'ar' ? 'جميع الخطط تشمل' : 'All Plans Include'}
          </h2>
        </div>
      </div>

      {/* Marquee Row 1 */}
      <div className="relative mb-4 overflow-hidden marquee-row-1-container" style={{ transform: 'rotate(-2deg)' }}>
        <div className="marquee-row-1 flex gap-4" style={{ width: 'max-content' }}>
          {[...Array(4)].map((_, repeatIndex) => (
            <div key={repeatIndex} className="flex gap-4 shrink-0">
              {row1Features.map((feature, index) => (
                <div
                  key={`${repeatIndex}-${index}`}
                  className="flex items-center gap-3 px-5 py-3 rounded-full bg-gray-50 border border-gray-100 hover:bg-[#1d71b8]/5 hover:border-[#1d71b8]/20 transition-colors group whitespace-nowrap"
                >
                  <div className="w-8 h-8 rounded-full bg-[#1d71b8]/10 flex items-center justify-center group-hover:bg-[#1d71b8]/20 transition-colors shrink-0">
                    <feature.icon className="h-4 w-4 text-[#1d71b8]" />
                  </div>
                  <span className="text-sm font-medium text-gray-700">{feature.text}</span>
                </div>
              ))}
            </div>
          ))}
        </div>
      </div>

      {/* Marquee Row 2 - Moves opposite direction */}
      <div className="relative overflow-hidden flex justify-end marquee-row-2-container" style={{ transform: 'rotate(-2deg)' }}>
        <div className="marquee-row-2 flex gap-4" style={{ width: 'max-content' }}>
          {[...Array(4)].map((_, repeatIndex) => (
            <div key={repeatIndex} className="flex gap-4 shrink-0">
              {row2Features.map((feature, index) => (
                <div
                  key={`${repeatIndex}-${index}`}
                  className="flex items-center gap-3 px-5 py-3 rounded-full bg-gray-50 border border-gray-100 hover:bg-[#1d71b8]/5 hover:border-[#1d71b8]/20 transition-colors group whitespace-nowrap"
                >
                  <div className="w-8 h-8 rounded-full bg-[#1d71b8]/10 flex items-center justify-center group-hover:bg-[#1d71b8]/20 transition-colors shrink-0">
                    <feature.icon className="h-4 w-4 text-[#1d71b8]" />
                  </div>
                  <span className="text-sm font-medium text-gray-700">{feature.text}</span>
                </div>
              ))}
            </div>
          ))}
        </div>
      </div>
    </section>
  );
}
