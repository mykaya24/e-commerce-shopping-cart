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

            case $method === 'POST' && $uri === '/api/cart/items':
                (new \App\Controllers\CartController())->add();
            break;
           
            case $method === 'PUT' && preg_match('#^/api/cart/items/(\d+)$#', $uri, $matches):
                $id = (int) $matches[1];
                (new \App\Controllers\CartController())->cartProductUpdate($id);
            break;

            case $method === 'DELETE' && preg_match('#^/api/cart/items/(\d+)$#', $uri, $matches):
                $id = (int) $matches[1];
                (new \App\Controllers\CartController())->cartProductRemove($id);
            break;
            case $method === 'DELETE' && $uri === '/api/cart':
                (new \App\Controllers\CartController())->remove();
            break;

            default:
                http_response_code(404);
                echo json_encode(['error' => 'Not Found']);
        }
    }
}