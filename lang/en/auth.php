<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during authentication for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */

    'failed' => 'These credentials do not match our records.',
    'password' => 'The provided password is incorrect.',
    'throttle' => 'Too many login attempts. Please try again in :seconds seconds.',
    'invalid_credentials' => 'Invalid credentials.',

    /*
    |--------------------------------------------------------------------------
    | Registration Validation Messages
    |--------------------------------------------------------------------------
    */

    'auth_type' => [
        'required' => 'Authentication type is required.',
        'in' => 'Authentication type must be one of: default, social, or otp.',
    ],
    'identifier' => [
        'required' => 'Email or Phone is required.',
        'string' => 'Email or Phone must be a valid string.',
        'max' => 'Email or Phone must not exceed 255 characters.',
    ],
    'otp_field' => [
        'required_if' => 'Please specify whether OTP should be sent to phone or email.',
        'in' => 'OTP field must be either phone or email.',
    ],
    'email' => [
        'required' => 'Email is required for this authentication type.',
        'required_without' => 'Either email or phone is required for default authentication.',
    ],
    'phone' => [
        'required' => 'Phone is required when OTP field is set to phone.',
        'required_without' => 'Either phone or email is required for default authentication.',
    ],
    'password_field' => [
        'required' => 'Password is required for default authentication.',
        'min' => 'Password must be at least 8 characters.',
        'confirmed' => 'Password confirmation does not match.',
    ],
    'provider' => [
        'required' => 'Provider is required for social authentication.',
    'provider_id' => [
        'required' => 'Provider ID is required for social authentication.',
    ],
    ],
    'otp' => [
        'required' => 'OTP code is required for OTP authentication.',
    ],

];
