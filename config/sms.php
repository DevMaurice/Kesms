<?php

return [

    'default' => env('SMS_GATEWAY', 'at'),

    'gateways' => [
        'at' =>[
            'driver' => 'at',
            'username' => env('AT_USERNAME',''),
            'api_key' => env('AT_API_KEY','')
        ],

        'move' => [
            'driver' => 'move',
            'username' => env('MOVE_USERNAME', 'sandbox'),
            'apiKey' => env('MOVE_KEY', 'sandbox'),
            'sender' => env('MOVE_SENDER', 'sandbox'),
            'url' => env('MOVE_URL','https://sms.movesms.co.ke/api/compose')
        ],

        'robersms' => [
            'driver' => 'rober',
            'url' => env('ROBER_SMS_URL',''),
            'key' => env('ROBER_SMS_KEY','')
        ]
    ]

];
