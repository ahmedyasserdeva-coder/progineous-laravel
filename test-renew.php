<?php
require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Services\DynadotService;

$registrar = \App\Models\DomainRegistrar::first();
$service = new DynadotService($registrar);

$domain = 'alrabwallc.net';

echo "Testing renew for: " . $domain . PHP_EOL;
echo "=============================" . PHP_EOL;

try {
    $result = $service->renewDomain($domain, 1);
    echo "Renew Result:" . PHP_EOL;
    print_r($result);
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . PHP_EOL;
}
