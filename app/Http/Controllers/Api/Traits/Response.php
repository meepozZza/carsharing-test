<?php

namespace App\Http\Controllers\Api\Traits;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Validation\ValidationException;

trait Response
{
    /**
     * Sending success response.
     *
     * @param $result
     * @param int $code
     * @param Request|null $request
     * @return JsonResponse
     */
    public function sendResponse($result, int $code = 200, ?Request $request = null): JsonResponse
    {
        return ($result instanceof ResourceCollection) ? $result->toResponse($request ?? request()) : response()->json($result, $code);
    }

    /**
     * Sending error response.
     *
     * @param mixed $errors
     * @param int $errorCode
     * @return JsonResponse
     */
    public function sendError($errors, int $errorCode = 400): JsonResponse
    {
        return match (true) {
            $errors instanceof AuthenticationException => response()->json(['errors' => [$errors->getMessage()]], 401),
            $errors instanceof ValidationException => response()->json(['errors' => $errors->getMessage()], $errorCode),
            $errors instanceof \Throwable => response()->json(['errors' => (array)$errors->getMessage()], $errorCode),
            default => response()->json(['errors' => (array)$errors], $errorCode),
        };
    }
}
