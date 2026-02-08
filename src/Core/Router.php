<?php

namespace App\Core;

use App\Controllers\CartController;
use App\Controllers\FavoriteController;
use App\Controllers\ProductController;

class Router
{
    public function dispatch(): void
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        //echo $uri;
        switch (true) {
            case $method === 'GET' && $uri === '/api/products':
                (new ProductController())->index($_GET);
            break;
            case $method === 'GET' && preg_match('#^/api/products/(\d+)$#', $uri, $matches):
                $id = (int) $matches[1];
                (new ProductController())->show($id);
            break;
            case $method === 'GET' && $uri === '/api/categories':
                (new ProductController())->getAllCategory();
            break;

            case $method === 'GET' && $uri === '/api/cart':
                (new CartController())->show();
            break;

            case $method === 'POST' && $uri === '/api/cart/items':
                (new CartController())->add();
            break;
           
            case $method === 'PUT' && preg_match('#^/api/cart/items/(\d+)$#', $uri, $matches):
                $id = (int) $matches[1];
                (new CartController())->cartProductUpdate($id);
            break;

            case $method === 'DELETE' && preg_match('#^/api/cart/items/(\d+)$#', $uri, $matches):
                $id = (int) $matches[1];
                (new CartController())->cartProductRemove($id);
            break;
            case $method === 'DELETE' && $uri === '/api/cart':
                (new CartController())->remove();
            break;

            case $method === 'GET' && $uri === '/api/favorites':
                (new FavoriteController())->show();
            break;
            case $method === 'POST' && $uri === '/api/favorites':
                (new FavoriteController())->addNewProduct();
            break;

            case $method === 'DELETE' && preg_match('#^/api/favorites/(\d+)$#', $uri, $matches):
                $productId = (int) $matches[1];
                (new FavoriteController())->remove($productId);
            break;

            case $method === 'POST' && preg_match('#^/api/favorites/(\d+)/add-to-cart$#', $uri, $matches):
                $productId = (int) $matches[1];
                (new FavoriteController())->addFavoriteProductToCart($productId);
            break;

            case $method === 'POST' && $uri === '/api/cart/coupon':
                (new CartController())->applyCoupon();
            break;

            case $method === 'DELETE' && $uri === '/api/cart/coupon':
                (new CartController())->removeCoupon();
            break;

            default:
                http_response_code(404);
                echo json_encode(['error' => 'Not Found URL']);
        }
    }
}