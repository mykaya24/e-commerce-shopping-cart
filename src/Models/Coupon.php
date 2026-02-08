<?php

namespace App\Models;

use App\Enum\CouponType;

class Coupon implements \JsonSerializable
{
    public function __construct(
        public int $id,
        public string $code,
        public CouponType $type,
        public float $value,
        public float $minCartTotal,
        public \DateTimeImmutable $expiresAt
    ) {}

    public function isValidFor(Cart $cart): bool
    {
        $now = new \DateTimeImmutable();

        if ($this->expiresAt && $now > $this->expiresAt) {
            return false;
        }

        if ($this->minCartTotal !== null && $cart->getTotal() < $this->minCartTotal) {
            return false;
        }

        return true;
    }

    public function calculateDiscount(Cart $cart): float
    {
        $cartTotal = $cart->getTotalWithoutDiscount();

        return match ($this->type) {
            CouponType::PERCENTAGE =>
                $cartTotal * ($this->value / 100),

            CouponType::FIXED =>
                min($this->value, $cartTotal),
        };
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'type' => $this->type->value,
            'value' => $this->value
        ];
    }
}