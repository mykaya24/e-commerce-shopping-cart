<?php

namespace App\Services;

use App\Exceptions\CategoryNotFoundException;
use App\Exceptions\ProductNotFoundException;
use App\Models\Product;
use App\Repositories\ProductRepository;

class ProductService
{
    public function __construct(
        private ProductRepository $productRepository
    ) {}
    public function getProducts(array $parameters): array
    {
        $product = $this->productRepository->getProducts($parameters);
        if (!$product)
            throw new ProductNotFoundException();
        return $product;    
    }

    public function getProductById(int $id): Product   
    {
        $product = $this->productRepository->getProductById($id);
        if (!$product)
            throw new ProductNotFoundException();
        return $product; 
    }
    public function getAllCategory(): array
    {
        $category = $this->productRepository->getAllCategory();
        if (!$category)
            throw new CategoryNotFoundException();
        return $category;
    }
    
}