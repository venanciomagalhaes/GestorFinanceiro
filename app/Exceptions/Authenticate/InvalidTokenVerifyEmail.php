<?php

namespace App\Exceptions\Authenticate;

use App\Exceptions\PersonalExceptions;
use App\Exceptions\Throwable;
use Exception;

class InvalidTokenVerifyEmail extends PersonalExceptions
{
    public function __construct(string $message = "The token provided is not valid or has already been used", int $code = 400, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
