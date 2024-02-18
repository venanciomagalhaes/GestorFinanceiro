<?php

namespace App\Business\User;

use App\Http\Requests\User\UserUpdateRequest;
use App\Http\Resources\User\UserResource;

class User
{
    public function update(UserUpdateRequest $request): UserResource
    {
        $user = auth()->user();
        $user->update($request->all());
        $user->message = "User updated successfully";
        return new UserResource($user);
    }
}
