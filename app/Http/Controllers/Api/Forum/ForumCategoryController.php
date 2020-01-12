<?php

namespace App\Http\Controllers\Api\Forum;

use App\Http\Controllers\Api\BaseControllers\ApiBaseController;
use App\Http\Resources\Forum\ForumCategoryResource;
use App\Models\Forum\ForumCategory;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class ForumCategoryController extends ApiBaseController
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['index', 'show']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     *
     * @OA\Get(
     *     path="/forumCategories",
     *     operationId="getForumCategoryList",
     *     tags={"ForumCategory"},
     *     summary="Get all forum categories",
     *     description="Returns all forum categories",
     *     @OA\Response(
     *          response=200,
     *          description="successful operation"
     *     ),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function index()
    {
        $categories = ForumCategoryResource::collection(ForumCategory::latest()->get());
        return $this->sendResponse($categories, 'Forum category retrieved successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param ForumCategory $forumCategory
     * @return JsonResponse
     *
     * @OA\Get(
     *      path="/forumCategories/{slug}",
     *      operationId="getForumCategoryBySlug",
     *      tags={"ForumCategory"},
     *      summary="Get forum category by slug",
     *      description="Returns forum category by slug",
     *      @OA\Parameter(
     *          name="slug",
     *          description="Forum category slug",
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
    public function show(ForumCategory $forumCategory)
    {
        $category = new ForumCategoryResource($forumCategory);
        return $this->sendResponse($category, 'Forum category retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws AuthorizationException
     *
     * @OA\Post(
     *     path="/forumCategories",
     *     operationId="forumCategoryCreate",
     *     tags={"ForumCategory"},
     *     summary="Create forum category in database",
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
    public function store(Request $request)
    {
        $this->authorize('store', ForumCategory::class);
        $data =[ 'name' => $request->name ];
        $category = ForumCategory::create($data);
        return $this->sendResponse($category, 'Forum category created successfully.', Response::HTTP_CREATED);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param ForumCategory $forumCategory
     * @return JsonResponse
     * @throws AuthorizationException
     *
     * @OA\Put(
     *     path="/forumCategories/{slug}",
     *     operationId="forumCategoryUpdate",
     *     tags={"ForumCategory"},
     *     summary="Update forum category in database",
     *     security={
     *          {"app_id": {}},
     *     },
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
     *          response=202,
     *          description="successful operation"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     * )
     */
    public function update(Request $request, ForumCategory $forumCategory)
    {
        $this->authorize('update', ForumCategory::class);
        $data =[ 'name' => $request->name ];
        $forumCategory->update($data);
        return $this->sendResponse(new ForumCategoryResource($forumCategory),
            'Forum category updated successfully.',
            Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ForumCategory $forumCategory
     * @return JsonResponse
     * @throws Exception
     * @throws AuthorizationException
     *
     * @OA\Delete(
     *     path="/forumCategories/{slug}",
     *     operationId="forumCategoryDelete",
     *     tags={"ForumCategory"},
     *     summary="Delete forum category in database",
     *     security={
     *          {"app_id": {}},
     *     },
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
     *          response=202,
     *          description="successful operation"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     * )
     */
    public function destroy(ForumCategory $forumCategory)
    {
        $this->authorize('delete', ForumCategory::class);
        $forumCategory->delete();
        return $this->sendResponse(NULL,'Forum category deleted successfully',Response::HTTP_ACCEPTED);
    }
}
