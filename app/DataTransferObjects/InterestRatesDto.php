<?php

namespace App\DataTransferObjects;

use App\Http\Requests\InterestRatesRequest;

class InterestRatesDto
{
    public function __construct(
        public float $rate,
        public string $rate_type,
        public ?string $reference,
        public ?string $valid_from,
    ) {
    }

    public static function fromRequest(InterestRatesRequest $request): self
    {
        return new self(
            rate: $request->input('rate'),
            rate_type: $request->input('rate_type'),
            reference: $request->input('reference'),
            valid_from: $request->input('valid_from'),
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'rate' => $this->rate,
            'rate_type' => $this->rate_type,
            'reference' => $this->reference,
            'valid_from' => $this->valid_from,
        ], fn($value) => !is_null($value));
    }
}
