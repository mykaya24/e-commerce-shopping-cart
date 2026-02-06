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

    public function index(array $parameters): void
    {
        $products = $this->productService->getProducts($parameters);
        Response::success($products,"process done");
    }
    public function show(int $id): void
    {
        $product = $this->productService->getProductById($id);
        Response::success($product,"process done");
    }
    public function getAllCategory(): void
    {
        $product = $this->productService->getAllCategory();
        Response::success($product,"process done");
    }
    

}