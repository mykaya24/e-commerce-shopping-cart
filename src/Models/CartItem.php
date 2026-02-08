<?php

namespace App\Models;

class CartItem implements \JsonSerializable
{
    public function __construct(
        public ?int $id,
        public int $cart_id,
        public Product $product,
        public int $quantity
    ) {}

    public function increase(int $quantity): void
    {
        $this->quantity += $quantity;
    }

    public function subtotal(): float
    {
        return $this->product->price * $this->quantity;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'quantity' => $this->quantity,
            'total' => $this->subtotal(),
            'product' => $this->product
        ];
    }
}
