<?php


namespace App\Services\Contracts;


use Illuminate\Http\Request;

interface ApiLoginInterface
{
    public function authorize(Request $request);
}
