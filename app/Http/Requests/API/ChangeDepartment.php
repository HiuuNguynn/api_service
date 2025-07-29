<?php 
namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class ChangeDepartment extends FormRequest
{
    public function rules()
    {
        return [
            'id' => 'required|exists:users,id',
            'department_id' => 'required|exists:departments,id',
        ];
    }

    public function messages()
    {
        return [
            'id.required' => 'User ID is required',
            'id.exists' => 'User ID does not exist',
            'department_id.required' => 'Department ID is required',
            'department_id.exists' => 'Department ID does not exist',
        ];
    }
}