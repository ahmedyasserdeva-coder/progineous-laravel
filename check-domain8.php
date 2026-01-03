<?php
require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$domain = \App\Models\Domain::find(8);

if ($domain) {
    echo "=== Domain #8 Details ===\n";
    echo "Domain Name: " . $domain->domain_name . "\n";
    echo "First Payment Amount: " . ($domain->first_payment_amount ?? 'NULL') . "\n";
    echo "Recurring Amount: " . ($domain->recurring_amount ?? 'NULL') . "\n";
    echo "Order ID: " . ($domain->order_id ?? 'NULL') . "\n";
    echo "Order Type: " . ($domain->order_type ?? 'NULL') . "\n";
    echo "Status: " . $domain->status . "\n";
    
    // Check related OrderItem
    if ($domain->order_id) {
        $orderItem = \App\Models\OrderItem::where('order_id', $domain->order_id)
            ->where('type', 'domain')
            ->first();
        if ($orderItem) {
            echo "\n=== Related OrderItem ===\n";
            echo "Unit Price: " . $orderItem->unit_price . "\n";
            echo "Total: " . $orderItem->total . "\n";
        }
    }
} else {
    echo "Domain #8 not found!\n";
}
