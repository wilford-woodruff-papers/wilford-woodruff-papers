<?php

return [

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'redirect' => env('GOOGLE_REDIRECT_URI'),
    ],

    'facebook' => [
        'client_id' => env('FACEBOOK_CLIENT_ID'),
        'client_secret' => env('FACEBOOK_CLIENT_SECRET'),
        'redirect' => env('FACEBOOK_REDIRECT_URI'),
    ],

    'constantcontact' => [
        'client_id' => env('CONSTANT_CONTACT_CLIENT_ID'),
        'client_secret' => env('CONSTANT_CONTACT_CLIENT_SECRET'),
        'redirect_uri' => env('CONSTANT_CONTACT_REDIRECT_URI'),
    ],

    'familysearch' => [
        'base_uri' => env('FAMILYSEARCH_BASE_URI'),
        'base_auth_uri' => env('FAMILYSEARCH_AUTH_BASE_URI'),
        'client_id' => env('FAMILYSEARCH_CLIENT_ID'),
        'client_secret' => env('FAMILYSEARCH_CLIENT_SECRET'),
        'redirect' => env('FAMILYSEARCH_REDIRECT_URI'),
        'delay' => env('FAMILYSEARCH_DELAY', 20),
    ],

    'api-ninja' => [
        'key' => env('API_NINJA_KEY'),
    ],

    'horizon' => [
        'secret' => env('HORIZON_SECRET'),
    ],

    'ftp' => [
        'secret' => env('FTP_SECRET'),
    ],

    'coudconvert' => [
        'api_key' => env('CLOUDCONVERT_API_KEY'),
    ],

];
