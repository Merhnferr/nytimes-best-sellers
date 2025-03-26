<?php

declare(strict_types=1);

namespace App\Services\v1;

use App\DTO\v1\BestSellersHistoryDto;
use App\DTO\v1\DtoInterface;
use App\DTO\v1\ListDto;
use App\Helpers\CacheHelper;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use RuntimeException;
use Throwable;

class BestSellerService implements BestSellerServiceInterface
{
    private readonly PendingRequest $client;

    public function __construct()
    {
        $this->client = Http::withOptions(['base_uri' => config('booksApi.baseUrl')])
            ->withQueryParameters(['api-key' => config('booksApi.apiKey')]);
    }

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

        $data = $this->sendRequest('lists.bestSellersHistory', $listDto);

        Cache::put($cacheKey, $data, config('cache.cacheTtl'));

        return BestSellersHistoryDto::fromArray($data);
    }

    /**
     * @throws RequestException
     */
    private function sendRequest(string $endpointName, DtoInterface $dto, string $version = 'v3')
    {
        $endpointUri = $this->getEndpointUri($version, $endpointName);

        return $this->client->get($endpointUri, $dto->toQueryParams())->throw()->json();
    }

    private function getEndpointUri(string $version, $endpointName): string
    {
        $path = Arr::get(config('booksApi.endpoints'), "$version.$endpointName");

        if (! $path) {
            throw new RuntimeException(trans('messages.nytimes.endpointNameNotExists'));
        }

        return sprintf('%s/%s', $version, $this->trimSlashes($path));
    }

    private function trimSlashes(string $string): string
    {
        return trim($string, '/');
    }
}
