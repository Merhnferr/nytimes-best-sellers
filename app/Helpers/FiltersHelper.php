<?php

declare(strict_types=1);

namespace App\Helpers;

class FiltersHelper
{
    public static function formatFilters(array $filters): array
    {
        if (! array_key_exists('isbn', $filters)) {
            return $filters;
        }

        $filters['isbn'] = implode(';', $filters['isbn']);

        return $filters;
    }
}
