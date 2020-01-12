<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\BaseControllers\ApiBaseController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LogoutController extends ApiBaseController
{
    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request)
    {
        $request->user()->token()->revoke();

        return $this->sendResponse(TRUE, 'You are successfully logged out', Response::HTTP_OK);
    }
}
