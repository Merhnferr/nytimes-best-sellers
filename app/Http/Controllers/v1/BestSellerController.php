<?php

declare(strict_types=1);

namespace App\Http\Controllers\v1;

use App\DTO\v1\ListDto;
use App\Http\Requests\v1\BestSellerHistoryListRequest;
use App\Http\Resources\v1\BestSellersHistoryResource;
use App\Http\Responses\v1\ApiResponse;
use App\Services\v1\BestSellerServiceInterface;
use Throwable;

class BestSellerController extends BaseController
{
    public function __construct(private readonly BestSellerServiceInterface $service) {}

    /**
     * @throws Throwable
     */
    public function __invoke(BestSellerHistoryListRequest $request): ApiResponse
    {
        $data = $this->service->listHistory(ListDto::fromRequest($request));

        return new ApiResponse(BestSellersHistoryResource::make($data));
    }
}
