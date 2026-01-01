<?php

$logFile = __DIR__ . '/db_fix_log.txt';
function logMsg($msg) {
    global $logFile;
    file_put_contents($logFile, $msg . "\n", FILE_APPEND);
}

$dbPath = __DIR__ . '/database/database.sqlite';

if (!file_exists($dbPath)) {
    logMsg("Database file not found at: $dbPath");
    exit(1);
}

logMsg("Database found at: $dbPath");

try {
    $pdo = new PDO("sqlite:$dbPath");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    logMsg("Connected to SQLite database.");

    // Check columns
    $stmt = $pdo->query("PRAGMA table_info(court_categories)");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $hasImage = false;
    logMsg("Columns in court_categories:");
    foreach ($columns as $col) {
        logMsg("- " . $col['name']);
        if ($col['name'] === 'image') {
            $hasImage = true;
        }
    }

    if (!$hasImage) {
        logMsg("Column 'image' is MISSING. Adding it now...");
        $pdo->exec("ALTER TABLE court_categories ADD COLUMN image VARCHAR(255) NULL");
        logMsg("Column 'image' added successfully.");
    } else {
        logMsg("Column 'image' ALREADY EXISTS.");
    }

} catch (PDOException $e) {
    logMsg("DB Error: " . $e->getMessage());
}
