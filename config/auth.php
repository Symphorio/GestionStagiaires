<?php

return [
    'defaults' => [
        'guard' => 'web',
        'passwords' => 'users',
    ],

'guards' => [
    'web' => [
        'driver' => 'session',
        'provider' => 'users',
    ],

    'stagiaire' => [
        'driver' => 'session',
        'provider' => 'stagiaires',
    ],

    'sg' => [
        'driver' => 'session',
        'provider' => 'sgs',
    ],

    'srhds' => [
        'driver' => 'session',
        'provider' => 'srhdss',
    ],

    'dpaf' => [
        'driver' => 'session',
        'provider' => 'dpafs',
    ],

    'superviseur' => [
        'driver' => 'session',
        'provider' => 'superviseurs',
    ],
],

'providers' => [
    'users' => [
        'driver' => 'eloquent',
        'model' => App\Models\User::class,
    ],

    'stagiaires' => [
        'driver' => 'eloquent',
        'model' => App\Models\Stagiaire::class,
    ],

    'sgs' => [
        'driver' => 'eloquent',
        'model' => App\Models\Sg::class,
    ],

    'srhdss' => [
        'driver' => 'eloquent',
        'model' => App\Models\Srhds::class,
    ],

    'dpafs' => [
        'driver' => 'eloquent',
        'model' => App\Models\Dpaf::class,
    ],

    'superviseurs' => [
        'driver' => 'eloquent',
        'model' => App\Models\Superviseur::class,
    ],
],


    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],

        'stagiaires' => [
            'provider' => 'stagiaires',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => 10800,
];