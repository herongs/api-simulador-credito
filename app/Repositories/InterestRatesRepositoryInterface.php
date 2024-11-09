<?php

namespace App\Repositories;

use App\DataTransferObjects\InterestRatesDto;
use Illuminate\Database\Eloquent\Collection;
use App\Models\InterestRates;

interface InterestRatesRepositoryInterface
{
    public function all(): Collection;

    public function find(int $id): ?InterestRates;

    public function create(InterestRatesDto $dto): InterestRates;

    public function update(int $id, InterestRatesDto $dto): InterestRates;

    public function delete(int $id): bool;

    public function findSelicRateByDate(string $date): ?InterestRates;
}
