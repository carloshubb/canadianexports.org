<?php

// Test script to diagnose queue email issues
// Run with: php test-queue-email.php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;

echo "=== Checking Failed Jobs ===\n\n";

$failedJob = DB::table('failed_jobs')
    ->orderBy('failed_at', 'desc')
    ->first();

if ($failedJob) {
    echo "Latest Failed Job:\n";
    echo "UUID: " . $failedJob->uuid . "\n";
    echo "Failed At: " . $failedJob->failed_at . "\n\n";
    
    echo "Exception:\n";
    echo "==========\n";
    echo $failedJob->exception;
    echo "\n==========\n";
} else {
    echo "No failed jobs found.\n";
}

echo "\n=== Checking EmailTemplate Table ===\n\n";

try {
    $count = DB::table('email_templates')->count();
    echo "Email templates count: $count\n";
    
    $verifyTemplate = DB::table('email_templates')
        ->where('key', 'customer_verify_email')
        ->first();
    
    if ($verifyTemplate) {
        echo "✅ customer_verify_email template exists\n";
        echo "   - Active: " . ($verifyTemplate->is_active ? 'Yes' : 'No') . "\n";
        echo "   - Subject: " . $verifyTemplate->subject . "\n";
    } else {
        echo "❌ customer_verify_email template NOT FOUND\n";
    }
} catch (\Exception $e) {
    echo "❌ Error accessing email_templates: " . $e->getMessage() . "\n";
}

echo "\n=== Checking Views ===\n\n";

$views = [
    'mails.customer-verify-email',
    'mails.dynamic-markdown'
];

foreach ($views as $view) {
    $path = resource_path('views/' . str_replace('.', '/', $view) . '.blade.php');
    if (file_exists($path)) {
        echo "✅ $view exists\n";
    } else {
        echo "❌ $view NOT FOUND at: $path\n";
    }
}

echo "\n=== Done ===\n";

