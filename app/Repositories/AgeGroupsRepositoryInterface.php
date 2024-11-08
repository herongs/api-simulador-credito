<?php

namespace App\Repositories;

use App\DataTransferObjects\AgeGroupsDto;
use Illuminate\Database\Eloquent\Collection;
use App\Models\AgeGroups;

interface AgeGroupsRepositoryInterface
{
    public function all(): Collection;

    public function find(int $id): AgeGroups;

    public function findByAge(int $age): ?float;

    public function create(AgeGroupsDto $dto): AgeGroups;

    public function update(int $id, AgeGroupsDto $dto): AgeGroups;

    public function delete(int $id): bool;
}
