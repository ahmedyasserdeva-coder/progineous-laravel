<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\DomainRegistrar;
use App\Services\DynadotService;

$registrar = DomainRegistrar::where('name', 'Dynadot')->first();

echo "=== Dynadot Transfer Test ===" . PHP_EOL;
echo "Test Mode: " . ($registrar->test_mode ? 'YES (Sandbox)' : 'NO (Production)') . PHP_EOL;
echo PHP_EOL;

$dynadot = new DynadotService($registrar);

// Test transfer for test.com
$domain = 'test.com';
$authCode = 'TEST123'; // Dummy auth code for sandbox

echo "Testing transfer for: $domain" . PHP_EOL;
echo "Auth Code: $authCode" . PHP_EOL;
echo PHP_EOL;

try {
    $result = $dynadot->transferDomain($domain, $authCode);
    
    echo "Transfer Result:" . PHP_EOL;
    print_r($result);
    
    // Check if transfer was successful
    if (isset($result['TransferResponse'])) {
        $response = $result['TransferResponse'];
        echo PHP_EOL . "=== Transfer Response Details ===" . PHP_EOL;
        echo "Response Code: " . ($response['ResponseCode'] ?? 'N/A') . PHP_EOL;
        echo "Status: " . ($response['Status'] ?? 'N/A') . PHP_EOL;
        
        if (isset($response['TransferId'])) {
            echo "Transfer ID: " . $response['TransferId'] . PHP_EOL;
        }
        
        if (isset($response['Error'])) {
            echo "Error: " . $response['Error'] . PHP_EOL;
        }
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . PHP_EOL;
    echo PHP_EOL . "Check laravel.log for details" . PHP_EOL;
}

// Also check the logs
echo PHP_EOL . "=== Recent Log Entries ===" . PHP_EOL;
$logFile = 'storage/logs/laravel.log';
$lines = file($logFile);
$lastLines = array_slice($lines, -30);
foreach ($lastLines as $line) {
    if (strpos($line, 'transferDomain') !== false || strpos($line, 'transfer') !== false) {
        echo $line;
    }
}
