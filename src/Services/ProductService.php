<?php

namespace App\Services;
use App\Repositories\ProductRepository;

class ProductService
{
    public function __construct(
        private ProductRepository $productRepository
    ) {}
    public function getProducts(string $search): array
    {
        return $this->productRepository->getProducts($search);
    }
}