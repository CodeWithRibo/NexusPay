<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DepartmentRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'code' => ['required'],
            'name' => ['required'],
            'type' => ['required'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
