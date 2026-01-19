<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Strategies
    |--------------------------------------------------------------------------
    |
    | Here you may configure the authentication strategies for your application.
    | Each strategy is mapped to its corresponding authenticator class.
    | You can add or remove strategies as needed.
    |
    */
    'guards' => [
        'admin' => [
            'model' => \App\Models\Admin::class,
        ],
        'user' => [
            'model' => \App\Models\User::class,
        ],
        'vendor' => [
            'model' => \App\Models\Vendor::class,
        ],

        // Add more guards here
    ],
    'methods' => [
        'authenticate' => [
            'basic' => \App\Services\Auth\Strategies\Authenticate\BasicAuthenticateStrategy::class,
            'social' => \App\Services\Auth\Strategies\Authenticate\SocialAuthenticateStrategy::class,
            'otp' => \App\Services\Auth\Strategies\Authenticate\OtpAuthenticateStrategy::class
        ],
        'registration' => [
            'basic' => \App\Services\Auth\Strategies\Register\BasicRegistrationStrategy::class,
            'otp' => \App\Services\Auth\Strategies\Register\OtpRegistrationStrategy::class,
        ],

        // Add more authenticators here
        // 'biometric' => \App\Services\Auth\Authenticator\BiometricAuthenticator::class,
        // 'sso' => \App\Services\Auth\Authenticator\SsoAuthenticator::class,
        // 'magic_link' => \App\Services\Auth\Authenticator\MagicLinkAuthenticator::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Default Authentication Strategy
    |--------------------------------------------------------------------------
    |
    | This option controls the default authentication strategy that will be
    | used when no specific strategy is provided.
    |
    */

    'default' => env('AUTH_STRATEGY', 'basic'),
    'authenticate_by' => env('AUTHENTICATE_BY', 'email'), // 'email', 'username', 'phone'

];
