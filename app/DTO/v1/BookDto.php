<?php

declare(strict_types=1);

namespace App\DTO\v1;

class BookDto
{
    /**
     * @param IsbnDto[] $isbns
     * @param RankHistoryDto[] $ranksHistory
     * @param ReviewDto[] $reviews
     */
    public function __construct(
        private readonly string $title,
        private readonly ?string $description,
        private readonly ?string $contributor,
        private readonly string $author,
        private readonly ?string $contributorNote,
        private readonly float $price,
        private readonly ?string $ageGroup,
        private readonly ?string $publisher,
        private readonly array $isbns,
        private readonly array $ranksHistory,
        private readonly array $reviews
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            $data['title'],
            $data['description'],
            $data['contributor'],
            $data['author'],
            $data['contributor_note'],
            (float) $data['price'],
            $data['age_group'],
            $data['publisher'],
            array_map(static fn($isbn) => IsbnDto::fromArray($isbn), $data['isbns']),
            array_map(static fn($rank) => RankHistoryDto::fromArray($rank), $data['ranks_history']),
            array_map(static fn($review) => ReviewDto::fromArray($review), $data['reviews'])
        );
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getContributor(): ?string
    {
        return $this->contributor;
    }

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function getContributorNote(): ?string
    {
        return $this->contributorNote;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getAgeGroup(): ?string
    {
        return $this->ageGroup;
    }

    public function getPublisher(): ?string
    {
        return $this->publisher;
    }

    /**
     * @return IsbnDto[]
     */
    public function getIsbns(): array
    {
        return $this->isbns;
    }

    /**
     * @return RankHistoryDto[]
     */
    public function getRanksHistory(): array
    {
        return $this->ranksHistory;
    }

    /**
     * @return ReviewDto[]
     */
    public function getReviews(): array
    {
        return $this->reviews;
    }
}
