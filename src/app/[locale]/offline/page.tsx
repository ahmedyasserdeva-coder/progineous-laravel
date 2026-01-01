'use client';

import { useParams } from 'next/navigation';
import { motion } from 'framer-motion';

export default function OfflinePage() {
  const params = useParams();
  const locale = (params?.locale as string) || 'en';
  const isArabic = locale === 'ar';

  const content = {
    ar: {
      title: 'أنت غير متصل بالإنترنت',
      description: 'يبدو أنك فقدت الاتصال بالإنترنت. تحقق من اتصالك وحاول مرة أخرى.',
      tips: 'نصائح:',
      tipsList: [
        'تحقق من اتصال WiFi الخاص بك',
        'تأكد من أن بيانات الهاتف مفعّلة',
        'حاول إعادة تشغيل جهاز الراوتر',
        'تحقق من إعدادات الشبكة',
      ],
      retry: 'إعادة المحاولة',
      cachedPages: 'الصفحات المحفوظة',
    },
    en: {
      title: "You're Offline",
      description: "It looks like you've lost your internet connection. Check your connection and try again.",
      tips: 'Tips:',
      tipsList: [
        'Check your WiFi connection',
        'Make sure mobile data is enabled',
        'Try restarting your router',
        'Check your network settings',
      ],
      retry: 'Try Again',
      cachedPages: 'Cached Pages',
    },
  };

  const t = isArabic ? content.ar : content.en;

  const handleRetry = () => {
    window.location.reload();
  };

  return (
    <div className="min-h-screen bg-linear-to-br from-slate-900 via-gray-800 to-slate-900 flex items-center justify-center px-4 py-20">
      {/* Background Elements */}
      <div className="absolute inset-0 overflow-hidden">
        <div className="absolute top-1/4 left-1/4 w-96 h-96 bg-gray-500/10 rounded-full blur-3xl" />
        <div className="absolute bottom-1/4 right-1/4 w-96 h-96 bg-slate-500/10 rounded-full blur-3xl" />
      </div>

      <div className="relative z-10 text-center max-w-2xl mx-auto">
        {/* Offline Icon */}
        <motion.div
          initial={{ opacity: 0, scale: 0.5 }}
          animate={{ opacity: 1, scale: 1 }}
          transition={{ duration: 0.5 }}
          className="relative mb-8"
        >
          <div className="w-32 h-32 mx-auto bg-linear-to-br from-gray-600 to-slate-700 rounded-full flex items-center justify-center shadow-2xl">
            <motion.div
              animate={{ 
                opacity: [1, 0.5, 1],
              }}
              transition={{ 
                duration: 2,
                repeat: Infinity,
              }}
              className="text-6xl"
            >
              
            </motion.div>
          </div>
          {/* Disconnected indicator */}
          <div className="absolute -bottom-2 -right-2 w-10 h-10 bg-red-500 rounded-full flex items-center justify-center">
            <svg className="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={3} d="M6 18L18 6M6 6l12 12" />
            </svg>
          </div>
        </motion.div>

        {/* Title */}
        <motion.h1
          initial={{ opacity: 0, y: 20 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ delay: 0.2 }}
          className="text-3xl md:text-4xl font-bold text-white mb-4"
        >
          {t.title}
        </motion.h1>

        {/* Description */}
        <motion.p
          initial={{ opacity: 0, y: 20 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ delay: 0.3 }}
          className="text-gray-400 text-lg mb-8"
        >
          {t.description}
        </motion.p>

        {/* Tips */}
        <motion.div
          initial={{ opacity: 0, y: 20 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ delay: 0.4 }}
          className="bg-white/5 border border-white/10 rounded-2xl p-6 mb-8 text-left"
        >
          <h3 className="text-white font-semibold mb-4">{t.tips}</h3>
          <ul className="space-y-3">
            {t.tipsList.map((tip, index) => (
              <li key={index}>
                <motion.div
                  initial={{ opacity: 0, x: -20 }}
                  animate={{ opacity: 1, x: 0 }}
                  transition={{ delay: 0.5 + index * 0.1 }}
                  className="flex items-center gap-3 text-gray-400"
                >
                  <span className="w-6 h-6 bg-blue-500/20 text-blue-400 rounded-full flex items-center justify-center text-sm">
                    {index + 1}
                  </span>
                  {tip}
                </motion.div>
              </li>
            ))}
          </ul>
        </motion.div>

        {/* Retry Button */}
        <motion.div
          initial={{ opacity: 0, y: 20 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ delay: 0.6 }}
        >
          <button
            onClick={handleRetry}
            className="inline-flex items-center gap-2 px-8 py-4 bg-linear-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold rounded-xl transition-all transform hover:scale-105 shadow-lg shadow-blue-500/25"
          >
            <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
            </svg>
            {t.retry}
          </button>
        </motion.div>

        {/* Network Status Indicator */}
        <motion.div
          initial={{ opacity: 0 }}
          animate={{ opacity: 1 }}
          transition={{ delay: 0.7 }}
          className="mt-8 flex justify-center items-center gap-2 text-gray-500 text-sm"
        >
          <span className="w-2 h-2 bg-red-500 rounded-full animate-pulse" />
          Offline
        </motion.div>
      </div>
    </div>
  );
}


