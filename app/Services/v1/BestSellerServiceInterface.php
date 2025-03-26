<?php

namespace App\Services\v1;

use App\DTO\v1\BestSellersHistoryDto;
use App\DTO\v1\ListDto;

interface BestSellerServiceInterface
{
    public function listHistory(ListDto $listDto): BestSellersHistoryDto;
}
