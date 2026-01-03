<?php
require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Check domain TLD
$domain = \App\Models\Domain::where('domain_name', 'google.com')->first();
if (!$domain) {
    $domain = \App\Models\Domain::first();
}
echo "Domain: " . $domain->domain_name . PHP_EOL;
echo "Domain TLD: [" . $domain->tld . "]" . PHP_EOL;

// Clean TLD (remove dot if present)
$tld = ltrim($domain->tld, '.');
echo "Cleaned TLD: [" . $tld . "]" . PHP_EOL;

$pricing = \App\Models\DomainPricing::where('tld', $tld)->first();

if ($pricing) {
    echo "TLD in pricing: " . $pricing->tld . PHP_EOL;
    echo "dynadot_renew: " . ($pricing->dynadot_renew ?? 'null') . PHP_EOL;
    echo "progineous_renew: " . ($pricing->progineous_renew ?? 'null') . PHP_EOL;
} else {
    echo "No pricing found for tld: " . $tld . PHP_EOL;
}

// Check with dot
$pricingWithDot = \App\Models\DomainPricing::where('tld', '.' . $tld)->first();
echo PHP_EOL . "Checking with dot (.com):" . PHP_EOL;
echo $pricingWithDot ? "Found" : "Not found";
echo PHP_EOL;
