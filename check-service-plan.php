<?php
require 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\DedicatedInstance;
use App\Models\DedicatedPlan;

$service = DedicatedInstance::with('plan', 'service')->where('hetzner_server_id', 60882915)->first();

if ($service) {
    echo "=== DedicatedInstance ===\n";
    echo "ID: " . $service->id . "\n";
    echo "Name: " . $service->name . "\n";
    echo "Hetzner Server ID: " . $service->hetzner_server_id . "\n";
    echo "Server Type: " . $service->server_type . "\n";
    echo "Plan ID: " . $service->plan_id . "\n";
    echo "Service ID: " . $service->service_id . "\n";
    
    if ($service->plan) {
        echo "\n=== Related DedicatedPlan ===\n";
        echo "Plan ID: " . $service->plan->id . "\n";
        echo "Plan Name: " . $service->plan->name . "\n";
        echo "Plan Slug: " . $service->plan->slug . "\n";
        echo "Plan Monthly Price: $" . $service->plan->monthly_price . "/month\n";
    } else {
        echo "\n!!! No related plan found !!!\n";
    }
    
    if ($service->service) {
        echo "\n=== Related Service ===\n";
        echo "Service ID: " . $service->service->id . "\n";
        echo "Recurring Amount: $" . $service->service->recurring_amount . "/month\n";
        echo "Status: " . $service->service->status . "\n";
    }
} else {
    echo "DedicatedInstance not found\n";
}
