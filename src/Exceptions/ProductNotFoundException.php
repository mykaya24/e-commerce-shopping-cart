<?php

namespace App\Exceptions;

class ProductNotFoundException extends DomainException
{
    protected string $errorCode = 'PRODUCT_NOT_FOUND';
    protected int $statusCode = 404;

    public function __construct(string $message = 'Product not found')
    {
        parent::__construct($message);
    }
}