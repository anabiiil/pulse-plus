<?php

namespace App\Http\Controllers\Api\Website;

use App\Http\Controllers\Controller;
use App\Support\Traits\Api\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    use ApiResponseTrait;

    /**
     * Handle contact form submission.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'message' => 'required|string|max:1000',
        ]);

        if ($validator->fails()) {
            return $this->responseError(
                $validator->errors()->toArray(),
                code: 422,
                key: 'errors'
            );
        }

        $data = $validator->validated();

        // TODO: Store in database if you want to keep contact records
        // Contact::create($data);

        // TODO: Send email notification
        // Mail::to(config('mail.from.address'))->send(new ContactFormMail($data));

        return $this->responseData([
            'message' => 'Thank you for contacting us! We will get back to you soon.'
        ], 201);
    }
}
