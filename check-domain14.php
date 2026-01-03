<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$domain = \App\Models\Domain::find(14);

if ($domain) {
    echo "=== Domain #14 ===" . PHP_EOL;
    echo "Domain Name: " . $domain->domain_name . PHP_EOL;
    echo "Status: " . $domain->status . PHP_EOL;
    echo "Order Type: " . $domain->order_type . PHP_EOL;
    echo "Order ID: " . $domain->order_id . PHP_EOL;
    echo "Registration Period: " . $domain->registration_period . PHP_EOL;
    echo "TLD: " . $domain->tld . PHP_EOL;
    echo "Created: " . $domain->created_at . PHP_EOL;
    echo "Expiry: " . $domain->expiry_date . PHP_EOL;
    
    echo PHP_EOL . "=== Nameservers ===" . PHP_EOL;
    print_r($domain->nameservers);
    
    // Check the order item
    if ($domain->order_id) {
        $orderItem = \App\Models\OrderItem::where('order_id', $domain->order_id)
            ->where('type', 'domain')
            ->first();
        
        if ($orderItem) {
            echo PHP_EOL . "=== Order Item ===" . PHP_EOL;
            echo "Product Name: " . $orderItem->product_name . PHP_EOL;
            echo "Configuration:" . PHP_EOL;
            print_r($orderItem->configuration);
        }
        
        // Check order
        $order = \App\Models\Order::find($domain->order_id);
        if ($order) {
            echo PHP_EOL . "=== Order ===" . PHP_EOL;
            echo "Order #: " . $order->id . PHP_EOL;
            echo "Status: " . $order->status . PHP_EOL;
            echo "Payment Status: " . $order->payment_status . PHP_EOL;
        }
    }
    
    // Check service
    $service = \App\Models\Service::where('domain_registration_id', 14)->first();
    if ($service) {
        echo PHP_EOL . "=== Service ===" . PHP_EOL;
        echo "Service ID: " . $service->id . PHP_EOL;
        echo "Status: " . $service->status . PHP_EOL;
        echo "Server Data:" . PHP_EOL;
        print_r($service->server_data);
    }
} else {
    echo "Domain #14 not found" . PHP_EOL;
}
