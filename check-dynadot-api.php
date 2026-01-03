<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\DomainRegistrar;
use Illuminate\Support\Facades\Http;

$registrar = DomainRegistrar::where('name', 'Dynadot')->first();

$apiKey = $registrar->api_key;
$testMode = $registrar->test_mode;

echo "Test Mode: " . ($testMode ? 'YES (Sandbox)' : 'NO (Production)') . PHP_EOL;
echo "API Key: " . substr($apiKey, 0, 20) . "..." . PHP_EOL . PHP_EOL;

// Use correct sandbox URL
$baseUrl = $testMode 
    ? 'https://api-sandbox.dynadot.com/api3.json'
    : 'https://api.dynadot.com/api3.json';

echo "Using URL: $baseUrl" . PHP_EOL . PHP_EOL;

// List domains
echo "=== List Domains ===" . PHP_EOL;
$response = Http::timeout(30)->get($baseUrl, [
    'key' => $apiKey,
    'command' => 'list_domain'
]);

$data = $response->json();
echo "Response Code: " . ($data['ListDomainInfoResponse']['ResponseCode'] ?? 'N/A') . PHP_EOL;

if (isset($data['ListDomainInfoResponse']['DomainInfoList'])) {
    $domains = $data['ListDomainInfoResponse']['DomainInfoList'];
    if (!empty($domains)) {
        echo "Found " . count($domains) . " domain(s):" . PHP_EOL;
        foreach ($domains as $domain) {
            $name = $domain['DomainInfo']['Name'] ?? $domain['DomainInfo']['Domain'] ?? 'Unknown';
            $status = $domain['DomainInfo']['Status'] ?? 'Unknown';
            $expiry = $domain['DomainInfo']['Expiration'] ?? 'Unknown';
            echo "  - $name (Status: $status, Expires: $expiry)" . PHP_EOL;
        }
    } else {
        echo "No domains in list" . PHP_EOL;
    }
} else {
    echo "Response:" . PHP_EOL;
    print_r($data);
}

// Check transfer in list
echo PHP_EOL . "=== List Transfer In ===" . PHP_EOL;
$response = Http::timeout(30)->get($baseUrl, [
    'key' => $apiKey,
    'command' => 'list_transfer_in'
]);

$data = $response->json();
echo "Response:" . PHP_EOL;
print_r($data);
