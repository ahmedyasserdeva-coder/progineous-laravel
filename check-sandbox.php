<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\DomainRegistrar;

$registrar = DomainRegistrar::where('name', 'Dynadot')->first();

echo "=== Dynadot Registrar Settings ===" . PHP_EOL;
echo "sandbox_mode value: ";
var_dump($registrar->sandbox_mode);
echo "sandbox_mode type: " . gettype($registrar->sandbox_mode) . PHP_EOL;
echo "API Key: " . substr($registrar->api_key, 0, 20) . "..." . PHP_EOL;
echo PHP_EOL;

// Fix sandbox mode if needed
if (!$registrar->sandbox_mode && str_starts_with($registrar->api_key, 'sandbox_')) {
    echo "⚠️ API Key starts with 'sandbox_' but sandbox_mode is not enabled!" . PHP_EOL;
    echo "Enabling sandbox mode..." . PHP_EOL;
    $registrar->sandbox_mode = true;
    $registrar->save();
    echo "✅ Sandbox mode enabled!" . PHP_EOL;
}
