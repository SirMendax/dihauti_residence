<?php

namespace App\Http\Resources\Blog;

use Illuminate\Http\Resources\Json\JsonResource;

class BlogPostResource extends JsonResource
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
            'description' => $this->description,
            'comments_count' => $this->blogComments->count(),
            'path' => $this->path,
            'body' => $this->body,
            'created_at' => $this->created_at->format("F j, Y, g:i a"),
            'user_id' => $this->user_id,
            'user' => $this->user->name,
            'online' => $this->user->isOnline(),
            'user_slug' => $this->user->slug,
            'category' => $this->blogCategory->name,
            'comments' => BlogCommentResource::collection($this->blogComments),
            'likes' => $this->likes,
            'like_count' => $this->likes->count(),
        ];
    }
}
