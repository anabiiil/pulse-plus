<?php

namespace App\Http\Requests\Vendor\Employee;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateEmployeeRequest extends FormRequest
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
        $employeeId = $this->route('employee');

        return [
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:vendors,email,' . $employeeId,
            'password' => 'nullable|string|min:6',
            'phone' => 'sometimes|required|string|max:20',
            'status' => 'nullable|boolean',
            'locale' => 'nullable|string|in:en,ar',
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
            'name.required' => 'The name field is required.',
            'name.max' => 'The name may not be greater than 255 characters.',
            'email.required' => 'The email field is required.',
            'email.email' => 'The email must be a valid email address.',
            'email.unique' => 'This email is already registered.',
            'password.min' => 'The password must be at least 6 characters.',
            'phone.required' => 'The phone field is required.',
            'phone.max' => 'The phone may not be greater than 20 characters.',
            'locale.in' => 'The locale must be either en or ar.',
        ];
    }
}

