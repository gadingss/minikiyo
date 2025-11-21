<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Midtrans Configuration
    |--------------------------------------------------------------------------
    |
    | Pastikan .env sudah memiliki MIDTRANS_SERVER_KEY & MIDTRANS_CLIENT_KEY
    |
    */

    'server_key' => env('MIDTRANS_SERVER_KEY'),
    'client_key' => env('MIDTRANS_CLIENT_KEY'),
    'is_production' => env('MIDTRANS_IS_PRODUCTION', false),

    // Optional settings
    'is_sanitized' => true,
    'is_3ds' => true,
];
