<?php
namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class SetRole extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'users' => 'required|array',
            'users.*.id' => 'required|exists:users,id',
            'users.*.role' => 'required|in:admin_head,admin,manager,user',
        ];
    }


    public function messages()
    {
        return [
            'users.required' => 'Users are required',
            'users.array' => 'Users must be an array',
            'users.*.id.required' => 'User ID is required',
            'users.*.id.exists' => 'User not found',
            'users.*.role.required' => 'Role is required',
            'users.*.role.in' => 'Invalid role',
        ];
    }
}