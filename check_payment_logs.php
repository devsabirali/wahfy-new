<?php
/**
 * Simple script to check payment-related logs
 * Run this script to see recent payment processing logs
 */

$logFile = 'storage/logs/laravel.log';

if (!file_exists($logFile)) {
    echo "Log file not found: $logFile\n";
    exit(1);
}

echo "=== Recent Payment Processing Logs ===\n\n";

$lines = file($logFile);
$paymentLines = [];

// Get last 100 lines and filter for payment-related logs
$recentLines = array_slice($lines, -100);
foreach ($recentLines as $line) {
    if (strpos($line, 'Payment processing') !== false || 
        strpos($line, 'payment') !== false ||
        strpos($line, 'Payment') !== false ||
        strpos($line, 'Stripe') !== false ||
        strpos($line, 'contribution') !== false) {
        $paymentLines[] = $line;
    }
}

if (empty($paymentLines)) {
    echo "No payment-related logs found in recent entries.\n";
} else {
    echo "Found " . count($paymentLines) . " payment-related log entries:\n\n";
    foreach ($paymentLines as $line) {
        echo $line;
    }
}

echo "\n=== End of Payment Logs ===\n";
echo "To see all logs, check: $logFile\n";
echo "To monitor logs in real-time, run: tail -f $logFile\n";
