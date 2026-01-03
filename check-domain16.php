<?php
require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== Last 10 Domains ===\n\n";
$domains = \App\Models\Domain::orderBy('id', 'desc')->take(10)->get();

foreach ($domains as $d) {
    echo "ID: {$d->id} | {$d->domain_name} | Status: {$d->status} | Type: {$d->order_type}\n";
}

echo "\n=== Domain #16 Details ===\n";
$domain = \App\Models\Domain::find(16);
if ($domain) {
    echo "Domain Name: " . $domain->domain_name . "\n";
    echo "TLD: " . $domain->tld . "\n";
    echo "Status: " . $domain->status . "\n";
    echo "Order Type: " . $domain->order_type . "\n";
    echo "Order ID: " . $domain->order_id . "\n";
    echo "Registration Period: " . $domain->registration_period . "\n";
    
    // Check OrderItem
    if ($domain->order_id) {
        $orderItem = \App\Models\OrderItem::where('order_id', $domain->order_id)
            ->where('type', 'domain')
            ->first();
        if ($orderItem) {
            echo "\nOrderItem Configuration:\n";
            print_r($orderItem->configuration);
        }
    }
} else {
    echo "Domain #16 not found!\n";
}
