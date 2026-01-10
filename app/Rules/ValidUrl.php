<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidUrl implements Rule
{
    public function passes($attribute, $value)
    {
        // Use PHP's built-in URL validator which is more reliable and accepts all valid URL characters
        // This will accept URLs with @ signs, special characters, and any valid URL format
        if (empty($value)) {
            return true; // Allow empty values (handled by 'nullable' rule)
        }
        
        // First try PHP's built-in URL validator
        $filtered = filter_var($value, FILTER_VALIDATE_URL);
        if ($filtered !== false) {
            return true;
        }
        
        // Fallback: More permissive regex pattern that accepts any valid URL characters
        // This pattern accepts: protocol (optional), domain, and any path/query/fragment
        $pattern = '/^(https?:\/\/)?([a-zA-Z0-9]([a-zA-Z0-9\-]{0,61}[a-zA-Z0-9])?\.)+[a-zA-Z]{2,}(\/.*)?$/i';
        
        return preg_match($pattern, $value);
    }

    public function message()
    {
        return 'Please enter a valid URL';
    }
}
