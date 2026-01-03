<?php
require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Check DomainRegistrar in database
$registrar = \App\Models\DomainRegistrar::where('name', 'LIKE', '%dynadot%')->first();
echo "=== DomainRegistrar from Database ===\n";
if ($registrar) {
    echo "ID: " . $registrar->id . "\n";
    echo "Name: " . $registrar->name . "\n";
    echo "Test Mode: " . ($registrar->test_mode ? 'Yes' : 'No') . "\n";
    echo "API Key (first 10): " . substr($registrar->api_key, 0, 10) . "...\n\n";
    
    // Use this registrar to create service
    $ds = new \App\Services\DynadotService($registrar);
    
    echo "=== Listing domains from Dynadot ===\n";
    try {
        $result = $ds->listDomains();
        print_r($result);
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
} else {
    echo "DomainRegistrar not found!\n";
}
