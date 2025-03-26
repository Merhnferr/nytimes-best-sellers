<?php

declare(strict_types=1);

namespace App\DTO;

class RankHistoryDto
{
    public function __construct(
        private readonly string $primaryIsbn10,
        private readonly string $primaryIsbn13,
        private readonly int $rank,
        private readonly string $listName,
        private readonly string $displayName,
        private readonly string $publishedDate,
        private readonly string $bestsellersDate,
        private readonly int $weeksOnList,
        private readonly ?int $ranksLastWeek,
        private readonly int $asterisk,
        private readonly int $dagger
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            $data['primary_isbn10'],
            $data['primary_isbn13'],
            $data['rank'],
            $data['list_name'],
            $data['display_name'],
            $data['published_date'],
            $data['bestsellers_date'],
            $data['weeks_on_list'],
            $data['ranks_last_week'] ?? null,
            $data['asterisk'],
            $data['dagger']
        );
    }

    public function getPrimaryIsbn10(): string
    {
        return $this->primaryIsbn10;
    }

    public function getPrimaryIsbn13(): string
    {
        return $this->primaryIsbn13;
    }

    public function getRank(): int
    {
        return $this->rank;
    }

    public function getListName(): string
    {
        return $this->listName;
    }

    public function getDisplayName(): string
    {
        return $this->displayName;
    }

    public function getPublishedDate(): string
    {
        return $this->publishedDate;
    }

    public function getBestsellersDate(): string
    {
        return $this->bestsellersDate;
    }

    public function getWeeksOnList(): int
    {
        return $this->weeksOnList;
    }

    public function getRanksLastWeek(): ?int
    {
        return $this->ranksLastWeek;
    }

    public function getAsterisk(): int
    {
        return $this->asterisk;
    }

    public function getDagger(): int
    {
        return $this->dagger;
    }
}
