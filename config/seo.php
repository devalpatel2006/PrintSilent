<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Site Identity
    |--------------------------------------------------------------------------
    */

    'site_name' => env('APP_NAME', 'PrintSilently'),

    'title_separator' => '—',

    'default_title' => 'Silent Printing for Modern Businesses',

    'default_description' => 'PrintSilently connects cloud apps to local printers with secure silent background printing. The best QZ Tray alternative for thermal labels, ZPL, ESC/POS, and browser-based printing.',

    /*
    |--------------------------------------------------------------------------
    | Default Open Graph Image
    |--------------------------------------------------------------------------
    */

    'og_image' => '/images/og-default.jpg',

    /*
    |--------------------------------------------------------------------------
    | Social Handles
    |--------------------------------------------------------------------------
    */

    'twitter_handle' => '@printsilently',

    'twitter_card_type' => 'summary_large_image',

    /*
    |--------------------------------------------------------------------------
    | Organization Schema
    |--------------------------------------------------------------------------
    */

    'organization' => [
        'name'        => 'PrintSilently',
        'legal_name'  => 'PrintSilently',
        'url'         => env('APP_URL', 'https://printsilently.com'),
        'logo'        => '/images/logo.jpg',
        'email'       => 'hello@printsilently.com',
        'description' => 'PrintSilently is an enterprise-grade silent printing platform that bridges cloud applications with local printers. A modern alternative to QZ Tray for browser-based printing, thermal labels, ZPL, and ESC/POS.',
        'same_as'     => [
            // Add social profile URLs here
            // 'https://twitter.com/printsilently',
            // 'https://github.com/printsilently',
            // 'https://www.linkedin.com/company/printsilently',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Software Application Schema
    |--------------------------------------------------------------------------
    */

    'software' => [
        'name'                => 'PrintSilently',
        'application_category' => 'BusinessApplication',
        'operating_system'    => 'Windows, macOS',
        'offers'              => [
            'price'    => '0',
            'currency' => 'USD',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Target Keywords (used for internal reference & meta generation)
    |--------------------------------------------------------------------------
    */

    'keywords' => [
        'silent printing',
        'browser printing',
        'thermal label printing',
        'QZ Tray alternative',
        'browser print API',
        'Zebra printer',
        'ZPL printing',
        'ESC/POS printing',
        'barcode printing',
        'cloud printing',
        'shipping label printing',
        'silent print software',
        'print without dialog',
        'receipt printing',
        'label printer software',
    ],

];
