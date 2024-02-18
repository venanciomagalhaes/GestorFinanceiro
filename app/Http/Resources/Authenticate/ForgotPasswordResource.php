<?php

namespace App\Http\Resources\Authenticate;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ForgotPasswordResource extends JsonResource
{
    public static $wrap = '';
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'message' => 'Password reset email was sent successfully'
        ];
    }
}
