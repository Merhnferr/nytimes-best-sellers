<?php

declare(strict_types=1);

namespace App\Http\Controllers\v1;

use App\DTO\v1\ListDto;
use App\Http\Requests\v1\BestSellerHistoryListRequest;
use App\Http\Resources\v1\BestSellersHistoryResource;
use App\Services\v1\BestSellerServiceInterface;
use Illuminate\Routing\Controller;
use Throwable;

class BestSellerController extends Controller
{
    public function __construct(private readonly BestSellerServiceInterface $service) {}

    /**
     * @throws Throwable
     */
    public function __invoke(BestSellerHistoryListRequest $request): BestSellersHistoryResource
    {
        $data = $this->service->listHistory(ListDto::fromRequest($request));

        return BestSellersHistoryResource::make($data);
    }
}
