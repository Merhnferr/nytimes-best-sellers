<?php

declare(strict_types=1);

namespace App\Configs\NYTimes;

use Illuminate\Support\Arr;
use RuntimeException;
use Throwable;

class BooksApiConfig
{
    public function __construct(
        readonly private string $apiKey,
        readonly private string $baseUrl,
        readonly private string $version,
        readonly private array $endpoints
    ) {}

    public function getApiKey(): string
    {
        return $this->apiKey;
    }

    /**
     * @throws Throwable
     */
    public function getFullEndpointAddress(string $endpointName): string
    {
        $path = Arr::get($this->endpoints, "$this->version.$endpointName");

        if (! $path) {
            throw new RuntimeException(trans('messages.nytimes.endpointNameNotExists'));
        }

        return sprintf(
            '%s/%s/%s',
            $this->trimSlashes($this->baseUrl),
            $this->version,
            $this->trimSlashes($path)
        );
    }

    private function trimSlashes(string $string): string
    {
        return trim($string, '/');
    }
}
