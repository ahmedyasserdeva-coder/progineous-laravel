import { NextResponse } from 'next/server';
import { getProducts, getProductGroups } from '@/lib/whmcs';

export async function GET() {
  try {
    const [productsRes, groupsRes] = await Promise.all([
      getProducts(),
      getProductGroups(),
    ]);

    if (productsRes.result === 'error') {
      return NextResponse.json({ error: productsRes.message }, { status: 400 });
    }

    return NextResponse.json({
      products: productsRes.products?.product || [],
      groups: groupsRes.groups?.group || [],
    });
  } catch (error) {
    console.error('Error fetching products:', error);
    return NextResponse.json({ error: 'Failed to fetch products' }, { status: 500 });
  }
}
