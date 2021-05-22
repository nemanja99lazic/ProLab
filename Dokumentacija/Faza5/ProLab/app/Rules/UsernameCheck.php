<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class UsernameCheck implements Rule
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
        if (preg_match("/^[A-Za-z0-9_\.]*$/", $value) && preg_match("/[A-Za-z]/", $value)) {
            return True;
        } else {
            return False;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Username can contain digits, dots and _ and at least one letter';
    }
}
