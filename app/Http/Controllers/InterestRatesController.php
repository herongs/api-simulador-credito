<?php

namespace App\Http\Controllers;

use App\Services\InterestRatesService;
use App\Http\Requests\InterestRatesRequest;
use App\Http\Resources\InterestRatesResource;
use App\Http\Resources\InterestRatesCollection;
use App\DataTransferObjects\InterestRatesDto;
use Illuminate\Http\JsonResponse;

class InterestRatesController extends Controller
{
    public function __construct(
        protected InterestRatesService $InterestRatesService,
    ) {}

    public function index(): JsonResponse
    {
        $items = $this->InterestRatesService->getAllItems();
        return $this->successResponse(payload: new InterestRatesCollection($items));
    }

    public function store(InterestRatesRequest $request): JsonResponse
    {
        $item = $this->InterestRatesService->createItem(InterestRatesDto::fromRequest($request));
        return $this->successResponse(payload: new InterestRatesResource($item), message: __('messages.created'), code: 201);
    }

    public function show(int $id): JsonResponse
    {
        $item = $this->InterestRatesService->getItem($id);
        return $this->successResponse(payload: new InterestRatesResource($item));
    }

    public function update(InterestRatesRequest $request, int $id): JsonResponse
    {
        $item = $this->InterestRatesService->updateItem(InterestRatesDto::fromRequest($request), $id);
        return $this->successResponse(payload: new InterestRatesResource($item), message: __('messages.updated'));
    }

    public function destroy(int $id): JsonResponse
    {
        $this->InterestRatesService->deleteItem($id);
        return $this->successResponse(message: __('messages.deleted'), code: 204);
    }
}
