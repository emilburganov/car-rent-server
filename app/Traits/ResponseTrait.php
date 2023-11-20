<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\MessageBag;

trait ResponseTrait
{
    protected function message(string $message, int $code = 200): JsonResponse
    {
        return response()->json([
            'message' => $message,
        ], $code);
    }

    protected function validationError(MessageBag $errors): JsonResponse
    {
        return response()->json([
            'message' =>  'Validation error.',
            'errors' => $errors,
        ], 422);
    }
}
