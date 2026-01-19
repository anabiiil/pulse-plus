<?php

return [

    /*
    |--------------------------------------------------------------------------
    | OTP Type
    |--------------------------------------------------------------------------
    |
    | This value determines the type of OTP to generate.
    | Supported: "numeric", "alphanumeric"
    |
    */

    'type' => env('OTP_TYPE', 'numeric'),

    /*
    |--------------------------------------------------------------------------
    | OTP Length
    |--------------------------------------------------------------------------
    |
    | The number of characters/digits in the OTP code.
    |
    */

    'length' => env('OTP_LENGTH', 6),

    /*
    |--------------------------------------------------------------------------
    | OTP Expiry Time
    |--------------------------------------------------------------------------
    |
    | The time in minutes before an OTP expires.
    |
    */

    'expiry_minutes' => env('OTP_EXPIRY_MINUTES', 10),

    /*
    |--------------------------------------------------------------------------
    | Maximum Verification Attempts
    |--------------------------------------------------------------------------
    |
    | The maximum number of failed verification attempts allowed.
    |
    */

    'max_attempts' => env('OTP_MAX_ATTEMPTS', 3),

    /*
    |--------------------------------------------------------------------------
    | Hashed Mode
    |--------------------------------------------------------------------------
    |
    | When true, OTPs will be hashed before storage for security.
    | When false, OTPs will be stored in plain text (standard mode).
    |
    */

    'hashed' => env('OTP_HASHED', true),

    /*
    |--------------------------------------------------------------------------
    | Hash Algorithm
    |--------------------------------------------------------------------------
    |
    | The hashing algorithm to use when hashed mode is enabled.
    | Uses Laravel's Hash facade (bcrypt/argon2).
    |
    */

    'hash_algo' => env('OTP_HASH_ALGO', 'bcrypt'),

];
