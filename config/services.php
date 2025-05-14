<?php

return [

    // ... other services ...

    'mpesa' => [
        'shortcode' => env('MPESA_SHORTCODE'),
        'passkey' => env('MPESA_PASSKEY'),
        'consumer_key' => env('MPESA_CONSUMER_KEY'),
        'consumer_secret' => env('MPESA_CONSUMER_SECRET'),
        'callback_url' => env('MPESA_CALLBACK_URL'),
    ],

];
