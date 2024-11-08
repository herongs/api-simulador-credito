<?php

namespace App\Http\Controllers;

use App\Services\SimulationsService;
use App\Http\Requests\SimulationsRequest;
use App\Http\Resources\SimulationsResource;
use App\Http\Resources\SimulationsCollection;
use App\DataTransferObjects\SimulationsDto;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class SimulationsController extends Controller
{
    public function __construct(
        protected SimulationsService $SimulationsService,
    ) {}

    public function store(SimulationsRequest $request): JsonResponse
    {
        $birthDate = $request->input('birth_date');

        if (!$birthDate || !strtotime($birthDate)) {
            return $this->errorResponse(
                message: __('Data de nascimento inválida. Tente novamente!'),
                code: 400
            );
        }

        $item = $this->SimulationsService->createItem(SimulationsDto::fromRequest($request));

        if (!$item) {
            if ($request->input('interest_type') === 'FIXA' || !$request->input('interest_type')) {
                return $this->errorResponse(
                    message: __('Não foi possível encontrar a taxa de juros para a idade informada. Tente Novamente!'),
                    code: 404
                );
            }

            return $this->errorResponse(
                message: __('Tipo de Taxa de Juros não suportado. Tente Novamente!'),
                code: 404
            );
        }

        return $this->successResponse(payload: new SimulationsResource($item), message: __('messages.created'), code: 201);
    }

}
