<?php

namespace App\Http\Requests\Admin\Main;

use App\Support\Traits\Api\ApiResponseTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Validator;

class BaseFormRequest extends FormRequest
{
    use ApiResponseTrait;

    protected function failedValidation(Validator|\Illuminate\Contracts\Validation\Validator $validator)
    {
        // Get all error messages
        $errors = $validator->errors()->messages();

        // Transform errors to get only the first error message for each field
        $firstErrors = collect($errors)->map(function ($messages) {
            return $messages[0]; // Get the first error message
        })->toArray();

        // Return the JSON response with the first errors
        throw new HttpResponseException($this->responseError($firstErrors, code: 422, msg: 'validation errors', key: 'errors'));
    }
}
