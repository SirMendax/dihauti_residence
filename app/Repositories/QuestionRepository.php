<?php


namespace App\Repositories;


use App\Http\Requests\QuestionRequest;
use App\Models\Forum\ForumQuestion;
use Purifier;

class QuestionRepository extends AbstractRepository
{
    public function getModelClass()
    {
        return ForumQuestion::class;
    }

    public function store(QuestionRequest $request)
    {
        $filterData = [
            'title' => $request->title,
            'blog_category_id' => $request->forum_category_id,
            'body' => Purifier::clean($request->body),
        ];
        auth('api')->user()->forumQuestion()->create($filterData);
    }

    public function update(ForumQuestion $question, QuestionRequest $request)
    {
        $filterData = [
            'title' => $request->title,
            'body' => Purifier::clean($request->body),
        ];
        $question->update($filterData);
    }
}
