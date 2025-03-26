<?php

declare(strict_types=1);

namespace App\Http\Resources\v1;

use App\DTO\v1\RankHistoryDto;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin RankHistoryDto
 */
class RankHistoryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'primaryIsbn10' => $this->getPrimaryIsbn10(),
            'primaryIsbn13' => $this->getPrimaryIsbn13(),
            'rank' => $this->getRank(),
            'listName' => $this->getListName(),
            'displayName' => $this->getDisplayName(),
            'publishedDate' => $this->getPublishedDate(),
            'bestsellersDate' => $this->getBestsellersDate(),
            'weeksOnList' => $this->getWeeksOnList(),
            'ranksLastWeek' => $this->getRanksLastWeek(),
            'asterisk' => $this->getAsterisk(),
            'dagger' => $this->getDagger(),
        ];
    }
}
