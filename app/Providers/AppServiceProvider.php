<?php

declare(strict_types=1);

namespace App\Providers;

use App\Configs\NYTimes\BooksApiConfig;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(BooksApiConfig::class, function () {
            return new BooksApiConfig(
                config('nytimes.booksApi.apiKey'),
                config('nytimes.booksApi.baseUrl'),
                config('nytimes.booksApi.endpoints'),
            );
        });
    }

    public function boot(): void {}
}
