<?php

namespace App\Http\Controllers\Api\Auth;

use ApiLogin;
use App\Http\Controllers\Api\BaseControllers\ApiBaseController;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LoginController extends ApiBaseController
{
    /**
     * Handle the incoming request.
     *
     * @OA\Post(
     *    path="/login",
     *    operationId="authorize",
     *    tags={"AuthSystem"},
     *    summary="Auth in api",
     *    @OA\RequestBody(
     *         description="name new category",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/LoginRequest")
     *    ),
     *    @OA\Response(
     *          response=200,
     *          description="Login successfull"
     *    ),
     *    @OA\Response(response=401, description="You cannot sign with those credentials"),
     * )
     *
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function __invoke(LoginRequest $request)
    {
        $result = ApiLogin::authorize($request);

        if ($result === false) {
            return $this->sendError('Unauthorised', 'You cannot sign with those credentials', 401);
        } else {
            return $this->sendResponse($result, 'Login successfully', 200);
        }
    }
}
