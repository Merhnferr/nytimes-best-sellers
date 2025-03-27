<?php

declare(strict_types=1);

namespace App\Helpers;

class CacheHelper
{
    public static function buildCacheKey(string $version, array $identifiers): string
    {
        return md5(
            implode(':', [config('cache.prefix'), $version, ...$identifiers])
        );
    }
}
