<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class DialogResource extends JsonResource
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
            'user_one' => [
                'id' => $this->users[0]->id,
                'name' => $this->users[0]->name
            ],
            'user_two' => [
                'id' => $this->users[1]->id,
                'name' => $this->users[1]->name
            ],
            'last_message' => $this->lastMessage($this->messages)
        ];
    }

    public function lastMessage($messages)
    {
        if($messages->last()){
            return [
                'sender' => User::find($this->messages->last()->sender_id)->name,
                'text' => $this->messages->last()->text,
                'date' => $this->messages->last()->created_at->format("F j, Y, g:i a")
            ];
        }else{
            return null;
        }
    }
}
