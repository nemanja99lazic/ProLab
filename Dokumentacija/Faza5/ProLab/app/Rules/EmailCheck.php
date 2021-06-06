<?php

/**
 *
 * Autor: Slobodan Katanic 2018/0133
 *
 */

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

/**
 * EmailCheck - klasa koja vrsi proveru da li je email adresa u odgovarajucem formatu.
 *
 * @package App\Rules
 * @version 1.0
 */
class EmailCheck implements Rule
{
    /**
     * Sadrzi informaciju o tipi korisnika, koji se prosledjuje kroz konstruktor.
     *
     * @var string
     */
    private $userType;

    /**
     * Kreiranje nove instance.
     *
     * @param string $userType
     */
    public function __construct($userType) {
        $this->userType = $userType;
    }

    /**
     * Utvrdjuje da li prosledjena vrednost za email zadovoljava odgovarajuci format.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value) {
        if ($this->userType == 'teacher') {
            if (!preg_match("/^[a-zA-Z0-9][a-zA-Z0-9\.-_]*[a-zA-Z0-9]@etf(\.bg\.ac)?\.rs$/", $value)) {
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
            if (!preg_match("/^[a-zA-Z0-9][a-zA-Z0-9\.-_]*[a-zA-Z0-9]@admin.etf(\.bg\.ac)?\.rs$/", $value)) {
                return False;
            } else {
                return True;
            }
        }
    }

    /**
     * Vraca poruku greske koja se ispisuje u slucaju da validacija ne uspe.
     *
     * @return string
     */
    public function message() {

        return 'Neispravan format email adrese.';

    }
}
