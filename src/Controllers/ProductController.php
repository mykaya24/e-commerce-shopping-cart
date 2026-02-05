<?php

namespace App\Controllers;

use App\Helpers\Response;
use App\Services\ProductService;
use App\Repositories\ProductRepository;

class ProductController
{
    private ProductService $productService;

    public function __construct()
    {
        $this->productService = new ProductService(
            new ProductRepository()
        );
    }

    public function index(): void
    {
        $products = $this->productService->getProducts("bulaşık");
        Response::success($products,"process done");
    }
}