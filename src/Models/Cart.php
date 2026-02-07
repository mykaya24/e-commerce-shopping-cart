<?php

namespace App\Models;

class Cart
{
    public array $items = [];

    public function __construct(
        public int $id,
        public string $session_id,
        public ?Coupon $coupon = null,
        array $items = []
    ) {
        $this->items = $items;
    }

    public function addItem(Product $product, int $quantity): void
    {
        foreach ($this->items as $item) {
            if ($item->product->id === $product->id) {
                $item->increase($quantity);
                return;
            }
        }

        $this->items[] = new CartItem(
            null,
            $this->id,
            $product,
            $quantity
        );
    }

    public function items(): array
    {
        return $this->items;
    }

    public function updateItemQuantity(int $itemId, int $quantity): void
    {
        foreach ($this->items as $item) {
            if ($item->id === $itemId) {
                $item->quantity = $quantity;
                return;
            }
        }

        throw new \Exception('Cart item not found');
    }

}