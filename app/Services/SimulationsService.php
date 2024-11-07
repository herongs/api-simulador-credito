<?php

namespace App\Services;

use App\DataTransferObjects\NewSimulationsDto;
use App\Repositories\SimulationsRepositoryInterface;
use App\DataTransferObjects\SimulationsDto;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Simulations;
use App\Repositories\AgeGroupsRepositoryInterface;
use App\Repositories\InterestRatesRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class SimulationsService
{
    public function __construct(
        protected SimulationsRepositoryInterface $repository,
        protected AgeGroupsRepositoryInterface $ageGroupRepository,
        protected InterestRatesService $InterestRatesService,
        protected InterestRatesRepositoryInterface $interestRateRepository
    ) {}

    public function getAllItems(): Collection
    {
        return $this->repository->all();
    }

    public function getItem(int $id): ?Simulations
    {
        return $this->repository->find($id);
    }

    public function createItem(SimulationsDto $dto): Simulations
    {
        Log::info('Starting createItem method');

        $birthDate = Carbon::parse($dto->birth_date);
        $currentDate = Carbon::now();
        $age = $currentDate->diff($birthDate)->y;

        Log::info('Parsed birth date: ' . $dto->birth_date);
        Log::info('Calculated age: ' . $age);

        Log::info('DTO data: ' . json_encode($dto));

        if ($dto->interest_type === 'VARIAVEL') {
            $today = Carbon::now()->format('Y-m-d');

            Log::info('Today: ' . $today);

            $selicRate = $this->interestRateRepository->findSelicRateByDate($today);

            Log::info('Selic rate for today (' . $today . '): ' . json_encode($selicRate));

            if (!$selicRate) {
                Log::info('Selic rate not found, fetching current Selic rate');
                $selicRate = $this->InterestRatesService->getAndSaveCurrentSelicRate();
            }
            $annualInterestRate = $selicRate->rate;
            $monthlyInterestRate = pow(1 + ($annualInterestRate / 100), 1 / 12) - 1;
            $interestRate = $annualInterestRate;

            Log::info('Annual interest rate: ' . $annualInterestRate);
            Log::info('Monthly interest rate: ' . $monthlyInterestRate);
        } else {
            $interestRate = $this->ageGroupRepository->findByAge($age);
            Log::info('Interest rate for age ' . $age . ': ' . json_encode($interestRate));

            if (!$interestRate) {
                Log::error('Interest rate not found for age: ' . $age);
                throw new \Exception('Interest rate not found for age: ' . $age);
            }
            $monthlyInterestRate = $interestRate / 100 / 12;
        }

        $monthlyPayment = ($dto->loan_amount * $monthlyInterestRate) / (1 - pow(1 + $monthlyInterestRate, -$dto->payment_date));
        $totalPayment = $monthlyPayment * $dto->payment_date;

        Log::info('Monthly payment: ' . $monthlyPayment);
        Log::info('Total payment: ' . $totalPayment);

        $simulation = $this->repository->create(
            new NewSimulationsDto(
                birth_date: $dto->birth_date,
                loan_amount: $dto->loan_amount,
                payment_date: $dto->payment_date,
                interest_rate: $interestRate,
                interest_type: $dto->interest_type ?? 'FIXA',
                total_amount: $dto->loan_amount,
                total_payment: $totalPayment,
                monthly_payment: $monthlyPayment,
                total_interest: ($monthlyPayment * $dto->payment_date) - $dto->loan_amount
            )
        );

        Log::info('Simulation created: ' . json_encode($simulation));

        return $simulation;
    }


    public function updateItem(SimulationsDto $dto, int $id): Simulations
    {
        return $this->repository->update($id, $dto);
    }

    public function deleteItem(int $id): bool
    {
        return $this->repository->delete($id);
    }
}
