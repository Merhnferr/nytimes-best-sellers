<?php

declare(strict_types=1);

namespace App\Http\Controllers\v1;

use App\DTO\v1\BestSellersFiltersDto;
use App\Http\Requests\v1\BestSellerHistoryListRequest;
use App\Http\Resources\v1\BestSellersHistoryResource;
use App\Services\v1\BookServiceInterface;
use Illuminate\Routing\Controller;
use Throwable;

class BestSellerController extends Controller
{
    public function __construct(private readonly BookServiceInterface $service) {}

    /**
     * @throws Throwable
     */
    public function __invoke(BestSellerHistoryListRequest $request): BestSellersHistoryResource
    {
        $data = $this->service->listBestSellersHistory(BestSellersFiltersDto::fromRequest($request));

        return BestSellersHistoryResource::make($data);
    }
}
