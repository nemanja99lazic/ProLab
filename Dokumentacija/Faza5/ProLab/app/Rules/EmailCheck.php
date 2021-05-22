<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class EmailCheck implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */

    private $userType;

    public function __construct($userType) {
        $this->userType = $userType;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value) {
        if ($this->userType == 'teacher') {
            if (!preg_match("/^[a-zA-Z0-9][a-zA-Z0-9\.-_]*[a-zA-Z0-9]@etf(\.bg\.ac){0, 1}\.rs$/", $value)) {
                return False;
            } else {
                return True;
            }
        } else if ($this->userType == 'student') {
            if (!preg_match("/^[a-z][a-z][0-9]{6}d@student\.etf\.bg\.ac\.rs$/", $value)) {
                return False;
            } else {
                return True;
            }
        } else {
            if (!preg_match("/^[a-zA-Z0-9][a-zA-Z0-9\.-_]*[a-zA-Z0-9]@admin.etf(\.bg\.ac){0, 1}\.rs$/", $value)) {
                return Flase;
            } else {
                return True;
            }
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message() {
        return 'Email format is not correct.';
    }
}
