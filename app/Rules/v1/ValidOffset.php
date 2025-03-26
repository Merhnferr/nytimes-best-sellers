<?php

declare(strict_types=1);

namespace App\Rules\v1;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidOffset implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! is_numeric($value)) {
            return;
        }

        if ($value % 20 !== 0) {
            $fail(trans('validation.offset'));
        }
    }
}
