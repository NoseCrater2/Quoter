<?php
/**
 * PayPal Setting & API Credentials
 * Created by Raza Mehdi <srmk@outlook.com>.
 */

return [
    'mode'    => env('NETPAY_MODE', 'sandbox'), // Can only be 'sandbox' Or 'live'. If empty or invalid, 'live' will be used.
    'sandbox' => [
        'secret_key'    => env('NETPAY_SECRET_KEY_SBOX'),
        'public_key'    => env('MIX_NETPAY_PUBLIC_KEY_SBOX'),
        'base_url'      => env('NETPAY_BASE_URL_SBOX'),
    ],
    'live' => [
        'secret_key'    => env('NETPAY_SECRET_KEY_PROD'),
        'public_key'    => env('MIX_NETPAY_PUBLIC_KEY_PROD'),
        'base_url'      => env('NETPAY_BASE_URL_PROD'),
    ],
];
