<?php

namespace App\Repositories;

use App\Models\InterestRates;
use App\DataTransferObjects\InterestRatesDto;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;

class InterestRatesRepository implements InterestRatesRepositoryInterface
{
    public function __construct(
        protected InterestRates $model
    ){
    }

    public function all(): Collection
    {
        return $this->model->all();
    }

    public function find(int $id): ?InterestRates
    {
        return $this->model->find($id);
    }

    public function create(InterestRatesDto $dto): InterestRates
    {
        return $this->model->create($dto->toArray());
    }

    public function update(int $id, InterestRatesDto $dto): InterestRates
    {
        $record = $this->find($id);
        $record->update($dto->toArray());
        return $record;
    }

    public function delete(int $id): bool
    {
        return $this->model->destroy($id) > 0;
    }

    public function findSelicRateByDate(string $date): ?InterestRates
    {
        $formattedDate = date('Y-m-d', strtotime($date));

        return $this->model->where('reference', 'SELIC')
            ->whereDate('valid_from', '=', $formattedDate)
            ->first();
    }
}
