'use client';

import Link from 'next/link';
import { useParams } from 'next/navigation';
import { motion } from 'framer-motion';

export default function NotFound() {
  const params = useParams();
  const locale = (params?.locale as string) || 'en';
  const isArabic = locale === 'ar';

  const content = {
    ar: {
      code: '404',
      title: 'الصفحة غير موجودة',
      description: 'عذراً، الصفحة التي تبحث عنها غير موجودة أو تم نقلها أو حذفها.',
      suggestions: 'ربما تريد زيارة:',
      home: 'الصفحة الرئيسية',
      hosting: 'خدمات الاستضافة',
      domains: 'تسجيل النطاقات',
      contact: 'تواصل معنا',
      backHome: 'العودة للرئيسية',
    },
    en: {
      code: '404',
      title: 'Page Not Found',
      description: "Sorry, the page you're looking for doesn't exist, has been moved, or has been deleted.",
      suggestions: 'You might want to visit:',
      home: 'Home Page',
      hosting: 'Hosting Services',
      domains: 'Domain Registration',
      contact: 'Contact Us',
      backHome: 'Back to Home',
    },
  };

  const t = isArabic ? content.ar : content.en;

  return (
    <div className="min-h-screen bg-gradient-to-br from-slate-900 via-blue-900 to-slate-900 flex items-center justify-center px-4 py-20">
      {/* Background Elements */}
      <div className="absolute inset-0 overflow-hidden">
        <div className="absolute top-1/4 left-1/4 w-96 h-96 bg-blue-500/10 rounded-full blur-3xl" />
        <div className="absolute bottom-1/4 right-1/4 w-96 h-96 bg-blue-500/10 rounded-full blur-3xl" />
      </div>

      <div className="relative z-10 text-center max-w-2xl mx-auto">
        {/* 404 Number */}
        <motion.div
          initial={{ opacity: 0, scale: 0.5 }}
          animate={{ opacity: 1, scale: 1 }}
          transition={{ duration: 0.5 }}
          className="relative"
        >
          <span className="text-[180px] md:text-[250px] font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-blue-500 leading-none select-none">
            {t.code}
          </span>
          <div className="absolute inset-0 flex items-center justify-center">
            <motion.div
              animate={{ 
                rotate: [0, 10, -10, 0],
                y: [0, -10, 0]
              }}
              transition={{ 
                duration: 2,
                repeat: Infinity,
                repeatType: "reverse"
              }}
              className="text-6xl md:text-8xl"
            >
              
            </motion.div>
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

        {/* Suggestions */}
        <motion.div
          initial={{ opacity: 0, y: 20 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ delay: 0.4 }}
          className="mb-8"
        >
          <p className="text-gray-500 mb-4">{t.suggestions}</p>
          <div className="flex flex-wrap justify-center gap-3">
            <Link
              href={`/${locale}`}
              className="px-4 py-2 bg-white/10 hover:bg-white/20 text-white rounded-lg transition-colors"
            >
              {t.home}
            </Link>
            <Link
              href={`/${locale}/hosting/shared`}
              className="px-4 py-2 bg-white/10 hover:bg-white/20 text-white rounded-lg transition-colors"
            >
              {t.hosting}
            </Link>
            <Link
              href={`/${locale}/domains`}
              className="px-4 py-2 bg-white/10 hover:bg-white/20 text-white rounded-lg transition-colors"
            >
              {t.domains}
            </Link>
            <Link
              href={`/${locale}/contact`}
              className="px-4 py-2 bg-white/10 hover:bg-white/20 text-white rounded-lg transition-colors"
            >
              {t.contact}
            </Link>
          </div>
        </motion.div>

        {/* Back Home Button */}
        <motion.div
          initial={{ opacity: 0, y: 20 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ delay: 0.5 }}
        >
          <Link
            href={`/${locale}`}
            className="inline-flex items-center gap-2 px-8 py-4 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold rounded-xl transition-all transform hover:scale-105 shadow-lg shadow-blue-500/25"
          >
            <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            {t.backHome}
          </Link>
        </motion.div>
      </div>
    </div>
  );
}


