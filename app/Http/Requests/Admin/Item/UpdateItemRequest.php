<?php

namespace App\Http\Requests\Admin\Item;

use Illuminate\Foundation\Http\FormRequest;

class UpdateItemRequest extends FormRequest
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
            'name' => 'nullable|string|max:255',
            'status' => 'nullable|in:0,1,true,false',
        ];
    }

    public function messages(): array
    {
        return [
            'name.string' => 'The item name must be a string.',
            'name.max' => 'The item name must not exceed 255 characters.',
            'status.in' => 'The status must be a boolean value (true/false).',
        ];
    }
}
