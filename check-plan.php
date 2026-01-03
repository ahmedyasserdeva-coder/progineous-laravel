<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$plan = \App\Models\DedicatedPlan::where('hetzner_server_type', 'ccx13')->first();

if ($plan) {
    echo "=== DedicatedPlan CCX13 ===\n";
    echo "Plan Name: " . $plan->plan_name . "\n";
    echo "Monthly Price: $" . $plan->monthly_price . "\n";
    echo "Updated at: " . $plan->updated_at . "\n";
} else {
    echo "Plan CCX13 not found in database\n";
}

echo "\n=== All DedicatedPlans ===\n";
$plans = \App\Models\DedicatedPlan::all();
foreach ($plans as $p) {
    echo $p->hetzner_server_type . " - $" . $p->monthly_price . "/month\n";
}
