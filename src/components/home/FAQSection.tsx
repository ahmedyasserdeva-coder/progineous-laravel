'use client';

import { useState } from 'react';
import { useLocale } from 'next-intl';
import { ChevronDown } from 'lucide-react';

export function FAQSection() {
  const locale = useLocale();
  const [openIndex, setOpenIndex] = useState<number | null>(null);

  const faqs = [
    {
      question: locale === 'ar' ? 'ما هي الاستضافة المشتركة؟' : 'What is shared hosting?',
      answer: locale === 'ar' 
        ? 'الاستضافة المشتركة هي نوع من استضافة الويب حيث يتشارك عدة مواقع في موارد خادم واحد. إنها خيار فعال من حيث التكلفة للمواقع الصغيرة والمتوسطة.'
        : 'Shared hosting is a type of web hosting where multiple websites share resources on a single server. It\'s a cost-effective option for small to medium websites.'
    },
    {
      question: locale === 'ar' ? 'كيف يمكنني نقل موقعي إليكم؟' : 'How can I migrate my website to you?',
      answer: locale === 'ar' 
        ? 'نقدم خدمة نقل مجانية! فريقنا سيتولى نقل موقعك وقواعد البيانات والبريد الإلكتروني بدون أي توقف يذكر. فقط تواصل مع الدعم الفني.'
        : 'We offer free migration! Our team will handle transferring your website, databases, and emails with minimal downtime. Just contact our support team.'
    },
    {
      question: locale === 'ar' ? 'هل تقدمون شهادات SSL مجانية؟' : 'Do you offer free SSL certificates?',
      answer: locale === 'ar' 
        ? 'نعم! جميع خططنا تتضمن شهادات SSL مجانية من Let\'s Encrypt لتأمين موقعك وحماية بيانات زوارك.'
        : 'Yes! All our plans include free SSL certificates from Let\'s Encrypt to secure your website and protect your visitors\' data.'
    },
    {
      question: locale === 'ar' ? 'ما هو ضمان وقت التشغيل؟' : 'What is your uptime guarantee?',
      answer: locale === 'ar' 
        ? 'نضمن وقت تشغيل بنسبة 99.9%. خوادمنا مراقبة على مدار الساعة ونستخدم أحدث التقنيات لضمان استمرارية عمل موقعك.'
        : 'We guarantee 99.9% uptime. Our servers are monitored 24/7 and we use the latest technologies to ensure your website stays online.'
    },
    {
      question: locale === 'ar' ? 'هل يمكنني ترقية خطتي لاحقاً؟' : 'Can I upgrade my plan later?',
      answer: locale === 'ar' 
        ? 'بالطبع! يمكنك ترقية خطتك في أي وقت من لوحة التحكم. الترقية تتم فوراً ويتم احتساب الفرق بشكل تناسبي.'
        : 'Absolutely! You can upgrade your plan at any time from your control panel. Upgrades are instant and the difference is prorated.'
    },
    {
      question: locale === 'ar' ? 'ما هي طرق الدفع المتاحة؟' : 'What payment methods do you accept?',
      answer: locale === 'ar' 
        ? 'نقبل بطاقات الائتمان (Visa, MasterCard)، PayPal، والتحويل البنكي. كما نوفر خيارات دفع محلية في بعض البلدان.'
        : 'We accept credit cards (Visa, MasterCard), PayPal, and bank transfers. We also offer local payment options in some countries.'
    },
    {
      question: locale === 'ar' ? 'هل تقدمون نسخ احتياطية؟' : 'Do you provide backups?',
      answer: locale === 'ar' 
        ? 'نعم، نقوم بعمل نسخ احتياطية يومية تلقائية لجميع المواقع. يمكنك استعادة موقعك بنقرة واحدة من لوحة التحكم.'
        : 'Yes, we perform automatic daily backups for all websites. You can restore your site with one click from your control panel.'
    },
    {
      question: locale === 'ar' ? 'ما هي سياسة استرداد الأموال؟' : 'What is your refund policy?',
      answer: locale === 'ar' 
        ? 'نقدم ضمان استرداد الأموال خلال 30 يوماً. إذا لم تكن راضياً عن خدمتنا، يمكنك طلب استرداد كامل المبلغ.'
        : 'We offer a 30-day money-back guarantee. If you\'re not satisfied with our service, you can request a full refund.'
    },
    {
      question: locale === 'ar' ? 'هل يمكنني استضافة عدة مواقع؟' : 'Can I host multiple websites?',
      answer: locale === 'ar' 
        ? 'نعم، معظم خططنا تدعم استضافة عدة مواقع. تحقق من تفاصيل كل خطة لمعرفة عدد المواقع المسموح بها.'
        : 'Yes, most of our plans support hosting multiple websites. Check the details of each plan to see how many sites are allowed.'
    },
    {
      question: locale === 'ar' ? 'كيف يمكنني التواصل مع الدعم الفني؟' : 'How can I contact technical support?',
      answer: locale === 'ar' 
        ? 'فريق الدعم متاح 24/7 عبر الدردشة المباشرة، البريد الإلكتروني، ونظام التذاكر. متوسط وقت الاستجابة أقل من 15 دقيقة.'
        : 'Our support team is available 24/7 via live chat, email, and ticket system. Average response time is less than 15 minutes.'
    },
    // New SEO-optimized questions targeting competitor keywords
    {
      question: locale === 'ar' ? 'هل Pro Gineous أفضل من Hostinger؟' : 'Is Pro Gineous better than Hostinger?',
      answer: locale === 'ar' 
        ? 'نعم، Pro Gineous تقدم أسعاراً أقل، دعماً فنياً باللغة العربية على مدار الساعة، وسيرفرات أقرب للشرق الأوسط مما يعني سرعة أفضل لزوار مواقعك.'
        : 'Yes, Pro Gineous offers lower prices, 24/7 Arabic technical support, and servers closer to the Middle East meaning better speed for your visitors.'
    },
    {
      question: locale === 'ar' ? 'كم سعر الاستضافة في مصر؟' : 'How much is web hosting in Egypt?',
      answer: locale === 'ar' 
        ? 'تبدأ أسعار الاستضافة من $2 شهرياً فقط مع Pro Gineous. نقدم خطط استضافة مشتركة، سحابية، VPS، وسيرفرات مخصصة بأسعار تناسب السوق المصري والعربي.'
        : 'Hosting prices start from just $2/month with Pro Gineous. We offer shared, cloud, VPS, and dedicated server plans at prices suitable for the Egyptian and Arab market.'
    },
    {
      question: locale === 'ar' ? 'ما أفضل استضافة لموقع ووردبريس؟' : 'What is the best hosting for WordPress?',
      answer: locale === 'ar' 
        ? 'استضافتنا مُحسّنة لووردبريس مع LiteSpeed Cache وPHP 8.3 وNVMe SSD لأداء فائق السرعة. كما نقدم تثبيت ووردبريس بنقرة واحدة.'
        : 'Our hosting is optimized for WordPress with LiteSpeed Cache, PHP 8.3, and NVMe SSD for lightning-fast performance. We also offer one-click WordPress installation.'
    },
    {
      question: locale === 'ar' ? 'هل تدعمون الدفع بالجنيه المصري؟' : 'Do you support payment in local currencies?',
      answer: locale === 'ar' 
        ? 'نعم! نقبل الدفع بالجنيه المصري، الريال السعودي، الدرهم الإماراتي، وجميع العملات العربية عبر فودافون كاش، فوري، البطاقات الائتمانية، وPayPal.'
        : 'Yes! We accept payment in Egyptian Pound, Saudi Riyal, UAE Dirham, and all Arab currencies via Vodafone Cash, Fawry, credit cards, and PayPal.'
    }
  ];

  const leftColumn = faqs.slice(0, 7);
  const rightColumn = faqs.slice(7, 14);

  const toggleFAQ = (index: number) => {
    setOpenIndex(openIndex === index ? null : index);
  };

  const FAQItem = ({ faq, index }: { faq: typeof faqs[0]; index: number }) => (
    <div className="border-b border-gray-200">
      <button
        onClick={() => toggleFAQ(index)}
        className="w-full py-5 flex items-center justify-between text-left"
      >
        <span className="text-base font-medium text-gray-900 pr-4">
          {faq.question}
        </span>
        <ChevronDown 
          className={`flex-shrink-0 h-5 w-5 text-gray-500 transition-transform duration-300 ${
            openIndex === index ? 'rotate-180' : ''
          }`}
        />
      </button>
      <div 
        className={`overflow-hidden transition-all duration-300 ${
          openIndex === index ? 'max-h-48 pb-5' : 'max-h-0'
        }`}
      >
        <p className="text-gray-600 leading-relaxed">
          {faq.answer}
        </p>
      </div>
    </div>
  );

  return (
    <section className="bg-gray-50 py-16 lg:py-24">
      <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        
        {/* Section Header */}
        <div className="text-center max-w-3xl mx-auto mb-12 lg:mb-16">
          <h2 className="text-3xl lg:text-4xl font-bold text-gray-900">
            {locale === 'ar' ? 'الأسئلة الشائعة' : 'Frequently asked questions'}
          </h2>
          <p className="mt-4 text-lg text-gray-600">
            {locale === 'ar' 
              ? 'إجابات على أكثر الأسئلة شيوعاً حول خدماتنا'
              : 'Answers to the most common questions about our services'}
          </p>
        </div>

        {/* FAQ Grid - 2 Columns */}
        <div className="grid grid-cols-1 lg:grid-cols-2 gap-x-12 lg:gap-x-16">
          
          {/* Left Column */}
          <div>
            {leftColumn.map((faq, index) => (
              <FAQItem key={index} faq={faq} index={index} />
            ))}
          </div>

          {/* Right Column */}
          <div>
            {rightColumn.map((faq, index) => (
              <FAQItem key={index + 5} faq={faq} index={index + 5} />
            ))}
          </div>

        </div>

      </div>
    </section>
  );
}
