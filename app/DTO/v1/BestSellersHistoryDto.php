<?php

declare(strict_types=1);

namespace App\DTO\v1;

class BestSellersHistoryDto
{
    /**
     * @param BookDto[] $result
     */
    public function __construct(
        private readonly string $copyright,
        private readonly int $resultsNumber,
        private readonly array $result,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            $data['copyright'],
            $data['num_results'],
            array_map(static fn($book) => BookDto::fromArray($book), $data['results'])
        );
    }

    public function getCopyright(): string
    {
        return $this->copyright;
    }

    public function getResultsNumber(): int
    {
        return $this->resultsNumber;
    }

    public function getResult(): array
    {
        return $this->result;
    }
}
