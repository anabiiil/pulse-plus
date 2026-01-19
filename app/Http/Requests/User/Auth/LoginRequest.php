<?php

namespace App\Http\Requests\User\Auth;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Login Request
 *
 * Handles validation for user login.
 *
 * @package App\Http\Requests\User\Auth
 */
class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return array_merge(
            $this->baseRules(),
            $this->authTypeRules()
        );
    }

    /**
     * Get base validation rules.
     *
     * @return array<string, ValidationRule|array|string>
     */
    protected function baseRules(): array
    {
        return [
            'auth_type' => 'required|string|in:default,social,otp',
        ];
    }

    /**
     * Get conditional validation rules based on auth_type.
     *
     * @return array<string, ValidationRule|array|string>
     */
    protected function authTypeRules(): array
    {
        return match ($this->input('auth_type')) {
            'default' => $this->defaultAuthRules(),
            'social' => $this->socialAuthRules(),
            'otp' => $this->otpAuthRules(),
            default => [],
        };
    }

    /**
     * Get validation rules for default authentication (credentials).
     *
     * @return array<string, string>
     */
    protected function defaultAuthRules(): array
    {
        return [
            'email' => 'required_without:phone|string|email|max:255',
            'phone' => 'required_without:email|string|max:20',
            'password' => 'required|string|min:8',
        ];
    }

    /**
     * Get validation rules for social authentication.
     *
     * @return array<string, string>
     */
    protected function socialAuthRules(): array
    {
        return [
            'provider' => 'required|string|in:google,facebook,apple',
            'provider_id' => 'required|string',
            'provider_token' => 'required|string',
        ];
    }

    /**
     * Get validation rules for OTP authentication.
     *
     * @return array<string, string>
     */
    protected function otpAuthRules(): array
    {
        return [
            'otp' => 'required|string|min:4|max:10',
            'otp_field' => 'required|string|in:phone,email',
            'phone' => 'required_if:otp_field,phone|string|max:20',
            'email' => 'required_if:otp_field,email|string|email|max:255',
        ];
    }

    /**
     * Get custom validation messages.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'auth_type.required' => __('auth.auth_type.required'),
            'auth_type.in' => __('auth.auth_type.in'),
            'otp_field.required' => __('auth.otp_field.required'),
            'otp_field.in' => __('auth.otp_field.in'),
            'email.required_without' => __('auth.email.required_without'),
            'phone.required_without' => __('auth.phone.required_without'),
            'email.required_if' => __('auth.email.required_if'),
            'phone.required_if' => __('auth.phone.required_if'),
            'password.required' => __('auth.password_field.required'),
            'password.min' => __('auth.password_field.min'),
            'provider.required' => __('auth.provider.required'),
            'provider.in' => __('auth.provider.in'),
            'provider_id.required' => __('auth.provider_id.required'),
            'provider_token.required' => __('auth.provider_token.required'),
            'otp.required' => __('auth.otp.required'),
            'otp.min' => __('auth.otp.min'),
            'otp.max' => __('auth.otp.max'),
        ];
    }
}


