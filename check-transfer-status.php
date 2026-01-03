<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Services\DynadotService;
use App\Models\DomainRegistrar;

$registrar = DomainRegistrar::where('name', 'Dynadot')->where('status', true)->first();

if (!$registrar) {
    echo "Dynadot registrar not found or not active" . PHP_EOL;
    exit;
}

$dynadot = new DynadotService($registrar);

echo "=== Checking Transfer Status for test.com ===" . PHP_EOL . PHP_EOL;

// Check transfer status
try {
    $transferStatus = $dynadot->getTransferStatus('test.com');
    echo "Transfer Status Response:" . PHP_EOL;
    print_r($transferStatus);
} catch (Exception $e) {
    echo "Error checking transfer status: " . $e->getMessage() . PHP_EOL;
}

echo PHP_EOL . "=== Checking Domain Info ===" . PHP_EOL . PHP_EOL;

// Also check domain info
try {
    $domainInfo = $dynadot->getDomainInfo('test.com');
    echo "Domain Info:" . PHP_EOL;
    print_r($domainInfo);
} catch (Exception $e) {
    echo "Error getting domain info: " . $e->getMessage() . PHP_EOL;
}

echo PHP_EOL . "=== List All Domains in Dynadot Account ===" . PHP_EOL . PHP_EOL;

// List all domains
try {
    $domains = $dynadot->listDomains();
    if (!empty($domains)) {
        foreach ($domains as $domain) {
            $name = $domain['Name'] ?? $domain['name'] ?? 'Unknown';
            $status = $domain['Status'] ?? $domain['status'] ?? 'Unknown';
            $expiry = $domain['Expiration'] ?? $domain['expiration'] ?? 'Unknown';
            echo "- $name (Status: $status)" . PHP_EOL;
        }
    } else {
        echo "No domains found in account" . PHP_EOL;
    }
} catch (Exception $e) {
    echo "Error listing domains: " . $e->getMessage() . PHP_EOL;
}
