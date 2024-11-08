<?php

namespace App\Repositories;

use App\DataTransferObjects\ExchangeRatesDto;
use Illuminate\Database\Eloquent\Collection;
use App\Models\ExchangeRates;

interface ExchangeRatesRepositoryInterface
{
    public function all(): Collection;

    public function find(int $id): ?ExchangeRates;

    public function create(ExchangeRatesDto $dto): ExchangeRates;

    public function update(int $id, ExchangeRatesDto $dto): ExchangeRates;

    public function delete(int $id): bool;

    public function getExchangeRate(string $targetCurrency): ?ExchangeRates;
}
