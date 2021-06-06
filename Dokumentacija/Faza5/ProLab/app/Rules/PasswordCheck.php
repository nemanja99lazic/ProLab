<?php

/**
 *
 * Autor: Slobodan Katanic 2018/0133
 *
 */

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class PasswordCheck implements Rule
{
    /**
     * Kreira novu instacu pravila.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Utvrdjuje da li prosledjena vrednost za lozinku korisnika ima odgovarajuci format.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (preg_match("/[a-z]/", $value) && preg_match("/[A-Z]/", $value) &&
            preg_match("/[0-9]/", $value)) {
            return True;
        } else {
            return False;
        }
    }

    /**
     * Vraca poruku greske koja se ispisuje u slucaju da validacija ne uspe.
     *
     * @return string
     */
    public function message()
    {
        return 'Password must containt at least one uppercase letter, lowercase letter and number digit';
    }
}
