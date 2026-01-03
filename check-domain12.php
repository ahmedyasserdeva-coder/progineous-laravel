<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$domain = App\Models\Domain::find(12);

if (!$domain) {
    echo "Domain not found\n";
    exit;
}

echo "=== Domain #12 Details ===\n";
echo "Domain Name: " . $domain->domain_name . "\n";
echo "Status: " . $domain->status . "\n";
echo "Order Type: " . $domain->order_type . "\n";
echo "Registration Period: " . $domain->registration_period . " years\n";
echo "Registration Date: " . ($domain->registration_date ?? 'NULL') . "\n";
echo "Expiry Date: " . ($domain->expiry_date ?? 'NULL') . "\n";
echo "Registrar Domain ID: " . ($domain->registrar_domain_id ?? 'NULL') . "\n";

// Check related service
$service = App\Models\Service::where('domain_registration_id', $domain->id)->first();
if ($service) {
    echo "\n=== Related Service ===\n";
    echo "Service ID: " . $service->id . "\n";
    echo "Service Status: " . $service->status . "\n";
    echo "Server Data:\n";
    print_r($service->server_data);
}

// Check order
$order = App\Models\Order::find($domain->order_id);
if ($order) {
    echo "\n=== Related Order ===\n";
    echo "Order ID: " . $order->id . "\n";
    echo "Order Status: " . $order->status . "\n";
    echo "Payment Status: " . $order->payment_status . "\n";
}
