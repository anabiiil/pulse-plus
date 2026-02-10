<?php

namespace App\Http\Requests\Admin\Setting;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateSettingRequest extends FormRequest
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
        $settingId = $this->route('setting')?->id;

        return [
            'title.en' => 'required|string|max:255',
            'title.ar' => 'required|string|max:255',
            'slug' => [
                'required',
                'string',
                'max:255',
                'alpha_dash',
            ],
            'content.en' => 'required|string',
            'content.ar' => 'required|string',
        ];
    }

    /**
     * Get custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'title.en.required' => 'The title (English) is required.',
            'title.en.string' => 'The title (English) must be a string.',
            'title.en.max' => 'The title (English) must not exceed 255 characters.',
            'title.ar.required' => 'The title (Arabic) is required.',
            'title.ar.string' => 'The title (Arabic) must be a string.',
            'title.ar.max' => 'The title (Arabic) must not exceed 255 characters.',
            'slug.required' => 'The slug is required.',
            'slug.string' => 'The slug must be a string.',
            'slug.max' => 'The slug must not exceed 255 characters.',
            'slug.alpha_dash' => 'The slug may only contain letters, numbers, dashes and underscores.',
            'slug.unique' => 'This slug has already been taken.',
            'content.en.required' => 'The content (English) is required.',
            'content.en.string' => 'The content (English) must be a string.',
            'content.ar.required' => 'The content (Arabic) is required.',
            'content.ar.string' => 'The content (Arabic) must be a string.',
        ];
    }
}

