<?php

namespace App\Http\Requests\Admin\Service;

use Illuminate\Foundation\Http\FormRequest;

class CreateServiceRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'name.en' => 'required|string|max:100',
            'name.ar' => 'required|string|max:100',
            'description.en' => 'nullable|string',
            'description.ar' => 'nullable|string',
            'status' => 'nullable|in:0,1,true,false',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
        ];
    }

    /**
     * Get custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'name.en.required' => 'The service name (English) is required.',
            'name.en.string' => 'The service name (English) must be a string.',
            'name.en.max' => 'The service name (English) must not exceed 100 characters.',
            'name.ar.required' => 'The service name (Arabic) is required.',
            'name.ar.string' => 'The service name (Arabic) must be a string.',
            'name.ar.max' => 'The service name (Arabic) must not exceed 100 characters.',
            'description.en.string' => 'The description (English) must be a string.',
            'description.ar.string' => 'The description (Arabic) must be a string.',
            'status.boolean' => 'The status must be a boolean value (true/false).',
            'image.image' => 'The image must be a valid image file.',
            'image.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif, webp.',
            'image.max' => 'The image must not exceed 10MB.',
        ];
    }
}
