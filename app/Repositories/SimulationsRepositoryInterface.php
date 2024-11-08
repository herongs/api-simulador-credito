<?php

namespace App\Repositories;

use App\DataTransferObjects\NewSimulationsDto;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Simulations;

interface SimulationsRepositoryInterface
{
    public function create(NewSimulationsDto $dto): Simulations;
}
