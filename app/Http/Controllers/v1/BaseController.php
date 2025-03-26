<?php

declare(strict_types=1);

namespace App\Http\Controllers\v1;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpFoundation\Response;

abstract class BaseController extends Controller
{
    public function json(?array $data, int $statusCode = Response::HTTP_OK): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $data,
        ], $statusCode);
    }
}
