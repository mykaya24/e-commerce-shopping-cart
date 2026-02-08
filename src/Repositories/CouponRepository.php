<?php

namespace App\Repositories;

use App\Enum\CouponType;
use App\Models\Coupon;
use DateTimeImmutable;

class CouponRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct();
    }

    public function findByCode(string $couponCode) :?Coupon{
        $sql = "select * from coupons where code = :code";
        //echo $couponCode;
        $row = $this->first($sql, ["code"=>$couponCode]);
        if(empty($row))
            return null;
        return new Coupon(
                $row["id"],
                $row["code"],
                CouponType::from($row['type']),
                $row["value"],
                $row["min_cart_total"],
                new \DateTimeImmutable($row["expires_at"]));

    }

    
}
