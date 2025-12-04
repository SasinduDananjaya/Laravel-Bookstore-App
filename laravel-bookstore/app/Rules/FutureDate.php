<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class FutureDate implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $inputDate = \Carbon\Carbon::parse($value)->startOfDay();
        $today = \Carbon\Carbon::today();

        if ($inputDate->lessThanOrEqualTo($today)) {
            $fail('The :attribute must be a future date (tomorrow or later).');
        }
    }
}
