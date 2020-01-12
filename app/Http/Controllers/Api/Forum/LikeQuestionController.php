<?php

namespace App\Http\Controllers\Api\Forum;

use App\Http\Controllers\Api\BaseControllers\ApiBaseController;
use App\Models\Forum\ForumQuestion;
use App\Services\Like\CreateLikeService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LikeQuestionController extends ApiBaseController
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * @param Request $request
     * @param ForumQuestion $question
     * @return JsonResponse
     * @OA\Post(
     *     path="/questions/{forumQuestion}/like",
     *     operationId="questionLike",
     *     tags={"Like"},
     *     summary="Like question",
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
     *     @OA\Response(
     *          response=201,
     *          description="Liked this question successfully"
     *       ),
     *     @OA\Response(
     *          response=202,
     *          description="Unliked this question successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     * )
     */
    public function __invoke(Request $request, ForumQuestion $question)
    {
        $result = CreateLikeService::like($question, $request->user()->id);
        return $this->sendResponse($result['content'], $result['message'], $result['status']);
    }
}
