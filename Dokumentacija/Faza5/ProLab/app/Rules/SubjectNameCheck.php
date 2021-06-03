<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class SubjectNameCheck implements Rule
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
        $parts = explode(' ', $value);
        foreach ($parts as $part) {
            if (!ctype_alpha($part) && !is_numeric($part)) {
                return False;
            }
        }
        return True;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Naziv predmeta moze sadrzati samo slova i broj predmeta';
    }
}
