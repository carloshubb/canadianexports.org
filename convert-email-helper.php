<?php

/**
 * Email Template Conversion Helper
 * 
 * This script helps you read Blade templates and prepare them for database entry.
 * 
 * Usage: php convert-email-helper.php <blade-file-path>
 * 
 * Example: php convert-email-helper.php resources/views/mails/become-sponsor.blade.php
 */

if ($argc < 2) {
    echo "Usage: php convert-email-helper.php <blade-file-path>\n";
    echo "Example: php convert-email-helper.php resources/views/mails/become-sponsor.blade.php\n";
    exit(1);
}

$filePath = $argv[1];

if (!file_exists($filePath)) {
    echo "Error: File not found: $filePath\n";
    exit(1);
}

$content = file_get_contents($filePath);
$fileName = basename($filePath, '.blade.php');

// Suggest key from filename
$suggestedKey = str_replace('-', '_', $fileName);
$suggestedKey = strtolower($suggestedKey);

echo "\n";
echo "========================================\n";
echo "Email Template Conversion Helper\n";
echo "========================================\n\n";
echo "File: $filePath\n";
echo "Suggested Key: $suggestedKey\n\n";
echo "Template Content (copy this to admin panel):\n";
echo "----------------------------------------\n";
echo $content;
echo "\n----------------------------------------\n\n";
echo "Next Steps:\n";
echo "1. Copy the template content above\n";
echo "2. Go to Admin → Email Templates → Create\n";
echo "3. Set Key: $suggestedKey\n";
echo "4. Paste template in Body (HTML) field\n";
echo "5. Update the corresponding Mailable class\n\n";


