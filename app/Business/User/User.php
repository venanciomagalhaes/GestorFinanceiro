<?php

namespace App\Business\User;

use App\Http\Requests\User\UserUpdateRequest;
use App\Http\Resources\User\UserDeleteResource;
use App\Http\Resources\User\UserResource;
use Illuminate\Http\Request;

class User
{
    public function update(UserUpdateRequest $request): UserResource
    {
        /** @var $user \App\Models\User*/
        $user = auth()->user();
        $user->update($request->all());
        $user->message = "User updated successfully";
        return new UserResource($user);
    }

    public function destroy(Request $request): UserDeleteResource
    {
        /** @var $user \App\Models\User*/
        $user = auth()->user();
        $user->delete();
        return new UserDeleteResource($user);
    }
}
