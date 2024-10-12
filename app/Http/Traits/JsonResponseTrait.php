<?php

namespace App\Http\Traits;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

trait JsonResponseTrait {

    /**
     * Return a JSON response for successful or failed operations.
     *
     * @param mixed $data The data to include in the response.
     * @param int $status The HTTP status code.
     * @param string|null $message The message to include in the response.
     * @param bool $success Indicates whether the operation was successful. Defaults to true.
     * @return JsonResponse
     */
    public function jsonResponse(mixed $data = null, int $status = Response::HTTP_OK, string $message = null, bool $success = true): JsonResponse {
        return response()->json([
                    'success' => $success,
                    'message' => $message ?? ($success ? __('messages.success') : __('messages.error')),
                    'data' => $data,
                        ], $status);
    }
}
