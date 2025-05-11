<?php

namespace App\Logics;

use Illuminate\Http\Response;

class AppResponse
{
    public static function ok(string $message = "Success", ?array $data = [])
    {
        return response()->json([
            'message' => $message,
            'status' => Response::HTTP_OK,
            'data' => $data
        ], Response::HTTP_OK);
    }
}
