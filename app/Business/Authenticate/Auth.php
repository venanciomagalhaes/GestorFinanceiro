<?php

namespace App\Business\Authenticate;

use App\Exceptions\Authenticate\IncorrectLoginCredentialsException;
use App\Http\Requests\Authenticate\ForgotPasswordRequest;
use App\Http\Requests\Authenticate\LoginRequest;
use App\Http\Requests\Authenticate\RegisterRequest;
use App\Http\Resources\Authenticate\ForgotPasswordResource;
use App\Http\Resources\Authenticate\UserResource;
use App\Models\User;
use App\Notifications\Authenticate\ResetPasswordNotification;
use Illuminate\Support\Facades\Auth as AuthenticateFacade;
use Illuminate\Support\Str;

class Auth
{
    public function __construct(
        private User $repository
    ){}

    public function register(RegisterRequest $request): UserResource
    {
        $user = $this->repository->create($request->all());
        $user->message = "User created successfully";
        return new UserResource($user);
    }


    /**
     * @throws IncorrectLoginCredentialsException
     */
    public function login(LoginRequest $request):UserResource
    {
        if(!$this->isCorrectCredentials($request)){
            throw new IncorrectLoginCredentialsException();
        }
        return $this->handleLogin($request);
    }

    private function isCorrectCredentials(LoginRequest $request): bool
    {
        return AuthenticateFacade::attempt($request->all());
    }

    /**
     * @param LoginRequest $request
     * @return UserResource
     */
    public function handleLogin(LoginRequest $request): UserResource
    {
        $user = $this->repository->where('email', $request->input('email'))->first();
        $user->message = "User logged successfully";
        return new UserResource($user);
    }

    public function logout(): void
    {
        auth()->user()->tokens()->delete();
    }

    public function forgotPassword(ForgotPasswordRequest $request): ForgotPasswordResource
    {
        /** @var $user User*/
        $user = $this->repository->where('email', $request->input('email'))->first();
        $hasUser = (bool) $user;
        if($hasUser){
            $this->setRememberToken($user);
            $user->notify(new ResetPasswordNotification($user));
        }
        return new ForgotPasswordResource($request);
    }

    /**
     * @param $user
     * @return void
     */
    public function setRememberToken($user): void
    {
        $user->remember_token = Str::random(50);
        $user->save();
    }

}
