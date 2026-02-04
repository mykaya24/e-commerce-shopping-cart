<?php

require_once __DIR__ . '/../vendor/autoload.php';

session_start();

use App\Core\Router;

$router = new Router();
$router->dispatch();