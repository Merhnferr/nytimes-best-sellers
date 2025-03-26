<?php

declare(strict_types=1);

namespace App\Providers;

use App\Configs\BooksApiConfig;
use App\Repositories\v1\BestSellerRepository;
use App\Repositories\v1\BestSellerRepositoryInterface;
use App\Services\v1\BestSellerService;
use App\Services\v1\BestSellerServiceInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public array $bindings = [
        BestSellerServiceInterface::class => BestSellerService::class,
        BestSellerRepositoryInterface::class => BestSellerRepository::class,
    ];

    public function register(): void
    {
        $this->app->singleton(BooksApiConfig::class, function () {
            return new BooksApiConfig(
                config('nytimes.booksApi.apiKey'),
                config('nytimes.booksApi.baseUrl'),
                config('nytimes.booksApi.version'),
                config('nytimes.booksApi.endpoints'),
            );
        });
    }

    public function boot(): void {}
}
