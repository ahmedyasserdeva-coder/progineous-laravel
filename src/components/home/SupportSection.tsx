'use client';

import { useLocale } from 'next-intl';
import Link from 'next/link';

export function SupportSection() {
  const locale = useLocale();

  return (
    <section className="bg-white py-16 lg:py-24">
      <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        
        <div className="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 items-center">
          
          {/* Content Side */}
          <div className={locale === 'ar' ? 'lg:order-2' : 'lg:order-1'}>
            <h2 className="text-3xl lg:text-4xl font-bold text-gray-900 mb-6">
              {locale === 'ar' ? 'الدعم الفني؟ نحن هنا دائماً.' : "Tech support? We're always here."}
            </h2>
            <p className="text-lg text-gray-600 leading-relaxed mb-8">
              {locale === 'ar' 
                ? 'مهندسونا الخبراء في progineous.com متاحون على مدار الساعة طوال أيام الأسبوع، يقدمون معرفة تقنية عميقة لمساعدتك في اختيار الخطة المناسبة، وتهيئتها لأفضل أداء، والحفاظ على تشغيل موقعك بسلاسة.'
                : 'Our expert progineous.com engineers are available 24/7, bringing deep technical knowledge to help you choose the right plan, configure it for peak performance, and keep your site running flawlessly.'}
            </p>
            
            <Link 
              href={`/${locale}/contact`}
              className="inline-flex items-center justify-center px-6 py-3 rounded-xl bg-emerald-100 hover:bg-emerald-200 text-emerald-700 font-semibold transition-colors"
            >
              {locale === 'ar' ? 'تواصل معنا' : "Let's talk"}
            </Link>
          </div>

          {/* Chat Mockup Side */}
          <div className={locale === 'ar' ? 'lg:order-1' : 'lg:order-2'}>
            <div className="relative rounded-2xl overflow-hidden bg-gradient-to-br from-teal-600 via-teal-500 to-lime-400 p-6 lg:p-8 min-h-[400px]">
              
              {/* Chat Messages */}
              <div className="space-y-6">
                
                {/* Customer Message */}
                <div className="flex items-start gap-3">
                  <div className="flex-shrink-0 w-10 h-10 rounded-full bg-amber-200 overflow-hidden flex items-center justify-center">
                    <svg className="w-6 h-6 text-amber-600" fill="currentColor" viewBox="0 0 24 24">
                      <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                    </svg>
                  </div>
                  <div>
                    <div className="bg-white/90 backdrop-blur-sm rounded-2xl rounded-tl-sm px-4 py-3 max-w-xs">
                      <p className="text-gray-800 text-sm">
                        {locale === 'ar' 
                          ? 'مرحباً، كيف أضيف أدوات جديدة لموقعي؟'
                          : 'Hi, how do I add feature tools to my website?'}
                      </p>
                    </div>
                    <p className="text-white/70 text-xs mt-1.5 ml-2">
                      {locale === 'ar' ? 'سارة • منذ دقيقتين' : 'Holly • 2 mins ago'}
                    </p>
                  </div>
                </div>

                {/* Support Response */}
                <div className="flex flex-col items-end">
                  <div className="bg-white/20 backdrop-blur-sm rounded-2xl rounded-tr-sm px-4 py-3 max-w-xs">
                    <p className="text-white text-sm">
                      {locale === 'ar' 
                        ? 'مرحباً سارة، سأكون سعيداً بمساعدتك - لن يستغرق الأمر وقتاً على الإطلاق لتشغيل موقعك.'
                        : "Hi Holly, I'll be happy to help - it'll take no time at all to get you up and running."}
                    </p>
                  </div>
                  <p className="text-white/70 text-xs mt-1.5 mr-2">
                    {locale === 'ar' ? 'أحمد • منذ دقيقة' : 'Jason • 1 min ago'}
                  </p>
                </div>

                {/* Second Support Message */}
                <div className="flex items-end gap-3 justify-end">
                  <div className="bg-white/90 backdrop-blur-sm rounded-2xl rounded-br-sm px-4 py-3 max-w-xs">
                    <p className="text-gray-800 text-sm">
                      {locale === 'ar' ? 'إليك كيفية القيام بذلك' : "Here's how to do it"}
                    </p>
                  </div>
                  <div className="flex-shrink-0 w-10 h-10 rounded-full bg-teal-200 overflow-hidden flex items-center justify-center">
                    <svg className="w-6 h-6 text-teal-600" fill="currentColor" viewBox="0 0 24 24">
                      <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                    </svg>
                  </div>
                </div>

                {/* Typing Indicator */}
                <div className="flex items-center gap-3 justify-end">
                  <div className="flex items-center gap-2">
                    <span className="text-white/70 text-xs">
                      {locale === 'ar' ? 'أحمد يكتب...' : 'Jason is typing...'}
                    </span>
                    <div className="flex-shrink-0 w-8 h-8 rounded-full bg-teal-200 overflow-hidden flex items-center justify-center">
                      <svg className="w-5 h-5 text-teal-600" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                      </svg>
                    </div>
                  </div>
                </div>

              </div>

            </div>
          </div>

        </div>

      </div>
    </section>
  );
}
