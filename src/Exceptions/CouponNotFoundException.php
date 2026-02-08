<?php

namespace App\Exceptions;


class CouponNotFoundException extends DomainException
{
    protected string $errorCode = 'COUPON_NOT_FOUND';
    protected int $statusCode = 404;

    public function __construct(string $message = 'Coupon not found')
    {
        parent::__construct($message);
    }
}