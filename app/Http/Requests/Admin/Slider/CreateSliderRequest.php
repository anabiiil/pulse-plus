<?php

namespace App\Http\Requests\Admin\Slider;

use App\Http\Requests\Admin\Main\BaseFormRequest;
use Illuminate\Contracts\Validation\ValidationRule;

class CreateSliderRequest extends BaseFormRequest
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
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',

            'link' => 'sometimes|nullable|url'
        ];
    }


}
