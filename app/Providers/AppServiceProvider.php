<?php

declare(strict_types=1);

namespace App\Providers;

use App\Services\v1\BestSellerService;
use App\Services\v1\BestSellerServiceInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public array $bindings = [
        BestSellerServiceInterface::class => BestSellerService::class,
    ];

    public function register(): void {}

    public function boot(): void {}
}
