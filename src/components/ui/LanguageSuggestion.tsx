'use client';

import { useState, useEffect } from 'react';
import { useParams, useRouter } from 'next/navigation';
import { X, Globe } from 'lucide-react';

// قائمة الدول العربية (رموز ISO)
const ARABIC_COUNTRIES = [
  'EG', 'SA', 'AE', 'KW', 'QA', 'BH', 'OM', 'JO', 'LB', 'SY', 
  'IQ', 'YE', 'PS', 'LY', 'TN', 'DZ', 'MA', 'SD', 'MR', 'DJ', 
  'SO', 'KM'
];

// قائمة أكواد اللغة العربية
const ARABIC_LANGUAGE_CODES = ['ar', 'ar-EG', 'ar-SA', 'ar-AE', 'ar-KW', 'ar-QA', 'ar-BH', 'ar-OM', 'ar-JO', 'ar-LB', 'ar-SY', 'ar-IQ', 'ar-YE', 'ar-PS', 'ar-LY', 'ar-TN', 'ar-DZ', 'ar-MA', 'ar-SD'];

export function LanguageSuggestion() {
  const [isVisible, setIsVisible] = useState(false);
  const [isClosing, setIsClosing] = useState(false);
  const params = useParams();
  const router = useRouter();
  const locale = (params?.locale as string) || 'en';

  useEffect(() => {
    // لا تظهر الرسالة إذا كان المستخدم يتصفح بالعربية بالفعل
    if (locale === 'ar') return;

    // تحقق إذا كان المستخدم قد رفض العرض سابقاً
    const dismissed = localStorage.getItem('language-suggestion-dismissed');
    if (dismissed) return;

    // تحقق من لغة المتصفح أولاً
    const browserLanguages = navigator.languages || [navigator.language];
    const hasArabicLanguage = browserLanguages.some(lang => 
      ARABIC_LANGUAGE_CODES.some(arCode => lang.toLowerCase().startsWith(arCode.toLowerCase()))
    );

    if (hasArabicLanguage) {
      // تأخير قليل لتحسين تجربة المستخدم
      setTimeout(() => setIsVisible(true), 1500);
      return;
    }

    // إذا لم تكن لغة المتصفح عربية، تحقق من الموقع الجغرافي
    checkLocation();
  }, [locale]);

  const checkLocation = async () => {
    try {
      // استخدام خدمة مجانية للحصول على معلومات الموقع
      const response = await fetch('https://ipapi.co/json/', {
        signal: AbortSignal.timeout(5000) // timeout بعد 5 ثواني
      });
      
      if (response.ok) {
        const data = await response.json();
        if (ARABIC_COUNTRIES.includes(data.country_code)) {
          setTimeout(() => setIsVisible(true), 1500);
        }
      }
    } catch {
      // في حالة فشل الاتصال، تحقق من لغة المتصفح فقط
      console.log('Could not detect location');
    }
  };

  const handleSwitchToArabic = () => {
    // احصل على المسار الحالي بدون اللغة
    const currentPath = window.location.pathname;
    const pathWithoutLocale = currentPath.replace(/^\/(en|ar)/, '');
    
    // انتقل إلى النسخة العربية
    router.push(`/ar${pathWithoutLocale || '/'}`);
    handleClose();
  };

  const handleClose = () => {
    setIsClosing(true);
    setTimeout(() => {
      setIsVisible(false);
      setIsClosing(false);
    }, 300);
  };

  const handleDismiss = () => {
    localStorage.setItem('language-suggestion-dismissed', 'true');
    handleClose();
  };

  if (!isVisible) return null;

  return (
    <div 
      className={`fixed bottom-4 left-4 z-50 max-w-sm transition-all duration-300 ${
        isClosing 
          ? 'opacity-0 translate-x-[-100%]' 
          : 'opacity-100 translate-x-0'
      }`}
      dir="rtl"
    >
      <div className="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl border border-gray-200 dark:border-gray-700 overflow-hidden">
        {/* Header */}
        <div className="bg-gradient-to-r from-[#1d71b8] to-[#0d4a7a] px-4 py-3 flex items-center justify-between">
          <div className="flex items-center gap-2 text-white">
            <Globe className="w-5 h-5" />
            <span className="font-semibold">اللغة العربية</span>
          </div>
          <button
            onClick={handleDismiss}
            className="text-white/80 hover:text-white transition-colors p-1 hover:bg-white/10 rounded-full"
            aria-label="إغلاق"
          >
            <X className="w-4 h-4" />
          </button>
        </div>

        {/* Content */}
        <div className="p-4">
          <p className="text-gray-700 dark:text-gray-300 text-sm mb-4 leading-relaxed">
            مرحباً! 👋 يبدو أنك من منطقة عربية. هل تريد تصفح الموقع باللغة العربية؟
          </p>

          <div className="flex gap-2">
            <button
              onClick={handleSwitchToArabic}
              className="flex-1 bg-[#1d71b8] hover:bg-[#0d4a7a] text-white font-medium py-2.5 px-4 rounded-xl transition-colors text-sm"
            >
              نعم، العربية
            </button>
            <button
              onClick={handleDismiss}
              className="flex-1 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 font-medium py-2.5 px-4 rounded-xl transition-colors text-sm"
            >
              لا، شكراً
            </button>
          </div>
        </div>
      </div>
    </div>
  );
}
