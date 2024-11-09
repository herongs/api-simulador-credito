<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExchangeRatesRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'source_currency' => 'required|string',
            'target_currency' => 'required|string',
            'rate' => 'required|numeric',
            'date' => 'required|date',
        ];
    }
}
