<?php

namespace App\Http\Controllers\Api\Blog;

use App\Http\Controllers\Api\BaseControllers\ApiBaseController;
use App\Models\Blog\BlogCategory;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Resources\Blog\BlogCategoryResource;

class BlogCategoryController extends ApiBaseController
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
     *     path="/blogCategories",
     *     operationId="getBlogCategoryList",
     *     tags={"BlogCategory"},
     *     summary="Get all blog categories",
     *     description="Returns all blog categories",
     *     @OA\Response(
     *          response=200,
     *          description="Blog's categories retrieved successfully"
     *     ),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function index()
    {
        $categories = BlogCategoryResource::collection(BlogCategory::orderBy('id', 'asc')->get());
        return $this->sendResponse($categories, 'Blog category retrieved successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param BlogCategory $blogCategory
     * @return JsonResponse
     *
     * @OA\Get(
     *      path="/blogCategories/{slug}",
     *      operationId="getBlogCategoryBySlug",
     *      tags={"BlogCategory"},
     *      summary="Get blog category by slug",
     *      description="Returns blog category by slug",
     *      @OA\Parameter(
     *          name="slug",
     *          description="Blog category slug",
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
    public function show(BlogCategory $blogCategory)
    {
        $category = new BlogCategoryResource($blogCategory);
        return $this->sendResponse($category, 'Blog category retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws AuthorizationException
     *
     * @OA\Post(
     *     path="/blogCategories",
     *     operationId="blogCategoryCreate",
     *     tags={"BlogCategory"},
     *     summary="Create blog category in database",
     *     security={
     *          {"app_id": {}},
     *     },
     *     @OA\Response(
     *          response=201,
     *          description="Blog category created successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     * )
     */
    public function store(Request $request)
    {
        $this->authorize('store', BlogCategory::class);
        $data =[ 'name' => $request->name ];
        BlogCategory::create($data);
        return $this->sendResponse(TRUE, 'Blog category created successfully.', Response::HTTP_CREATED);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param BlogCategory $blogCategory
     * @return JsonResponse
     * @throws AuthorizationException
     *
     * @OA\Put(
     *     path="/blogCategories/{slug}",
     *     operationId="blogCategoryUpdate",
     *     tags={"BlogCategory"},
     *     summary="Update blog category in database",
     *     security={
     *          {"app_id": {}},
     *     },
     *     @OA\Parameter(
     *          name="slug",
     *          description="Blog category slug",
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
    public function update(BlogCategory $blogCategory, Request $request)
    {
        $this->authorize('update', BlogCategory::class);
        $data =[ 'name' => $request->name ];
        $blogCategory->update($data);
        return $this->sendResponse(TRUE, 'Blog category updated successfully.', Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     * @param BlogCategory $blogCategory
     * @return JsonResponse
     * @throws Exception
     *
     * @OA\Delete(
     *     path="/blogCategories/{slug}",
     *     operationId="blogCategoryDelete",
     *     tags={"BlogCategory"},
     *     summary="Delete blog category in database",
     *     security={
     *          {"app_id": {}},
     *     },
     *     @OA\Parameter(
     *          name="slug",
     *          description="Blog category slug",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *     @OA\Response(
     *          response=202,
     *          description="Blog category deleted successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     * )
     */
    public function destroy(BlogCategory $blogCategory)
    {
        $this->authorize('delete', BlogCategory::class);
        $blogCategory->delete();
        return $this->sendResponse(TRUE,'Blog category deleted successfully.',Response::HTTP_ACCEPTED);
    }
}
