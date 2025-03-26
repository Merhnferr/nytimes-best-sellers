<?php

declare(strict_types=1);

namespace App\NYTimes\Repositories;

use App\NYTimes\Configs\BooksApiConfig;
use Illuminate\Support\Facades\Http;
use Throwable;

class BestSellerRepository
{
    public function __construct(private readonly BooksApiConfig $config) {}

    /**
     * @throws Throwable
     */
    public function listHistory(array $filters): array
    {
        return Http::get(
            $this->config->getFullEndpointAddress('lists.bestSellersHistory'),
            $this->appendApiKey($filters)
        )->throw()
            ->json();
    }

    private function appendApiKey(array $queryParams): array
    {
        return [
            ...$queryParams,
            'api-key' => $this->config->getApiKey(),
        ];
    }
}
