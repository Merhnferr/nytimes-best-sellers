<?php

declare(strict_types=1);

namespace App\Http\Resources\v1;

use App\DTO\v1\BookDto;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin BookDto
 */
class BookResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'title' => $this->getTitle(),
            'description' => $this->getDescription(),
            'contributor' => $this->getContributor(),
            'author' => $this->getAuthor(),
            'contributorNote' => $this->getContributorNote(),
            'price' => $this->getPrice(),
            'ageGroup' => $this->getAgeGroup(),
            'publisher' => $this->getPublisher(),
            'isbns' => IsbnResource::collection($this->getIsbns()),
            'ranksHistory' => RankHistoryResource::collection($this->getRanksHistory()),
            'reviews' => ReviewResource::collection($this->getReviews()),
        ];
    }
}
