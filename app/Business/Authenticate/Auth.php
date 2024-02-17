<?php

namespace App\Business\Authenticate;

use App\Http\Requests\Authenticate\RegisterRequest;
use App\Models\User;

class Auth
{
    public function __construct(
        private User $repository
    ){}

    public function register(RegisterRequest $request)
    {

    }
}
