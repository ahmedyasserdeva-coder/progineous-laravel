'use client';

import { useState, useEffect } from 'react';
import { useLocale } from 'next-intl';
import Link from 'next/link';
import { ArrowLeft, ChevronRight, Menu, X, Shield, Globe, Lock, Eye, Database, Users, Bell, FileText, Scale, Mail } from 'lucide-react';
import { cn } from '@/lib/utils';
import { RTLText } from '@/components/ui/RTLText';

export default function PrivacyPage() {
  const locale = useLocale();
  const isRTL = locale === 'ar';
  const [activeSection, setActiveSection] = useState('intro');
  const [mobileMenuOpen, setMobileMenuOpen] = useState(false);

  const sections = [
    {
      id: 'intro',
      title: { en: 'Introduction', ar: 'مقدمة' },
      icon: Shield,
      content: {
        en: `Pro Gineous ("Pro Gineous", "we", "us", or "our") respects your privacy and is committed to protecting your personal data. This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you visit our website, use our hosting services, or otherwise interact with us.

Because we serve customers both in Egypt and internationally, this Privacy Policy is structured to comply with various privacy laws and regulations.

This Privacy Policy is divided into sections to ensure transparency:

• Section A – General Privacy Information: Contains general information about data collection and usage.
• Section B – Your Rights: Contains information about your rights regarding your personal data.

By using our services, you acknowledge that you have read and understood this Privacy Policy.`,
        ar: `تحترم برو جينيوس ("برو جينيوس"، "نحن"، "لنا"، أو "الخاصة بنا") خصوصيتك وتلتزم بحماية بياناتك الشخصية. توضح سياسة الخصوصية هذه كيفية جمع واستخدام والإفصاح عن معلوماتك وحمايتها عند زيارة موقعنا الإلكتروني أو استخدام خدمات الاستضافة الخاصة بنا أو التفاعل معنا بأي طريقة أخرى.

نظرًا لأننا نخدم العملاء في مصر ودوليًا، فإن سياسة الخصوصية هذه مُنظمة للامتثال لمختلف قوانين ولوائح الخصوصية.

تم تقسيم سياسة الخصوصية هذه إلى أقسام لضمان الشفافية:

• القسم أ – معلومات الخصوصية العامة: يحتوي على معلومات عامة حول جمع البيانات واستخدامها.
• القسم ب – حقوقك: يحتوي على معلومات حول حقوقك المتعلقة ببياناتك الشخصية.

باستخدام خدماتنا، فإنك تقر بأنك قد قرأت وفهمت سياسة الخصوصية هذه.`
      }
    },
    {
      id: 'parties',
      title: { en: 'Parties', ar: 'الأطراف' },
      icon: Users,
      content: {
        en: `This Privacy Policy discusses the ways in which we collect, use, maintain and disclose information collected by us from our customers, visitors to our websites, and, in some cases, visitors to our customer's websites ("Users").

Capitalized terms used but not defined in this policy have the meaning given to them in our Terms of Services.

The data controller responsible for your personal data is:

Pro Gineous
9 Mustafa Kamel Street, Balwalidain Ihsanah Tower
Beni Suef, Egypt
Commercial Register: 90088
Tax Registration: 755-552-334`,
        ar: `تناقش سياسة الخصوصية هذه الطرق التي نجمع بها المعلومات ونستخدمها ونحافظ عليها ونفصح عنها من عملائنا وزوار مواقعنا الإلكترونية، وفي بعض الحالات، زوار مواقع عملائنا ("المستخدمين").

المصطلحات المكتوبة بأحرف كبيرة المستخدمة ولكن غير المعرّفة في هذه السياسة لها المعنى المحدد في شروط الخدمة الخاصة بنا.

مراقب البيانات المسؤول عن بياناتك الشخصية هو:

برو جينيوس
9 شارع مصطفى كامل، برج بالوالدين إحسانًا
بني سويف، مصر
السجل التجاري: 90088
رقم التسجيل الضريبي: 755-552-334`
      }
    },
    {
      id: 'data-collection',
      title: { en: 'Information We Collect', ar: 'المعلومات التي نجمعها' },
      icon: Database,
      content: {
        en: `We collect information from you in several ways:

Information You Provide Directly:
• Account Information: When you register for our services, we collect your name, email address, phone number, billing address, and payment information.
• Communications: When you contact us for support or inquiries, we collect the information you provide in your messages.
• User Content: Any content you upload to our servers, including website files, databases, and emails.

Information Collected Automatically:
• Log Data: Our servers automatically record information when you access our services, including your IP address, browser type, operating system, referring URLs, and timestamps.
• Cookies: We use cookies and similar tracking technologies to collect information about your browsing behavior. See our Cookie Policy for more details.
• Device Information: We collect information about the device you use to access our services, including device type, operating system, and unique device identifiers.

Information from Third Parties:
• Payment Processors: We receive transaction information from payment processors when you make purchases.
• Domain Registrars: We receive information related to domain registration services.
• Analytics Providers: We receive aggregated analytics data from third-party analytics services.`,
        ar: `نجمع المعلومات منك بعدة طرق:

المعلومات التي تقدمها مباشرة:
• معلومات الحساب: عند التسجيل في خدماتنا، نجمع اسمك وعنوان بريدك الإلكتروني ورقم هاتفك وعنوان الفوترة ومعلومات الدفع.
• الاتصالات: عندما تتصل بنا للحصول على الدعم أو الاستفسارات، نجمع المعلومات التي تقدمها في رسائلك.
• محتوى المستخدم: أي محتوى تقوم بتحميله على خوادمنا، بما في ذلك ملفات الموقع وقواعد البيانات ورسائل البريد الإلكتروني.

المعلومات المجمعة تلقائيًا:
• بيانات السجل: تسجل خوادمنا تلقائيًا المعلومات عند وصولك إلى خدماتنا، بما في ذلك عنوان IP الخاص بك ونوع المتصفح ونظام التشغيل وعناوين URL المُحيلة والطوابع الزمنية.
• ملفات تعريف الارتباط: نستخدم ملفات تعريف الارتباط وتقنيات التتبع المماثلة لجمع معلومات حول سلوك التصفح الخاص بك.
• معلومات الجهاز: نجمع معلومات حول الجهاز الذي تستخدمه للوصول إلى خدماتنا، بما في ذلك نوع الجهاز ونظام التشغيل ومعرفات الجهاز الفريدة.

المعلومات من أطراف ثالثة:
• معالجات الدفع: نتلقى معلومات المعاملات من معالجات الدفع عند إجراء عمليات الشراء.
• مسجلي النطاقات: نتلقى معلومات تتعلق بخدمات تسجيل النطاقات.
• مزودي التحليلات: نتلقى بيانات تحليلية مجمعة من خدمات التحليلات التابعة لجهات خارجية.`
      }
    },
    {
      id: 'data-use',
      title: { en: 'How We Use Your Data', ar: 'كيف نستخدم بياناتك' },
      icon: Eye,
      content: {
        en: `We use your information for the following purposes:

Service Delivery:
• To provide, maintain, and improve our hosting services
• To process transactions and send related information
• To manage your account and provide customer support
• To send technical notices, updates, and security alerts

Communications:
• To respond to your comments, questions, and requests
• To send promotional communications (with your consent)
• To provide news and information about our services

Security and Compliance:
• To detect, prevent, and address technical issues
• To protect against fraudulent, unauthorized, or illegal activity
• To comply with legal obligations and enforce our terms

Analytics and Improvement:
• To understand how users interact with our services
• To develop new products, services, and features
• To measure the effectiveness of our marketing campaigns`,
        ar: `نستخدم معلوماتك للأغراض التالية:

تقديم الخدمة:
• لتوفير خدمات الاستضافة الخاصة بنا وصيانتها وتحسينها
• لمعالجة المعاملات وإرسال المعلومات ذات الصلة
• لإدارة حسابك وتقديم دعم العملاء
• لإرسال الإشعارات الفنية والتحديثات وتنبيهات الأمان

الاتصالات:
• للرد على تعليقاتك وأسئلتك وطلباتك
• لإرسال اتصالات ترويجية (بموافقتك)
• لتوفير الأخبار والمعلومات حول خدماتنا

الأمان والامتثال:
• لاكتشاف المشكلات التقنية ومنعها ومعالجتها
• للحماية من النشاط الاحتيالي أو غير المصرح به أو غير القانوني
• للامتثال للالتزامات القانونية وإنفاذ شروطنا

التحليلات والتحسين:
• لفهم كيفية تفاعل المستخدمين مع خدماتنا
• لتطوير منتجات وخدمات وميزات جديدة
• لقياس فعالية حملاتنا التسويقية`
      }
    },
    {
      id: 'data-sharing',
      title: { en: 'Data Sharing', ar: 'مشاركة البيانات' },
      icon: Globe,
      content: {
        en: `We may share your information in the following circumstances:

Service Providers:
We share information with third-party service providers who perform services on our behalf, including:
• Payment processing
• Data hosting and storage
• Customer support services
• Analytics and marketing services
• Domain registration services

These providers are contractually obligated to protect your information and use it only for the purposes we specify.

Legal Requirements:
We may disclose your information if required to do so by law or in response to valid requests by public authorities (e.g., a court or government agency).

Business Transfers:
If we are involved in a merger, acquisition, or sale of assets, your information may be transferred as part of that transaction.

With Your Consent:
We may share your information with third parties when you have given us your explicit consent to do so.

We do NOT sell your personal information to third parties for their marketing purposes.`,
        ar: `قد نشارك معلوماتك في الظروف التالية:

مزودو الخدمات:
نشارك المعلومات مع مزودي خدمات الطرف الثالث الذين يؤدون خدمات نيابة عنا، بما في ذلك:
• معالجة الدفع
• استضافة البيانات وتخزينها
• خدمات دعم العملاء
• خدمات التحليلات والتسويق
• خدمات تسجيل النطاقات

يلتزم هؤلاء المزودون تعاقديًا بحماية معلوماتك واستخدامها فقط للأغراض التي نحددها.

المتطلبات القانونية:
قد نفصح عن معلوماتك إذا طُلب منا ذلك بموجب القانون أو استجابة لطلبات صالحة من السلطات العامة (مثل محكمة أو وكالة حكومية).

عمليات نقل الأعمال:
إذا كنا مشاركين في عملية اندماج أو استحواذ أو بيع أصول، فقد يتم نقل معلوماتك كجزء من تلك المعاملة.

بموافقتك:
قد نشارك معلوماتك مع أطراف ثالثة عندما تمنحنا موافقتك الصريحة على القيام بذلك.

نحن لا نبيع معلوماتك الشخصية لأطراف ثالثة لأغراضهم التسويقية.`
      }
    },
    {
      id: 'cookies',
      title: { en: 'Cookies & Tracking', ar: 'ملفات تعريف الارتباط والتتبع' },
      icon: FileText,
      content: {
        en: `Cookies and Similar Technologies:

Our websites use "cookies" - small data files stored on your device that help us improve your experience.

Types of Cookies We Use:

Essential Cookies:
Required for the website to function properly. These cannot be disabled.
• Session management
• Security features
• Load balancing

Functional Cookies:
Enable enhanced functionality and personalization.
• Language preferences
• User preferences
• Remember login details

Analytics Cookies:
Help us understand how visitors interact with our website.
• Page views and navigation patterns
• Time spent on pages
• Error tracking

Marketing Cookies:
Used to deliver relevant advertisements and track campaign effectiveness.
• Ad targeting
• Campaign measurement
• Remarketing

Managing Cookies:
You can control cookies through your browser settings. Note that disabling certain cookies may affect website functionality.

Do Not Track:
Some browsers have a "Do Not Track" feature. We currently do not respond to DNT signals, but you can manage your privacy preferences through our cookie settings.`,
        ar: `ملفات تعريف الارتباط والتقنيات المماثلة:

تستخدم مواقعنا الإلكترونية "ملفات تعريف الارتباط" - وهي ملفات بيانات صغيرة مخزنة على جهازك تساعدنا على تحسين تجربتك.

أنواع ملفات تعريف الارتباط التي نستخدمها:

ملفات تعريف الارتباط الأساسية:
مطلوبة لكي يعمل الموقع بشكل صحيح. لا يمكن تعطيلها.
• إدارة الجلسات
• ميزات الأمان
• موازنة التحميل

ملفات تعريف الارتباط الوظيفية:
تمكّن الوظائف المحسنة والتخصيص.
• تفضيلات اللغة
• تفضيلات المستخدم
• تذكر تفاصيل تسجيل الدخول

ملفات تعريف الارتباط التحليلية:
تساعدنا على فهم كيفية تفاعل الزوار مع موقعنا.
• مشاهدات الصفحات وأنماط التنقل
• الوقت المستغرق في الصفحات
• تتبع الأخطاء

ملفات تعريف الارتباط التسويقية:
تُستخدم لتقديم إعلانات ذات صلة وتتبع فعالية الحملات.
• استهداف الإعلانات
• قياس الحملات
• إعادة التسويق

إدارة ملفات تعريف الارتباط:
يمكنك التحكم في ملفات تعريف الارتباط من خلال إعدادات المتصفح. لاحظ أن تعطيل بعض ملفات تعريف الارتباط قد يؤثر على وظائف الموقع.`
      }
    },
    {
      id: 'security',
      title: { en: 'Data Security', ar: 'أمان البيانات' },
      icon: Lock,
      content: {
        en: `Security Measures:

We implement appropriate technical and organizational measures to protect your personal data against unauthorized access, alteration, disclosure, or destruction.

Technical Safeguards:
• SSL/TLS encryption for data in transit
• Encryption at rest for sensitive data
• Firewalls and intrusion detection systems
• Regular security audits and penetration testing
• Secure data centers with physical access controls

Organizational Measures:
• Employee training on data protection
• Access controls based on role and necessity
• Incident response procedures
• Regular review of security practices

Password Security:
• Passwords are stored using industry-standard hashing algorithms
• We never store passwords in plain text
• We recommend using strong, unique passwords

Data Breach Response:
In the event of a data breach that affects your personal information, we will:
• Notify affected users within 72 hours where required by law
• Provide information about the nature of the breach
• Describe the measures taken to address the breach
• Offer guidance on steps you can take to protect yourself

While we strive to protect your information, no method of transmission over the Internet or electronic storage is 100% secure. We cannot guarantee absolute security.`,
        ar: `تدابير الأمان:

نقوم بتنفيذ التدابير التقنية والتنظيمية المناسبة لحماية بياناتك الشخصية من الوصول غير المصرح به أو التغيير أو الإفصاح أو التدمير.

الضمانات التقنية:
• تشفير SSL/TLS للبيانات أثناء النقل
• التشفير في حالة السكون للبيانات الحساسة
• جدران الحماية وأنظمة كشف التسلل
• عمليات تدقيق أمنية منتظمة واختبار الاختراق
• مراكز بيانات آمنة مع ضوابط الوصول المادي

التدابير التنظيمية:
• تدريب الموظفين على حماية البيانات
• ضوابط الوصول بناءً على الدور والضرورة
• إجراءات الاستجابة للحوادث
• المراجعة المنتظمة لممارسات الأمان

أمان كلمة المرور:
• يتم تخزين كلمات المرور باستخدام خوارزميات التجزئة القياسية في الصناعة
• لا نخزن كلمات المرور أبدًا بنص عادي
• نوصي باستخدام كلمات مرور قوية وفريدة

الاستجابة لخرق البيانات:
في حالة حدوث خرق للبيانات يؤثر على معلوماتك الشخصية، سنقوم بما يلي:
• إخطار المستخدمين المتأثرين خلال 72 ساعة حيثما يقتضي القانون
• تقديم معلومات حول طبيعة الخرق
• وصف التدابير المتخذة لمعالجة الخرق
• تقديم إرشادات حول الخطوات التي يمكنك اتخاذها لحماية نفسك

بينما نسعى جاهدين لحماية معلوماتك، لا توجد طريقة نقل عبر الإنترنت أو تخزين إلكتروني آمنة بنسبة 100٪. لا يمكننا ضمان الأمان المطلق.`
      }
    },
    {
      id: 'retention',
      title: { en: 'Data Retention', ar: 'الاحتفاظ بالبيانات' },
      icon: Database,
      content: {
        en: `How Long We Keep Your Data:

We retain your personal data only for as long as necessary to fulfill the purposes for which it was collected, including:

Account Data:
• Active accounts: Data retained while your account is active
• Closed accounts: Basic records retained for 7 years for legal and tax purposes
• Billing records: Retained for 7 years as required by tax regulations

Service Data:
• Server logs: Retained for 90 days for security and troubleshooting
• Backup data: Retained according to your service plan (typically 7-30 days)
• Support tickets: Retained for 3 years after resolution

Marketing Data:
• Email preferences: Retained until you unsubscribe
• Analytics data: Aggregated and anonymized after 26 months

Legal Requirements:
We may retain certain data longer if required by law or to establish, exercise, or defend legal claims.

Deletion Requests:
When you request deletion of your data:
• We will delete or anonymize your data within 30 days
• Some data may be retained in backups for up to 90 days
• Certain data may be retained as required by law`,
        ar: `كم من الوقت نحتفظ ببياناتك:

نحتفظ ببياناتك الشخصية فقط طالما كان ذلك ضروريًا لتحقيق الأغراض التي تم جمعها من أجلها، بما في ذلك:

بيانات الحساب:
• الحسابات النشطة: يتم الاحتفاظ بالبيانات طالما أن حسابك نشط
• الحسابات المغلقة: يتم الاحتفاظ بالسجلات الأساسية لمدة 7 سنوات للأغراض القانونية والضريبية
• سجلات الفوترة: يتم الاحتفاظ بها لمدة 7 سنوات وفقًا للوائح الضريبية

بيانات الخدمة:
• سجلات الخادم: يتم الاحتفاظ بها لمدة 90 يومًا للأمان واستكشاف الأخطاء وإصلاحها
• بيانات النسخ الاحتياطي: يتم الاحتفاظ بها وفقًا لخطة الخدمة الخاصة بك (عادةً 7-30 يومًا)
• تذاكر الدعم: يتم الاحتفاظ بها لمدة 3 سنوات بعد الحل

بيانات التسويق:
• تفضيلات البريد الإلكتروني: يتم الاحتفاظ بها حتى إلغاء الاشتراك
• بيانات التحليلات: يتم تجميعها وإخفاء هويتها بعد 26 شهرًا

المتطلبات القانونية:
قد نحتفظ ببعض البيانات لفترة أطول إذا كان القانون يتطلب ذلك أو لإنشاء أو ممارسة أو الدفاع عن المطالبات القانونية.

طلبات الحذف:
عندما تطلب حذف بياناتك:
• سنقوم بحذف بياناتك أو إخفاء هويتها خلال 30 يومًا
• قد يتم الاحتفاظ ببعض البيانات في النسخ الاحتياطية لمدة تصل إلى 90 يومًا
• قد يتم الاحتفاظ ببعض البيانات وفقًا لما يقتضيه القانون`
      }
    },
    {
      id: 'your-rights',
      title: { en: 'Your Rights', ar: 'حقوقك' },
      icon: Scale,
      content: {
        en: `Your Privacy Rights:

You have the following rights regarding your personal data:

Right to Access:
You can request a copy of the personal data we hold about you.

Right to Rectification:
You can request that we correct any inaccurate or incomplete personal data.

Right to Erasure:
You can request that we delete your personal data, subject to certain exceptions.

Right to Restrict Processing:
You can request that we limit how we use your personal data.

Right to Data Portability:
You can request a copy of your data in a structured, commonly used format.

Right to Object:
You can object to the processing of your personal data for certain purposes.

Right to Withdraw Consent:
Where we rely on your consent, you can withdraw it at any time.

How to Exercise Your Rights:
• Log into your account and access privacy settings
• Contact us at privacy@progineous.com
• Submit a request through our support portal

We will respond to your request within 30 days. We may need to verify your identity before processing your request.`,
        ar: `حقوق الخصوصية الخاصة بك:

لديك الحقوق التالية فيما يتعلق ببياناتك الشخصية:

حق الوصول:
يمكنك طلب نسخة من البيانات الشخصية التي نحتفظ بها عنك.

حق التصحيح:
يمكنك طلب تصحيح أي بيانات شخصية غير دقيقة أو غير كاملة.

حق المحو:
يمكنك طلب حذف بياناتك الشخصية، مع مراعاة بعض الاستثناءات.

حق تقييد المعالجة:
يمكنك طلب تحديد كيفية استخدامنا لبياناتك الشخصية.

حق نقل البيانات:
يمكنك طلب نسخة من بياناتك بتنسيق منظم وشائع الاستخدام.

حق الاعتراض:
يمكنك الاعتراض على معالجة بياناتك الشخصية لأغراض معينة.

حق سحب الموافقة:
حيث نعتمد على موافقتك، يمكنك سحبها في أي وقت.

كيفية ممارسة حقوقك:
• تسجيل الدخول إلى حسابك والوصول إلى إعدادات الخصوصية
• الاتصال بنا على privacy@progineous.com
• تقديم طلب من خلال بوابة الدعم الخاصة بنا

سنرد على طلبك خلال 30 يومًا. قد نحتاج إلى التحقق من هويتك قبل معالجة طلبك.`
      }
    },
    {
      id: 'children',
      title: { en: 'Children\'s Privacy', ar: 'خصوصية الأطفال' },
      icon: Users,
      content: {
        en: `Children's Privacy:

Our services are not intended for children under the age of 16. We do not knowingly collect personal information from children under 16.

If you are a parent or guardian and believe that your child has provided us with personal information, please contact us immediately at privacy@progineous.com.

If we become aware that we have collected personal information from a child under 16, we will take steps to delete that information as soon as possible.

Parental Consent:
If we need to collect information from children under 16 for any reason, we will obtain verifiable parental consent before collecting such information.`,
        ar: `خصوصية الأطفال:

خدماتنا غير موجهة للأطفال دون سن 16 عامًا. نحن لا نجمع معلومات شخصية من الأطفال دون سن 16 عامًا عن علم.

إذا كنت والدًا أو وصيًا وتعتقد أن طفلك قد زودنا بمعلومات شخصية، يرجى الاتصال بنا فورًا على privacy@progineous.com.

إذا علمنا أننا جمعنا معلومات شخصية من طفل دون سن 16 عامًا، فسنتخذ خطوات لحذف تلك المعلومات في أقرب وقت ممكن.

موافقة الوالدين:
إذا احتجنا لجمع معلومات من أطفال دون سن 16 عامًا لأي سبب، فسنحصل على موافقة الوالدين القابلة للتحقق قبل جمع هذه المعلومات.`
      }
    },
    {
      id: 'international',
      title: { en: 'International Transfers', ar: 'النقل الدولي' },
      icon: Globe,
      content: {
        en: `International Data Transfers:

Your information may be transferred to and processed in countries other than your country of residence. These countries may have data protection laws that are different from the laws of your country.

Safeguards:
When we transfer your data internationally, we implement appropriate safeguards to protect your information:

• Standard Contractual Clauses: We use EU-approved standard contractual clauses with our service providers.
• Data Processing Agreements: We enter into data processing agreements that require the same level of protection.
• Security Measures: We ensure that appropriate security measures are in place regardless of where data is processed.

Data Storage Locations:
Our primary data centers are located in:
• Egypt (Primary)
• Europe (Backup/CDN)
• United States (CDN partners)

You can request information about the specific safeguards we use for international transfers by contacting us.`,
        ar: `النقل الدولي للبيانات:

قد يتم نقل معلوماتك ومعالجتها في بلدان غير بلد إقامتك. قد يكون لهذه البلدان قوانين حماية بيانات مختلفة عن قوانين بلدك.

الضمانات:
عندما ننقل بياناتك دوليًا، ننفذ ضمانات مناسبة لحماية معلوماتك:

• البنود التعاقدية القياسية: نستخدم البنود التعاقدية القياسية المعتمدة من الاتحاد الأوروبي مع مزودي خدماتنا.
• اتفاقيات معالجة البيانات: ندخل في اتفاقيات معالجة البيانات التي تتطلب نفس مستوى الحماية.
• تدابير الأمان: نضمن وجود تدابير أمنية مناسبة بغض النظر عن مكان معالجة البيانات.

مواقع تخزين البيانات:
تقع مراكز البيانات الرئيسية لدينا في:
• مصر (الأساسي)
• أوروبا (النسخ الاحتياطي/CDN)
• الولايات المتحدة (شركاء CDN)

يمكنك طلب معلومات حول الضمانات المحددة التي نستخدمها للنقل الدولي عن طريق الاتصال بنا.`
      }
    },
    {
      id: 'changes',
      title: { en: 'Policy Changes', ar: 'تغييرات السياسة' },
      icon: Bell,
      content: {
        en: `Changes to This Privacy Policy:

We may update this Privacy Policy from time to time to reflect changes in our practices, technologies, legal requirements, or other factors.

How We Notify You:
• Material Changes: We will notify you by email or by posting a prominent notice on our website before the changes become effective.
• Minor Changes: We will update the "Last Updated" date at the bottom of this page.

Your Continued Use:
Your continued use of our services after any changes to this Privacy Policy constitutes your acceptance of the updated policy.

Review Regularly:
We encourage you to review this Privacy Policy periodically to stay informed about how we are protecting your information.

Previous Versions:
You can request copies of previous versions of this Privacy Policy by contacting us.`,
        ar: `التغييرات على سياسة الخصوصية هذه:

قد نقوم بتحديث سياسة الخصوصية هذه من وقت لآخر لتعكس التغييرات في ممارساتنا أو تقنياتنا أو المتطلبات القانونية أو عوامل أخرى.

كيف نخطرك:
• التغييرات الجوهرية: سنخطرك عبر البريد الإلكتروني أو عن طريق نشر إشعار بارز على موقعنا قبل أن تصبح التغييرات سارية المفعول.
• التغييرات الطفيفة: سنقوم بتحديث تاريخ "آخر تحديث" في أسفل هذه الصفحة.

استمرار استخدامك:
يعتبر استمرارك في استخدام خدماتنا بعد أي تغييرات على سياسة الخصوصية هذه قبولاً منك للسياسة المحدثة.

المراجعة بانتظام:
نشجعك على مراجعة سياسة الخصوصية هذه بشكل دوري للبقاء على اطلاع حول كيفية حمايتنا لمعلوماتك.

الإصدارات السابقة:
يمكنك طلب نسخ من الإصدارات السابقة لسياسة الخصوصية هذه عن طريق الاتصال بنا.`
      }
    },
    {
      id: 'contact',
      title: { en: 'Contact Us', ar: 'اتصل بنا' },
      icon: Mail,
      content: {
        en: `Contact Information:

If you have any questions, concerns, or requests regarding this Privacy Policy or our data practices, please contact us:

Pro Gineous
Data Protection Inquiries

Address:
9 Mustafa Kamel Street
Balwalidain Ihsanah Tower
Beni Suef, Egypt

Email:
privacy@progineous.com

Support Portal:
https://app.progineous.com/submitticket.php

Company Information:
Commercial Register: 90088
Tax Registration: 755-552-334

Response Time:
We aim to respond to all privacy-related inquiries within 30 days.

Complaints:
If you are not satisfied with our response, you have the right to lodge a complaint with the relevant data protection authority in your jurisdiction.`,
        ar: `معلومات الاتصال:

إذا كان لديك أي أسئلة أو مخاوف أو طلبات بخصوص سياسة الخصوصية هذه أو ممارسات البيانات الخاصة بنا، يرجى الاتصال بنا:

برو جينيوس
استفسارات حماية البيانات

العنوان:
9 شارع مصطفى كامل
برج بالوالدين إحسانًا
بني سويف، مصر

البريد الإلكتروني:
privacy@progineous.com

بوابة الدعم:
https://app.progineous.com/submitticket.php

معلومات الشركة:
السجل التجاري: 90088
رقم التسجيل الضريبي: 755-552-334

وقت الاستجابة:
نهدف للرد على جميع الاستفسارات المتعلقة بالخصوصية خلال 30 يومًا.

الشكاوى:
إذا لم تكن راضيًا عن ردنا، فلديك الحق في تقديم شكوى إلى هيئة حماية البيانات المختصة في منطقتك.`
      }
    }
  ];

  // Handle scroll spy
  useEffect(() => {
    const handleScroll = () => {
      const sectionElements = sections.map(section => ({
        id: section.id,
        element: document.getElementById(section.id)
      }));

      const scrollPosition = window.scrollY + 200;

      for (let i = sectionElements.length - 1; i >= 0; i--) {
        const section = sectionElements[i];
        if (section.element && section.element.offsetTop <= scrollPosition) {
          setActiveSection(section.id);
          break;
        }
      }
    };

    window.addEventListener('scroll', handleScroll);
    return () => window.removeEventListener('scroll', handleScroll);
  }, []);

  const scrollToSection = (sectionId: string) => {
    const element = document.getElementById(sectionId);
    if (element) {
      const offset = 100;
      const elementPosition = element.getBoundingClientRect().top + window.pageYOffset;
      window.scrollTo({ top: elementPosition - offset, behavior: 'smooth' });
      setMobileMenuOpen(false);
    }
  };

  const jsonLd = {
    '@context': 'https://schema.org',
    '@graph': [
      {
        '@type': 'WebPage',
        '@id': `https://progineous.com/${locale}/privacy`,
        name: isRTL ? 'سياسة الخصوصية | بروجينيوس' : 'Privacy Policy | Pro Gineous',
        description: isRTL
          ? 'كيف نجمع ونستخدم ونحمي بياناتك الشخصية في بروجينيوس'
          : 'How Pro Gineous collects, uses, and protects your personal data',
        url: `https://progineous.com/${locale}/privacy`,
        inLanguage: isRTL ? 'ar' : 'en',
        isPartOf: {
          '@type': 'WebSite',
          name: 'Pro Gineous',
          url: 'https://progineous.com',
        },
        about: {
          '@type': 'Thing',
          name: isRTL ? 'خصوصية البيانات وحمايتها' : 'Data Privacy and Protection',
        },
      },
      {
        '@type': 'BreadcrumbList',
        itemListElement: [
          {
            '@type': 'ListItem',
            position: 1,
            name: isRTL ? 'الرئيسية' : 'Home',
            item: `https://progineous.com/${locale}`,
          },
          {
            '@type': 'ListItem',
            position: 2,
            name: isRTL ? 'سياسة الخصوصية' : 'Privacy Policy',
            item: `https://progineous.com/${locale}/privacy`,
          },
        ],
      },
      {
        '@type': 'Organization',
        '@id': 'https://progineous.com/#organization',
        name: 'Pro Gineous',
        url: 'https://progineous.com',
        logo: 'https://progineous.com/pro%20Gineous_logo.svg',
        contactPoint: {
          '@type': 'ContactPoint',
          contactType: 'customer service',
          availableLanguage: ['English', 'Arabic'],
        },
      },
    ],
  };

  return (
    <div className={cn('min-h-screen bg-gray-50', isRTL && 'rtl')}>
      {/* JSON-LD Structured Data */}
      <script
        type="application/ld+json"
        dangerouslySetInnerHTML={{ __html: JSON.stringify(jsonLd) }}
      />
      {/* Header */}
      <header className="bg-white border-b border-gray-200 sticky top-0 z-30">
        <div className="max-w-7xl mx-auto px-4 py-4 flex items-center justify-between">
          <Link href={`/${locale}`} className="flex items-center gap-2 text-gray-600 hover:text-[#1d71b8] transition-colors">
            <ArrowLeft className={cn('w-5 h-5', isRTL && 'rotate-180')} />
            <span className="text-sm font-medium">{isRTL ? 'العودة للرئيسية' : 'Back to Home'}</span>
          </Link>
          <Link href={`/${locale}`}>
            <img src="/pro Gineous_logo.svg" alt="Pro Gineous" className="h-8 w-auto" />
          </Link>
          {/* Mobile menu button */}
          <button 
            className="lg:hidden p-2 text-gray-600"
            onClick={() => setMobileMenuOpen(!mobileMenuOpen)}
          >
            {mobileMenuOpen ? <X className="w-6 h-6" /> : <Menu className="w-6 h-6" />}
          </button>
        </div>
      </header>

      {/* Hero Section */}
      <div className="bg-linear-to-br from-[#1d71b8] to-[#1557a0] text-white py-16">
        <div className="max-w-7xl mx-auto px-4 text-center">
          <div className="flex justify-center mb-6">
            <div className="p-4 bg-white/10 rounded-2xl backdrop-blur-sm">
              <Shield className="w-12 h-12" />
            </div>
          </div>
          <h1 className="text-4xl md:text-5xl font-bold mb-4">
            {isRTL ? 'سياسة الخصوصية' : 'Privacy Policy'}
          </h1>
          <p className="text-lg text-white/80 max-w-2xl mx-auto">
            {isRTL 
              ? 'نحن ملتزمون بحماية خصوصيتك وبياناتك الشخصية'
              : 'We are committed to protecting your privacy and personal data'
            }
          </p>
          <p className="mt-4 text-sm text-white/60">
            {isRTL ? 'آخر تحديث: 1 يناير 2025' : 'Last Updated: January 1, 2025'}
          </p>
        </div>
      </div>

      <div className="max-w-7xl mx-auto px-4 py-8">
        <div className="flex gap-8">
          {/* Sidebar Navigation - Desktop */}
          <aside className="hidden lg:block w-72 shrink-0">
            <div className="sticky top-24">
              <nav className="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                <div className="p-4 bg-gray-50 border-b border-gray-200">
                  <h3 className="font-semibold text-gray-900">
                    {isRTL ? 'المحتويات' : 'Contents'}
                  </h3>
                </div>
                <div className="p-2 max-h-[calc(100vh-200px)] overflow-y-auto">
                  {sections.map((section, index) => {
                    const Icon = section.icon;
                    return (
                      <button
                        key={section.id}
                        onClick={() => scrollToSection(section.id)}
                        className={cn(
                          'w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all',
                          activeSection === section.id
                            ? 'bg-[#1d71b8] text-white shadow-md'
                            : 'text-gray-600 hover:bg-gray-100'
                        )}
                      >
                        <span className={cn(
                          'flex items-center justify-center w-6 h-6 rounded-md text-xs font-bold shrink-0',
                          activeSection === section.id
                            ? 'bg-white/20 text-white'
                            : 'bg-gray-100 text-gray-500'
                        )}>
                          {index + 1}
                        </span>
                        <span className="truncate font-medium">{section.title[locale as 'en' | 'ar']}</span>
                      </button>
                    );
                  })}
                </div>
              </nav>
            </div>
          </aside>

          {/* Mobile Navigation */}
          {mobileMenuOpen && (
            <div className="lg:hidden fixed inset-0 top-16.25 bg-white z-20 overflow-y-auto">
              <nav className="p-4">
                <h3 className="font-semibold text-gray-900 mb-4 px-2">
                  {isRTL ? 'المحتويات' : 'Contents'}
                </h3>
                {sections.map((section, index) => (
                  <button
                    key={section.id}
                    onClick={() => scrollToSection(section.id)}
                    className={cn(
                      'w-full flex items-center gap-3 px-4 py-3 rounded-lg text-sm mb-1',
                      activeSection === section.id
                        ? 'bg-[#1d71b8] text-white'
                        : 'text-gray-600 hover:bg-gray-100'
                    )}
                  >
                    <span className={cn(
                      'flex items-center justify-center w-7 h-7 rounded-md text-xs font-bold',
                      activeSection === section.id
                        ? 'bg-white/20 text-white'
                        : 'bg-gray-100 text-gray-500'
                    )}>
                      {index + 1}
                    </span>
                    <span className="font-medium">{section.title[locale as 'en' | 'ar']}</span>
                  </button>
                ))}
              </nav>
            </div>
          )}

          {/* Main Content */}
          <main className="flex-1 min-w-0">
            <div className="space-y-8">
              {sections.map((section, index) => {
                const Icon = section.icon;
                return (
                  <section
                    key={section.id}
                    id={section.id}
                    className="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden scroll-mt-28"
                  >
                    <div className="p-6 md:p-8">
                      <div className="flex items-start gap-4 mb-6">
                        <div className={cn(
                          'flex items-center justify-center w-12 h-12 rounded-xl shrink-0',
                          'bg-linear-to-br from-[#1d71b8] to-[#1557a0] text-white shadow-lg'
                        )}>
                          <Icon className="w-6 h-6" />
                        </div>
                        <div>
                          <span className="text-sm font-semibold text-[#1d71b8]">
                            {isRTL ? `القسم ${index + 1}` : `Section ${index + 1}`}
                          </span>
                          <h2 className="text-2xl font-bold text-gray-900">
                            {section.title[locale as 'en' | 'ar']}
                          </h2>
                        </div>
                      </div>
                      <div className="prose prose-gray max-w-none">
                        <div className="text-gray-600 leading-relaxed whitespace-pre-line">
                          {isRTL ? <RTLText>{section.content[locale as 'en' | 'ar']}</RTLText> : section.content[locale as 'en' | 'ar']}
                        </div>
                      </div>
                    </div>
                  </section>
                );
              })}
            </div>

            {/* Related Links */}
            <div className="mt-12 bg-white rounded-xl border border-gray-200 shadow-sm p-6 md:p-8">
              <h3 className="text-xl font-bold text-gray-900 mb-6">
                {isRTL ? 'سياسات ذات صلة' : 'Related Policies'}
              </h3>
              <div className="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <Link
                  href={`/${locale}/terms`}
                  className="flex items-center gap-3 p-4 rounded-xl border border-gray-200 hover:border-[#1d71b8] hover:bg-blue-50 transition-all group"
                >
                  <div className="p-2 bg-gray-100 rounded-lg group-hover:bg-[#1d71b8] group-hover:text-white transition-colors">
                    <FileText className="w-5 h-5" />
                  </div>
                  <div>
                    <h4 className="font-semibold text-gray-900 group-hover:text-[#1d71b8]">
                      {isRTL ? 'شروط الخدمة' : 'Terms of Service'}
                    </h4>
                    <p className="text-sm text-gray-500">
                      {isRTL ? 'الشروط والأحكام العامة' : 'General terms and conditions'}
                    </p>
                  </div>
                  <ChevronRight className={cn('w-5 h-5 text-gray-400 ms-auto', isRTL && 'rotate-180')} />
                </Link>
                <Link
                  href={`/${locale}/aup`}
                  className="flex items-center gap-3 p-4 rounded-xl border border-gray-200 hover:border-[#1d71b8] hover:bg-blue-50 transition-all group"
                >
                  <div className="p-2 bg-gray-100 rounded-lg group-hover:bg-[#1d71b8] group-hover:text-white transition-colors">
                    <Shield className="w-5 h-5" />
                  </div>
                  <div>
                    <h4 className="font-semibold text-gray-900 group-hover:text-[#1d71b8]">
                      {isRTL ? 'سياسة الاستخدام المقبول' : 'Acceptable Use Policy'}
                    </h4>
                    <p className="text-sm text-gray-500">
                      {isRTL ? 'إرشادات الاستخدام' : 'Usage guidelines'}
                    </p>
                  </div>
                  <ChevronRight className={cn('w-5 h-5 text-gray-400 ms-auto', isRTL && 'rotate-180')} />
                </Link>
                <Link
                  href={`/${locale}/dmca`}
                  className="flex items-center gap-3 p-4 rounded-xl border border-gray-200 hover:border-[#1d71b8] hover:bg-blue-50 transition-all group"
                >
                  <div className="p-2 bg-gray-100 rounded-lg group-hover:bg-[#1d71b8] group-hover:text-white transition-colors">
                    <FileText className="w-5 h-5" />
                  </div>
                  <div>
                    <h4 className="font-semibold text-gray-900 group-hover:text-[#1d71b8]">
                      {isRTL ? 'سياسة DMCA' : 'DMCA Policy'}
                    </h4>
                    <p className="text-sm text-gray-500">
                      {isRTL ? 'حقوق النشر والملكية الفكرية' : 'Copyright and intellectual property'}
                    </p>
                  </div>
                  <ChevronRight className={cn('w-5 h-5 text-gray-400 ms-auto', isRTL && 'rotate-180')} />
                </Link>
                <Link
                  href={`/${locale}/refund`}
                  className="flex items-center gap-3 p-4 rounded-xl border border-gray-200 hover:border-[#1d71b8] hover:bg-blue-50 transition-all group"
                >
                  <div className="p-2 bg-gray-100 rounded-lg group-hover:bg-[#1d71b8] group-hover:text-white transition-colors">
                    <FileText className="w-5 h-5" />
                  </div>
                  <div>
                    <h4 className="font-semibold text-gray-900 group-hover:text-[#1d71b8]">
                      {isRTL ? 'سياسة الاسترداد' : 'Refund & Billing'}
                    </h4>
                    <p className="text-sm text-gray-500">
                      {isRTL ? 'المبالغ المستردة والفوترة' : 'Refunds and billing'}
                    </p>
                  </div>
                  <ChevronRight className={cn('w-5 h-5 text-gray-400 ms-auto', isRTL && 'rotate-180')} />
                </Link>
                <Link
                  href={`/${locale}/affiliate`}
                  className="flex items-center gap-3 p-4 rounded-xl border border-gray-200 hover:border-[#1d71b8] hover:bg-blue-50 transition-all group"
                >
                  <div className="p-2 bg-gray-100 rounded-lg group-hover:bg-[#1d71b8] group-hover:text-white transition-colors">
                    <FileText className="w-5 h-5" />
                  </div>
                  <div>
                    <h4 className="font-semibold text-gray-900 group-hover:text-[#1d71b8]">
                      {isRTL ? 'سياسة الأفلييت' : 'Affiliate Policy'}
                    </h4>
                    <p className="text-sm text-gray-500">
                      {isRTL ? 'برنامج الشراكة والعمولات' : 'Partnership and commissions'}
                    </p>
                  </div>
                  <ChevronRight className={cn('w-5 h-5 text-gray-400 ms-auto', isRTL && 'rotate-180')} />
                </Link>
                <Link
                  href={`/${locale}/refer-friend`}
                  className="flex items-center gap-3 p-4 rounded-xl border border-gray-200 hover:border-[#1d71b8] hover:bg-blue-50 transition-all group"
                >
                  <div className="p-2 bg-gray-100 rounded-lg group-hover:bg-[#1d71b8] group-hover:text-white transition-colors">
                    <FileText className="w-5 h-5" />
                  </div>
                  <div>
                    <h4 className="font-semibold text-gray-900 group-hover:text-[#1d71b8]">
                      {isRTL ? 'إحالة صديق' : 'Refer a Friend'}
                    </h4>
                    <p className="text-sm text-gray-500">
                      {isRTL ? 'احصل على مكافآت' : 'Get rewards'}
                    </p>
                  </div>
                  <ChevronRight className={cn('w-5 h-5 text-gray-400 ms-auto', isRTL && 'rotate-180')} />
                </Link>
              </div>
            </div>
          </main>
        </div>
      </div>
    </div>
  );
}
