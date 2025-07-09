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
            'old_password.required' => 'Mật khẩu cũ là bắt buộc',
            'new_password.required' => 'Mật khẩu mới là bắt buộc',
            'new_password.min' => 'Mật khẩu mới phải có ít nhất 6 ký tự',
            'new_password.confirmed' => 'Mật khẩu mới không khớp',
        ];
    }
}