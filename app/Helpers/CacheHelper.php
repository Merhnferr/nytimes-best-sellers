<?php

declare(strict_types=1);

namespace App\Helpers;

class CacheHelper
{
    public static function buildCacheKey(array $identifiers): string
    {
        return md5(
            implode(':', [config('cache.prefix'), ...$identifiers])
        );
    }
}
