<?php


namespace App\Services\Messenger;

use App\Events\MessageEvent;
use App\Http\Resources\MessageResource;
use App\Models\Dialog;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class Messenger
{
    /**
     * @param $dialog
     * @param Request $request
     * @return array
     */
    public static function sendMessage($dialog, Request $request)
    {
        if(auth('api')->user()->id === $request->recipient_id){
            return [
              'code' => 0,
              'data' => FALSE,
              'message' => 'Dialog not started',
              'status' => Response::HTTP_BAD_REQUEST
            ];
        }

        if(!$dialog){
            return [
                'code' => 0,
                'data' => FALSE,
                'message' => 'You message has not been sent',
                'status' => Response::HTTP_BAD_REQUEST
            ];
        }

        $message = auth('api')->user()->send()->create([
            'text'         => $request->text,
            'recipient_id' => $request->recipient_id,
            'dialog_id'    => $dialog->id
        ]);

        $message = new MessageResource(Message::where([
            ['recipient_id', $request->recipient_id],
            ['sender_id', auth('api')->user()->id]
        ])->latest()->first());

        MessageEvent::dispatch([
            'msg' => json_encode($message),
            'dialog_id' => $dialog->id
        ]);

        return [
            'code' => 1,
            'data' => TRUE,
            'message' => 'You message has been sent',
            'status' => Response::HTTP_CREATED
        ];
    }

    /**
     * @param Request $request
     * @return array
     */
    public static function startDialog(Request $request)
    {
        if(auth('api')->user()->id === $request->recipient_id){
            return [
                'code' => 0,
                'data' => FALSE,
                'message' => 'Dialog not started',
                'status' => Response::HTTP_BAD_REQUEST
            ];
        }

        $recipient = User::find($request->recipient_id);
        $titleDialog = auth()->user()->slug .'-'. $recipient->slug;

        if(Dialog::where('title', $titleDialog)->get()->count()){
            return [
                'code' => 1,
                'data' => ['id' => Dialog::where('title', $titleDialog)->first()->id],
                'message' => 'Dialog already started',
                'status' => Response::HTTP_CREATED
            ];
        }

        $dialog = new Dialog();
        $dialog->create(['title' => $titleDialog]);

        $currentDialog = Dialog::where('title', $titleDialog)->first();

        auth()->user()->dialogs()->attach(['dialog_id' => $currentDialog->id]);

        $recipient->dialogs()->attach(['dialog_id' => $currentDialog->id]);

        return [
            'code' => 1,
            'data' => ['id' => $currentDialog->id],
            'message' => 'Dialog started successfully',
            'status' => Response::HTTP_CREATED
        ];
    }
}
