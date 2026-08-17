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
     * Normalize the phone number before validation (strip spaces and dashes).
     */
    protected function prepareForValidation(): void
    {
        if ($this->has('customer_phone')) {
            $this->merge([
                'customer_phone' => preg_replace('/[\s\-]+/', '', (string) $this->input('customer_phone')),
            ]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'customer_name' => 'required|string|max:255',
            // Egyptian mobile: optional +20/0020 or leading 0, then 1[0125] + 8 digits
            'customer_phone' => ['required', 'string', 'regex:/^(?:\+?20|0)1[0125]\d{8}$/'],
            'governorate_id' => 'required|integer|exists:governorates,id',
            'payment_method_id' => 'required|integer|exists:payment_methods,id',
            'address' => 'required|string|max:1000',
            'notes' => 'nullable|string|max:1000',
            'coupon_code' => 'nullable|string|max:100',
            'receipt' => 'nullable|file|mimes:jpeg,png,jpg,webp,pdf|max:10240',
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
            'customer_phone.regex' => __('messages.invalid_egyptian_phone'),
        ];
    }
}
