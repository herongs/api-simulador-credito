<?php

namespace App\DataTransferObjects;

use App\Http\Requests\SimulationsRequest;


class SimulationsDto
{
    public function __construct(
        public string $loan_amount,
        public int $payment_date,
        public string $birth_date,
    ) {
    }

    public static function fromRequest(SimulationsRequest $request): self
    {
        return new self(
            loan_amount: $request->input('loan_amount'),
            payment_date: $request->input('payment_date'),
            birth_date: $request->input('birth_date'),
        );
    }



    public function toArray(): array
    {
        return array_filter([
            'loan_amount' => $this->loan_amount,
            'payment_date' => $this->payment_date,
            'birth_date' => $this->birth_date,
        ], fn($value) => !is_null($value));
    }
}
