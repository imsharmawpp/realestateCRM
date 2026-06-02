<?php

return [
    'app' => [
        'name' => env('APP_NAME', 'Real Estate CRM'),
        'env' => env('APP_ENV', 'production'),
        'debug' => filter_var(env('APP_DEBUG', 'false'), FILTER_VALIDATE_BOOLEAN),
        'url' => rtrim(env('APP_URL', ''), '/'),
        'timezone' => env('APP_TIMEZONE', 'Asia/Kolkata'),
    ],
    'database' => [
        'host' => env('DB_HOST', 'localhost'),
        'port' => env('DB_PORT', '3306'),
        'database' => env('DB_DATABASE', ''),
        'username' => env('DB_USERNAME', ''),
        'password' => env('DB_PASSWORD', ''),
        'charset' => 'utf8mb4',
    ],
    'mail' => [
        'from_address' => env('MAIL_FROM_ADDRESS', 'no-reply@example.com'),
        'from_name' => env('MAIL_FROM_NAME', 'Real Estate CRM'),
    ],
    'integrations' => [
        'whatsapp_business_number' => env('WHATSAPP_BUSINESS_NUMBER', '919999999999'),
        'razorpay_key_id' => env('RAZORPAY_KEY_ID', ''),
        'razorpay_key_secret' => env('RAZORPAY_KEY_SECRET', ''),
    ],
];
