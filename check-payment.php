<?php
require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$order = \App\Models\Order::find(87);
echo "Order: " . $order->order_number . PHP_EOL;
echo "Order payment_method: " . $order->payment_method . PHP_EOL;
echo "Invoice: " . ($order->invoice ? $order->invoice->invoice_number : 'No invoice') . PHP_EOL;

if($order->invoice) {
    echo "Payments count: " . $order->invoice->payments->count() . PHP_EOL;
    
    foreach($order->invoice->payments as $p) {
        echo "  - Gateway: " . $p->gateway . ", Amount: " . $p->amount . ", Status: " . $p->status . PHP_EOL;
    }
}
