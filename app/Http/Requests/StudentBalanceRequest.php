<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentBalanceRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'fee_name' => ['required'],
            'total_amount' => ['required', 'decimal:2'],
            'paid_amount' => ['required', 'decimal:2'],
            'status' => ['required'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
