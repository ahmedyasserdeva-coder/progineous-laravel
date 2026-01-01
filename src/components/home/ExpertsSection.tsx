'use client';

import { useState, useEffect, useCallback } from 'react';
import { useLocale } from 'next-intl';
import { 
  Rocket,
  HeadphonesIcon,
  ArrowRightLeft,
  ShieldCheck,
  Server,
  ChevronLeft,
  ChevronRight
} from 'lucide-react';

export function ExpertsSection() {
  const locale = useLocale();
  const [currentSlide, setCurrentSlide] = useState(0);
  const [isAutoPlaying, setIsAutoPlaying] = useState(true);

  const slides = [
    {
      icon: Rocket,
      title: locale === 'ar' ? 'سرعة توربو أسرع 20 مرة' : 'Up to 20X faster turbo',
      description: locale === 'ar' 
        ? 'هذا يعني ترتيب أفضل في محركات البحث، معدلات ارتداد أقل ومعدلات تحويل أعلى!'
        : 'That means better SEO rankings, lower bounce rates & higher conversion rates!',
      iconBg: 'bg-orange-100',
      iconColor: 'text-orange-500'
    },
    {
      icon: HeadphonesIcon,
      title: locale === 'ar' ? 'دعم لا ينقطع أبداً' : 'Support that never clocks out',
      description: locale === 'ar' 
        ? 'فريقنا الداخلي متاح على مدار الساعة طوال أيام السنة. أشخاص حقيقيون جاهزون للمساعدة، سواء كان الوقت 3 مساءً أو 3 صباحاً.'
        : "Our in-house team is available 24/7/365. Real people ready to help, whether it's 3 p.m. or 3 a.m.",
      iconBg: 'bg-blue-100',
      iconColor: 'text-[#1d71b8]'
    },
    {
      icon: ArrowRightLeft,
      title: locale === 'ar' ? 'نقل الحساب مجاناً' : 'Free account migration',
      description: locale === 'ar' 
        ? 'لديك موقع بالفعل؟ دعنا نقوم بالعمل الشاق نيابةً عنك وننقله مجاناً! اسألنا كيف!'
        : 'Already have a Website? Let us do the hard work for you and transfer it for free! Ask us how!',
      iconBg: 'bg-emerald-100',
      iconColor: 'text-emerald-500'
    },
    {
      icon: ShieldCheck,
      title: locale === 'ar' ? 'ضمان استرداد الأموال' : 'Money-back guarantee',
      description: locale === 'ar' 
        ? 'جرّب خدمة الاستضافة عالية السرعة لدينا بدون أي مخاطر تماماً!'
        : 'Give our high-speed hosting service a try completely risk-free!',
      iconBg: 'bg-purple-100',
      iconColor: 'text-purple-500'
    },
    {
      icon: Server,
      title: locale === 'ar' ? 'التزام بوقت تشغيل 99.9%' : '99.9% uptime commitment',
      description: locale === 'ar' 
        ? 'progineous.com هو المضيف الذي يمكنك الاعتماد عليه مع خوادم فائقة الموثوقية!'
        : 'progineous.com is the host you can depend on with ultra-reliable servers!',
      iconBg: 'bg-red-100',
      iconColor: 'text-red-500'
    }
  ];

  const nextSlide = useCallback(() => {
    setCurrentSlide((prev) => (prev + 1) % slides.length);
  }, [slides.length]);

  const prevSlide = () => {
    setCurrentSlide((prev) => (prev - 1 + slides.length) % slides.length);
  };

  const goToSlide = (index: number) => {
    setCurrentSlide(index);
    setIsAutoPlaying(false);
    // Resume auto-play after 5 seconds of inactivity
    setTimeout(() => setIsAutoPlaying(true), 5000);
  };

  // Auto-play functionality
  useEffect(() => {
    if (!isAutoPlaying) return;
    const interval = setInterval(nextSlide, 4000);
    return () => clearInterval(interval);
  }, [isAutoPlaying, nextSlide]);

  // Get visible slides for desktop (show 3 at a time)
  const getVisibleSlides = () => {
    const result = [];
    for (let i = 0; i < 3; i++) {
      const index = (currentSlide + i) % slides.length;
      result.push({ ...slides[index], originalIndex: index });
    }
    return result;
  };

  return (
    <section className="bg-white py-16 lg:py-24">
      <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        
        {/* Section Header */}
        <div className="text-center max-w-4xl mx-auto mb-12 lg:mb-16">
          <h2 className="text-3xl lg:text-4xl font-bold text-gray-900 mb-6">
            {locale === 'ar' ? 'بُني بواسطة خبراء للخبراء' : 'Built by experts for experts'}
          </h2>
          <p className="text-lg text-gray-600 leading-relaxed">
            {locale === 'ar' 
              ? 'نحافظ على سرعة موقعك واستقراره وجاهزيته لأي شيء قادم. كل خطة تعمل على أجهزة قوية - معالجات AMD EPYC، تخزين Samsung NVMe، و Anycast DNS. مصمم للتوسع، سواء كان مدونة شخصية أو إمبراطورية تجارة إلكترونية عالمية.'
              : "We keep your site fast, stable, and ready for whatever's next. Every plan runs on serious hardware — AMD EPYC processors, Samsung NVMe storage, and Anycast DNS. Built to scale, so you're covered whether it's a personal blog or a global ecommerce empire."}
          </p>
        </div>

        {/* Slider Container */}
        <div className="relative">
          
          {/* Navigation Arrows */}
          <button 
            onClick={prevSlide}
            className="absolute left-0 top-1/2 -translate-y-1/2 -translate-x-4 lg:-translate-x-6 z-10 h-10 w-10 lg:h-12 lg:w-12 rounded-full bg-white shadow-lg flex items-center justify-center text-gray-600 hover:bg-gray-50 transition-colors"
            aria-label="Previous slide"
          >
            <ChevronLeft className="h-5 w-5 lg:h-6 lg:w-6" />
          </button>
          
          <button 
            onClick={nextSlide}
            className="absolute right-0 top-1/2 -translate-y-1/2 translate-x-4 lg:translate-x-6 z-10 h-10 w-10 lg:h-12 lg:w-12 rounded-full bg-white shadow-lg flex items-center justify-center text-gray-600 hover:bg-gray-50 transition-colors"
            aria-label="Next slide"
          >
            <ChevronRight className="h-5 w-5 lg:h-6 lg:w-6" />
          </button>

          {/* Desktop Slides (3 visible) */}
          <div className="hidden lg:grid lg:grid-cols-3 gap-6">
            {getVisibleSlides().map((slide, index) => (
              <div 
                key={`${slide.originalIndex}-${index}`}
                className="p-6 rounded-2xl bg-gray-50 border border-gray-100 transition-all duration-500"
              >
                {/* Icon */}
                <div className={`inline-flex h-14 w-14 items-center justify-center rounded-xl ${slide.iconBg}`}>
                  <slide.icon className={`h-7 w-7 ${slide.iconColor}`} />
                </div>
                
                {/* Content */}
                <h3 className="mt-5 text-xl font-bold text-gray-900">
                  {slide.title}
                </h3>
                <p className="mt-3 text-gray-600 leading-relaxed">
                  {slide.description}
                </p>
              </div>
            ))}
          </div>

          {/* Mobile/Tablet Single Slide */}
          <div className="lg:hidden">
            <div className="overflow-hidden">
              <div 
                className="flex transition-transform duration-500 ease-in-out"
                style={{ transform: `translateX(-${currentSlide * 100}%)` }}
              >
                {slides.map((slide, index) => (
                  <div 
                    key={index}
                    className="w-full flex-shrink-0 px-2"
                  >
                    <div className="p-6 rounded-2xl bg-gray-50 border border-gray-100">
                      {/* Icon */}
                      <div className={`inline-flex h-14 w-14 items-center justify-center rounded-xl ${slide.iconBg}`}>
                        <slide.icon className={`h-7 w-7 ${slide.iconColor}`} />
                      </div>
                      
                      {/* Content */}
                      <h3 className="mt-5 text-xl font-bold text-gray-900">
                        {slide.title}
                      </h3>
                      <p className="mt-3 text-gray-600 leading-relaxed">
                        {slide.description}
                      </p>
                    </div>
                  </div>
                ))}
              </div>
            </div>
          </div>

        </div>

        {/* Dots Navigation */}
        <div className="flex justify-center gap-2 mt-8">
          {slides.map((_, index) => (
            <button
              key={index}
              onClick={() => goToSlide(index)}
              className={`h-2.5 rounded-full transition-all duration-300 ${
                index === currentSlide 
                  ? 'w-8 bg-[#1d71b8]' 
                  : 'w-2.5 bg-gray-300 hover:bg-gray-400'
              }`}
              aria-label={`Go to slide ${index + 1}`}
            />
          ))}
        </div>

      </div>
    </section>
  );
}
