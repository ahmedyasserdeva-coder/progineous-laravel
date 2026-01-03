<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$service = App\Models\Service::find(25);

echo "Service ID: " . $service->id . "\n";
echo "Service Name: " . $service->service_name . "\n";
echo "Username: " . $service->username . "\n";
echo "cPanel Username: " . $service->cpanel_username . "\n";
echo "Decrypted Password: " . $service->decrypted_password . "\n";
