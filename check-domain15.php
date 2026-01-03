<?php
require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$domain = \App\Models\Domain::find(16);

if ($domain) {
    echo "=== Domain #15 Details ===\n";
    echo "Domain Name: " . $domain->domain_name . "\n";
    echo "TLD: " . $domain->tld . "\n";
    echo "Status: " . $domain->status . "\n";
    echo "Order Type: " . $domain->order_type . "\n";
    echo "Client ID: " . $domain->client_id . "\n";
    echo "Order ID: " . $domain->order_id . "\n";
    echo "Registration Period: " . $domain->registration_period . "\n";
    echo "Expiry Date: " . $domain->expiry_date . "\n";
    echo "\nConfiguration:\n";
    print_r($domain->configuration);
    
    // Check related OrderItem
    if ($domain->order_id) {
        $orderItem = \App\Models\OrderItem::where('order_id', $domain->order_id)
            ->where('type', 'domain')
            ->first();
        if ($orderItem) {
            echo "\n=== Related OrderItem ===\n";
            echo "OrderItem ID: " . $orderItem->id . "\n";
            echo "OrderItem Configuration:\n";
            print_r($orderItem->configuration);
        }
    }
} else {
    echo "Domain #15 not found!\n";
}
