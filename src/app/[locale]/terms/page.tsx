'use client';

import { useState, useEffect } from 'react';
import { useLocale } from 'next-intl';
import Link from 'next/link';
import { ArrowLeft, ChevronRight, Menu, X } from 'lucide-react';
import { cn } from '@/lib/utils';
import { RTLText } from '@/components/ui/RTLText';

export default function TermsPage() {
  const locale = useLocale();
  const isRTL = locale === 'ar';
  const [activeSection, setActiveSection] = useState('purpose');
  const [mobileMenuOpen, setMobileMenuOpen] = useState(false);

  const sections = [
    {
      id: 'purpose',
      title: { en: 'Purpose', ar: 'الغرض' },
      content: {
        en: `These Terms of Service ("TOS") represent the basis of a contract between you, or the entity on whose behalf you are executing this agreement ("you" or "your"), and Pro Gineous ("Pro Gineous", "we", "us", or "our").

By corresponding with us, browsing our web properties, or using our Services you accept these TOS and you agree to abide by the then-current version of: these TOS, our Acceptable Use Policy, our Support Policy, our Refund & Billing Policy, our Privacy Policy, and our Server Maintenance Policy, each of which is integrated into the TOS by reference (together, the "Policies").

These Policies may be modified from time-to-time by us and, by continuing to use our Services, you agree to be bound by the modifications. The most recent version of these TOS can always be found here.`,
        ar: `تمثل شروط الخدمة هذه ("TOS") أساس العقد بينك أو بين الكيان الذي تنفذ هذه الاتفاقية نيابة عنه ("أنت" أو "الخاص بك")، وبين برو جينيوس ("برو جينيوس"، "نحن"، "لنا"، أو "الخاصة بنا").

من خلال التواصل معنا أو تصفح مواقعنا الإلكترونية أو استخدام خدماتنا، فإنك تقبل شروط الخدمة هذه وتوافق على الالتزام بالإصدار الحالي من: شروط الخدمة هذه، وسياسة الاستخدام المقبول، وسياسة الدعم، وسياسة الاسترداد والفوترة، وسياسة الخصوصية، وسياسة صيانة الخادم.

قد يتم تعديل هذه السياسات من وقت لآخر من قبلنا، ومن خلال الاستمرار في استخدام خدماتنا، فإنك توافق على الالتزام بالتعديلات.`
      }
    },
    {
      id: 'customers',
      title: { en: 'Customers', ar: 'العملاء' },
      content: {
        en: `While we facilitate your business on the Internet, we are an independent contractor. We only have control of the products and services we provide directly, and are not liable for your actions, the actions of third party service providers, or the actions of individuals who use your instance of such products and services ("End Users").

You are responsible for ensuring that your End Users comply with these Terms of Service and all applicable laws and regulations.`,
        ar: `بينما نسهل عملك على الإنترنت، نحن متعاقد مستقل. لدينا فقط السيطرة على المنتجات والخدمات التي نقدمها مباشرة، ولسنا مسؤولين عن أفعالك أو أفعال مقدمي الخدمات من الأطراف الثالثة أو أفعال الأفراد الذين يستخدمون نسختك من هذه المنتجات والخدمات ("المستخدمين النهائيين").

أنت مسؤول عن ضمان امتثال المستخدمين النهائيين لشروط الخدمة هذه وجميع القوانين واللوائح المعمول بها.`
      }
    },
    {
      id: 'services',
      title: { en: 'Services', ar: 'الخدمات' },
      content: {
        en: `Pro Gineous provides a number of services and products to its customers, which are collectively referred to in these TOS as the "Services". Regardless of whether you pay for a Service or it is provided as part of a package, as a standalone full price or discounted service or for free, any Service you request or allow to be provided by Pro Gineous is included as part of the "Services" we refer to in these TOS and the other Policies.

Services Offered:
• Shared Web Hosting
• VPS Hosting (Managed and Unmanaged)
• Reseller Hosting
• Cloud Hosting
• Dedicated Server Hosting
• Email Hosting
• Domain Registrations
• SSL Certificates

Domain Name Services:
We resell domain names through accredited registrars. By using our Domain Name Services, you agree to be bound by our partner registrar's domain name registration policies and procedures. Because of the mechanics of domain name registration, we cannot guarantee that your domain name will be registered.

After registration, it is your responsibility to ensure your domain name does not lapse and is timely renewed. We are not responsible for any lapse or any damages caused by any lapse.`,
        ar: `تقدم برو جينيوس عدداً من الخدمات والمنتجات لعملائها، والتي يشار إليها مجتمعة في شروط الخدمة هذه باسم "الخدمات". بغض النظر عما إذا كنت تدفع مقابل خدمة أو يتم تقديمها كجزء من حزمة، كخدمة مستقلة بالسعر الكامل أو مخفضة أو مجانية، فإن أي خدمة تطلبها أو تسمح بتقديمها من قبل برو جينيوس مشمولة كجزء من "الخدمات".

الخدمات المقدمة:
• استضافة الويب المشتركة
• استضافة VPS (مُدارة وغير مُدارة)
• استضافة الموزعين
• الاستضافة السحابية
• استضافة الخوادم المخصصة
• استضافة البريد الإلكتروني
• تسجيل النطاقات
• شهادات SSL

خدمات أسماء النطاقات:
نحن نعيد بيع أسماء النطاقات من خلال مسجلين معتمدين. باستخدام خدمات أسماء النطاقات الخاصة بنا، فإنك توافق على الالتزام بسياسات وإجراءات تسجيل أسماء النطاقات الخاصة بشريكنا المسجل.

بعد التسجيل، تقع على عاتقك مسؤولية التأكد من عدم انتهاء صلاحية اسم النطاق الخاص بك وتجديده في الوقت المناسب.`
      }
    },
    {
      id: 'hosting-terms',
      title: { en: 'Hosting Terms', ar: 'شروط الاستضافة' },
      content: {
        en: `Terms That Apply to All Hosting Services:

• Bandwidth Allocation: Our Hosting accounts are allocated bandwidth depending on the package you select. The bandwidth for Services purchased does not rollover and is not creditable across periods. In the event you require more bandwidth than you have purchased, your account may be suspended until the next period, or you may purchase additional bandwidth by upgrading your account.

• IP Addresses: We will provide, as part of the Service cost, the number of primary IP addresses included in the plan you select. You may request additional IP addresses for an additional fee. If we need to change one of your assigned IP addresses we will notify you of the change by email.

• Resource Usage: In using our hosting Services, you may not place excessive burdens on our CPUs, servers, or other resources. You understand that bandwidth, connection speeds, and other similar indices of capacity are maximum numbers. Consistently reaching these capacity numbers may result in restrictions on your use of the Services.

• Backups: For shared web hosting and reseller hosting services, we will provide complimentary backups of your data. These backups are limited to an aggregate 50GB quota. If you exceed 50GB of disk usage in your account, your account will no longer be backed up.`,
        ar: `الشروط التي تنطبق على جميع خدمات الاستضافة:

• تخصيص عرض النطاق الترددي: يتم تخصيص عرض النطاق الترددي لحسابات الاستضافة الخاصة بنا حسب الحزمة التي تختارها. لا يتم ترحيل عرض النطاق الترددي للخدمات المشتراة ولا يمكن احتسابه عبر الفترات. في حالة احتياجك لعرض نطاق ترددي أكثر مما اشتريته، قد يتم تعليق حسابك حتى الفترة التالية، أو يمكنك شراء عرض نطاق ترددي إضافي عن طريق ترقية حسابك.

• عناوين IP: سنوفر، كجزء من تكلفة الخدمة، عدد عناوين IP الأساسية المضمنة في الخطة التي تختارها. يمكنك طلب عناوين IP إضافية مقابل رسوم إضافية.

• استخدام الموارد: عند استخدام خدمات الاستضافة الخاصة بنا، لا يجوز لك وضع أعباء مفرطة على وحدات المعالجة المركزية أو الخوادم أو الموارد الأخرى الخاصة بنا. أنت تفهم أن عرض النطاق الترددي وسرعات الاتصال والمؤشرات المماثلة الأخرى للسعة هي أرقام قصوى.

• النسخ الاحتياطية: بالنسبة لخدمات استضافة الويب المشتركة واستضافة الموزعين، سنوفر نسخاً احتياطية مجانية لبياناتك. هذه النسخ الاحتياطية محدودة بحصة إجمالية قدرها 50 جيجابايت.`
      }
    },
    {
      id: 'resellers',
      title: { en: 'Resellers', ar: 'الموزعين' },
      content: {
        en: `Whether you are a reseller or use Reseller Hosting Services, you agree to abide, and be bound, by the terms of these TOS and our Policies, including all provisions related to indemnification and termination for a violation of these TOS and our Policies.

All additional or different terms, representations, warranties or covenants than those included in these TOS or our other Policies, including those made about the capabilities of any Services by any third party, are specifically disclaimed.

Further, such proposed additional or different terms shall be deemed a violation of the Terms of Service and could result in cancellation of your account.`,
        ar: `سواء كنت موزعاً أو تستخدم خدمات استضافة الموزعين، فإنك توافق على الالتزام بشروط الخدمة هذه وسياساتنا، بما في ذلك جميع الأحكام المتعلقة بالتعويض والإنهاء بسبب انتهاك شروط الخدمة هذه وسياساتنا.

يتم إخلاء المسؤولية صراحةً عن جميع الشروط أو الإقرارات أو الضمانات أو التعهدات الإضافية أو المختلفة عن تلك المدرجة في شروط الخدمة هذه أو سياساتنا الأخرى.

علاوة على ذلك، تعتبر هذه الشروط الإضافية أو المختلفة المقترحة انتهاكاً لشروط الخدمة وقد تؤدي إلى إلغاء حسابك.`
      }
    },
    {
      id: 'account',
      title: { en: 'Account Information', ar: 'معلومات الحساب' },
      content: {
        en: `Enrollment:
YOU WARRANT THAT BEFORE YOU USE ANY OF THE SERVICES OR SIGN UP FOR AN ACCOUNT THAT YOU ARE AT LEAST 18 YEARS OF AGE AND HAVE THE AUTHORITY TO BIND YOURSELF OR THE ENTITY YOU REPRESENT TO THESE TOS.

You may be subject to a credit check and screening for potential fraud and accurate information must be supplied for purposes of this screening. Further, before using the Services, you represent and warrant that:
• You have the experience and knowledge necessary to use the Services
• You understand and appreciate the risks inherent to doing business on the Internet
• You will provide us with material that may be implemented by us to provide the Services

Account Information:
You are required to provide us with accurate information when setting up your account. You must also keep this information, including your email address, up to date during the course of our relationship.

Account Security:
• You are responsible for all actions that are performed with, by, or under your account credentials whether done by you or by others
• All account access, password, and other security measures are your responsibility
• Pro Gineous is not liable for any damages, direct or indirect, that result from unauthorized account access or use`,
        ar: `التسجيل:
أنت تضمن أنه قبل استخدام أي من الخدمات أو التسجيل للحصول على حساب، أن عمرك لا يقل عن 18 عاماً ولديك السلطة لإلزام نفسك أو الكيان الذي تمثله بشروط الخدمة هذه.

قد تخضع لفحص ائتماني وفحص للاحتيال المحتمل ويجب تقديم معلومات دقيقة لأغراض هذا الفحص. علاوة على ذلك، قبل استخدام الخدمات، فإنك تقر وتضمن أن:
• لديك الخبرة والمعرفة اللازمة لاستخدام الخدمات
• تفهم وتقدر المخاطر الكامنة في ممارسة الأعمال التجارية على الإنترنت
• ستزودنا بالمواد التي قد ننفذها لتقديم الخدمات

معلومات الحساب:
يُطلب منك تزويدنا بمعلومات دقيقة عند إعداد حسابك. يجب عليك أيضاً الحفاظ على تحديث هذه المعلومات، بما في ذلك عنوان بريدك الإلكتروني.

أمان الحساب:
• أنت مسؤول عن جميع الإجراءات التي يتم تنفيذها باستخدام بيانات اعتماد حسابك سواء قمت بها أنت أو الآخرون
• جميع إجراءات الوصول للحساب وكلمات المرور وتدابير الأمان الأخرى هي مسؤوليتك
• برو جينيوس غير مسؤولة عن أي أضرار ناتجة عن الوصول غير المصرح به للحساب أو استخدامه`
      }
    },
    {
      id: 'billing',
      title: { en: 'Billing & Payment', ar: 'الفوترة والدفع' },
      content: {
        en: `Term:
We are not bound to perform Services until we receive payment from you. We will begin delivery of the Services on the Effective Date and continue until the date set out on the page describing the Services.

Automatic Renewal:
The Initial Term will AUTOMATICALLY RENEW for successive periods of equal duration (each a "Renewal Term"). If you wish to discontinue the Services, you need to notify us before automatic renewal for a Renewal Term.

You can notify us by:
• Submitting a cancellation at least one (1) day before the beginning of a Renewal Term through our online cancellation form found at your customer panel

Termination:
Regardless of the method of termination by you, valid proof of account ownership and authorization to cancel are required to terminate an account.

Termination for Convenience:
Either party may terminate the Services for convenience upon fifteen (15) days prior by providing written notice to the other. We only accept cancellations through our online cancellation form found at your customer panel.`,
        ar: `المدة:
لسنا ملزمين بأداء الخدمات حتى نتلقى الدفع منك. سنبدأ في تقديم الخدمات في تاريخ السريان ونستمر حتى التاريخ المحدد في صفحة وصف الخدمات.

التجديد التلقائي:
ستتجدد المدة الأولية تلقائياً لفترات متتالية من نفس المدة (كل منها "فترة تجديد"). إذا كنت ترغب في إيقاف الخدمات، فأنت بحاجة إلى إخطارنا قبل التجديد التلقائي لفترة التجديد.

يمكنك إخطارنا عن طريق:
• تقديم إلغاء قبل يوم واحد (1) على الأقل من بداية فترة التجديد من خلال نموذج الإلغاء عبر الإنترنت الموجود في لوحة العميل الخاصة بك

الإنهاء:
بغض النظر عن طريقة الإنهاء من جانبك، يلزم إثبات صالح لملكية الحساب والتفويض بالإلغاء لإنهاء الحساب.

الإنهاء للراحة:
يجوز لأي من الطرفين إنهاء الخدمات للراحة بإخطار كتابي مسبق قبل خمسة عشر (15) يوماً. نقبل فقط الإلغاءات من خلال نموذج الإلغاء عبر الإنترنت الموجود في لوحة العميل الخاصة بك.`
      }
    },
    {
      id: 'refund',
      title: { en: 'Money Back Guarantee', ar: 'ضمان استرداد الأموال' },
      content: {
        en: `If you have just changed your mind about the services we offer a no quibble money back guarantee. You can choose to exercise this option only once. Moreover, this guarantee applies to only your first term, not to subsequent extended terms.

You must notify us that you wish to cancel within the time frames set forth below for your services. You will then receive a full refund for the money paid to the date of termination, minus the domain registration fees or other expenses which are non-refundable.

This guarantee does not apply to:
• Domain name registrations, renewals or transfers
• Dedicated servers
• Certain third-party supplier products (Microsoft 365 Business Licenses, etc.)

Money Back Guarantee Period:
All Products (except for Domains, Servers and certain third-party supplier products): 30 days

In such cases where the exclusion applies, the exclusion from the no quibble money back guarantee will be notified to you before you complete the purchase.`,
        ar: `إذا غيرت رأيك بشأن الخدمات، فإننا نقدم ضمان استرداد الأموال بدون جدال. يمكنك اختيار ممارسة هذا الخيار مرة واحدة فقط. علاوة على ذلك، ينطبق هذا الضمان فقط على فترتك الأولى، وليس على الفترات الممتدة اللاحقة.

يجب عليك إخطارنا برغبتك في الإلغاء خلال الأطر الزمنية المحددة أدناه لخدماتك. ستتلقى بعد ذلك استرداداً كاملاً للأموال المدفوعة حتى تاريخ الإنهاء، مطروحاً منها رسوم تسجيل النطاق أو النفقات الأخرى غير القابلة للاسترداد.

لا ينطبق هذا الضمان على:
• تسجيلات أسماء النطاقات أو التجديدات أو عمليات النقل
• الخوادم المخصصة
• بعض منتجات الموردين من الأطراف الثالثة (تراخيص Microsoft 365 Business، إلخ)

فترة ضمان استرداد الأموال:
جميع المنتجات (باستثناء النطاقات والخوادم وبعض منتجات الموردين من الأطراف الثالثة): 30 يوماً`
      }
    },
    {
      id: 'use',
      title: { en: 'Use of Services', ar: 'استخدام الخدمات' },
      content: {
        en: `Your use of the Services is governed by these TOS, including our Policies.

PRO GINEOUS PROVIDES NO GUARANTEE THAT THE SERVICES WILL BE UNINTERRUPTED, OR CONTINUOUS, OR THAT YOU WILL BE ABLE TO ACCESS PRO GINEOUS'S NETWORK AT A PARTICULAR TIME, OR THAT ANY DATA TRANSMITTED BY PRO GINEOUS IS ACCURATE, ERROR FREE, VIRUS FREE, SECURE, OR INOFFENSIVE.

You agree to use our services only for lawful purposes. You are responsible for all activities conducted through your account.

Prohibited activities include but are not limited to:
• Illegal content distribution
• Spam and unsolicited bulk email
• Malware distribution
• Copyright infringement
• Phishing or fraud
• Cryptocurrency mining
• Any activities that may harm our infrastructure or other users`,
        ar: `يخضع استخدامك للخدمات لشروط الخدمة هذه، بما في ذلك سياساتنا.

لا تقدم برو جينيوس أي ضمان بأن الخدمات ستكون غير منقطعة أو مستمرة، أو أنك ستتمكن من الوصول إلى شبكة برو جينيوس في وقت معين، أو أن أي بيانات ترسلها برو جينيوس دقيقة أو خالية من الأخطاء أو الفيروسات أو آمنة أو غير مسيئة.

أنت توافق على استخدام خدماتنا للأغراض المشروعة فقط. أنت مسؤول عن جميع الأنشطة التي تتم من خلال حسابك.

تشمل الأنشطة المحظورة على سبيل المثال لا الحصر:
• توزيع المحتوى غير القانوني
• البريد العشوائي والبريد الإلكتروني الجماعي غير المرغوب فيه
• توزيع البرامج الضارة
• انتهاك حقوق النشر
• التصيد الاحتيالي أو الاحتيال
• تعدين العملات المشفرة
• أي أنشطة قد تضر ببنيتنا التحتية أو المستخدمين الآخرين`
      }
    },
    {
      id: 'backups',
      title: { en: 'Data Backups', ar: 'النسخ الاحتياطية' },
      content: {
        en: `YOU ACKNOWLEDGE THAT IT IS SOLELY YOUR RESPONSIBILITY TO REGULARLY BACK-UP AND MAINTAIN COPIES OF YOUR DATA OUTSIDE OF PRO GINEOUS'S NETWORK.

Pro Gineous is not responsible for any data loss or corruption, including that result from:
• Our authorized actions
• Those actions you take using the Services
• Hardware failures
• Any software or other technology failures
• Account termination, cancellation, or suspension

We strongly recommend that you:
• Maintain regular backups of all your data
• Store backups in a separate location from your hosting account
• Test your backups regularly to ensure they can be restored
• Keep multiple backup copies from different time periods`,
        ar: `أنت تقر بأنه من مسؤوليتك وحدك النسخ الاحتياطي المنتظم والحفاظ على نسخ من بياناتك خارج شبكة برو جينيوس.

برو جينيوس غير مسؤولة عن أي فقدان للبيانات أو تلفها، بما في ذلك الناتج عن:
• إجراءاتنا المصرح بها
• تلك الإجراءات التي تتخذها باستخدام الخدمات
• أعطال الأجهزة
• أي أعطال في البرامج أو التقنيات الأخرى
• إنهاء الحساب أو إلغاؤه أو تعليقه

نوصي بشدة بما يلي:
• الحفاظ على نسخ احتياطية منتظمة لجميع بياناتك
• تخزين النسخ الاحتياطية في موقع منفصل عن حساب الاستضافة الخاص بك
• اختبار النسخ الاحتياطية بانتظام للتأكد من إمكانية استعادتها
• الاحتفاظ بنسخ احتياطية متعددة من فترات زمنية مختلفة`
      }
    },
    {
      id: 'intellectual-property',
      title: { en: 'Intellectual Property', ar: 'الملكية الفكرية' },
      content: {
        en: `Services performed or provided by Pro Gineous are either Pro Gineous's original work or are the works of third parties from which Pro Gineous has obtained necessary permissions to provide and are not "works made for hire".

We hereby grant you a license to use the Services and technology under the terms of these TOS, including our Policies. The license is non-exclusive, non-transferable, non-sublicensable worldwide, and royalty free and terminates when you or Pro Gineous terminates the Services.

All right, title and interest in Pro Gineous's technology and the Services shall remain with Pro Gineous, or Pro Gineous's licensors.

You are not permitted to:
• Circumvent any devices designed to protect Pro Gineous's ownership interests
• Reverse engineer this technology or the Services

Data Ownership:
You retain ownership of all content and data you upload to our services. We do not claim any ownership rights over your content.`,
        ar: `الخدمات التي تؤديها أو تقدمها برو جينيوس هي إما عمل برو جينيوس الأصلي أو أعمال أطراف ثالثة حصلت برو جينيوس منها على الأذونات اللازمة للتقديم وليست "أعمالاً مصنوعة للتأجير".

نمنحك بموجب هذا ترخيصاً لاستخدام الخدمات والتقنية بموجب شروط الخدمة هذه، بما في ذلك سياساتنا. الترخيص غير حصري وغير قابل للتحويل وغير قابل للترخيص من الباطن في جميع أنحاء العالم وخالي من حقوق الملكية وينتهي عندما تنهي أنت أو برو جينيوس الخدمات.

تظل جميع الحقوق والملكية والمصلحة في تقنية برو جينيوس والخدمات ملكاً لـ برو جينيوس أو المرخصين لـ برو جينيوس.

لا يُسمح لك بـ:
• التحايل على أي أجهزة مصممة لحماية مصالح ملكية برو جينيوس
• الهندسة العكسية لهذه التقنية أو الخدمات

ملكية البيانات:
أنت تحتفظ بملكية جميع المحتويات والبيانات التي تقوم بتحميلها إلى خدماتنا. نحن لا ندعي أي حقوق ملكية على المحتوى الخاص بك.`
      }
    },
    {
      id: 'warranty',
      title: { en: 'Warranty', ar: 'الضمان' },
      content: {
        en: `Pro Gineous warrants that it will perform the Services in accordance with prevailing industry standards.

To make a breach of warranty claim, you must notify Pro Gineous in writing, specifying the breach in reasonable detail, within thirty (30) days of the alleged breach.

Your sole and exclusive remedy, and Pro Gineous's sole and exclusive obligation, in the case of a breach of this warranty is, at Pro Gineous's option, to:
• Reperform the Services, or
• Issue you a credit based on the amount of time the Services were not in conformity with this warranty

SERVICES PROVIDED BY THIRD PARTIES ARE EXPRESSLY EXCLUDED FROM THIS WARRANTY.

EXCEPT FOR THE WARRANTY ABOVE, THE SERVICES ARE PROVIDED "AS IS" WITHOUT WARRANTY OF ANY KIND, EITHER EXPRESS OR IMPLIED, INCLUDING ANY WARRANTIES OF MERCHANTABILITY, NON-INFRINGEMENT, OR FITNESS FOR A PARTICULAR PURPOSE.`,
        ar: `تضمن برو جينيوس أنها ستؤدي الخدمات وفقاً لمعايير الصناعة السائدة.

لتقديم مطالبة بخرق الضمان، يجب عليك إخطار برو جينيوس كتابياً، مع تحديد الخرق بتفاصيل معقولة، في غضون ثلاثين (30) يوماً من الخرق المزعوم.

علاجك الوحيد والحصري، والتزام برو جينيوس الوحيد والحصري، في حالة خرق هذا الضمان هو، بخيار برو جينيوس:
• إعادة أداء الخدمات، أو
• إصدار رصيد لك بناءً على مقدار الوقت الذي لم تكن فيه الخدمات متوافقة مع هذا الضمان

الخدمات المقدمة من الأطراف الثالثة مستبعدة صراحةً من هذا الضمان.

باستثناء الضمان أعلاه، يتم تقديم الخدمات "كما هي" دون أي ضمان من أي نوع، سواء كان صريحاً أو ضمنياً.`
      }
    },
    {
      id: 'disclaimers',
      title: { en: 'Disclaimers', ar: 'إخلاء المسؤولية' },
      content: {
        en: `Pro Gineous is not liable, and expressly disclaims any liability, for the content of any data transferred either to, or from, you or stored by you or any of your customers via the Services provided by us.

Pro Gineous is not responsible for any loss of data, for any reason.

Pro Gineous is not liable for:
• Unauthorized access to, or any corruption, erasure, theft, destruction, alteration or inadvertent disclosure of, data, information or content
• Data breaches or data compromise caused by your failure to keep web applications including plugins up to date

PRO GINEOUS SPECIFICALLY DISCLAIMS ANY AND ALL WARRANTIES REGARDING SERVICES PROVIDED BY THIRD PARTIES, REGARDLESS OF WHETHER THOSE SERVICES APPEAR TO BE PROVIDED BY US.

SOME JURISDICTIONS DO NOT ALLOW PRO GINEOUS TO EXCLUDE CERTAIN WARRANTIES. IF THIS APPLIES TO YOU, YOUR WARRANTY IS LIMITED TO 90 DAYS FROM THE EFFECTIVE DATE.`,
        ar: `برو جينيوس غير مسؤولة، وتخلي مسؤوليتها صراحةً، عن محتوى أي بيانات يتم نقلها إليك أو منك أو تخزينها بواسطتك أو أي من عملائك عبر الخدمات التي نقدمها.

برو جينيوس غير مسؤولة عن أي فقدان للبيانات، لأي سبب.

برو جينيوس غير مسؤولة عن:
• الوصول غير المصرح به إلى، أو أي تلف أو محو أو سرقة أو تدمير أو تعديل أو إفصاح غير مقصود عن البيانات أو المعلومات أو المحتوى
• اختراقات البيانات أو اختراق البيانات الناجمة عن عدم تحديثك لتطبيقات الويب بما في ذلك المكونات الإضافية

تخلي برو جينيوس مسؤوليتها صراحةً عن أي وجميع الضمانات المتعلقة بالخدمات المقدمة من الأطراف الثالثة.

بعض الولايات القضائية لا تسمح لـ برو جينيوس باستبعاد ضمانات معينة. إذا كان هذا ينطبق عليك، فإن ضمانك يقتصر على 90 يوماً من تاريخ السريان.`
      }
    },
    {
      id: 'liability',
      title: { en: 'Limitation of Liability', ar: 'تحديد المسؤولية' },
      content: {
        en: `It is your obligation to ensure the accuracy, integrity, title or ownership, and security of anything you receive from the Internet.

YOU AGREE THAT PRO GINEOUS HAS NO LIABILITY, OF ANY SORT, FOR CONTENT YOU OR YOUR CUSTOMERS ACCESS FROM THE INTERNET.

IN NO EVENT SHALL PRO GINEOUS BE LIABLE TO YOU IN CONNECTION WITH THESE TOS OR THE SERVICES FOR ANY:
• Data loss
• Direct, indirect, special, exemplary, consequential, incidental, or punitive damages
• Lost profits, lost revenues, lost business expectancy, business interruption losses

IN NO EVENT WILL PRO GINEOUS'S LIABILITY HEREUNDER EXCEED THE AGGREGATE FEES ACTUALLY RECEIVED BY PRO GINEOUS FROM YOU FOR THE THREE (3) MONTH PERIOD IMMEDIATELY PRECEDING THE EVENT GIVING RISE TO THE LIABILITY.

Pro Gineous will not be held responsible for any:
• Force majeure events
• Problems or service outages caused due to reboots during standard maintenance periods
• Scheduled Downtime`,
        ar: `من واجبك ضمان دقة وسلامة وملكية وأمن أي شيء تتلقاه من الإنترنت.

أنت توافق على أن برو جينيوس ليس لديها أي مسؤولية، من أي نوع، عن المحتوى الذي تصل إليه أنت أو عملاؤك من الإنترنت.

في أي حال من الأحوال، لن تكون برو جينيوس مسؤولة تجاهك فيما يتعلق بشروط الخدمة هذه أو الخدمات عن أي:
• فقدان البيانات
• أضرار مباشرة أو غير مباشرة أو خاصة أو نموذجية أو تبعية أو عرضية أو عقابية
• أرباح مفقودة، إيرادات مفقودة، توقعات عمل مفقودة، خسائر انقطاع الأعمال

في أي حال من الأحوال، لن تتجاوز مسؤولية برو جينيوس بموجب هذا إجمالي الرسوم المستلمة فعلياً من قبل برو جينيوس منك لفترة الثلاثة (3) أشهر السابقة مباشرة للحدث الذي أدى إلى المسؤولية.

لن تتحمل برو جينيوس المسؤولية عن أي:
• أحداث القوة القاهرة
• مشاكل أو انقطاع الخدمة الناجمة عن إعادة التشغيل أثناء فترات الصيانة القياسية
• التوقف المجدول`
      }
    },
    {
      id: 'indemnification',
      title: { en: 'Indemnification', ar: 'التعويض' },
      content: {
        en: `You agree to indemnify, defend, and hold harmless Pro Gineous and its personnel, parent, subsidiaries and affiliated companies, third party service providers, and each of their respective officers, directors, employees, shareholders, and agents from and against any and all claims, damages, losses, liabilities, suits, actions, demands, proceedings (whether legal or administrative), and expenses (including, reasonable attorney's fees) arising out of or relating to:

• Your use of the Services, including any data migration-related efforts
• Any violation by you of these TOS or any of Pro Gineous's Policies
• Any breach of any of your representations, warranties, or covenants contained in these TOS
• Any acts or omissions by you

The terms of this section shall survive any termination of these TOS or the Services.`,
        ar: `أنت توافق على تعويض والدفاع عن وإبراء ذمة برو جينيوس وموظفيها والشركة الأم والشركات التابعة والشركات الشقيقة ومقدمي الخدمات من الأطراف الثالثة وكل من مسؤوليهم ومديريهم وموظفيهم ومساهميهم ووكلائهم من وضد أي وجميع المطالبات والأضرار والخسائر والالتزامات والدعاوى والإجراءات والمطالب والإجراءات (سواء كانت قانونية أو إدارية) والنفقات (بما في ذلك أتعاب المحاماة المعقولة) الناشئة عن أو المتعلقة بـ:

• استخدامك للخدمات، بما في ذلك أي جهود متعلقة بنقل البيانات
• أي انتهاك من قبلك لشروط الخدمة هذه أو أي من سياسات برو جينيوس
• أي خرق لأي من إقراراتك أو ضماناتك أو تعهداتك الواردة في شروط الخدمة هذه
• أي أفعال أو إغفالات من جانبك

تظل شروط هذا القسم سارية بعد أي إنهاء لشروط الخدمة هذه أو الخدمات.`
      }
    },
    {
      id: 'legal',
      title: { en: 'Legal', ar: 'القانون' },
      content: {
        en: `Compliance with Law:
Export laws apply to your use of the Services. It is your obligation to confirm that your use of the Services complies with applicable laws.

We may disclose information, including information that you may consider confidential, in order to comply with a court order, subpoena, summons, discovery request, warrant, regulation, or governmental request or to protect our business, or others, from harm.

Force Majeure:
Except for the obligation to pay monies due and owing, neither party shall be liable for any delay or failure in performance due to events outside the party's reasonable control, including without limitation third party service failures, software failures, hardware failures, distributed denial of service (DDoS) attacks, acts of God, bandwidth interruptions, general network outages, earthquake, labor disputes, shortages of supplies, riots, war, fire, epidemics, or delays of common carriers.

Choice of Law, Jurisdiction, and Venue:
These Terms of Use and your use of the services are governed by and construed in accordance with the laws of the Arab Republic of Egypt. The parties specifically disclaim the UN Convention on Contracts for the International Sale of Goods.

All claims you bring against us must be resolved in accordance with our Policies.

Assignment:
These TOS may be assigned by Pro Gineous. It may not be assigned by you.

Severability:
In the event that any of the terms of these TOS become or are declared to be illegal or otherwise unenforceable by any court of competent jurisdiction, such term(s) shall be revised to reflect Pro Gineous's intent, as permitted by applicable law.

Claims Period:
No action or proceeding against us may be commenced by you more than one (1) year after the Service which is the basis for the action is rendered.`,
        ar: `الامتثال للقانون:
تنطبق قوانين التصدير على استخدامك للخدمات. من واجبك التأكد من أن استخدامك للخدمات يتوافق مع القوانين المعمول بها.

قد نكشف عن المعلومات، بما في ذلك المعلومات التي قد تعتبرها سرية، من أجل الامتثال لأمر محكمة أو استدعاء أو طلب اكتشاف أو أمر قضائي أو لائحة أو طلب حكومي أو لحماية أعمالنا أو الآخرين من الضرر.

القوة القاهرة:
باستثناء الالتزام بدفع الأموال المستحقة والمستحقة، لن يكون أي من الطرفين مسؤولاً عن أي تأخير أو فشل في الأداء بسبب أحداث خارجة عن السيطرة المعقولة للطرف، بما في ذلك على سبيل المثال لا الحصر فشل خدمات الأطراف الثالثة وفشل البرامج وفشل الأجهزة وهجمات رفض الخدمة الموزعة (DDoS) والكوارث الطبيعية وانقطاعات عرض النطاق الترددي وانقطاع الشبكة العامة والزلازل والنزاعات العمالية ونقص الإمدادات وأعمال الشغب والحروب والحرائق والأوبئة أو تأخيرات الناقلين العامين.

اختيار القانون والاختصاص القضائي والمكان:
تخضع شروط الاستخدام هذه واستخدامك للخدمات وتفسر وفقاً لقوانين جمهورية مصر العربية.

يجب حل جميع المطالبات التي تقدمها ضدنا وفقاً لسياساتنا.

التنازل:
يجوز لـ برو جينيوس التنازل عن شروط الخدمة هذه. لا يجوز لك التنازل عنها.

قابلية الفصل:
في حالة أن أياً من شروط الخدمة هذه تصبح أو يُعلن أنها غير قانونية أو غير قابلة للتنفيذ من قبل أي محكمة ذات اختصاص، يتم تعديل هذه الشروط لتعكس نية برو جينيوس.

فترة المطالبات:
لا يجوز لك البدء في أي إجراء أو دعوى ضدنا بعد أكثر من سنة واحدة (1) من تقديم الخدمة التي هي أساس الدعوى.`
      }
    },
    {
      id: 'contact',
      title: { en: 'Contact Us', ar: 'اتصل بنا' },
      content: {
        en: `If you have any questions about these Terms of Service, please contact us:

Pro Gineous
9 Mustafa Kamel Street, Balwalidain Ihsanah Tower
Beni Suef, Egypt

Email: support@progineous.com
Website: https://progineous.com

Commercial Register: 90088
Tax Registration Number: 755-552-334

Notices will be sent to you at the email address in your account. It is your obligation to ensure that we have the most current email address for you by keeping your account information up to date.`,
        ar: `إذا كان لديك أي أسئلة حول شروط الخدمة هذه، يرجى الاتصال بنا:

برو جينيوس
9 شارع مصطفى كامل، برج بالوالدين إحسانا
بني سويف، مصر

البريد الإلكتروني: support@progineous.com
الموقع الإلكتروني: https://progineous.com

السجل التجاري: 90088
رقم التسجيل الضريبي: 755-552-334

سيتم إرسال الإشعارات إليك على عنوان البريد الإلكتروني في حسابك. من واجبك التأكد من أن لدينا أحدث عنوان بريد إلكتروني لك من خلال تحديث معلومات حسابك.`
      }
    }
  ];

  // Handle scroll to update active section
  useEffect(() => {
    const handleScroll = () => {
      const sectionElements = sections.map(s => document.getElementById(s.id));
      const scrollPosition = window.scrollY + 150;

      for (let i = sectionElements.length - 1; i >= 0; i--) {
        const element = sectionElements[i];
        if (element && element.offsetTop <= scrollPosition) {
          setActiveSection(sections[i].id);
          break;
        }
      }
    };

    window.addEventListener('scroll', handleScroll);
    return () => window.removeEventListener('scroll', handleScroll);
  }, []);

  const scrollToSection = (id: string) => {
    const element = document.getElementById(id);
    if (element) {
      const offset = 100;
      const elementPosition = element.getBoundingClientRect().top + window.scrollY;
      window.scrollTo({ top: elementPosition - offset, behavior: 'smooth' });
      setMobileMenuOpen(false);
    }
  };

  const jsonLd = {
    '@context': 'https://schema.org',
    '@graph': [
      {
        '@type': 'WebPage',
        '@id': `https://progineous.com/${locale}/terms`,
        name: isRTL ? 'شروط الخدمة | بروجينيوس' : 'Terms of Service | Pro Gineous',
        description: isRTL
          ? 'الشروط والأحكام الخاصة باستخدام خدمات بروجينيوس للاستضافة والنطاقات'
          : 'Terms and conditions for using Pro Gineous hosting and domain services',
        url: `https://progineous.com/${locale}/terms`,
        inLanguage: isRTL ? 'ar' : 'en',
        isPartOf: {
          '@type': 'WebSite',
          name: 'Pro Gineous',
          url: 'https://progineous.com',
        },
        about: {
          '@type': 'Thing',
          name: isRTL ? 'شروط وأحكام الخدمة' : 'Terms and Conditions',
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
            name: isRTL ? 'شروط الخدمة' : 'Terms of Service',
            item: `https://progineous.com/${locale}/terms`,
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
    <div className={cn('min-h-screen bg-white', isRTL && 'rtl')}>
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
      <div className="bg-linear-to-br from-[#0a1628] to-[#1d3a5c] text-white py-16 md:py-24">
        <div className="max-w-7xl mx-auto px-4 text-center">
          <h1 className="text-4xl md:text-5xl font-bold mb-4">
            {isRTL ? 'شروط الخدمة' : 'Service Terms'}
          </h1>
          <p className="text-white/70 text-lg max-w-2xl mx-auto">
            {isRTL 
              ? 'يرجى قراءة هذه الشروط بعناية قبل استخدام خدماتنا'
              : 'Please read these terms carefully before using our services'
            }
          </p>
        </div>
      </div>

      {/* Mobile Navigation */}
      {mobileMenuOpen && (
        <div className="lg:hidden fixed inset-0 top-16.25 bg-white z-20 overflow-y-auto">
          <nav className="p-4">
            {sections.map((section, index) => (
              <button
                key={section.id}
                onClick={() => scrollToSection(section.id)}
                className={cn(
                  'w-full text-left py-3 px-4 rounded-lg mb-1 flex items-center gap-3 transition-colors',
                  activeSection === section.id
                    ? 'bg-[#1d71b8]/10 text-[#1d71b8]'
                    : 'text-gray-600 hover:bg-gray-50'
                )}
              >
                <span className="text-sm font-medium text-gray-400">{index + 1}.</span>
                <span className="font-medium">{isRTL ? section.title.ar : section.title.en}</span>
              </button>
            ))}
          </nav>
        </div>
      )}

      {/* Content */}
      <div className="max-w-7xl mx-auto px-4 py-12">
        <div className="flex gap-12">
          {/* Sidebar Navigation - Desktop */}
          <aside className="hidden lg:block w-72 shrink-0">
            <div className="sticky top-24">
              <nav className="space-y-1">
                {sections.map((section, index) => (
                  <button
                    key={section.id}
                    onClick={() => scrollToSection(section.id)}
                    className={cn(
                      'w-full text-left py-2.5 px-4 rounded-lg flex items-center gap-3 transition-all group',
                      activeSection === section.id
                        ? 'bg-[#1d71b8] text-white'
                        : 'text-gray-600 hover:bg-gray-100'
                    )}
                  >
                    <span className={cn(
                      'text-sm font-medium',
                      activeSection === section.id ? 'text-white/70' : 'text-gray-400'
                    )}>
                      {index + 1}.
                    </span>
                    <span className="font-medium text-sm">{isRTL ? section.title.ar : section.title.en}</span>
                    <ChevronRight className={cn(
                      'w-4 h-4 ml-auto opacity-0 group-hover:opacity-100 transition-opacity',
                      activeSection === section.id && 'opacity-100',
                      isRTL && 'rotate-180'
                    )} />
                  </button>
                ))}
              </nav>

              {/* Last Updated */}
              <div className="mt-8 pt-8 border-t border-gray-200">
                <p className="text-sm text-gray-500">
                  {isRTL ? 'آخر تحديث:' : 'Last updated:'}
                </p>
                <p className="text-sm font-medium text-gray-700">
                  {isRTL ? '1 يناير 2025' : 'January 1, 2025'}
                </p>
              </div>
            </div>
          </aside>

          {/* Main Content */}
          <main className="flex-1 min-w-0">
            {sections.map((section, index) => (
              <section key={section.id} id={section.id} className="mb-16">
                <h2 className="text-2xl md:text-3xl font-bold text-gray-900 mb-6 pb-4 border-b border-gray-200">
                  {index + 1}. {isRTL ? section.title.ar : section.title.en}
                </h2>
                <div className="prose prose-lg max-w-none text-gray-600 leading-relaxed whitespace-pre-line">
                  {isRTL ? <RTLText>{section.content.ar}</RTLText> : section.content.en}
                </div>
              </section>
            ))}

            {/* Related Policies */}
            <div className="mt-12 bg-white rounded-xl border border-gray-200 shadow-sm p-6 md:p-8">
              <h3 className="text-xl font-bold text-gray-900 mb-6">
                {isRTL ? 'سياسات ذات صلة' : 'Related Policies'}
              </h3>
              <div className="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <Link
                  href={`/${locale}/privacy`}
                  className="flex items-center gap-3 p-4 rounded-xl border border-gray-200 hover:border-[#1d71b8] hover:bg-blue-50 transition-all group"
                >
                  <div className="p-2 bg-gray-100 rounded-lg group-hover:bg-[#1d71b8] group-hover:text-white transition-colors">
                    <ChevronRight className="w-5 h-5" />
                  </div>
                  <div>
                    <h4 className="font-semibold text-gray-900 group-hover:text-[#1d71b8]">
                      {isRTL ? 'سياسة الخصوصية' : 'Privacy Policy'}
                    </h4>
                    <p className="text-sm text-gray-500">
                      {isRTL ? 'كيف نحمي بياناتك' : 'How we protect your data'}
                    </p>
                  </div>
                  <ChevronRight className={cn('w-5 h-5 text-gray-400 ms-auto', isRTL && 'rotate-180')} />
                </Link>
                <Link
                  href={`/${locale}/aup`}
                  className="flex items-center gap-3 p-4 rounded-xl border border-gray-200 hover:border-[#1d71b8] hover:bg-blue-50 transition-all group"
                >
                  <div className="p-2 bg-gray-100 rounded-lg group-hover:bg-[#1d71b8] group-hover:text-white transition-colors">
                    <ChevronRight className="w-5 h-5" />
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
                    <ChevronRight className="w-5 h-5" />
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
                    <ChevronRight className="w-5 h-5" />
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
                    <ChevronRight className="w-5 h-5" />
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
                    <ChevronRight className="w-5 h-5" />
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

            {/* Contact CTA */}
            <div className="mt-8 p-8 bg-linear-to-br from-[#0a1628] to-[#1d3a5c] rounded-2xl text-white">
              <h3 className="text-xl font-bold mb-2">
                {isRTL ? 'هل لديك أسئلة؟' : 'Have Questions?'}
              </h3>
              <p className="text-white/70 mb-4">
                {isRTL 
                  ? 'فريق الدعم لدينا جاهز لمساعدتك في أي استفسارات حول شروط الخدمة.'
                  : 'Our support team is ready to help you with any questions about our terms of service.'
                }
              </p>
              <a 
                href="mailto:support@progineous.com"
                className="inline-flex items-center gap-2 bg-white text-[#1d71b8] px-6 py-3 rounded-lg font-medium hover:bg-gray-100 transition-colors"
              >
                {isRTL ? 'تواصل معنا' : 'Contact Us'}
                <ChevronRight className={cn('w-4 h-4', isRTL && 'rotate-180')} />
              </a>
            </div>
          </main>
        </div>
      </div>

      {/* Footer */}
      <footer className="border-t border-gray-200 bg-gray-50 py-8">
        <div className="max-w-7xl mx-auto px-4">
          <div className="flex flex-col md:flex-row items-center justify-between gap-4">
            <p className="text-gray-500 text-sm">
              © {new Date().getFullYear()} Pro Gineous. {isRTL ? 'جميع الحقوق محفوظة.' : 'All rights reserved.'}
            </p>
            <div className="flex items-center gap-6 text-sm">
              <Link href={`/${locale}/privacy`} className="text-gray-500 hover:text-[#1d71b8] transition-colors">
                {isRTL ? 'سياسة الخصوصية' : 'Privacy Policy'}
              </Link>
              <Link href={`/${locale}/terms`} className="text-[#1d71b8] font-medium">
                {isRTL ? 'شروط الخدمة' : 'Terms of Service'}
              </Link>
              <Link href={`/${locale}/aup`} className="text-gray-500 hover:text-[#1d71b8] transition-colors">
                {isRTL ? 'سياسة الاستخدام' : 'Acceptable Use'}
              </Link>
            </div>
          </div>
        </div>
      </footer>
    </div>
  );
}
