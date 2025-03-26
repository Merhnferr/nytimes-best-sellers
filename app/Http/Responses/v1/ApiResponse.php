<?php

declare(strict_types=1);

namespace App\Http\Responses\v1;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\Response;

class ApiResponse implements Responsable
{
    public function __construct(
        private readonly JsonResource $data,
        public readonly bool $success = true,
        public readonly int $status = Response::HTTP_OK,
    ) {}

    public function toResponse($request): Response
    {
        return new JsonResponse(
            [
                'success' => $this->success,
                'data' => $this->data,
            ],
            $this->status
        );
    }
}
