<?php
require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Update domain expiry
$domain = \App\Models\Domain::where('domain_name', 'alrabwallc.net')->first();
if ($domain) {
    $newExpiry = \Carbon\Carbon::createFromTimestamp(1860594432927 / 1000);
    $domain->update(['expiry_date' => $newExpiry]);
    echo "Domain expiry updated to: " . $newExpiry . PHP_EOL;
}

// Update service for order 83
$order = \App\Models\Order::find(83);
if ($order) {
    foreach ($order->services as $service) {
        $service->update([
            'status' => 'active',
            'domain_registration_id' => $domain ? $domain->id : null,
            'server_data' => [
                'action' => 'renew',
                'registrar' => 'Dynadot',
                'renewed_at' => now()->toDateTimeString(),
                'years_added' => 1,
                'new_expiration' => 1860594432927,
            ]
        ]);
        echo "Service #{$service->id} updated to active" . PHP_EOL;
    }
}

echo PHP_EOL . "Done!" . PHP_EOL;
