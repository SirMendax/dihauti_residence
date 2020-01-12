<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseControllers\ApiBaseController;
use App\Http\Resources\DialogResource;
use App\Http\Resources\MessageResource;
use App\Http\Resources\UserResource;
use App\Models\Dialog;
use App\Models\User;
use App\Services\Messenger\Messenger;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MessageController extends ApiBaseController
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * @return JsonResponse
     *
     * @OA\Get(
     *     path="/contacts",
     *     operationId="getContactList",
     *     tags={"Messenger"},
     *     summary="Get contact list",
     *     description="Returns contact list",
     *     @OA\Response(
     *          response=200,
     *          description="successful operation"
     *     ),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */

    public function getAllUsers()
    {
        $users = User::where('id', '!=', auth('api')->user()->id)->get();
        return $this->sendResponse(UserResource::collection($users), 'All users uploaded', Response::HTTP_OK);
    }

    /**
     * @return JsonResponse
     *
     * @OA\Get(
     *     path="/messages",
     *     operationId="getCurrentDialog",
     *     tags={"Messenger"},
     *     summary="Get all current dialog",
     *     description="Returns all current dialog",
     *     @OA\Response(
     *          response=200,
     *          description="successful operation"
     *     ),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */

    public function getAllDialog()
    {
        $dialogs = auth('api')->user()->dialogs()->get();

        return $this->sendResponse(DialogResource::collection($dialogs), 'All dialogs uploaded', Response::HTTP_OK);
    }

    /**
     * @param Dialog $dialog
     * @return JsonResponse
     * @throws AuthorizationException
     *
     * @OA\Get(
     *     path="/messages/{dialog}",
     *     operationId="getMessagesInDialog",
     *     tags={"Messenger"},
     *     summary="Get messages in dialog",
     *     description="Get messages in dialog",
     *     @OA\Parameter(
     *          name="slug",
     *          description="Dialog slug",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *     @OA\Response(
     *          response=200,
     *          description="successful operation"
     *     ),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getMessage(Dialog $dialog)
    {
        $this->authorize('view', $dialog);
        $messages = MessageResource::collection($dialog->messages()->get());
        return $this->sendResponse($messages, 'Messages from selected user uploaded', Response::HTTP_OK);
    }

    /**
     * @param Dialog $dialog
     * @return JsonResponse
     * @throws AuthorizationException
     *
     * @OA\Get(
     *     path="/dialog/{dialog}",
     *     operationId="getDialog",
     *     tags={"Messenger"},
     *     summary="Get dialog",
     *     description="Get dialog",
     *     @OA\Parameter(
     *          name="slug",
     *          description="Dialog slug",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *     @OA\Response(
     *          response=200,
     *          description="successful operation"
     *     ),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getDialog(Dialog $dialog)
    {
        $this->authorize('view', $dialog);
        return $this->sendResponse(new DialogResource($dialog), 'Messages from selected user uploaded', Response::HTTP_OK);
    }

    /**
     * @param Dialog $dialog
     * @param Request $request
     * @return JsonResponse
     * @throws AuthorizationException
     *
     * @OA\Post(
     *     path="/messages/{dialog}/send",
     *     operationId="sendNewMessage",
     *     tags={"Messenger"},
     *     summary="Create message in database",
     *     security={
     *          {"app_id": {}},
     *     },
     *     @OA\Response(
     *          response=201,
     *          description="successful operation"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=500, description="Internal server error"),
     * )
     */
    public function sendMessage(Dialog $dialog, Request $request)
    {
        $this->authorize('view', $dialog);
        $result = Messenger::sendMessage($dialog, $request);
        switch ($result['code']){
            case 0:
                return $this->sendError($result['data'], $result['message'], $result['status']);
            case 1:
                return $this->sendResponse($result['data'], $result['message'], $result['status']);
            default:
                return $this->sendError(FALSE, 'Server error', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     *
     * @OA\Post(
     *     path="/startDialog",
     *     operationId="startDialog",
     *     tags={"Messenger"},
     *     summary="Create gialog in database",
     *     security={
     *          {"app_id": {}},
     *     },
     *     @OA\Response(
     *          response=201,
     *          description="successful operation"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=500, description="Internal server error"),
     * )
     */
    public function startDialog(Request $request)
    {
        $result = Messenger::startDialog($request);
        switch ($result['code']){
            case 0:
                return $this->sendError($result['data'], $result['message'], $result['status']);
            case 1:
                return $this->sendResponse($result['data'], $result['message'], $result['status']);
            default:
                return $this->sendError(FALSE, 'Server error', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

}
