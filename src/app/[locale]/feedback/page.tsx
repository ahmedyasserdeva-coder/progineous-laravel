'use client';

import { useState } from 'react';
import { useLocale } from 'next-intl';
import { 
  Star, 
  Send, 
  Gift, 
  CheckCircle, 
  Sparkles,
  Copy,
  Check,
  ThumbsUp,
  MessageSquare,
  Zap,
  Shield,
  Headphones,
  Phone,
  ChevronDown
} from 'lucide-react';
import { cn } from '@/lib/utils';
import confetti from 'canvas-confetti';

// قائمة أكواد الدول
const countryCodes = [
  // الخليج العربي
  { code: '+966', country: 'SA', flag: '🇸🇦', nameEn: 'Saudi Arabia', nameAr: 'السعودية' },
  { code: '+971', country: 'AE', flag: '🇦🇪', nameEn: 'UAE', nameAr: 'الإمارات' },
  { code: '+965', country: 'KW', flag: '🇰🇼', nameEn: 'Kuwait', nameAr: 'الكويت' },
  { code: '+974', country: 'QA', flag: '🇶🇦', nameEn: 'Qatar', nameAr: 'قطر' },
  { code: '+973', country: 'BH', flag: '🇧🇭', nameEn: 'Bahrain', nameAr: 'البحرين' },
  { code: '+968', country: 'OM', flag: '🇴🇲', nameEn: 'Oman', nameAr: 'عمان' },
  // شمال أفريقيا
  { code: '+20', country: 'EG', flag: '🇪🇬', nameEn: 'Egypt', nameAr: 'مصر' },
  { code: '+212', country: 'MA', flag: '🇲🇦', nameEn: 'Morocco', nameAr: 'المغرب' },
  { code: '+213', country: 'DZ', flag: '🇩🇿', nameEn: 'Algeria', nameAr: 'الجزائر' },
  { code: '+216', country: 'TN', flag: '🇹🇳', nameEn: 'Tunisia', nameAr: 'تونس' },
  { code: '+218', country: 'LY', flag: '🇱🇾', nameEn: 'Libya', nameAr: 'ليبيا' },
  { code: '+249', country: 'SD', flag: '🇸🇩', nameEn: 'Sudan', nameAr: 'السودان' },
  // الشام
  { code: '+962', country: 'JO', flag: '🇯🇴', nameEn: 'Jordan', nameAr: 'الأردن' },
  { code: '+961', country: 'LB', flag: '🇱🇧', nameEn: 'Lebanon', nameAr: 'لبنان' },
  { code: '+963', country: 'SY', flag: '🇸🇾', nameEn: 'Syria', nameAr: 'سوريا' },
  { code: '+970', country: 'PS', flag: '🇵🇸', nameEn: 'Palestine', nameAr: 'فلسطين' },
  { code: '+964', country: 'IQ', flag: '🇮🇶', nameEn: 'Iraq', nameAr: 'العراق' },
  { code: '+967', country: 'YE', flag: '🇾🇪', nameEn: 'Yemen', nameAr: 'اليمن' },
  // أوروبا
  { code: '+44', country: 'GB', flag: '🇬🇧', nameEn: 'United Kingdom', nameAr: 'بريطانيا' },
  { code: '+49', country: 'DE', flag: '🇩🇪', nameEn: 'Germany', nameAr: 'ألمانيا' },
  { code: '+33', country: 'FR', flag: '🇫🇷', nameEn: 'France', nameAr: 'فرنسا' },
  { code: '+39', country: 'IT', flag: '🇮🇹', nameEn: 'Italy', nameAr: 'إيطاليا' },
  { code: '+34', country: 'ES', flag: '🇪🇸', nameEn: 'Spain', nameAr: 'إسبانيا' },
  { code: '+31', country: 'NL', flag: '🇳🇱', nameEn: 'Netherlands', nameAr: 'هولندا' },
  { code: '+32', country: 'BE', flag: '🇧🇪', nameEn: 'Belgium', nameAr: 'بلجيكا' },
  { code: '+41', country: 'CH', flag: '🇨🇭', nameEn: 'Switzerland', nameAr: 'سويسرا' },
  { code: '+43', country: 'AT', flag: '🇦🇹', nameEn: 'Austria', nameAr: 'النمسا' },
  { code: '+46', country: 'SE', flag: '🇸🇪', nameEn: 'Sweden', nameAr: 'السويد' },
  { code: '+47', country: 'NO', flag: '🇳🇴', nameEn: 'Norway', nameAr: 'النرويج' },
  { code: '+45', country: 'DK', flag: '🇩🇰', nameEn: 'Denmark', nameAr: 'الدنمارك' },
  { code: '+358', country: 'FI', flag: '🇫🇮', nameEn: 'Finland', nameAr: 'فنلندا' },
  { code: '+48', country: 'PL', flag: '🇵🇱', nameEn: 'Poland', nameAr: 'بولندا' },
  { code: '+351', country: 'PT', flag: '🇵🇹', nameEn: 'Portugal', nameAr: 'البرتغال' },
  { code: '+30', country: 'GR', flag: '🇬🇷', nameEn: 'Greece', nameAr: 'اليونان' },
  { code: '+90', country: 'TR', flag: '🇹🇷', nameEn: 'Turkey', nameAr: 'تركيا' },
  { code: '+7', country: 'RU', flag: '🇷🇺', nameEn: 'Russia', nameAr: 'روسيا' },
  // أمريكا الشمالية
  { code: '+1', country: 'US', flag: '🇺🇸', nameEn: 'USA', nameAr: 'أمريكا' },
  { code: '+1', country: 'CA', flag: '🇨🇦', nameEn: 'Canada', nameAr: 'كندا' },
  { code: '+52', country: 'MX', flag: '🇲🇽', nameEn: 'Mexico', nameAr: 'المكسيك' },
  // آسيا
  { code: '+91', country: 'IN', flag: '🇮🇳', nameEn: 'India', nameAr: 'الهند' },
  { code: '+92', country: 'PK', flag: '🇵🇰', nameEn: 'Pakistan', nameAr: 'باكستان' },
  { code: '+86', country: 'CN', flag: '🇨🇳', nameEn: 'China', nameAr: 'الصين' },
  { code: '+81', country: 'JP', flag: '🇯🇵', nameEn: 'Japan', nameAr: 'اليابان' },
  { code: '+82', country: 'KR', flag: '🇰🇷', nameEn: 'South Korea', nameAr: 'كوريا' },
  { code: '+60', country: 'MY', flag: '🇲🇾', nameEn: 'Malaysia', nameAr: 'ماليزيا' },
  { code: '+62', country: 'ID', flag: '🇮🇩', nameEn: 'Indonesia', nameAr: 'إندونيسيا' },
  { code: '+65', country: 'SG', flag: '🇸🇬', nameEn: 'Singapore', nameAr: 'سنغافورة' },
  { code: '+66', country: 'TH', flag: '🇹🇭', nameEn: 'Thailand', nameAr: 'تايلاند' },
  { code: '+84', country: 'VN', flag: '🇻🇳', nameEn: 'Vietnam', nameAr: 'فيتنام' },
  { code: '+63', country: 'PH', flag: '🇵🇭', nameEn: 'Philippines', nameAr: 'الفلبين' },
  // أستراليا وأوقيانوسيا
  { code: '+61', country: 'AU', flag: '🇦🇺', nameEn: 'Australia', nameAr: 'أستراليا' },
  { code: '+64', country: 'NZ', flag: '🇳🇿', nameEn: 'New Zealand', nameAr: 'نيوزيلندا' },
  // أفريقيا
  { code: '+27', country: 'ZA', flag: '🇿🇦', nameEn: 'South Africa', nameAr: 'جنوب أفريقيا' },
  { code: '+234', country: 'NG', flag: '🇳🇬', nameEn: 'Nigeria', nameAr: 'نيجيريا' },
  { code: '+254', country: 'KE', flag: '🇰🇪', nameEn: 'Kenya', nameAr: 'كينيا' },
  // أمريكا الجنوبية
  { code: '+55', country: 'BR', flag: '🇧🇷', nameEn: 'Brazil', nameAr: 'البرازيل' },
  { code: '+54', country: 'AR', flag: '🇦🇷', nameEn: 'Argentina', nameAr: 'الأرجنتين' },
  { code: '+57', country: 'CO', flag: '🇨🇴', nameEn: 'Colombia', nameAr: 'كولومبيا' },
  { code: '+56', country: 'CL', flag: '🇨🇱', nameEn: 'Chile', nameAr: 'تشيلي' },
];

const ratingCategories = [
  { id: 'overall', iconEn: '⭐', iconAr: '⭐' },
  { id: 'performance', iconEn: '⚡', iconAr: '⚡' },
  { id: 'design', iconEn: '🎨', iconAr: '🎨' },
  { id: 'support', iconEn: '💬', iconAr: '💬' },
  { id: 'value', iconEn: '💰', iconAr: '💰' },
];

export default function FeedbackPage() {
  const locale = useLocale();
  const isArabic = locale === 'ar';
  
  const [ratings, setRatings] = useState<Record<string, number>>({});
  const [hoveredRating, setHoveredRating] = useState<Record<string, number>>({});
  const [comment, setComment] = useState('');
  const [email, setEmail] = useState('');
  const [name, setName] = useState('');
  const [phone, setPhone] = useState('');
  const [countryCode, setCountryCode] = useState('+20');
  const [showCountryDropdown, setShowCountryDropdown] = useState(false);
  const [countrySearch, setCountrySearch] = useState('');
  const [isSubmitting, setIsSubmitting] = useState(false);
  const [isSubmitted, setIsSubmitted] = useState(false);
  const [couponCode, setCouponCode] = useState('');
  const [isCopied, setIsCopied] = useState(false);

  const content = {
    title: isArabic ? 'شاركنا رأيك واحصل على خصم 15%' : 'Share Your Feedback & Get 15% Off',
    subtitle: isArabic 
      ? 'نقدّر رأيك! قيّم تجربتك مع آخر تحديثاتنا واحصل على كود خصم حصري'
      : 'We value your opinion! Rate your experience with our latest updates and get an exclusive discount code',
    categories: {
      overall: isArabic ? 'التقييم العام' : 'Overall Experience',
      performance: isArabic ? 'الأداء والسرعة' : 'Performance & Speed',
      design: isArabic ? 'التصميم والواجهة' : 'Design & Interface',
      support: isArabic ? 'الدعم الفني' : 'Customer Support',
      value: isArabic ? 'القيمة مقابل السعر' : 'Value for Money',
    },
    form: {
      name: isArabic ? 'الاسم *' : 'Your Name *',
      namePlaceholder: isArabic ? 'أدخل اسمك' : 'Enter your name',
      email: isArabic ? 'البريد الإلكتروني *' : 'Email Address *',
      emailPlaceholder: isArabic ? 'أدخل بريدك الإلكتروني' : 'Enter your email',
      phone: isArabic ? 'رقم الهاتف *' : 'Phone Number *',
      phonePlaceholder: isArabic ? 'أدخل رقم هاتفك' : 'Enter your phone number',
      comment: isArabic ? 'تعليقك (اختياري)' : 'Your Comment (Optional)',
      commentPlaceholder: isArabic 
        ? 'شاركنا تجربتك... ما الذي أعجبك؟ ما الذي يمكننا تحسينه؟'
        : 'Share your experience... What did you like? What can we improve?',
      submit: isArabic ? 'إرسال التقييم والحصول على الخصم' : 'Submit & Get Discount',
      submitting: isArabic ? 'جاري الإرسال...' : 'Submitting...',
    },
    success: {
      title: isArabic ? '🎉 شكراً لك!' : '🎉 Thank You!',
      message: isArabic 
        ? 'نقدر ملاحظاتك القيمة. إليك كود الخصم الحصري الخاص بك:'
        : 'We appreciate your valuable feedback. Here is your exclusive discount code:',
      discount: '15%',
      discountText: isArabic ? 'خصم على أي خدمة' : 'off any service',
      copyButton: isArabic ? 'نسخ الكود' : 'Copy Code',
      copied: isArabic ? 'تم النسخ!' : 'Copied!',
      validity: isArabic ? 'صالح حتى 31 يناير 2026' : 'Valid until January 31, 2026',
      cta: isArabic ? 'استخدم الكود الآن' : 'Use Code Now',
    },
    features: [
      {
        icon: Zap,
        title: isArabic ? 'تحسينات الأداء' : 'Performance Improvements',
        description: isArabic ? 'سرعة تحميل أسرع بنسبة 40%' : '40% faster loading speed',
      },
      {
        icon: Shield,
        title: isArabic ? 'أمان محسّن' : 'Enhanced Security',
        description: isArabic ? 'حماية متقدمة ضد الهجمات' : 'Advanced protection against attacks',
      },
      {
        icon: Headphones,
        title: isArabic ? 'دعم فني أفضل' : 'Better Support',
        description: isArabic ? 'استجابة أسرع على مدار الساعة' : 'Faster 24/7 response time',
      },
    ],
  };

  const couponCodeFixed = 'pg-2026';

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    
    // التحقق من وجود تقييم واحد على الأقل
    if (Object.keys(ratings).length === 0) {
      return;
    }

    setIsSubmitting(true);

    try {
      // إرسال التقييم للـ API
      const response = await fetch('/api/feedback', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          name,
          email,
          phone: `${countryCode}${phone}`,
          ratings,
          comment,
          locale,
          timestamp: new Date().toISOString(),
        }),
      });

      if (response.ok) {
        setCouponCode(couponCodeFixed);
        setIsSubmitted(true);
        
        // إطلاق الألعاب النارية
        confetti({
          particleCount: 100,
          spread: 70,
          origin: { y: 0.6 }
        });
      }
    } catch (error) {
      console.error('Error submitting feedback:', error);
    } finally {
      setIsSubmitting(false);
    }
  };

  const copyToClipboard = () => {
    navigator.clipboard.writeText(couponCode);
    setIsCopied(true);
    setTimeout(() => setIsCopied(false), 2000);
  };

  const StarRating = ({ category }: { category: string }) => {
    const currentRating = ratings[category] || 0;
    const hoverRating = hoveredRating[category] || 0;

    return (
      <div className="flex gap-1">
        {[1, 2, 3, 4, 5].map((star) => (
          <button
            key={star}
            type="button"
            onClick={() => setRatings({ ...ratings, [category]: star })}
            onMouseEnter={() => setHoveredRating({ ...hoveredRating, [category]: star })}
            onMouseLeave={() => setHoveredRating({ ...hoveredRating, [category]: 0 })}
            className="transition-transform hover:scale-110 focus:outline-none"
          >
            <Star
              className={cn(
                'w-8 h-8 transition-colors',
                (hoverRating || currentRating) >= star
                  ? 'fill-yellow-400 text-yellow-400'
                  : 'text-gray-300 hover:text-yellow-200'
              )}
            />
          </button>
        ))}
      </div>
    );
  };

  if (isSubmitted) {
    return (
      <div className="min-h-screen bg-gradient-to-b from-blue-50 to-white py-20 px-4">
        <div className="max-w-xl mx-auto">
          <div className="bg-white rounded-3xl shadow-2xl p-8 md:p-12 text-center">
            <div className="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
              <CheckCircle className="w-10 h-10 text-green-500" />
            </div>
            
            <h1 className="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
              {content.success.title}
            </h1>
            
            <p className="text-gray-600 mb-8">
              {content.success.message}
            </p>

            {/* Coupon Card */}
            <div className="relative bg-gradient-to-r from-blue-600 to-blue-800 rounded-2xl p-6 mb-6 overflow-hidden">
              <div className="absolute inset-0 opacity-10">
                <div className="absolute top-0 left-0 w-20 h-20 border-4 border-white rounded-full -translate-x-1/2 -translate-y-1/2" />
                <div className="absolute bottom-0 right-0 w-32 h-32 border-4 border-white rounded-full translate-x-1/2 translate-y-1/2" />
              </div>
              
              <div className="relative">
                <div className="flex items-center justify-center gap-2 mb-2">
                  <Gift className="w-6 h-6 text-white" />
                  <span className="text-white/80 text-sm">{content.success.discountText}</span>
                </div>
                
                <div className="text-5xl font-bold text-white mb-4">
                  {content.success.discount}
                </div>
                
                <div className="bg-white/20 backdrop-blur rounded-xl p-4 mb-4">
                  <code className="text-2xl font-mono font-bold text-white tracking-wider">
                    {couponCode}
                  </code>
                </div>
                
                <button
                  onClick={copyToClipboard}
                  className="inline-flex items-center gap-2 bg-white text-blue-600 font-semibold px-6 py-3 rounded-xl hover:bg-blue-50 transition-colors"
                >
                  {isCopied ? (
                    <>
                      <Check className="w-5 h-5" />
                      {content.success.copied}
                    </>
                  ) : (
                    <>
                      <Copy className="w-5 h-5" />
                      {content.success.copyButton}
                    </>
                  )}
                </button>
              </div>
            </div>

            <p className="text-sm text-gray-500 mb-6">
              ⏰ {content.success.validity}
            </p>

            <a
              href={`/${locale}/hosting/shared`}
              className="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-8 py-4 rounded-xl transition-colors"
            >
              <Sparkles className="w-5 h-5" />
              {content.success.cta}
            </a>
          </div>
        </div>
      </div>
    );
  }

  return (
    <div className="min-h-screen bg-gradient-to-b from-blue-50 to-white py-20 px-4">
      <div className="max-w-4xl mx-auto">
        {/* Header */}
        <div className="text-center mb-12">
          <div className="inline-flex items-center gap-2 bg-blue-100 text-blue-700 px-4 py-2 rounded-full text-sm font-medium mb-6">
            <Gift className="w-4 h-4" />
            {isArabic ? 'عرض خاص - خصم 15%' : 'Special Offer - 15% Discount'}
          </div>
          
          <h1 className="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
            {content.title}
          </h1>
          
          <p className="text-xl text-gray-600 max-w-2xl mx-auto">
            {content.subtitle}
          </p>
        </div>

        {/* What's New Section */}
        <div className="grid md:grid-cols-3 gap-4 mb-12">
          {content.features.map((feature, index) => (
            <div key={index} className="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
              <feature.icon className="w-10 h-10 text-blue-600 mb-3" />
              <h3 className="font-semibold text-gray-900 mb-1">{feature.title}</h3>
              <p className="text-sm text-gray-500">{feature.description}</p>
            </div>
          ))}
        </div>

        {/* Feedback Form */}
        <form onSubmit={handleSubmit} className="bg-white rounded-3xl shadow-xl p-8 md:p-12">
          {/* Rating Categories */}
          <div className="space-y-6 mb-8">
            <h2 className="text-xl font-semibold text-gray-900 mb-4 flex items-center gap-2">
              <Star className="w-5 h-5 text-yellow-500" />
              {isArabic ? 'قيّم تجربتك' : 'Rate Your Experience'}
            </h2>
            
            {ratingCategories.map((category) => (
              <div 
                key={category.id} 
                className="flex flex-col sm:flex-row sm:items-center justify-between gap-3 p-4 bg-gray-50 rounded-xl"
              >
                <div className="flex items-center gap-3">
                  <span className="text-2xl">{isArabic ? category.iconAr : category.iconEn}</span>
                  <span className="font-medium text-gray-700">
                    {content.categories[category.id as keyof typeof content.categories]}
                  </span>
                </div>
                <StarRating category={category.id} />
              </div>
            ))}
          </div>

          {/* Personal Info */}
          <div className="grid md:grid-cols-2 gap-4 mb-6">
            <div>
              <label className="block text-sm font-medium text-gray-700 mb-2">
                {content.form.name}
              </label>
              <input
                type="text"
                value={name}
                onChange={(e) => setName(e.target.value)}
                placeholder={content.form.namePlaceholder}
                required
                className="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition-all"
              />
            </div>
            <div>
              <label className="block text-sm font-medium text-gray-700 mb-2">
                {content.form.email}
              </label>
              <input
                type="email"
                value={email}
                onChange={(e) => setEmail(e.target.value)}
                placeholder={content.form.emailPlaceholder}
                required
                className="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition-all"
              />
            </div>
          </div>

          {/* Phone Number with Country Code */}
          <div className="mb-6">
            <label className="text-sm font-medium text-gray-700 mb-2 flex items-center gap-2">
              <Phone className="w-4 h-4" />
              {content.form.phone}
            </label>
            <div className="flex gap-2">
              {/* Country Code Selector */}
              <div className="relative">
                <button
                  type="button"
                  onClick={() => {
                    setShowCountryDropdown(!showCountryDropdown);
                    setCountrySearch('');
                  }}
                  className="flex items-center gap-2 px-4 py-3 border border-gray-200 rounded-xl bg-gray-50 hover:bg-gray-100 transition-colors min-w-[120px]"
                >
                  <span className="text-xl">
                    {countryCodes.find(c => c.code === countryCode && c.country === (countryCodes.find(cc => cc.code === countryCode)?.country))?.flag || countryCodes.find(c => c.code === countryCode)?.flag}
                  </span>
                  <span className="font-medium text-gray-700">{countryCode}</span>
                  <ChevronDown className="w-4 h-4 text-gray-500" />
                </button>
                
                {showCountryDropdown && (
                  <div className="absolute top-full mt-1 left-0 w-72 bg-white border border-gray-200 rounded-xl shadow-lg z-50">
                    {/* Search Input */}
                    <div className="p-2 border-b border-gray-100">
                      <input
                        type="text"
                        value={countrySearch}
                        onChange={(e) => setCountrySearch(e.target.value)}
                        placeholder={isArabic ? '🔍 ابحث عن دولة...' : '🔍 Search country...'}
                        className="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none"
                        autoFocus
                      />
                    </div>
                    {/* Countries List */}
                    <div className="max-h-48 overflow-y-auto">
                      {countryCodes
                        .filter(country => {
                          const search = countrySearch.toLowerCase();
                          return (
                            country.nameEn.toLowerCase().includes(search) ||
                            country.nameAr.includes(countrySearch) ||
                            country.code.includes(search) ||
                            country.country.toLowerCase().includes(search)
                          );
                        })
                        .map((country, index) => (
                          <button
                            key={`${country.code}-${country.country}-${index}`}
                            type="button"
                            onClick={() => {
                              setCountryCode(country.code);
                              setShowCountryDropdown(false);
                              setCountrySearch('');
                            }}
                            className={cn(
                              "w-full flex items-center gap-3 px-4 py-2.5 hover:bg-blue-50 transition-colors text-left",
                              countryCode === country.code && "bg-blue-50"
                            )}
                          >
                            <span className="text-lg">{country.flag}</span>
                            <span className="font-medium text-sm">{country.code}</span>
                            <span className="text-gray-600 text-sm truncate">
                              {isArabic ? country.nameAr : country.nameEn}
                            </span>
                          </button>
                        ))}
                      {countryCodes.filter(country => {
                        const search = countrySearch.toLowerCase();
                        return (
                          country.nameEn.toLowerCase().includes(search) ||
                          country.nameAr.includes(countrySearch) ||
                          country.code.includes(search)
                        );
                      }).length === 0 && (
                        <div className="px-4 py-3 text-sm text-gray-500 text-center">
                          {isArabic ? 'لم يتم العثور على نتائج' : 'No results found'}
                        </div>
                      )}
                    </div>
                  </div>
                )}
              </div>
              
              {/* Phone Input */}
              <input
                type="tel"
                value={phone}
                onChange={(e) => {
                  // السماح بالأرقام فقط
                  const value = e.target.value.replace(/\D/g, '');
                  setPhone(value);
                }}
                placeholder={content.form.phonePlaceholder}
                required
                className="flex-1 px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition-all"
                dir="ltr"
              />
            </div>
          </div>

          {/* Comment */}
          <div className="mb-8">
            <label className="block text-sm font-medium text-gray-700 mb-2 flex items-center gap-2">
              <MessageSquare className="w-4 h-4" />
              {content.form.comment}
            </label>
            <textarea
              value={comment}
              onChange={(e) => setComment(e.target.value)}
              placeholder={content.form.commentPlaceholder}
              rows={4}
              className="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition-all resize-none"
            />
          </div>

          {/* Submit Button */}
          <button
            type="submit"
            disabled={isSubmitting || Object.keys(ratings).length === 0}
            className={cn(
              'w-full py-4 rounded-xl font-semibold text-lg transition-all flex items-center justify-center gap-3',
              Object.keys(ratings).length > 0
                ? 'bg-gradient-to-r from-blue-600 to-blue-800 hover:from-blue-700 hover:to-blue-900 text-white shadow-lg hover:shadow-xl'
                : 'bg-gray-200 text-gray-500 cursor-not-allowed'
            )}
          >
            {isSubmitting ? (
              <>
                <div className="w-5 h-5 border-2 border-white border-t-transparent rounded-full animate-spin" />
                {content.form.submitting}
              </>
            ) : (
              <>
                <Send className="w-5 h-5" />
                {content.form.submit}
                <Gift className="w-5 h-5" />
              </>
            )}
          </button>

          {Object.keys(ratings).length === 0 && (
            <p className="text-center text-sm text-gray-500 mt-3">
              {isArabic ? '* يرجى تقييم فئة واحدة على الأقل' : '* Please rate at least one category'}
            </p>
          )}
        </form>
      </div>
    </div>
  );
}
