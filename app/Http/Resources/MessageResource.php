<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
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
            'sender' => User::find($this->sender_id)->name,
            'sender_id' => User::find($this->sender_id)->id,
            'text' => $this->text,
            'date' => $this->created_at->format("F j, Y, g:i a"),
        ];
    }
}
