<?php
declare(strict_types=1);

//$pdo = require __DIR__ . '/../config/database.php';

try {
    $pdo = require __DIR__ . '/../config/database.php';
    echo " Database connection successful\n";

    // Schema
    $schema = file_get_contents(__DIR__ . '/../sql/schema.sql');
    $pdo->exec($schema);
    echo " Schema created successfully\n";

    // Seed
    $seed = file_get_contents(__DIR__ . '/../sql/seed.sql');
    $pdo->exec($seed);
    echo " Seed data inserted successfully\n";

    echo "\n🎉 Installation completed successfully!\n";

} catch (Throwable $e) {
    echo " Installation failed:\n";
    echo $e->getMessage();
}