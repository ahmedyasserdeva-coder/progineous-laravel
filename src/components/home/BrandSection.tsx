'use client';

import { useLocale } from 'next-intl';
import Image from 'next/image';

export function BrandSection() {
  const locale = useLocale();

  return (
    <section className="bg-gray-50 py-16 lg:py-24">
      <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        
        <div className="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center">
          
          {/* Content Side */}
          <div className={locale === 'ar' ? 'lg:order-2' : 'lg:order-1'}>
            <h2 className="text-3xl lg:text-4xl font-bold text-gray-900 mb-6">
              {locale === 'ar' ? 'من وراء العلامة التجارية' : "Who's behind the brand"}
            </h2>
            <p className="text-lg text-gray-600 leading-relaxed mb-8">
              {locale === 'ar' 
                ? 'progineous.com مبني بواسطة أشخاص يؤمنون أن الاستضافة يجب أن تكون موثوقة مثل التقنية التي تدعمها. نجمع بين عقود من الخبرة في المجال مع نهج تفكير مستقبلي، لخلق حلول تعمل للشركات من جميع الأحجام. من أصحاب المواقع المبتدئين إلى المؤسسات العالمية، لدينا التقنية والفريق لدعمك.'
                : "progineous.com is built by people who believe hosting should be as reliable as the technology behind it. We combine decades of industry experience with a forward-thinking approach, creating solutions that work for businesses of every size. From first-time site owners to global enterprises, we've got the tech and the team to support you."}
            </p>
            
            {/* Stats */}
            <div className="grid grid-cols-3 gap-6">
              <div>
                <div className="text-3xl lg:text-4xl font-bold text-[#1d71b8]">15+</div>
                <div className="text-sm text-gray-500 mt-1">
                  {locale === 'ar' ? 'سنوات خبرة' : 'Years Experience'}
                </div>
              </div>
              <div>
                <div className="text-3xl lg:text-4xl font-bold text-[#1d71b8]">50K+</div>
                <div className="text-sm text-gray-500 mt-1">
                  {locale === 'ar' ? 'عميل سعيد' : 'Happy Clients'}
                </div>
              </div>
              <div>
                <div className="text-3xl lg:text-4xl font-bold text-[#1d71b8]">24/7</div>
                <div className="text-sm text-gray-500 mt-1">
                  {locale === 'ar' ? 'دعم متواصل' : 'Support'}
                </div>
              </div>
            </div>
          </div>

          {/* Mockup Side */}
          <div className={locale === 'ar' ? 'lg:order-1' : 'lg:order-2'}>
            <div className="relative">
              {/* Browser Mockup */}
              <div className="bg-white rounded-2xl shadow-2xl overflow-hidden border border-gray-200">
                {/* Browser Header */}
                <div className="bg-gray-100 px-4 py-3 flex items-center gap-2">
                  <div className="flex gap-1.5">
                    <div className="w-3 h-3 rounded-full bg-red-400"></div>
                    <div className="w-3 h-3 rounded-full bg-yellow-400"></div>
                    <div className="w-3 h-3 rounded-full bg-green-400"></div>
                  </div>
                  <div className="flex-1 mx-4">
                    <div className="bg-white rounded-lg px-4 py-1.5 text-sm text-gray-500 flex items-center gap-2">
                      <svg className="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fillRule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clipRule="evenodd" />
                      </svg>
                      progineous.com
                    </div>
                  </div>
                </div>
                
                {/* Browser Content */}
                <div className="p-6 lg:p-8">
                  {/* Dashboard Preview */}
                  <div className="space-y-4">
                    {/* Header */}
                    <div className="flex items-center justify-between">
                      <div className="flex items-center gap-3">
                        <div className="w-10 h-10 rounded-xl bg-[#1d71b8] flex items-center justify-center">
                          <span className="text-white font-bold text-lg">P</span>
                        </div>
                        <div>
                          <div className="font-semibold text-gray-900">Pro Gineous</div>
                          <div className="text-xs text-gray-500">Hosting Dashboard</div>
                        </div>
                      </div>
                      <div className="flex gap-2">
                        <div className="w-8 h-8 rounded-lg bg-gray-100"></div>
                        <div className="w-8 h-8 rounded-lg bg-gray-100"></div>
                      </div>
                    </div>

                    {/* Stats Cards */}
                    <div className="grid grid-cols-3 gap-3">
                      <div className="p-3 rounded-xl bg-emerald-50">
                        <div className="text-xs text-emerald-600 mb-1">Uptime</div>
                        <div className="text-lg font-bold text-gray-900">99.9%</div>
                      </div>
                      <div className="p-3 rounded-xl bg-blue-50">
                        <div className="text-xs text-blue-600 mb-1">Speed</div>
                        <div className="text-lg font-bold text-gray-900">0.2s</div>
                      </div>
                      <div className="p-3 rounded-xl bg-purple-50">
                        <div className="text-xs text-purple-600 mb-1">Storage</div>
                        <div className="text-lg font-bold text-gray-900">45%</div>
                      </div>
                    </div>

                    {/* Server Status */}
                    <div className="p-4 rounded-xl bg-gray-50">
                      <div className="flex items-center justify-between mb-3">
                        <span className="text-sm font-medium text-gray-700">Server Status</span>
                        <span className="flex items-center gap-1.5 text-xs text-emerald-600">
                          <span className="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                          All Systems Operational
                        </span>
                      </div>
                      <div className="space-y-2">
                        <div className="h-2 rounded-full bg-gray-200 overflow-hidden">
                          <div className="h-full w-3/4 rounded-full bg-[#1d71b8]"></div>
                        </div>
                        <div className="h-2 rounded-full bg-gray-200 overflow-hidden">
                          <div className="h-full w-1/2 rounded-full bg-emerald-500"></div>
                        </div>
                      </div>
                    </div>

                    {/* Quick Actions */}
                    <div className="flex gap-2">
                      <div className="flex-1 py-2 px-3 rounded-lg bg-[#1d71b8] text-white text-sm font-medium text-center">
                        Manage Sites
                      </div>
                      <div className="flex-1 py-2 px-3 rounded-lg bg-gray-100 text-gray-700 text-sm font-medium text-center">
                        View Analytics
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              {/* Floating Elements */}
              <div className="absolute -top-4 -right-4 w-20 h-20 bg-[#1d71b8]/10 rounded-full blur-2xl"></div>
              <div className="absolute -bottom-4 -left-4 w-32 h-32 bg-emerald-500/10 rounded-full blur-2xl"></div>
              
              {/* Floating Badge */}
              <div className="absolute -bottom-3 -right-3 lg:bottom-8 lg:-right-6 bg-white rounded-xl shadow-lg p-3 border border-gray-100">
                <div className="flex items-center gap-2">
                  <div className="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center">
                    <svg className="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M5 13l4 4L19 7" />
                    </svg>
                  </div>
                  <div>
                    <div className="text-xs font-medium text-gray-900">SSL Secured</div>
                    <div className="text-[10px] text-gray-500">256-bit encryption</div>
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
