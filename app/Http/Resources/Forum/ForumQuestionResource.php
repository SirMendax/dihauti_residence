<?php

namespace App\Http\Resources\Forum;

use App\Models\Forum\ForumReply;
use Illuminate\Http\Resources\Json\JsonResource;

class ForumQuestionResource extends JsonResource
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
            'title' => $this->title,
            'view_count' => $this->view_count,
            'slug' => $this->slug,
            'replies_count' => $this->replies->count(),
            'path' => $this->path,
            'body' => $this->body,
            'created_at' => $this->created_at->format("F j, Y, g:i a"),
            'user_id' => $this->user_id,
            'user' => $this->user->name,
            'online' => $this->user->isOnline(),
            'user_slug' => $this->user->slug,
            'category' => $this->forumCategory->name,
            'category_slug' => $this->forumCategory->slug,
            'replies' => ForumReplyResource::collection($this->replies),
            'last_replies' => ForumReplyResource::collection($this->replies)->first(),
            'likes' => $this->likes,
            'like_count' => $this->likes->count(),
        ];
    }
}
