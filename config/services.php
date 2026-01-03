<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'cpanel' => [
        'url' => env('CPANEL_URL'),
        'username' => env('CPANEL_USERNAME'),
        'password' => env('CPANEL_PASSWORD'),
        'api_token' => env('CPANEL_API_TOKEN'),
    ],

    'dynadot' => [
        'api_key' => env('DYNADOT_API_KEY'),
        'secret_key' => env('DYNADOT_SECRET_KEY'),
        'sandbox' => env('DYNADOT_SANDBOX', false),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'hetzner' => [
        'api_token' => env('HETZNER_API_TOKEN'),
    ],

    'cloudflare' => [
        'api_key' => env('CLOUDFLARE_API_KEY'),
        'email' => env('CLOUDFLARE_EMAIL'),
    ],

    'turnstile' => [
        'site_key' => env('TURNSTILE_SITE_KEY', '1x00000000000000000000AA'), // Test key that always passes
        'secret_key' => env('TURNSTILE_SECRET_KEY', '1x0000000000000000000000000000000AA'), // Test secret key
    ],

    'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'redirect' => env('GOOGLE_REDIRECT_URL', env('APP_URL').'/auth/google/callback'),
    ],

    'github' => [
        'client_id' => env('GITHUB_CLIENT_ID'),
        'client_secret' => env('GITHUB_CLIENT_SECRET'),
        'redirect' => env('GITHUB_REDIRECT_URL', env('APP_URL').'/auth/github/callback'),
    ],

    'linkedin-openid' => [
        'client_id' => env('LINKEDIN_CLIENT_ID'),
        'client_secret' => env('LINKEDIN_CLIENT_SECRET'),
        'redirect' => env('LINKEDIN_REDIRECT_URL', env('APP_URL').'/auth/linkedin/callback'),
    ],

    'fawaterak' => [
        'url' => env('FAWATERAK_API_URL', 'https://staging.fawaterk.com'),
        'token' => env('FAWATERAK_API_KEY'),
        'enabled' => env('FAWATERAK_ENABLED', true),
    ],

];
