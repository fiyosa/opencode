<?php

namespace App\Presentation\Core\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $attributes = [
            'id' => $this->id,
            'username' => $this->username,
            'email' => $this->email,
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];

        if ($this->relationLoaded('roles')) {
            $attributes['roles'] = $this->roles->map(fn ($role) => [
                'id' => $role->id,
                'name' => $role->name,
            ]);
        }

        if ($this->relationLoaded('detail') && $this->detail) {
            $attributes['detail'] = [
                'id' => $this->detail->id,
                'name' => $this->detail->name,
                'last_name' => $this->detail->last_name,
                'phone' => $this->detail->phone,
            ];
        }

        if ($this->relationLoaded('division')) {
            $attributes['division'] = $this->division;
        }

        return $attributes;
    }
}
