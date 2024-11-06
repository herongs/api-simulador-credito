<?php

namespace App\Services;

use App\Repositories\AgeGroupsRepositoryInterface;
use App\DataTransferObjects\AgeGroupsDto;
use Illuminate\Database\Eloquent\Collection;
use App\Models\AgeGroups;

class AgeGroupsService
{
    public function __construct(
        protected AgeGroupsRepositoryInterface $repository
    ){
    }

    public function getAllItems(): Collection
    {
        return $this->repository->all();
    }

    public function getItem(int $id): ?AgeGroups
    {
        return $this->repository->find($id);
    }

    public function createItem(AgeGroupsDto $dto): AgeGroups
    {
        return $this->repository->create($dto);
    }

    public function updateItem(AgeGroupsDto $dto, int $id): AgeGroups
    {
        return $this->repository->update($id, $dto);
    }

    public function deleteItem(int $id): bool
    {
        return $this->repository->delete($id);
    }
}
