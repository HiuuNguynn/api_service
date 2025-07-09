<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
class StorePersonRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_id' => 'required|exists:users,id',
            'name' => 'required|string|max:20',
            'email' => 'required|email|unique:people,email',
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string|max:100',
        ];
    }
    public function messages()
    {
        return [
            'email.unique' => 'Email already exists',
            'email.required' => 'Please enter email.',
            'name.required' => 'Please enter name.',
        ];
    }
}
