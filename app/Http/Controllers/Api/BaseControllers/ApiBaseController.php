<?php


namespace App\Http\Controllers\Api\BaseControllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="API documentation for Dihauti Residence",
 *      description="description",
 *      @OA\Contact(
 *          email="dev.arven@gmail.com"
 *      )
 * )
 * @OA\Server(
 *     description="API server",
 *     url="https://api.dihauti.ru/api"
 * )
 * @OA\SecurityScheme(
 *     type="apiKey",
 *     in="header",
 *     name="Authorization",
 *     scheme="https",
 *     securityScheme="passport",
 *     @OA\Flow(
 *         flow="password",
 *         authorizationUrl="/login",
 *         refreshUrl="/logout",
 *         scopes={}
 *     )
 *  )
 **/

abstract class ApiBaseController extends Controller
{
    /**
     * success response method.
     *
     * @param $result
     * @param $message
     * @param int $status
     * @return JsonResponse
     */
    public function sendResponse($result, $message, $status = 200)
    {
        $response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];
        return response()->json($response, $status);
    }

    /**
     * return error response.
     *
     * @param $error
     * @param array $errorMessages
     * @param int $status
     * @return JsonResponse
     */
    public function sendError($error, $errorMessages = [], $status = 404)
    {
        $response = [
            'success' => false,
            'error' => $error,
        ];
        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }
        return response()->json($response, $status);

    }
}
