<?php

namespace App\Exceptions;

class ProductOutOfStockException extends DomainException
{
    protected string $errorCode = 'PRODUCT_OUT_OF_STOCK';
    protected int $statusCode = 404;

    public function __construct(string $message = 'Product out of stock')
    {
        parent::__construct($message);
    }
}