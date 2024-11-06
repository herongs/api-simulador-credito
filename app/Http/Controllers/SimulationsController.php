<?php

namespace App\Http\Controllers;

use App\Services\SimulationsService;
use App\Http\Requests\SimulationsRequest;
use App\Http\Resources\SimulationsResource;
use App\Http\Resources\SimulationsCollection;
use App\DataTransferObjects\SimulationsDto;
use Illuminate\Http\JsonResponse;

class SimulationsController extends Controller
{
    public function __construct(
        protected SimulationsService $SimulationsService,
    ) {}

    public function index(): JsonResponse
    {
        $items = $this->SimulationsService->getAllItems();
        return $this->successResponse(payload: new SimulationsCollection($items));
    }

    public function store(SimulationsRequest $request): JsonResponse
    {
        $item = $this->SimulationsService->createItem(SimulationsDto::fromRequest($request));
        return $this->successResponse(payload: new SimulationsResource($item), message: __('messages.created'), code: 201);
    }

    public function show(int $id): JsonResponse
    {
        $item = $this->SimulationsService->getItem($id);
        return $this->successResponse(payload: new SimulationsResource($item));
    }

    public function update(SimulationsRequest $request, int $id): JsonResponse
    {
        $item = $this->SimulationsService->updateItem(SimulationsDto::fromRequest($request), $id);
        return $this->successResponse(payload: new SimulationsResource($item), message: __('messages.updated'));
    }

    public function destroy(int $id): JsonResponse
    {
        $this->SimulationsService->deleteItem($id);
        return $this->successResponse(message: __('messages.deleted'), code: 204);
    }
}
