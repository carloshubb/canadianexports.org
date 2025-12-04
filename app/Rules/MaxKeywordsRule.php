<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class MaxKeywordsRule implements Rule
{
    public function passes($attribute, $value)
    {
        // Split the input by commas to get individual keywords
        $keywords = explode(',', $value);

        // Ensure there are no more than 5 keywords
        return count($keywords) <= 5;
    }

    public function message()
    {
        return 'Please limit the keywords and keyphrases to a max. Of 5';
    }
}
