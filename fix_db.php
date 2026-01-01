<?php

require __DIR__ . '/vendor/autoload.php';

$app = require __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

$kernel->bootstrap();

use Illuminate\Support\Facades\Artisan;

echo "Running migrate:fresh --seed...\n";

try {
    Artisan::call('migrate:fresh', [
        '--seed' => true,
        '--force' => true,
    ]);
    echo Artisan::output();
    echo "\nSuccess!\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
