'use client';

import { useState, useEffect } from 'react';
import { useParams } from 'next/navigation';
import Link from 'next/link';
import {
  Users,
  FileText,
  RefreshCw,
  DollarSign,
  CreditCard,
  ShieldAlert,
  Mail,
  Scale,
  Award,
  Lock,
  AlertTriangle,
  ChevronRight,
  Percent,
  Handshake
} from 'lucide-react';
import { RTLText } from '@/components/ui/RTLText';

type Locale = 'en' | 'ar';

export default function AffiliatePolicyPage() {
  const params = useParams();
  const locale = (params?.locale as Locale) || 'en';
  const isRTL = locale === 'ar';
  const [activeSection, setActiveSection] = useState('introduction');

  const sections = [
    {
      id: 'introduction',
      title: { en: 'Introduction', ar: 'المقدمة' },
      icon: Users,
      content: {
        en: `Our affiliates are very important to Pro Gineous. We want to treat you with the fairness and respect you rightfully deserve. We simply request that you do the same for us. Our Terms and Conditions were written with you in mind and to protect Pro Gineous's good name.

Please ask us if you have any questions. We strongly believe in honest and straightforward communication. For fast answers to your questions please email us at affiliates@progineous.com.

Kind Regards,
Pro Gineous Affiliate Team`,
        ar: `شركاؤنا في برنامج الأفلييت مهمون جداً لبرو جينيوس. نريد أن نعاملكم بالعدل والاحترام الذي تستحقونه. نطلب منكم ببساطة أن تفعلوا الشيء نفسه معنا. كُتبت شروطنا وأحكامنا مع مراعاة مصلحتكم وحماية سمعة برو جينيوس الطيبة.

يرجى التواصل معنا إذا كانت لديكم أي أسئلة. نؤمن بشدة بالتواصل الصادق والمباشر. للحصول على إجابات سريعة لأسئلتكم، يرجى مراسلتنا على affiliates@progineous.com.

مع أطيب التحيات،
فريق الأفلييت في برو جينيوس`
      }
    },
    {
      id: 'terms-conditions',
      title: { en: 'Terms and Conditions', ar: 'الشروط والأحكام' },
      icon: FileText,
      content: {
        en: `IMPORTANT - PLEASE READ CAREFULLY: THIS AFFILIATE TERMS OF SERVICE IS A LEGAL AGREEMENT BETWEEN YOU AND PRO GINEOUS FOR PARTICIPATION IN THE PRO GINEOUS AFFILIATE PROGRAM ("AGREEMENT").

By registering for and participating in our program, you agree to be bound by the terms of this Agreement. If you do not agree to the terms of this Agreement, do not sign up for or participate in the program.

If you are already a Pro Gineous affiliate and do not agree to the entire Affiliate Agreement, then immediately terminate all uses of Pro Gineous affiliate materials and any affiliate links to Pro Gineous website.

If you are accepted to participate in our affiliate program and your site is thereafter determined (at our sole discretion) to be unsuitable based on the criteria below, we reserve the right to terminate this Agreement:

• Promotion of discrimination based on race, sex, religion, nationality, disability, sexual orientation, or age
• Promotion of sexually explicit, pornographic or obscene content
• Promotion of illegal activities
• Promotion of content that is unlawful, harmful, threatening, defamatory, obscene, harassing or racially objectionable
• Promotion of content related to liquor, tobacco, firearms, drugs, gambling, crime or death
• Auto-traffic generators or traffic exchanges
• Any other material deemed inappropriate or offensive by Pro Gineous`,
        ar: `هام - يرجى القراءة بعناية: شروط خدمة الأفلييت هذه هي اتفاقية قانونية بينك وبين برو جينيوس للمشاركة في برنامج الأفلييت الخاص ببرو جينيوس ("الاتفاقية").

بالتسجيل والمشاركة في برنامجنا، فإنك توافق على الالتزام بشروط هذه الاتفاقية. إذا كنت لا توافق على شروط هذه الاتفاقية، فلا تقم بالتسجيل أو المشاركة في البرنامج.

إذا كنت بالفعل شريكاً في برنامج الأفلييت لبرو جينيوس ولا توافق على اتفاقية الأفلييت بالكامل، فقم فوراً بإنهاء جميع استخدامات مواد الأفلييت وأي روابط تابعة لموقع برو جينيوس.

إذا تم قبولك للمشاركة في برنامج الأفلييت الخاص بنا وتم تحديد موقعك لاحقاً (وفقاً لتقديرنا الخاص) بأنه غير مناسب بناءً على المعايير أدناه، فإننا نحتفظ بالحق في إنهاء هذه الاتفاقية:

• الترويج للتمييز على أساس العرق أو الجنس أو الدين أو الجنسية أو الإعاقة أو التوجه الجنسي أو العمر
• الترويج لمحتوى جنسي صريح أو إباحي أو فاحش
• الترويج للأنشطة غير القانونية
• الترويج لمحتوى غير قانوني أو ضار أو تهديدي أو تشهيري أو فاحش أو مزعج أو عنصري
• الترويج لمحتوى متعلق بالكحول أو التبغ أو الأسلحة النارية أو المخدرات أو القمار أو الجريمة أو الموت
• مولدات الزيارات التلقائية أو تبادل الزيارات
• أي مواد أخرى تعتبرها برو جينيوس غير لائقة أو مسيئة`
      }
    },
    {
      id: 'changes',
      title: { en: 'Changes', ar: 'التغييرات' },
      icon: RefreshCw,
      content: {
        en: `Pro Gineous reserves the right to make changes to this Agreement at any time and solely at our discretion.

Continued participation in our affiliate program constitutes your agreement to any and all changes made to this agreement.

We will make reasonable efforts to notify affiliates of significant changes via:
• Email notification to your registered email address
• Announcement in the affiliate dashboard
• Updates posted on our website

It is your responsibility to review this Agreement periodically. Your continued participation after changes are posted means you accept the modified terms.`,
        ar: `تحتفظ برو جينيوس بالحق في إجراء تغييرات على هذه الاتفاقية في أي وقت ووفقاً لتقديرنا الخاص.

تشكل المشاركة المستمرة في برنامج الأفلييت الخاص بنا موافقتك على أي وجميع التغييرات التي تم إجراؤها على هذه الاتفاقية.

سنبذل جهوداً معقولة لإخطار الشركاء بالتغييرات المهمة عبر:
• إشعار بالبريد الإلكتروني على عنوان بريدك المسجل
• إعلان في لوحة تحكم الأفلييت
• تحديثات منشورة على موقعنا

تقع على عاتقك مسؤولية مراجعة هذه الاتفاقية بشكل دوري. استمرارك في المشاركة بعد نشر التغييرات يعني قبولك للشروط المعدلة.`
      }
    },
    {
      id: 'commissions',
      title: { en: 'Commissions', ar: 'العمولات' },
      icon: DollarSign,
      content: {
        en: `Affiliates earn commissions based on the amount of sales they deliver each month as follows:

Commission Structure:
• 1-10 sales: $50 per sale
• 11-15 sales: $75 per sale
• 16-20 sales: $100 per sale
• 21+ sales: $125 per sale

Commission Rules:
• All new accounts are subject to a 45-day approval period
• Each new sale must remain in good standing
• Commissions will not be credited for sales that have been canceled, terminated, charged back, refunded, or have outstanding balances
• All sales must originate from your unique tracking URL
• The tracking URL we provide must not be altered

Valid Commission Requirements:
• A valid commission is considered a unique hosting plan purchase made by a new customer
• Not an existing customer or their subsequent renewal order
• Affiliate generated sales that do not meet these requirements will not be eligible for commission credit

We reserve the right to deny commissions for:
• Poor quality affiliate traffic or conversions
• Low sale cost or high rate of cancellations
• Low renewals or low-quality user content
• Plagiarized or template user content`,
        ar: `يكسب الشركاء عمولات بناءً على عدد المبيعات التي يحققونها كل شهر كما يلي:

هيكل العمولات:
• 1-10 مبيعات: 50 دولار لكل عملية بيع
• 11-15 مبيعات: 75 دولار لكل عملية بيع
• 16-20 مبيعات: 100 دولار لكل عملية بيع
• 21+ مبيعات: 125 دولار لكل عملية بيع

قواعد العمولات:
• جميع الحسابات الجديدة تخضع لفترة موافقة مدتها 45 يوماً
• يجب أن تظل كل عملية بيع جديدة في وضع جيد
• لن يتم احتساب العمولات للمبيعات التي تم إلغاؤها أو إنهاؤها أو استردادها أو التي لديها أرصدة مستحقة
• يجب أن تنشأ جميع المبيعات من رابط التتبع الفريد الخاص بك
• لا يجب تغيير رابط التتبع الذي نقدمه

متطلبات العمولة الصالحة:
• تعتبر العمولة الصالحة شراء خطة استضافة فريدة من قبل عميل جديد
• وليس عميلاً حالياً أو طلب تجديده اللاحق
• المبيعات التي ينشئها الشريك والتي لا تستوفي هذه المتطلبات لن تكون مؤهلة لرصيد العمولة

نحتفظ بالحق في رفض العمولات بسبب:
• جودة رديئة لحركة المرور أو التحويلات
• انخفاض تكلفة البيع أو ارتفاع معدل الإلغاءات
• انخفاض التجديدات أو محتوى المستخدم منخفض الجودة
• محتوى منسوخ أو قوالب جاهزة`
      }
    },
    {
      id: 'payment',
      title: { en: 'Payment', ar: 'الدفع' },
      icon: CreditCard,
      content: {
        en: `Payment Threshold:
Commissions are paid when affiliates reach a $100 commission balance. Commission balances that have not yet reached $100 will carry over to the next month until the minimum has been reached.

Forfeiture Period:
Commission balances that do not reach the minimum threshold for a period of 18 months are thereafter forfeited by you and no longer eligible for payment.

Payment Schedule:
• Commissions are processed on the 15th of each month
• If 15th falls on a weekend or holiday, commissions are processed on the next available workday
• Payment will be made to the payment method active in your affiliate account at that time

Payment Methods:
• PayPal
• Bank Transfer (for balances over $500)
• Payoneer

Currency:
All funds are paid in US Dollars (USD).

Required Documentation:
• Valid national ID or passport
• Tax registration (if applicable)
• Complete and accurate payment details must be on file before payment can be released`,
        ar: `حد الدفع:
يتم دفع العمولات عندما يصل الشركاء إلى رصيد عمولة 100 دولار. أرصدة العمولات التي لم تصل بعد إلى 100 دولار ستُرحل إلى الشهر التالي حتى يتم الوصول إلى الحد الأدنى.

فترة المصادرة:
أرصدة العمولات التي لا تصل إلى الحد الأدنى لفترة 18 شهراً يتم مصادرتها بعد ذلك ولم تعد مؤهلة للدفع.

جدول الدفع:
• تتم معالجة العمولات في الخامس عشر من كل شهر
• إذا صادف الخامس عشر عطلة نهاية الأسبوع أو عطلة رسمية، تتم معالجة العمولات في يوم العمل التالي المتاح
• سيتم الدفع إلى طريقة الدفع النشطة في حساب الأفلييت الخاص بك في ذلك الوقت

طرق الدفع:
• PayPal
• تحويل بنكي (للأرصدة التي تزيد عن 500 دولار)
• Payoneer

العملة:
يتم دفع جميع الأموال بالدولار الأمريكي (USD).

الوثائق المطلوبة:
• بطاقة هوية وطنية صالحة أو جواز سفر
• التسجيل الضريبي (إن وجد)
• يجب أن تكون تفاصيل الدفع الكاملة والدقيقة مسجلة قبل إصدار الدفع`
      }
    },
    {
      id: 'restrictions',
      title: { en: 'Affiliate Restrictions', ar: 'قيود الأفلييت' },
      icon: ShieldAlert,
      content: {
        en: `The following restrictions apply to all affiliates. If at any time these restrictions are not adhered to, this Agreement will be terminated, you will be removed from the affiliate program and any unpaid commissions will be canceled and will not be paid.

Prohibited Activities:
• Affiliates may not use their affiliate link for self-referring accounts used for their own personal use
• Cookie stuffing will not be tolerated and will result in termination
• Use of browser extensions to set affiliate IDs or refer traffic is prohibited
• Affiliates cannot use traffic exchanges or incentive offers
• Affiliates cannot earn commissions on their own purchases
• Affiliates may not format pages with affiliate links using iframes or any other disguising methods

Brand Protection:
• It is at our discretion whether to allow affiliates based on the content of their website who have "progineous", "pro gineous" or any variation in their domain name
• Affiliates are prohibited from making representations that visitors are visiting the Pro Gineous site when they are not

Marketing Restrictions:
• Affiliates are prohibited from using spam or any other unsolicited mass email campaigns
• Affiliates may not promote Pro Gineous via browser add-ons or toolbars
• Affiliates are prohibited from promoting on sites whose primary function is to distribute coupon/promotional codes
• Affiliates may not promote exclusive offers negotiated through non-affiliate channels

Sales Voiding:
Sales will be voided when these rules are violated. Other occasions when an affiliate sale will be voided include:
• Canceled before 45-day approval period
• Test transactions
• Duplicate sales
• Fraudulent orders`,
        ar: `تنطبق القيود التالية على جميع الشركاء. إذا لم يتم الالتزام بهذه القيود في أي وقت، سيتم إنهاء هذه الاتفاقية، وستتم إزالتك من برنامج الأفلييت وسيتم إلغاء أي عمولات غير مدفوعة ولن يتم دفعها.

الأنشطة المحظورة:
• لا يجوز للشركاء استخدام رابط الأفلييت الخاص بهم لإحالة حسابات لاستخدامهم الشخصي
• لن يتم التسامح مع حشو ملفات تعريف الارتباط وسيؤدي إلى الإنهاء
• استخدام إضافات المتصفح لتعيين معرفات الأفلييت أو إحالة حركة المرور محظور
• لا يمكن للشركاء استخدام تبادل الزيارات أو عروض الحوافز
• لا يمكن للشركاء كسب عمولات على مشترياتهم الخاصة
• لا يجوز للشركاء تنسيق الصفحات بروابط الأفلييت باستخدام إطارات iframe أو أي طرق تمويه أخرى

حماية العلامة التجارية:
• يعود الأمر لتقديرنا في السماح للشركاء بناءً على محتوى موقعهم الذين لديهم "progineous" أو "pro gineous" أو أي اختلاف في اسم نطاقهم
• يُحظر على الشركاء تقديم تمثيلات بأن الزوار يزورون موقع برو جينيوس عندما لا يكونون كذلك

قيود التسويق:
• يُحظر على الشركاء استخدام البريد العشوائي أو أي حملات بريد إلكتروني جماعية غير مرغوب فيها
• لا يجوز للشركاء الترويج لبرو جينيوس عبر إضافات المتصفح أو أشرطة الأدوات
• يُحظر على الشركاء الترويج على المواقع التي وظيفتها الأساسية توزيع أكواد الكوبونات/الترويجية
• لا يجوز للشركاء الترويج لعروض حصرية تم التفاوض عليها من خلال قنوات غير تابعة

إلغاء المبيعات:
سيتم إلغاء المبيعات عند انتهاك هذه القواعد. المناسبات الأخرى التي سيتم فيها إلغاء مبيعات الأفلييت تشمل:
• الإلغاء قبل فترة الموافقة البالغة 45 يوماً
• المعاملات التجريبية
• المبيعات المكررة
• الطلبات الاحتيالية`
      }
    },
    {
      id: 'anti-spam',
      title: { en: 'Anti-Spam Policy', ar: 'سياسة مكافحة البريد العشوائي' },
      icon: Mail,
      content: {
        en: `We do not and will not tolerate the sending of unsolicited email messages and will take appropriate action against all offenders. By agreeing to this Agreement, you also agree to the following:

Email Requirements:
a) Emails promoting Pro Gineous shall not contain falsified sender domain name or falsified IP address

b) Emails shall not be routed or relayed through servers that the sender does not have explicit authorization to use

c) Emails shall not contain false or misleading subject lines that attempt to disguise the content

d) All emails shall contain valid and responsive contact information of the sender, including your physical address

e) No emails shall be sent for the purpose of harvesting email addresses

f) All emails promoting Pro Gineous will be sent to individuals who have given their Affirmative Consent

Opt-Out Requirements:
g) Every email shall contain a functioning return electronic mail address that recipients may use to request not to receive future messages

h) You shall process all opt-out requests within 5 business days or less

Branding:
i) Unless otherwise directed by Pro Gineous in writing, you shall not use Pro Gineous or its represented advertisers' names in the originating or return email address line, header or subject line

j) All email transmissions shall contain language that clearly announces that the offer is being sent by you for the benefit of your users`,
        ar: `نحن لا نتسامح ولن نتسامح مع إرسال رسائل بريد إلكتروني غير مرغوب فيها وسنتخذ الإجراءات المناسبة ضد جميع المخالفين. بموافقتك على هذه الاتفاقية، فإنك توافق أيضاً على ما يلي:

متطلبات البريد الإلكتروني:
أ) يجب ألا تحتوي رسائل البريد الإلكتروني التي تروج لبرو جينيوس على اسم نطاق مرسل مزيف أو عنوان IP مزيف

ب) يجب ألا يتم توجيه رسائل البريد الإلكتروني أو ترحيلها عبر خوادم ليس لدى المرسل تصريح صريح لاستخدامها

ج) يجب ألا تحتوي رسائل البريد الإلكتروني على سطور موضوع كاذبة أو مضللة تحاول إخفاء المحتوى

د) يجب أن تحتوي جميع رسائل البريد الإلكتروني على معلومات اتصال صالحة وسريعة الاستجابة للمرسل، بما في ذلك عنوانك الفعلي

هـ) لا يجوز إرسال رسائل بريد إلكتروني لغرض جمع عناوين البريد الإلكتروني

و) سيتم إرسال جميع رسائل البريد الإلكتروني التي تروج لبرو جينيوس إلى الأفراد الذين أعطوا موافقتهم الإيجابية

متطلبات إلغاء الاشتراك:
ز) يجب أن يحتوي كل بريد إلكتروني على عنوان بريد إلكتروني للرد يعمل يمكن للمستلمين استخدامه لطلب عدم تلقي رسائل مستقبلية

ح) يجب عليك معالجة جميع طلبات إلغاء الاشتراك خلال 5 أيام عمل أو أقل

العلامة التجارية:
ط) ما لم توجه برو جينيوس خلاف ذلك كتابياً، لا يجوز لك استخدام برو جينيوس أو أسماء المعلنين الممثلين لها في سطر عنوان البريد الإلكتروني المنشئ أو المرتجع أو الرأس أو سطر الموضوع

ي) يجب أن تحتوي جميع رسائل البريد الإلكتروني على لغة تعلن بوضوح أن العرض يتم إرساله من قبلك لصالح مستخدميك`
      }
    },
    {
      id: 'disclaimer',
      title: { en: 'Disclaimer', ar: 'إخلاء المسؤولية' },
      icon: AlertTriangle,
      content: {
        en: `Pro Gineous does not express or imply any warranties or representations with respect to our affiliate program or an affiliate's potential to earn income from our affiliate program.

We make no representation that either our site or that of the affiliate program will be uninterrupted or error-free and we will not be liable for any consequences of interruptions or server down time.

No Guaranteed Income:
• Past performance is not indicative of future results
• Individual results may vary based on effort, market conditions, and other factors
• We do not guarantee any specific level of income or success

Technical Availability:
• We strive for maximum uptime but cannot guarantee 100% availability
• Scheduled maintenance may temporarily affect affiliate tracking
• We are not responsible for third-party service disruptions

Affiliate Materials:
• All promotional materials are provided "as is"
• We may modify or discontinue materials at any time
• Affiliates are responsible for ensuring their use of materials complies with local laws`,
        ar: `لا تعبر برو جينيوس أو تضمن أي ضمانات أو تمثيلات فيما يتعلق ببرنامج الأفلييت الخاص بنا أو إمكانية الشريك في كسب دخل من برنامج الأفلييت الخاص بنا.

نحن لا نقدم أي تمثيل بأن موقعنا أو برنامج الأفلييت سيكون دون انقطاع أو خالياً من الأخطاء ولن نكون مسؤولين عن أي عواقب للانقطاعات أو توقف الخادم.

لا يوجد دخل مضمون:
• الأداء السابق لا يدل على النتائج المستقبلية
• قد تختلف النتائج الفردية بناءً على الجهد وظروف السوق وعوامل أخرى
• نحن لا نضمن أي مستوى محدد من الدخل أو النجاح

التوفر التقني:
• نسعى لتحقيق أقصى وقت تشغيل ولكن لا يمكننا ضمان توفر 100%
• قد تؤثر الصيانة المجدولة مؤقتاً على تتبع الأفلييت
• نحن غير مسؤولين عن انقطاعات خدمات الطرف الثالث

مواد الأفلييت:
• يتم تقديم جميع المواد الترويجية "كما هي"
• قد نقوم بتعديل أو إيقاف المواد في أي وقت
• الشركاء مسؤولون عن ضمان امتثال استخدامهم للمواد للقوانين المحلية`
      }
    },
    {
      id: 'licenses',
      title: { en: 'Grant of Licenses', ar: 'منح التراخيص' },
      icon: Award,
      content: {
        en: `License Grant:
We grant to you a non-exclusive, non-transferable, revocable right to:
(i) Access our site through HTML links solely in accordance with the terms of this Agreement
(ii) Solely in connection with such links, to use our logos, trade names, trademarks, and similar identifying material (collectively, the "Licensed Materials") that we provide to you or authorize for such purpose

Conditions of Use:
• You are only entitled to use the Licensed Materials to the extent that you are a member in good standing of Pro Gineous's Affiliate Program
• You agree that all uses of the Licensed Materials will be on behalf of Pro Gineous and the good will associated therewith will inure to the sole benefit of Pro Gineous

Restrictions on Use:
• Each party agrees not to use the other's proprietary materials in any manner that is disparaging, misleading, obscene or that otherwise portrays the party in a negative light
• Each party reserves all of its respective rights in the proprietary materials covered by this license
• Other than the license granted in this Agreement, each party retains all right, title, and interest to its respective rights and no right, title, or interest is transferred to the other`,
        ar: `منح الترخيص:
نمنحك حقاً غير حصري وغير قابل للتحويل وقابل للإلغاء في:
(أ) الوصول إلى موقعنا من خلال روابط HTML فقط وفقاً لشروط هذه الاتفاقية
(ب) فقط فيما يتعلق بهذه الروابط، لاستخدام شعاراتنا وأسمائنا التجارية وعلاماتنا التجارية والمواد التعريفية المماثلة (مجتمعة، "المواد المرخصة") التي نقدمها لك أو نصرح بها لهذا الغرض

شروط الاستخدام:
• يحق لك فقط استخدام المواد المرخصة طالما أنك عضو بحالة جيدة في برنامج الأفلييت الخاص ببرو جينيوس
• توافق على أن جميع استخدامات المواد المرخصة ستكون نيابة عن برو جينيوس والسمعة الحسنة المرتبطة بها ستعود بالفائدة على برو جينيوس وحدها

قيود الاستخدام:
• يوافق كل طرف على عدم استخدام المواد الخاصة بالطرف الآخر بأي طريقة مسيئة أو مضللة أو فاحشة أو تصور الطرف بشكل سلبي
• يحتفظ كل طرف بجميع حقوقه في المواد الخاصة المشمولة بهذا الترخيص
• بخلاف الترخيص الممنوح في هذه الاتفاقية، يحتفظ كل طرف بجميع الحقوق والملكية والمصلحة في حقوقه ولا يتم نقل أي حق أو ملكية أو مصلحة إلى الطرف الآخر`
      }
    },
    {
      id: 'liability',
      title: { en: 'Limitations of Liability', ar: 'حدود المسؤولية' },
      icon: Scale,
      content: {
        en: `WE WILL NOT BE LIABLE TO YOU WITH RESPECT TO ANY SUBJECT MATTER OF THIS AGREEMENT UNDER ANY CONTRACT, NEGLIGENCE, TORT, STRICT LIABILITY OR OTHER LEGAL OR EQUITABLE THEORY FOR ANY INDIRECT, INCIDENTAL, CONSEQUENTIAL, SPECIAL OR EXEMPLARY DAMAGES.

This includes, without limitation:
• Loss of revenue or goodwill
• Anticipated profits
• Lost business opportunities

EVEN IF WE HAVE BEEN ADVISED OF THE POSSIBILITY OF SUCH DAMAGES.

Maximum Liability:
Notwithstanding anything to the contrary contained in this Agreement, in no event shall Pro Gineous's cumulative liability to you arising out of or related to this Agreement, whether based in contract, negligence, strict liability, tort or other legal or equitable theory, exceed the total commission fees paid to you under this Agreement.

This limitation applies to:
• Direct damages
• Claims arising from system failures
• Any breach of this Agreement
• Any other claim related to the affiliate program`,
        ar: `لن نكون مسؤولين تجاهك فيما يتعلق بأي موضوع من هذه الاتفاقية بموجب أي عقد أو إهمال أو ضرر أو مسؤولية صارمة أو أي نظرية قانونية أو منصفة أخرى عن أي أضرار غير مباشرة أو عرضية أو تبعية أو خاصة أو تأديبية.

يشمل ذلك، دون حصر:
• فقدان الإيرادات أو السمعة الحسنة
• الأرباح المتوقعة
• فرص العمل الضائعة

حتى لو تم إخطارنا بإمكانية حدوث مثل هذه الأضرار.

الحد الأقصى للمسؤولية:
على الرغم من أي شيء يتعارض مع ما ورد في هذه الاتفاقية، في أي حال من الأحوال لن تتجاوز المسؤولية التراكمية لبرو جينيوس تجاهك الناشئة عن أو المتعلقة بهذه الاتفاقية، سواء كانت قائمة على العقد أو الإهمال أو المسؤولية الصارمة أو الضرر أو أي نظرية قانونية أو منصفة أخرى، إجمالي رسوم العمولات المدفوعة لك بموجب هذه الاتفاقية.

ينطبق هذا التحديد على:
• الأضرار المباشرة
• المطالبات الناشئة عن أعطال النظام
• أي خرق لهذه الاتفاقية
• أي مطالبة أخرى تتعلق ببرنامج الأفلييت`
      }
    },
    {
      id: 'indemnification',
      title: { en: 'Indemnification', ar: 'التعويض' },
      icon: Handshake,
      content: {
        en: `You hereby agree to indemnify and hold harmless Pro Gineous, and its subsidiaries and affiliates, and their directors, officers, employees, agents, shareholders, partners, members, and other owners, against any and all claims, actions, demands, liabilities, losses, damages, judgments, settlements, costs, and expenses (including reasonable attorneys' fees).

This indemnification applies to Losses arising out of or based on:

(i) Any claim that our use of your affiliate trademarks infringes on any trademark, trade name, service mark, copyright, license, intellectual property, or other proprietary right of any third party

(ii) Any misrepresentation of a representation or warranty or breach of a covenant or breach of this Agreement made by you herein

(iii) Any claim related to your site, including, without limitation, content therein not attributable to us

Your Obligations:
• Promptly notify Pro Gineous of any claims
• Cooperate fully in the defense of any claims
• Not settle any claims without prior written consent from Pro Gineous`,
        ar: `توافق بموجب هذا على تعويض وحماية برو جينيوس والشركات التابعة لها والشركات المنتسبة إليها ومديريها ومسؤوليها وموظفيها ووكلائها ومساهميها وشركائها وأعضائها وأصحابها الآخرين من وضد أي وجميع المطالبات والدعاوى والمطالب والمسؤوليات والخسائر والأضرار والأحكام والتسويات والتكاليف والنفقات (بما في ذلك أتعاب المحاماة المعقولة).

ينطبق هذا التعويض على الخسائر الناشئة عن أو القائمة على:

(أ) أي ادعاء بأن استخدامنا لعلاماتك التجارية التابعة ينتهك أي علامة تجارية أو اسم تجاري أو علامة خدمة أو حقوق نشر أو ترخيص أو ملكية فكرية أو أي حق ملكية آخر لأي طرف ثالث

(ب) أي تحريف لتمثيل أو ضمان أو خرق عهد أو خرق لهذه الاتفاقية من قبلك

(ج) أي ادعاء يتعلق بموقعك، بما في ذلك، دون حصر، المحتوى غير المنسوب إلينا

التزاماتك:
• إخطار برو جينيوس فوراً بأي مطالبات
• التعاون الكامل في الدفاع عن أي مطالبات
• عدم تسوية أي مطالبات دون موافقة كتابية مسبقة من برو جينيوس`
      }
    },
    {
      id: 'confidentiality',
      title: { en: 'Confidentiality', ar: 'السرية' },
      icon: Lock,
      content: {
        en: `All confidential information, including, but not limited to, any business, technical, financial, and customer information, disclosed by one party to the other during negotiation or the effective term of this Agreement which is marked "Confidential," or should be understood as confidential under the circumstances, will remain the sole property of the disclosing party.

Obligations:
Each party will keep in confidence and not use or disclose such proprietary information of the other party without express written permission of the disclosing party.

What is Considered Confidential:
• Commission rates and payment structures
• Conversion rates and performance metrics
• Customer data and analytics
• Marketing strategies and materials
• Technical specifications and integrations

Exceptions:
Information is not considered confidential if it:
• Is publicly available through no fault of the receiving party
• Was already known to the receiving party before disclosure
• Is required to be disclosed by law or court order`,
        ar: `جميع المعلومات السرية، بما في ذلك على سبيل المثال لا الحصر، أي معلومات تجارية أو تقنية أو مالية أو معلومات العملاء، التي يكشف عنها أحد الطرفين للآخر أثناء التفاوض أو الفترة الفعلية لهذه الاتفاقية والمميزة بعلامة "سرية" أو التي يجب فهمها على أنها سرية في ظل الظروف، ستظل الملكية الوحيدة للطرف المُفصح.

الالتزامات:
سيحافظ كل طرف على السرية ولن يستخدم أو يكشف عن هذه المعلومات الخاصة بالطرف الآخر دون إذن كتابي صريح من الطرف المُفصح.

ما يُعتبر سرياً:
• معدلات العمولات وهياكل الدفع
• معدلات التحويل ومقاييس الأداء
• بيانات العملاء والتحليلات
• استراتيجيات ومواد التسويق
• المواصفات التقنية والتكاملات

الاستثناءات:
لا تُعتبر المعلومات سرية إذا:
• كانت متاحة للعموم دون خطأ من الطرف المتلقي
• كانت معروفة بالفعل للطرف المتلقي قبل الإفصاح
• كان مطلوباً الكشف عنها بموجب القانون أو أمر المحكمة`
      }
    },
    {
      id: 'miscellaneous',
      title: { en: 'Miscellaneous', ar: 'أحكام متنوعة' },
      icon: FileText,
      content: {
        en: `13.1. Independent Contractor
You agree that you are an independent contractor, and nothing in this Agreement will create any partnership, joint venture, agency, franchise, sales representative, or employment relationship between you and Pro Gineous. You will have no authority to make or accept any offers or representations on our behalf.

13.2. Assignment
Neither party may assign its rights or obligations under this Agreement to any party, except to a party who obtains all or substantially all of the business or assets of a third party.

13.3. Governing Law
This Agreement shall be governed by and interpreted in accordance with the laws of the Arab Republic of Egypt without regard to the conflicts of laws and principles thereof.

13.4. Amendments
You may not amend or waive any provision of this Agreement unless in writing and signed by both parties.

13.5. Entire Agreement
This Agreement represents the entire agreement between us and you, and shall supersede all prior agreements and communications of the parties, oral or written.

13.6. Headings
The headings and titles contained in this Agreement are included for convenience only, and shall not limit or otherwise affect the terms of this Agreement.

13.7. Severability
If any provision of this Agreement is held to be invalid or unenforceable, that provision shall be eliminated or limited to the minimum extent necessary such that the intent of the parties is effectuated, and the remainder of this agreement shall have full force and effect.

Last Updated: January 1, 2025`,
        ar: `13.1. مقاول مستقل
توافق على أنك مقاول مستقل، ولن يُنشئ أي شيء في هذه الاتفاقية أي شراكة أو مشروع مشترك أو وكالة أو امتياز أو علاقة مندوب مبيعات أو علاقة توظيف بينك وبين برو جينيوس. لن يكون لديك أي سلطة لتقديم أو قبول أي عروض أو تمثيلات نيابة عنا.

13.2. التنازل
لا يجوز لأي طرف التنازل عن حقوقه أو التزاماته بموجب هذه الاتفاقية لأي طرف، باستثناء طرف يحصل على كل أو معظم الأعمال أو الأصول الخاصة بطرف ثالث.

13.3. القانون الحاكم
تخضع هذه الاتفاقية وتُفسر وفقاً لقوانين جمهورية مصر العربية دون مراعاة تعارض القوانين ومبادئها.

13.4. التعديلات
لا يجوز لك تعديل أو التنازل عن أي حكم من أحكام هذه الاتفاقية ما لم يكن ذلك كتابياً وموقعاً من كلا الطرفين.

13.5. الاتفاقية الكاملة
تمثل هذه الاتفاقية الاتفاقية الكاملة بيننا وبينك، وتحل محل جميع الاتفاقيات والاتصالات السابقة بين الطرفين، الشفهية أو المكتوبة.

13.6. العناوين
العناوين والعناوين الواردة في هذه الاتفاقية مدرجة للملاءمة فقط، ولن تحد أو تؤثر بأي شكل آخر على شروط هذه الاتفاقية.

13.7. قابلية الفصل
إذا تم اعتبار أي حكم من أحكام هذه الاتفاقية غير صالح أو غير قابل للتنفيذ، فسيتم حذف هذا الحكم أو تقييده إلى الحد الأدنى الضروري بحيث يتم تحقيق نية الطرفين، وسيظل باقي هذه الاتفاقية ساري المفعول والتأثير الكامل.

آخر تحديث: 1 يناير 2025`
      }
    },
    {
      id: 'contact',
      title: { en: 'Contact Us', ar: 'اتصل بنا' },
      icon: Mail,
      content: {
        en: `For questions about this Affiliate Policy or the Pro Gineous Affiliate Program:

Pro Gineous - Affiliate Team

Address:
9 Mustafa Kamel Street
Balwalidain Ihsanah Tower
Beni Suef, Egypt

Email:
affiliates@progineous.com

Support Portal:
https://app.progineous.com/submitticket.php
(Select "Affiliate Program" as the department)

Response Times:
• General inquiries: Within 24-48 hours
• Commission inquiries: Within 48-72 hours
• Payment issues: Within 5 business days

Business Hours:
Sunday - Thursday: 9:00 AM - 6:00 PM (Egypt Time)
Friday - Saturday: Closed

Join Our Affiliate Program:
https://app.progineous.com/affiliates.php

Company Information:
Commercial Register: 90088
Tax Registration: 755-552-334`,
        ar: `للأسئلة حول سياسة الأفلييت هذه أو برنامج الأفلييت الخاص ببرو جينيوس:

برو جينيوس - فريق الأفلييت

العنوان:
9 شارع مصطفى كامل
برج بالوالدين إحسانًا
بني سويف، مصر

البريد الإلكتروني:
affiliates@progineous.com

بوابة الدعم:
https://app.progineous.com/submitticket.php
(اختر "برنامج الأفلييت" كقسم)

أوقات الاستجابة:
• الاستفسارات العامة: خلال 24-48 ساعة
• استفسارات العمولات: خلال 48-72 ساعة
• مشاكل الدفع: خلال 5 أيام عمل

ساعات العمل:
الأحد - الخميس: 9:00 صباحًا - 6:00 مساءً (توقيت مصر)
الجمعة - السبت: مغلق

انضم لبرنامج الأفلييت:
https://app.progineous.com/affiliates.php

معلومات الشركة:
السجل التجاري: 90088
رقم التسجيل الضريبي: 755-552-334`
      }
    }
  ];

  useEffect(() => {
    const handleScroll = () => {
      const sectionElements = sections.map(section => ({
        id: section.id,
        element: document.getElementById(section.id)
      }));

      const scrollPosition = window.scrollY + 150;

      for (let i = sectionElements.length - 1; i >= 0; i--) {
        const section = sectionElements[i];
        if (section.element && section.element.offsetTop <= scrollPosition) {
          setActiveSection(section.id);
          break;
        }
      }
    };

    window.addEventListener('scroll', handleScroll);
    handleScroll();

    return () => window.removeEventListener('scroll', handleScroll);
  }, []);

  const scrollToSection = (sectionId: string) => {
    const element = document.getElementById(sectionId);
    if (element) {
      const offsetTop = element.offsetTop - 100;
      window.scrollTo({
        top: offsetTop,
        behavior: 'smooth'
      });
    }
  };

  const relatedLinks = [
    { title: { en: 'Terms of Service', ar: 'شروط الخدمة' }, href: `/${locale}/terms` },
    { title: { en: 'Privacy Policy', ar: 'سياسة الخصوصية' }, href: `/${locale}/privacy` },
    { title: { en: 'Acceptable Use Policy', ar: 'سياسة الاستخدام المقبول' }, href: `/${locale}/aup` },
    { title: { en: 'DMCA Policy', ar: 'سياسة DMCA' }, href: `/${locale}/dmca` },
    { title: { en: 'Refund & Billing', ar: 'الاسترداد والفوترة' }, href: `/${locale}/refund` },
    { title: { en: 'Refer a Friend', ar: 'إحالة صديق' }, href: `/${locale}/refer-friend` }
  ];

  return (
    <div className={`min-h-screen bg-gray-50 ${isRTL ? 'rtl' : 'ltr'}`}>
      {/* JSON-LD Structured Data */}
      <script
        type="application/ld+json"
        dangerouslySetInnerHTML={{
          __html: JSON.stringify({
            '@context': 'https://schema.org',
            '@type': 'WebPage',
            name: isRTL ? 'برنامج الأفلييت - بروجينيوس' : 'Affiliate Program - Pro Gineous',
            description: isRTL
              ? 'انضم لبرنامج الأفلييت واربح عمولات على كل عملية بيع'
              : 'Join our affiliate program and earn commissions on every sale',
            url: `https://progineous.com/${locale}/affiliate`,
            mainEntity: {
              '@type': 'Service',
              name: isRTL ? 'برنامج الأفلييت' : 'Affiliate Program',
              provider: {
                '@type': 'Organization',
                name: 'Pro Gineous',
              },
              offers: {
                '@type': 'Offer',
                description: isRTL ? 'عمولات تصل إلى 125 دولار لكل عملية بيع' : 'Commissions up to $125 per sale',
                priceCurrency: 'USD',
              },
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
              { '@type': 'ListItem', position: 2, name: isRTL ? 'برنامج الأفلييت' : 'Affiliate Program', item: `https://progineous.com/${locale}/affiliate` },
            ],
          }),
        }}
      />

      {/* Header */}
      <div className="relative z-30 bg-linear-to-r from-green-600 via-emerald-600 to-teal-600 text-white">
        <div className="absolute inset-0 bg-[url('/patterns/circuit.svg')] opacity-10"></div>
        <div className="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-24">
          <div className="text-center">
            <div className="inline-flex items-center justify-center w-20 h-20 bg-white/10 backdrop-blur-sm rounded-2xl mb-6">
              <Users className="w-10 h-10 text-white" />
            </div>
            <h1 className="text-4xl lg:text-5xl font-bold mb-4">
              {isRTL ? 'سياسة برنامج الأفلييت' : 'Affiliate Policy'}
            </h1>
            <p className="text-lg text-green-100 max-w-2xl mx-auto">
              {isRTL
                ? 'الشروط والأحكام للمشاركة في برنامج الأفلييت الخاص ببرو جينيوس'
                : 'Terms and conditions for participating in the Pro Gineous Affiliate Program'}
            </p>
          </div>
        </div>
        <div className="absolute bottom-0 left-0 right-0">
          <svg viewBox="0 0 1440 60" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0 60L1440 60L1440 0C1440 0 1140 60 720 60C300 60 0 0 0 0L0 60Z" fill="#F9FAFB" />
          </svg>
        </div>
      </div>

      {/* Main Content */}
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div className="flex flex-col lg:flex-row gap-8">
          {/* Sidebar */}
          <div className="lg:w-72 shrink-0">
            <div className="lg:sticky lg:top-24">
              <nav className="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                <h3 className="font-semibold text-gray-900 mb-4 px-3">
                  {isRTL ? 'المحتويات' : 'Contents'}
                </h3>
                <ul className="space-y-1">
                  {sections.map((section, index) => {
                    const Icon = section.icon;
                    return (
                      <li key={section.id}>
                        <button
                          onClick={() => scrollToSection(section.id)}
                          className={`w-full flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-all ${
                            activeSection === section.id
                              ? 'bg-green-50 text-green-700 font-medium'
                              : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'
                          }`}
                        >
                          <span className={`flex items-center justify-center w-6 h-6 rounded-md text-xs font-medium ${
                            activeSection === section.id
                              ? 'bg-green-600 text-white'
                              : 'bg-gray-100 text-gray-500'
                          }`}>
                            {index + 1}
                          </span>
                          <span className="truncate">{section.title[locale] || section.title.en}</span>
                        </button>
                      </li>
                    );
                  })}
                </ul>
              </nav>

              {/* Related Links */}
              <div className="mt-6 bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                <h3 className="font-semibold text-gray-900 mb-4 px-3">
                  {isRTL ? 'روابط ذات صلة' : 'Related Links'}
                </h3>
                <ul className="space-y-2">
                  {relatedLinks.map((link, index) => (
                    <li key={index}>
                      <Link
                        href={link.href}
                        className="flex items-center gap-2 px-3 py-2 text-sm text-gray-600 hover:text-green-600 hover:bg-green-50 rounded-lg transition-colors"
                      >
                        <ChevronRight className={`w-4 h-4 ${isRTL ? 'rotate-180' : ''}`} />
                        {link.title[locale] || link.title.en}
                      </Link>
                    </li>
                  ))}
                </ul>
              </div>

              {/* Join CTA */}
              <div className="mt-6 bg-linear-to-br from-green-600 to-emerald-600 rounded-xl shadow-sm p-6 text-white">
                <div className="flex items-center gap-3 mb-3">
                  <Percent className="w-8 h-8" />
                  <h3 className="font-semibold">
                    {isRTL ? 'انضم الآن' : 'Join Now'}
                  </h3>
                </div>
                <p className="text-sm text-green-100 mb-4">
                  {isRTL
                    ? 'اكسب عمولات على كل عملية بيع تحققها'
                    : 'Earn commissions on every sale you generate'}
                </p>
                <Link
                  href="https://app.progineous.com/affiliates.php"
                  target="_blank"
                  className="block w-full py-2 px-4 bg-white text-green-600 font-medium rounded-lg text-center hover:bg-green-50 transition-colors"
                >
                  {isRTL ? 'سجل الآن' : 'Sign Up'}
                </Link>
              </div>
            </div>
          </div>

          {/* Content */}
          <div className="flex-1 min-w-0">
            <div className="bg-white rounded-xl shadow-sm border border-gray-100">
              {sections.map((section, index) => {
                const Icon = section.icon;
                return (
                  <div
                    key={section.id}
                    id={section.id}
                    className={`p-6 lg:p-8 ${index !== sections.length - 1 ? 'border-b border-gray-100' : ''}`}
                  >
                    <div className="flex items-start gap-4 mb-4">
                      <div className="flex items-center justify-center w-10 h-10 bg-green-100 text-green-600 rounded-lg shrink-0">
                        <Icon className="w-5 h-5" />
                      </div>
                      <div>
                        <div className="flex items-center gap-2 mb-1">
                          <span className="text-xs font-medium text-green-600 bg-green-50 px-2 py-0.5 rounded">
                            {isRTL ? `القسم ${index + 1}` : `Section ${index + 1}`}
                          </span>
                        </div>
                        <h2 className="text-xl lg:text-2xl font-bold text-gray-900">
                          {section.title[locale] || section.title.en}
                        </h2>
                      </div>
                    </div>
                    <div className={`prose prose-gray max-w-none ${isRTL ? 'text-right' : ''}`}>
                      {(section.content[locale] || section.content.en).split('\n\n').map((paragraph, pIndex) => (
                        <p key={pIndex} className="text-gray-600 leading-relaxed whitespace-pre-line mb-4">
                          {isRTL ? <RTLText>{paragraph}</RTLText> : paragraph}
                        </p>
                      ))}
                    </div>
                  </div>
                );
              })}
            </div>

            {/* Last Updated */}
            <div className="mt-6 text-center text-sm text-gray-500">
              {isRTL ? 'آخر تحديث: 1 يناير 2025' : 'Last Updated: January 1, 2025'}
            </div>
          </div>
        </div>
      </div>
    </div>
  );
}
