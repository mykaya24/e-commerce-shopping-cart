<?php

namespace App\Models;

use App\Exceptions\CartItemNotFoundException;
use App\Exceptions\CouponAlreadyAppliedException;
use App\Exceptions\CouponNotApplicableException;

class Cart implements \JsonSerializable
{
    public array $items = [];
    private float $priceTotal = 0;
    private float $discountTotal = 0;
    private float $total = 0;

    public function __construct(
        public int $id,
        public string $sessionId,
        public ?Coupon $coupon = null,
        array $items = []
    ) {
        $this->items = $items;
        //$this->discountTotal = $this->getTotalWithoutDiscount() - $coupon->calculateDiscount($this);
        $this->recalculate();
    }

    private function recalculate(): void
    {
        $this->priceTotal = array_sum(
            array_map(fn(CartItem $item) => $item->subtotal(), $this->items)
        );

        $this->discountTotal = $this->coupon
            ? $this->coupon->calculateDiscount($this)
            : 0;

        $this->total = max(0, $this->priceTotal - $this->discountTotal);
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
        $this->recalculate();
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
                $this->recalculate();
                return;
            }
        }

        throw new CartItemNotFoundException();
    }

    public function applyCoupon(Coupon $coupon): void
    {
        if ($this->coupon !== null)
            throw new CouponAlreadyAppliedException();

        $this->coupon = $coupon;
        $this->recalculate();

        if ($this->discountTotal <= 0) {
            throw new CouponNotApplicableException();
        }
    }

    public function removeCoupon(): void
    {
        $this->coupon = null;
        $this->recalculate();
    }

    public function getTotal(): float
    {
        return max(0, $this->getTotalWithoutDiscount() - $this->discountTotal);
    }


    public function getTotalWithoutDiscount(): float
    {
        return array_reduce(
            $this->items,
            fn($total, CartItem $item) => $total + $item->subtotal(),
            0
        );
    }

    public function getId(): int
    {
        return $this->id;
    }


    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'session_id' => $this->sessionId,
            'priceTotal' => $this->priceTotal,
            'discount_total' => $this->discountTotal,
            'total' => $this->total,
            'items' => $this->items,
            'coupon' => $this->coupon
        ];
    }
}
