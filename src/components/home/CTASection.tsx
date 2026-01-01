'use client';

import { useTranslations, useLocale } from 'next-intl';
import { ArrowRight, Rocket } from 'lucide-react';

export function CTASection() {
  const t = useTranslations('cta');
  const locale = useLocale();

  return (
    <section className="bg-white py-16 lg:py-24">
      <div className="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
        
        {/* Card */}
        <div className="relative overflow-hidden rounded-3xl bg-gradient-to-br from-[#1d71b8] to-blue-700 p-8 lg:p-12 text-center shadow-2xl">
          
          {/* Background Pattern */}
          <div className="absolute inset-0 opacity-10">
            <svg className="h-full w-full" xmlns="http://www.w3.org/2000/svg">
              <defs>
                <pattern
                  id="grid-cta"
                  width="40"
                  height="40"
                  patternUnits="userSpaceOnUse"
                >
                  <path
                    d="M 40 0 L 0 0 0 40"
                    fill="none"
                    stroke="white"
                    strokeWidth="1"
                  />
                </pattern>
              </defs>
              <rect width="100%" height="100%" fill="url(#grid-cta)" />
            </svg>
          </div>

          {/* Decorative circles */}
          <div className="absolute -top-10 -right-10 w-40 h-40 bg-white/10 rounded-full blur-2xl"></div>
          <div className="absolute -bottom-10 -left-10 w-40 h-40 bg-white/10 rounded-full blur-2xl"></div>

          <div className="relative">
            {/* Icon */}
            <div className="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-white/20 backdrop-blur">
              <Rocket className="h-8 w-8 text-white" />
            </div>

            {/* Content */}
            <h2 className="mt-6 text-2xl lg:text-3xl font-bold text-white">
              {t('title')}
            </h2>
            <p className="mt-3 text-base lg:text-lg text-white/80 max-w-xl mx-auto">
              {t('subtitle')}
            </p>

            {/* CTA Button */}
            <a
              href="https://app.progineous.com/register.php"
              target="_blank"
              rel="noopener noreferrer"
              className="group mt-8 inline-flex items-center gap-2 rounded-xl bg-white px-8 py-4 text-base lg:text-lg font-semibold text-[#1d71b8] shadow-lg transition-all hover:shadow-xl hover:bg-gray-50"
            >
              {t('button')}
              <ArrowRight className="h-5 w-5 transition-transform group-hover:translate-x-1 rtl:rotate-180 rtl:group-hover:-translate-x-1" />
            </a>

            {/* Trust Badges */}
            <div className="mt-8 flex flex-wrap items-center justify-center gap-6 text-white/70 text-sm">
              <div className="flex items-center gap-2">
                <svg className="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                  <path
                    fillRule="evenodd"
                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                    clipRule="evenodd"
                  />
                </svg>
                {locale === 'ar' ? 'ضمان 30 يوم' : '30-Day Money Back'}
              </div>
              <div className="flex items-center gap-2">
                <svg className="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                  <path
                    fillRule="evenodd"
                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                    clipRule="evenodd"
                  />
                </svg>
                {locale === 'ar' ? 'نقل مجاني' : 'Free Migration'}
              </div>
            </div>
          </div>

        </div>

      </div>
    </section>
  );
}
