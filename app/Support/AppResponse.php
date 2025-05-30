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
        return (new self)(Response::HTTP_INTERNAL_SERVER_ERROR, __('response.server_error'), [
            'reason' => $reason,
        ]);
    }

    public static function resource(
        JsonResource $resource,
        ?string $messsage = null,
        int $statusCode = Response::HTTP_OK
    ): JsonResponse {
        return response()->json([
            'status' => data_get(Response::$statusTexts, $statusCode),
            'statusCode' => $statusCode,
            'message' => $messsage ?? data_get(Response::$statusTexts, $statusCode),
            'resource' => $resource,
        ], $statusCode);
    }
}
