<?php

namespace App\Http\Controllers\Authenticate;

use App\Business\Authenticate\Auth;
use App\Exceptions\Authenticate\IncorrectLoginCredentialsException;
use App\Exceptions\Authenticate\InvalidTokenResetPasswordException;
use App\Exceptions\Authenticate\InvalidTokenVerifyEmail;
use App\Http\Controllers\Controller;
use App\Http\Requests\Authenticate\ForgotPasswordRequest;
use App\Http\Requests\Authenticate\LoginRequest;
use App\Http\Requests\Authenticate\RegisterRequest;
use App\Http\Requests\Authenticate\ResetPasswordRequest;
use App\Http\Resources\Authenticate\ForgotPasswordResource;
use App\Http\Resources\Authenticate\ResetPasswordResource;
use App\Http\Resources\Authenticate\UserResource;
use App\Http\Resources\Authenticate\VerifyEmailResource;
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

    /**
     * @throws IncorrectLoginCredentialsException
     */
    public function login(LoginRequest $request): UserResource
    {
        return $this->business->login($request);
    }

    public function logout(Request $request): void
    {
         $this->business->logout();
    }

    public function forgotPassword(ForgotPasswordRequest $request): ForgotPasswordResource
    {
        return $this->business->forgotPassword($request);
    }

    /**
     * @throws InvalidTokenResetPasswordException
     */
    public function resetPassword(ResetPasswordRequest $request, string $token): ResetPasswordResource
    {
        return $this->business->resetPassword($request,$token);
    }

    /**
     * @throws InvalidTokenVerifyEmail
     */
    public function verifyEmail(Request $request, $token): VerifyEmailResource
    {
        return $this->business->verifyEmail($request,$token);
    }
}
