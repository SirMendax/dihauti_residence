<?php


namespace App\Services\Contracts;


use Illuminate\Http\Request;

interface VerificationUserInterface
{
    /**
     * @param Request $request
     * @return mixed
     */
    public static function verify(Request $request);
}
