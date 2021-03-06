<?php

namespace App\Http\Controllers\Api\Blog;

use App\Http\Controllers\Api\BaseControllers\ApiBaseController;
use App\Http\Requests\CommentStoreRequest;
use App\Http\Resources\Blog\BlogCommentResource;
use App\Models\Blog\BlogComment;
use App\Repositories\CommentRepository;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Blog\BlogPost;
use Mews\Purifier\Facades\Purifier;

class BlogCommentController extends ApiBaseController
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['index', 'show']]);
    }

    /**
     * @OA\Get(
     *     path="/posts/{blogPost}/comments",
     *     operationId="getCommentList",
     *     tags={"Comment"},
     *     summary="Get all comment for post with pagination",
     *     description="Returns all comment for post with pagination",
     *     @OA\Parameter(
     *          name="slug",
     *          description="Post slug",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
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
     *          description="Comments for blog post retrieved successfully"
     *     ),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     *
     * Display a listing of the resource.
     *
     * @param BlogPost $post
     * @param CommentRepository $commentRepository
     * @return JsonResponse
     */
    public function index(BlogPost $post, CommentRepository $commentRepository)
    {
        $comments = $commentRepository->getPagination($post->id);
        return $this->sendResponse($comments, 'Comments for blog post retrieved successfully.');
    }

    /**
     * @OA\Get(
     *      path="/posts/{blogPost}/comments/{id}",
     *      operationId="getCommentById",
     *      tags={"Comment"},
     *      summary="Get comment for post by id",
     *      description="Returns comment for post by id",
     *      @OA\Parameter(
     *          name="slug",
     *          description="Post slug",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="id",
     *          description="Comment for post id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Comment for blog post retrieved successfully"
     *       ),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     *
     * Display the specified resource.
     *
     * @param BlogPost $post
     * @param BlogComment $comment
     * @return JsonResponse
     */
    public function show(BlogPost $post, BlogComment $comment)
    {
        $comment = new BlogCommentResource($comment);
        return $this->sendResponse($comment, 'Comment for blog post retrieved successfully.');
    }

    /**
     * @OA\Post(
     *     path="/posts/{blogPost}/comments",
     *     operationId="commentCreate",
     *     tags={"Comment"},
     *     summary="Create yet another comment for post in database",
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
     *         description="data for new comment",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/CommentStoreRequest")
     *    ),
     *    @OA\Response(
     *          response=201,
     *          description="Comment created successfully"
     *    ),
     *    @OA\Response(
     *         response=422,
     *         description="Missing Data"
     *     ),
     *    @OA\Response(response=400, description="Bad request"),
     * )
     *
     * Store a newly created resource in storage.
     *
     * @param BlogPost $post
     * @param CommentStoreRequest $request
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function store(BlogPost $post, CommentStoreRequest $request)
    {
        $this->authorize('store', BlogComment::class);
        $data = [ 'body' => Purifier::clean($request->body) ];
        $$post->blogComments()->create($data);
        return $this->sendResponse(TRUE,'Comment store successfully',Response::HTTP_CREATED);
    }

    /**
     * @OA\Put(
     *     path="/posts/{blogPost}/comments/{id}",
     *     operationId="commentUpdate",
     *     tags={"Comment"},
     *     summary="Update comment for post in database",
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
     *     @OA\Parameter(
     *          name="id",
     *          description="Comment for post id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *    @OA\RequestBody(
     *         description="Update comment",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/CommentStoreRequest")
     *    ),
     *    @OA\Response(
     *          response=202,
     *          description="Comment updated successfully"
     *    ),
     *    @OA\Response(
     *         response=422,
     *         description="Missing Data"
     *     ),
     *    @OA\Response(response=400, description="Bad request"),
     * )
     *
     * Update the specified resource in storage.
     *
     * @param CommentStoreRequest $request
     * @param BlogPost $post
     * @param BlogComment $comment
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function update(CommentStoreRequest $request, BlogPost $post, BlogComment $comment)
    {
        $this->authorize('update', $comment);
        $data = [ 'body' => Purifier::clean($request->body) ];
        $comment->update($data);
        return $this->sendResponse(TRUE,'Comment updated successfully',Response::HTTP_ACCEPTED);
    }

    /**
     * @OA\Delete(
     *     path="/posts/{blogPost}/comments/{id}",
     *     operationId="commentDelete",
     *     tags={"Comment"},
     *     summary="Delete comment for post in database",
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
     *     @OA\Parameter(
     *          name="id",
     *          description="Comment for post id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *     @OA\Response(
     *          response=202,
     *          description="Comment deleted successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     * )
     *
     * Remove the specified resource from storage.
     *
     * @param BlogPost $post
     * @param BlogComment $comment
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(BlogPost $post, BlogComment $comment)
    {
        $this->authorize('delete', $comment);
        $comment->delete();
        return $this->sendResponse(TRUE,'Comment deleted successfully',Response::HTTP_ACCEPTED);
    }
}
