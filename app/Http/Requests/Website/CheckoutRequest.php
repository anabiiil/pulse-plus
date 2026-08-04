<?php

namespace App\Http\Requests\Website;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
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
     * @return array<string, string>
     */
    public function rules(): array
    {
        return [
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:30',
            'governorate_id' => 'required|integer|exists:governorates,id',
            'payment_method_id' => 'required|integer|exists:payment_methods,id',
            'address' => 'required|string|max:1000',
            'notes' => 'nullable|string|max:1000',
            'receipt' => 'nullable|file|mimes:jpeg,png,jpg,webp,pdf|max:10240',
        ];
    }
}
