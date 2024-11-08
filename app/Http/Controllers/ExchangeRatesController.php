<?php

namespace App\Http\Controllers;

use App\Services\ExchangeRatesService;
use App\Http\Requests\ExchangeRatesRequest;
use App\Http\Resources\ExchangeRatesResource;
use App\Http\Resources\ExchangeRatesCollection;
use App\DataTransferObjects\ExchangeRatesDto;
use Illuminate\Http\JsonResponse;

class ExchangeRatesController extends Controller
{
    public function __construct(
        protected ExchangeRatesService $ExchangeRatesService,
    ) {}

    public function index(): JsonResponse
    {
        $items = $this->ExchangeRatesService->getAllItems();
        return $this->successResponse(payload: new ExchangeRatesCollection($items));
    }

    public function store(ExchangeRatesRequest $request): JsonResponse
    {
        $item = $this->ExchangeRatesService->createItem(ExchangeRatesDto::fromRequest($request));
        return $this->successResponse(payload: new ExchangeRatesResource($item), message: __('messages.created'), code: 201);
    }

    public function show(int $id): JsonResponse
    {
        $item = $this->ExchangeRatesService->getItem($id);
        return $this->successResponse(payload: new ExchangeRatesResource($item));
    }

    public function update(ExchangeRatesRequest $request, int $id): JsonResponse
    {
        $item = $this->ExchangeRatesService->updateItem(ExchangeRatesDto::fromRequest($request), $id);
        return $this->successResponse(payload: new ExchangeRatesResource($item), message: __('messages.updated'));
    }

    public function destroy(int $id): JsonResponse
    {
        $this->ExchangeRatesService->deleteItem($id);
        return $this->successResponse(message: __('messages.deleted'), code: 204);
    }
}
