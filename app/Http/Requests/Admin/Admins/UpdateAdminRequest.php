<?php

namespace App\Http\Requests\Admin\Admins;

use App\Http\Requests\Admin\Main\BaseFormRequest;
use Illuminate\Contracts\Validation\ValidationRule;

class UpdateAdminRequest extends BaseFormRequest
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
            'name' => 'required|string|min:2|max:200',
            'email' => 'required|email|unique:admins,email,'.request()->id,
            'password' => 'sometimes|nullable|string|min:6|confirmed',
        ];
    }


}
