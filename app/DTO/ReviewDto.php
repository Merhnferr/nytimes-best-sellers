<?php

declare(strict_types=1);

namespace App\DTO;

class ReviewDto
{
    public function __construct(
        private readonly ?string $bookReviewLink,
        private readonly ?string $firstChapterLink,
        private readonly ?string $sundayReviewLink,
        private readonly ?string $articleChapterLink
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            $data['book_review_link'],
            $data['first_chapter_link'],
            $data['sunday_review_link'],
            $data['article_chapter_link']
        );
    }

    public function getBookReviewLink(): ?string
    {
        return $this->bookReviewLink;
    }

    public function getFirstChapterLink(): ?string
    {
        return $this->firstChapterLink;
    }

    public function getSundayReviewLink(): ?string
    {
        return $this->sundayReviewLink;
    }

    public function getArticleChapterLink(): ?string
    {
        return $this->articleChapterLink;
    }
}
