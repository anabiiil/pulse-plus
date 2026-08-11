<?php

namespace App\Http\Requests\Admin\Coupon;

use App\Support\Enums\Main\CouponTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class CouponRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $couponId = $this->route('coupon')?->id;

        return [
            'code' => [
                'required',
                'string',
                'max:100',
                Rule::unique('coupons', 'code')->ignore($couponId),
            ],
            'name' => 'nullable|string|max:255',
            'type' => ['required', new Enum(CouponTypeEnum::class)],
            'value' => 'required|numeric|min:0|max:9999999.99',
            'starts_at' => 'nullable|date',
            'expires_at' => 'nullable|date|after_or_equal:starts_at',
            'status' => 'nullable|in:0,1,true,false',
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
            'code.required' => 'The coupon code is required.',
            'code.unique' => 'This coupon code is already in use.',
            'type.required' => 'The coupon type is required.',
            'value.required' => 'The coupon value is required.',
            'value.numeric' => 'The coupon value must be a number.',
            'expires_at.after_or_equal' => 'The expiry date must be on or after the start date.',
        ];
    }
}
