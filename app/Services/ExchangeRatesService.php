<?php

namespace App\Services;

use App\Repositories\ExchangeRatesRepositoryInterface;
use App\DataTransferObjects\ExchangeRatesDto;
use Illuminate\Database\Eloquent\Collection;
use App\Models\ExchangeRates;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class ExchangeRatesService
{
    public function __construct(
        protected ExchangeRatesRepositoryInterface $repository
    ){
    }

    public function getAllItems(): Collection
    {
        return $this->repository->all();
    }

    public function getItem(int $id): ?ExchangeRates
    {
        return $this->repository->find($id);
    }

    public function createItem(ExchangeRatesDto $dto): ExchangeRates
    {
        return $this->repository->create($dto);
    }

    public function updateItem(ExchangeRatesDto $dto, int $id): ExchangeRates
    {
        return $this->repository->update($id, $dto);
    }

    public function deleteItem(int $id): bool
    {
        return $this->repository->delete($id);
    }

    public function getExchangeRate(string $targetCurrency): ?ExchangeRates
    {
        return $this->repository->getExchangeRate($targetCurrency);
    }

    public function getAndSaveCurrentExchangeRate(string $targetCurrency): ?ExchangeRates
    {
        $exchangeRate = $this->getExchangeRateFromApi($targetCurrency);
        if ($exchangeRate) {
            return $this->createItem($exchangeRate);
        }

        return null;
    }

    private function getExchangeRateFromApi(string $targetCurrency): ?ExchangeRatesDto
    {
        $url = "https://economia.awesomeapi.com.br/last/BRL-$targetCurrency";
        $response = json_decode(file_get_contents($url), true);
        if (isset($response['error'])) {
            return null;
        }

        return new ExchangeRatesDto(
            source_currency: 'BRL',
            target_currency: $targetCurrency,
            rate: $response['BRL' . $targetCurrency]['bid'],
            date: Carbon::now()->toDateString(),
        );
    }
}
