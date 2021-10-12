<?php

namespace App\Modules\Contact\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'fullname' => 'required|between:3,64|regex:/^[0-9a-zA-z ]+$/',
            'company'  => 'nullable|max:64|regex:/^[0-9a-zA-z ]+$/',
            'email'    => 'required|email|max:254',
            'reason'   => 'required|max:254|regex:/^[0-9a-zA-z,. ]+$/',
            'message'  => 'required|between:10,2048|regex:/^[0-9a-zA-z,. ]+$/',
        ];
    }

    public function messages(): array
    {
        return [
            '*.regex'           => 'Invalid characters.',
            'fullname.required' => 'Please enter your fullname.',
            'email.required'    => 'Please enter your email address.',
            'reason.required'   => 'Please enter your reason for contact.',
            'message.required'  => 'Please enter your message.',
        ];
    }
}
