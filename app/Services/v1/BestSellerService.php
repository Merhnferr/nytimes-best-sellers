<?php

declare(strict_types=1);

namespace App\Services\v1;

use App\Helpers\CacheHelper;
use App\Helpers\FiltersHelper;
use App\NYTimes\Repositories\BestSellerRepository;
use Illuminate\Support\Facades\Cache;
use Throwable;

class BestSellerService
{
    public function __construct(private readonly BestSellerRepository $repository) {}

    /**
     * @throws Throwable
     */
    public function listHistory(array $filters): array
    {
        $filters = FiltersHelper::formatFilters($filters);
        $cacheKey = CacheHelper::buildCacheKey($filters);

        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        $data = $this->repository->listHistory($filters);
        $bestSellers = [
            'bestSellers' => $data['results'] ?? [],
            'meta' => [
                'total' => $data['num_results'] ?? 0,
            ],
        ];

        Cache::put($cacheKey, $bestSellers, config('cache.cacheTtl'));

        return $bestSellers;
    }
}
