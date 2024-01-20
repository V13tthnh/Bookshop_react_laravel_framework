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

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'google' => [
        'client_id' => '620486827681-2tq8r5mfe51sqsgkcbb1o90ocqv3rgjo.apps.googleusercontent.com',
        'client_secret' => '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',
        'redirect' => 'http://localhost:3000/auth/google/callback',
    ],

    'facebook' => [
        'client_id' => '1394067511470646',
        'client_secret' => '6ceeb3f5171664f5e6ab207dfb218626',
        'redirect' => 'http://localhost:3000/facebook/callback',
    ]

];
