<?php

namespace App\Http\Requests\Admin\Slider;

use Illuminate\Foundation\Http\FormRequest;

class CreateSliderRequest extends FormRequest
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
            'title.en' => 'nullable|string|max:255',
            'title.ar' => 'nullable|string|max:255',
            'desc.en' => 'nullable|string',
            'desc.ar' => 'nullable|string',
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
            'title.en.string' => 'The title (English) must be a string.',
            'title.en.max' => 'The title (English) must not exceed 255 characters.',
            'title.ar.string' => 'The title (Arabic) must be a string.',
            'title.ar.max' => 'The title (Arabic) must not exceed 255 characters.',
            'desc.en.string' => 'The description (English) must be a string.',
            'desc.ar.string' => 'The description (Arabic) must be a string.',
            'status.boolean' => 'The status must be a boolean value (true/false).',
            'image.image' => 'The image must be a valid image file.',
            'image.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif, webp.',
            'image.max' => 'The image must not exceed 10MB.',
        ];
    }
}
