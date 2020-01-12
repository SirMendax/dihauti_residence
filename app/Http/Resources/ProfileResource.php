<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'role' => RoleResource::collection($this->roles),
            'slug' => $this->slug,
            'first_name' => $this->profile->first_name,
            'sex' => $this->profile->sex,
            'city' => $this->profile->city,
            'quote' => $this->profile->quote,
        ];
    }
}
