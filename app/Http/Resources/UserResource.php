<?php

namespace App\Http\Resources;

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
            'name' => $this->name,
            'email' => $this->email,
            'created_at' => $this->created_at,

            ...$this->authPayload($request),
        ];
    }

    private function authPayload(Request $request): array
    {
        if ($request->user()->id !== $this->id) {
            return [];
        }

        return [
            'updated_at' => $this->updated_at,
        ];
    }
}
