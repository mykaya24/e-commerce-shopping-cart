<?php

require_once __DIR__ . '/../vendor/autoload.php';

session_start();

if (!isset($_SESSION['sessionId'])) {
    $_SESSION['sessionId'] = bin2hex(random_bytes(16));
}

use App\Core\Router;

$router = new Router();
$router->dispatch();