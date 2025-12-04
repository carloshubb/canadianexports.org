<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class MaxLines implements Rule
{
    protected $maxLines;

    public function __construct($maxLines = 5)
    {
        $this->maxLines = $maxLines;
    }

    public function passes($attribute, $value)
    {
        $lines = preg_split('/\r\n|\r|\n/', $value);
        return count($lines) <= $this->maxLines;
    }

    public function message()
    {
        return 'The :attribute may not contain more than ' . $this->maxLines . ' lines.';
    }
}