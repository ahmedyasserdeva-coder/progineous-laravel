'use client';

import { useParams } from 'next/navigation';
import { useState } from 'react';
import { 
  Mail, 
  Phone, 
  MapPin, 
  Clock, 
  Send, 
  MessageSquare,
  Globe,
  Headphones,
  CheckCircle,
  AlertCircle,
  Loader2,
  Facebook,
  Twitter,
  Linkedin,
  Instagram
} from 'lucide-react';

export default function ContactPage() {
  const params = useParams();
  const locale = (params?.locale as string) || 'en';
  const isRTL = locale === 'ar';

  const [formData, setFormData] = useState({
    name: '',
    email: '',
    phone: '',
    subject: '',
    department: 'support',
    message: ''
  });
  const [isSubmitting, setIsSubmitting] = useState(false);
  const [submitStatus, setSubmitStatus] = useState<'idle' | 'success' | 'error'>('idle');

  const content = {
    en: {
      title: 'Contact Us',
      subtitle: 'We\'d love to hear from you. Get in touch with our team.',
      getInTouch: 'Get in Touch',
      getInTouchDesc: 'Have a question or need assistance? Fill out the form below and our team will get back to you as soon as possible.',
      contactInfo: 'Contact Information',
      formLabels: {
        name: 'Full Name',
        email: 'Email Address',
        phone: 'Phone Number',
        subject: 'Subject',
        department: 'Department',
        message: 'Message',
        submit: 'Send Message',
        submitting: 'Sending...'
      },
      placeholders: {
        name: 'Enter your full name',
        email: 'Enter your email address',
        phone: '+20 xxx xxx xxxx',
        subject: 'How can we help you?',
        message: 'Write your message here...'
      },
      departments: {
        support: 'Technical Support',
        sales: 'Sales & Inquiries',
        billing: 'Billing & Accounts',
        partnerships: 'Partnerships',
        other: 'Other'
      },
      contactDetails: {
        email: {
          title: 'Email Us',
          primary: 'support@progineous.com',
          secondary: 'sales@progineous.com'
        },
        phone: {
          title: 'WhatsApp',
          primary: '+20 107 079 8859',
          secondary: 'Available 24/7'
        },
        address: {
          title: 'Visit Us',
          line1: '9 Mustafa Kamel Street',
          line2: 'Balwalidain Ihsanah Tower, Beni Suef, Egypt'
        },
        hours: {
          title: 'Working Hours',
          line1: 'Sunday - Thursday: 9:00 AM - 6:00 PM',
          line2: 'Friday - Saturday: Closed'
        }
      },
      supportChannels: {
        title: 'Support Channels',
        items: [
          { icon: Headphones, title: 'Live Chat', desc: '24/7 instant support via live chat' },
          { icon: MessageSquare, title: 'Ticket System', desc: 'Create a support ticket for complex issues' },
          { icon: Globe, title: 'Knowledge Base', desc: 'Find answers in our documentation' }
        ]
      },
      followUs: 'Follow Us',
      successMessage: 'Thank you! Your message has been sent successfully. We\'ll get back to you soon.',
      errorMessage: 'Something went wrong. Please try again later.',
      responseTime: 'Average Response Time',
      responseTimeValue: 'Within 24 hours'
    },
    ar: {
      title: 'اتصل بنا',
      subtitle: 'يسعدنا سماع رأيك. تواصل مع فريقنا.',
      getInTouch: 'تواصل معنا',
      getInTouchDesc: 'هل لديك سؤال أو تحتاج إلى مساعدة؟ املأ النموذج أدناه وسيتواصل معك فريقنا في أقرب وقت ممكن.',
      contactInfo: 'معلومات الاتصال',
      formLabels: {
        name: 'الاسم الكامل',
        email: 'البريد الإلكتروني',
        phone: 'رقم الهاتف',
        subject: 'الموضوع',
        department: 'القسم',
        message: 'الرسالة',
        submit: 'إرسال الرسالة',
        submitting: 'جاري الإرسال...'
      },
      placeholders: {
        name: 'أدخل اسمك الكامل',
        email: 'أدخل بريدك الإلكتروني',
        phone: '+20 xxx xxx xxxx',
        subject: 'كيف يمكننا مساعدتك؟',
        message: 'اكتب رسالتك هنا...'
      },
      departments: {
        support: 'الدعم الفني',
        sales: 'المبيعات والاستفسارات',
        billing: 'الفواتير والحسابات',
        partnerships: 'الشراكات',
        other: 'أخرى'
      },
      contactDetails: {
        email: {
          title: 'راسلنا',
          primary: 'support@progineous.com',
          secondary: 'sales@progineous.com'
        },
        phone: {
          title: 'واتساب',
          primary: '+20 107 079 8859',
          secondary: 'متاح 24/7'
        },
        address: {
          title: 'زورنا',
          line1: '9 شارع مصطفى كامل',
          line2: 'برج الوالدين إحسانه، بني سويف، مصر'
        },
        hours: {
          title: 'ساعات العمل',
          line1: 'الأحد - الخميس: 9:00 ص - 6:00 م',
          line2: 'الجمعة - السبت: مغلق'
        }
      },
      supportChannels: {
        title: 'قنوات الدعم',
        items: [
          { icon: Headphones, title: 'الدردشة المباشرة', desc: 'دعم فوري على مدار الساعة' },
          { icon: MessageSquare, title: 'نظام التذاكر', desc: 'أنشئ تذكرة دعم للمشاكل المعقدة' },
          { icon: Globe, title: 'قاعدة المعرفة', desc: 'ابحث عن إجابات في وثائقنا' }
        ]
      },
      followUs: 'تابعنا',
      successMessage: 'شكراً لك! تم إرسال رسالتك بنجاح. سنتواصل معك قريباً.',
      errorMessage: 'حدث خطأ ما. يرجى المحاولة مرة أخرى لاحقاً.',
      responseTime: 'متوسط وقت الاستجابة',
      responseTimeValue: 'خلال 24 ساعة'
    }
  };

  const t = content[locale as keyof typeof content] || content.en;

  const handleInputChange = (e: React.ChangeEvent<HTMLInputElement | HTMLTextAreaElement | HTMLSelectElement>) => {
    const { name, value } = e.target;
    setFormData(prev => ({ ...prev, [name]: value }));
  };

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    setIsSubmitting(true);
    setSubmitStatus('idle');

    try {
      const response = await fetch('/api/contact', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify(formData),
      });

      const data = await response.json();

      if (!response.ok) {
        throw new Error(data.error || 'Failed to send message');
      }

      setSubmitStatus('success');
      setFormData({
        name: '',
        email: '',
        phone: '',
        subject: '',
        department: 'support',
        message: ''
      });
    } catch {
      setSubmitStatus('error');
    } finally {
      setIsSubmitting(false);
    }
  };

  const socialLinks = [
    { icon: Facebook, href: 'https://facebook.com/progineous', label: 'Facebook' },
    { icon: Twitter, href: 'https://twitter.com/progineous', label: 'Twitter' },
    { icon: Linkedin, href: 'https://linkedin.com/company/progineous', label: 'LinkedIn' },
    { icon: Instagram, href: 'https://instagram.com/progineous', label: 'Instagram' }
  ];

  return (
    <div className={`min-h-screen bg-gray-50 ${isRTL ? 'rtl' : 'ltr'}`} dir={isRTL ? 'rtl' : 'ltr'}>
      {/* JSON-LD Structured Data */}
      <script
        type="application/ld+json"
        dangerouslySetInnerHTML={{
          __html: JSON.stringify({
            '@context': 'https://schema.org',
            '@type': 'ContactPage',
            name: isRTL ? 'اتصل بنا - بروجينيوس' : 'Contact Us - Pro Gineous',
            description: isRTL
              ? 'تواصل مع فريق بروجينيوس للحصول على الدعم'
              : 'Get in touch with Pro Gineous team for support',
            url: `https://progineous.com/${locale}/contact`,
            mainEntity: {
              '@type': 'Organization',
              name: 'Pro Gineous',
              telephone: '+20-107-079-8859',
              email: 'support@progineous.com',
              address: {
                '@type': 'PostalAddress',
                streetAddress: '9 Mustafa Kamel Street, Balwalidain Ihsanah Tower',
                addressLocality: 'Beni Suef',
                addressCountry: 'EG',
              },
              openingHoursSpecification: [
                {
                  '@type': 'OpeningHoursSpecification',
                  dayOfWeek: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday'],
                  opens: '09:00',
                  closes: '18:00',
                },
              ],
              contactPoint: [
                {
                  '@type': 'ContactPoint',
                  telephone: '+20-107-079-8859',
                  contactType: 'customer service',
                  availableLanguage: ['Arabic', 'English'],
                },
                {
                  '@type': 'ContactPoint',
                  email: 'support@progineous.com',
                  contactType: 'technical support',
                },
                {
                  '@type': 'ContactPoint',
                  email: 'sales@progineous.com',
                  contactType: 'sales',
                },
              ],
            },
          }),
        }}
      />
      <script
        type="application/ld+json"
        dangerouslySetInnerHTML={{
          __html: JSON.stringify({
            '@context': 'https://schema.org',
            '@type': 'BreadcrumbList',
            itemListElement: [
              { '@type': 'ListItem', position: 1, name: isRTL ? 'الرئيسية' : 'Home', item: `https://progineous.com/${locale}` },
              { '@type': 'ListItem', position: 2, name: isRTL ? 'اتصل بنا' : 'Contact Us', item: `https://progineous.com/${locale}/contact` },
            ],
          }),
        }}
      />

      {/* Hero Section */}
      <section className="bg-linear-to-br from-[#1d71b8] via-[#1557a0] to-[#0d4a7a] text-white py-20">
        <div className="container mx-auto px-4">
          <div className="max-w-4xl mx-auto text-center">
            <div className="inline-flex items-center justify-center w-20 h-20 bg-white/10 rounded-2xl mb-6">
              <Mail className="w-10 h-10" />
            </div>
            <h1 className="text-4xl md:text-5xl font-bold mb-4">{t.title}</h1>
            <p className="text-xl text-blue-100">{t.subtitle}</p>
          </div>
        </div>
      </section>

      {/* Main Content */}
      <section className="py-16">
        <div className="container mx-auto px-4">
          <div className="max-w-7xl mx-auto">
            <div className="grid lg:grid-cols-3 gap-8">
              {/* Contact Form */}
              <div className="lg:col-span-2">
                <div className="bg-white rounded-2xl shadow-lg p-8">
                  <h2 className="text-2xl font-bold text-gray-900 mb-2">{t.getInTouch}</h2>
                  <p className="text-gray-600 mb-8">{t.getInTouchDesc}</p>

                  {submitStatus === 'success' && (
                    <div className="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl flex items-center gap-3">
                      <CheckCircle className="w-5 h-5 text-green-600 shrink-0" />
                      <p className="text-green-800">{t.successMessage}</p>
                    </div>
                  )}

                  {submitStatus === 'error' && (
                    <div className="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl flex items-center gap-3">
                      <AlertCircle className="w-5 h-5 text-red-600 shrink-0" />
                      <p className="text-red-800">{t.errorMessage}</p>
                    </div>
                  )}

                  <form onSubmit={handleSubmit} className="space-y-6">
                    <div className="grid md:grid-cols-2 gap-6">
                      {/* Name */}
                      <div>
                        <label className="block text-sm font-medium text-gray-700 mb-2">
                          {t.formLabels.name} <span className="text-red-500">*</span>
                        </label>
                        <input
                          type="text"
                          name="name"
                          value={formData.name}
                          onChange={handleInputChange}
                          required
                          placeholder={t.placeholders.name}
                          className="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#1d71b8] focus:border-transparent transition-all outline-none"
                        />
                      </div>

                      {/* Email */}
                      <div>
                        <label className="block text-sm font-medium text-gray-700 mb-2">
                          {t.formLabels.email} <span className="text-red-500">*</span>
                        </label>
                        <input
                          type="email"
                          name="email"
                          value={formData.email}
                          onChange={handleInputChange}
                          required
                          placeholder={t.placeholders.email}
                          className="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#1d71b8] focus:border-transparent transition-all outline-none"
                        />
                      </div>

                      {/* Phone */}
                      <div>
                        <label className="block text-sm font-medium text-gray-700 mb-2">
                          {t.formLabels.phone} <span className="text-red-500">*</span>
                        </label>
                        <input
                          type="tel"
                          name="phone"
                          value={formData.phone}
                          onChange={handleInputChange}
                          required
                          placeholder={t.placeholders.phone}
                          className="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#1d71b8] focus:border-transparent transition-all outline-none"
                        />
                      </div>

                      {/* Department */}
                      <div>
                        <label className="block text-sm font-medium text-gray-700 mb-2">
                          {t.formLabels.department}
                        </label>
                        <select
                          name="department"
                          value={formData.department}
                          onChange={handleInputChange}
                          title={t.formLabels.department}
                          className="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#1d71b8] focus:border-transparent transition-all outline-none bg-white"
                        >
                          {Object.entries(t.departments).map(([key, value]) => (
                            <option key={key} value={key}>{value}</option>
                          ))}
                        </select>
                      </div>
                    </div>

                    {/* Subject */}
                    <div>
                      <label className="block text-sm font-medium text-gray-700 mb-2">
                        {t.formLabels.subject} <span className="text-red-500">*</span>
                      </label>
                      <input
                        type="text"
                        name="subject"
                        value={formData.subject}
                        onChange={handleInputChange}
                        required
                        placeholder={t.placeholders.subject}
                        className="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#1d71b8] focus:border-transparent transition-all outline-none"
                      />
                    </div>

                    {/* Message */}
                    <div>
                      <label className="block text-sm font-medium text-gray-700 mb-2">
                        {t.formLabels.message} <span className="text-red-500">*</span>
                      </label>
                      <textarea
                        name="message"
                        value={formData.message}
                        onChange={handleInputChange}
                        required
                        rows={6}
                        placeholder={t.placeholders.message}
                        className="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#1d71b8] focus:border-transparent transition-all outline-none resize-none"
                      />
                    </div>

                    {/* Submit Button */}
                    <button
                      type="submit"
                      disabled={isSubmitting}
                      className="w-full md:w-auto px-8 py-4 bg-[#1d71b8] hover:bg-[#0d4a7a] text-white font-semibold rounded-xl transition-all duration-300 flex items-center justify-center gap-2 disabled:opacity-70 disabled:cursor-not-allowed"
                    >
                      {isSubmitting ? (
                        <>
                          <Loader2 className="w-5 h-5 animate-spin" />
                          {t.formLabels.submitting}
                        </>
                      ) : (
                        <>
                          <Send className="w-5 h-5" />
                          {t.formLabels.submit}
                        </>
                      )}
                    </button>
                  </form>
                </div>
              </div>

              {/* Contact Information Sidebar */}
              <div className="space-y-6">
                {/* Contact Details Card */}
                <div className="bg-white rounded-2xl shadow-lg p-6">
                  <h3 className="text-xl font-bold text-gray-900 mb-6">{t.contactInfo}</h3>
                  
                  <div className="space-y-6">
                    {/* Email */}
                    <div className="flex items-start gap-4">
                      <div className="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center shrink-0">
                        <Mail className="w-6 h-6 text-[#1d71b8]" />
                      </div>
                      <div>
                        <h4 className="font-semibold text-gray-900">{t.contactDetails.email.title}</h4>
                        <a href={`mailto:${t.contactDetails.email.primary}`} className="text-[#1d71b8] hover:underline block">
                          {t.contactDetails.email.primary}
                        </a>
                        <a href={`mailto:${t.contactDetails.email.secondary}`} className="text-gray-600 hover:text-[#1d71b8] block text-sm">
                          {t.contactDetails.email.secondary}
                        </a>
                      </div>
                    </div>

                    {/* WhatsApp */}
                    <div className="flex items-start gap-4">
                      <div className="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center shrink-0">
                        <svg className="w-6 h-6 text-green-600" viewBox="0 0 24 24" fill="currentColor">
                          <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                        </svg>
                      </div>
                      <div>
                        <h4 className="font-semibold text-gray-900">{t.contactDetails.phone.title}</h4>
                        <a href="https://wa.me/201070798859" target="_blank" rel="noopener noreferrer" className="text-green-600 hover:underline block">
                          <span dir="ltr">{t.contactDetails.phone.primary}</span>
                        </a>
                        <p className="text-gray-600 text-sm">{t.contactDetails.phone.secondary}</p>
                      </div>
                    </div>

                    {/* Address */}
                    <div className="flex items-start gap-4">
                      <div className="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center shrink-0">
                        <MapPin className="w-6 h-6 text-orange-600" />
                      </div>
                      <div>
                        <h4 className="font-semibold text-gray-900">{t.contactDetails.address.title}</h4>
                        <p className="text-gray-700">{t.contactDetails.address.line1}</p>
                        <p className="text-gray-600 text-sm">{t.contactDetails.address.line2}</p>
                      </div>
                    </div>

                    {/* Working Hours */}
                    <div className="flex items-start gap-4">
                      <div className="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center shrink-0">
                        <Clock className="w-6 h-6 text-purple-600" />
                      </div>
                      <div>
                        <h4 className="font-semibold text-gray-900">{t.contactDetails.hours.title}</h4>
                        <p className="text-gray-700 text-sm">{t.contactDetails.hours.line1}</p>
                        <p className="text-gray-600 text-sm">{t.contactDetails.hours.line2}</p>
                      </div>
                    </div>
                  </div>
                </div>

                {/* Response Time Card */}
                <div className="bg-linear-to-br from-[#1d71b8] to-[#0d4a7a] rounded-2xl shadow-lg p-6 text-white">
                  <div className="flex items-center gap-3 mb-2">
                    <Clock className="w-5 h-5" />
                    <h4 className="font-semibold">{t.responseTime}</h4>
                  </div>
                  <p className="text-2xl font-bold">{t.responseTimeValue}</p>
                </div>

                {/* Support Channels */}
                <div className="bg-white rounded-2xl shadow-lg p-6">
                  <h3 className="text-xl font-bold text-gray-900 mb-4">{t.supportChannels.title}</h3>
                  <div className="space-y-4">
                    {t.supportChannels.items.map((item, index) => (
                      <div key={index} className="flex items-start gap-3">
                        <div className="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center shrink-0">
                          <item.icon className="w-5 h-5 text-[#1d71b8]" />
                        </div>
                        <div>
                          <h4 className="font-semibold text-gray-900 text-sm">{item.title}</h4>
                          <p className="text-gray-600 text-xs">{item.desc}</p>
                        </div>
                      </div>
                    ))}
                  </div>
                </div>

                {/* Social Links */}
                <div className="bg-white rounded-2xl shadow-lg p-6">
                  <h3 className="text-lg font-bold text-gray-900 mb-4">{t.followUs}</h3>
                  <div className="flex gap-3">
                    {socialLinks.map((social, index) => (
                      <a
                        key={index}
                        href={social.href}
                        target="_blank"
                        rel="noopener noreferrer"
                        className="w-10 h-10 bg-gray-100 hover:bg-[#1d71b8] rounded-lg flex items-center justify-center transition-all duration-300 group"
                        aria-label={social.label}
                      >
                        <social.icon className="w-5 h-5 text-gray-600 group-hover:text-white transition-colors" />
                      </a>
                    ))}
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      {/* Map Section */}
      <section className="py-16 bg-white">
        <div className="container mx-auto px-4">
          <div className="max-w-7xl mx-auto">
            <div className="rounded-2xl overflow-hidden h-100 shadow-lg">
              <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3487.160528976068!2d31.098657512712087!3d29.07140097532535!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x145a278510681a3f%3A0xc5dff464b3150b22!2sPro%20Gineous!5e0!3m2!1sen!2seg!4v1767143798555!5m2!1sen!2seg"
                width="100%"
                height="100%"
                className="border-0"
                allowFullScreen
                loading="lazy"
                referrerPolicy="no-referrer-when-downgrade"
                title="Pro Gineous Location - 9 Mustafa Kamel Street, Beni Suef, Egypt"
              />
            </div>
            {/* Address below map */}
            <div className="mt-6 text-center">
              <div className="inline-flex items-center gap-2 bg-gray-100 px-6 py-3 rounded-xl">
                <MapPin className="w-5 h-5 text-[#1d71b8]" />
                <span className="text-gray-700 font-medium">
                  {locale === 'ar' 
                    ? '9 شارع مصطفى كامل، برج الوالدين إحسانه، بني سويف، مصر'
                    : '9 Mustafa Kamel Street, Balwalidain Ihsanah Tower, Beni Suef, Egypt'
                  }
                </span>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  );
}
