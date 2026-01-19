<?php

namespace App\Http\Requests\User\Auth;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
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
        return [
            'name' => ['required', 'string', 'max:255'],
            'auth_type' => ['required', 'string', 'in:basic,otp'],
            'email' => [
                'required_without:phone',
                'string',
                'email',
                'max:255',
                'unique:users,email',
            ],
            'phone' => [
                'nullable',
                'required_without:email',
                'string',
                'max:20',
                'unique:users,phone',
            ],
            'password' => [
                'required_if:auth_type,basic',
                'string',
                'min:8',
                'confirmed',
            ],
            'otp' => [
                'required_if:auth_type,otp',
                'string',
                'size:6',
            ],
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
            'name.required' => __('auth.name.required'),
            'email.required_without' => __('auth.email.required_without'),
            'email.email' => __('auth.email.email'),
            'email.unique' => __('auth.email.unique'),
            'phone.required_without' => __('auth.phone.required_without'),
            'phone.unique' => __('auth.phone.unique'),
            'password.required_if' => __('auth.password.required_if'),
            'password.min' => __('auth.password.min'),
            'password.confirmed' => __('auth.password.confirmed'),
            'otp.required_if' => __('auth.otp.required_if'),
            'otp.size' => __('auth.otp.size'),
        ];
    }
}
