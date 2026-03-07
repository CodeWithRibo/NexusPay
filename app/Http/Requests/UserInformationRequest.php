<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserInformationRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'first_name' => ['required'],
            'last_name' => ['required'],
            'address' => ['required'],
            'birth_date' => ['required'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
