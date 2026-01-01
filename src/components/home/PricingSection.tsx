'use client';

import { useState } from 'react';
import { useTranslations } from 'next-intl';
import { Link } from '@/i18n/routing';
import { Check, Sparkles } from 'lucide-react';
import { cn } from '@/lib/utils';

export function PricingSection() {
  const t = useTranslations('pricing');
  const [isYearly, setIsYearly] = useState(false);

  const plans = [
    {
      name: 'Starter',
      price: { monthly: 9.99, yearly: 7.99 },
      features: [
        { key: 'storage', value: '10 GB SSD' },
        { key: 'bandwidth', value: '100 GB' },
        { key: 'domains', value: '1' },
        { key: 'emails', value: '5' },
        { key: 'ssl', value: '✓' },
        { key: 'backup', value: 'Weekly' }
      ],
      popular: false
    },
    {
      name: 'Professional',
      price: { monthly: 19.99, yearly: 15.99 },
      features: [
        { key: 'storage', value: '50 GB NVMe' },
        { key: 'bandwidth', value: 'Unlimited' },
        { key: 'domains', value: '10' },
        { key: 'emails', value: '50' },
        { key: 'ssl', value: '✓' },
        { key: 'backup', value: 'Daily' }
      ],
      popular: true
    },
    {
      name: 'Business',
      price: { monthly: 39.99, yearly: 31.99 },
      features: [
        { key: 'storage', value: '100 GB NVMe' },
        { key: 'bandwidth', value: 'Unlimited' },
        { key: 'domains', value: 'Unlimited' },
        { key: 'emails', value: 'Unlimited' },
        { key: 'ssl', value: '✓' },
        { key: 'backup', value: 'Real-time' }
      ],
      popular: false
    }
  ];

  return (
    <section className="bg-gray-50 py-20">
      <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        {/* Header */}
        <div className="text-center">
          <h2 className="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
            {t('title')}
          </h2>
          <p className="mt-4 text-lg text-gray-600">
            {t('subtitle')}
          </p>

          {/* Toggle */}
          <div className="mt-8 inline-flex items-center gap-4 rounded-full bg-white p-1 shadow-md">
            <button
              onClick={() => setIsYearly(false)}
              className={cn(
                'rounded-full px-6 py-2 text-sm font-medium transition-all',
                !isYearly
                  ? 'bg-blue-600 text-white'
                  : 'text-gray-600 hover:text-gray-900'
              )}
            >
              {t('monthly')}
            </button>
            <button
              onClick={() => setIsYearly(true)}
              className={cn(
                'rounded-full px-6 py-2 text-sm font-medium transition-all',
                isYearly
                  ? 'bg-blue-600 text-white'
                  : 'text-gray-600 hover:text-gray-900'
              )}
            >
              {t('yearly')}
              <span className="ms-2 rounded bg-green-100 px-2 py-0.5 text-xs text-green-700">
                -20%
              </span>
            </button>
          </div>
        </div>

        {/* Plans */}
        <div className="mt-12 grid gap-8 lg:grid-cols-3">
          {plans.map((plan, index) => (
            <div
              key={index}
              className={cn(
                'relative rounded-2xl bg-white p-8 shadow-lg transition-all hover:-translate-y-1 hover:shadow-xl',
                plan.popular && 'ring-2 ring-[#1d71b8]'
              )}
            >
              {/* Popular Badge */}
              {plan.popular && (
                <div className="absolute -top-4 start-1/2 -translate-x-1/2 rtl:translate-x-1/2">
                  <div className="inline-flex items-center gap-1 rounded-full bg-[#1d71b8] px-4 py-1 text-sm font-medium text-white">
                    <Sparkles className="h-4 w-4" />
                    {t('popular')}
                  </div>
                </div>
              )}

              {/* Plan Name */}
              <h3 className="text-xl font-bold text-gray-900">
                {plan.name}
              </h3>

              {/* Price */}
              <div className="mt-4 flex items-baseline gap-1">
                <span className="text-4xl font-extrabold text-gray-900">
                  ${isYearly ? plan.price.yearly : plan.price.monthly}
                </span>
                <span className="text-gray-500">
                  /{t('monthly').toLowerCase()}
                </span>
              </div>

              {/* Features */}
              <ul className="mt-8 space-y-4">
                {plan.features.map((feature, idx) => (
                  <li key={idx} className="flex items-center gap-3">
                    <div className="flex h-5 w-5 items-center justify-center rounded-full bg-green-100">
                      <Check className="h-3 w-3 text-green-600" />
                    </div>
                    <span className="text-gray-600">
                      <span className="font-medium text-gray-900">
                        {t(`features.${feature.key}`)}:
                      </span>{' '}
                      {feature.value}
                    </span>
                  </li>
                ))}
              </ul>

              {/* CTA */}
              <Link
                href="/hosting/shared"
                className={cn(
                  'mt-8 block rounded-xl py-3 text-center font-semibold transition-all',
                  plan.popular
                    ? 'bg-[#1d71b8] text-white hover:bg-[#1a6299]'
                    : 'border-2 border-gray-200 text-gray-700 hover:border-[#1d71b8] hover:text-[#1d71b8]'
                )}
              >
                {t('order_now')}
              </Link>
            </div>
          ))}
        </div>
      </div>
    </section>
  );
}
