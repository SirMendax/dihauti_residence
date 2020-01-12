<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Api\BaseControllers\ApiBaseController;

class IndexController extends ApiBaseController {
    public function index()
    {
        return $this->sendResponse(NULL, 'Hello, this API for SPA forum Dihauti Residence', 200);
    }
}
