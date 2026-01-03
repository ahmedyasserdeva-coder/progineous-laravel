<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\DomainRegistrar;
use Illuminate\Support\Facades\Http;

$registrar = DomainRegistrar::where('name', 'Dynadot')->where('status', true)->first();

if (!$registrar) {
    echo "Dynadot registrar not found" . PHP_EOL;
    exit;
}

$apiKey = $registrar->api_key;
$sandbox = $registrar->sandbox_mode ?? false;

echo "Sandbox Mode: " . ($sandbox ? 'YES' : 'NO') . PHP_EOL;
echo "API Key: " . substr($apiKey, 0, 10) . "..." . PHP_EOL . PHP_EOL;

$baseUrl = $sandbox 
    ? 'https://api.dynadot.com/api3.xml'  // Sandbox uses same URL but different key
    : 'https://api.dynadot.com/api3.xml';

// Check transfer status
echo "=== Checking Transfer Status ===" . PHP_EOL;
$url = $baseUrl . '?' . http_build_query([
    'key' => $apiKey,
    'command' => 'get_transfer_status',
    'domain' => 'test.com'
]);

$response = Http::timeout(30)->get($url);
echo "HTTP Status: " . $response->status() . PHP_EOL;
echo "Response:" . PHP_EOL;
echo $response->body() . PHP_EOL . PHP_EOL;

// List domains
echo "=== List Domains ===" . PHP_EOL;
$url = $baseUrl . '?' . http_build_query([
    'key' => $apiKey,
    'command' => 'list_domain'
]);

$response = Http::timeout(30)->get($url);
echo "HTTP Status: " . $response->status() . PHP_EOL;
echo "Response:" . PHP_EOL;
echo $response->body() . PHP_EOL . PHP_EOL;

// Check pending transfers
echo "=== Get Transfer History ===" . PHP_EOL;
$url = $baseUrl . '?' . http_build_query([
    'key' => $apiKey,
    'command' => 'get_open_transfer'
]);

$response = Http::timeout(30)->get($url);
echo "HTTP Status: " . $response->status() . PHP_EOL;
echo "Response:" . PHP_EOL;
echo $response->body() . PHP_EOL;
