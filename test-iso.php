<?php
require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$hetznerService = app(\App\Services\HetznerService::class);

// Get a sample server ID from a service
$service = \App\Models\Service::where('type', 'dedicated')
    ->whereNotNull('server_data')
    ->first();

if (!$service) {
    echo "No dedicated service found\n";
    exit;
}

$serverData = is_string($service->server_data) 
    ? json_decode($service->server_data, true) 
    : $service->server_data;

if (!isset($serverData['hetzner_server_id'])) {
    echo "No hetzner_server_id found in service\n";
    exit;
}

$serverId = $serverData['hetzner_server_id'];
echo "Server ID: $serverId\n\n";

// Get server details
echo "=== Server Details ===\n";
$server = $hetznerService->getServer($serverId);
print_r($server);
echo "\n\nServer Name: " . ($server['server']['name'] ?? 'N/A') . "\n";
echo "Mounted ISO: ";
if (isset($server['server']['iso']) && $server['server']['iso']) {
    print_r($server['server']['iso']);
} else {
    echo "No ISO mounted\n";
}

// Get available ISO images
echo "\n=== Available ISO Images ===\n";
$isos = $hetznerService->getISOImages();
echo "Total ISOs: " . count($isos) . "\n\n";

// Show first 10 ISOs
foreach (array_slice($isos, 0, 10) as $iso) {
    echo "- [{$iso['id']}] {$iso['name']} - {$iso['description']}\n";
}
