import { NextResponse } from 'next/server';
import { getTLDPricing } from '@/lib/whmcs';

export async function GET() {
  try {
    const result = await getTLDPricing();

    console.log('WHMCS TLD Response:', JSON.stringify(result, null, 2));

    if (result.result === 'error') {
      return NextResponse.json({ error: result.message }, { status: 400 });
    }

    // Transform TLD pricing data into a simpler format
    const tlds: { extension: string; price: string; isFree?: boolean }[] = [];
    const currency = result.currency || { code: 'USD', prefix: '$', suffix: '' };
    
    if (result.pricing) {
      // Get only com, net, org for hero section
      const priorityTLDs = ['com', 'net', 'org'];
      
      for (const tld of priorityTLDs) {
        if (result.pricing[tld]) {
          const pricing = result.pricing[tld];
          // WHMCS returns keys as strings like "1", "2", etc.
          const registerPrice = pricing.register?.['1'] || pricing.register?.[1] || 
                               pricing.renew?.['1'] || pricing.renew?.[1] || null;
          
          if (registerPrice !== null) {
            const priceNum = parseFloat(registerPrice);
            tlds.push({
              extension: `.${tld}`,
              price: `${currency.prefix}${priceNum.toFixed(2)}${currency.suffix}`,
              isFree: priceNum === 0,
            });
          }
        }
      }
      
      // If no priority TLDs found, get any available TLDs
      if (tlds.length === 0) {
        const allTLDs = Object.keys(result.pricing).slice(0, 6);
        for (const tld of allTLDs) {
          const pricing = result.pricing[tld];
          const registerPrice = pricing.register?.['1'] || pricing.register?.[1] || 
                               pricing.renew?.['1'] || pricing.renew?.[1] || null;
          
          if (registerPrice !== null) {
            const priceNum = parseFloat(registerPrice);
            tlds.push({
              extension: `.${tld}`,
              price: `${currency.prefix}${priceNum.toFixed(2)}${currency.suffix}`,
              isFree: priceNum === 0,
            });
          }
        }
      }
    }

    // Return debug info if no TLDs found
    if (tlds.length === 0) {
      return NextResponse.json({
        tlds: [],
        currency,
        debug: {
          hasResult: !!result,
          resultStatus: result.result,
          hasPricing: !!result.pricing,
          pricingKeys: result.pricing ? Object.keys(result.pricing).slice(0, 10) : [],
          samplePricing: result.pricing ? result.pricing[Object.keys(result.pricing)[0]] : null,
        }
      });
    }

    return NextResponse.json({
      tlds,
      currency,
    });
  } catch (error) {
    console.error('Error fetching TLDs:', error);
    return NextResponse.json({ 
      error: 'Failed to fetch TLDs',
      details: error instanceof Error ? error.message : 'Unknown error'
    }, { status: 500 });
  }
}
