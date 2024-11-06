<?php

namespace App\Services;

use App\DataTransferObjects\NewSimulationsDto;
use App\Repositories\SimulationsRepositoryInterface;
use App\DataTransferObjects\SimulationsDto;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Simulations;
use App\Repositories\AgeGroupsRepositoryInterface;
use DateTime;
use Illuminate\Support\Facades\Log;

class SimulationsService
{
    public function __construct(
        protected SimulationsRepositoryInterface $repository,
        protected AgeGroupsRepositoryInterface $ageGroupRepository
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
        $birthDate = new DateTime($dto->birth_date);
        $currentDate = new DateTime();
        $age = $currentDate->diff($birthDate)->y;

        $interestRate = $this->ageGroupRepository->findByAge($age);
        if (!$interestRate) {
            Log::error('Interest rate not found for age: ' . $age);
            throw new \Exception('Interest rate not found for age: ' . $age);
        }

        $monthlyInterestRate = $interestRate /100 / 12;
        $mensal_payment = ($dto->loan_amount * $monthlyInterestRate) / (1 - pow(1 + $monthlyInterestRate, -$dto->payment_date));
        $total_payment = $mensal_payment * $dto->payment_date;

        $simulation = $this->repository->create(
            new NewSimulationsDto(
                birth_date: $dto->birth_date,
                loan_amount: $dto->loan_amount,
                payment_date: $dto->payment_date,
                interest_rate: $interestRate,
                interest_type: 'FIXED',
                total_amount: $dto->loan_amount,
                total_payment: $total_payment,
                monthly_payment: $mensal_payment,
                total_interest: ($mensal_payment * $dto->payment_date) - $dto->loan_amount
            )
        );

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
