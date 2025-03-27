<?php

declare(strict_types=1);

namespace App\Services\v1;

use App\DTO\v1\BestSellersFiltersDto;
use App\DTO\v1\BestSellersHistoryDto;
use App\DTO\v1\FiltersDtoInterface;
use App\Helpers\CacheHelper;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use RuntimeException;
use Throwable;

class BookService implements BookServiceInterface
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
    public function listBestSellersHistory(BestSellersFiltersDto $filtersDto): BestSellersHistoryDto
    {
        $data = $this->sendRequest('lists.bestSellersHistory', $filtersDto);

        return BestSellersHistoryDto::fromArray($data);
    }

    /**
     * @throws RequestException
     */
    private function sendRequest(string $endpointName, FiltersDtoInterface $filtersDto, ?string $version = null)
    {
        $version = $version ?? (string) config('booksApi.defaultVersion');

        $endpointUri = $this->getEndpointUri($version, $endpointName);

        $queryParams = $filtersDto->toQueryParams();
        $cacheKey = CacheHelper::buildCacheKey($version, $queryParams);

        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        $response = $this->client->get($endpointUri, $queryParams)->throw()->json();

        Cache::put($cacheKey, $response, config('cache.cacheTtl'));

        return $response;
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
