'use client';

import { useState, useEffect } from 'react';
import { useLocale } from 'next-intl';
import Link from 'next/link';
import { ArrowLeft, ChevronRight, Menu, X, CreditCard, RefreshCw, Clock, AlertCircle, DollarSign, Receipt, ArrowUpDown, FileText, Shield, Mail, Percent, HelpCircle } from 'lucide-react';
import { cn } from '@/lib/utils';
import { RTLText } from '@/components/ui/RTLText';

export default function RefundPage() {
  const locale = useLocale();
  const isRTL = locale === 'ar';
  const [activeSection, setActiveSection] = useState('purpose');
  const [mobileMenuOpen, setMobileMenuOpen] = useState(false);

  const sections = [
    {
      id: 'purpose',
      title: { en: 'Purpose', ar: 'الغرض' },
      icon: FileText,
      content: {
        en: `This is Pro Gineous's ("Pro Gineous", "we", or "our") Refund & Billing Policy. This policy discusses the ways in which we charge customers for use of the Services and related questions about charges, refunds and billing disputes.

Capitalized terms used but not defined in this policy have the meaning given to them in our Terms of Service.

This policy applies to all hosting services, domain registrations, SSL certificates, and other products offered by Pro Gineous.`,
        ar: `هذه سياسة الاسترداد والفوترة الخاصة ببرو جينيوس ("برو جينيوس"، "نحن"، أو "الخاصة بنا"). تناقش هذه السياسة الطرق التي نفرض بها رسومًا على العملاء مقابل استخدام الخدمات والأسئلة ذات الصلة حول الرسوم والاسترداد ونزاعات الفوترة.

المصطلحات المكتوبة بأحرف كبيرة المستخدمة ولكن غير المعرّفة في هذه السياسة لها المعنى المحدد في شروط الخدمة الخاصة بنا.

تنطبق هذه السياسة على جميع خدمات الاستضافة وتسجيلات النطاقات وشهادات SSL والمنتجات الأخرى التي تقدمها برو جينيوس.`
      }
    },
    {
      id: 'auto-renewal',
      title: { en: 'Automatic Renewal', ar: 'التجديد التلقائي' },
      icon: RefreshCw,
      content: {
        en: `Package Renewal:
ALL HOSTING PLANS AND DOMAIN NAMES ARE SET TO AUTOMATICALLY RENEW ON THEIR RENEWAL DATE to prevent any disruption in the Services. Your renewal date will appear on the checkout screen when you initially purchase Services and on every invoice you receive.

You will be emailed an invoice for the renewal term at the email address in your account in advance of any renewal with the terms of the upcoming Renewal Term, including duration and price.

Domain Name Renewal:
Domain names are set to AUTOMATICALLY RENEW five (5) days before their respective due date to avoid any disruptions due to expiry. Some registries require renewal well before the expiry date.

Please note that all payment methods that allow automatic charges will be charged at the domain's due date per the invoice UNLESS YOU CANCEL MORE THAN five (5) days before the due date.

Failure to Renew:
• Accounts with invoices more than fourteen (14) days overdue will be suspended
• Suspended accounts require all overdue invoices to be paid before reactivation
• Accounts more than 14 days overdue are considered abandoned and subject to termination
• Termination includes removal of all associated data on our system`,
        ar: `تجديد الباقات:
جميع خطط الاستضافة وأسماء النطاقات مضبوطة على التجديد التلقائي في تاريخ التجديد لمنع أي انقطاع في الخدمات. سيظهر تاريخ التجديد الخاص بك على شاشة الدفع عند شراء الخدمات لأول مرة وعلى كل فاتورة تتلقاها.

ستتلقى فاتورة عبر البريد الإلكتروني لفترة التجديد على عنوان البريد الإلكتروني في حسابك قبل أي تجديد مع شروط فترة التجديد القادمة، بما في ذلك المدة والسعر.

تجديد أسماء النطاقات:
أسماء النطاقات مضبوطة على التجديد التلقائي قبل خمسة (5) أيام من تاريخ استحقاقها لتجنب أي انقطاعات بسبب انتهاء الصلاحية. تتطلب بعض السجلات التجديد قبل تاريخ انتهاء الصلاحية بوقت كافٍ.

يرجى ملاحظة أن جميع طرق الدفع التي تسمح بالرسوم التلقائية سيتم خصمها في تاريخ استحقاق النطاق حسب الفاتورة ما لم تلغِ قبل أكثر من خمسة (5) أيام من تاريخ الاستحقاق.

الفشل في التجديد:
• الحسابات التي لديها فواتير متأخرة أكثر من أربعة عشر (14) يومًا سيتم تعليقها
• تتطلب الحسابات المعلقة دفع جميع الفواتير المتأخرة قبل إعادة التفعيل
• الحسابات المتأخرة أكثر من 14 يومًا تُعتبر مهجورة وعرضة للإنهاء
• يشمل الإنهاء إزالة جميع البيانات المرتبطة على نظامنا`
      }
    },
    {
      id: 'payment-responsibility',
      title: { en: 'Payment Responsibility', ar: 'مسؤولية الدفع' },
      icon: CreditCard,
      content: {
        en: `Your Responsibilities:
You are responsible for all charges, costs, expenses and other fees (the "Fees") associated with your use of the Services once our Services are made available to you.

Invoice Generation:
• Your first invoice is generated at the time you purchase the Services
• Renewal invoices are generated fourteen (14) days prior to the Renewal Term
• Invoices are charged three (3) days before the renewal date to ensure continuity of service
• Invoices are available in the "My Invoices" section of your Client Portal

Payment Timeline:
• New Services, packages or domains that are ordered and unpaid after seven (7) days will be canceled
• If you fail to pay for services, we may assign unpaid balances to a collection agency
• You agree to reimburse Pro Gineous for all expenses incurred to recover sums due, including attorneys' fees

Price Adjustments:
• We occasionally make changes to our plans and pricing to remain competitive
• No price changes will be effective without your consent in the middle of a paid term
• Prices may change between Renewal Terms
• All price changes will be reflected in the emailed invoice sent to you`,
        ar: `مسؤولياتك:
أنت مسؤول عن جميع الرسوم والتكاليف والمصاريف والرسوم الأخرى ("الرسوم") المرتبطة باستخدامك للخدمات بمجرد إتاحة خدماتنا لك.

إنشاء الفواتير:
• يتم إنشاء فاتورتك الأولى في وقت شراء الخدمات
• يتم إنشاء فواتير التجديد قبل أربعة عشر (14) يومًا من فترة التجديد
• يتم خصم الفواتير قبل ثلاثة (3) أيام من تاريخ التجديد لضمان استمرارية الخدمة
• الفواتير متاحة في قسم "فواتيري" في لوحة تحكم العميل

الجدول الزمني للدفع:
• الخدمات أو الباقات أو النطاقات الجديدة التي يتم طلبها ولا يتم دفعها بعد سبعة (7) أيام سيتم إلغاؤها
• إذا فشلت في الدفع مقابل الخدمات، فقد نحيل الأرصدة غير المدفوعة إلى وكالة تحصيل
• توافق على تعويض برو جينيوس عن جميع النفقات المتكبدة لاسترداد المبالغ المستحقة، بما في ذلك أتعاب المحاماة

تعديلات الأسعار:
• نقوم أحيانًا بإجراء تغييرات على خططنا وأسعارنا لنبقى تنافسيين
• لن تكون أي تغييرات في الأسعار سارية المفعول دون موافقتك في منتصف فترة مدفوعة
• قد تتغير الأسعار بين فترات التجديد
• ستنعكس جميع تغييرات الأسعار في الفاتورة المرسلة إليك عبر البريد الإلكتروني`
      }
    },
    {
      id: 'refunds',
      title: { en: 'Refunds', ar: 'الاسترداد' },
      icon: DollarSign,
      content: {
        en: `General Refund Policy:
• Accounts terminated due to Terms of Service violations are NOT eligible for refunds
• Domain registrations are NOT refundable under any circumstances
• Setup fees and migration fees are NOT refundable
• Service credits have no cash value and expire after twenty-four (24) months

Money-Back Guarantee:
We offer a 30-day money-back guarantee on shared hosting plans for new customers:
• Request must be made within 30 days of initial purchase
• Only applies to hosting fees (not domains, SSL, or add-ons)
• Only available for first-time customers
• Must be requested through support ticket

Refund Processing:
• Credit card payments: Refunded to the card on file
• PayPal payments: Refunded to the PayPal account
• Other payment methods: Refunded through the same processor
• Bank transfer/check payments: Refunded via PayPal only
• Refund requests after 120 days will be issued via PayPal only

Important Notes:
• If your account information is not up to date, your refund may not be completed
• Pro Gineous is not responsible for fees deducted from refunds by payment processors
• All refunds are subject to third-party payment processor terms`,
        ar: `سياسة الاسترداد العامة:
• الحسابات المنتهية بسبب انتهاكات شروط الخدمة غير مؤهلة للاسترداد
• تسجيلات النطاقات غير قابلة للاسترداد تحت أي ظرف
• رسوم الإعداد ورسوم الترحيل غير قابلة للاسترداد
• رصيد الخدمة ليس له قيمة نقدية وينتهي بعد أربعة وعشرين (24) شهرًا

ضمان استرداد الأموال:
نقدم ضمان استرداد الأموال لمدة 30 يومًا على خطط الاستضافة المشتركة للعملاء الجدد:
• يجب تقديم الطلب خلال 30 يومًا من الشراء الأولي
• ينطبق فقط على رسوم الاستضافة (وليس النطاقات أو SSL أو الإضافات)
• متاح فقط للعملاء لأول مرة
• يجب طلبه من خلال تذكرة دعم

معالجة الاسترداد:
• مدفوعات بطاقات الائتمان: يتم استردادها إلى البطاقة المسجلة
• مدفوعات PayPal: يتم استردادها إلى حساب PayPal
• طرق الدفع الأخرى: يتم استردادها من خلال نفس المعالج
• مدفوعات التحويل البنكي/الشيكات: يتم استردادها عبر PayPal فقط
• طلبات الاسترداد بعد 120 يومًا سيتم إصدارها عبر PayPal فقط

ملاحظات مهمة:
• إذا لم تكن معلومات حسابك محدثة، فقد لا يتم إكمال استردادك
• برو جينيوس غير مسؤولة عن الرسوم المخصومة من المبالغ المستردة من قبل معالجات الدفع
• جميع المبالغ المستردة تخضع لشروط معالج الدفع التابع لجهة خارجية`
      }
    },
    {
      id: 'service-credits',
      title: { en: 'Service Credits', ar: 'رصيد الخدمة' },
      icon: Percent,
      content: {
        en: `Service Credit Eligibility:

Who Does NOT Qualify:
• Customers who are not current on their invoices at the time of claimed outage
• Customers who have not paid invoices on time more than three times in the preceding 12 months
• Outages caused by customer actions or security system triggers

Uptime Guarantee:
We guarantee 99.9% uptime for our hosting services. If we fail to meet this guarantee:
• Less than 99.9% but more than 99.0%: 10% service credit
• Less than 99.0% but more than 95.0%: 25% service credit
• Less than 95.0%: 50% service credit

How to Claim:
• Submit a support ticket within 7 days of the outage
• Include dates and times of the outage
• Provide any relevant error messages or screenshots

Credit Terms:
• Service credits are applied to your account balance
• Credits can only be used for future invoices
• Credits have no cash value
• Credits expire at account termination or after 24 months
• Credits are issued at our discretion`,
        ar: `أهلية رصيد الخدمة:

من لا يتأهل:
• العملاء الذين ليسوا على اطلاع بفواتيرهم في وقت الانقطاع المُدعى
• العملاء الذين لم يدفعوا الفواتير في الوقت المحدد أكثر من ثلاث مرات في الـ 12 شهرًا السابقة
• الانقطاعات الناتجة عن إجراءات العملاء أو محفزات نظام الأمان

ضمان وقت التشغيل:
نضمن 99.9٪ وقت تشغيل لخدمات الاستضافة لدينا. إذا فشلنا في تلبية هذا الضمان:
• أقل من 99.9٪ ولكن أكثر من 99.0٪: رصيد خدمة 10٪
• أقل من 99.0٪ ولكن أكثر من 95.0٪: رصيد خدمة 25٪
• أقل من 95.0٪: رصيد خدمة 50٪

كيفية المطالبة:
• إرسال تذكرة دعم خلال 7 أيام من الانقطاع
• تضمين تواريخ وأوقات الانقطاع
• تقديم أي رسائل خطأ أو لقطات شاشة ذات صلة

شروط الرصيد:
• يتم تطبيق رصيد الخدمة على رصيد حسابك
• يمكن استخدام الأرصدة فقط للفواتير المستقبلية
• الأرصدة ليس لها قيمة نقدية
• تنتهي الأرصدة عند إنهاء الحساب أو بعد 24 شهرًا
• يتم إصدار الأرصدة وفقًا لتقديرنا`
      }
    },
    {
      id: 'payment-methods',
      title: { en: 'Payment Methods', ar: 'طرق الدفع' },
      icon: Receipt,
      content: {
        en: `Accepted Payment Methods:

Credit/Debit Cards:
• Visa
• MasterCard
• American Express

Digital Wallets:
• PayPal
• Vodafone Cash
• Fawry

Bank Transfer:
• Available for annual plans and above
• See invoice for banking information
• Additional processing time may apply

Payment Currency:
• Primary currency: Egyptian Pound (EGP)
• USD payments accepted
• Prices displayed in other currencies are approximate
• Exchange rates may vary from your bank's rate

Important Notes:
• By providing payment information, you consent to automatic charges on invoice due dates
• Returned checks incur a fee of 100 EGP per instance
• We reserve the right to change accepted payment methods
• Some payment methods may not be available in all regions`,
        ar: `طرق الدفع المقبولة:

بطاقات الائتمان/الخصم:
• فيزا
• ماستركارد
• أمريكان إكسبريس

المحافظ الرقمية:
• PayPal
• فودافون كاش
• فوري

التحويل البنكي:
• متاح للخطط السنوية وما فوق
• انظر الفاتورة للحصول على معلومات البنك
• قد يتم تطبيق وقت معالجة إضافي

عملة الدفع:
• العملة الأساسية: الجنيه المصري (EGP)
• مدفوعات الدولار الأمريكي مقبولة
• الأسعار المعروضة بعملات أخرى تقريبية
• قد تختلف أسعار الصرف عن سعر البنك الخاص بك

ملاحظات مهمة:
• بتقديم معلومات الدفع، فإنك توافق على الرسوم التلقائية في تواريخ استحقاق الفواتير
• الشيكات المرتجعة تتحمل رسومًا قدرها 100 جنيه مصري لكل حالة
• نحتفظ بالحق في تغيير طرق الدفع المقبولة
• قد لا تتوفر بعض طرق الدفع في جميع المناطق`
      }
    },
    {
      id: 'upgrades-downgrades',
      title: { en: 'Upgrades & Downgrades', ar: 'الترقية والتخفيض' },
      icon: ArrowUpDown,
      content: {
        en: `Account Upgrades:

When upgrading to a higher-priced plan:
• We will migrate your account to the new Service at no charge
• Data center migration fee is waived during upgrade
• Upgrade is effective only after payment for the price difference
• Prorated credits applied for unused time on current plan

Standalone Migration:
• Moving to another data center without upgrading: $25 migration fee
• Contact sales before requesting to discuss options

Account Downgrades:

When downgrading to a lower-priced plan:
• The price difference will be placed as a service credit on your account
• Refunds are NOT issued for downgrades
• A $25 downgrade migration fee may apply
• Some features may be lost when downgrading

Migrations from Other Hosts:

Free Migration:
• Available for cPanel-to-cPanel migrations
• Requires providing cPanel credentials from previous host
• Subject to our migration team's availability

Paid Migration:
• Non-cPanel migrations may incur charges
• Fee determined by migration complexity
• We reserve the right to deny migration requests`,
        ar: `ترقيات الحساب:

عند الترقية إلى خطة أعلى سعرًا:
• سنقوم بترحيل حسابك إلى الخدمة الجديدة بدون رسوم
• يتم التنازل عن رسوم ترحيل مركز البيانات أثناء الترقية
• تكون الترقية فعالة فقط بعد دفع فرق السعر
• يتم تطبيق أرصدة نسبية للوقت غير المستخدم في الخطة الحالية

الترحيل المستقل:
• الانتقال إلى مركز بيانات آخر بدون ترقية: رسوم ترحيل 25 دولارًا
• اتصل بالمبيعات قبل الطلب لمناقشة الخيارات

تخفيضات الحساب:

عند التخفيض إلى خطة أقل سعرًا:
• سيتم وضع فرق السعر كرصيد خدمة في حسابك
• لا يتم إصدار مبالغ مستردة للتخفيضات
• قد يتم تطبيق رسوم تخفيض قدرها 25 دولارًا
• قد تُفقد بعض الميزات عند التخفيض

الترحيل من مضيفين آخرين:

الترحيل المجاني:
• متاح لترحيلات cPanel إلى cPanel
• يتطلب تقديم بيانات اعتماد cPanel من المضيف السابق
• يخضع لتوفر فريق الترحيل لدينا

الترحيل المدفوع:
• قد تتحمل عمليات الترحيل غير cPanel رسومًا
• يتم تحديد الرسوم حسب تعقيد الترحيل
• نحتفظ بالحق في رفض طلبات الترحيل`
      }
    },
    {
      id: 'billing-errors',
      title: { en: 'Billing Errors & Chargebacks', ar: 'أخطاء الفوترة ورد المبالغ' },
      icon: AlertCircle,
      content: {
        en: `Billing Errors:

If you discover an error on your invoice:
• Notify us as soon as possible via support ticket
• We will honor invoice errors if notified within ninety (90) days
• Errors reported after 90 days may be declined
• Approved corrections will be issued as service credits

How to Report:
• Submit a ticket to our Billing Department
• Include invoice number and description of error
• Provide any supporting documentation

Chargebacks:

Before initiating a chargeback, please contact us:
• Email: billing@progineous.com
• Support Portal: https://app.progineous.com/submitticket.php

Chargeback Consequences:
• A $50 investigation fee will be charged to your account
• All services will be immediately suspended pending investigation
• We may reject future payments from accounts with chargebacks
• Your account may be terminated upon receipt of a chargeback

We strongly encourage you to contact our billing team before disputing any charges with your bank or payment provider.`,
        ar: `أخطاء الفوترة:

إذا اكتشفت خطأ في فاتورتك:
• أخطرنا في أقرب وقت ممكن عبر تذكرة دعم
• سنعترف بأخطاء الفاتورة إذا تم إخطارنا خلال تسعين (90) يومًا
• الأخطاء المُبلغ عنها بعد 90 يومًا قد يتم رفضها
• سيتم إصدار التصحيحات المعتمدة كأرصدة خدمة

كيفية الإبلاغ:
• إرسال تذكرة إلى قسم الفوترة لدينا
• تضمين رقم الفاتورة ووصف الخطأ
• تقديم أي وثائق داعمة

رد المبالغ (Chargebacks):

قبل بدء رد المبالغ، يرجى الاتصال بنا:
• البريد الإلكتروني: billing@progineous.com
• بوابة الدعم: https://app.progineous.com/submitticket.php

عواقب رد المبالغ:
• سيتم خصم رسوم تحقيق قدرها 50 دولارًا من حسابك
• سيتم تعليق جميع الخدمات فورًا في انتظار التحقيق
• قد نرفض المدفوعات المستقبلية من الحسابات التي لديها رد مبالغ
• قد يتم إنهاء حسابك عند استلام رد المبالغ

نشجعك بشدة على الاتصال بفريق الفوترة لدينا قبل الطعن في أي رسوم مع البنك أو مزود الدفع الخاص بك.`
      }
    },
    {
      id: 'taxes',
      title: { en: 'Taxes', ar: 'الضرائب' },
      icon: Receipt,
      content: {
        en: `Tax Policy:

VAT (Value Added Tax):
• All prices displayed are exclusive of VAT unless otherwise stated
• Egyptian customers will be charged 14% VAT on all services
• VAT will be clearly shown on your invoice

Tax Exemptions:
• Registered businesses may apply for tax exemption
• Provide valid tax registration documents
• Exemption applies only after approval

International Customers:
• Customers outside Egypt may be exempt from Egyptian VAT
• You are responsible for any taxes applicable in your country
• We do not collect taxes on behalf of other jurisdictions

Tax Invoices:
• Official tax invoices are provided for all payments
• Invoices include our tax registration number
• Request duplicate invoices through support if needed

Company Tax Information:
Pro Gineous
Tax Registration Number: 755-552-334
Commercial Register: 90088`,
        ar: `سياسة الضرائب:

ضريبة القيمة المضافة (VAT):
• جميع الأسعار المعروضة لا تشمل ضريبة القيمة المضافة ما لم يُذكر خلاف ذلك
• سيتم فرض ضريبة قيمة مضافة بنسبة 14٪ على جميع الخدمات للعملاء المصريين
• ستظهر ضريبة القيمة المضافة بوضوح في فاتورتك

الإعفاءات الضريبية:
• يمكن للشركات المسجلة التقدم للإعفاء الضريبي
• تقديم وثائق التسجيل الضريبي الصالحة
• ينطبق الإعفاء فقط بعد الموافقة

العملاء الدوليين:
• قد يُعفى العملاء خارج مصر من ضريبة القيمة المضافة المصرية
• أنت مسؤول عن أي ضرائب مطبقة في بلدك
• نحن لا نجمع الضرائب نيابة عن الولايات القضائية الأخرى

الفواتير الضريبية:
• يتم توفير فواتير ضريبية رسمية لجميع المدفوعات
• تتضمن الفواتير رقم التسجيل الضريبي الخاص بنا
• اطلب فواتير مكررة من خلال الدعم إذا لزم الأمر

معلومات الشركة الضريبية:
برو جينيوس
رقم التسجيل الضريبي: 755-552-334
السجل التجاري: 90088`
      }
    },
    {
      id: 'cancellation',
      title: { en: 'Cancellation', ar: 'الإلغاء' },
      icon: Clock,
      content: {
        en: `How to Cancel:

To cancel your services:
1. Log into your Client Portal at https://app.progineous.com
2. Navigate to "My Services"
3. Select the service you wish to cancel
4. Click "Request Cancellation"
5. Select cancellation type and provide reason

Cancellation Types:
• Immediate: Service terminated immediately (no refund)
• End of Billing Period: Service continues until paid period ends

Important Notes:
• Cancellation requests cannot be processed via email
• Domain cancellations must be requested at least 5 days before renewal
• Some services may have minimum contract periods

What Happens After Cancellation:
• You will receive a confirmation email
• Data will be retained for 7 days after termination
• After 7 days, all data will be permanently deleted
• Backups will not be available after deletion

Reactivation:
• Canceled accounts can be reactivated within 7 days
• A reactivation fee may apply
• Data recovery is not guaranteed after 7 days`,
        ar: `كيفية الإلغاء:

لإلغاء خدماتك:
1. تسجيل الدخول إلى لوحة تحكم العميل على https://app.progineous.com
2. الانتقال إلى "خدماتي"
3. تحديد الخدمة التي ترغب في إلغائها
4. النقر على "طلب الإلغاء"
5. تحديد نوع الإلغاء وتقديم السبب

أنواع الإلغاء:
• فوري: يتم إنهاء الخدمة فورًا (بدون استرداد)
• نهاية فترة الفوترة: تستمر الخدمة حتى انتهاء الفترة المدفوعة

ملاحظات مهمة:
• لا يمكن معالجة طلبات الإلغاء عبر البريد الإلكتروني
• يجب طلب إلغاء النطاقات قبل 5 أيام على الأقل من التجديد
• قد يكون لبعض الخدمات فترات عقد دنيا

ماذا يحدث بعد الإلغاء:
• ستتلقى رسالة تأكيد بالبريد الإلكتروني
• سيتم الاحتفاظ بالبيانات لمدة 7 أيام بعد الإنهاء
• بعد 7 أيام، سيتم حذف جميع البيانات نهائيًا
• لن تكون النسخ الاحتياطية متاحة بعد الحذف

إعادة التفعيل:
• يمكن إعادة تفعيل الحسابات الملغاة خلال 7 أيام
• قد يتم تطبيق رسوم إعادة التفعيل
• استعادة البيانات غير مضمونة بعد 7 أيام`
      }
    },
    {
      id: 'contact',
      title: { en: 'Contact Billing', ar: 'اتصل بالفوترة' },
      icon: Mail,
      content: {
        en: `Billing Support:

For billing questions or concerns:

Pro Gineous - Billing Department

Address:
9 Mustafa Kamel Street
Balwalidain Ihsanah Tower
Beni Suef, Egypt

Email:
billing@progineous.com

Support Portal:
https://app.progineous.com/submitticket.php
(Select "Billing" as the department)

Response Times:
• Billing inquiries: Within 24 hours
• Refund requests: Within 48-72 hours
• Dispute resolution: Within 5 business days

Business Hours:
Sunday - Thursday: 9:00 AM - 6:00 PM (Egypt Time)
Friday - Saturday: Closed

Company Information:
Commercial Register: 90088
Tax Registration: 755-552-334

Last Updated: January 1, 2025`,
        ar: `دعم الفوترة:

للأسئلة أو المخاوف المتعلقة بالفوترة:

برو جينيوس - قسم الفوترة

العنوان:
9 شارع مصطفى كامل
برج بالوالدين إحسانًا
بني سويف، مصر

البريد الإلكتروني:
billing@progineous.com

بوابة الدعم:
https://app.progineous.com/submitticket.php
(اختر "الفوترة" كقسم)

أوقات الاستجابة:
• استفسارات الفوترة: خلال 24 ساعة
• طلبات الاسترداد: خلال 48-72 ساعة
• حل النزاعات: خلال 5 أيام عمل

ساعات العمل:
الأحد - الخميس: 9:00 صباحًا - 6:00 مساءً (توقيت مصر)
الجمعة - السبت: مغلق

معلومات الشركة:
السجل التجاري: 90088
رقم التسجيل الضريبي: 755-552-334

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
    { title: { en: 'Affiliate Policy', ar: 'سياسة الأفلييت' }, href: `/${locale}/affiliate` },
    { title: { en: 'Refer a Friend', ar: 'إحالة صديق' }, href: `/${locale}/refer-friend` }
  ];

  const jsonLd = {
    '@context': 'https://schema.org',
    '@graph': [
      {
        '@type': 'WebPage',
        '@id': `https://progineous.com/${locale}/refund`,
        name: isRTL ? 'سياسة الاسترداد والفوترة | بروجينيوس' : 'Refund & Billing Policy | Pro Gineous',
        description: isRTL
          ? 'ضمان استرداد الأموال خلال 30 يوماً وسياسة الفوترة في بروجينيوس'
          : '30-day money back guarantee and billing policy at Pro Gineous',
        url: `https://progineous.com/${locale}/refund`,
        inLanguage: isRTL ? 'ar' : 'en',
        isPartOf: {
          '@type': 'WebSite',
          name: 'Pro Gineous',
          url: 'https://progineous.com',
        },
        about: {
          '@type': 'Thing',
          name: isRTL ? 'سياسة الاسترداد والفوترة' : 'Refund and Billing Policy',
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
            name: isRTL ? 'سياسة الاسترداد' : 'Refund Policy',
            item: `https://progineous.com/${locale}/refund`,
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
    <div className={`min-h-screen bg-gray-50 ${isRTL ? 'rtl' : 'ltr'}`}>
      {/* JSON-LD Structured Data */}
      <script
        type="application/ld+json"
        dangerouslySetInnerHTML={{ __html: JSON.stringify(jsonLd) }}
      />
      {/* Header */}
      <div className="relative z-30 bg-linear-to-r from-blue-600 via-blue-700 to-blue-800 text-white">
        <div className="absolute inset-0 bg-[url('/patterns/circuit.svg')] opacity-10"></div>
        <div className="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-24">
          <div className="text-center">
            <div className="inline-flex items-center justify-center w-20 h-20 bg-white/10 backdrop-blur-sm rounded-2xl mb-6">
              <DollarSign className="w-10 h-10 text-white" />
            </div>
            <h1 className="text-4xl lg:text-5xl font-bold mb-4">
              {isRTL ? 'سياسة الاسترداد والفوترة' : 'Refund & Billing Policy'}
            </h1>
            <p className="text-lg text-blue-100 max-w-2xl mx-auto">
              {isRTL
                ? 'معلومات حول الرسوم والمدفوعات والاسترداد وفوترة الحساب'
                : 'Information about charges, payments, refunds, and account billing'}
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
                              ? 'bg-blue-50 text-blue-700 font-medium'
                              : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'
                          }`}
                        >
                          <span className={`flex items-center justify-center w-6 h-6 rounded-md text-xs font-medium ${
                            activeSection === section.id
                              ? 'bg-blue-600 text-white'
                              : 'bg-gray-100 text-gray-500'
                          }`}>
                            {index + 1}
                          </span>
                          <span className="truncate">{section.title[locale as 'en' | 'ar'] || section.title.en}</span>
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
                        className="flex items-center gap-2 px-3 py-2 text-sm text-gray-600 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"
                      >
                        <ChevronRight className={`w-4 h-4 ${isRTL ? 'rotate-180' : ''}`} />
                        {link.title[locale as 'en' | 'ar'] || link.title.en}
                      </Link>
                    </li>
                  ))}
                </ul>
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
                      <div className="flex items-center justify-center w-10 h-10 bg-blue-100 text-blue-600 rounded-lg shrink-0">
                        <Icon className="w-5 h-5" />
                      </div>
                      <div>
                        <div className="flex items-center gap-2 mb-1">
                          <span className="text-xs font-medium text-blue-600 bg-blue-50 px-2 py-0.5 rounded">
                            {isRTL ? `القسم ${index + 1}` : `Section ${index + 1}`}
                          </span>
                        </div>
                        <h2 className="text-xl lg:text-2xl font-bold text-gray-900">
                          {section.title[locale as 'en' | 'ar'] || section.title.en}
                        </h2>
                      </div>
                    </div>
                    <div className={`prose prose-gray max-w-none ${isRTL ? 'text-right' : ''}`}>
                      {(section.content[locale as 'en' | 'ar'] || section.content.en).split('\n\n').map((paragraph: string, pIndex: number) => (
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
