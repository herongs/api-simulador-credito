<?php

namespace App\Http\Controllers;

use App\Services\AgeGroupsService;
use App\Http\Requests\AgeGroupsRequest;
use App\Http\Resources\AgeGroupsResource;
use App\Http\Resources\AgeGroupsCollection;
use App\DataTransferObjects\AgeGroupsDto;
use Illuminate\Http\JsonResponse;

class AgeGroupsController extends Controller
{
    public function __construct(
        protected AgeGroupsService $AgeGroupsService,
    ) {}

    public function index(): JsonResponse
    {
        $items = $this->AgeGroupsService->getAllItems();
        return $this->successResponse(payload: new AgeGroupsCollection($items));
    }

    public function store(AgeGroupsRequest $request): JsonResponse
    {
        $item = $this->AgeGroupsService->createItem(AgeGroupsDto::fromRequest($request));
        return $this->successResponse(payload: new AgeGroupsResource($item), message: __('messages.created'), code: 201);
    }

    public function show(int $id): JsonResponse
    {
        $item = $this->AgeGroupsService->getItem($id);
        return $this->successResponse(payload: new AgeGroupsResource($item));
    }

    public function update(AgeGroupsRequest $request, int $id): JsonResponse
    {
        $item = $this->AgeGroupsService->updateItem(AgeGroupsDto::fromRequest($request), $id);
        return $this->successResponse(payload: new AgeGroupsResource($item), message: __('messages.updated'));
    }

    public function destroy(int $id): JsonResponse
    {
        $this->AgeGroupsService->deleteItem($id);
        return $this->successResponse(message: __('messages.deleted'), code: 204);
    }
}
