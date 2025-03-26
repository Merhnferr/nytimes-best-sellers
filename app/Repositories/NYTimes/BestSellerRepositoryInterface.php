<?php

namespace App\Repositories\NYTimes;

interface BestSellerRepositoryInterface
{
    public function listHistory(array $filters): array;
}
