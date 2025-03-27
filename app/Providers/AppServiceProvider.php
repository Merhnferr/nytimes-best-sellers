<?php

declare(strict_types=1);

namespace App\Providers;

use App\Services\v1\BookService;
use App\Services\v1\BookServiceInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public array $bindings = [
        BookServiceInterface::class => BookService::class,
    ];

    public function register(): void {}

    public function boot(): void {}
}
