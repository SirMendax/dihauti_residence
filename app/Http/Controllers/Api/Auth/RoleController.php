<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\BaseControllers\ApiBaseController;
use App\Http\Resources\RoleResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RoleController extends ApiBaseController
{
    /**
     * @param User $user
     * @return JsonResponse
     */
    public function get(User $user)
    {
        $roles = RoleResource::collection($user->roles()->get());
        return $this->sendResponse($roles, 'Role retrieved successfully');
    }

    /**
     * @param User $user
     * @param Request $request
     * @return JsonResponse
     */
    public function store(User $user, Request $request)
    {
        $user->roles()->attach($request->role_id);
        return $this->sendResponse(TRUE, 'Role retrieved successfully', Response::HTTP_OK);
    }

    /**
     * @param User $user
     * @param Request $request
     * @return JsonResponse
     */
    public function update(User $user, Request $request)
    {
        $user->roles()->updateExistingPivot($request->currentRole, ['role_id' => $request->newRole]);
        return $this->sendResponse(TRUE, 'Role updated this user successful', Response::HTTP_OK);
    }

    /**
     * @param User $user
     * @param Request $request
     * @return JsonResponse
     */
    public function delete(User $user, Request $request)
    {
        $user->roles()->detach($request->role_id);
        return $this->sendResponse(TRUE, 'Role deleted this user successful', Response::HTTP_OK);
    }

}
