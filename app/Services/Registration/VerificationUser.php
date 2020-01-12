<?php


namespace App\Services\Registration;


use App\Models\User;
use App\Services\Contracts\VerificationUserInterface;
use Illuminate\Http\Request;

class VerificationUser implements VerificationUserInterface
{
    /**
     * @param Request $request
     * @return bool
     */
    public static function verify(Request $request)
    {
        $user_id = $request->user()->id;
        $verification_code = $request->verification_code;

        $user = User::find($user_id);

        if($user->verification_code === $verification_code){
            $user->update(['verified' =>  true]);
            return true;
        }else{
            return false;
        }
    }
}
