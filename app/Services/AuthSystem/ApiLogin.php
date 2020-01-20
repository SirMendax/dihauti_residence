<?php


namespace App\Services\AuthSystem;


use App\Http\Resources\RoleResource;
use App\Services\Contracts\ApiLoginInterface;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Str;

class ApiLogin implements ApiLoginInterface
{
    public function authorize(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!Auth::guard('web')->attempt($credentials)) {
            return false;
        }

        $user = Auth::guard('web')->user();

        $token = $user->createToken('DihautiResidence');

        $token->token->expires_at = $request->remember_me ?
            Carbon::now()->addMonth() :
            Carbon::now()->addDay();

        $token->token->save();

        return [
            'token_type' => 'Bearer',
            'token' => $token->accessToken,
            'expires_at' => Carbon::parse($token->token->expires_at)->toDateTimeString(),
            'id'=> $user->id,
            'role'=> json_encode(RoleResource::collection($user->roles()->get()))
        ];
    }


}
