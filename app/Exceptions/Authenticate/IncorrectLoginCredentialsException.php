<?php

namespace App\Exceptions\Authenticate;

use App\Exceptions\PersonalExceptions;
use Exception;

class IncorrectLoginCredentialsException extends PersonalExceptions
{
   public function __construct(string $message = "Incorrect email or password", int $code = 401, ?Throwable $previous = null)
   {
       parent::__construct($message, $code, $previous);
   }
}
