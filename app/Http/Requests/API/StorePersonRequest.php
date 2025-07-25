<?php

namespace App\Http\Requests\API;

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
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string|max:100',
        ];
    }
    public function messages()
    {
        return [
            'phone.max' => 'Phone must be less than 15 characters.',
            'address.max' => 'Address must be less than 100 characters.',
        ];
    }
}
