<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InterestRatesResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'rate' => $this->rate,
            'rate_type' => $this->rate_type,
            'reference' => $this->reference,
            'valid_from' => $this->valid_from,
        ];
    }
}
