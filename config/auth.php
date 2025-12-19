<?php

return [

    'defaults' => [
        'guard' => 'web',
        'passwords' => 'operators',
    ],

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'operators',
        ],
    ],

    'providers' => [
        'operators' => [
            'driver' => 'eloquent',
            'model' => App\Models\Operator::class,
        ],
    ],

    'passwords' => [
        'operators' => [
            'provider' => 'operators',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => 10800,
];