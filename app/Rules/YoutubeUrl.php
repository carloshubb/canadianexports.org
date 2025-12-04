<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class YoutubeUrl implements Rule
{
    public function passes($attribute, $value)
    {
        // Regular expression for a valid YouTube URL
        // $pattern = '/(youtube.com|youtu.be)\/(watch)?(\?v=)?(\S+)?/';

        // return preg_match($pattern, $value);
        $pattern = '/^(https?:\/\/)?(www\.)?(youtube\.com|youtu\.be)(\/.*)?$/i';

        return preg_match($pattern, $value);
    }

    public function message()
    {
        return 'The :attribute must be a valid YouTube URL.';
    }
}
