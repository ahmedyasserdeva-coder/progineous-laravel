'use client';

import { useEffect, useState, useRef, useCallback } from 'react';
import { useLocale } from 'next-intl';
import { gsap } from '@/lib/gsap';
import { X, PartyPopper } from 'lucide-react';

export function NewYearCelebration() {
  const [isVisible, setIsVisible] = useState(true);
  const cardRef = useRef<HTMLDivElement>(null);
  const numberRefs = useRef<(HTMLSpanElement | null)[]>([]);
  const locale = useLocale();
  const isRTL = locale === 'ar';

  // GSAP Animations
  useEffect(() => {
    if (!cardRef.current) return;

    const ctx = gsap.context(() => {
      // Card entrance - slide up with bounce
      gsap.fromTo(
        cardRef.current,
        { y: 100, opacity: 0, scale: 0.95 },
        { y: 0, opacity: 1, scale: 1, duration: 0.6, ease: 'back.out(1.7)' }
      );

      // Animate each number with stagger
      numberRefs.current.forEach((ref, i) => {
        if (ref) {
          gsap.fromTo(
            ref,
            { y: 30, opacity: 0, rotateX: -90 },
            {
              y: 0,
              opacity: 1,
              rotateX: 0,
              duration: 0.5,
              delay: 0.3 + i * 0.1,
              ease: 'back.out(2)',
            }
          );
        }
      });

      // Subtle floating animation
      gsap.to(cardRef.current, {
        y: -5,
        duration: 2,
        repeat: -1,
        yoyo: true,
        ease: 'sine.inOut',
        delay: 1,
      });
    });

    // Auto close after 10 seconds
    const timer = setTimeout(handleClose, 10000);

    return () => {
      ctx.revert();
      clearTimeout(timer);
    };
  }, []);

  const handleClose = useCallback(() => {
    gsap.to(cardRef.current, {
      y: 100,
      opacity: 0,
      scale: 0.95,
      duration: 0.4,
      ease: 'power2.in',
      onComplete: () => setIsVisible(false),
    });
  }, []);

  if (!isVisible) return null;

  const yearDigits = ['2', '0', '2', '6'];

  const content = {
    ar: {
      greeting: 'سنة جديدة سعيدة',
      tagline: 'مع تحيات',
      brand: 'برو جينيوس',
    },
    en: {
      greeting: 'Happy New Year',
      tagline: 'From',
      brand: 'Pro Gineous',
    },
  };

  const t = content[locale as keyof typeof content] || content.en;

  return (
    <div className="fixed bottom-6 left-0 right-0 z-9999 flex justify-center px-4 pointer-events-none">
      {/* Main Card */}
      <div
        ref={cardRef}
        className="pointer-events-auto relative"
        dir={isRTL ? 'rtl' : 'ltr'}
      >
        <div 
          className="relative px-8 py-6 rounded-3xl overflow-hidden"
          style={{
            background: 'linear-gradient(145deg, #1e1e2e 0%, #2d2d44 100%)',
            boxShadow: '0 25px 50px -12px rgba(0, 0, 0, 0.5), 0 0 0 1px rgba(255, 255, 255, 0.1)',
          }}
        >
          {/* Gradient orbs */}
          <div className={`absolute -top-20 ${isRTL ? '-right-20' : '-left-20'} w-40 h-40 bg-blue-500/20 rounded-full blur-3xl`} />
          <div className={`absolute -bottom-20 ${isRTL ? '-left-20' : '-right-20'} w-40 h-40 bg-cyan-500/20 rounded-full blur-3xl`} />

          {/* Close button */}
          <button
            onClick={handleClose}
            className={`absolute top-3 ${isRTL ? 'left-3' : 'right-3'} text-gray-500 hover:text-white transition-colors rounded-full p-1 hover:bg-white/10`}
          >
            <X size={16} />
          </button>

          {/* Content */}
          <div className="relative flex items-center gap-6">
            {/* Icon */}
            <div className={`hidden sm:flex items-center justify-center w-16 h-16 rounded-2xl bg-linear-to-br from-blue-400 to-cyan-500 shadow-lg shadow-blue-500/25 ${isRTL ? 'order-last' : ''}`}>
              <PartyPopper className="w-8 h-8 text-white" />
            </div>

            <div className={`text-center ${isRTL ? 'sm:text-right' : 'sm:text-left'}`}>
              {/* Happy New Year */}
              <p className={`text-sm font-medium text-gray-400 mb-1 tracking-wide ${isRTL ? '' : 'uppercase'}`}>
                {t.greeting}
              </p>

              {/* Year with animated digits */}
              <div dir="ltr" className={`flex items-center justify-center ${isRTL ? 'sm:justify-end' : 'sm:justify-start'} gap-1`}>
                {yearDigits.map((digit, i) => (
                  <span
                    key={i}
                    ref={(el) => { numberRefs.current[i] = el; }}
                    className="inline-block text-5xl sm:text-6xl font-black"
                    style={{
                      background: 'linear-gradient(135deg, #60a5fa 0%, #3b82f6 50%, #60a5fa 100%)',
                      WebkitBackgroundClip: 'text',
                      WebkitTextFillColor: 'transparent',
                      textShadow: '0 0 40px rgba(59, 130, 246, 0.3)',
                    }}
                  >
                    {digit}
                  </span>
                ))}
              </div>

              {/* Tagline */}
              <p className="text-xs text-gray-500 mt-2">
                ✨ {t.tagline} <span className="text-blue-400 font-semibold">{t.brand}</span> {isRTL ? '' : 'with love'}
              </p>
            </div>

            {/* Decorative emoji */}
            <div className={`hidden md:block text-4xl animate-bounce ${isRTL ? 'order-first' : ''}`}>
              🎊
            </div>
          </div>
        </div>
      </div>
    </div>
  );
}
