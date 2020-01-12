<?php

namespace App\Http\Resources\Blog;

use Illuminate\Http\Resources\Json\JsonResource;

class BlogCommentResource extends JsonResource
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
            'body' => $this->body,
            'user' => $this->user->name,
            'online' => $this->user->isOnline(),
            'role' => $this->user->roles,
            'user_id' => $this->user_id,
            'post_slug' => $this->blogPost->slug,
            'created_at' => $this->created_at->format("F j, Y, g:i a"),
            'likes' => $this->likes,
            'like_count' => $this->likes->count(),
        ];
    }
}
