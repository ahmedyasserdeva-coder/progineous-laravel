'use client';

import { useState, useEffect } from 'react';
import { useLocale } from 'next-intl';
import Link from 'next/link';
import { ArrowLeft, ChevronRight, Menu, X, ShieldAlert, Ban, AlertTriangle, Server, Mail, Globe, Gavel, FileText, Shield, Users, Zap, Bug } from 'lucide-react';
import { cn } from '@/lib/utils';
import { RTLText } from '@/components/ui/RTLText';

export default function AUPPage() {
  const locale = useLocale();
  const isRTL = locale === 'ar';
  const [activeSection, setActiveSection] = useState('intro');
  const [mobileMenuOpen, setMobileMenuOpen] = useState(false);

  const sections = [
    {
      id: 'intro',
      title: { en: 'Introduction', ar: 'مقدمة' },
      icon: ShieldAlert,
      content: {
        en: `This Acceptable Use Policy ("AUP") governs the use of all services provided by Pro Gineous ("Pro Gineous", "we", "us", or "our"). This policy is designed to help protect Pro Gineous, our customers, and the Internet community from irresponsible or illegal activities.

By using our services, you agree to comply with this AUP. Violation of this policy may result in suspension or termination of your services without refund.

This AUP should be read in conjunction with our Terms of Service and Privacy Policy. We reserve the right to modify this policy at any time without prior notice.

Purpose:
• Ensure the security and reliability of our network and services
• Protect our customers and their data
• Maintain our reputation and the integrity of the Internet
• Comply with applicable laws and regulations`,
        ar: `تحكم سياسة الاستخدام المقبول هذه ("AUP") استخدام جميع الخدمات المقدمة من برو جينيوس ("برو جينيوس"، "نحن"، "لنا"، أو "الخاصة بنا"). تم تصميم هذه السياسة للمساعدة في حماية برو جينيوس وعملائنا ومجتمع الإنترنت من الأنشطة غير المسؤولة أو غير القانونية.

باستخدام خدماتنا، فإنك توافق على الامتثال لسياسة الاستخدام المقبول هذه. قد يؤدي انتهاك هذه السياسة إلى تعليق أو إنهاء خدماتك دون استرداد.

يجب قراءة سياسة الاستخدام المقبول هذه بالتزامن مع شروط الخدمة وسياسة الخصوصية الخاصة بنا. نحتفظ بالحق في تعديل هذه السياسة في أي وقت دون إشعار مسبق.

الغرض:
• ضمان أمان وموثوقية شبكتنا وخدماتنا
• حماية عملائنا وبياناتهم
• الحفاظ على سمعتنا ونزاهة الإنترنت
• الامتثال للقوانين واللوائح المعمول بها`
      }
    },
    {
      id: 'illegal-activities',
      title: { en: 'Illegal Activities', ar: 'الأنشطة غير القانونية' },
      icon: Ban,
      content: {
        en: `Prohibited Illegal Activities:

You may not use our services for any illegal purpose or in violation of any laws. This includes, but is not limited to:

Criminal Activity:
• Fraud, theft, or any form of financial crime
• Identity theft or impersonation
• Money laundering or terrorist financing
• Drug trafficking or illegal substance distribution
• Human trafficking or exploitation
• Gambling operations where prohibited by law

Intellectual Property Violations:
• Copyright infringement (piracy, unauthorized distribution)
• Trademark violations
• Patent infringement
• Distribution of counterfeit goods
• Circumvention of digital rights management (DRM)

Privacy Violations:
• Unauthorized collection of personal information
• Stalking, harassment, or cyberbullying
• Doxing (publishing private information)
• Unauthorized surveillance or monitoring

Child Exploitation:
• Child sexual abuse material (CSAM) - ZERO TOLERANCE
• Child grooming or exploitation
• Any content sexualizing minors

We will report any suspected illegal activity to the appropriate law enforcement authorities and cooperate fully with any investigations.`,
        ar: `الأنشطة غير القانونية المحظورة:

لا يجوز لك استخدام خدماتنا لأي غرض غير قانوني أو بما ينتهك أي قوانين. يشمل ذلك، على سبيل المثال لا الحصر:

النشاط الإجرامي:
• الاحتيال أو السرقة أو أي شكل من أشكال الجرائم المالية
• سرقة الهوية أو انتحال الشخصية
• غسيل الأموال أو تمويل الإرهاب
• الاتجار بالمخدرات أو توزيع المواد غير المشروعة
• الاتجار بالبشر أو الاستغلال
• عمليات المقامرة حيث يحظرها القانون

انتهاكات الملكية الفكرية:
• انتهاك حقوق النشر (القرصنة، التوزيع غير المصرح به)
• انتهاكات العلامات التجارية
• انتهاك براءات الاختراع
• توزيع البضائع المقلدة
• التحايل على إدارة الحقوق الرقمية (DRM)

انتهاكات الخصوصية:
• الجمع غير المصرح به للمعلومات الشخصية
• الملاحقة أو المضايقة أو التنمر الإلكتروني
• نشر المعلومات الخاصة (Doxing)
• المراقبة أو الرصد غير المصرح به

استغلال الأطفال:
• مواد الاعتداء الجنسي على الأطفال (CSAM) - عدم تسامح مطلق
• استدراج أو استغلال الأطفال
• أي محتوى يُجنس القاصرين

سنبلغ عن أي نشاط غير قانوني مشتبه به إلى سلطات إنفاذ القانون المختصة وسنتعاون بشكل كامل مع أي تحقيقات.`
      }
    },
    {
      id: 'harmful-content',
      title: { en: 'Harmful Content', ar: 'المحتوى الضار' },
      icon: AlertTriangle,
      content: {
        en: `Prohibited Harmful Content:

The following types of content are strictly prohibited on our services:

Malicious Content:
• Malware, viruses, trojans, worms, or any malicious code
• Phishing pages or deceptive content
• Exploit kits or hacking tools
• Botnets or command-and-control infrastructure
• Ransomware distribution or hosting

Hateful Content:
• Content promoting violence against individuals or groups
• Hate speech based on race, ethnicity, religion, gender, sexual orientation, disability, or national origin
• Terrorist propaganda or recruitment materials
• Extremist content promoting violence

Deceptive Content:
• Fake news designed to mislead
• Scam websites or fraudulent schemes
• Impersonation of legitimate businesses or individuals
• Misleading health claims or dangerous misinformation

Adult Content:
• Pornographic material (unless on designated adult hosting plans)
• Non-consensual intimate images
• Obscene content as defined by applicable law

Violent Content:
• Graphic violence or gore
• Content promoting self-harm or suicide
• Torture or extreme cruelty`,
        ar: `المحتوى الضار المحظور:

الأنواع التالية من المحتوى محظورة تمامًا على خدماتنا:

المحتوى الخبيث:
• البرمجيات الخبيثة أو الفيروسات أو أحصنة طروادة أو الديدان أو أي كود ضار
• صفحات التصيد الاحتيالي أو المحتوى المخادع
• أدوات الاستغلال أو أدوات القرصنة
• شبكات البوت أو البنية التحتية للتحكم والسيطرة
• توزيع أو استضافة برامج الفدية

المحتوى الكراهية:
• محتوى يروج للعنف ضد الأفراد أو المجموعات
• خطاب الكراهية على أساس العرق أو الإثنية أو الدين أو الجنس أو التوجه الجنسي أو الإعاقة أو الأصل القومي
• الدعاية الإرهابية أو مواد التجنيد
• المحتوى المتطرف الذي يروج للعنف

المحتوى المخادع:
• الأخبار المزيفة المصممة للتضليل
• مواقع الاحتيال أو المخططات الاحتيالية
• انتحال صفة الشركات أو الأفراد الشرعيين
• الادعاءات الصحية المضللة أو المعلومات الخاطئة الخطيرة

المحتوى للبالغين:
• المواد الإباحية (ما لم تكن على خطط استضافة البالغين المخصصة)
• الصور الحميمة غير التوافقية
• المحتوى الفاحش كما هو محدد بموجب القانون المعمول به

المحتوى العنيف:
• العنف الصريح أو المشاهد الدموية
• المحتوى الذي يروج لإيذاء النفس أو الانتحار
• التعذيب أو القسوة الشديدة`
      }
    },
    {
      id: 'network-abuse',
      title: { en: 'Network Abuse', ar: 'إساءة استخدام الشبكة' },
      icon: Server,
      content: {
        en: `Prohibited Network Activities:

The following network activities are strictly prohibited:

Denial of Service:
• DDoS attacks (launching or participating)
• DoS attacks against any target
• Flooding, packet manipulation, or protocol abuse
• Amplification attacks
• Using our network to attack others

Network Intrusion:
• Unauthorized access to systems or networks
• Port scanning or vulnerability scanning without permission
• Exploiting security vulnerabilities
• Bypassing authentication or security measures
• Network sniffing or traffic interception

Resource Abuse:
• Cryptocurrency mining without explicit permission
• Excessive bandwidth consumption affecting other users
• Running open proxies or relays
• Hosting Tor exit nodes without authorization
• Resource exhaustion attacks

IP Address Violations:
• IP address spoofing
• Unauthorized use of IP addresses
• Operating rogue DHCP or DNS servers
• BGP hijacking or route manipulation

Traffic Manipulation:
• Sending forged packets
• TCP/IP stack exploitation
• Protocol abuse or manipulation
• Traffic injection or interception`,
        ar: `أنشطة الشبكة المحظورة:

الأنشطة الشبكية التالية محظورة تمامًا:

هجمات رفض الخدمة:
• هجمات DDoS (إطلاقها أو المشاركة فيها)
• هجمات DoS ضد أي هدف
• الإغراق أو التلاعب بالحزم أو إساءة استخدام البروتوكول
• هجمات التضخيم
• استخدام شبكتنا لمهاجمة الآخرين

اختراق الشبكة:
• الوصول غير المصرح به إلى الأنظمة أو الشبكات
• فحص المنافذ أو فحص الثغرات بدون إذن
• استغلال الثغرات الأمنية
• تجاوز المصادقة أو التدابير الأمنية
• التنصت على الشبكة أو اعتراض حركة المرور

إساءة استخدام الموارد:
• تعدين العملات المشفرة بدون إذن صريح
• استهلاك النطاق الترددي المفرط الذي يؤثر على المستخدمين الآخرين
• تشغيل البروكسيات أو المرحلات المفتوحة
• استضافة عقد خروج Tor بدون تصريح
• هجمات استنفاد الموارد

انتهاكات عناوين IP:
• انتحال عناوين IP
• الاستخدام غير المصرح به لعناوين IP
• تشغيل خوادم DHCP أو DNS مارقة
• اختطاف BGP أو التلاعب بالمسار

التلاعب بحركة المرور:
• إرسال حزم مزورة
• استغلال مكدس TCP/IP
• إساءة استخدام البروتوكول أو التلاعب به
• حقن أو اعتراض حركة المرور`
      }
    },
    {
      id: 'email-abuse',
      title: { en: 'Email & Spam', ar: 'البريد الإلكتروني والرسائل غير المرغوبة' },
      icon: Mail,
      content: {
        en: `Email and Messaging Policies:

Spam and Unsolicited Messages:

You may NOT use our services to send:
• Unsolicited bulk email (spam)
• Unsolicited commercial email (UCE)
• Messages to purchased or harvested email lists
• Chain letters or pyramid schemes
• Phishing emails or social engineering attacks

Email Best Practices Required:
• Maintain proper opt-in/opt-out mechanisms
• Honor unsubscribe requests within 10 days
• Include valid physical address in commercial emails
• Use accurate sender information and subject lines
• Comply with CAN-SPAM, GDPR, and other applicable laws

Mailing List Requirements:
• Only send to confirmed opt-in subscribers
• Provide clear unsubscribe options
• Remove bounced addresses promptly
• Maintain list hygiene and remove inactive subscribers

Prohibited Email Activities:
• Operating open mail relays
• Forging email headers or sender information
• Using our servers to relay third-party spam
• Harvesting email addresses from websites
• Dictionary attacks on mail servers

Consequences:
• First offense: Warning and immediate cessation required
• Second offense: Service suspension
• Third offense: Account termination without refund

We maintain strict anti-spam measures and monitor outgoing email for compliance.`,
        ar: `سياسات البريد الإلكتروني والمراسلة:

الرسائل غير المرغوب فيها:

لا يجوز لك استخدام خدماتنا لإرسال:
• البريد الإلكتروني الجماعي غير المرغوب فيه (سبام)
• البريد الإلكتروني التجاري غير المرغوب فيه
• رسائل إلى قوائم بريد إلكتروني مشتراة أو محصودة
• رسائل متسلسلة أو مخططات هرمية
• رسائل التصيد الاحتيالي أو هجمات الهندسة الاجتماعية

أفضل ممارسات البريد الإلكتروني المطلوبة:
• الحفاظ على آليات الاشتراك/إلغاء الاشتراك المناسبة
• تلبية طلبات إلغاء الاشتراك خلال 10 أيام
• تضمين عنوان فعلي صالح في رسائل البريد الإلكتروني التجارية
• استخدام معلومات مرسل دقيقة وعناوين موضوع صحيحة
• الامتثال لـ CAN-SPAM و GDPR والقوانين الأخرى المعمول بها

متطلبات قوائم البريد:
• إرسال فقط إلى المشتركين المؤكدين
• توفير خيارات إلغاء اشتراك واضحة
• إزالة العناوين المرتدة على الفور
• الحفاظ على نظافة القائمة وإزالة المشتركين غير النشطين

أنشطة البريد الإلكتروني المحظورة:
• تشغيل مرحلات البريد المفتوحة
• تزوير رؤوس البريد الإلكتروني أو معلومات المرسل
• استخدام خوادمنا لترحيل رسائل سبام الطرف الثالث
• حصاد عناوين البريد الإلكتروني من المواقع
• هجمات القاموس على خوادم البريد

العواقب:
• المخالفة الأولى: تحذير ووقف فوري مطلوب
• المخالفة الثانية: تعليق الخدمة
• المخالفة الثالثة: إنهاء الحساب بدون استرداد

نحافظ على تدابير صارمة لمكافحة الرسائل غير المرغوبة ونراقب البريد الصادر للامتثال.`
      }
    },
    {
      id: 'security',
      title: { en: 'Security Requirements', ar: 'متطلبات الأمان' },
      icon: Shield,
      content: {
        en: `Customer Security Responsibilities:

You are responsible for maintaining the security of your account and hosted content:

Account Security:
• Use strong, unique passwords
• Enable two-factor authentication (2FA) where available
• Keep login credentials confidential
• Report suspected unauthorized access immediately
• Regularly review account activity

Application Security:
• Keep all software, CMS, and plugins updated
• Remove unused applications and plugins
• Use secure coding practices
• Implement proper input validation
• Protect against common vulnerabilities (SQL injection, XSS, etc.)

Data Security:
• Encrypt sensitive data at rest and in transit
• Implement proper access controls
• Regular backup of critical data
• Secure handling of customer PII
• Compliance with data protection regulations

Vulnerability Management:
• Promptly patch known vulnerabilities
• Respond to security advisories
• Address vulnerabilities within 48 hours of notification
• Cooperate with our security team

Incident Response:
• Report security incidents to our team immediately
• Preserve evidence and logs
• Cooperate with investigations
• Implement recommended remediation measures

Failure to maintain adequate security may result in service suspension until issues are resolved.`,
        ar: `مسؤوليات أمان العميل:

أنت مسؤول عن الحفاظ على أمان حسابك والمحتوى المستضاف:

أمان الحساب:
• استخدم كلمات مرور قوية وفريدة
• تمكين المصادقة الثنائية (2FA) حيثما كانت متاحة
• الحفاظ على سرية بيانات تسجيل الدخول
• الإبلاغ عن الوصول غير المصرح به المشتبه به فورًا
• مراجعة نشاط الحساب بانتظام

أمان التطبيق:
• تحديث جميع البرامج وأنظمة إدارة المحتوى والإضافات
• إزالة التطبيقات والإضافات غير المستخدمة
• استخدام ممارسات الترميز الآمنة
• تنفيذ التحقق المناسب من المدخلات
• الحماية من الثغرات الشائعة (حقن SQL، XSS، إلخ)

أمان البيانات:
• تشفير البيانات الحساسة في حالة السكون وأثناء النقل
• تنفيذ ضوابط الوصول المناسبة
• النسخ الاحتياطي المنتظم للبيانات الهامة
• التعامل الآمن مع معلومات العملاء الشخصية
• الامتثال للوائح حماية البيانات

إدارة الثغرات:
• تصحيح الثغرات المعروفة على الفور
• الاستجابة للتحذيرات الأمنية
• معالجة الثغرات خلال 48 ساعة من الإخطار
• التعاون مع فريق الأمان لدينا

الاستجابة للحوادث:
• الإبلاغ عن الحوادث الأمنية لفريقنا فورًا
• الحفاظ على الأدلة والسجلات
• التعاون مع التحقيقات
• تنفيذ تدابير المعالجة الموصى بها

قد يؤدي الفشل في الحفاظ على الأمان الكافي إلى تعليق الخدمة حتى يتم حل المشكلات.`
      }
    },
    {
      id: 'resource-usage',
      title: { en: 'Resource Usage', ar: 'استخدام الموارد' },
      icon: Zap,
      content: {
        en: `Fair Resource Usage Policy:

Our services operate on shared infrastructure where resources must be fairly distributed:

CPU Usage:
• Sustained high CPU usage affecting other users is prohibited
• Background processes must not monopolize CPU resources
• CPU-intensive tasks should be scheduled during off-peak hours
• Dedicated servers or VPS recommended for resource-heavy applications

Memory Usage:
• Applications must manage memory efficiently
• Memory leaks must be addressed promptly
• Excessive memory usage may result in process termination

Storage Usage:
• Use storage efficiently and remove unnecessary files
• Large media files should use appropriate CDN services
• Backup archives should not be stored on primary hosting
• Database optimization is required for large datasets

Bandwidth Usage:
• Bandwidth must be used for normal website operations
• File hosting or distribution services require appropriate plans
• Video streaming requires dedicated resources
• Excessive bandwidth may result in throttling or suspension

Concurrent Connections:
• Connection limits must be respected
• Implement proper connection pooling
• Long-running connections must be managed appropriately

Prohibited Resource Usage:
• Cryptocurrency mining
• Brute force attacks
• Resource exhaustion tests
• Proxy services without authorization
• File sharing or torrent operations`,
        ar: `سياسة الاستخدام العادل للموارد:

تعمل خدماتنا على بنية تحتية مشتركة حيث يجب توزيع الموارد بشكل عادل:

استخدام وحدة المعالجة المركزية:
• يُحظر الاستخدام العالي المستمر لوحدة المعالجة المركزية الذي يؤثر على المستخدمين الآخرين
• يجب ألا تحتكر العمليات الخلفية موارد وحدة المعالجة المركزية
• يجب جدولة المهام كثيفة الاستخدام لوحدة المعالجة المركزية خلال ساعات الذروة المنخفضة
• يُوصى بالخوادم المخصصة أو VPS للتطبيقات الثقيلة الموارد

استخدام الذاكرة:
• يجب أن تدير التطبيقات الذاكرة بكفاءة
• يجب معالجة تسريبات الذاكرة على الفور
• قد يؤدي الاستخدام المفرط للذاكرة إلى إنهاء العملية

استخدام التخزين:
• استخدم التخزين بكفاءة وأزل الملفات غير الضرورية
• يجب أن تستخدم ملفات الوسائط الكبيرة خدمات CDN المناسبة
• لا ينبغي تخزين أرشيفات النسخ الاحتياطي على الاستضافة الأساسية
• تحسين قاعدة البيانات مطلوب لمجموعات البيانات الكبيرة

استخدام النطاق الترددي:
• يجب استخدام النطاق الترددي لعمليات الموقع العادية
• تتطلب خدمات استضافة الملفات أو التوزيع خططًا مناسبة
• يتطلب بث الفيديو موارد مخصصة
• قد يؤدي النطاق الترددي المفرط إلى التقييد أو التعليق

الاتصالات المتزامنة:
• يجب احترام حدود الاتصال
• تنفيذ تجميع الاتصالات المناسب
• يجب إدارة الاتصالات طويلة التشغيل بشكل مناسب

استخدام الموارد المحظور:
• تعدين العملات المشفرة
• هجمات القوة الغاشمة
• اختبارات استنفاد الموارد
• خدمات البروكسي بدون تصريح
• مشاركة الملفات أو عمليات التورنت`
      }
    },
    {
      id: 'reseller',
      title: { en: 'Reseller Obligations', ar: 'التزامات الموزعين' },
      icon: Users,
      content: {
        en: `Reseller Account Responsibilities:

If you have a reseller account, you are responsible for your customers' compliance with this AUP:

Customer Management:
• Implement your own acceptable use policy that is at least as restrictive as this AUP
• Inform your customers of prohibited activities
• Monitor your customers for policy violations
• Respond promptly to abuse reports about your customers
• Maintain accurate contact information for your customers

Abuse Handling:
• You must respond to abuse complaints within 24 hours
• Take appropriate action against violating customers
• Report serious violations to Pro Gineous
• Maintain abuse handling procedures

Liability:
• You are liable for all activities of your customers
• Repeated violations by your customers may result in suspension of your reseller account
• You must indemnify Pro Gineous for damages caused by your customers

Support:
• You are responsible for providing first-level support to your customers
• Escalate technical issues appropriately
• Do not submit abuse complaints from your own customers to Pro Gineous directly

Disclosure:
• You may not represent yourself as Pro Gineous
• You must disclose that you are a reseller when required
• Marketing materials must accurately represent the services`,
        ar: `مسؤوليات حساب الموزع:

إذا كان لديك حساب موزع، فأنت مسؤول عن امتثال عملائك لسياسة الاستخدام المقبول هذه:

إدارة العملاء:
• تنفيذ سياسة الاستخدام المقبول الخاصة بك والتي تكون على الأقل مقيدة مثل سياسة الاستخدام المقبول هذه
• إبلاغ عملائك بالأنشطة المحظورة
• مراقبة عملائك لانتهاكات السياسة
• الاستجابة الفورية لتقارير الإساءة حول عملائك
• الحفاظ على معلومات اتصال دقيقة لعملائك

التعامل مع الإساءة:
• يجب الرد على شكاوى الإساءة خلال 24 ساعة
• اتخاذ الإجراء المناسب ضد العملاء المخالفين
• الإبلاغ عن الانتهاكات الخطيرة إلى برو جينيوس
• الحفاظ على إجراءات التعامل مع الإساءة

المسؤولية:
• أنت مسؤول عن جميع أنشطة عملائك
• قد تؤدي الانتهاكات المتكررة من قبل عملائك إلى تعليق حساب الموزع الخاص بك
• يجب عليك تعويض برو جينيوس عن الأضرار الناجمة عن عملائك

الدعم:
• أنت مسؤول عن تقديم دعم المستوى الأول لعملائك
• تصعيد المشكلات التقنية بشكل مناسب
• لا ترسل شكاوى الإساءة من عملائك إلى برو جينيوس مباشرة

الإفصاح:
• لا يجوز لك تمثيل نفسك على أنك برو جينيوس
• يجب الإفصاح عن أنك موزع عند الطلب
• يجب أن تمثل مواد التسويق الخدمات بدقة`
      }
    },
    {
      id: 'vulnerability',
      title: { en: 'Vulnerability Reporting', ar: 'الإبلاغ عن الثغرات' },
      icon: Bug,
      content: {
        en: `Security Vulnerability Disclosure:

We take security seriously and appreciate responsible disclosure of vulnerabilities:

Reporting Vulnerabilities:
If you discover a security vulnerability in our systems, please report it to:
• Email: security@progineous.com
• Include detailed information about the vulnerability
• Provide steps to reproduce the issue
• Include any proof-of-concept code (if applicable)

Responsible Disclosure Guidelines:
• Do not access or modify data belonging to others
• Do not perform actions that could harm service availability
• Do not publicly disclose the vulnerability before we address it
• Give us reasonable time (90 days) to fix the issue
• Do not use automated scanning tools without permission

What We Commit To:
• Acknowledge receipt of your report within 48 hours
• Provide regular updates on our progress
• Notify you when the vulnerability is fixed
• Credit you in our security acknowledgments (if desired)
• Not pursue legal action against good-faith reporters

Out of Scope:
• Social engineering attacks
• Physical security issues
• Denial of service attacks
• Spam or email issues
• Issues in third-party services

We do not currently offer a bug bounty program, but we deeply appreciate security researchers who help keep our services safe.`,
        ar: `الإفصاح عن الثغرات الأمنية:

نأخذ الأمان على محمل الجد ونقدر الإفصاح المسؤول عن الثغرات:

الإبلاغ عن الثغرات:
إذا اكتشفت ثغرة أمنية في أنظمتنا، يرجى الإبلاغ عنها إلى:
• البريد الإلكتروني: security@progineous.com
• تضمين معلومات مفصلة عن الثغرة
• تقديم خطوات لإعادة إنتاج المشكلة
• تضمين أي كود إثبات مفهوم (إن وجد)

إرشادات الإفصاح المسؤول:
• لا تصل إلى البيانات التابعة للآخرين أو تعدلها
• لا تقم بإجراءات قد تضر بتوفر الخدمة
• لا تفصح علنًا عن الثغرة قبل معالجتها
• امنحنا وقتًا معقولاً (90 يومًا) لإصلاح المشكلة
• لا تستخدم أدوات الفحص الآلي بدون إذن

ما نلتزم به:
• الإقرار باستلام تقريرك خلال 48 ساعة
• تقديم تحديثات منتظمة حول تقدمنا
• إخطارك عند إصلاح الثغرة
• نسب الفضل إليك في إقرارات الأمان الخاصة بنا (إذا رغبت)
• عدم اتخاذ إجراء قانوني ضد المُبلغين بحسن نية

خارج النطاق:
• هجمات الهندسة الاجتماعية
• مشكلات الأمان المادي
• هجمات رفض الخدمة
• مشكلات البريد الإلكتروني أو الرسائل غير المرغوبة
• مشكلات في خدمات الطرف الثالث

نحن لا نقدم حاليًا برنامج مكافآت الأخطاء، لكننا نقدر بشدة الباحثين الأمنيين الذين يساعدون في الحفاظ على أمان خدماتنا.`
      }
    },
    {
      id: 'enforcement',
      title: { en: 'Enforcement', ar: 'التنفيذ' },
      icon: Gavel,
      content: {
        en: `Policy Enforcement:

We take violations of this AUP seriously and will take appropriate action:

Investigation Process:
• We may investigate suspected violations
• We may suspend services during investigation
• We will attempt to contact you before taking action (except in emergencies)
• You must cooperate with investigations

Enforcement Actions:
Depending on the severity and nature of the violation:

Warning:
• First-time minor violations
• Unintentional policy breaches
• Issues that can be quickly resolved

Service Limitation:
• Restricting specific features
• Bandwidth or resource throttling
• Blocking specific protocols or ports

Service Suspension:
• Temporary suspension pending resolution
• Suspension until issue is remediated
• Suspension during investigation

Service Termination:
• Repeated violations after warnings
• Serious violations (illegal content, attacks)
• Refusal to cooperate with investigation
• Violations causing harm to others

Legal Action:
• Criminal activity reported to authorities
• Civil action for damages
• Cooperation with law enforcement

No Refunds:
Services terminated for AUP violations are not eligible for refunds.

Appeals:
You may appeal enforcement actions by contacting abuse@progineous.com within 14 days of the action.`,
        ar: `تنفيذ السياسة:

نأخذ انتهاكات سياسة الاستخدام المقبول هذه على محمل الجد وسنتخذ الإجراء المناسب:

عملية التحقيق:
• قد نحقق في الانتهاكات المشتبه بها
• قد نعلق الخدمات أثناء التحقيق
• سنحاول الاتصال بك قبل اتخاذ إجراء (باستثناء حالات الطوارئ)
• يجب عليك التعاون مع التحقيقات

إجراءات التنفيذ:
اعتمادًا على خطورة وطبيعة الانتهاك:

تحذير:
• الانتهاكات البسيطة لأول مرة
• الانتهاكات غير المقصودة للسياسة
• المشكلات التي يمكن حلها بسرعة

تقييد الخدمة:
• تقييد ميزات معينة
• تقييد النطاق الترددي أو الموارد
• حظر بروتوكولات أو منافذ معينة

تعليق الخدمة:
• تعليق مؤقت في انتظار الحل
• التعليق حتى يتم معالجة المشكلة
• التعليق أثناء التحقيق

إنهاء الخدمة:
• الانتهاكات المتكررة بعد التحذيرات
• الانتهاكات الخطيرة (محتوى غير قانوني، هجمات)
• رفض التعاون مع التحقيق
• الانتهاكات التي تسبب ضررًا للآخرين

الإجراء القانوني:
• الإبلاغ عن النشاط الإجرامي للسلطات
• دعوى مدنية للتعويضات
• التعاون مع جهات إنفاذ القانون

لا استرداد:
الخدمات المنتهية بسبب انتهاكات سياسة الاستخدام المقبول غير مؤهلة للاسترداد.

الاستئناف:
يمكنك استئناف إجراءات التنفيذ عن طريق الاتصال بـ abuse@progineous.com خلال 14 يومًا من الإجراء.`
      }
    },
    {
      id: 'reporting',
      title: { en: 'Report Abuse', ar: 'الإبلاغ عن إساءة' },
      icon: AlertTriangle,
      content: {
        en: `How to Report Abuse:

If you believe someone is violating this AUP or engaging in abusive behavior, please report it:

Abuse Reports:
Email: abuse@progineous.com

Include in Your Report:
• Your contact information
• Description of the violation
• Evidence (URLs, screenshots, logs, headers)
• Date and time of the incident
• IP addresses or domains involved
• Any other relevant information

Types of Reports We Handle:
• Spam or unsolicited email
• Phishing or fraud
• Malware or malicious content
• Copyright infringement (DMCA)
• Trademark violations
• Network attacks
• Illegal content
• Terms of service violations

Response Times:
• Emergency issues (active attacks): Within 1 hour
• Illegal content: Within 24 hours
• Spam/abuse: Within 48 hours
• Other violations: Within 72 hours

DMCA Notices:
For copyright infringement claims, please send DMCA notices to:
dmca@progineous.com

Include all required elements under 17 U.S.C. § 512(c)(3).

Anonymous Reports:
We accept anonymous reports but may be limited in our ability to follow up without contact information.`,
        ar: `كيفية الإبلاغ عن إساءة:

إذا كنت تعتقد أن شخصًا ما ينتهك سياسة الاستخدام المقبول هذه أو يشارك في سلوك مسيء، يرجى الإبلاغ عنه:

تقارير الإساءة:
البريد الإلكتروني: abuse@progineous.com

تضمين في تقريرك:
• معلومات الاتصال الخاصة بك
• وصف الانتهاك
• الأدلة (عناوين URL، لقطات الشاشة، السجلات، الرؤوس)
• تاريخ ووقت الحادث
• عناوين IP أو النطاقات المعنية
• أي معلومات أخرى ذات صلة

أنواع التقارير التي نتعامل معها:
• الرسائل غير المرغوبة أو البريد غير المطلوب
• التصيد الاحتيالي أو الاحتيال
• البرمجيات الخبيثة أو المحتوى الضار
• انتهاك حقوق النشر (DMCA)
• انتهاكات العلامات التجارية
• هجمات الشبكة
• المحتوى غير القانوني
• انتهاكات شروط الخدمة

أوقات الاستجابة:
• المشكلات الطارئة (هجمات نشطة): خلال ساعة واحدة
• المحتوى غير القانوني: خلال 24 ساعة
• الرسائل غير المرغوبة/الإساءة: خلال 48 ساعة
• الانتهاكات الأخرى: خلال 72 ساعة

إشعارات DMCA:
لمطالبات انتهاك حقوق النشر، يرجى إرسال إشعارات DMCA إلى:
dmca@progineous.com

تضمين جميع العناصر المطلوبة بموجب 17 U.S.C. § 512(c)(3).

التقارير المجهولة:
نقبل التقارير المجهولة ولكن قد نكون محدودين في قدرتنا على المتابعة بدون معلومات الاتصال.`
      }
    },
    {
      id: 'contact',
      title: { en: 'Contact', ar: 'اتصل بنا' },
      icon: Mail,
      content: {
        en: `Contact Information:

For questions about this Acceptable Use Policy:

Pro Gineous
Abuse & Compliance Team

Address:
9 Mustafa Kamel Street
Balwalidain Ihsanah Tower
Beni Suef, Egypt

General Inquiries:
Email: support@progineous.com

Abuse Reports:
Email: abuse@progineous.com

Security Issues:
Email: security@progineous.com

DMCA Notices:
Email: dmca@progineous.com

Legal Matters:
Email: legal@progineous.com

Company Information:
Commercial Register: 90088
Tax Registration: 755-552-334

Support Portal:
https://app.progineous.com/submitticket.php

Last Updated: January 1, 2025

This AUP is effective immediately and applies to all services provided by Pro Gineous.`,
        ar: `معلومات الاتصال:

للأسئلة حول سياسة الاستخدام المقبول هذه:

برو جينيوس
فريق الإساءة والامتثال

العنوان:
9 شارع مصطفى كامل
برج بالوالدين إحسانًا
بني سويف، مصر

الاستفسارات العامة:
البريد الإلكتروني: support@progineous.com

تقارير الإساءة:
البريد الإلكتروني: abuse@progineous.com

المشكلات الأمنية:
البريد الإلكتروني: security@progineous.com

إشعارات DMCA:
البريد الإلكتروني: dmca@progineous.com

المسائل القانونية:
البريد الإلكتروني: legal@progineous.com

معلومات الشركة:
السجل التجاري: 90088
رقم التسجيل الضريبي: 755-552-334

بوابة الدعم:
https://app.progineous.com/submitticket.php

آخر تحديث: 1 يناير 2025

سياسة الاستخدام المقبول هذه سارية المفعول فورًا وتنطبق على جميع الخدمات المقدمة من برو جينيوس.`
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
        '@id': `https://progineous.com/${locale}/aup`,
        name: isRTL ? 'سياسة الاستخدام المقبول | بروجينيوس' : 'Acceptable Use Policy | Pro Gineous',
        description: isRTL
          ? 'قواعد وإرشادات الاستخدام الآمن والقانوني لخدمات بروجينيوس'
          : 'Rules and guidelines for safe and legal use of Pro Gineous services',
        url: `https://progineous.com/${locale}/aup`,
        inLanguage: isRTL ? 'ar' : 'en',
        isPartOf: {
          '@type': 'WebSite',
          name: 'Pro Gineous',
          url: 'https://progineous.com',
        },
        about: {
          '@type': 'Thing',
          name: isRTL ? 'سياسة الاستخدام المقبول' : 'Acceptable Use Policy',
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
            name: isRTL ? 'سياسة الاستخدام المقبول' : 'Acceptable Use Policy',
            item: `https://progineous.com/${locale}/aup`,
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
      <div className="bg-linear-to-br from-orange-500 to-red-600 text-white py-16">
        <div className="max-w-7xl mx-auto px-4 text-center">
          <div className="flex justify-center mb-6">
            <div className="p-4 bg-white/10 rounded-2xl backdrop-blur-sm">
              <ShieldAlert className="w-12 h-12" />
            </div>
          </div>
          <h1 className="text-4xl md:text-5xl font-bold mb-4">
            {isRTL ? 'سياسة الاستخدام المقبول' : 'Acceptable Use Policy'}
          </h1>
          <p className="text-lg text-white/80 max-w-2xl mx-auto">
            {isRTL 
              ? 'إرشادات لاستخدام خدماتنا بشكل مسؤول وقانوني'
              : 'Guidelines for responsible and lawful use of our services'
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
                            ? 'bg-orange-500 text-white shadow-md'
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
                        ? 'bg-orange-500 text-white'
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
            {/* Warning Banner */}
            <div className="bg-amber-50 border border-amber-200 rounded-xl p-4 mb-8 flex items-start gap-3">
              <AlertTriangle className="w-6 h-6 text-amber-600 shrink-0 mt-0.5" />
              <div>
                <h3 className="font-semibold text-amber-800">
                  {isRTL ? 'تحذير مهم' : 'Important Notice'}
                </h3>
                <p className="text-sm text-amber-700 mt-1">
                  {isRTL 
                    ? 'انتهاك سياسة الاستخدام المقبول قد يؤدي إلى تعليق أو إنهاء الخدمة فورًا بدون استرداد. يرجى قراءة هذه السياسة بعناية.'
                    : 'Violation of this Acceptable Use Policy may result in immediate suspension or termination of services without refund. Please read this policy carefully.'
                  }
                </p>
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
                          'bg-linear-to-br from-orange-500 to-red-600 text-white shadow-lg'
                        )}>
                          <Icon className="w-6 h-6" />
                        </div>
                        <div>
                          <span className="text-sm font-semibold text-orange-600">
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
                  className="flex items-center gap-3 p-4 rounded-xl border border-gray-200 hover:border-orange-500 hover:bg-orange-50 transition-all group"
                >
                  <div className="p-2 bg-gray-100 rounded-lg group-hover:bg-orange-500 group-hover:text-white transition-colors">
                    <FileText className="w-5 h-5" />
                  </div>
                  <div>
                    <h4 className="font-semibold text-gray-900 group-hover:text-orange-600">
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
                  className="flex items-center gap-3 p-4 rounded-xl border border-gray-200 hover:border-orange-500 hover:bg-orange-50 transition-all group"
                >
                  <div className="p-2 bg-gray-100 rounded-lg group-hover:bg-orange-500 group-hover:text-white transition-colors">
                    <Shield className="w-5 h-5" />
                  </div>
                  <div>
                    <h4 className="font-semibold text-gray-900 group-hover:text-orange-600">
                      {isRTL ? 'سياسة الخصوصية' : 'Privacy Policy'}
                    </h4>
                    <p className="text-sm text-gray-500">
                      {isRTL ? 'كيف نحمي بياناتك' : 'How we protect your data'}
                    </p>
                  </div>
                  <ChevronRight className={cn('w-5 h-5 text-gray-400 ms-auto', isRTL && 'rotate-180')} />
                </Link>
                <Link
                  href={`/${locale}/dmca`}
                  className="flex items-center gap-3 p-4 rounded-xl border border-gray-200 hover:border-orange-500 hover:bg-orange-50 transition-all group"
                >
                  <div className="p-2 bg-gray-100 rounded-lg group-hover:bg-orange-500 group-hover:text-white transition-colors">
                    <FileText className="w-5 h-5" />
                  </div>
                  <div>
                    <h4 className="font-semibold text-gray-900 group-hover:text-orange-600">
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
                  className="flex items-center gap-3 p-4 rounded-xl border border-gray-200 hover:border-orange-500 hover:bg-orange-50 transition-all group"
                >
                  <div className="p-2 bg-gray-100 rounded-lg group-hover:bg-orange-500 group-hover:text-white transition-colors">
                    <FileText className="w-5 h-5" />
                  </div>
                  <div>
                    <h4 className="font-semibold text-gray-900 group-hover:text-orange-600">
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
                  className="flex items-center gap-3 p-4 rounded-xl border border-gray-200 hover:border-orange-500 hover:bg-orange-50 transition-all group"
                >
                  <div className="p-2 bg-gray-100 rounded-lg group-hover:bg-orange-500 group-hover:text-white transition-colors">
                    <FileText className="w-5 h-5" />
                  </div>
                  <div>
                    <h4 className="font-semibold text-gray-900 group-hover:text-orange-600">
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
                  className="flex items-center gap-3 p-4 rounded-xl border border-gray-200 hover:border-orange-500 hover:bg-orange-50 transition-all group"
                >
                  <div className="p-2 bg-gray-100 rounded-lg group-hover:bg-orange-500 group-hover:text-white transition-colors">
                    <FileText className="w-5 h-5" />
                  </div>
                  <div>
                    <h4 className="font-semibold text-gray-900 group-hover:text-orange-600">
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
