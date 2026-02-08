<?php

namespace App\Exceptions;

use Exception;

abstract class DomainException extends Exception
{
    protected string $errorCode;
    protected int $statusCode = 400;

    public function getErrorCode(): string
    {
        return $this->errorCode;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }
}