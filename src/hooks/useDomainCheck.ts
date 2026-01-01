'use client';

import { useState } from 'react';

interface DomainCheckResult {
  domain: string;
  available: boolean;
  status: string;
}

export function useDomainCheck() {
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState<string | null>(null);
  const [result, setResult] = useState<DomainCheckResult | null>(null);

  const checkDomain = async (domain: string) => {
    setLoading(true);
    setError(null);
    
    try {
      const response = await fetch(`/api/whmcs/domains/check?domain=${encodeURIComponent(domain)}`);
      const data = await response.json();
      
      if (!response.ok) {
        throw new Error(data.error || 'Failed to check domain');
      }
      
      setResult(data);
      return data;
    } catch (err) {
      const message = err instanceof Error ? err.message : 'An error occurred';
      setError(message);
      throw err;
    } finally {
      setLoading(false);
    }
  };

  return { checkDomain, loading, error, result };
}
