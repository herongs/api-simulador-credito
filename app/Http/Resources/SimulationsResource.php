<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SimulationsResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'total_payment' => $this->total_payment,
            'monthly_payment' => $this->monthly_payment,
            'total_interest' => $this->total_interest,
        ];
    }
}
