<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Page Request
 *
 * Handles pagination and sorting parameters for list/index endpoints.
 *
 * @package App\Http\Requests
 */
class PageIndexRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
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
            'per_page' => 'sometimes|integer|min:1|max:100',
            'sorting_column' => 'sometimes|string|max:255',
            'sorting_direction' => 'sometimes|in:asc,desc',
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
            'per_page.integer' => 'Per page must be a valid number.',
            'per_page.min' => 'Per page must be at least 1.',
            'per_page.max' => 'Per page cannot exceed 100.',
            'sorting_direction.in' => 'Sorting direction must be either asc or desc.',
        ];
    }
}

