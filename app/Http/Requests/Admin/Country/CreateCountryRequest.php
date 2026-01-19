<?php

namespace App\Http\Requests\Admin\Country;

use App\Http\Requests\Admin\Main\BaseFormRequest;
use Illuminate\Contracts\Validation\ValidationRule;

class CreateCountryRequest extends BaseFormRequest
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
            'name' => 'array|required|size:2',
            'name.en' => 'string|required|max:100',
            'name.ar' => 'string|required|max:100',
            'region' => 'array|sometimes|nullable',
            'subregion' => 'array|sometimes|nullable',
            'region.*' => 'string|sometimes|nullable|max:100',
            'subregion.*' => 'string|sometimes|nullable|max:100',
            'iso3' => 'required|nullable|max:3|min:3',
            'phone_code' => 'required|nullable|min:2',
            'status' => 'required|boolean',
        ];
    }


}
