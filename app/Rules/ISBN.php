<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ISBN implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $total = 0;
        $multiplier = 10;

        if (strlen($value) !== 10) {
            return false;
        }

        for ($x = 0; $x < strlen($value); $x++) {
            $number = filter_var($value[$x], FILTER_VALIDATE_INT);
            if (!is_int($number)) {
                return response([
                    'message' => 'not integer',
                    'value' => $number
                ]);
            }
            $total += $multiplier * $number;
            $multiplier--;
        }

        $rem = $total % 11;

        if ($rem) {
            return false;
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The ISBN is not valid.';
    }
}
