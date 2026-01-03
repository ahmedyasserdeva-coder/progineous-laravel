<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\DomainRegistrar;
use App\Services\DynadotService;

$registrar = DomainRegistrar::where('name', 'Dynadot')->first();

echo "=== Dynadot Registrar Settings ===" . PHP_EOL;
echo "test_mode: ";
var_dump($registrar->test_mode);
echo "API Key: " . substr($registrar->api_key, 0, 20) . "..." . PHP_EOL;
echo PHP_EOL;

// Check if test_mode should be true
if (!$registrar->test_mode && str_starts_with($registrar->api_key, 'sandbox_')) {
    echo "⚠️ API Key starts with 'sandbox_' but test_mode is not enabled!" . PHP_EOL;
    echo "Enabling test mode..." . PHP_EOL;
    $registrar->test_mode = true;
    $registrar->save();
    echo "✅ Test mode enabled!" . PHP_EOL;
    echo PHP_EOL;
}

// Now check Dynadot
echo "=== Checking Dynadot Sandbox API ===" . PHP_EOL;
$dynadot = new DynadotService($registrar);

// List domains
try {
    echo "Listing domains..." . PHP_EOL;
    $domains = $dynadot->listDomains();
    
    if (!empty($domains)) {
        echo "Found " . count($domains) . " domain(s):" . PHP_EOL;
        foreach ($domains as $domain) {
            $name = $domain['Name'] ?? $domain['DomainName'] ?? $domain['name'] ?? json_encode($domain);
            $status = $domain['Status'] ?? $domain['status'] ?? 'Unknown';
            echo "  - $name (Status: $status)" . PHP_EOL;
        }
    } else {
        echo "No domains found" . PHP_EOL;
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . PHP_EOL;
}

// Get open transfers
echo PHP_EOL . "=== Checking Open Transfers ===" . PHP_EOL;
try {
    // Call API directly for transfer list
    $reflection = new ReflectionClass($dynadot);
    $method = $reflection->getMethod('makeApiRequest');
    $method->setAccessible(true);
    
    $result = $method->invoke($dynadot, [
        'command' => 'list_transfer_in'
    ]);
    
    echo "Transfer In List:" . PHP_EOL;
    print_r($result);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . PHP_EOL;
}
