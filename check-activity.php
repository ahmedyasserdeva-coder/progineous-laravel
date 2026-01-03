<?php
require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$domain = \App\Models\Domain::find(18);

// Add sample activities for the domain
$activities = [
    ['event' => 'created', 'description' => 'Domain registered', 'properties' => ['registrar' => 'Dynadot']],
    ['event' => 'updated', 'description' => 'Nameservers updated', 'properties' => ['old' => ['ns1.old.com', 'ns2.old.com'], 'new' => ['ns1.new.com', 'ns2.new.com']]],
    ['event' => 'updated', 'description' => 'Auto-renew enabled', 'properties' => ['auto_renew' => true]],
    ['event' => 'renewed', 'description' => 'Domain renewed for 1 year', 'properties' => ['years' => 1, 'old_expiry' => '2027-12-16', 'new_expiry' => '2028-12-16']],
];

foreach ($activities as $act) {
    activity()
        ->performedOn($domain)
        ->withProperties($act['properties'])
        ->event($act['event'])
        ->log($act['description']);
    echo "Logged: " . $act['description'] . PHP_EOL;
}

echo PHP_EOL . "Done! Activities added for domain 18" . PHP_EOL;

// Now verify
echo PHP_EOL . "=== Activities for Domain 18 ===" . PHP_EOL;
$spatieActivities = \Spatie\Activitylog\Models\Activity::where('subject_type', \App\Models\Domain::class)
    ->where('subject_id', 18)
    ->orderBy('id', 'desc')
    ->get();

echo "Count: " . $spatieActivities->count() . PHP_EOL;
foreach ($spatieActivities as $a) {
    echo "- " . $a->event . ": " . $a->description . PHP_EOL;
}
