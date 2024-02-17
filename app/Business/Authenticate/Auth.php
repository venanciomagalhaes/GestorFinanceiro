<?php

namespace App\Business\Authenticate;

use App\Exceptions\Authenticate\IncorrectLoginCredentialsException;
use App\Http\Requests\Authenticate\LoginRequest;
use App\Http\Requests\Authenticate\RegisterRequest;
use App\Http\Resources\Authenticate\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth as AuthenticateFacede;

class Auth
{
    public function __construct(
        private User $repository
    ){}

    public function register(RegisterRequest $request): UserResource
    {
        $user = $this->repository->create($request->all());
        $user->message = "User created successfully";
        return new UserResource($user) ;
    }

    /**
     * @throws IncorrectLoginCredentialsException
     */
    public function login(LoginRequest $request):UserResource
    {
        if($this->isCorrectCredentials($request)){
           $user = $this->repository->where('email', $request->input('email'))->first();
           $user->message = "User logged successfully";
           return new UserResource($user);
        }
        throw new IncorrectLoginCredentialsException();
    }
    private function isCorrectCredentials(LoginRequest $request): bool
    {
        return AuthenticateFacede::attempt($request->all());
    }
}
