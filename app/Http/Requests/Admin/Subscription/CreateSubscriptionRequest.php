<?php

namespace App\Http\Requests\Admin\Subscription;

use Illuminate\Foundation\Http\FormRequest;

class CreateSubscriptionRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:250',
            'months' => 'required|integer|min:1|max:120',
            'status' => 'nullable|in:0,1,true,false',
            'description' => 'nullable|string',
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'The subscription name is required.',
            'name.max' => 'The subscription name must not exceed 250 characters.',
            'months.required' => 'The number of months is required.',
            'months.integer' => 'The months must be a valid integer.',
            'months.min' => 'The months must be at least 1.',
            'months.max' => 'The months must not exceed 120.',
        ];
    }
}
