<?php

return [
    'use' => env('HORIZON_REDIS_CONNECTION', 'default'),
    'prefix' => env('HORIZON_PREFIX', 'horizon:'),

    'defaults' => [
        'supervisor' => [
            'connection' => 'redis',
            'queue' => [],
            'balance' => 'auto',
            'processes' => 0,
            'tries' => 0,
            'timeout' => 120,
        ],
    ],

    'environments' => [
        'production' => [],
        'local' => [],
    ],
];
