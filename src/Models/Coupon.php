<?php

namespace App\Models;

class Coupon
{
    public function __construct(
        public int $id,
        public string $code,
        public string $type,
        public float $value,
        public float $min_cart_total,
        public \DateTimeImmutable $expires_at
    ) {}
}