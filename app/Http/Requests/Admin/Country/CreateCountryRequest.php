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
            'status' => 'required|boolean',
        ];
    }


}
