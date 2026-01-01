'use client';

import { Shield, RefreshCw, Lock, Globe2, Mail, FileText } from 'lucide-react';

export function DomainFeatures() {
  const features = [
    {
      icon: Shield,
      title: 'حماية الخصوصية',
      description: 'حماية WHOIS مجانية لإخفاء معلوماتك الشخصية'
    },
    {
      icon: Lock,
      title: 'قفل النطاق',
      description: 'حماية نطاقك من النقل غير المصرح به'
    },
    {
      icon: RefreshCw,
      title: 'تجديد تلقائي',
      description: 'لن تفقد نطاقك أبداً مع التجديد التلقائي'
    },
    {
      icon: Globe2,
      title: 'DNS مجاني',
      description: 'خوادم DNS سريعة وموثوقة مجاناً'
    },
    {
      icon: Mail,
      title: 'إعادة توجيه البريد',
      description: 'إعادة توجيه البريد الإلكتروني مجاناً'
    },
    {
      icon: FileText,
      title: 'شهادة الملكية',
      description: 'شهادة رقمية تثبت ملكيتك للنطاق'
    }
  ];

  return (
    <section className="bg-gray-50 py-20">
      <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div className="text-center">
          <h2 className="text-3xl font-bold text-gray-900">
            كل ما تحتاجه مع كل نطاق
          </h2>
          <p className="mt-4 text-gray-600">
            ميزات مجانية مع كل تسجيل نطاق
          </p>
        </div>

        <div className="mt-12 grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
          {features.map((feature, index) => (
            <div
              key={index}
              className="rounded-xl bg-white p-6 shadow-sm transition-all hover:shadow-md"
            >
              <div className="inline-flex h-12 w-12 items-center justify-center rounded-lg bg-blue-100">
                <feature.icon className="h-6 w-6 text-blue-600" />
              </div>
              <h3 className="mt-4 text-lg font-semibold text-gray-900">
                {feature.title}
              </h3>
              <p className="mt-2 text-gray-600">
                {feature.description}
              </p>
            </div>
          ))}
        </div>
      </div>
    </section>
  );
}
