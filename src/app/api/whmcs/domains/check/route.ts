import { NextRequest, NextResponse } from 'next/server';
import { checkDomainAvailability, getTLDPricing } from '@/lib/whmcs';

export async function GET(request: NextRequest) {
  const searchParams = request.nextUrl.searchParams;
  const domain = searchParams.get('domain');

  if (!domain) {
    return NextResponse.json({ error: 'Domain parameter is required' }, { status: 400 });
  }

  try {
    const result = await checkDomainAvailability(domain);
    
    // Get TLD extension
    const tld = '.' + domain.split('.').slice(1).join('.');
    
    // Try to get pricing for this TLD
    let price = null;
    try {
      const pricingResult = await getTLDPricing(1); // Currency ID 1 (usually USD)
      if (pricingResult.pricing && pricingResult.pricing.hasOwnProperty(tld.substring(1))) {
        const tldPricing = pricingResult.pricing[tld.substring(1)];
        if (tldPricing.register && tldPricing.register['1']) {
          price = `$${tldPricing.register['1']} USD`;
        }
      }
    } catch (priceError) {
      console.error('Error fetching TLD pricing:', priceError);
    }
    
    return NextResponse.json({
      domain,
      available: result.status === 'available',
      status: result.status,
      price,
    });
  } catch (error) {
    console.error('Error checking domain:', error);
    return NextResponse.json({ error: 'Failed to check domain availability' }, { status: 500 });
  }
}
