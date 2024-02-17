<?php

namespace App\Http\Controllers\Authenticate;

use App\Business\Authenticate\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\Authenticate\LoginRequest;
use App\Http\Requests\Authenticate\RegisterRequest;
use App\Http\Resources\Authenticate\UserResource;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(
        private Auth $business
    ){}

    public function register(RegisterRequest $request): UserResource
    {
       return $this->business->register($request);
    }

    public function login(LoginRequest $request): UserResource
    {
        return $this->business->login($request);
    }

    public function logout(Request $request): void
    {
         $this->business->logout($request);
    }
}
