<?php

namespace App\Models;

class Product implements \JsonSerializable
{
    public function __construct(
        public int $id,
        public string $name,
        public string $description,
        public float $price,
        public int $stock,
        public Category $category,
        public string $imageUrl
    ) {}
    public function getStock():int{
        return $this->stock;
    }
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' => $this->price,
            'stock' => $this->stock,
            'category' => $this->category,
            'image_url' => $this->imageUrl
        ];
    }
}