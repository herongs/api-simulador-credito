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

    public function all(): Collection
    {
        return $this->model->all();
    }

    public function find(int $id): ?Simulations
    {
        return $this->model->find($id);
    }

    public function create(NewSimulationsDto $dto): Simulations
    {
        return $this->model->create($dto->toArray());
    }

    public function update(int $id, NewSimulationsDto $dto): Simulations
    {
        $record = $this->find($id);
        $record->update($dto->toArray());
        return $record;
    }

    public function delete(int $id): bool
    {
        return $this->model->destroy($id) > 0;
    }
}
