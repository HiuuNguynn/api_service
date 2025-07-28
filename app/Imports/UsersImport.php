<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UsersImport implements ToCollection, WithHeadingRow, WithValidation, SkipsEmptyRows
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            User::create([
                'name'     => $row['name'],
                'email'    => $row['email'],
                'department_id' => $row['department_id'],
                'password' => Hash::make($row['password']),
            ]);
        }
    }


public function rules(): array
{
    return [
        '*.name'     => 'required|string|max:255',
        '*.email'    => 'required|email:rfc,dns|unique:users,email|max:255|regex:/^[^@\s]+@amela\.vn$/i',
        '*.department_id' => 'required|exists:departments,id',
        '*.password' => 'required|string|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/',
    ];
}

    public function customValidationMessages()
    {
        return [
            '*.email.required' => 'Email is required',
            '*.email.regex'    => 'Email must be a valid amela.vn email address',
            '*.email.unique'   => 'Email already exists in the system',
            '*.password.regex' => 'Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character',
            '*.department_id.required' => 'Department ID is required',
            '*.department_id.exists' => 'Department ID does not exist',
        ];
    }

    public function validator()
    {
        return function($rows) {
            return Validator::make($rows->toArray(), $this->rules(), $this->customValidationMessages());
        };
    }
}


