<?php


namespace App\Facades;


use App\Services\Contracts\ApiLoginInterface;
use Illuminate\Support\Facades\Facade;

class ApiLoginFacade extends Facade
{
    protected static function getFacadeAccessor() {
        return ApiLoginInterface::class;
    }
}
