<?php

namespace App\Http\Controllers\Api\Forum;

use App\Http\Controllers\Api\BaseControllers\ApiBaseController;
use App\Http\Resources\Forum\ForumReplyResource;
use App\Models\Forum\ForumQuestion;
use App\Models\Forum\ForumReply;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Mews\Purifier\Facades\Purifier;

class ForumReplyController extends ApiBaseController
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @param ForumQuestion $question
     * @return JsonResponse
     *
     * @OA\Get(
     *     path="/questions/{forumQuestion}/replies",
     *     operationId="getRepliesList",
     *     tags={"Reply"},
     *     summary="Get all reply for question with pagination",
     *     description="Returns all reply for questio with pagination",
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
     *          description="successful operation"
     *     ),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function index(ForumQuestion $question)
    {
        $replies = ForumReply::where('forum_question_id', $question->id)->paginate(10);
        $response = [
            'pagination' => [
                'total' => $replies->total(),
                'per_page' => $replies->perPage(),
                'current_page' => $replies->currentPage(),
                'last_page' => $replies->lastPage(),
                'from' => $replies->firstItem(),
                'to' => $replies->lastItem()
            ],
            'data' => ForumReplyResource::collection($replies)
        ];

        return $this->sendResponse($response, 'Replies for question retrieved successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param ForumQuestion $question
     * @param ForumReply $reply
     * @return JsonResponse
     *
     * @OA\Get(
     *      path="/questions/{forumQuestion}/replies/{id}",
     *      operationId="getReplyById",
     *      tags={"Reply"},
     *      summary="Get reply for post by id",
     *      description="Returns reply for post by id",
     *      @OA\Parameter(
     *          name="slug",
     *          description="Question slug",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="id",
     *          description="Reply for question id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation"
     *       ),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function show(ForumQuestion $question, ForumReply $reply)
    {
        $forumReply = new ForumReplyResource($reply);
        return $this->sendResponse($forumReply, 'Forum reply for question retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ForumQuestion $question
     * @param Request $request
     * @return JsonResponse
     * @throws AuthorizationException
     * @OA\Post(
     *     path="/questions/{forumQuestion}/replies",
     *     operationId="replyCreate",
     *     tags={"Reply"},
     *     summary="Create reply for question in database",
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
     *          description="successful operation"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     * )
     */
    public function store(ForumQuestion $question, Request $request)
    {
        $this->authorize('store', ForumReply::class);
        $data = ['body' => Purifier::clean($request->body)];
        $reply = $question->replies()->create($data);
        return $this->sendResponse($reply, 'Reply store successfully', Response::HTTP_CREATED);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ForumQuestion $question
     * @param ForumReply $reply
     * @param Request $request
     * @return JsonResponse
     * @throws AuthorizationException
     *
     * @OA\Put(
     *     path="/questions/{forumQuestion}/replies/{id}",
     *     operationId="replyUpdate",
     *     tags={"Reply"},
     *     summary="Update reply for question in database",
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
     *          description="Reply for post id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *     @OA\Response(
     *          response=202,
     *          description="successful operation"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     * )
     */
    public function update(ForumQuestion $question, ForumReply $reply, Request $request)
    {
        $this->authorize('update', $reply);
        $data = ['body' => Purifier::clean($request->body)];
        $reply->update($data);
        return $this->sendResponse($reply, 'Reply updated successfully', Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ForumQuestion $question
     * @param ForumReply $reply
     * @return JsonResponse
     * @throws Exception
     * @throws AuthorizationException
     *
     * @OA\Delete(
     *     path="/questions/{forumQuestion}/replies/{id}",
     *     operationId="replyDelete",
     *     tags={"Reply"},
     *     summary="Delete reply for question in database",
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
     *          description="Reply for post id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *     @OA\Response(
     *          response=202,
     *          description="successful operation"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     * )
     */
    public function destroy(ForumQuestion $question, ForumReply $reply)
    {
        $this->authorize('delete', $reply);
        $reply->delete();
        return $this->sendResponse(NULL, 'Comment deleted successfully', Response::HTTP_NO_CONTENT);

    }
}
