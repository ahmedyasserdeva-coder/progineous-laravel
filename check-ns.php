<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$registrar = \App\Models\DomainRegistrar::where('type', 'dynadot')
    ->where('status', true)
    ->first();

$service = new \App\Services\DynadotService($registrar);

echo "=== Domain Info Raw ===\n";
$info = $service->getDomainInfoRaw('progineous.org');
print_r($info);

echo "\n=== Extracted Nameservers ===\n";
$ns = $service->getNameservers('progineous.org');
print_r($ns);
