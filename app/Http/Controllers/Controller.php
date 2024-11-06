<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

abstract class Controller
{
    public function successResponse($payload = null, ?string $message = null, int $code = 200): JsonResponse
    {
        return response()->json(['payload' => $payload, 'message' => $message], $code);
    }

    public function errorResponse(?string $message = null, int $code = 404): JsonResponse
    {
        return response()->json(['message' => $message], $code);
    }
}
