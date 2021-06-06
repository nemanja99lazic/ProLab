<?php

/**
 *
 * Autor: Slobodan Katanic 2018/0133
 *
 */

namespace App\Rules;

use App\NewSubjectRequest;
use App\Subject;
use Illuminate\Contracts\Validation\Rule;

class SubjectCodeCheck implements Rule
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
     * Utvrdjuje da li prosledjena vrednost za sifru predmeta zadovoljava pravilo.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value) {
        $subject = Subject::where('code', '=', $value)->first();
        if ($subject != null) {
            return False;
        }

        $requests = NewSubjectRequest::all();
        foreach ($requests as $request) {
            $code = explode('_', $request->subjectName)[1];
            if ($code == $value) {
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
    public function message() {
        return 'Uneta sifra vec postoji.';
    }
}
