<?php

/**
 *
 * Autor: Slobodan Katanic 2018/0133
 *
 */

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

/**
 * UsernameCheck - klasa koja proverava da li je korisnicko ime u odgovarajucem formatu.
 *
 * @package App\Rules
 * @version
 */
class UsernameCheck implements Rule
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
     * Utvrdjuje da li prosledjena vrednost za korisnicko ime ima odgovrajuci format.
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
     * Vraca poruku greske koja se ispisuje u slucaju da validacija ne uspe.
     *
     * @return string
     */
    public function message()
    {
        return 'Korisničko ime može da sadrži cifre, tačke, znak _ i bar jedno slovo';
    }
}
