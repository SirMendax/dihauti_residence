<?php

namespace App\Http\Controllers\Api\Blog;

use App\Http\Controllers\Api\BaseControllers\ApiBaseController;
use App\Http\Requests\PostStoreRequest;
use App\Models\Blog\BlogPost;
use App\Repositories\PostRepository;
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
     * @param PostRepository $postRepository
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
    public function index(PostRepository $postRepository)
    {
        $posts = $postRepository->getPagination();
        return $this->sendResponse($posts, 'Blog posts retrieved successfully.');
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
     * @param PostStoreRequest $request
     * @param PostRepository $postRepository
     * @return JsonResponse
     * @throws AuthorizationException
     * @OA\Post(
     *     path="/posts",
     *     operationId="postCreate",
     *     tags={"Post"},
     *     summary="Create yet another post in database",
     *     security={
     *          {"app_id": {}},
     *     },
     *     @OA\RequestBody(
     *         description="Created post",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/PostStoreRequest")
     *    ),
     *    @OA\Response(
     *          response=201,
     *          description="Blog post created successfully"
     *    ),
     *    @OA\Response(
     *         response=422,
     *         description="Missing Data"
     *     ),
     * )
     */
    public function store(PostStoreRequest $request, PostRepository $postRepository)
    {
        $this->authorize('store', BlogPost::class);
        $postRepository->store($request);
        return $this->sendResponse(TRUE, 'Blog post created successfully.', Response::HTTP_CREATED);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PostStoreRequest $request
     * @param BlogPost $post
     * @param PostRepository $postRepository
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
     *    @OA\RequestBody(
     *         description="Update post",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/PostStoreRequest")
     *    ),
     *    @OA\Response(
     *          response=202,
     *          description="Post updated successfully"
     *    ),
     *    @OA\Response(
     *         response=422,
     *         description="Missing Data"
     *     ),
     *    @OA\Response(response=400, description="Bad request"),
     * )
     */
    public function update(PostStoreRequest $request, BlogPost $post, PostRepository $postRepository)
    {
        $this->authorize('update', $post);
        $postRepository->update($post, $request);
        return $this->sendResponse(TRUE,'Post updated successfully',Response::HTTP_ACCEPTED);
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
        return $this->sendResponse(TRUE,'Post deleted successfully', Response::HTTP_ACCEPTED);
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
