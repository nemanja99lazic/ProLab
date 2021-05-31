<?php

namespace App\Rules;

use App\NewSubjectRequest;
use App\Subject;
use Illuminate\Contracts\Validation\Rule;

class SubjectCodeCheck implements Rule
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
     * Get the validation error message.
     *
     * @return string
     */
    public function message() {
        return 'Uneta sifra vec postoji.';
    }
}
