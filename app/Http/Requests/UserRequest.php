<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'student_id' => ['required', 'unique:users'],
            'email' => ['required', 'email', 'max:254', 'unique:users'],
            'password' => ['required'],
            'role' => ['required'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
