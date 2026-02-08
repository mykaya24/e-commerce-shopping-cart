<?php

namespace App\Exceptions;


class CartItemNotFoundException extends DomainException
{
    protected string $errorCode = 'CART_ITEM_NOT_FOUND';
    protected int $statusCode = 404;

    public function __construct(string $message = 'Cart item not found')
    {
        parent::__construct($message);
    }
}