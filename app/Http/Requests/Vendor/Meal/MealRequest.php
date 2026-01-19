<?php

namespace App\Http\Requests\Vendor\Meal;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class MealRequest extends FormRequest
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
            'calories' => 'required|integer|min:0',
            'meal_type' => 'required|string|in:breakfast,lunch,dinner,snack',
            'protein_amount' => 'required|numeric|min:0',
            'carb_amount' => 'required|numeric|min:0',
            'fat_amount' => 'required|numeric|min:0',
            'price' => 'required|numeric|min:0',
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
            'calories.required' => 'The calories field is required.',
            'calories.integer' => 'The calories must be an integer.',
            'meal_type.required' => 'The meal type is required.',
            'meal_type.in' => 'The meal type must be one of: breakfast, lunch, dinner, snack.',
            'protein_amount.required' => 'The protein amount is required.',
            'carb_amount.required' => 'The carb amount is required.',
            'fat_amount.required' => 'The fat amount is required.',
            'price.required' => 'The price is required.',
        ];
    }
}

