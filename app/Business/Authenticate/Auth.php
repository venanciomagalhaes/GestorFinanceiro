<?php

namespace App\Business\Authenticate;

use App\Exceptions\Authenticate\IncorrectLoginCredentialsException;
use App\Exceptions\Authenticate\InvalidTokenResetPasswordException;
use App\Exceptions\Authenticate\InvalidTokenVerifyEmail;
use App\Http\Requests\Authenticate\ForgotPasswordRequest;
use App\Http\Requests\Authenticate\LoginRequest;
use App\Http\Requests\Authenticate\RegisterRequest;
use App\Http\Requests\Authenticate\ResetPasswordRequest;
use App\Http\Resources\Authenticate\ForgotPasswordResource;
use App\Http\Resources\Authenticate\ResetPasswordResource;
use App\Http\Resources\Authenticate\UserResource;
use App\Http\Resources\Authenticate\VerifyEmailResource;
use App\Models\User;
use App\Notifications\Authenticate\ResetPasswordNotification;
use App\Notifications\Authenticate\VerifyEmailNotification;
use App\Notifications\Authenticate\WelcomeNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as AuthenticateFacade;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;

class Auth
{
    public function __construct(
        private User $repository
    ){}

    public function register(RegisterRequest $request): UserResource
    {
        /** @var $user User*/
        $user = $this->repository->create($request->all());
        $user->message = "User created successfully";
        $user->notify(new WelcomeNotification($user));
        $user->notify(new VerifyEmailNotification($user));
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
        /** @var $user User*/
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
        /** @var $user User*/
        $user->remember_token = Str::random(50);
        $user->save();
    }

    /**
     * @throws InvalidTokenResetPasswordException
     */
    public function resetPassword(ResetPasswordRequest $request, string $token): ResetPasswordResource
    {
        /** @var $user User*/
        $user = $this->repository->where('remember_token',$token)->first();
        $validToken = (bool) $user;
        if(!$validToken){
            throw new InvalidTokenResetPasswordException();
        }
        $this->changePassword($user, $request);
        return new ResetPasswordResource($request);
    }

    /**
     * @param User $user
     * @param ResetPasswordRequest $request
     * @return void
     */
    public function changePassword(User $user, ResetPasswordRequest $request): void
    {
        $user->update($request->all());
        $user->remember_token = "";
        $user->save();
    }

    /**
     * @throws InvalidTokenVerifyEmail
     */
    public function verifyEmail(Request $request, string $token): VerifyEmailResource
    {
        /** @var $user User*/
        $email = Crypt::decrypt($token);
        $user = $this->repository->where('email', $email)->first();
        $hasUser = (bool) $user;
        $hasLastVerificationEmail = $user->email_verified_at;
        if(!$hasUser || $hasLastVerificationEmail ){
            throw new InvalidTokenVerifyEmail();
        }
        $this->registerVerifyEmail($user);
        return new VerifyEmailResource($request);
    }

    /**
     * @param User $user
     * @return void
     */
    public function registerVerifyEmail(User $user): void
    {
        $user->email_verified_at = Carbon::now();
        $user->save();
    }

}
