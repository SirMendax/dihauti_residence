<?php

namespace App\Http\Resources\Forum;

use Illuminate\Http\Resources\Json\JsonResource;

class ForumReplyResource extends JsonResource
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
            'user' => $this->user->name,
            'online' => $this->user->isOnline(),
            'body' => $this->body,
            'role' => $this->user->roles[0]->name,
            'user_id' => $this->user_id,
            'question_slug' => $this->forumQuestion->slug,
            'created_at' => $this->created_at->format("F j, Y, g:i a"),
            'likes' => $this->likes,
            'like_count' => $this->likes->count(),
        ];
    }
}
