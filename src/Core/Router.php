<?php

namespace App\Core;

class Router
{
    public function dispatch(): void
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        //echo $uri;
        switch (true) {
            case $method === 'GET' && $uri === '/api/products':
                (new \App\Controllers\ProductController())->index($_GET);
            break;
            case $method === 'GET' && preg_match('#^/api/products/(\d+)$#', $uri, $matches):
                $id = (int) $matches[1];
                (new \App\Controllers\ProductController())->show($id);
            break;
            case $method === 'GET' && $uri === '/api/categories':
                (new \App\Controllers\ProductController())->getAllCategory();
            break;

            case $method === 'GET' && $uri === '/api/cart':
                (new \App\Controllers\CartController())->show();
            break;
           
            default:
                http_response_code(404);
                echo json_encode(['error' => 'Not Found']);
        }
    }
}