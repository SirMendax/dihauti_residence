<?php

namespace App\Http\Controllers\Api\Forum;

use App\Http\Controllers\Api\BaseControllers\ApiBaseController;
use App\Http\Requests\QuestionRequest;
use App\Http\Resources\Forum\ForumQuestionResource;
use App\Models\Forum\ForumQuestion;
use App\Models\Forum\ForumCategory;
use App\Repositories\QuestionRepository;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ForumQuestionController extends ApiBaseController
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     *
     * @OA\Get(
     *     path="/questions",
     *     operationId="getQuestionsList",
     *     tags={"Question"},
     *     summary="Get all questions with group by category",
     *     description="Returns all questions with group by category",
     *     @OA\Response(
     *          response=200,
     *          description="successful operation"
     *     ),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function index()
    {
        $questions = ForumQuestionResource::collection(ForumQuestion::latest()->limit(10)->get())->groupBy('forum_category_id');
        return $this->sendResponse($questions, 'Forum question retrieved successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param ForumQuestion $question
     * @return JsonResponse
     *
     * @OA\Get(
     *      path="/questions/{slug}",
     *      operationId="getQuestionBySlug",
     *      tags={"Question"},
     *      summary="Get question by slug",
     *      description="Returns question by slug",
     *      @OA\Parameter(
     *          name="slug",
     *          description="Question slug",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation"
     *       ),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function show(ForumQuestion $question)
    {
        $question = new ForumQuestionResource($question);
        event('viewPost', $question);
        return $this->sendResponse($question, 'Question retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param QuestionRequest $request
     * @param QuestionRepository $questionRepository
     * @return JsonResponse
     * @throws AuthorizationException
     * @OA\Post(
     *     path="/questions",
     *     operationId="questionCreate",
     *     tags={"Question"},
     *     summary="Create question in database",
     *     security={
     *          {"app_id": {}},
     *     },
     *     @OA\Response(
     *          response=201,
     *          description="successful operation"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     * )
     */
    public function store(QuestionRequest $request, QuestionRepository $questionRepository)
    {
        $this->authorize('store', ForumQuestion::class);
        $questionRepository->store($request);
        return $this->sendResponse(TRUE, 'Question created successfully.', Response::HTTP_CREATED);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param ForumQuestion $question
     * @param QuestionRepository $questionRepository
     * @return JsonResponse
     * @throws AuthorizationException
     * @OA\Put(
     *     path="/questions/{slug}",
     *     operationId="questionUpdate",
     *     tags={"Question"},
     *     summary="Update question in database",
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
     *          response=202,
     *          description="successful operation"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     * )
     */
    public function update(QuestionRequest $request, ForumQuestion $question,  QuestionRepository $questionRepository)
    {
        $this->authorize('update', $question);
        $questionRepository->update($question, $request);
        return $this->sendResponse(TRUE,'Question updated successfully',Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ForumQuestion $question
     * @return JsonResponse
     * @throws AuthorizationException
     * @OA\Delete(
     *     path="/questions/{slug}",
     *     operationId="questionDelete",
     *     tags={"Question"},
     *     summary="Delete question in database",
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
     *          response=202,
     *          description="successful operation"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     * )
     */
    public function destroy(ForumQuestion $question)
    {
        $this->authorize('delete', $question);
        $question->delete();
        return $this->sendResponse(TRUE,'Question deleted successfully', Response::HTTP_ACCEPTED);
    }

    /**
     * @param ForumCategory $forumCategory
     * @return JsonResponse
     *
     * @OA\Get(
     *     path="/forumCategories/{forumCategory}",
     *     operationId="getQuestionsListWithCategory",
     *     tags={"Question"},
     *     summary="Get questions with category",
     *     description="Returns questions with category",
     *     @OA\Parameter(
     *          name="slug",
     *          description="Forum category slug",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *     @OA\Response(
     *          response=200,
     *          description="successful operation"
     *     ),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getQuestionCategory(ForumCategory $forumCategory)
    {
        $question = ForumQuestionResource::collection(ForumQuestion::latest()
        	->where('forum_category_id', $forumCategory->id)->get());
        return $this->sendResponse($question, 'Question retrieved successfully.');
    }
}
