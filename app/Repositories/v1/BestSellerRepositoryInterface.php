<?php

namespace App\Repositories\v1;

interface BestSellerRepositoryInterface
{
    public function listHistory(array $filters): array;
}
