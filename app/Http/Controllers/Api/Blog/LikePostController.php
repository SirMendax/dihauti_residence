<?php

namespace App\Http\Controllers\Api\Blog;

use App\Http\Controllers\Api\BaseControllers\ApiBaseController;
use App\Models\Blog\BlogPost;
use App\Services\Like\CreateLikeService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LikePostController extends ApiBaseController
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * @param Request $request
     * @param BlogPost $post
     * @return JsonResponse
     * @throws AuthorizationException
     *
     * @OA\Post(
     *     path="/posts/{blogPost}/like",
     *     operationId="postLike",
     *     tags={"Like"},
     *     summary="Like post",
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
     *          response=201,
     *          description="Liked this post successfully"
     *       ),
     *     @OA\Response(
     *          response=202,
     *          description="Unliked this post successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     * )
     */
    public function __invoke(Request $request, BlogPost $post)
    {
        $result = CreateLikeService::like($post, $request->user()->id);
        return $this->sendResponse($result['content'], $result['message'], $result['status']);
    }
}
