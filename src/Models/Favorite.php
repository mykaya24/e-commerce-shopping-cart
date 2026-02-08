<?php

namespace App\Models;

class Favorite
{
    public function __construct(
        public ?int $id,
        public ?string $session_id,
        public Product $product
    ) {}
}