<?php

namespace App\Services\v1;

use App\DTO\v1\BestSellersFiltersDto;
use App\DTO\v1\BestSellersHistoryDto;

interface BookServiceInterface
{
    public function listBestSellersHistory(BestSellersFiltersDto $filtersDto): BestSellersHistoryDto;
}
