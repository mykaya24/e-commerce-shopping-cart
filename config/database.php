<?php
declare(strict_types=1);

use PDO;

$host = "127.0.0.1";
$db = "ecommerce";
$user = "root";
$password = "1100";

return new PDO(
    'mysql:host='.$host.';dbname='.$db.';charset=utf8mb4',
    $user,
    $password, // şifre
    [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]
);