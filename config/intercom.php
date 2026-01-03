<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Intercom App ID
    |--------------------------------------------------------------------------
    |
    | Your Intercom application ID. You can find this in your Intercom
    | dashboard under Settings > Installation.
    |
    */

    'app_id' => env('INTERCOM_APP_ID', 'i848b5ou'),

    /*
    |--------------------------------------------------------------------------
    | Intercom API Secret
    |--------------------------------------------------------------------------
    |
    | Your Intercom API secret key. This is used for server-side operations.
    | You can find this in your Intercom dashboard under Settings > API Keys.
    |
    */

    'api_secret' => env('INTERCOM_API_SECRET', ''),

    /*
    |--------------------------------------------------------------------------
    | Enable Intercom
    |--------------------------------------------------------------------------
    |
    | Enable or disable Intercom integration globally.
    |
    */

    'enabled' => env('INTERCOM_ENABLED', true),

    /*
    |--------------------------------------------------------------------------
    | User Identity Verification
    |--------------------------------------------------------------------------
    |
    | Enable user identity verification for enhanced security.
    | Learn more: https://developers.intercom.com/installing-intercom/docs/enable-identity-verification
    |
    */

    'identity_verification' => [
        'enabled' => env('INTERCOM_IDENTITY_VERIFICATION', false),
        'secret_key' => env('INTERCOM_IDENTITY_SECRET_KEY', ''),
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Attributes
    |--------------------------------------------------------------------------
    |
    | Define custom attributes to send with user data
    |
    */

    'custom_attributes' => [
        // Example: 'plan', 'company', 'language', etc.
    ],

    /*
    |--------------------------------------------------------------------------
    | Intercom Messenger Settings
    |--------------------------------------------------------------------------
    |
    | Customize the Intercom messenger appearance and behavior
    |
    */

    'messenger' => [
        'alignment' => env('INTERCOM_ALIGNMENT', 'right'), // 'left' or 'right'
        'horizontal_padding' => env('INTERCOM_HORIZONTAL_PADDING', 20),
        'vertical_padding' => env('INTERCOM_VERTICAL_PADDING', 20),
        'hide_default_launcher' => env('INTERCOM_HIDE_LAUNCHER', false),
    ],

];
