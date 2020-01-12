<?php

namespace App\Http\Controllers\Api\Auth;


use App\Http\Controllers\Api\BaseControllers\ApiBaseController;
use App\Services\Registration\RoleDistributor;
use App\Services\Registration\VerificationUser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class VerificationController extends ApiBaseController
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request){

        $result = VerificationUser::verify($request);
        if(false !== $result){
            RoleDistributor::setRole($request->user());
            return $this->sendResponse(TRUE, 'You have received comrade status', Response::HTTP_ACCEPTED);
        } else{
            return $this->sendError('Failed', 'You failed verification your profile', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
