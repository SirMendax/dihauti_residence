<?php


namespace App\Repositories;


use App\Http\Resources\Blog\BlogCommentResource;
use App\Models\Blog\BlogComment;

class CommentRepository extends AbstractRepository
{
    public function getModelClass()
    {
        return BlogComment::class;
    }

    public function getPagination($postId)
    {
        $comments = $this->model->where('blog_post_id', $postId)->paginate(10);
        return [
            'pagination' => [
                'total' => $comments->total(),
                'per_page' => $comments->perPage(),
                'current_page' => $comments->currentPage(),
                'last_page' => $comments->lastPage(),
                'from' => $comments->firstItem(),
                'to' => $comments->lastItem()
            ],
            'data' => BlogCommentResource::collection($comments)
        ];
    }
}
