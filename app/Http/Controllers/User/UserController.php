<?php

namespace App\Http\Controllers\User;

use App\Business\User\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserUpdateRequest;
use App\Http\Resources\User\UserDeleteResource;
use App\Http\Resources\User\UserResource;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function __construct(
      private User $business
    ){}

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request): UserResource
    {
        return $this->business->update($request);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request): UserDeleteResource
    {
        return $this->business->destroy($request);
    }
}
