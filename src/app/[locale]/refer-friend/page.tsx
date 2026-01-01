'use client';

import { useState, useEffect } from 'react';
import { useParams } from 'next/navigation';
import Link from 'next/link';
import {
  Gift,
  FileText,
  Package,
  Users,
  DollarSign,
  ShieldAlert,
  Scale,
  AlertTriangle,
  ChevronRight,
  Heart,
  Share2,
  CreditCard
} from 'lucide-react';
import { RTLText } from '@/components/ui/RTLText';

type Locale = 'en' | 'ar';

export default function ReferFriendPolicyPage() {
  const params = useParams();
  const locale = (params?.locale as Locale) || 'en';
  const isRTL = locale === 'ar';
  const [activeSection, setActiveSection] = useState('terms');

  const sections = [
    {
      id: 'terms',
      title: { en: 'Terms of Service', ar: 'شروط الخدمة' },
      icon: FileText,
      content: {
        en: `These Terms of Service ("These Terms") are a legal agreement between you and Pro Gineous ("We", "us", "Pro Gineous") and govern Pro Gineous's Refer-a-Friend program ("Referral Program" or "this Program").

These Terms are valid in addition to the existing terms and notices of Pro Gineous, including but not limited to, Terms and Conditions, Privacy Policy and Acceptable Usage Policy. By participating in our Referral Program, you agree to the terms outlined below.

The Pro Gineous Referral Program gives you the opportunity to earn commission on eligible products for each new customer that originates from your referral link. In addition, eligible referred customers ("Friends") may receive a one-time account credit as described in the Friend Reward section below.

By participating in our Referral Program you agree to be bound by these Terms.

Important Note:
Commissions through this program cannot be combined with any other referral or affiliate programs offered by Pro Gineous.`,
        ar: `شروط الخدمة هذه ("هذه الشروط") هي اتفاقية قانونية بينك وبين برو جينيوس ("نحن"، "لنا"، "برو جينيوس") وتحكم برنامج "إحالة صديق" الخاص ببرو جينيوس ("برنامج الإحالة" أو "هذا البرنامج").

هذه الشروط سارية بالإضافة إلى الشروط والإشعارات الحالية لبرو جينيوس، بما في ذلك على سبيل المثال لا الحصر، الشروط والأحكام وسياسة الخصوصية وسياسة الاستخدام المقبول. بالمشاركة في برنامج الإحالة الخاص بنا، فإنك توافق على الشروط الموضحة أدناه.

يمنحك برنامج الإحالة الخاص ببرو جينيوس الفرصة لكسب عمولة على المنتجات المؤهلة لكل عميل جديد ينشأ من رابط الإحالة الخاص بك. بالإضافة إلى ذلك، قد يحصل العملاء المُحالون المؤهلون ("الأصدقاء") على رصيد حساب لمرة واحدة كما هو موضح في قسم مكافأة الصديق أدناه.

بالمشاركة في برنامج الإحالة الخاص بنا، فإنك توافق على الالتزام بهذه الشروط.

ملاحظة مهمة:
لا يمكن دمج العمولات من خلال هذا البرنامج مع أي برامج إحالة أو شراكة أخرى تقدمها برو جينيوس.`
      }
    },
    {
      id: 'eligible-products',
      title: { en: 'Eligible Products & Services', ar: 'المنتجات والخدمات المؤهلة' },
      icon: Package,
      content: {
        en: `The following products and services qualify as eligible products and services under these Terms:

Shared Hosting Packages:
• Startup Plan: $20 per referral
• Essential Plan: $35 per referral
• Ultimate Plan: $50 per referral

VPS Hosting Packages:
• VPS 103 (2GB RAM): $20 per referral
• VPS 102 (4GB RAM): $35 per referral
• VPS 101 (8GB RAM): $50 per referral
• VPS 100 (16GB RAM): $65 per referral

Reseller Hosting Packages:
• Go Reseller: $50 per referral
• Prof Reseller: $70 per referral
• Premium Reseller: $100 per referral

Products NOT Eligible:
• Domain name registrations
• SSL Certificates
• Email packages
• Software licenses
• Any add-ons or upgrades

Tracking & Approval:
After you have shared your link, we will automatically track and generate a commission for any new customer sales originating from your link, provided they have purchased an eligible product.

Commissions for eligible products are held in a pending state for 45 days for refunds, chargebacks, and fraud reasons. After 45 days the commission will be reviewed and if the customer remains active, the commission becomes eligible for a payout.`,
        ar: `المنتجات والخدمات التالية مؤهلة بموجب هذه الشروط:

باقات الاستضافة المشتركة:
• خطة Startup: 20 دولار لكل إحالة
• خطة Essential: 35 دولار لكل إحالة
• خطة Ultimate: 50 دولار لكل إحالة

باقات استضافة VPS:
• VPS 103 (2 جيجا رام): 20 دولار لكل إحالة
• VPS 102 (4 جيجا رام): 35 دولار لكل إحالة
• VPS 101 (8 جيجا رام): 50 دولار لكل إحالة
• VPS 100 (16 جيجا رام): 65 دولار لكل إحالة

باقات استضافة الموزعين:
• Go Reseller: 50 دولار لكل إحالة
• Prof Reseller: 70 دولار لكل إحالة
• Premium Reseller: 100 دولار لكل إحالة

المنتجات غير المؤهلة:
• تسجيلات أسماء النطاقات
• شهادات SSL
• باقات البريد الإلكتروني
• تراخيص البرامج
• أي إضافات أو ترقيات

التتبع والموافقة:
بعد مشاركة رابطك، سنقوم تلقائياً بتتبع وإنشاء عمولة لأي مبيعات عملاء جدد تنشأ من رابطك، بشرط أن يكونوا قد اشتروا منتجاً مؤهلاً.

يتم الاحتفاظ بالعمولات للمنتجات المؤهلة في حالة معلقة لمدة 45 يوماً لأسباب الاسترداد ورد المبالغ والاحتيال. بعد 45 يوماً، سيتم مراجعة العمولة وإذا بقي العميل نشطاً، تصبح العمولة مؤهلة للدفع.`
      }
    },
    {
      id: 'friend-reward',
      title: { en: 'Friend Reward (Two-Sided Benefit)', ar: 'مكافأة الصديق (فائدة مزدوجة)' },
      icon: Gift,
      content: {
        en: `Eligible referred customers ("Friends") will receive a one-time $20 account credit when purchasing an eligible product through your referral link, subject to the following conditions:

Eligibility Requirements:
• The Friend reward applies only to purchases of products defined as Eligible Products in these Terms
• The Friend must remain an active Pro Gineous customer for 45 days following the initial purchase
• After the 45-day review period, the $20 credit will be automatically applied to the Friend's Pro Gineous account

Credit Terms:
• The $20 account credit has no cash value
• The credit is non-transferable
• May be used only as account credit toward Pro Gineous services
• The Friend reward cannot be combined with any other promotion, coupon, or discount program unless explicitly stated

Important Notes:
• Pro Gineous reserves the right to withhold the Friend reward in cases of:
  - Cancellation
  - Refund
  - Chargeback
  - Fraud
  - Ineligibility
  - Any other reason outlined in these Terms

• The Friend reward applies once per referred customer`,
        ar: `سيحصل العملاء المُحالون المؤهلون ("الأصدقاء") على رصيد حساب لمرة واحدة بقيمة 20 دولار عند شراء منتج مؤهل من خلال رابط الإحالة الخاص بك، وفقاً للشروط التالية:

متطلبات الأهلية:
• تنطبق مكافأة الصديق فقط على مشتريات المنتجات المحددة كمنتجات مؤهلة في هذه الشروط
• يجب أن يظل الصديق عميلاً نشطاً لبرو جينيوس لمدة 45 يوماً بعد الشراء الأولي
• بعد فترة المراجعة البالغة 45 يوماً، سيتم تطبيق رصيد الـ 20 دولار تلقائياً على حساب الصديق في برو جينيوس

شروط الرصيد:
• رصيد الحساب البالغ 20 دولار ليس له قيمة نقدية
• الرصيد غير قابل للتحويل
• يمكن استخدامه فقط كرصيد حساب تجاه خدمات برو جينيوس
• لا يمكن دمج مكافأة الصديق مع أي عرض ترويجي أو قسيمة أو برنامج خصم آخر ما لم يُذكر صراحةً

ملاحظات مهمة:
• تحتفظ برو جينيوس بالحق في حجب مكافأة الصديق في حالات:
  - الإلغاء
  - الاسترداد
  - رد المبالغ
  - الاحتيال
  - عدم الأهلية
  - أي سبب آخر موضح في هذه الشروط

• تنطبق مكافأة الصديق مرة واحدة لكل عميل مُحال`
      }
    },
    {
      id: 'payout-terms',
      title: { en: 'Commission Payout Terms', ar: 'شروط دفع العمولات' },
      icon: DollarSign,
      content: {
        en: `You can request your commission balance to be paid out via account credit, PayPal, or Bank transfer by submitting a ticket to the 'Referral Program' department, provided that you have the minimum balance requirement for that payment method:

Minimum Balance Requirements:
• Account Credit: No minimum requirement
• PayPal: $100+ in approved commissions
• Bank Transfer: $200+ in approved commissions

Account Credit Option:
If you choose Account Credit, the commission balance will stay valid indefinitely. In the event you do not meet the minimum payout requirements for PayPal and/or Bank Transfer, the commission balance will remain on your account until the minimum threshold has been met.

Payout Schedule:
• Payouts are performed between the 1st - 5th of each month
• If you request your payout after this date range, it will be scheduled for the next round of payouts (between the 1st and 5th of the following month)
• Due to different processing timelines among financial institutions, the actual release of funds might take several days

Bank Transfer Notice:
Depending on the policies of your bank, a bank transfer may incur additional fees and exchange rate differences which are outside of our control. The burden of this risk is solely upon you. To mitigate this risk, we recommend using PayPal.

Currency:
All payouts are made in US Dollars (USD).`,
        ar: `يمكنك طلب صرف رصيد عمولتك عبر رصيد الحساب أو PayPal أو التحويل البنكي من خلال إرسال تذكرة إلى قسم "برنامج الإحالة"، بشرط أن يكون لديك الحد الأدنى من الرصيد المطلوب لطريقة الدفع تلك:

متطلبات الحد الأدنى للرصيد:
• رصيد الحساب: لا يوجد حد أدنى مطلوب
• PayPal: 100 دولار أو أكثر في العمولات المعتمدة
• التحويل البنكي: 200 دولار أو أكثر في العمولات المعتمدة

خيار رصيد الحساب:
إذا اخترت رصيد الحساب، سيظل رصيد العمولة صالحاً إلى أجل غير مسمى. في حالة عدم استيفائك لمتطلبات الحد الأدنى للدفع لـ PayPal و/أو التحويل البنكي، سيبقى رصيد العمولة في حسابك حتى يتم الوصول إلى الحد الأدنى.

جدول الدفع:
• تتم المدفوعات بين الأول والخامس من كل شهر
• إذا طلبت الدفع بعد هذا النطاق الزمني، سيتم جدولته للجولة التالية من المدفوعات (بين الأول والخامس من الشهر التالي)
• بسبب اختلاف الجداول الزمنية للمعالجة بين المؤسسات المالية، قد يستغرق الإفراج الفعلي عن الأموال عدة أيام

إشعار التحويل البنكي:
اعتماداً على سياسات البنك الخاص بك، قد يتحمل التحويل البنكي رسوماً إضافية واختلافات في أسعار الصرف خارجة عن سيطرتنا. يقع عبء هذه المخاطر عليك وحدك. للتخفيف من هذه المخاطر، نوصي باستخدام PayPal.

العملة:
جميع المدفوعات تتم بالدولار الأمريكي (USD).`
      }
    },
    {
      id: 'restrictions',
      title: { en: 'Referral Program Restrictions', ar: 'قيود برنامج الإحالة' },
      icon: ShieldAlert,
      content: {
        en: `Commission payouts are bound to the restrictions of this section. If any sale of eligible products and services through the qualifying link falls under any of the following prohibitions, there will be no commission recognized under the Referral Program:

Prohibited Activities:

Spam Policy:
• We have a zero-tolerance policy against spam
• It is prohibited to partake in any form of spamming with your referral link
• Forbidden acts include mass emailing, texting, or otherwise messaging people you do not know

Automated Systems:
• It is prohibited to utilize automated systems/bots through any channel to distribute, promote or otherwise share your referral link

Paid Advertising:
• It is prohibited to use any type of PPC (Pay Per Click) advertising channels, such as Google Ads, Facebook Ads, Bing Ads, or others

Deceptive Practices:
• It is prohibited to place your link in an iFrame in an attempt to mislead users
• It is prohibited to participate in any form of cookie stuffing
• It is prohibited to mislead users by giving the impression of your referral link being an official & direct promotion

Distribution Restrictions:
• It is prohibited to share your link on any traffic exchange sites, or other affiliate networks
• It is prohibited to share your referral link on any coupon/discount, or other similar websites

Self-Referral:
• You cannot refer yourself or use your own referral link for your own purchases
• Referrals from the same household or IP address may be flagged for review`,
        ar: `تخضع مدفوعات العمولات لقيود هذا القسم. إذا كان أي بيع للمنتجات والخدمات المؤهلة من خلال الرابط المؤهل يندرج تحت أي من المحظورات التالية، فلن يتم الاعتراف بأي عمولة بموجب برنامج الإحالة:

الأنشطة المحظورة:

سياسة البريد العشوائي:
• لدينا سياسة عدم تسامح مطلق ضد البريد العشوائي
• يُحظر المشاركة في أي شكل من أشكال البريد العشوائي برابط الإحالة الخاص بك
• تشمل الأعمال المحظورة الإرسال الجماعي للبريد الإلكتروني أو الرسائل النصية أو مراسلة أشخاص لا تعرفهم

الأنظمة الآلية:
• يُحظر استخدام الأنظمة الآلية/البوتات من خلال أي قناة لتوزيع أو ترويج أو مشاركة رابط الإحالة الخاص بك

الإعلانات المدفوعة:
• يُحظر استخدام أي نوع من قنوات الإعلان بالدفع لكل نقرة (PPC)، مثل Google Ads أو Facebook Ads أو Bing Ads أو غيرها

الممارسات الخادعة:
• يُحظر وضع رابطك في iFrame في محاولة لتضليل المستخدمين
• يُحظر المشاركة في أي شكل من أشكال حشو ملفات تعريف الارتباط
• يُحظر تضليل المستخدمين بإعطاء انطباع بأن رابط الإحالة الخاص بك هو عرض ترويجي رسمي ومباشر

قيود التوزيع:
• يُحظر مشاركة رابطك على أي مواقع تبادل الزيارات أو شبكات الأفلييت الأخرى
• يُحظر مشاركة رابط الإحالة الخاص بك على أي مواقع كوبونات/خصومات أو مواقع مشابهة

الإحالة الذاتية:
• لا يمكنك إحالة نفسك أو استخدام رابط الإحالة الخاص بك لمشترياتك الخاصة
• قد يتم وضع علامة على الإحالات من نفس المنزل أو عنوان IP للمراجعة`
      }
    },
    {
      id: 'reserved-rights',
      title: { en: 'Reserved Rights', ar: 'الحقوق المحفوظة' },
      icon: Scale,
      content: {
        en: `Pro Gineous reserves the right to change, end, or pause in whole or in part, any Referral Program, as well as any referrer's or referee's ability to participate in any referral program or receive rewards at any time for any reason.

This includes, but is not limited to:
• Suspected fraud (by either the referrer and/or referee)
• Program abuse
• Any violation of these Terms

Commission Denial:
At our sole discretion, we reserve the right to decline commissions in the event of any of the following reasons:

• We are unable to collect funds from the referred customer
• The order is suspected of being fraudulent
• The client came from another referrer first (not you)
• The commission was generated improperly for any reason, as determined by us
• The referred customer cancels within the 45-day review period
• Evidence of collusion between referrer and referee

Program Modifications:
• We may modify commission rates at any time with notice
• Changes to eligible products may occur without prior notice
• Program terms may be updated periodically

Account Termination:
Serious or repeated violations may result in:
• Forfeiture of pending commissions
• Removal from the Referral Program
• Termination of your Pro Gineous account`,
        ar: `تحتفظ برو جينيوس بالحق في تغيير أو إنهاء أو إيقاف كلياً أو جزئياً أي برنامج إحالة، وكذلك قدرة أي مُحيل أو مُحال على المشاركة في أي برنامج إحالة أو تلقي مكافآت في أي وقت ولأي سبب.

يشمل ذلك على سبيل المثال لا الحصر:
• الاحتيال المشتبه به (من قبل المُحيل و/أو المُحال)
• إساءة استخدام البرنامج
• أي انتهاك لهذه الشروط

رفض العمولة:
وفقاً لتقديرنا الخاص، نحتفظ بالحق في رفض العمولات في حالة أي من الأسباب التالية:

• عدم قدرتنا على تحصيل الأموال من العميل المُحال
• الاشتباه في أن الطلب احتيالي
• العميل جاء من مُحيل آخر أولاً (وليس أنت)
• تم إنشاء العمولة بشكل غير صحيح لأي سبب، كما نحدده نحن
• إلغاء العميل المُحال خلال فترة المراجعة البالغة 45 يوماً
• دليل على التواطؤ بين المُحيل والمُحال

تعديلات البرنامج:
• قد نعدل معدلات العمولة في أي وقت مع الإخطار
• قد تحدث تغييرات على المنتجات المؤهلة دون إشعار مسبق
• قد يتم تحديث شروط البرنامج بشكل دوري

إنهاء الحساب:
قد تؤدي الانتهاكات الخطيرة أو المتكررة إلى:
• مصادرة العمولات المعلقة
• الإزالة من برنامج الإحالة
• إنهاء حساب برو جينيوس الخاص بك`
      }
    },
    {
      id: 'limitation-liability',
      title: { en: 'Limitation of Liability', ar: 'حدود المسؤولية' },
      icon: AlertTriangle,
      content: {
        en: `We provide the Referral Program "as is" without any express or implied warranties or any kind of guarantees.

No Warranties:
This includes, but is not limited to:
• Duration of the program
• Content or features of the program
• Promised gains or earnings
• Availability or uptime of tracking systems

Limitation of Damages:
In no event will we be liable to you or any third party for any indirect, special, incidental, consequential, exemplary, or punitive damages, including but not limited to:

• Damages for lost data
• Lost profits
• Lost business
• Loss of opportunity
• Costs of procurement of substitute goods or services

This applies however caused and under any theory of liability, and whether or not we knew or should have known about the possibility of such damage.

Maximum Liability:
Our maximum liability under this program shall not exceed the total amount of commissions actually paid to you in the twelve (12) months preceding any claim.

Your Responsibilities:
You are solely responsible for:
• Compliance with all applicable laws when promoting your referral link
• Payment of any taxes owed on commission earnings
• Maintaining accurate payment information in your account`,
        ar: `نقدم برنامج الإحالة "كما هو" دون أي ضمانات صريحة أو ضمنية أو أي نوع من الضمانات.

لا ضمانات:
يشمل ذلك على سبيل المثال لا الحصر:
• مدة البرنامج
• محتوى أو ميزات البرنامج
• المكاسب أو الأرباح الموعودة
• توفر أو وقت تشغيل أنظمة التتبع

تحديد الأضرار:
في أي حال من الأحوال لن نكون مسؤولين تجاهك أو تجاه أي طرف ثالث عن أي أضرار غير مباشرة أو خاصة أو عرضية أو تبعية أو تأديبية، بما في ذلك على سبيل المثال لا الحصر:

• أضرار البيانات المفقودة
• الأرباح المفقودة
• الأعمال المفقودة
• فقدان الفرصة
• تكاليف شراء سلع أو خدمات بديلة

ينطبق هذا بغض النظر عن السبب وبموجب أي نظرية للمسؤولية، وسواء كنا نعلم أو كان يجب أن نعلم بإمكانية حدوث مثل هذا الضرر.

الحد الأقصى للمسؤولية:
لن تتجاوز مسؤوليتنا القصوى بموجب هذا البرنامج إجمالي مبلغ العمولات المدفوعة فعلياً لك في الاثني عشر (12) شهراً السابقة لأي مطالبة.

مسؤولياتك:
أنت وحدك المسؤول عن:
• الامتثال لجميع القوانين المعمول بها عند الترويج لرابط الإحالة الخاص بك
• دفع أي ضرائب مستحقة على أرباح العمولات
• الحفاظ على معلومات دفع دقيقة في حسابك`
      }
    },
    {
      id: 'how-it-works',
      title: { en: 'How It Works', ar: 'كيف يعمل البرنامج' },
      icon: Share2,
      content: {
        en: `Getting started with the Pro Gineous Refer-a-Friend program is easy:

Step 1: Get Your Unique Link
• Log into your Pro Gineous Client Portal
• Navigate to "Refer a Friend" section
• Copy your unique referral link

Step 2: Share Your Link
• Share your link with friends, family, and colleagues
• Post on social media (following our guidelines)
• Include in blog posts or website content

Step 3: Friend Signs Up
• Your friend clicks your referral link
• They sign up for an eligible Pro Gineous service
• Their purchase is tracked automatically

Step 4: Earn Rewards
• Your friend gets $20 account credit (after 45 days)
• You earn commission based on the product purchased
• Commission becomes payable after 45-day review period

Step 5: Get Paid
• Request payout when you reach the minimum threshold
• Choose PayPal, Bank Transfer, or Account Credit
• Receive your earnings between the 1st-5th of each month

Tips for Success:
• Share with people who genuinely need hosting services
• Explain the benefits they'll receive as new customers
• Be transparent that you're sharing a referral link
• Focus on quality referrals, not quantity`,
        ar: `البدء مع برنامج "إحالة صديق" من برو جينيوس سهل:

الخطوة 1: احصل على رابطك الفريد
• سجل الدخول إلى لوحة تحكم العميل في برو جينيوس
• انتقل إلى قسم "إحالة صديق"
• انسخ رابط الإحالة الفريد الخاص بك

الخطوة 2: شارك رابطك
• شارك رابطك مع الأصدقاء والعائلة والزملاء
• انشر على وسائل التواصل الاجتماعي (باتباع إرشاداتنا)
• ضمّنه في منشورات المدونة أو محتوى الموقع

الخطوة 3: صديقك يسجل
• ينقر صديقك على رابط الإحالة الخاص بك
• يسجل في خدمة برو جينيوس مؤهلة
• يتم تتبع عملية الشراء تلقائياً

الخطوة 4: اكسب المكافآت
• يحصل صديقك على رصيد حساب 20 دولار (بعد 45 يوماً)
• تكسب عمولة بناءً على المنتج المُشترى
• تصبح العمولة قابلة للدفع بعد فترة المراجعة البالغة 45 يوماً

الخطوة 5: احصل على أموالك
• اطلب الدفع عندما تصل إلى الحد الأدنى
• اختر PayPal أو التحويل البنكي أو رصيد الحساب
• استلم أرباحك بين الأول والخامس من كل شهر

نصائح للنجاح:
• شارك مع أشخاص يحتاجون حقاً إلى خدمات الاستضافة
• اشرح الفوائد التي سيحصلون عليها كعملاء جدد
• كن شفافاً بأنك تشارك رابط إحالة
• ركز على جودة الإحالات، وليس الكمية`
      }
    },
    {
      id: 'other',
      title: { en: 'Other Terms', ar: 'شروط أخرى' },
      icon: FileText,
      content: {
        en: `General Terms:
For those matters not specified herein, the Pro Gineous General Terms and Conditions apply.

Related Policies:
This Refer-a-Friend Policy should be read in conjunction with:
• Terms of Service
• Privacy Policy
• Acceptable Use Policy
• Affiliate Policy (for those interested in our full affiliate program)

Governing Law:
This agreement shall be governed by and interpreted in accordance with the laws of the Arab Republic of Egypt.

Dispute Resolution:
Any disputes arising from this program shall be resolved through our standard support channels. If a resolution cannot be reached, disputes shall be handled according to our Terms of Service.

Severability:
If any provision of these Terms is held to be invalid or unenforceable, that provision shall be eliminated or limited to the minimum extent necessary, and the remainder shall have full force and effect.

Contact:
For questions about the Refer-a-Friend program, contact us at:
• Email: referrals@progineous.com
• Support Portal: https://app.progineous.com/submitticket.php

Last Updated: January 1, 2025`,
        ar: `الشروط العامة:
للمسائل غير المحددة هنا، تنطبق الشروط والأحكام العامة لبرو جينيوس.

السياسات ذات الصلة:
يجب قراءة سياسة "إحالة صديق" هذه بالتزامن مع:
• شروط الخدمة
• سياسة الخصوصية
• سياسة الاستخدام المقبول
• سياسة الأفلييت (للمهتمين ببرنامج الأفلييت الكامل)

القانون الحاكم:
تخضع هذه الاتفاقية وتُفسر وفقاً لقوانين جمهورية مصر العربية.

حل النزاعات:
يتم حل أي نزاعات ناشئة عن هذا البرنامج من خلال قنوات الدعم القياسية لدينا. إذا تعذر الوصول إلى حل، يتم التعامل مع النزاعات وفقاً لشروط الخدمة الخاصة بنا.

قابلية الفصل:
إذا تم اعتبار أي حكم من هذه الشروط غير صالح أو غير قابل للتنفيذ، فسيتم حذف هذا الحكم أو تقييده إلى الحد الأدنى الضروري، وسيظل الباقي ساري المفعول والتأثير الكامل.

اتصل بنا:
للأسئلة حول برنامج "إحالة صديق"، تواصل معنا على:
• البريد الإلكتروني: referrals@progineous.com
• بوابة الدعم: https://app.progineous.com/submitticket.php

آخر تحديث: 1 يناير 2025`
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
    { title: { en: 'Affiliate Policy', ar: 'سياسة الأفلييت' }, href: `/${locale}/affiliate` }
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
            name: isRTL ? 'برنامج إحالة صديق - بروجينيوس' : 'Refer a Friend Program - Pro Gineous',
            description: isRTL
              ? 'اربح مكافآت عندما يسجل أصدقاؤك في بروجينيوس'
              : 'Earn rewards when your friends sign up for Pro Gineous',
            url: `https://progineous.com/${locale}/refer-friend`,
            mainEntity: {
              '@type': 'Service',
              name: isRTL ? 'برنامج إحالة صديق' : 'Refer a Friend Program',
              provider: {
                '@type': 'Organization',
                name: 'Pro Gineous',
              },
              offers: [
                {
                  '@type': 'Offer',
                  name: isRTL ? 'مكافأة المُحيل' : 'Referrer Reward',
                  description: isRTL ? 'عمولات تصل إلى 100 دولار' : 'Commissions up to $100',
                  priceCurrency: 'USD',
                },
                {
                  '@type': 'Offer',
                  name: isRTL ? 'مكافأة الصديق' : 'Friend Reward',
                  description: isRTL ? 'رصيد 20 دولار مجاناً' : '$20 credit free',
                  price: '20',
                  priceCurrency: 'USD',
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
              { '@type': 'ListItem', position: 2, name: isRTL ? 'إحالة صديق' : 'Refer a Friend', item: `https://progineous.com/${locale}/refer-friend` },
            ],
          }),
        }}
      />

      {/* Header */}
      <div className="relative z-30 bg-linear-to-r from-orange-500 via-amber-500 to-yellow-500 text-white">
        <div className="absolute inset-0 bg-[url('/patterns/circuit.svg')] opacity-10"></div>
        <div className="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-24">
          <div className="text-center">
            <div className="inline-flex items-center justify-center w-20 h-20 bg-white/10 backdrop-blur-sm rounded-2xl mb-6">
              <Gift className="w-10 h-10 text-white" />
            </div>
            <h1 className="text-4xl lg:text-5xl font-bold mb-4">
              {isRTL ? 'سياسة إحالة صديق' : 'Refer a Friend Policy'}
            </h1>
            <p className="text-lg text-orange-100 max-w-2xl mx-auto">
              {isRTL
                ? 'اكسب مكافآت عندما يسجل أصدقاؤك في خدمات برو جينيوس'
                : 'Earn rewards when your friends sign up for Pro Gineous services'}
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
                              ? 'bg-orange-50 text-orange-700 font-medium'
                              : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'
                          }`}
                        >
                          <span className={`flex items-center justify-center w-6 h-6 rounded-md text-xs font-medium ${
                            activeSection === section.id
                              ? 'bg-orange-500 text-white'
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
                        className="flex items-center gap-2 px-3 py-2 text-sm text-gray-600 hover:text-orange-600 hover:bg-orange-50 rounded-lg transition-colors"
                      >
                        <ChevronRight className={`w-4 h-4 ${isRTL ? 'rotate-180' : ''}`} />
                        {link.title[locale] || link.title.en}
                      </Link>
                    </li>
                  ))}
                </ul>
              </div>

              {/* Refer CTA */}
              <div className="mt-6 bg-linear-to-br from-orange-500 to-amber-500 rounded-xl shadow-sm p-6 text-white">
                <div className="flex items-center gap-3 mb-3">
                  <Heart className="w-8 h-8" />
                  <h3 className="font-semibold">
                    {isRTL ? 'ابدأ الإحالة' : 'Start Referring'}
                  </h3>
                </div>
                <p className="text-sm text-orange-100 mb-4">
                  {isRTL
                    ? 'شارك الحب واكسب مكافآت مع كل صديق يسجل'
                    : 'Share the love and earn rewards with every friend who signs up'}
                </p>
                <Link
                  href="https://app.progineous.com/index.php?m=refer_a_friend"
                  target="_blank"
                  className="block w-full py-2 px-4 bg-white text-orange-600 font-medium rounded-lg text-center hover:bg-orange-50 transition-colors"
                >
                  {isRTL ? 'احصل على رابطك' : 'Get Your Link'}
                </Link>
              </div>
            </div>
          </div>

          {/* Content */}
          <div className="flex-1 min-w-0">
            {/* Rewards Banner */}
            <div className="bg-linear-to-r from-orange-500 to-amber-500 rounded-xl p-6 mb-8 text-white">
              <div className="flex flex-col md:flex-row items-center justify-between gap-4">
                <div className="flex items-center gap-4">
                  <div className="w-16 h-16 bg-white/20 rounded-xl flex items-center justify-center">
                    <Users className="w-8 h-8" />
                  </div>
                  <div>
                    <h3 className="text-xl font-bold">
                      {isRTL ? 'أنت وصديقك تحصلان على مكافآت!' : 'You & Your Friend Both Get Rewarded!'}
                    </h3>
                    <p className="text-orange-100">
                      {isRTL ? 'أنت تكسب عمولة، صديقك يحصل على 20$ رصيد' : 'You earn commission, your friend gets $20 credit'}
                    </p>
                  </div>
                </div>
                <div className="flex items-center gap-4">
                  <div className="text-center px-4">
                    <div className="text-3xl font-bold">$20-$80</div>
                    <div className="text-sm text-orange-100">{isRTL ? 'لك' : 'For You'}</div>
                  </div>
                  <div className="text-2xl">+</div>
                  <div className="text-center px-4">
                    <div className="text-3xl font-bold">$20</div>
                    <div className="text-sm text-orange-100">{isRTL ? 'لصديقك' : 'For Friend'}</div>
                  </div>
                </div>
              </div>
            </div>

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
                      <div className="flex items-center justify-center w-10 h-10 bg-orange-100 text-orange-600 rounded-lg shrink-0">
                        <Icon className="w-5 h-5" />
                      </div>
                      <div>
                        <div className="flex items-center gap-2 mb-1">
                          <span className="text-xs font-medium text-orange-600 bg-orange-50 px-2 py-0.5 rounded">
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
