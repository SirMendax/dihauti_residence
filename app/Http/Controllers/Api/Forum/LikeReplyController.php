<?php

namespace App\Http\Controllers\Api\Forum;

use App\Http\Controllers\Api\BaseControllers\ApiBaseController;
use App\Models\Forum\ForumQuestion;
use App\Models\Forum\ForumReply;
use App\Services\Like\CreateLikeService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LikeReplyController extends ApiBaseController
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * @param Request $request
     * @param ForumQuestion $question
     * @param ForumReply $reply
     * @return JsonResponse
     * @OA\Post(
     *     path="/questions/{forumQuestion}/replies/{id}/like",
     *     operationId="replyLike",
     *     tags={"Like"},
     *     summary="Like reply for question",
     *     security={
     *          {"app_id": {}},
     *     },
     *     @OA\Parameter(
     *          name="slug",
     *          description="Question slug",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *     @OA\Parameter(
     *          name="id",
     *          description="Reply for question post id",
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
    public function __invoke(Request $request, ForumQuestion $question, ForumReply $reply)
    {
        $result = CreateLikeService::like($reply, $request->user()->id);
        return $this->sendResponse($result['content'], $result['message'], $result['status']);
    }
}
