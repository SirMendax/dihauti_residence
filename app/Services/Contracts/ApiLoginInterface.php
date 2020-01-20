<?php


namespace App\Services\Contracts;


use App\Http\Requests\LoginRequest;

interface ApiLoginInterface
{
    public function authorize(LoginRequest $request);
}
