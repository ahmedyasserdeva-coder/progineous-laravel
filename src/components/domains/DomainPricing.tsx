'use client';

import { useTranslations } from 'next-intl';
import { Check, ShoppingCart } from 'lucide-react';

export function DomainPricing() {
  const t = useTranslations('domains');

  const tlds = [
    {
      ext: '.com',
      desc: 'Most popular worldwide',
      register: 12.99,
      renew: 14.99,
      transfer: 12.99
    },
    {
      ext: '.net',
      desc: 'Great for tech companies',
      register: 14.99,
      renew: 16.99,
      transfer: 14.99
    },
    {
      ext: '.org',
      desc: 'Perfect for organizations',
      register: 12.99,
      renew: 14.99,
      transfer: 12.99
    },
    {
      ext: '.io',
      desc: 'Popular for startups',
      register: 39.99,
      renew: 44.99,
      transfer: 39.99
    },
    {
      ext: '.co',
      desc: 'Short & memorable',
      register: 29.99,
      renew: 32.99,
      transfer: 29.99
    },
    {
      ext: '.sa',
      desc: 'Saudi Arabia domain',
      register: 49.99,
      renew: 54.99,
      transfer: 49.99
    }
  ];

  return (
    <section className="bg-white py-20">
      <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div className="text-center">
          <h2 className="text-3xl font-bold text-gray-900">
            أسعار النطاقات
          </h2>
          <p className="mt-4 text-gray-600">
            أسعار تنافسية مع تجديد سهل
          </p>
        </div>

        {/* Pricing Table */}
        <div className="mt-12 overflow-hidden rounded-2xl border border-gray-200">
          <table className="w-full">
            <thead>
              <tr className="bg-gray-50">
                <th className="px-6 py-4 text-start text-sm font-semibold text-gray-900">
                  النطاق
                </th>
                <th className="px-6 py-4 text-center text-sm font-semibold text-gray-900">
                  التسجيل
                </th>
                <th className="px-6 py-4 text-center text-sm font-semibold text-gray-900">
                  التجديد
                </th>
                <th className="px-6 py-4 text-center text-sm font-semibold text-gray-900">
                  النقل
                </th>
                <th className="px-6 py-4"></th>
              </tr>
            </thead>
            <tbody className="divide-y divide-gray-200">
              {tlds.map((tld, index) => (
                <tr
                  key={index}
                  className="transition-colors hover:bg-gray-50"
                >
                  <td className="px-6 py-4">
                    <div className="flex items-center gap-3">
                      <div className="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-100 font-bold text-blue-600">
                        {tld.ext}
                      </div>
                      <div>
                        <p className="font-medium text-gray-900">
                          {tld.ext}
                        </p>
                        <p className="text-sm text-gray-500">{tld.desc}</p>
                      </div>
                    </div>
                  </td>
                  <td className="px-6 py-4 text-center">
                    <span className="font-bold text-green-600">
                      ${tld.register}
                    </span>
                    <span className="text-sm text-gray-500">/سنة</span>
                  </td>
                  <td className="px-6 py-4 text-center">
                    <span className="font-medium text-gray-900">
                      ${tld.renew}
                    </span>
                    <span className="text-sm text-gray-500">/سنة</span>
                  </td>
                  <td className="px-6 py-4 text-center">
                    <span className="font-medium text-gray-900">
                      ${tld.transfer}
                    </span>
                  </td>
                  <td className="px-6 py-4 text-end">
                    <button className="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white transition-all hover:bg-blue-700">
                      <ShoppingCart className="h-4 w-4" />
                      {t('register')}
                    </button>
                  </td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>
      </div>
    </section>
  );
}
