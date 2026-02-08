<?php

namespace App\Exceptions;


class CartNotFoundException extends DomainException
{
    protected string $errorCode = 'CART_NOT_FOUND';
    protected int $statusCode = 404;

    public function __construct(string $message = 'Cart not found')
    {
        parent::__construct($message);
    }
}