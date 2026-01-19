<?php

namespace App\Http\Requests\Admin\Auth;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Login Request
 *
 * Handles validation for admin login.
 *
 * @package App\Http\Requests\Admin\Auth
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
        return [
            'identifier' => 'required|string|max:255',
            'password' => 'required|nullable|string|min:6',
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
            'identifier.required' => __('auth.identifier.required'),
            'identifier.string' => __('auth.identifier.string'),
            'identifier.max' => __('auth.identifier.max'),
            'password.required' => __('auth.password_field.required'),
            'password.min' => __('auth.password_field.min'),
        ];
    }
}

