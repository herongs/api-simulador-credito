<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class SimulationsRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'loan_amount' => 'required|numeric',
            'payment_date' => 'required|integer',
            'birth_date' => 'required|date|date_format:Y-m-d',
            'interest_type' => 'string',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();

        throw new HttpResponseException(response()->json([
            'status' => 'Falha na validação',
            'errors' => $errors,
        ], 422));
    }
}
