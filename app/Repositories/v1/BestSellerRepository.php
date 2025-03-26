<?php

declare(strict_types=1);

namespace App\Repositories\v1;

use App\Configs\BooksApiConfig;
use Illuminate\Support\Facades\Http;
use Throwable;

class BestSellerRepository implements BestSellerRepositoryInterface
{
    public function __construct(private readonly BooksApiConfig $config) {}

    /**
     * @throws Throwable
     */
    public function listHistory(array $filters): array
    {
        return Http::withQueryParameters(['api-key' => $this->config->getApiKey()])
            ->get($this->config->getFullEndpointAddress('lists.bestSellersHistory'), $filters)
            ->throw()
            ->json();
    }
}
