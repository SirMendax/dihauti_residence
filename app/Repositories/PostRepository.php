<?php


namespace App\Repositories;


use App\Http\Requests\PostRequest;
use App\Http\Resources\Blog\BlogPostResource;
use App\Models\Blog\BlogPost;
use Purifier;

class PostRepository extends AbstractRepository
{
    public function getModelClass()
    {
        return BlogPost::class;
    }

    public function getPagination()
    {
        $post = $this->model->latest()->paginate(5);
        return [
            'pagination' => [
                'total' => $post->total(),
                'per_page' => $post->perPage(),
                'current_page' => $post->currentPage(),
                'last_page' => $post->lastPage(),
                'from' => $post->firstItem(),
                'to' => $post->lastItem()
            ],
            'data' => BlogPostResource::collection($post)
        ];
    }

    public function store(PostRequest $request)
    {
        $filterData = [
            'title' => $request->title,
            'blog_category_id' => $request->blog_category_id,
            'body' => Purifier::clean($request->body),
            'description' => Purifier::clean($request->description),
        ];
        auth('api')->user()->blogPost()->create($filterData);
    }

    public function update(BlogPost $post, PostRequest $request)
    {
        $filterData = [
            'title' => $request->title,
            'body' => Purifier::clean($request->body),
            'description' => Purifier::clean($request->description),
        ];
        $post->update($filterData);
    }
}
