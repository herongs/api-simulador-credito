<?php

namespace App\DataTransferObjects;

use App\Http\Requests\SimulationsRequest;


class NewSimulationsDto
{
    public function __construct(
        public string $loan_amount,
        public int $payment_date,
        public string $birth_date,
        public float $interest_rate,
        public string $interest_type,
        public float $total_amount,
        public float $total_payment,
        public float $monthly_payment,
        public float $total_interest,
        public ?string $currency,
    ) {
    }

    public static function fromRequest(SimulationsRequest $request): self
    {
        return new self(
            loan_amount: $request->input('loan_amount'),
            payment_date: $request->input('payment_date'),
            birth_date: $request->input('birth_date'),
            interest_rate: $request->input('interest_rate'),
            interest_type: $request->input('interest_type'),
            total_amount: $request->input('total_amount'),
            total_payment: $request->input('total_payment'),
            monthly_payment: $request->input('monthly_payment'),
            total_interest: $request->input('total_interest'),
            currency: $request->input('currency') ?? 'BRL',
        );
    }



    public function toArray(): array
    {
        return array_filter([
            'loan_amount' => $this->loan_amount,
            'payment_date' => $this->payment_date,
            'birth_date' => $this->birth_date,
            'interest_rate' => $this->interest_rate,
            'interest_type' => $this->interest_type,
            'total_amount' => $this->total_amount,
            'total_payment' => $this->total_payment,
            'monthly_payment' => $this->monthly_payment,
            'total_interest' => $this->total_interest,
            'currency' => $this->currency,
        ], fn($value) => !is_null($value));
    }
}
