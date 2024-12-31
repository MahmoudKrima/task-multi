<?php

namespace App\Http\Resources\Api\User;

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
        if ($this->image != null) {
            $img = displayImage($this->image);
        }else {
            $img = displayImage('defaults/admin.jpg');
        }

        return [
            'id' => $this->id,
            'name' => $this->name ?? __('api.n/a'),
            'email' => $this->email ?? __('api.n/a'),
            'phone' => $this->phone ?? __('api.n/a'),
            'image' => $img,
        ];
    }
}
