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
    'dpaf' => [
        'driver' => 'session',
        'provider' => 'dpafs',
    ],
    'tuteur' => [
        'driver' => 'session',
        'provider' => 'tuteurs',
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
    'dpafs' => [
        'driver' => 'eloquent',
        'model' => App\Models\Dpaf::class,
    ],
    'tuteurs' => [
        'driver' => 'eloquent',
        'model' => App\Models\Tuteur::class,
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