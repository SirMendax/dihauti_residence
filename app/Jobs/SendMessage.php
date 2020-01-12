<?php

namespace App\Jobs;

use App\Services\Sender\SenderBuilder;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    protected array $message;
    protected string $type;
    protected string $recipient;

    /**
     * SendMessage constructor.
     * @param string $type
     * @param string $recipient
     * @param array $message
     */

    public function __construct(string $type, string $recipient, array $message)
    {
        $this->message = $message;
        $this->type = $type;
        $this->recipient = $recipient;
    }

    /**
     * @throws Exception
     */
    public function handle()
    {
        $notify = SenderBuilder::createSender($this->type, $this->recipient, $this->message);
        $notify->sendNotification();
    }

    /**
     * @param Exception $exception
     */
    public function failed(Exception $exception)
    {
        info($exception->getMessage());
    }
}
