<?php

namespace App\Http\Controllers\Api\Blog;

use App\Http\Controllers\Api\BaseControllers\ApiBaseController;
use App\Models\Blog\BlogComment;
use App\Models\Blog\BlogPost;
use App\Services\Like\CreateLikeService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LikeCommentController extends ApiBaseController
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * @param Request $request
     * @param BlogPost $post
     * @param BlogComment $comment
     * @return JsonResponse
     * @throws AuthorizationException
     *
     * @OA\Post(
     *     path="/posts/{blogPost}/comments/{id}/like",
     *     operationId="commentLike",
     *     tags={"Like"},
     *     summary="Like comment for post",
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
     *          description="Comment for blog post id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *     @OA\Response(
     *          response=201,
     *          description="Liked this post successfully"
     *       ),
     *      @OA\Response(
     *          response=202,
     *          description="Unliked this post successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     * )
     */
    public function __invoke(Request $request, BlogPost $post, BlogComment $comment)
    {
        $result = CreateLikeService::like($comment, $request->user()->id);
        return $this->sendResponse($result['content'], $result['message'], $result['status']);
    }
}
