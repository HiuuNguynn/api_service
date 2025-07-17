<?php 
namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class ChangePassWord extends FormRequest
{
    public function rules()
    {
        return [
            'old_password' => 'required',
            'new_password' => 'required|string|min:6|confirmed',
        ];
    }

    public function messages()
    {
        return [
            'old_password.required' => 'Old password is required',
            'new_password.required' => 'New password is required',
            'new_password.min' => 'New password must be at least 6 characters',
            'new_password.confirmed' => 'New password confirmation does not match',
        ];
    }
}