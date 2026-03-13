<?php

namespace App\Http\Requests\Website;

use Illuminate\Foundation\Http\FormRequest;

class SyncDiseasesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth('web')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'disease_ids' => ['present', 'array'],
            'disease_ids.*' => ['integer', 'exists:diseases,id'],
        ];
    }

    /**
     * Get custom messages for validation errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'disease_ids.present' => 'The disease_ids field is required.',
            'disease_ids.array' => 'The disease_ids must be an array.',
            'disease_ids.*.exists' => 'One or more selected diseases do not exist.',
        ];
    }
}
