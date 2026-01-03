<?php
require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Check order 83
$order = \App\Models\Order::with(['items', 'services'])->find(83);

if ($order) {
    echo "Order #" . $order->id . PHP_EOL;
    echo "Status: " . $order->status . PHP_EOL;
    echo "Total: " . $order->total . PHP_EOL;
    
    echo PHP_EOL . "Order Items:" . PHP_EOL;
    foreach ($order->items as $item) {
        echo "- " . $item->item_type . ": " . $item->item_name . PHP_EOL;
        echo "  Configuration: " . json_encode($item->configuration) . PHP_EOL;
    }
    
    echo PHP_EOL . "Services:" . PHP_EOL;
    foreach ($order->services as $service) {
        echo "- " . $service->name . PHP_EOL;
        echo "  Status: " . $service->status . PHP_EOL;
        echo "  Server Data: " . json_encode($service->server_data) . PHP_EOL;
    }
} else {
    echo "Order 83 not found" . PHP_EOL;
}

// Check domain alrabwallc.net
echo PHP_EOL . "Domain alrabwallc.net:" . PHP_EOL;
$domain = \App\Models\Domain::where('domain_name', 'alrabwallc.net')->first();
if ($domain) {
    echo "ID: " . $domain->id . PHP_EOL;
    echo "Status: " . $domain->status . PHP_EOL;
    echo "Order Type: " . $domain->order_type . PHP_EOL;
    echo "Expiry: " . ($domain->expiry_date ?? 'null') . PHP_EOL;
} else {
    echo "Domain not found in domains table" . PHP_EOL;
}
