<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class ImportFile extends FormRequest
{
    public function rules()
    {
        return [
            'file' => 'required|file|mimes:xlsx,xls,csv',
        ];
    }

    public function messages()
    {
        return [
            'file.required' => 'File is required',
            'file.file' => 'File must be a file',
            'file.mimes' => 'File must be a valid file type',
        ];
    }
}