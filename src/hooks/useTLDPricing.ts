'use client';

import { useState, useEffect } from 'react';

interface TLDPrice {
  tld: string;
  register: string;
  transfer: string;
  renew: string;
}

interface TLDPricingData {
  pricing: Record<string, any>;
  currency: any;
}

// Popular TLDs to show in the menu
const POPULAR_TLDS = ['.com', '.net', '.org', '.sa'];

export function useTLDPricing() {
  const [prices, setPrices] = useState<TLDPrice[]>([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState<string | null>(null);

  useEffect(() => {
    async function fetchPricing() {
      try {
        const response = await fetch('/api/whmcs/domains/pricing');
        
        if (!response.ok) {
          throw new Error('Failed to fetch pricing');
        }

        const data: TLDPricingData = await response.json();
        
        if (data.pricing) {
          const formattedPrices: TLDPrice[] = [];
          
          // Extract prices for popular TLDs
          for (const tld of POPULAR_TLDS) {
            const tldKey = tld.replace('.', '');
            const tldData = data.pricing[tldKey];
            
            if (tldData) {
              // Get 1-year registration price
              const registerPrice = tldData.register?.['1'] || tldData.register?.['1.00'] || null;
              const transferPrice = tldData.transfer?.['1'] || tldData.transfer?.['1.00'] || null;
              const renewPrice = tldData.renew?.['1'] || tldData.renew?.['1.00'] || null;
              
              formattedPrices.push({
                tld,
                register: registerPrice ? `$${parseFloat(registerPrice).toFixed(2)}` : 'N/A',
                transfer: transferPrice ? `$${parseFloat(transferPrice).toFixed(2)}` : 'N/A',
                renew: renewPrice ? `$${parseFloat(renewPrice).toFixed(2)}` : 'N/A',
              });
            }
          }
          
          setPrices(formattedPrices);
        }
      } catch {
        // Set fallback prices when API is unavailable
        setPrices([
          { tld: '.com', register: '$13.06', transfer: '$13.06', renew: '$13.06' },
          { tld: '.net', register: '$15.02', transfer: '$15.02', renew: '$15.02' },
          { tld: '.org', register: '$12.64', transfer: '$12.64', renew: '$12.64' },
          { tld: '.sa', register: '$45.99', transfer: '$45.99', renew: '$45.99' },
        ]);
      } finally {
        setLoading(false);
      }
    }

    fetchPricing();
  }, []);

  return { prices, loading, error };
}
