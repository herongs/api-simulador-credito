<?php

namespace App\Services;

use App\DataTransferObjects\NewSimulationsDto;
use App\Repositories\SimulationsRepositoryInterface;
use App\DataTransferObjects\SimulationsDto;
use App\Http\Controllers\Controller;
use App\Mail\SendSimulationMail;
use App\Mail\SendExchangeSimulationMail;
use App\Models\Simulations;
use App\Repositories\AgeGroupsRepositoryInterface;
use App\Repositories\InterestRatesRepositoryInterface;

use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class SimulationsService extends Controller
{
    public function __construct(
        protected SimulationsRepositoryInterface $repository,
        protected AgeGroupsRepositoryInterface $ageGroupRepository,
        protected InterestRatesService $InterestRatesService,
        protected InterestRatesRepositoryInterface $interestRateRepository,
        protected ExchangeRatesService $ExchangeRatesService

    ) {}

    public function createItem(SimulationsDto $dto): ?Simulations
    {
        $age = $this->calculateAge($dto->birth_date);
        $interestData = $this->getInterestData($dto->interest_type, $age);
        if (!$interestData) {
            return null;
        }

        $monthlyPayment = $this->calculateMonthlyPayment($dto->loan_amount, $interestData['monthlyRate'], $dto->payment_date);
        $totalPayment = $monthlyPayment * $dto->payment_date;

        $simulation = $this->repository->create(
            new NewSimulationsDto(
                birth_date: $dto->birth_date,
                loan_amount: $dto->loan_amount,
                payment_date: $dto->payment_date,
                interest_rate: $interestData['rate'],
                interest_type: $dto->interest_type ?? 'FIXA',
                total_amount: $dto->loan_amount,
                total_payment: $totalPayment,
                monthly_payment: $monthlyPayment,
                total_interest: $totalPayment - $dto->loan_amount,
                currency: 'BRL',
                email: $dto->email ?? null,
            )
        );

        if ($dto->email) {
            $this->sendSimulationEmailToUser($simulation, $dto);
        }

        return $simulation;
    }

    public function createItemExchange(SimulationsDto $dto): ?Simulations
    {
        $exchangeRate = $this->ExchangeRatesService->getExchangeRate($dto->target_currency);
        if (!$exchangeRate) {
            $exchangeRate = $this->ExchangeRatesService->getAndSaveCurrentExchangeRate($dto->target_currency);
        }

        $totalAmount = $dto->loan_amount * $exchangeRate->rate;
        $age = $this->calculateAge($dto->birth_date);
        $interestData = $this->getInterestData($dto->interest_type, $age);
        if (!$interestData) {
            return null;
        }

        $monthlyPayment = $this->calculateMonthlyPayment($totalAmount, $interestData['monthlyRate'], $dto->payment_date);
        $totalPayment = $monthlyPayment * $dto->payment_date;

        $simulation = $this->repository->create(
            new NewSimulationsDto(
                birth_date: $dto->birth_date,
                loan_amount: $totalAmount,
                payment_date: $dto->payment_date,
                interest_rate: $interestData['rate'],
                interest_type: $dto->interest_type ?? 'FIXA',
                total_amount: $totalAmount,
                total_payment: $totalPayment,
                monthly_payment: $monthlyPayment,
                total_interest: $totalPayment - $totalAmount,
                currency: $dto->target_currency,
                email: $dto->email ?? null,
            )
        );

        if ($dto->email) {
            $this->sendExchangeSimulationEmailToUser($simulation, $dto, $exchangeRate);
        }

        return $simulation;
    }

    private function sendSimulationEmailToUser(Simulations $simulation, SimulationsDto $dto): void
    {
        Mail::to($dto->email)->send(new SendSimulationMail($simulation));
    }

    private function sendExchangeSimulationEmailToUser(Simulations $simulation, SimulationsDto $dto, $exchangeRate): void
    {
        Mail::to($dto->email)->send(new SendExchangeSimulationMail($simulation,  $exchangeRate, $dto));
    }

    private function calculateAge(string $birthDate): int
    {
        $birthDate = Carbon::parse($birthDate);
        $currentDate = Carbon::now();
        $age = $currentDate->diff($birthDate)->y;
        return $age;
    }

    private function getInterestData(?string $interestType, int $age): ?array
    {
        if ($interestType === 'VARIAVEL') {
            $selicRate = $this->interestRateRepository->findSelicRateByDate(Carbon::now()->format('Y-m-d'));
            if (!$selicRate) {
                $selicRate = $this->InterestRatesService->getAndSaveCurrentSelicRate();
            }
            $annualInterestRate = $selicRate->rate;
            $monthlyRate = pow(1 + ($annualInterestRate / 100), 1 / 12) - 1;
            return ['rate' => $annualInterestRate, 'monthlyRate' => $monthlyRate];
        } elseif ($interestType === 'FIXA' || !$interestType) {
            $rate = $this->ageGroupRepository->findByAge($age);
            if (!$rate) {
                return null;
            }
            $monthlyRate = $rate / 100 / 12;
            return ['rate' => $rate, 'monthlyRate' => $monthlyRate];
        }
        return null;
    }

    private function calculateMonthlyPayment(float $amount, float $monthlyRate, int $terms): float
    {
        return ($amount * $monthlyRate) / (1 - pow(1 + $monthlyRate, -$terms));
    }
}
