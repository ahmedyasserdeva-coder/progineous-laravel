<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$s = App\Models\Service::find(56);

echo "=== Service 56 Info ===\n";
echo "service_name: " . $s->service_name . "\n";
echo "package_name: " . $s->package_name . "\n";
echo "domain: " . $s->domain . "\n";
