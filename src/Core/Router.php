<?php

namespace App\Core;

class Router
{
    public function dispatch(): void
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        switch (true) {
            case $method === 'GET' && $uri === '/products':
                (new \App\Controllers\ProductController())->index();
            break;
           
            default:
                http_response_code(404);
                echo json_encode(['error' => 'Not Found']);
        }
    }
}