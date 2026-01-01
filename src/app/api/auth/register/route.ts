import { NextRequest, NextResponse } from 'next/server';
import { addClient } from '@/lib/whmcs';

export async function POST(request: NextRequest) {
  try {
    const body = await request.json();
    const {
      firstname,
      lastname,
      email,
      password,
      address1,
      city,
      state,
      postcode,
      country,
      phonenumber,
      companyname,
    } = body;

    // Validate required fields
    if (!firstname || !lastname || !email || !password || !address1 || !city || !country || !phonenumber) {
      return NextResponse.json(
        { error: 'Missing required fields' },
        { status: 400 }
      );
    }

    // Register client with WHMCS
    const result = await addClient({
      firstname,
      lastname,
      email,
      password2: password,
      address1,
      city,
      state: state || '',
      postcode: postcode || '',
      country,
      phonenumber,
      companyname,
    });

    if (result.result === 'error') {
      return NextResponse.json(
        { error: result.message || 'Registration failed' },
        { status: 400 }
      );
    }

    return NextResponse.json({
      success: true,
      message: 'Account created successfully',
      clientId: result.clientid,
    });
  } catch (error) {
    console.error('Registration error:', error);
    return NextResponse.json(
      { error: 'Registration failed' },
      { status: 500 }
    );
  }
}
