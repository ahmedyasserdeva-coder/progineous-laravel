import { NextResponse } from 'next/server';
import { getTLDPricing } from '@/lib/whmcs';

export async function GET() {
  try {
    const result = await getTLDPricing();

    if (result.result === 'error') {
      return NextResponse.json({ error: result.message }, { status: 400 });
    }

    return NextResponse.json({
      pricing: result.pricing,
      currency: result.currency,
    });
  } catch (error) {
    console.error('Error fetching TLD pricing:', error);
    return NextResponse.json({ error: 'Failed to fetch TLD pricing' }, { status: 500 });
  }
}
