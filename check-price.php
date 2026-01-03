<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$service = \App\Models\Service::where('type', 'dedicated')->first();
echo "=== Service Info ===\n";
echo "Service recurring_amount: $" . $service->recurring_amount . "\n";
echo "Billing cycle: " . $service->billing_cycle . "\n";

$serverData = is_string($service->server_data) ? json_decode($service->server_data, true) : $service->server_data;
echo "Server Type from DB: " . ($serverData['server_type'] ?? 'N/A') . "\n";

$h = app(\App\Services\HetznerService::class);
$server = $h->getServer($serverData['hetzner_server_id']);

echo "\n=== Hetzner Info ===\n";
echo "Server Type: " . $server['server_type']['name'] . "\n";
echo "Description: " . $server['server_type']['description'] . "\n";

// Find the correct location price
$location = $server['datacenter']['location']['name'];
echo "Server Location: " . $location . "\n\n";

echo "=== Prices by Location ===\n";
foreach ($server['server_type']['prices'] as $price) {
    $monthly = $price['price_monthly']['net'];
    $loc = $price['location'];
    $marker = ($loc === $location) ? ' <-- YOUR SERVER' : '';
    echo "$loc: \$$monthly/month$marker\n";
}
