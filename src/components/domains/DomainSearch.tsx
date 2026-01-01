'use client';

import { useState } from 'react';
import { useTranslations } from 'next-intl';
import { Search, Globe, ArrowRight, Loader2 } from 'lucide-react';
import { cn } from '@/lib/utils';

export function DomainSearch() {
  const t = useTranslations('domains');
  const [domain, setDomain] = useState('');
  const [isSearching, setIsSearching] = useState(false);
  const [results, setResults] = useState<
    { name: string; available: boolean; price: number }[] | null
  >(null);

  const extensions = ['.com', '.net', '.org', '.io', '.co', '.sa'];

  const handleSearch = async (e: React.FormEvent) => {
    e.preventDefault();
    if (!domain.trim()) return;

    setIsSearching(true);
    // Simulate API call
    await new Promise((resolve) => setTimeout(resolve, 1500));

    const domainName = domain.replace(/\.[^.]+$/, '').toLowerCase();
    setResults(
      extensions.map((ext) => ({
        name: domainName + ext,
        available: Math.random() > 0.3,
        price: ext === '.com' ? 12.99 : ext === '.io' ? 39.99 : 14.99
      }))
    );
    setIsSearching(false);
  };

  return (
    <section className="relative bg-[#1d71b8] py-20">
      {/* Background */}
      <div className="absolute inset-0">
        <div className="absolute inset-0 bg-[url('/grid.svg')] opacity-10" />
        <div className="absolute -start-20 top-0 h-72 w-72 rounded-full bg-white opacity-10 blur-3xl" />
        <div className="absolute -end-20 bottom-0 h-72 w-72 rounded-full bg-cyan-400 opacity-20 blur-3xl" />
      </div>

      <div className="relative mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
        {/* Header */}
        <div className="text-center">
          <div className="inline-flex items-center justify-center rounded-full bg-white/20 p-3">
            <Globe className="h-8 w-8 text-white" />
          </div>
          <h1 className="mt-4 text-3xl font-bold text-white sm:text-4xl lg:text-5xl">
            {t('title')}
          </h1>
          <p className="mt-4 text-lg text-blue-100">{t('subtitle')}</p>
        </div>

        {/* Search Form */}
        <form onSubmit={handleSearch} className="mt-10">
          <div className="relative flex flex-col gap-4 sm:flex-row">
            <div className="relative flex-1">
              <Search className="absolute start-4 top-1/2 h-5 w-5 -translate-y-1/2 text-gray-400" />
              <input
                type="text"
                value={domain}
                onChange={(e) => setDomain(e.target.value)}
                placeholder={t('search_placeholder')}
                className="w-full rounded-xl border-0 bg-white py-4 pe-4 ps-12 text-gray-900 shadow-lg placeholder:text-gray-400 focus:ring-2 focus:ring-[#1d71b8]"
              />
            </div>
            <button
              type="submit"
              disabled={isSearching}
              className="inline-flex items-center justify-center gap-2 rounded-xl bg-gray-900 px-8 py-4 font-semibold text-white transition-all hover:bg-gray-800 disabled:opacity-70"
            >
              {isSearching ? (
                <>
                  <Loader2 className="h-5 w-5 animate-spin" />
                  جاري البحث...
                </>
              ) : (
                <>
                  {t('search_button')}
                  <ArrowRight className="h-5 w-5 rtl:rotate-180" />
                </>
              )}
            </button>
          </div>
        </form>

        {/* Results */}
        {results && (
          <div className="mt-8 space-y-3">
            {results.map((result, index) => (
              <div
                key={index}
                className={cn(
                  'flex items-center justify-between rounded-xl bg-white/10 p-4 backdrop-blur transition-all hover:bg-white/20',
                  result.available && 'ring-2 ring-green-400'
                )}
              >
                <div className="flex items-center gap-3">
                  <div
                    className={cn(
                      'h-3 w-3 rounded-full',
                      result.available ? 'bg-green-400' : 'bg-red-400'
                    )}
                  />
                  <span className="font-medium text-white">{result.name}</span>
                </div>
                <div className="flex items-center gap-4">
                  <span className="font-bold text-white">
                    ${result.price}
                    <span className="text-sm font-normal text-blue-200">
                      {t('per_year')}
                    </span>
                  </span>
                  {result.available ? (
                    <button className="rounded-lg bg-green-500 px-4 py-2 text-sm font-medium text-white transition-all hover:bg-green-600">
                      {t('register')}
                    </button>
                  ) : (
                    <button
                      disabled
                      className="cursor-not-allowed rounded-lg bg-gray-500 px-4 py-2 text-sm font-medium text-white opacity-50"
                    >
                      غير متاح
                    </button>
                  )}
                </div>
              </div>
            ))}
          </div>
        )}

        {/* Popular Extensions */}
        <div className="mt-10">
          <p className="mb-4 text-center text-sm text-blue-200">
            {t('popular')}:
          </p>
          <div className="flex flex-wrap justify-center gap-3">
            {[
              { ext: '.com', price: '$12.99' },
              { ext: '.net', price: '$14.99' },
              { ext: '.org', price: '$12.99' },
              { ext: '.io', price: '$39.99' },
              { ext: '.sa', price: '$49.99' },
              { ext: '.co', price: '$29.99' }
            ].map((item) => (
              <div
                key={item.ext}
                className="flex items-center gap-2 rounded-full bg-white/10 px-4 py-2 backdrop-blur"
              >
                <span className="font-bold text-white">{item.ext}</span>
                <span className="text-sm text-blue-200">
                  {t('price_from')} {item.price}
                </span>
              </div>
            ))}
          </div>
        </div>
      </div>
    </section>
  );
}
