<?php

namespace App\Support;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;

class AppResponse
{
    public function __invoke(
        int $statusCode,
        ?string $message = null,
        ?array $data = []
    ): JsonResponse {
        $statusText = data_get(Response::$statusTexts, $statusCode);

        return response()->json([
            'status' => $statusText,
            'statusCode' => $statusCode,
            'message' => $message ?? $statusText,
            'data' => $data,
        ], $statusCode);
    }

    public static function ok(
        ?string $message = null,
        ?array $data = []
    ): JsonResponse {
        return (new self)(Response::HTTP_OK, $message, $data);
    }

    public static function actionSuccess(?array $data = []): JsonResponse
    {
        return self::ok(__('response.action.success'), $data);
    }

    public static function forbidden(
        ?string $message = null,
        ?array $data = []
    ): JsonResponse {
        return (new self)(Response::HTTP_FORBIDDEN, $message, $data);
    }

    public static function badRequest(
        ?string $message = null,
        ?array $data = []
    ): JsonResponse {
        return (new self)(Response::HTTP_BAD_REQUEST, $message, $data);
    }

    public static function serverError(
        ?string $reason = null,
    ): JsonResponse {
        $payload = config('app.debug') ? ['reason' => $reason] : [];

        return (new self)(Response::HTTP_INTERNAL_SERVER_ERROR, __('response.server_error'), $payload);
    }

    public static function resource(
        JsonResource $resource,
        ?string $message = null,
        int $statusCode = Response::HTTP_OK
    ): JsonResponse {
        $statusText = data_get(Response::$statusTexts, $statusCode);

        return response()->json([
            'status' => $statusText,
            'statusCode' => $statusCode,
            'message' => $message ?? $statusText,
            'resource' => $resource,
        ], $statusCode);
    }
}
