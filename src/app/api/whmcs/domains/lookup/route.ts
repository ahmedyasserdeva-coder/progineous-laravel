import { NextResponse } from 'next/server';

const WHMCS_URL = process.env.WHMCS_API_URL || 'https://app.progineous.com/includes/api.php';
const WHMCS_ADMIN_USERNAME = process.env.WHMCS_ADMIN_USERNAME || '';
const WHMCS_ADMIN_PASSWORD = process.env.WHMCS_ADMIN_PASSWORD || ''; // MD5 hashed

export async function GET(request: Request) {
  const { searchParams } = new URL(request.url);
  const domain = searchParams.get('domain');

  if (!domain) {
    return NextResponse.json({ error: 'Domain is required' }, { status: 400 });
  }

  try {
    // Get all domains from WHMCS and check if the requested domain exists
    const params = new URLSearchParams();
    params.append('username', WHMCS_ADMIN_USERNAME);
    params.append('password', WHMCS_ADMIN_PASSWORD);
    params.append('action', 'GetClientsDomains');
    params.append('limitnum', '10000'); // Get all domains
    params.append('responsetype', 'json');

    const response = await fetch(WHMCS_URL, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
      },
      body: params.toString(),
    });

    const data = await response.json();
    
    // Check if domain exists in the list
    if (data.result === 'success' && data.domains?.domain) {
      const domains = Array.isArray(data.domains.domain) 
        ? data.domains.domain 
        : [data.domains.domain];
      
      const foundDomain = domains.find((d: any) => 
        d.domainname?.toLowerCase() === domain.toLowerCase()
      );
      
      if (foundDomain) {
        return NextResponse.json({
          exists: true,
          domain: domain,
          status: foundDomain.status || 'Active',
          expiryDate: foundDomain.expirydate,
          clientId: foundDomain.userid,
          message: 'Domain is registered with us'
        });
      }
    }
    
    // Domain not found in our system
    return NextResponse.json({
      exists: false,
      domain: domain,
      message: 'Domain is not registered with us'
    });

  } catch (error) {
    console.error('Domain lookup error:', error);
    return NextResponse.json({
      exists: false,
      domain: domain,
      error: 'Could not verify domain ownership',
      message: 'Domain is not registered with us'
    });
  }
}
