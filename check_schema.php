<?php
use Illuminate\Support\Facades\Schema;

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$columns = Schema::getColumnListing('bookings');
echo "Columns in bookings table:\n";
print_r($columns);

$hasColumn = Schema::hasColumn('bookings', 'midtrans_order_id');
echo "\nHas midtrans_order_id: " . ($hasColumn ? 'YES' : 'NO') . "\n";
