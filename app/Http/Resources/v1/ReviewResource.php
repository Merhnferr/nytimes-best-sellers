<?php

declare(strict_types=1);

namespace App\Http\Resources\v1;

use App\DTO\ReviewDto;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin ReviewDto
 */
class ReviewResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'bookReviewLink' => $this->getBookReviewLink(),
            'firstChapterLink' => $this->getFirstChapterLink(),
            'sundayReviewLink' => $this->getSundayReviewLink(),
            'articleChapterLink' => $this->getArticleChapterLink(),
        ];
    }
}
