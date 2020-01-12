<?php

namespace App\Http\Controllers\Api\Blog;

use App\Http\Controllers\Api\BaseControllers\ApiBaseController;
use App\Models\Blog\BlogPost;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Resources\Blog\BlogPostResource;
use Purifier;

class BlogPostController extends ApiBaseController
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['index', 'show', 'getSort']]);
    }

    /**
     * Returns list of projects
     *
     * Display a listing of the resource.
     * @return JsonResponse
     *
     * @OA\Get(
     *     path="/posts",
     *     operationId="getPostsList",
     *     tags={"Post"},
     *     summary="Get all posts with pagination",
     *     description="Returns all posts with pagination",
     *     @OA\Parameter(
     *          name="page",
     *          description="The page number",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Blog posts retrieved successfully"
     *     ),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function index()
    {
        $post = BlogPost::latest()->paginate(5);
        $response = [
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

        return $this->sendResponse($response, 'Blog posts retrieved successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param BlogPost $post
     * @return JsonResponse
     *
     * @OA\Get(
     *      path="/posts/{slug}",
     *      operationId="getPostBySlug",
     *      tags={"Post"},
     *      summary="Get post by slug",
     *      description="Returns post by slug",
     *      @OA\Parameter(
     *          name="slug",
     *          description="Post slug",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Post retrieved successfully"
     *       ),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function show(BlogPost $post)
    {
        $post = new BlogPostResource($post);
        event('viewPost', $post);
        return $this->sendResponse($post, 'Post retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws AuthorizationException
     *
     * @OA\Post(
     *     path="/posts",
     *     operationId="postCreate",
     *     tags={"Post"},
     *     summary="Create yet another post in database",
     *     security={
     *          {"app_id": {}},
     *     },
     *     @OA\Response(
     *          response=201,
     *          description="Blog post created successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     * )
     **/
    public function store(Request $request)
    {
        $this->authorize('store', BlogPost::class);
        $filterData = [
          'title' => $request->title,
          'blog_category_id' => $request->blog_category_id,
          'body' => Purifier::clean($request->body),
          'description' => Purifier::clean($request->description),
       ];
        $blogPost = auth('api')->user()->blogPost()->create($filterData);
        return $this->sendResponse(new BlogPostResource($blogPost), 'Blog post created successfully.', Response::HTTP_CREATED);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param BlogPost $post
     * @return JsonResponse
     * @throws AuthorizationException
     * @OA\Put(
     *     path="/posts/{slug}",
     *     operationId="postUpdate",
     *     tags={"Post"},
     *     summary="Update post in database",
     *     security={
     *          {"app_id": {}},
     *     },
     *     @OA\Parameter(
     *          name="slug",
     *          description="Post slug",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *     @OA\Response(
     *          response=202,
     *          description="Post updated successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     * )
     */
    public function update(Request $request, BlogPost $post)
    {
        $this->authorize('update', $post);
        $filterData = [
          'title' => $request->title,
          'body' => Purifier::clean($request->body),
          'description' => Purifier::clean($request->description),
       ];
        $post->update($filterData);
        return $this->sendResponse($post,'Post updated successfully',Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param BlogPost $post
     * @return JsonResponse
     * @throws Exception
     *
     * @OA\Delete(
     *     path="/posts/{slug}",
     *     operationId="postDelete",
     *     tags={"Post"},
     *     summary="Delete post in database",
     *     security={
     *          {"app_id": {}},
     *     },
     *     @OA\Parameter(
     *          name="slug",
     *          description="Post slug",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *     @OA\Response(
     *          response=202,
     *          description="Post deleted successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     * )
     */
    public function destroy(BlogPost $post)
    {
        $this->authorize('delete', $post);
        $post->delete();
        return $this->sendResponse(NULL,'Post deleted successfully', Response::HTTP_ACCEPTED);
    }

    /**
     * @return JsonResponse
     *
     * @OA\Get(
     *     path="/sortedPost",
     *     operationId="getSortedBlogPostList",
     *     tags={"Post"},
     *     summary="Get sorting posts",
     *     description="Returns sorting posts",
     *     @OA\Response(
     *          response=200,
     *          description="successful operation"
     *     ),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getSort()
    {
        $post = BlogPostResource::collection(BlogPost::latest()->get())->unique('blog_category_id');
        return $this->sendResponse($post, 'Blog posts retrieved successfully.');
    }
}
