<?php

namespace App\Models;

class CartItem
{
    public function __construct(
        public ?int $id,
        public int $cart_id,
        public Product $product,
        public int $quantity
    ) {}

    public function increase(int $qty): void
    {
        $this->quantity += $qty;
    }

    public function subtotal(): float
    {
        return $this->product->price * $this->quantity;
    }
    
}