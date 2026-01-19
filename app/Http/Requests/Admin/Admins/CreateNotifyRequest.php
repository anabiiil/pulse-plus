<?php

namespace App\Http\Requests\Admin\Admins;

use App\Http\Requests\Admin\Main\BaseFormRequest;
use Illuminate\Contracts\Validation\ValidationRule;

class CreateNotifyRequest extends BaseFormRequest
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
            'title' => 'sometimes|array',
            'title.*' => 'required|string|min:2|max:200',
            'desc' => 'required|sometimes',
            'desc.*' => 'required|string|min:2|max:1000',
            'type' => 'required|in:schedule,immediately',
            'send_date' => 'sometimes|nullable|date',
            'users_ids' => 'sometimes|array|nullable',
            'send_all' => 'boolean',
            'timeZone' => 'string',
        ];
    }


}
