<?php

use App\Models\Office;

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$offices = Office::select('id', 'name', 'code', 'acronym')->get();

echo "Total offices: " . $offices->count() . "\n\n";

foreach ($offices as $office) {
    echo "ID: {$office->id} | Code: {$office->code} | Name: {$office->name}\n";
}
