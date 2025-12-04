<?php

/**
 * Mail Classes Checker
 * 
 * This script helps identify which mail classes in app/Mail/ 
 * still need to have the HasUnsubscribeLink trait added.
 * 
 * Usage: php check-mail-classes.php
 */

$mailDirectory = __DIR__ . '/app/Mail';
$results = [
    'updated' => [],
    'needs_update' => [],
    'total' => 0,
];

// Skip these transactional emails
$skipList = [
    'CustomerVerifyEmailMail.php',
    'CustomerResetPasswordMail.php',
    'CustomerPasswordResetSuccessMail.php',
];

echo "\n" . str_repeat("=", 70) . "\n";
echo "  EMAIL UNSUBSCRIBE IMPLEMENTATION CHECKER\n";
echo str_repeat("=", 70) . "\n\n";

if (!is_dir($mailDirectory)) {
    echo "❌ Error: Mail directory not found: $mailDirectory\n";
    exit(1);
}

$files = glob($mailDirectory . '/*.php');

foreach ($files as $file) {
    $filename = basename($file);
    $results['total']++;
    
    // Skip transactional emails
    if (in_array($filename, $skipList)) {
        continue;
    }
    
    $content = file_get_contents($file);
    
    // Check if the file has HasUnsubscribeLink trait
    if (strpos($content, 'HasUnsubscribeLink') !== false) {
        $results['updated'][] = $filename;
    } else {
        $results['needs_update'][] = $filename;
    }
}

// Display results
echo "📊 SUMMARY\n";
echo str_repeat("-", 70) . "\n";
echo sprintf("Total Mail Classes: %d\n", $results['total']);
echo sprintf("✅ Already Updated: %d\n", count($results['updated']));
echo sprintf("📝 Need Update: %d\n", count($results['needs_update']));
echo sprintf("⏭️  Skipped (Transactional): %d\n", count($skipList));
echo "\n";

// Show which are already updated
if (!empty($results['updated'])) {
    echo "✅ ALREADY UPDATED WITH UNSUBSCRIBE:\n";
    echo str_repeat("-", 70) . "\n";
    foreach ($results['updated'] as $file) {
        echo "  ✓ $file\n";
    }
    echo "\n";
}

// Show which need updating
if (!empty($results['needs_update'])) {
    echo "📝 NEED TO BE UPDATED:\n";
    echo str_repeat("-", 70) . "\n";
    
    // Categorize by priority
    $highPriority = [
        'InfoLetterMail.php',
        'AutoInfoLetterToCustomerMail.php',
        'CustomerMembershipExpiryMail.php',
        'AdminMembershipExpiryMail.php',
    ];
    
    $mediumPriority = [
        'ScamAlertMail.php',
        'SuccessStoriesMail.php',
        'TestimonialMail.php',
        'WelcomeEventMail.php',
    ];
    
    $high = array_intersect($results['needs_update'], $highPriority);
    $medium = array_intersect($results['needs_update'], $mediumPriority);
    $low = array_diff($results['needs_update'], $highPriority, $mediumPriority);
    
    if (!empty($high)) {
        echo "\n  🔴 HIGH PRIORITY:\n";
        foreach ($high as $file) {
            echo "     • $file\n";
        }
    }
    
    if (!empty($medium)) {
        echo "\n  🟡 MEDIUM PRIORITY:\n";
        foreach ($medium as $file) {
            echo "     • $file\n";
        }
    }
    
    if (!empty($low)) {
        echo "\n  ⚪ LOW PRIORITY:\n";
        foreach ($low as $file) {
            echo "     • $file\n";
        }
    }
    
    echo "\n";
}

// Show skipped files
echo "⏭️  SKIPPED (TRANSACTIONAL EMAILS):\n";
echo str_repeat("-", 70) . "\n";
foreach ($skipList as $file) {
    if (file_exists($mailDirectory . '/' . $file)) {
        echo "  ⊘ $file\n";
    }
}
echo "\n";

// Instructions
echo str_repeat("=", 70) . "\n";
echo "📚 NEXT STEPS:\n";
echo str_repeat("-", 70) . "\n";
echo "1. Start with HIGH PRIORITY emails\n";
echo "2. Follow the quick reference guide: UNSUBSCRIBE_QUICK_REFERENCE.md\n";
echo "3. Test each email after updating\n";
echo "4. Run this script again to track progress\n";
echo "\n";
echo "💡 TIP: Update one email at a time and test thoroughly\n";
echo str_repeat("=", 70) . "\n\n";

// Calculate progress
$toUpdate = count($results['needs_update']);
$completed = count($results['updated']);
$total = $toUpdate + $completed;
$percentage = $total > 0 ? round(($completed / $total) * 100) : 0;

echo "📈 PROGRESS: $completed/$total ($percentage% complete)\n";
echo "Progress Bar: [";
$barLength = 50;
$filledLength = round($barLength * ($percentage / 100));
echo str_repeat("█", $filledLength);
echo str_repeat("░", $barLength - $filledLength);
echo "] $percentage%\n\n";

exit(0);

