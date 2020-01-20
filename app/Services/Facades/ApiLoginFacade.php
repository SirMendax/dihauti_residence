<?php


namespace App\Services\Facades;
use Illuminate\Support\Facades\Facade;

class ApiLoginFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'apilogin';
    }
}
