<?php

namespace App\Services\v1;

use App\DTO\BestSellersHistoryDto;
use App\DTO\ListDto;

interface BestSellerServiceInterface
{
    public function listHistory(ListDto $listDto): BestSellersHistoryDto;
}
