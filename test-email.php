<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\Mail;

try {
    Mail::raw('This is a test email from Canadian Exports', function ($message) {
        $message->to('test@example.com')
                ->subject('Test Email - Canadian Exports');
    });
    
    echo "✅ Email sent successfully!\n";
    echo "If MAIL_MAILER=log, check storage/logs/laravel.log\n";
    echo "If MAIL_MAILER=smtp, check the recipient inbox\n";
} catch (Exception $e) {
    echo "❌ Email failed: " . $e->getMessage() . "\n";
}
