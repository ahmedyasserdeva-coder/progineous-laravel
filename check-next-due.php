<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$domain = \App\Models\Domain::find(18);

echo "Domain: " . $domain->domain_name . PHP_EOL;
echo "next_due_date: " . ($domain->next_due_date ?? 'NULL') . PHP_EOL;
echo "expiry_date: " . ($domain->expiry_date ?? 'NULL') . PHP_EOL;
echo "registration_date: " . ($domain->registration_date ?? 'NULL') . PHP_EOL;

// Check related service
$service = $domain->service;
if ($service) {
    echo PHP_EOL . "Related Service:" . PHP_EOL;
    echo "service_id: " . $service->id . PHP_EOL;
    echo "billing_cycle: " . ($service->billing_cycle ?? 'NULL') . PHP_EOL;
    echo "service next_due_date: " . ($service->next_due_date ?? 'NULL') . PHP_EOL;
    echo "recurring_amount: " . ($service->recurring_amount ?? 'NULL') . PHP_EOL;
}

// Check order item
$orderItem = \App\Models\OrderItem::where('id', $service->order_item_id)->first();
if ($orderItem) {
    echo PHP_EOL . "Order Item:" . PHP_EOL;
    echo "configuration: " . json_encode($orderItem->configuration, JSON_PRETTY_PRINT) . PHP_EOL;
}
