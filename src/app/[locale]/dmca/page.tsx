'use client';

import { useState, useEffect } from 'react';
import { useLocale } from 'next-intl';
import Link from 'next/link';
import { ArrowLeft, ChevronRight, Menu, X, Copyright, FileText, Shield, Mail, AlertCircle, Scale, Clock, UserX, RefreshCw, Gavel, HelpCircle, Send } from 'lucide-react';
import { cn } from '@/lib/utils';
import { RTLText } from '@/components/ui/RTLText';

export default function DMCAPage() {
  const locale = useLocale();
  const isRTL = locale === 'ar';
  const [activeSection, setActiveSection] = useState('intro');
  const [mobileMenuOpen, setMobileMenuOpen] = useState(false);

  const sections = [
    {
      id: 'intro',
      title: { en: 'Introduction', ar: 'مقدمة' },
      icon: Copyright,
      content: {
        en: `Digital Millennium Copyright Act (DMCA) Policy

Pro Gineous ("Pro Gineous", "we", "us", or "our") respects the intellectual property rights of others and expects our users to do the same. In accordance with the Digital Millennium Copyright Act of 1998 ("DMCA"), we will respond expeditiously to claims of copyright infringement committed using our services.

This policy outlines our procedures for:
• Receiving and processing DMCA takedown notices
• Handling counter-notifications
• Addressing repeat infringers

We are committed to complying with all applicable copyright laws and regulations while providing a fair process for all parties involved.

Important: This policy applies to content hosted on Pro Gineous servers. We are a service provider and do not monitor or control the content uploaded by our customers.`,
        ar: `سياسة قانون الألفية الرقمية لحقوق النشر (DMCA)

تحترم برو جينيوس ("برو جينيوس"، "نحن"، "لنا"، أو "الخاصة بنا") حقوق الملكية الفكرية للآخرين وتتوقع من مستخدمينا القيام بالمثل. وفقًا لقانون الألفية الرقمية لحقوق النشر لعام 1998 ("DMCA")، سنستجيب بسرعة لمطالبات انتهاك حقوق النشر المرتكبة باستخدام خدماتنا.

توضح هذه السياسة إجراءاتنا الخاصة بـ:
• استلام ومعالجة إشعارات الإزالة بموجب DMCA
• التعامل مع الإشعارات المضادة
• معالجة المخالفين المتكررين

نحن ملتزمون بالامتثال لجميع قوانين ولوائح حقوق النشر المعمول بها مع توفير عملية عادلة لجميع الأطراف المعنية.

هام: تنطبق هذه السياسة على المحتوى المستضاف على خوادم برو جينيوس. نحن مزود خدمة ولا نراقب أو نتحكم في المحتوى الذي يقوم عملاؤنا بتحميله.`
      }
    },
    {
      id: 'designated-agent',
      title: { en: 'Designated Agent', ar: 'الوكيل المعين' },
      icon: UserX,
      content: {
        en: `DMCA Designated Agent

In accordance with the DMCA, we have designated an agent to receive notifications of claimed copyright infringement:

Designated Agent Information:

Pro Gineous - DMCA Agent
9 Mustafa Kamel Street
Balwalidain Ihsanah Tower
Beni Suef, Egypt

Email: dmca@progineous.com
Phone: Available upon request

Online Form: https://app.progineous.com/submitticket.php
(Select "DMCA/Copyright" as the department)

Please send all DMCA-related communications to the designated agent. Communications sent to other addresses may not receive a timely response.

Agent Responsibilities:
• Receive and review DMCA takedown notices
• Process counter-notifications
• Coordinate with legal counsel as needed
• Maintain records of all DMCA communications
• Ensure compliance with DMCA procedures`,
        ar: `الوكيل المعين لـ DMCA

وفقًا لـ DMCA، قمنا بتعيين وكيل لاستلام إشعارات انتهاك حقوق النشر المزعومة:

معلومات الوكيل المعين:

برو جينيوس - وكيل DMCA
9 شارع مصطفى كامل
برج بالوالدين إحسانًا
بني سويف، مصر

البريد الإلكتروني: dmca@progineous.com
الهاتف: متاح عند الطلب

النموذج الإلكتروني: https://app.progineous.com/submitticket.php
(اختر "DMCA/حقوق النشر" كقسم)

يرجى إرسال جميع الاتصالات المتعلقة بـ DMCA إلى الوكيل المعين. قد لا تتلقى الاتصالات المرسلة إلى عناوين أخرى ردًا في الوقت المناسب.

مسؤوليات الوكيل:
• استلام ومراجعة إشعارات الإزالة بموجب DMCA
• معالجة الإشعارات المضادة
• التنسيق مع المستشار القانوني حسب الحاجة
• الاحتفاظ بسجلات جميع اتصالات DMCA
• ضمان الامتثال لإجراءات DMCA`
      }
    },
    {
      id: 'filing-notice',
      title: { en: 'Filing a DMCA Notice', ar: 'تقديم إشعار DMCA' },
      icon: Send,
      content: {
        en: `How to File a DMCA Takedown Notice

If you believe that content hosted on our servers infringes your copyright, you may submit a DMCA takedown notice. To be effective, your notice must be in writing and include the following:

Required Elements (17 U.S.C. § 512(c)(3)):

1. Physical or Electronic Signature
A physical or electronic signature of the copyright owner or a person authorized to act on their behalf.

2. Identification of Copyrighted Work
Identification of the copyrighted work claimed to have been infringed. If multiple works are involved, provide a representative list.

3. Identification of Infringing Material
Identification of the material claimed to be infringing, including:
• The specific URL(s) where the material is located
• Enough information for us to locate the material
• Screenshots or other evidence (if helpful)

4. Contact Information
Your contact information, including:
• Full legal name
• Mailing address
• Telephone number
• Email address

5. Good Faith Statement
A statement that you have a good faith belief that use of the material is not authorized by the copyright owner, its agent, or the law.

6. Accuracy Statement
A statement, made under penalty of perjury, that the information in the notification is accurate and that you are the copyright owner or authorized to act on behalf of the owner.

Submit your notice to: dmca@progineous.com`,
        ar: `كيفية تقديم إشعار إزالة DMCA

إذا كنت تعتقد أن المحتوى المستضاف على خوادمنا ينتهك حقوق النشر الخاصة بك، يمكنك تقديم إشعار إزالة DMCA. ليكون فعالاً، يجب أن يكون إشعارك كتابيًا ويتضمن ما يلي:

العناصر المطلوبة (17 U.S.C. § 512(c)(3)):

1. التوقيع المادي أو الإلكتروني
توقيع مادي أو إلكتروني لمالك حقوق النشر أو شخص مفوض بالتصرف نيابة عنه.

2. تحديد العمل المحمي بحقوق النشر
تحديد العمل المحمي بحقوق النشر المدعى انتهاكه. إذا كانت هناك أعمال متعددة، قدم قائمة تمثيلية.

3. تحديد المادة المخالفة
تحديد المادة المدعى أنها مخالفة، بما في ذلك:
• عناوين URL المحددة حيث توجد المادة
• معلومات كافية لنا لتحديد موقع المادة
• لقطات شاشة أو أدلة أخرى (إذا كانت مفيدة)

4. معلومات الاتصال
معلومات الاتصال الخاصة بك، بما في ذلك:
• الاسم القانوني الكامل
• العنوان البريدي
• رقم الهاتف
• عنوان البريد الإلكتروني

5. بيان حسن النية
بيان بأن لديك اعتقادًا حسن النية بأن استخدام المادة غير مصرح به من قبل مالك حقوق النشر أو وكيله أو القانون.

6. بيان الدقة
بيان، تحت طائلة عقوبة الحنث باليمين، بأن المعلومات الواردة في الإشعار دقيقة وأنك مالك حقوق النشر أو مفوض بالتصرف نيابة عن المالك.

أرسل إشعارك إلى: dmca@progineous.com`
      }
    },
    {
      id: 'notice-processing',
      title: { en: 'Notice Processing', ar: 'معالجة الإشعار' },
      icon: Clock,
      content: {
        en: `How We Process DMCA Notices

Upon receiving a valid DMCA takedown notice, we will take the following steps:

1. Review (Within 24-48 hours)
• Verify that the notice contains all required elements
• Confirm the material is hosted on our servers
• Assess the validity of the claim

2. If Notice is Valid:
• Remove or disable access to the allegedly infringing material
• Notify the account holder of the takedown
• Provide the account holder with a copy of the notice
• Inform them of their right to file a counter-notification

3. If Notice is Incomplete:
• Contact the complainant requesting additional information
• Hold processing until required information is received
• Notice will not be acted upon until complete

4. Documentation:
• Maintain records of all notices received
• Record actions taken in response
• Preserve evidence for potential legal proceedings

Response Timeline:
• Acknowledgment: Within 24 hours
• Initial review: Within 48 hours
• Action (if valid): Within 72 hours
• Notification to user: Immediately after action

We aim to process all DMCA notices as quickly as possible while ensuring due process for all parties.`,
        ar: `كيف نعالج إشعارات DMCA

عند استلام إشعار إزالة DMCA صالح، سنتخذ الخطوات التالية:

1. المراجعة (خلال 24-48 ساعة)
• التحقق من أن الإشعار يحتوي على جميع العناصر المطلوبة
• تأكيد أن المادة مستضافة على خوادمنا
• تقييم صحة المطالبة

2. إذا كان الإشعار صالحًا:
• إزالة أو تعطيل الوصول إلى المادة المزعوم انتهاكها
• إخطار صاحب الحساب بالإزالة
• تزويد صاحب الحساب بنسخة من الإشعار
• إبلاغهم بحقهم في تقديم إشعار مضاد

3. إذا كان الإشعار غير مكتمل:
• الاتصال بمقدم الشكوى لطلب معلومات إضافية
• تعليق المعالجة حتى يتم استلام المعلومات المطلوبة
• لن يتم التصرف بناءً على الإشعار حتى يكتمل

4. التوثيق:
• الاحتفاظ بسجلات جميع الإشعارات المستلمة
• تسجيل الإجراءات المتخذة استجابة لذلك
• الحفاظ على الأدلة للإجراءات القانونية المحتملة

الجدول الزمني للاستجابة:
• الإقرار بالاستلام: خلال 24 ساعة
• المراجعة الأولية: خلال 48 ساعة
• الإجراء (إذا كان صالحًا): خلال 72 ساعة
• إخطار المستخدم: فورًا بعد الإجراء

نهدف إلى معالجة جميع إشعارات DMCA بأسرع ما يمكن مع ضمان الإجراءات القانونية الواجبة لجميع الأطراف.`
      }
    },
    {
      id: 'counter-notification',
      title: { en: 'Counter-Notification', ar: 'الإشعار المضاد' },
      icon: RefreshCw,
      content: {
        en: `Filing a Counter-Notification

If you believe your content was removed in error or that you have authorization to use the material, you may file a counter-notification.

Required Elements (17 U.S.C. § 512(g)(3)):

1. Physical or Electronic Signature
Your physical or electronic signature.

2. Identification of Removed Material
Identification of the material that was removed and the location where it appeared before removal.

3. Statement Under Penalty of Perjury
A statement under penalty of perjury that you have a good faith belief that the material was removed or disabled as a result of mistake or misidentification.

4. Consent to Jurisdiction
A statement that you consent to the jurisdiction of:
• Federal District Court for the judicial district in which your address is located (if in the United States)
• Or any judicial district in which Pro Gineous may be found (if outside the United States)

5. Consent to Service of Process
A statement that you will accept service of process from the person who provided the original notification or their agent.

6. Contact Information
Your name, address, and telephone number.

Submit to: dmca@progineous.com
Subject: DMCA Counter-Notification

Processing Counter-Notifications:
• Upon receipt, we will forward the counter-notification to the original complainant
• The complainant has 10-14 business days to file a court action
• If no action is filed, we will restore the material within 10-14 business days`,
        ar: `تقديم إشعار مضاد

إذا كنت تعتقد أن المحتوى الخاص بك تمت إزالته عن طريق الخطأ أو أن لديك تصريحًا لاستخدام المادة، يمكنك تقديم إشعار مضاد.

العناصر المطلوبة (17 U.S.C. § 512(g)(3)):

1. التوقيع المادي أو الإلكتروني
توقيعك المادي أو الإلكتروني.

2. تحديد المادة المزالة
تحديد المادة التي تمت إزالتها والموقع الذي ظهرت فيه قبل الإزالة.

3. بيان تحت طائلة عقوبة الحنث باليمين
بيان تحت طائلة عقوبة الحنث باليمين بأن لديك اعتقادًا حسن النية بأن المادة أُزيلت أو عُطلت نتيجة خطأ أو سوء تحديد.

4. الموافقة على الاختصاص القضائي
بيان بأنك توافق على اختصاص:
• المحكمة الفيدرالية للمنطقة القضائية التي يقع فيها عنوانك (إذا كنت في الولايات المتحدة)
• أو أي منطقة قضائية قد توجد فيها برو جينيوس (إذا كنت خارج الولايات المتحدة)

5. الموافقة على استلام الإجراءات القانونية
بيان بأنك ستقبل استلام الإجراءات القانونية من الشخص الذي قدم الإشعار الأصلي أو وكيله.

6. معلومات الاتصال
اسمك وعنوانك ورقم هاتفك.

أرسل إلى: dmca@progineous.com
الموضوع: إشعار مضاد DMCA

معالجة الإشعارات المضادة:
• عند الاستلام، سنرسل الإشعار المضاد إلى مقدم الشكوى الأصلي
• لدى مقدم الشكوى 10-14 يوم عمل لتقديم دعوى قضائية
• إذا لم يتم تقديم دعوى، سنستعيد المادة خلال 10-14 يوم عمل`
      }
    },
    {
      id: 'repeat-infringers',
      title: { en: 'Repeat Infringers', ar: 'المخالفين المتكررين' },
      icon: AlertCircle,
      content: {
        en: `Repeat Infringer Policy

In accordance with the DMCA, we maintain a policy to terminate accounts of repeat infringers in appropriate circumstances.

Definition of Repeat Infringer:
A user who has been the subject of more than two valid DMCA takedown notices within a 12-month period.

Our Process:

First Notice:
• Content removed
• Warning issued to account holder
• Educational information provided about copyright compliance

Second Notice:
• Content removed
• Final warning issued
• Account flagged for monitoring
• User required to acknowledge understanding of policy

Third Notice:
• Content removed
• Account suspension (temporary or permanent)
• Review of all content on the account
• Possible termination without refund

Factors Considered:
• Nature and severity of infringement
• Whether infringement was willful or negligent
• User's response to previous notices
• Whether user filed valid counter-notifications
• Overall account history

Appeals:
Users may appeal repeat infringer status by demonstrating:
• Previous notices were resolved via counter-notification
• Changes implemented to prevent future infringement
• Good faith efforts to comply with copyright law

We reserve the right to terminate any account at any time for copyright infringement, regardless of the number of prior notices.`,
        ar: `سياسة المخالفين المتكررين

وفقًا لـ DMCA، نحتفظ بسياسة لإنهاء حسابات المخالفين المتكررين في الظروف المناسبة.

تعريف المخالف المتكرر:
المستخدم الذي كان موضوعًا لأكثر من إشعارين صالحين لإزالة DMCA خلال فترة 12 شهرًا.

عمليتنا:

الإشعار الأول:
• إزالة المحتوى
• إصدار تحذير لصاحب الحساب
• توفير معلومات تعليمية حول الامتثال لحقوق النشر

الإشعار الثاني:
• إزالة المحتوى
• إصدار تحذير نهائي
• وضع علامة على الحساب للمراقبة
• مطالبة المستخدم بالإقرار بفهم السياسة

الإشعار الثالث:
• إزالة المحتوى
• تعليق الحساب (مؤقت أو دائم)
• مراجعة جميع المحتوى على الحساب
• إمكانية الإنهاء بدون استرداد

العوامل المأخوذة في الاعتبار:
• طبيعة وشدة الانتهاك
• ما إذا كان الانتهاك متعمدًا أو ناتجًا عن إهمال
• استجابة المستخدم للإشعارات السابقة
• ما إذا كان المستخدم قد قدم إشعارات مضادة صالحة
• تاريخ الحساب العام

الاستئناف:
يمكن للمستخدمين استئناف وضع المخالف المتكرر من خلال إثبات:
• تم حل الإشعارات السابقة عبر إشعار مضاد
• تم تنفيذ تغييرات لمنع الانتهاك في المستقبل
• جهود حسنة النية للامتثال لقانون حقوق النشر

نحتفظ بالحق في إنهاء أي حساب في أي وقت بسبب انتهاك حقوق النشر، بغض النظر عن عدد الإشعارات السابقة.`
      }
    },
    {
      id: 'misrepresentation',
      title: { en: 'Misrepresentation', ar: 'التحريف' },
      icon: Scale,
      content: {
        en: `Penalties for Misrepresentation

The DMCA provides for penalties against those who knowingly make material misrepresentations in a takedown notice or counter-notification.

For Complainants:

Under 17 U.S.C. § 512(f), any person who knowingly materially misrepresents:
• That material is infringing, or
• That material was removed by mistake or misidentification

May be liable for damages, including:
• Costs and attorneys' fees incurred by the alleged infringer
• Any other party injured by such misrepresentation
• Pro Gineous, for costs associated with processing the fraudulent claim

Examples of Misrepresentation:
• Claiming copyright in material you don't own
• Filing notices to harass competitors
• Claiming infringement when fair use clearly applies
• Misidentifying yourself or your authority to act

Our Response to Misrepresentation:
• We may refuse to process notices from parties who have previously filed fraudulent claims
• We may report fraudulent notices to appropriate authorities
• We reserve the right to seek damages for costs incurred

Good Faith Requirement:
Before submitting a DMCA notice, carefully consider:
• Do you own or control the copyright?
• Is the use potentially fair use?
• Is the notice accurate in all respects?

We encourage all parties to consult with legal counsel before filing DMCA notices or counter-notifications.`,
        ar: `عقوبات التحريف

ينص قانون DMCA على عقوبات ضد أولئك الذين يقومون عن علم بتحريفات جوهرية في إشعار الإزالة أو الإشعار المضاد.

لمقدمي الشكاوى:

بموجب 17 U.S.C. § 512(f)، أي شخص يحرف عن علم وبشكل جوهري:
• أن المادة منتهكة، أو
• أن المادة أُزيلت عن طريق الخطأ أو سوء التحديد

قد يكون مسؤولاً عن الأضرار، بما في ذلك:
• التكاليف وأتعاب المحاماة التي تكبدها المخالف المزعوم
• أي طرف آخر متضرر من هذا التحريف
• برو جينيوس، عن التكاليف المرتبطة بمعالجة المطالبة الاحتيالية

أمثلة على التحريف:
• الادعاء بحقوق نشر في مادة لا تملكها
• تقديم إشعارات لمضايقة المنافسين
• الادعاء بالانتهاك عندما ينطبق الاستخدام العادل بوضوح
• تحريف هويتك أو صلاحيتك للتصرف

ردنا على التحريف:
• قد نرفض معالجة الإشعارات من الأطراف التي قدمت سابقًا مطالبات احتيالية
• قد نبلغ عن الإشعارات الاحتيالية إلى السلطات المختصة
• نحتفظ بالحق في المطالبة بتعويضات عن التكاليف المتكبدة

متطلبات حسن النية:
قبل تقديم إشعار DMCA، فكر بعناية في:
• هل تملك أو تتحكم في حقوق النشر؟
• هل الاستخدام محتمل أن يكون استخدامًا عادلاً؟
• هل الإشعار دقيق من جميع النواحي؟

نشجع جميع الأطراف على استشارة مستشار قانوني قبل تقديم إشعارات DMCA أو الإشعارات المضادة.`
      }
    },
    {
      id: 'safe-harbor',
      title: { en: 'Safe Harbor', ar: 'الملاذ الآمن' },
      icon: Shield,
      content: {
        en: `Service Provider Safe Harbor

As a service provider, Pro Gineous qualifies for the safe harbor provisions of the DMCA under 17 U.S.C. § 512.

Our Qualifications:

We meet the requirements for safe harbor protection because we:

1. Storage Safe Harbor (§ 512(c)):
• Do not have actual knowledge of infringing material
• Are not aware of facts making infringement apparent
• Act expeditiously to remove content upon notification
• Do not receive financial benefit directly from infringement
• Have designated an agent to receive DMCA notices

2. Information Location Tools (§ 512(d)):
• Provide tools for users to locate content
• Respond promptly to takedown notices
• Do not have actual knowledge of infringement

3. Transitory Communications (§ 512(a)):
• Act as a conduit for data transmission
• Do not initiate, select, or modify content
• Do not retain copies longer than necessary

What This Means:
• We are not liable for the infringing activities of our users
• We will respond appropriately to valid DMCA notices
• We maintain policies to address repeat infringers
• We do not pre-screen user content for infringement

Limitations:
Safe harbor does not apply if we:
• Have actual knowledge of infringement and fail to act
• Receive direct financial benefit from infringement
• Fail to implement repeat infringer policy
• Fail to accommodate standard technical measures`,
        ar: `الملاذ الآمن لمزود الخدمة

كمزود خدمة، تتأهل برو جينيوس لأحكام الملاذ الآمن في DMCA بموجب 17 U.S.C. § 512.

مؤهلاتنا:

نستوفي متطلبات حماية الملاذ الآمن لأننا:

1. الملاذ الآمن للتخزين (§ 512(c)):
• ليس لدينا علم فعلي بالمادة المنتهكة
• لسنا على علم بالحقائق التي تجعل الانتهاك واضحًا
• نتصرف بسرعة لإزالة المحتوى عند الإخطار
• لا نحصل على فائدة مالية مباشرة من الانتهاك
• لدينا وكيل معين لاستلام إشعارات DMCA

2. أدوات تحديد موقع المعلومات (§ 512(d)):
• نوفر أدوات للمستخدمين لتحديد موقع المحتوى
• نستجيب بسرعة لإشعارات الإزالة
• ليس لدينا علم فعلي بالانتهاك

3. الاتصالات العابرة (§ 512(a)):
• نعمل كقناة لنقل البيانات
• لا نبدأ أو نختار أو نعدل المحتوى
• لا نحتفظ بالنسخ لفترة أطول من اللازم

ماذا يعني هذا:
• لسنا مسؤولين عن الأنشطة المنتهكة لمستخدمينا
• سنستجيب بشكل مناسب لإشعارات DMCA الصالحة
• نحتفظ بسياسات لمعالجة المخالفين المتكررين
• لا نفحص محتوى المستخدم مسبقًا للكشف عن الانتهاك

القيود:
لا ينطبق الملاذ الآمن إذا:
• كان لدينا علم فعلي بالانتهاك وفشلنا في التصرف
• حصلنا على فائدة مالية مباشرة من الانتهاك
• فشلنا في تنفيذ سياسة المخالفين المتكررين
• فشلنا في استيعاب التدابير التقنية القياسية`
      }
    },
    {
      id: 'fair-use',
      title: { en: 'Fair Use', ar: 'الاستخدام العادل' },
      icon: HelpCircle,
      content: {
        en: `Fair Use Considerations

Before filing a DMCA notice, copyright owners should consider whether the use of their material may be protected by fair use under 17 U.S.C. § 107.

What is Fair Use?
Fair use is a legal doctrine that allows limited use of copyrighted material without permission for purposes such as:
• Criticism and commentary
• News reporting
• Teaching and education
• Scholarship and research
• Parody and satire

Four Factors of Fair Use:
Courts consider these factors when determining fair use:

1. Purpose and Character of Use
• Is it commercial or nonprofit/educational?
• Is it transformative (adds new meaning or message)?

2. Nature of the Copyrighted Work
• Is the original work creative or factual?
• Was it published or unpublished?

3. Amount Used
• How much of the original was used?
• Was the "heart" of the work taken?

4. Effect on Market
• Does the use harm the market for the original?
• Does it serve as a substitute for the original?

Our Position:
• We cannot make fair use determinations
• We encourage complainants to consider fair use before filing
• Counter-notifications may cite fair use as grounds for restoration
• Disputes about fair use should be resolved in court

Resources:
• U.S. Copyright Office: copyright.gov
• Electronic Frontier Foundation: eff.org
• Stanford Copyright & Fair Use Center`,
        ar: `اعتبارات الاستخدام العادل

قبل تقديم إشعار DMCA، يجب على مالكي حقوق النشر النظر فيما إذا كان استخدام موادهم قد يكون محميًا بموجب الاستخدام العادل بموجب 17 U.S.C. § 107.

ما هو الاستخدام العادل؟
الاستخدام العادل هو مبدأ قانوني يسمح بالاستخدام المحدود للمواد المحمية بحقوق النشر دون إذن لأغراض مثل:
• النقد والتعليق
• الإبلاغ الإخباري
• التدريس والتعليم
• البحث العلمي والأكاديمي
• المحاكاة الساخرة والهجاء

العوامل الأربعة للاستخدام العادل:
تنظر المحاكم في هذه العوامل عند تحديد الاستخدام العادل:

1. غرض الاستخدام وطبيعته
• هل هو تجاري أو غير ربحي/تعليمي؟
• هل هو تحويلي (يضيف معنى أو رسالة جديدة)؟

2. طبيعة العمل المحمي بحقوق النشر
• هل العمل الأصلي إبداعي أم واقعي؟
• هل تم نشره أم لم يُنشر؟

3. المقدار المستخدم
• كم تم استخدامه من الأصل؟
• هل تم أخذ "جوهر" العمل؟

4. التأثير على السوق
• هل يضر الاستخدام بسوق الأصل؟
• هل يعمل كبديل للأصل؟

موقفنا:
• لا يمكننا إصدار تحديدات الاستخدام العادل
• نشجع مقدمي الشكاوى على النظر في الاستخدام العادل قبل التقديم
• قد تستشهد الإشعارات المضادة بالاستخدام العادل كأساس للاستعادة
• يجب حل النزاعات حول الاستخدام العادل في المحكمة

المصادر:
• مكتب حقوق النشر الأمريكي: copyright.gov
• مؤسسة الحدود الإلكترونية: eff.org
• مركز ستانفورد لحقوق النشر والاستخدام العادل`
      }
    },
    {
      id: 'international',
      title: { en: 'International Users', ar: 'المستخدمين الدوليين' },
      icon: Gavel,
      content: {
        en: `International Copyright Considerations

While this policy is based on the U.S. DMCA, we serve customers worldwide and recognize international copyright frameworks.

International Frameworks We Recognize:

European Union:
• EU Copyright Directive (2019/790)
• E-Commerce Directive (2000/31/EC)
• DSA (Digital Services Act)

United Kingdom:
• Copyright, Designs and Patents Act 1988
• Online Safety Act

WIPO Treaties:
• Berne Convention
• WIPO Copyright Treaty (WCT)
• WIPO Performances and Phonograms Treaty (WPPT)

For International Users:

Filing Notices:
• You may file notices under your local copyright law
• Include reference to applicable legal framework
• Provide evidence of copyright ownership in your jurisdiction

Our Process:
• We will review notices under both DMCA and applicable international law
• We may request additional documentation for international claims
• Response times may vary for international notices

Jurisdiction:
• Our servers and operations are subject to Egyptian and international law
• Legal disputes may be resolved according to our Terms of Service
• We cooperate with international law enforcement when required

Local Representation:
If you require assistance with copyright matters in your jurisdiction, we recommend consulting with a local attorney familiar with your country's copyright laws.`,
        ar: `اعتبارات حقوق النشر الدولية

بينما تستند هذه السياسة إلى قانون DMCA الأمريكي، نحن نخدم العملاء في جميع أنحاء العالم ونعترف بالأطر الدولية لحقوق النشر.

الأطر الدولية التي نعترف بها:

الاتحاد الأوروبي:
• توجيه حقوق النشر في الاتحاد الأوروبي (2019/790)
• توجيه التجارة الإلكترونية (2000/31/EC)
• قانون الخدمات الرقمية (DSA)

المملكة المتحدة:
• قانون حقوق النشر والتصاميم وبراءات الاختراع 1988
• قانون السلامة عبر الإنترنت

معاهدات WIPO:
• اتفاقية برن
• معاهدة الويبو بشأن حقوق النشر (WCT)
• معاهدة الويبو بشأن الأداء والتسجيلات الصوتية (WPPT)

للمستخدمين الدوليين:

تقديم الإشعارات:
• يمكنك تقديم إشعارات بموجب قانون حقوق النشر المحلي الخاص بك
• تضمين الإشارة إلى الإطار القانوني المعمول به
• تقديم دليل على ملكية حقوق النشر في منطقتك القضائية

عمليتنا:
• سنراجع الإشعارات بموجب كل من DMCA والقانون الدولي المعمول به
• قد نطلب وثائق إضافية للمطالبات الدولية
• قد تختلف أوقات الاستجابة للإشعارات الدولية

الاختصاص القضائي:
• خوادمنا وعملياتنا تخضع للقانون المصري والدولي
• قد يتم حل النزاعات القانونية وفقًا لشروط الخدمة الخاصة بنا
• نتعاون مع أجهزة إنفاذ القانون الدولية عند الطلب

التمثيل المحلي:
إذا كنت تحتاج إلى مساعدة في مسائل حقوق النشر في منطقتك القضائية، نوصي باستشارة محامٍ محلي على دراية بقوانين حقوق النشر في بلدك.`
      }
    },
    {
      id: 'contact',
      title: { en: 'Contact Us', ar: 'اتصل بنا' },
      icon: Mail,
      content: {
        en: `Contact Information

For all DMCA-related inquiries:

DMCA Agent:
Pro Gineous - DMCA/Copyright Team

Address:
9 Mustafa Kamel Street
Balwalidain Ihsanah Tower
Beni Suef, Egypt

Email Contacts:
• DMCA Notices: dmca@progineous.com
• General Copyright Questions: legal@progineous.com
• Counter-Notifications: dmca@progineous.com

Online Submission:
https://app.progineous.com/submitticket.php
Department: Legal/DMCA

Response Times:
• Acknowledgment: Within 24 hours
• Initial Review: Within 48 hours
• Action on Valid Notices: Within 72 hours

What to Include:
For fastest processing, include:
• Clear identification of copyrighted work
• Specific URLs of infringing content
• Your complete contact information
• All required DMCA elements
• Any supporting documentation

Company Information:
Commercial Register: 90088
Tax Registration: 755-552-334

Last Updated: January 1, 2025

This DMCA Policy is effective immediately and applies to all content hosted by Pro Gineous.`,
        ar: `معلومات الاتصال

لجميع الاستفسارات المتعلقة بـ DMCA:

وكيل DMCA:
برو جينيوس - فريق DMCA/حقوق النشر

العنوان:
9 شارع مصطفى كامل
برج بالوالدين إحسانًا
بني سويف، مصر

جهات الاتصال عبر البريد الإلكتروني:
• إشعارات DMCA: dmca@progineous.com
• أسئلة حقوق النشر العامة: legal@progineous.com
• الإشعارات المضادة: dmca@progineous.com

التقديم الإلكتروني:
https://app.progineous.com/submitticket.php
القسم: قانوني/DMCA

أوقات الاستجابة:
• الإقرار بالاستلام: خلال 24 ساعة
• المراجعة الأولية: خلال 48 ساعة
• الإجراء على الإشعارات الصالحة: خلال 72 ساعة

ما يجب تضمينه:
للمعالجة الأسرع، قم بتضمين:
• تحديد واضح للعمل المحمي بحقوق النشر
• عناوين URL محددة للمحتوى المنتهك
• معلومات الاتصال الكاملة الخاصة بك
• جميع عناصر DMCA المطلوبة
• أي وثائق داعمة

معلومات الشركة:
السجل التجاري: 90088
رقم التسجيل الضريبي: 755-552-334

آخر تحديث: 1 يناير 2025

سياسة DMCA هذه سارية المفعول فورًا وتنطبق على جميع المحتوى المستضاف بواسطة برو جينيوس.`
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
        '@id': `https://progineous.com/${locale}/dmca`,
        name: isRTL ? 'سياسة DMCA | بروجينيوس' : 'DMCA Policy | Pro Gineous',
        description: isRTL
          ? 'سياسة قانون الألفية الرقمية لحقوق النشر وكيفية الإبلاغ عن الانتهاكات'
          : 'Digital Millennium Copyright Act policy and how to report infringements',
        url: `https://progineous.com/${locale}/dmca`,
        inLanguage: isRTL ? 'ar' : 'en',
        isPartOf: {
          '@type': 'WebSite',
          name: 'Pro Gineous',
          url: 'https://progineous.com',
        },
        about: {
          '@type': 'Thing',
          name: isRTL ? 'حقوق النشر والملكية الفكرية' : 'Copyright and Intellectual Property',
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
            name: isRTL ? 'سياسة DMCA' : 'DMCA Policy',
            item: `https://progineous.com/${locale}/dmca`,
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
      <div className="bg-linear-to-br from-[#1d71b8] to-[#0d4a7a] text-white py-16">
        <div className="max-w-7xl mx-auto px-4 text-center">
          <div className="flex justify-center mb-6">
            <div className="p-4 bg-white/10 rounded-2xl backdrop-blur-sm">
              <Copyright className="w-12 h-12" />
            </div>
          </div>
          <h1 className="text-4xl md:text-5xl font-bold mb-4">
            {isRTL ? 'سياسة DMCA' : 'DMCA Policy'}
          </h1>
          <p className="text-lg text-white/80 max-w-2xl mx-auto">
            {isRTL 
              ? 'سياسة قانون الألفية الرقمية لحقوق النشر'
              : 'Digital Millennium Copyright Act Policy'
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
            {/* Quick Action Banner */}
            <div className="bg-blue-50 border border-blue-200 rounded-xl p-4 mb-8">
              <div className="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div className="flex items-start gap-3">
                  <Copyright className="w-6 h-6 text-[#1d71b8] shrink-0 mt-0.5" />
                  <div>
                    <h3 className="font-semibold text-blue-800">
                      {isRTL ? 'الإبلاغ عن انتهاك حقوق النشر' : 'Report Copyright Infringement'}
                    </h3>
                    <p className="text-sm text-blue-700 mt-1">
                      {isRTL 
                        ? 'أرسل إشعار DMCA إلى dmca@progineous.com'
                        : 'Send DMCA notices to dmca@progineous.com'
                      }
                    </p>
                  </div>
                </div>
                <a 
                  href="mailto:dmca@progineous.com"
                  className="inline-flex items-center gap-2 px-4 py-2 bg-[#1d71b8] text-white rounded-lg hover:bg-[#155a94] transition-colors text-sm font-medium shrink-0"
                >
                  <Send className="w-4 h-4" />
                  {isRTL ? 'إرسال إشعار' : 'Send Notice'}
                </a>
              </div>
            </div>

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
                          'bg-linear-to-br from-[#1d71b8] to-[#0d4a7a] text-white shadow-lg'
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
                  href={`/${locale}/privacy`}
                  className="flex items-center gap-3 p-4 rounded-xl border border-gray-200 hover:border-[#1d71b8] hover:bg-blue-50 transition-all group"
                >
                  <div className="p-2 bg-gray-100 rounded-lg group-hover:bg-[#1d71b8] group-hover:text-white transition-colors">
                    <Shield className="w-5 h-5" />
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
