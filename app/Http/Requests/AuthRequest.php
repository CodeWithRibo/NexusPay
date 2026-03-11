<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class AuthRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'student_id' => ['nullable', 'required_if:role,student', 'unique:users', 'regex:/^02000[0-9]{6}$/'],
            'department_id' => ['nullable', 'unique:departments'],
            'email' => ['required', 'email', 'unique:users', 'regex:/^[a-zA-Z0-9]+(?:[._-][a-zA-Z0-9]+)*@(?:[a-zA-Z0-9-]+\.)+[a-zA-Z]{2,}$/'],
            'role' => ['required'],
            'first_name' => ['required'],
            'last_name' => ['required'],
            'address' => ['required'],
            'phone_number' => ['nullable'],
            'birth_date' => ['required'],
        ];
    }
    public function messages(): array
    {
        return [
            'student_id.regex' => 'The number must start with 02000 and contain at least 11 digits',
            'student_id.required_if' => 'The student id field is required.'
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
