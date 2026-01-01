import { NextRequest, NextResponse } from 'next/server';
import { validateLogin, getClientDetails } from '@/lib/whmcs';

const WHMCS_API_URL = process.env.WHMCS_API_URL || 'https://app.progineous.com/includes/api.php';
const WHMCS_BASE_URL = process.env.WHMCS_BASE_URL || 'https://app.progineous.com';
const WHMCS_API_IDENTIFIER = process.env.WHMCS_API_IDENTIFIER || '';
const WHMCS_API_SECRET = process.env.WHMCS_API_SECRET || '';

export async function POST(request: NextRequest) {
  try {
    const body = await request.json();
    const { email, password } = body;

    if (!email || !password) {
      return NextResponse.json(
        { error: 'Email and password are required' },
        { status: 400 }
      );
    }

    // Validate login with WHMCS
    const loginResult = await validateLogin(email, password);
    console.log('Login Result:', JSON.stringify(loginResult, null, 2));

    if (loginResult.result === 'error') {
      return NextResponse.json(
        { error: loginResult.message || 'Invalid credentials' },
        { status: 401 }
      );
    }

    // Get client details
    const clientDetails = await getClientDetails(loginResult.userid);
    console.log('Client Details:', JSON.stringify(clientDetails, null, 2));

    // Create SSO Token for automatic login
    let redirectUrl = `${WHMCS_BASE_URL}/clientarea.php`;
    
    try {
      const ssoFormData = new URLSearchParams({
        identifier: WHMCS_API_IDENTIFIER,
        secret: WHMCS_API_SECRET,
        action: 'CreateSsoToken',
        responsetype: 'json',
        client_id: loginResult.userid.toString(),
      });

      const ssoResponse = await fetch(WHMCS_API_URL, {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: ssoFormData.toString(),
      });

      const ssoData = await ssoResponse.json();
      console.log('SSO Response:', JSON.stringify(ssoData, null, 2));
      
      if (ssoData.result === 'success' && ssoData.redirect_url) {
        redirectUrl = ssoData.redirect_url;
      }
    } catch (ssoError) {
      console.error('SSO Token creation error:', ssoError);
    }

    // Create response
    const response = NextResponse.json({
      success: true,
      user: {
        id: loginResult.userid,
        email: clientDetails.email || clientDetails.client?.email,
        firstname: clientDetails.firstname || clientDetails.client?.firstname,
        lastname: clientDetails.lastname || clientDetails.client?.lastname,
        companyname: clientDetails.companyname || clientDetails.client?.companyname,
      },
      redirectUrl,
    });

    // Set a session cookie
    response.cookies.set('whmcs_user_id', String(loginResult.userid), {
      httpOnly: true,
      secure: process.env.NODE_ENV === 'production',
      sameSite: 'lax',
      maxAge: 60 * 60 * 24 * 7, // 7 days
    });

    return response;
  } catch (error) {
    console.error('Login error:', error);
    return NextResponse.json(
      { error: 'Authentication failed' },
      { status: 500 }
    );
  }
}
