<?php

namespace App\Services;

use App\Exceptions\CouponNotApplicableException;
use App\Exceptions\CouponNotFoundException;
use App\Models\Cart;
use App\Models\Coupon;
use App\Repositories\CouponRepository;

class CouponService
{
    public function __construct(
        private CouponRepository $couponRepository
    ) {}

    public function validate(string $code, Cart $cart): Coupon
    {
        $coupon = $this->couponRepository->findByCode($code);
        if (!$coupon) 
            throw new CouponNotFoundException();

        if (!$coupon->isValidFor($cart))
            throw new CouponNotApplicableException();

        return $coupon;
    }
    
}