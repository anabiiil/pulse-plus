<?php

namespace App\Http\Requests\Vendor\NutritionPlan;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class NutritionPlanRequest extends FormRequest
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
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,webp,gif|max:10240', // 10MB max
            'protein_percentage' => 'required|string',
            'carb_percentage' => 'required|string',
            'fats_percentage' => 'required|string',
            'is_active' => 'nullable|boolean',
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
            'title.required' => 'The title field is required.',
            'title.max' => 'The title may not be greater than 255 characters.',
            'image.image' => 'The file must be an image.',
            'image.mimes' => 'The image must be a file of type: jpeg, jpg, png, webp, gif.',
            'image.max' => 'The image size may not be greater than 10MB.',
            'protein_percentage.required' => 'The protein percentage is required.',
            'protein_percentage.regex' => 'The protein percentage must be in format: min-max (e.g., 10-20).',
            'carb_percentage.required' => 'The carb percentage is required.',
            'carb_percentage.regex' => 'The carb percentage must be in format: min-max (e.g., 20-40).',
            'fats_percentage.required' => 'The fats percentage is required.',
            'fats_percentage.regex' => 'The fats percentage must be in format: min-max (e.g., 15-20).',
        ];
    }
}

