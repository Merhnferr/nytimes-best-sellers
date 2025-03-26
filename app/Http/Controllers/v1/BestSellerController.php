<?php

declare(strict_types=1);

namespace App\Http\Controllers\v1;

use App\Http\Requests\v1\BestSellerHistoryListRequest;
use App\Services\v1\BestSellerServiceInterface;
use Illuminate\Http\JsonResponse;
use Throwable;

class BestSellerController extends BaseController
{
    public function __construct(private readonly BestSellerServiceInterface $service) {}

    /**
     * @throws Throwable
     */
    public function __invoke(BestSellerHistoryListRequest $request): JsonResponse
    {
        return $this->json($this->service->listHistory($request->validated()));
    }
}
