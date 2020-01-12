<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\BaseControllers\ApiBaseController;
use App\Http\Requests\Api\Auth\RegisterFormRequest;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use App\Services\Registration\Helper;
use Log;

class RegisterController extends ApiBaseController
{
    /**
     * Handle the incoming request.
     *
     * @param RegisterFormRequest $request
     * @return JsonResponse
     * @throws Exception
     */
    public function __invoke(RegisterFormRequest $request)
    {
        $user = Helper::createNewUser($request);

        $profile = Helper::createProfile($user);

        if($profile['status'] === false){
            Log::info($profile['message']);
            return $this->sendError("Query exception", 'Registration is failed', Response::HTTP_INTERNAL_SERVER_ERROR);
        };

        try{
            Helper::sendMessageForNewUser('email', $user->email, $user['verification_code'], $user['name']);
            Helper::sendNotifyForAdmin($user);
            return $this->sendResponse($user, 'You were successfully registered.', Response::HTTP_CREATED);

        }catch (Exception $e){
            Log::info($e->getMessage());
            return $this->sendResponse($user, 'You were successfully registered.', Response::HTTP_CREATED);

        }
    }

}
