<?php

return [

    'default' => env('DEFAULT_PAYMENT', 'psb'),
    'email' => env('PAYMENT_EMAIL'),

    'connections' => [
        'psb' => [
            'implementation' => App\Services\Payment\Implementation\PsbPayment::class,
            'baseurl' => env('PSB_URL'),
            'params' => [
                'TRTYPE' => 1,
                'MERCHANT' => env('PSB_MERCHANT'),
                'MERCH_NAME' => env('PSB_MERCH_NAME'),
                'TERMINAL' => env('PSB_TERMINAL')
            ]
        ],

    ]


];
