<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ExchangeRatesResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'source_currency' => $this->source_currency,
            'target_currency' => $this->target_currency,
            'rate' => $this->rate,
            'date' => $this->date,
        ];
    }
}
