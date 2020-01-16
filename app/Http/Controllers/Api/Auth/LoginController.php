<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\BaseControllers\ApiBaseController;
use App\Http\Resources\RoleResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Models\User;

class LoginController extends ApiBaseController
{
    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!Auth::guard('web')->attempt($credentials)) {
            return $this->sendError('Unauthorised', 'You cannot sign with those credentials', 401);
        }
        $user = User::where('email', $request->email)->first();

        $token = $user->createToken(config('MyApp'));

        $token->token->expires_at = $request->remember_me ?
            Carbon::now()->addMonth() :
            Carbon::now()->addDay();

        $token->token->save();

        return response()->json([
            'token_type' => 'Bearer',
            'token' => $token->accessToken,
            'expires_at' => Carbon::parse($token->token->expires_at)->toDateTimeString(),
            'user'=> Str::slug($user->name),
            'id'=> $user->id,
            'role'=> $user->roles()->count() > 0 ? json_encode(RoleResource::collection($user->roles()->get())) : 0
        ], 200);
    }
}
