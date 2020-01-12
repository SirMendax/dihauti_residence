<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\Auth\Classes\VerificationEmailUser;
use App\Http\Controllers\Api\BaseControllers\ApiBaseController;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class ResetPasswordController extends ApiBaseController
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function resetPassword(Request $request)
    {
        $user = User::where(['email' => $request->email, 'name' => $request->name])->first();
        if($user){
            $password = Str::random(10);
            $user->update(['password' => bcrypt($password)]);
            VerificationEmailUser::pushMessage($user->email, $password);
            return $this->sendResponse(new UserResource($user), 'Password reset successfully.', Response::HTTP_ACCEPTED);
        }else{
            return $this->sendResponse(new UserResource($user), 'Password reset failed, user does not exist', Response::HTTP_BAD_REQUEST);
        }
    }
}
