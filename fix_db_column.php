<?php
try {
    $dbPath = __DIR__ . '/database/database.sqlite';
    echo "Connecting to DB at: $dbPath\n";
    
    $pdo = new PDO('sqlite:' . $dbPath);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if column exists first to avoid error
    $columns = $pdo->query("PRAGMA table_info(bookings)")->fetchAll(PDO::FETCH_ASSOC);
    $exists = false;
    foreach ($columns as $col) {
        if ($col['name'] === 'midtrans_order_id') {
            $exists = true;
            break;
        }
    }

    if (!$exists) {
        $pdo->exec("ALTER TABLE bookings ADD COLUMN midtrans_order_id VARCHAR(255) NULL");
        echo "SUCCESS: Column 'midtrans_order_id' added to 'bookings' table.\n";
    } else {
        echo "INFO: Column 'midtrans_order_id' already exists.\n";
    }

} catch (PDOException $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
