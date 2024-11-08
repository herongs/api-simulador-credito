<?php

namespace App\Repositories;

use App\DataTransferObjects\NewSimulationsDto;
use App\Models\Simulations;
use App\DataTransferObjects\SimulationsDto;
use Illuminate\Database\Eloquent\Collection;

class SimulationsRepository implements SimulationsRepositoryInterface
{
    public function __construct(
        protected Simulations $model
    ){
    }

    public function create(NewSimulationsDto $dto): Simulations
    {
        return $this->model->create($dto->toArray());
    }

}
