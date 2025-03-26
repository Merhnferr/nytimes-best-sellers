<?php

declare(strict_types=1);

namespace App\Http\Resources\v1;

use App\DTO\BestSellersHistoryDto;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin BestSellersHistoryDto
 */
class BestSellersHistoryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'copyright' => $this->getCopyright(),
            'resultsNumber' => $this->getResultsNumber(),
            'result' => BookResource::collection($this->getResult()),
        ];
    }
}
