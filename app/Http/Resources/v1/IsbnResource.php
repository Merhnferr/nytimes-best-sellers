<?php

declare(strict_types=1);

namespace App\Http\Resources\v1;

use App\DTO\v1\IsbnDto;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin IsbnDto
 */
class IsbnResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'isbn10' => $this->getIsbn10(),
            'isbn13' => $this->getIsbn13(),
        ];
    }
}
