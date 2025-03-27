<?php

namespace App\DTO\v1;

interface FiltersDtoInterface
{
    public function toQueryParams(): array;
}
