<?php

namespace App\Services;

use App\DataTransferObjects\NewSimulationsDto;
use App\Repositories\SimulationsRepositoryInterface;
use App\DataTransferObjects\SimulationsDto;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Collection;
use App\Mail\SendSimulationMail;
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
        protected InterestRatesRepositoryInterface $interestRateRepository
    ) {}

    public function createItem(SimulationsDto $dto): ?Simulations
    {
        $birthDate = Carbon::parse($dto->birth_date);
        $currentDate = Carbon::now();
        $age = $currentDate->diff($birthDate)->y;

        if ($dto->interest_type === 'VARIAVEL') {
            $today = Carbon::now()->format('Y-m-d');

            $selicRate = $this->interestRateRepository->findSelicRateByDate($today);

            if (!$selicRate) {
                $selicRate = $this->InterestRatesService->getAndSaveCurrentSelicRate();
            }
            $annualInterestRate = $selicRate->rate;
            $monthlyInterestRate = pow(1 + ($annualInterestRate / 100), 1 / 12) - 1;
            $interestRate = $annualInterestRate;
        } elseif ($dto->interest_type === 'FIXA' || !$dto->interest_type) {
            $interestRate = $this->ageGroupRepository->findByAge($age);
            if (!$interestRate) {
                return null;
            }
            $monthlyInterestRate = $interestRate / 100 / 12;
        } else {
            return null;
        }

        $monthlyPayment = ($dto->loan_amount * $monthlyInterestRate) / (1 - pow(1 + $monthlyInterestRate, -$dto->payment_date));
        $totalPayment = $monthlyPayment * $dto->payment_date;

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

        if($dto->email) {
            $this->sendSimulationEmailToUser($simulation, $dto);
        }

        return $simulation;
    }

    private function sendSimulationEmailToUser(Simulations $simulation, SimulationsDto $dto): void
    {
        Mail::to($dto->email)->send(new SendSimulationMail($simulation));
    }

}
