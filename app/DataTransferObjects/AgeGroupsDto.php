<?php

namespace App\DataTransferObjects;

use App\Http\Requests\AgeGroupsRequest;

class AgeGroupsDto
{
    public function __construct(
        public int $min_age,
        public int $max_age,
        public float $annual_interest_rate,
    ) {
    }

    public static function fromRequest(AgeGroupsRequest $request): self
    {
        return new self(
            min_age: $request->input('min_age'),
            max_age: $request->input('max_age'),
            annual_interest_rate: $request->input('annual_interest_rate'),
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'min_age' => $this->min_age,
            'max_age' => $this->max_age,
            'annual_interest_rate' => $this->annual_interest_rate,
        ], fn($value) => !is_null($value));
    }
}
