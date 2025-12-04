<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class MaxWordsPerKeywordRule implements Rule
{
    public function passes($attribute, $value)
    {
        // Split the input by commas to get individual keywords
        $keywords = explode(',', $value);

        // Ensure each keyword has no more than 10 words
        foreach ($keywords as $keyword) {
            $keyword = explode(' ', $keyword);

            if (count($keyword) > 10) {
                return false;
            }
        }

        return true;
    }

    public function message()
    {
        return 'A keyphrase must not contain more than 10 words';
    }
}
