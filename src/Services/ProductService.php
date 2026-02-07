<?php

namespace App\Services;

use App\Models\Product;
use App\Repositories\ProductRepository;

class ProductService
{
    public function __construct(
        private ProductRepository $productRepository
    ) {}
    public function getProducts(array $parameters): array
    {
        return $this->productRepository->getProducts($parameters);
    }

    public function getProductById(int $id): Product   
    {
        return $this->productRepository->getProductById($id);
    }
    public function getAllCategory(): array
    {
        return $this->productRepository->getAllCategory();
    }
    
}