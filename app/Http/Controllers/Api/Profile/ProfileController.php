<?php

namespace App\Http\Controllers\Api\Profile;

use App\Http\Controllers\Api\BaseControllers\ApiBaseController;
use App\Http\Resources\ProfileResource;
use App\Models\User;
use App\Models\Profile\Profile;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProfileController extends ApiBaseController
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     * @throws AuthorizationException
     *
     * @OA\Get(
     *     path="/users",
     *     operationId="getUsersList",
     *     tags={"Profile"},
     *     summary="Get all users",
     *     description="Returns all users",
     *     @OA\Response(
     *          response=200,
     *          description="successful operation"
     *     ),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function index()
    {
        $this->authorize('allView', Profile::class);
        $profiles = ProfileResource::collection(User::latest()->get());
        return $this->sendResponse($profiles, 'Profiles retrieved successfully.');
    }

    /**
     * Display the specified resource.
     * @param User $user
     * @return JsonResponse
     *
     * @OA\Get(
     *     path="/users/{user}",
     *     operationId="getUser",
     *     tags={"Profile"},
     *     summary="Get user",
     *     description="Returns user",
     *     @OA\Parameter(
     *          name="slug",
     *          description="User slug",
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
    public function show(User $user)
    {
        $profile = new ProfileResource($user);
        return $this->sendResponse($profile, 'Profile retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     *
     * @OA\Put(
     *     path="/users/update",
     *     operationId="updateProfile",
     *     tags={"Profile"},
     *     summary="Update your profile",
     *     description="Update personal info in your profile",
     *     @OA\Response(
     *          response=202,
     *          description="successful operation"
     *     ),
     *     @OA\Response(response=400, description="Bad request"),
     * )
     */
    public function update(Request $request)
    {
        $user = auth('api')->user()->profile()->update($request->all());
        return $this->sendResponse(TRUE, 'Profile update successfully.', Response::HTTP_ACCEPTED);
    }

    /**
     * @return JsonResponse
     * @throws Exception
     *
     * @OA\Delete(
     *     path="/users/delete",
     *     operationId="deleteProfile",
     *     tags={"Profile"},
     *     summary="Delete your profile",
     *     description="Delete your profile",
     *     @OA\Response(
     *          response=204,
     *          description="successful operation"
     *     ),
     *     @OA\Response(response=400, description="Bad request"),
     * )
     */
    public function delete()
    {
        auth('api')->user()->delete();
        return $this->sendResponse(null, 'Profile deleted successfully.', Response::HTTP_NO_CONTENT);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     *
     * @OA\Put(
     *     path="/users/passwordUpdate",
     *     operationId="passwordUpdateProfile",
     *     tags={"Profile"},
     *     summary="Password update your profile",
     *     description="Password update your profile",
     *     @OA\Response(
     *          response=202,
     *          description="successful operation"
     *     ),
     *     @OA\Response(response=400, description="Bad request"),
     * )
     */
    public function updatePassword(Request $request)
    {
        $user = auth('api')->user()->update(['password' => bcrypt($request->new_password)]);
        return $this->sendResponse($user, 'Password update successfully.', Response::HTTP_ACCEPTED);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     *
     * @OA\Put(
     *     path="/users/loginUpdate",
     *     operationId="loginUpdateProfile",
     *     tags={"Profile"},
     *     summary="Login update your profile",
     *     description="Login update your profile",
     *     @OA\Response(
     *          response=202,
     *          description="successful operation"
     *     ),
     *     @OA\Response(response=400, description="Bad request"),
     * )
     */
    public function updateLogin(Request $request)
    {
        $user = auth('api')->user()->update(['name' => $request->new_name]);
        return $this->sendResponse($user, 'Login update successfully.', Response::HTTP_ACCEPTED);
    }

}
