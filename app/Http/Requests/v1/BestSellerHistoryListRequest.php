<?php

declare(strict_types=1);

namespace App\Http\Requests\v1;

use App\Rules\v1\ValidOffset;
use Illuminate\Foundation\Http\FormRequest;

class BestSellerHistoryListRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'author' => ['string'],
            'isbn' => ['array'],
            'isbn.*' => ['bail', 'distinct', 'regex:/^(?:\d{10}|\d{13})$/'],
            'title' => ['string'],
            'offset' => ['bail', 'integer', 'min:0', new ValidOffset],
        ];
    }
}
