<?php

namespace App\Repositories;

use App\Models\ExchangeRates;
use App\DataTransferObjects\ExchangeRatesDto;
use Illuminate\Database\Eloquent\Collection;

class ExchangeRatesRepository implements ExchangeRatesRepositoryInterface
{
    public function __construct(
        protected ExchangeRates $model
    ) {}

    public function all(): Collection
    {
        return $this->model->all();
    }

    public function find(int $id): ?ExchangeRates
    {
        return $this->model->find($id);
    }

    public function create(ExchangeRatesDto $dto): ExchangeRates
    {
        return $this->model->create($dto->toArray());
    }

    public function update(int $id, ExchangeRatesDto $dto): ExchangeRates
    {
        $record = $this->find($id);
        $record->update($dto->toArray());
        return $record;
    }

    public function delete(int $id): bool
    {
        return $this->model->destroy($id) > 0;
    }

    public function getExchangeRate(string $targetCurrency): ?ExchangeRates
    {
        return $this->model->where('target_currency', $targetCurrency)
            ->whereDate('created_at', now()->toDateString())
            ->first();
    }
}
