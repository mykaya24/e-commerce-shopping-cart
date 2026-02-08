<?php

namespace App\Exceptions;

class FavoriteNotFoundException extends DomainException
{
    protected string $errorCode = 'FAVORITES_NOT_FOUND';
    protected int $statusCode = 404;

    public function __construct(string $message = 'Favorite product not found')
    {
        parent::__construct($message);
    }
}