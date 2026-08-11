<?php

namespace App\Infrastructure\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class StrongPassword implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!preg_match('/[A-Z]/', $value)) {
            $fail("The :attribute must contain at least one uppercase letter.");
            return;
        }

        if (!preg_match('/[0-9]/', $value)) {
            $fail("The :attribute must contain at least one number.");
        }
    }
}
