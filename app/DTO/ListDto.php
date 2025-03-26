<?php

declare(strict_types=1);

namespace App\DTO;

use App\Http\Requests\v1\BestSellerHistoryListRequest;

class ListDto
{
    public function __construct(
        private readonly string $author,
        private readonly array $isbn,
        private readonly string $title,
        private readonly int $offset,
    ){}

    public static function fromRequest(BestSellerHistoryListRequest $request): self
    {
        return new self(
            $request->string('author')->toString(),
            $request->get('isbn', []),
            $request->string('title')->toString(),
            $request->integer('offset')
        );
    }

    public function toQueryParams(): array
    {
        $queryParams = array_filter(
            get_object_vars($this),
            static fn($value) => !empty($value)
        );

        if (array_key_exists('isbn', $queryParams)) {
            $queryParams['isbn'] = implode(';', $queryParams['isbn']);
        }

        return $queryParams;
    }
}
