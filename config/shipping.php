<?php

return [
    'shipping_origin_code' => env('SHIPPING_ORIGIN_CODE', '32.75.03.1001'),
    'api_kurir' => [
        'username' => env('API_KURIR_USERNAME'),
        'password' => env('API_KURIR_PASSWORD'),
        'token' => env('API_KURIR_TOKEN'),
    ]
];
