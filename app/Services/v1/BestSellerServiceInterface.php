<?php

namespace App\Services\v1;

interface BestSellerServiceInterface
{
    public function listHistory(array $filters): array;
}
