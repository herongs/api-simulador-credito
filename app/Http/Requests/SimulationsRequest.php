<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SimulationsRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'loan_amount' => 'required|numeric',
            'payment_date' => 'required|integer',
            'birth_date' => 'required|date',
            'interest_type' => 'string',
        ];
    }
}
