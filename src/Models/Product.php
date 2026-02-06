<?php

namespace App\Models;

class Product
{
    public function __construct(
        public int $id,
        public string $name,
        public string $description,
        public float $price,
        public int $stock,
        public Category $category,
        public string $image_url
    ) {}
}