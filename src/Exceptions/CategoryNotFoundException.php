<?php

namespace App\Exceptions;


class CategoryNotFoundException extends DomainException
{
    protected string $errorCode = 'CATEGORY_NOT_FOUND';
    protected int $statusCode = 404;

    public function __construct(string $message = 'Category not found')
    {
        parent::__construct($message);
    }
}