<?php

namespace App\Http\Requests\Website;

use App\Support\Enums\User\BloodTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMedicalInfoRequest extends FormRequest
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
            'blood_type' => ['nullable', Rule::enum(BloodTypeEnum::class)],
            'emergency_phone' => ['nullable', 'string', 'max:20'],
            'display_emergency' => ['nullable', 'boolean'],
            'display_medical_profile' => ['nullable', 'boolean'],
            'display_medical_archive' => ['nullable', 'boolean'],
            'display_medical_profile' => ['nullable', 'boolean'],
            'notes' => ['nullable', 'string', 'max:1000'],
            'disease_ids' => ['nullable', 'array'],
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
            'blood_type.enum' => 'Invalid blood type. Accepted values: '.implode(', ', BloodTypeEnum::values()),
            'disease_ids.array' => 'The disease_ids must be an array.',
            'disease_ids.*.exists' => 'One or more selected diseases do not exist.',
        ];
    }
}
