<?php

/**
 *
 * Autor: Slobodan Katanic 2018/0133
 *
 */

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

/**
 * SubjectNameCheck - klasa koja vrsi proveru da li je naziv predmeta u odgovarajucem formatu.
 *
 * @package App\Rules
 * @version 1.0
 */
class SubjectNameCheck implements Rule
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
     * Utvrdjuje da li prosledjena vrednost za naziv predmeta ima odgovrajuci format.
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
     * Vraca poruku greske koja se ispisuje u slucaju da validacija ne uspe.
     *
     * @return string
     */
    public function message()
    {
        return 'Naziv predmeta moze sadržati samo slova i broj predmeta';
    }
}
