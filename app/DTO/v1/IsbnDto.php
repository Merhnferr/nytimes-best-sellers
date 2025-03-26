<?php

declare(strict_types=1);

namespace App\DTO\v1;

class IsbnDto
{
    public function __construct(
        private readonly string $isbn10,
        private readonly string $isbn13
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            $data['isbn10'],
            $data['isbn13']
        );
    }

    public function getIsbn10(): string
    {
        return $this->isbn10;
    }

    public function getIsbn13(): string
    {
        return $this->isbn13;
    }
}
