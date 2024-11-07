<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InterestRatesRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'rate_type' => 'required|string|in:FIXA,VARIAVEL',
            'valid_from' => 'required|date',
            'rate' => 'required|numeric',
            'reference' => 'required|string',
        ];
    }
}
