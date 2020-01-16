<?php


namespace App\Repositories;


use App\Http\Resources\Forum\ForumReplyResource;
use App\Models\Forum\ForumReply;

class ReplyRepository extends AbstractRepository
{
    public function getModelClass()
    {
        return ForumReply::class;
    }

    public function getPagination($questionId)
    {
        $comments = $this->model->where('forum_question_id', $questionId)->paginate(10);
        return [
            'pagination' => [
                'total' => $comments->total(),
                'per_page' => $comments->perPage(),
                'current_page' => $comments->currentPage(),
                'last_page' => $comments->lastPage(),
                'from' => $comments->firstItem(),
                'to' => $comments->lastItem()
            ],
            'data' => ForumReplyResource::collection($comments)
        ];
    }
}
