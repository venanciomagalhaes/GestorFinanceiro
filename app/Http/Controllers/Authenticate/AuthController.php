<?php

namespace App\Http\Controllers\Authenticate;

use App\Business\Authenticate\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\Authenticate\RegisterRequest;

class AuthController extends Controller
{
    public function __construct(
        private Auth $business
    ){}

    public function register(RegisterRequest $request)
    {
       $this->business->register($request);
    }
}
