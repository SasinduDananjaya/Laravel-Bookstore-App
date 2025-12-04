<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class TodayOnly implements ValidationRule
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

        if (!$inputDate->equalTo($today)) {
            $fail('The :attribute must be today\'s date only.');
        }
    }
}
