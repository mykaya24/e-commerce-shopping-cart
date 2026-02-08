<?php

namespace App\Exceptions;


class CouponAlreadyAppliedException extends DomainException
{
    protected string $errorCode = 'COUPON_ALREADY_APPLIED';
    protected int $statusCode = 404;

    public function __construct(string $message = 'Coupon already applied')
    {
        parent::__construct($message);
    }
}