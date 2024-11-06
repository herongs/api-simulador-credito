<?php

namespace App\Repositories;

use App\DataTransferObjects\NewSimulationsDto;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Simulations;

interface SimulationsRepositoryInterface
{
    public function all(): Collection;

    public function find(int $id): ?Simulations;

    public function create(NewSimulationsDto $dto): Simulations;

    public function update(int $id, NewSimulationsDto $dto): Simulations;

    public function delete(int $id): bool;
}
