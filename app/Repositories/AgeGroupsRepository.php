<?php

namespace App\Repositories;

use App\Models\AgeGroups;
use App\DataTransferObjects\AgeGroupsDto;
use Illuminate\Database\Eloquent\Collection;

class AgeGroupsRepository implements AgeGroupsRepositoryInterface
{
    public function __construct(
        protected AgeGroups $model
    ) {}

    public function all(): Collection
    {
        return $this->model->all();
    }

    public function find(int $id): AgeGroups
    {
        return $this->model->find($id);
    }

    public function findByAge(int $age): float
    {
        return $this->model->where('min_age', '<=', $age)
            ->where('max_age', '>=', $age)
            ->first()->annual_interest_rate;
    }

    public function create(AgeGroupsDto $dto): AgeGroups
    {
        return $this->model->create($dto->toArray());
    }

    public function update(int $id, AgeGroupsDto $dto): AgeGroups
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
