<?php

declare(strict_types=1);

namespace App\Services\v1;

use App\DTO\v1\BestSellersHistoryDto;
use App\DTO\v1\ListDto;
use App\Helpers\CacheHelper;
use App\Repositories\v1\BestSellerRepository;
use Illuminate\Support\Facades\Cache;
use Throwable;

class BestSellerService implements BestSellerServiceInterface
{
    public function __construct(private readonly BestSellerRepository $repository) {}

    /**
     * @throws Throwable
     */
    public function listHistory(ListDto $listDto): BestSellersHistoryDto
    {
        $queryParams = $listDto->toQueryParams();
        $cacheKey = CacheHelper::buildCacheKey($queryParams);

        if (Cache::has($cacheKey)) {
            return BestSellersHistoryDto::fromArray(Cache::get($cacheKey));
        }

        $data = $this->repository->listHistory($queryParams);

        Cache::put($cacheKey, $data, config('cache.cacheTtl'));

        return BestSellersHistoryDto::fromArray($data);
    }
}
