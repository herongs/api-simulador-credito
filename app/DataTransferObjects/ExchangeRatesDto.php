<?php

namespace App\DataTransferObjects;

use App\Http\Requests\ExchangeRatesRequest;

class ExchangeRatesDto
{
    public function __construct(
        public string $source_currency,
        public string $target_currency,
        public float $rate,
        public string $date,
    ) {}

    public static function fromRequest(ExchangeRatesRequest $request): self
    {
        return new self(
            source_currency: $request->input('source_currency'),
            target_currency: $request->input('target_currency'),
            rate: $request->input('rate'),
            date: $request->input('date'),
        );
    }

    public function toArray(): array
    {

        return array_filter([
            'source_currency' => $this->source_currency,
            'target_currency' => $this->target_currency,
            'rate' => $this->rate,
            'date' => $this->date,
        ], fn($value) => !is_null($value));
    }
}
