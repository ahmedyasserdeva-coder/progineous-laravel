<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('frontend.cancellation_verification_code') }}</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">
    <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 30px; text-align: center; border-radius: 10px 10px 0 0;">
        <h1 style="color: white; margin: 0; font-size: 24px;">{{ config('app.name') }}</h1>
    </div>
    
    <div style="background: #f9fafb; padding: 30px; border-radius: 0 0 10px 10px; border: 1px solid #e5e7eb;">
        <h2 style="color: #1f2937; margin-top: 0;">{{ __('frontend.cancellation_verification_code') }}</h2>
        
        <p>{{ __('frontend.dear') }} {{ $client->name }},</p>
        
        <p>{{ __('frontend.cancellation_code_intro') }}</p>
        
        <div style="background: white; padding: 20px; margin: 30px 0; text-align: center; border-radius: 8px; border: 2px solid #e5e7eb;">
            <div style="font-size: 14px; color: #6b7280; margin-bottom: 10px; text-transform: uppercase; letter-spacing: 1px;">
                {{ __('frontend.verification_code') }}
            </div>
            <div style="font-size: 36px; font-weight: bold; color: #dc2626; letter-spacing: 8px; font-family: 'Courier New', monospace;">
                {{ $code }}
            </div>
        </div>
        
        <div style="background: #fef3c7; border-left: 4px solid #f59e0b; padding: 15px; margin: 20px 0; border-radius: 4px;">
            <p style="margin: 0; color: #92400e; font-size: 14px;">
                <strong>{{ __('frontend.note') }}:</strong> {{ __('frontend.code_expires_in') }}
            </p>
        </div>
        
        <p>{{ __('frontend.service_details') }}:</p>
        <ul style="background: white; padding: 20px; border-radius: 8px; border: 1px solid #e5e7eb;">
            <li><strong>{{ __('frontend.service') }}:</strong> {{ $service->service_name }}</li>
            <li><strong>{{ __('frontend.domain') }}:</strong> {{ $service->getDomainName() }}</li>
        </ul>
        
        <p style="color: #6b7280; font-size: 14px; margin-top: 30px;">
            {{ __('frontend.if_not_you') }}
        </p>
        
        <hr style="border: none; border-top: 1px solid #e5e7eb; margin: 30px 0;">
        
        <p style="color: #9ca3af; font-size: 12px; text-align: center; margin: 0;">
            © {{ date('Y') }} {{ config('app.name') }}. {{ __('frontend.all_rights_reserved') }}
        </p>
    </div>
</body>
</html>
