<?php

namespace App\Http\Resources\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'username' => $this->username,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'other_names' => $this->other_names,
            'gender' => $this->gender,
            'bio' => $this->bio,
            'email' => $this->email,
            'email_verified_at' => $this->email_verified_at,
            'phone' => $this->phone,
            'phone_verified_at' => $this->phone_verified_at,
            'dob' => $this->dob,
            'has_setup_password' => $this->has_setup_password,
            'has_verified_email' => $this->hasVerifiedEmail(),
            'has_verified_phone' => $this->has_verified_phone,
            'updated_at' => $this->updated_at,
            'last_activity_at' => $this->last_activity_at,
            'created_at' => $this->created_at,
        ];
    }
}
