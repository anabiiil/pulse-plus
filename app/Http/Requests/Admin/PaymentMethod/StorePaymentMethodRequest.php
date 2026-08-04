<?php

namespace App\Http\Requests\Admin\PaymentMethod;

use App\Http\Requests\Admin\Main\BaseFormRequest;

class StorePaymentMethodRequest extends BaseFormRequest
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
        return [
            'name' => 'required|array|size:2',
            'name.en' => 'required|string|max:100',
            'name.ar' => 'required|string|max:100',
            'description' => 'nullable|array',
            'description.en' => 'nullable|string|max:1000',
            'description.ar' => 'nullable|string|max:1000',
            'is_active' => 'nullable|in:0,1,true,false',
            'requires_receipt' => 'nullable|in:0,1,true,false',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:10240',
        ];
    }
}
