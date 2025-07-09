<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class EmailRequest extends FormRequest
{
    public function rules()
    {
        return [
            'email' => 'required|email',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Email là bắt buộc',
            'email.email' => 'Email không hợp lệ',
        ];
    }
}