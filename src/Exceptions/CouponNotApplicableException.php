<?php

namespace App\Exceptions;


class CouponNotApplicableException extends DomainException
{
    protected string $errorCode = 'COUPON_NOT_APPLICABLE';
    protected int $statusCode = 404;

    public function __construct(string $message = 'Coupon not applicable')
    {
        parent::__construct($message);
    }
}