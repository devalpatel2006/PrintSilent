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

    'printer_service' => [
        'base_url' => env('PRINTER_SERVICE_URL', 'http://127.0.0.1:8781'),
        'path' => env('PRINTER_SERVICE_PATH', '/GetPrinterData'),
        'timeout_seconds' => (int) env('PRINTER_SERVICE_TIMEOUT', 5),
    ],

    'playground' => [
        'url' => env('PLAYGROUND_TEST_URL', 'http://127.0.0.1:4545/status'),
        'api_key' => env('PLAYGROUND_API_KEY', 'as1231'),
        'timeout_seconds' => (int) env('PLAYGROUND_TEST_TIMEOUT', 10),
    ],

];
