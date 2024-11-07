<?php

namespace App\Services;

use App\Repositories\InterestRatesRepositoryInterface;
use App\DataTransferObjects\InterestRatesDto;
use Illuminate\Database\Eloquent\Collection;
use App\Models\InterestRates;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class InterestRatesService
{
    public function __construct(
        protected InterestRatesRepositoryInterface $repository
    ) {}

    public function getAllItems(): Collection
    {
        return $this->repository->all();
    }

    public function getItem(int $id): ?InterestRates
    {
        return $this->repository->find($id);
    }

    public function createItem(InterestRatesDto $dto): InterestRates
    {
        return $this->repository->create($dto);
    }

    public function updateItem(InterestRatesDto $dto, int $id): InterestRates
    {
        return $this->repository->update($id, $dto);
    }

    public function deleteItem(int $id): bool
    {
        return $this->repository->delete($id);
    }

    public function getAndSaveCurrentSelicRate()
    {
        $url = "https://api.bcb.gov.br/dados/serie/bcdata.sgs.11/dados/ultimos/1";
        $response = Http::get($url, [
            'formato' => 'json',
        ]);

        if ($response->successful()) {
            $data = $response->json();
            $latestRate = end($data);

            $annual_selic = $this->calculateAnnualizedSelic($latestRate['valor']);

            $dto = new InterestRatesDto(
                rate: $annual_selic,
                rate_type: 'VARIAVEL',
                reference: 'SELIC',
                valid_from: Carbon::parse($latestRate['data'])->format('Y-m-d'),
            );

            Log::info('Creating new SELIC rate: ' . json_encode($dto));

            $interestRate = $this->createItem($dto);

            Log::info('Saving new SELIC rate: ' . json_encode($interestRate));

            return $dto;
        } else {
            throw new Exception("Unable to retrieve the SELIC rate.");
        }
    }

    private function calculateAnnualizedSelic($dailySelic)
    {
        $decimalDailySelic = $dailySelic / 100;

        $annualizedSelic = pow(1 + $decimalDailySelic, 252) - 1;
        return $annualizedSelic * 100;
    }
}
