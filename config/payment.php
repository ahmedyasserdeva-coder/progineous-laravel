<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Payment Gateway
    |--------------------------------------------------------------------------
    |
    | This option controls the default payment gateway that will be used by
    | your application. You may set this to any of the gateways defined
    | in the "gateways" array.
    |
    | Supported: "stripe", "paypal", "fawaterak"
    |
    */

    'default' => env('PAYMENT_GATEWAY', 'fawaterak'),

    /*
    |--------------------------------------------------------------------------
    | Payment Currency
    |--------------------------------------------------------------------------
    |
    | The default currency for payments.
    | Fawaterak Supported: 'USD', 'EGP', 'SAR', 'AED', 'KWD', 'QAR', 'BHD'
    | Stripe/PayPal: All major currencies
    |
    */

    'currency' => env('PAYMENT_CURRENCY', 'EGP'),

    /*
    |--------------------------------------------------------------------------
    | Supported Currencies
    |--------------------------------------------------------------------------
    |
    | List of all supported currencies by Fawaterak payment gateway
    |
    */

    'supported_currencies' => [
        'EGP' => 'Egyptian Pound (جنيه مصري)',
        'USD' => 'US Dollar (دولار أمريكي)',
        'SAR' => 'Saudi Riyal (ريال سعودي)',
        'AED' => 'UAE Dirham (درهم إماراتي)',
        'KWD' => 'Kuwaiti Dinar (دينار كويتي)',
        'QAR' => 'Qatari Riyal (ريال قطري)',
        'BHD' => 'Bahraini Dinar (دينار بحريني)',
    ],

    /*
    |--------------------------------------------------------------------------
    | Stripe Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for Stripe payment gateway
    | Get your keys from: https://dashboard.stripe.com/apikeys
    |
    */

    'stripe' => [
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
        'webhook_secret' => env('STRIPE_WEBHOOK_SECRET'),
        'enabled' => env('STRIPE_ENABLED', true),
    ],

    /*
    |--------------------------------------------------------------------------
    | PayPal Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for PayPal payment gateway
    | Get your credentials from: https://developer.paypal.com/
    |
    */

    'paypal' => [
        'mode' => env('PAYPAL_MODE', 'sandbox'), // sandbox or live
        'sandbox' => [
            'client_id' => env('PAYPAL_SANDBOX_CLIENT_ID'),
            'client_secret' => env('PAYPAL_SANDBOX_CLIENT_SECRET'),
        ],
        'live' => [
            'client_id' => env('PAYPAL_LIVE_CLIENT_ID'),
            'client_secret' => env('PAYPAL_LIVE_CLIENT_SECRET'),
        ],
        'enabled' => env('PAYPAL_ENABLED', true),
    ],

    /*
    |--------------------------------------------------------------------------
    | Fawaterak Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for Fawaterak payment gateway (Egyptian payment gateway)
    | Get your API key from: https://fawaterak.com/
    |
    | API Documentation: https://fawaterak-api.readme.io/reference
    |
    */

    'fawaterak' => [
        'api_key' => env('FAWATERAK_API_KEY'),
        'provider_key' => env('FAWATERAK_PROVIDER_KEY'),
        // Production URL for live payments
        'api_url' => env('FAWATERAK_API_URL', 'https://app.fawaterk.com/api/v2'),
        // For testing use: https://staging.fawaterk.com/api/v2
        'mode' => env('FAWATERAK_MODE', 'production'), // staging or production
        'enabled' => env('FAWATERAK_ENABLED', true),
        
        // Payment Methods IDs from Fawaterak
        'payment_methods' => [
            'visa_mastercard' => 2,
            'fawry' => 3,
            'meeza' => 4,
            'aman' => 5,
            'basta' => 6,
        ],
        
        // Webhook URLs for Fawaterak Dashboard Configuration
        'webhooks' => [
            'paid' => env('FAWATERAK_WEBHOOK_PAID'),
            'cancelled' => env('FAWATERAK_WEBHOOK_CANCELLED'),
            'failed' => env('FAWATERAK_WEBHOOK_FAILED'),
            'refund' => env('FAWATERAK_WEBHOOK_REFUND'),
        ],
        
        // Redirect URLs after payment
        'redirect_urls' => [
            'success' => env('FAWATERAK_SUCCESS_URL'),
            'fail' => env('FAWATERAK_FAIL_URL'),
            'pending' => env('FAWATERAK_PENDING_URL'),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Payment Webhooks
    |--------------------------------------------------------------------------
    |
    | Webhook URLs for payment gateway callbacks
    |
    */

    'webhooks' => [
        'stripe' => env('APP_URL') . '/webhooks/stripe',
        'paypal' => env('APP_URL') . '/webhooks/paypal',
        'fawaterak' => env('APP_URL') . '/webhooks/fawaterak',
    ],

    /*
    |--------------------------------------------------------------------------
    | Payment Redirect URLs
    |--------------------------------------------------------------------------
    |
    | URLs to redirect after payment success/fail/pending
    |
    */

    'redirect_urls' => [
        'success' => env('APP_URL') . '/payment/success',
        'fail' => env('APP_URL') . '/payment/fail',
        'pending' => env('APP_URL') . '/payment/pending',
    ],

    /*
    |--------------------------------------------------------------------------
    | Currency Validation
    |--------------------------------------------------------------------------
    |
    | Helper method to validate if a currency is supported
    |
    */

    'validate_currency' => function($currency) {
        return array_key_exists($currency, config('payment.supported_currencies'));
    },

];
