<?php

namespace App\Exceptions;


class ProductAlredyExistsException extends DomainException
{
    protected string $errorCode = 'PRODUCT_ALREADY_EXISTS';
    protected int $statusCode = 404;

    public function __construct(string $message = 'Product already exists')
    {
        parent::__construct($message);
    }
}