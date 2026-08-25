<?php

namespace App\Http\Requests\Website;

use App\Support\Enums\MedicalFile\MedicalFileCategoryEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreMedicalFileRequest extends FormRequest
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
        $isUpdate = $this->isMethod('PUT') || $this->isMethod('PATCH');

        return [
            'title' => $isUpdate ? 'sometimes|required|string|max:255' : 'required|string|max:255',
            'category' => ['sometimes', 'required', Rule::enum(MedicalFileCategoryEnum::class)],
            // A record can hold a group of files. `file` (single) is still accepted
            // for backward compatibility.
            'files' => 'nullable|array',
            'files.*' => 'file|mimes:jpeg,png,jpg,gif,pdf|max:5120',
            'file' => 'nullable|file|mimes:jpeg,png,jpg,gif,pdf|max:5120',
            'remove_attachment_ids' => 'nullable|array',
            'remove_attachment_ids.*' => 'integer',
            'doctor' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'The document title is required.',
            'category.required' => 'The category is required.',
            'files.*.mimes' => 'Each file must be a jpeg, png, jpg, gif, or pdf.',
            'files.*.max' => 'Each file may not be larger than 5MB.',
            'file.mimes' => 'The file must be a jpeg, png, jpg, gif, or pdf.',
            'file.max' => 'The file may not be larger than 5MB.',
        ];
    }
}
