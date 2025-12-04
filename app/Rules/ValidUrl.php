<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidUrl implements Rule
{
    public function passes($attribute, $value)
    {
        // Regular expression for URL validation
        // $pattern = '/^(http(s)?:\/\/)?(www\.)?[a-zA-Z0-9-]+\.[a-zA-Z]{2,}([\/][a-zA-Z0-9-\/\.]*)?$/';


        // return preg_match($pattern, $value);
        $pattern = '/^(https?:\/\/)?([a-zA-Z0-9-]+\.)+[a-zA-Z]{2,}(\/[\@a-zA-Z0-9-\/._?&=#]*)?$/i';

        return preg_match($pattern, $value);
        // return true;
    }

    public function message()
    {
        return 'The :attribute is not a valid URL.';
    }
}
