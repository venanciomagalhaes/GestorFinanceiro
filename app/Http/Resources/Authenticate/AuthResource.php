<?php

namespace App\Http\Resources\Authenticate;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthResource extends JsonResource
{
    public static $wrap = '';
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var $this User*/
        return [
            'token' => $this->getPlainTextToken(),
            'message' => $this->message,
            'user' => [
                'name' => $this->name,
                'email' => $this->email,
            ],
        ];
    }
}
